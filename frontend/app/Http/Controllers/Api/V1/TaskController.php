<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Traits\ApiResponse;
use Carbon\Carbon;
use DateInterval;
use DatePeriod;
use DateTime;
use DB;
use PDF;
use Mail;
use Illuminate\Support\Carbon as SupportCarbon;
use Response;
use App\Models\Task;
use App\Models\Tag;
use App\Models\taskTimeHistory;
use App\Models\TaskUser;
use App\Models\Comment;

class TaskController extends Controller
{
    use ApiResponse;   



    public function taskDetail(Request $request)
    {
        $search = isset($request->search) ? $request->search : '';
        $task_status = isset($request->task_status) ? $request->task_status : '';
        $task_priority = isset($request->task_priority) ? $request->task_priority : '';

        $task = Task::join('users', 'users.id', 'tasks.user_select')
                    ->join('tags', 'tags.id', 'tasks.tage')
                    ->join('projects', 'projects.id', 'tasks.project_id')
                    ->leftjoin('users_task', 'users_task.task_id', 'tasks.id');

        $task->where(function ($query) {
                        $query->orWhere('task_user_id',Auth::user()->id);
                        $query->orWhere('user_select',Auth::user()->id);
                    });


        // search task
        if(!empty($search) && $search != ''){
            $task->where(function ($query) use ($search) {
                $query->orWhere(DB::raw('LOWER(task_name)'), "like", "%" . strtolower($search) . "%");
            });
        }
    
        // task status
        if(!empty($task_status) && $task_status != ''){
            $task = $task->where('tage',$task_status);
        } 

        if($task_priority != ''){
            $task->where('tasks.priority', $task_priority);
        }

        $task->select(
                'tasks.id',
                'tasks.project_id',
                'tasks.task_name',
                'tasks.detail',
                'tasks.start_date',
                'tasks.end_date',
                'tasks.deadline_date',
                'tasks.delivery_date',
                'tasks.testing_date',
                'tasks.user_select',
                'tasks.tage',
                'tasks.type',
                'tasks.created_by',
                'tasks.deadline_date_reason',
                'users.name as user_name',
                'tags.title as tag_name',
                'tags.color_code',
                'tasks.priority',
                'tasks.task_type',
                'tasks.created_at',
                'tasks.updated_at',
                'tasks.deleted_at',
                'projects.project_name',
                'projects.logo as project_logo',
                DB::raw("(SELECT name FROM users WHERE users.id = tasks.created_by) as task_creater")
            )
            ->orderByRaw('tasks.delivery_date >= CURDATE() DESC, tasks.delivery_date ASC');

        // get perticular task deatil
        if(isset($request->task_id) && !empty($request->task_id) && $request->task_id != '')
        {
            $task->where('tasks.id', $request->task_id);
            $tasks = $task->first();

            // $tasks->priority = getPriority($tasks->priority);
            // $tasks->task_type = $tasks->task_type == 0 ? "Public" : "Private";
            $tasks->project_logo = !empty($tasks->project_logo) ? asset('project_images/' . $tasks->project_logo) : '';

            // working hours
            $taskTime = taskTimeHistory::where('task_id', $request->task_id)->get();
            $sec_diff = 0;
                foreach ($taskTime as $timeDiff)
                {
                    $formattedCreatedDate = date_create($timeDiff->start_time);
                    $order_date = Carbon::parse($formattedCreatedDate);

                    $endTime = date_create($timeDiff->end_time);
                    $current_date = Carbon::parse($endTime);

                    $sec_diff += $current_date->diffInSeconds($order_date);
                }

                $totalHours = floor($sec_diff / 3600);
                $sec_diff %= 3600;
                $totalMinutes = floor($sec_diff / 60);
                $sec_diff %= 60;
                $total_time = sprintf('%02d:%02d:%02d', $totalHours, $totalMinutes,$sec_diff);   

            $tasks['working_hours'] = $total_time;

            // secondary users
            $secondary_users = TaskUser::join('users', 'users.id', 'users_task.task_user_id')
                                    ->join('tasks', 'tasks.id', 'users_task.task_id')
                                    ->where('users_task.task_id', $request->task_id)
                                    ->where('users_task.task_user_id', '!=', 0)
                                    ->select('users.name','users.email', 'users.id', 'users_task.task_user_id')
                                    ->get();

            $tasks['total_secondary_users'] = count($secondary_users);
            $tasks['secondary_users'] = $secondary_users;

            $task_date_arr = array();
            $task_date_arr[] =[
                    "label" => "Start Date",
                    "date" => $tasks->start_date,
                ];
            $task_date_arr[] =[
                    "label" => "End Date",
                    "date" => $tasks->end_date,
                ];
            $task_date_arr[] =[
                "label" => "Testing Date",
                "date" => $tasks->testing_date,
            ];
            $task_date_arr[] =[
                    "label" => "Deadline Date",
                    "date" => $tasks->deadline_date,
                ];
            $task_date_arr[] =[
                    "label" => "Delivery Date",
                    "date" => $tasks->delivery_date,
                ];
            $tasks['task_dates'] = $task_date_arr;

        }else{
            // get all task list

            $tasks = $task->orderBy('tasks.id', 'desc')->groupby('tasks.id')->get();

            foreach($tasks as $key => $row)
            {
                // $row->priority = getPriority($row->priority);
                // $row->task_type = $row->task_type == 0 ? "Public" : "Private";
                $row->project_logo = !empty($row->project_logo) ? asset('project_images/' . $row->project_logo) : '';

                // task start or stop
                $timeHistoryData = taskTimeHistory::where('task_id',$row->id)->orderBy('id', 'DESC')->first();
                if(isset($timeHistoryData->start_time) && !empty($timeHistoryData->start_time) && empty($timeHistoryData->end_time))
                {
                    $row['task_start_stop'] = "0";
                }else{
                    $row['task_start_stop'] = "1";
                }

                $secondary_users = TaskUser::join('users', 'users.id', 'users_task.task_user_id')
                                ->join('tasks', 'tasks.id', 'users_task.task_id')
                                ->where('users_task.task_id', $row->id)
                                ->where('users_task.task_user_id', '!=', 0)
                                ->select('users.name', 'users.email', 'users.id', 'users_task.task_user_id')
                                ->get();
                                
                $row['total_secondary_users'] = count($secondary_users);
                $row['secondary_users'] = $secondary_users;
            }
        }
        $result['task_details'] = $tasks;
        return $this->successResponse($result, "Task Details");
    }

