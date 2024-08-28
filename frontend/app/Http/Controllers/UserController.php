<?php
    
namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\User;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
    
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $data = User::where('id', '!=', $request->user()->id)->orderBy('id','desc')->paginate(10);
        $data = User::where('id', '!=', $request->user()->id);
        $department = Department::orderBy('name', 'asc')->get();
        $request_department= $request->department;
        if($request_department != null && $request_department != ""){
            $data->where('department_id',$request_department);
        }
        if(isset($request->s) && !empty($request->s)){
            $data->where(function ($query) use ($request) {
                $query->orWhere(DB::raw('LOWER(`name`)'), "like", "%" . strtolower($request->s) . "%");
                $query->orWhere('position', "like", "%" . $request->s . "%");
                $query->orWhere(DB::raw('LOWER(`email`)'), "like", "%" . strtolower($request->s) . "%");
            });
        }
        $data = $data->orderBy('id','desc')->paginate(10);
        return view('pages.users.index',compact('data','department','request_department'))->with('i', ($request->input('page', 1) - 1) * 5);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::orderBy('name', 'asc')->get();
        $department = Department::orderBy('name', 'asc')->get();
        return response()->json(['status'=>'success','data'=>$roles,'department'=>$department]);
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'confirm-password' => 'required',
            'roles' => 'required'
        ]);

        if($validator->fails()) {
            return response()->json(['status'=>'error','msg'=>$validator->errors()]);
        }

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
    
        $user = User::create($input);
        $user->assignRole($request->input('roles'));
    
        return response()->json(['status'=>'success','msg'=> 'User created successfully']);
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        $role=$user->getRoleNames();
        return response()->json(['status'=>'success', 'user'=> $user, 'role'=> $role]);
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::orderBy('name', 'asc')->get();
        $role=$user->roles->pluck("id")->first();
        $departments = Department::orderBy('name', 'asc')->get();
        $department = $user->department_id;
        return response()->json(['status'=>'success', 'roles'=>$roles, 'user'=>$user, 'role'=>$role,'departments'=>$departments,'department'=>$department]);
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'same:confirm-password',
            'roles' => 'required'
        ]);
    
        if($validator->fails()) {
            return response()->json(['status'=>'error','msg'=>$validator->errors()]);
        }

        $input = $request->all();
        if(!empty($input['password'])){ 
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = Arr::except($input,array('password'));    
        }
    
        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id',$id)->delete();
    
        $user->assignRole($request->input('roles'));
    
        return response()->json(['status'=>'success','msg'=> 'User updated successfully']);
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return response()->json(['status'=>'success','msg'=> 'User deleted successfully']);
    }
}