    // public function taskDetail(Request $request)
    // {
    //     $id = User::where('id', $request->user()->id)->first();        
    //     $user_id = isset($request->user_id) && !empty($request->user_id) ? $request->user_id : $id['id'];
    //     $taskid= $request->task_id;

    //     if (isset($user_id) && !empty($user_id)) { 
    //         $data = new Task;    
    //         $data = $data->where('user_select', $user_id);

    //         if($request->task_id){
    //            $data = $data->where('id',$taskid);
    //         }
    //         if($request->task_status){
    //             $data = $data->where('tage',$request->task_status);
    //         }        
    //         $data = $data->where('user_select', $user_id)->orderBy('id', 'DESC')->get();
    //         foreach($data as $task_details){
    //             $tag = Tag::find($task_details->tage);          

    //             $task_details['tag_name'] = $tag->title;

    //             // task start or stop
    //             $timeHistoryData = taskTimeHistory::where('task_id',$task_details->id)->orderBy('id', 'DESC')->first();
    //             if(isset($timeHistoryData->start_time) && !empty($timeHistoryData->start_time) && empty($timeHistoryData->end_time))
    //             {
    //                 $task_details['task_start_stop'] = "0";
    //             }else{
    //                 $task_details['task_start_stop'] = "1";
    //             }
    //         }
    //         $result['task_details'] = $data;

    //         return $this->successResponse($result, "Task Details");
    //     } else {
    //         return $this->successResponse('Message','Data Not Found !!!');
    //     }
    // }

    public function taskStartStop(Request $request)
    {
        if($request->task_id){
            $timeHistoryData = taskTimeHistory::where('task_id',$request->task_id)->orderBy('id', 'DESC')->first();
            if(isset($timeHistoryData->start_time) && !empty($timeHistoryData->start_time) && empty($timeHistoryData->end_time))
            {
                $taskTimeHistoryObj = taskTimeHistory::where('id',$timeHistoryData->id)->first();
                if($taskTimeHistoryObj){
                    $taskTimeHistoryObj->end_time = date('Y-m-d H:i:s');
                    $taskTimeHistoryObj->update();
                    return response()->json(['status'=>"success",'message'=>"Task stop successfully"], 200);
                }
            }else{
                $taskTimeHistoryObj = new taskTimeHistory();
                $taskTimeHistoryObj->task_id = $request->task_id;
                $taskTimeHistoryObj->start_time = date('Y-m-d H:i:s');
                $taskTimeHistoryObj->save();
                return response()->json(['status'=>"success",'message'=>"Task start successfully"], 200);
            }
        }else{
            return response()->json(['status'=>"error",'message'=>"Something went wrong"], 400);
        }
    }

    public function getTaskComments(Request $request)
    {
        if(isset($request->task_id) && !empty($request->task_id) && $request->task_id != '')
        {
            $comments = Comment::join('users', 'users.id', 'task_comments.user_id')
                            ->where('task_id', $request->task_id)
                            ->select('task_comments.*','users.email')->get();
            return response()->json(['status'=>"success",'data'=>$comments], 200);
        }
        return response()->json(['status'=>"error",'message'=>"Something went wrong"], 400);
    }

    public function submitTaskComments(Request $request)
    {
        if(isset($request->task_id) && !empty($request->task_id) && $request->task_id != '' )
        {
            $validator = Validator::make($request->all(),[
                'comments' => 'required',
            ]);
            if($validator->passes())
            {
                date_default_timezone_set("Asia/Kolkata");
                $request->merge([
                    'comments' => nl2br($request->comments), 
                    'user_id' => Auth::user()->id,
                    'task_id' => $request->task_id,
                    'punch_time' => date('Y-m-d H:i:s')
                ]);
                $data = Comment::create($request->all());

                return response()->json(['status'=>'success','message'=>'your comment is send successfully','data'=>$data->comments,
                                            'time'=>date('m/d/Y h:i A', strtotime($data->punch_time)) ], 200);
            }else{
                return response()->json(['status'=>'error', 'message'=>$validator->errors()->first()], 400);
            }
        }
        return response()->json(['status'=>"error",'message'=>"Something went wrong"], 400);
    }
}
