<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\UserSetting;
use App\Models\BookingCriteria;
use App\Models\DaySlot;
use DB;
use Auth;

class UserSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request){

        $user = Auth::user();
        // $userSettingData = UserSetting::get();
        $DaySlotData = array();
        if(!empty($userSettingData->slot)){
            $DaySlotData= json_decode($userSettingData->slot, true);
        }
        $userSettingData = UserSetting::paginate(10);
        return view('pages.users.botprofile',compact('user', 'userSettingData','DaySlotData'));
    }

    public function user_settings($userid){
        $userSettingData = UserSetting::where('id', $userid)->first();
        $DaySlotData = array();
        if(!empty($userSettingData->slot)){
            $DaySlotData= json_decode($userSettingData->slot, true);
        }
        return view('pages.users.setting',compact('userid','userSettingData','DaySlotData'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.users.add_bot_setting');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $slotArr = array_values($request->slot);  
        $BookingCriteriaIdArr = $request->BookingCriteriaId;
        $status = $request->has('status') ? 1 : 0;
        $req = $request->all();
        
        $validationRequest = [
            'full_name' => $request->full_name,
            'site_id' => $request->site_id
        ];

        $validator = Validator::make($validationRequest, [
            'full_name' => 'required',
            'site_id' => 'required',
        ],[]);
 
        if($validator->fails()) {
            return response()->json(['status'=>'error','msg'=>$validator->errors()]);
        }

        $site_url = ($request->site_id == 0) ? "https://www.fortworthgolf.org/golf/tee-times" : (($request->site_id == 1) ? "https://www.keetonpark.com" : '');
        $location = ($request->site_id == 0) ? "TX 76114" : (($request->site_id == 1) ? "TX 76114" : '');
        $category = ($request->site_id == 0) ? "Rockwood Park Golf Course" : (($request->site_id == 1) ? "Keet on Park" : '');
 
        $UserSettingObj = UserSetting::updateOrCreate([    
                        'id' => $request->userSettingId,                        
                    ],[
                        'user_id' => $user->id,
                        'user_name' => $req['full_name'],
                        // 'email' => $req['email'],
                        'site_url' => $site_url,
                        'slot' => json_encode($slotArr),
                        'location' =>  $location,
                        'stop_booking' =>  $req['stop_booking'],
                        'status' =>  $status,
                        'site_location' =>  $req['site_id'],
                        'category' =>  $category
                    ]);

        return response()->json(['status'=>'success','msg'=>'Data submitted successfully.']);
    }

    public function saveDetails(Request $request)
    {
        $req = $request->all();
        $user_setting_id = $req['sid'];

        $user_setting = UserSetting::find($user_setting_id);
        $user_setting->email = $req['email'];
        $user_setting->password = $req['password'];
        $user_setting->save();
        return response()->json(['status'=>'success','msg'=>'Credential has been changed successfully.']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function globalUserSetting(Request $request)
    {
        $pageTitle = "Global Settings";
        $check = null;
        $settings = UserSetting::find(2);
        $check = $settings->global_setting == 1 ? 1 : null;
        return view('pages.users.global',compact('pageTitle', 'check'));
    }

    public function storeglobalUserSetting(Request $request)
    {
        $globalSetting = $request->has('global-setting') ? $request->post('global-setting') : null;
        $affected = DB::table('user_setting')->update(array('global_setting' => $globalSetting));
        // global_setting
        return redirect()->route('global-user-setting')->with('success', 'Setting Updated');
    }

    public function deleteCriterea(Request $request)
    {
        if($request->c_id){
            BookingCriteria::where('id', $request->c_id)->delete();
            return response()->json(['status' => 'success' , 'msg' => 'Removed successfully']);
        }
        return response()->json(['status' => 'error', 'msg' => 'Something went wrong.']);
    }

    public function deleteDaySlot(Request $request)
    {
        if($request->slot_id){
            DaySlot::where('id', $request->slot_id)->delete();
            return response()->json(['status' => 'success', 'msg' => 'Removed successfully']);
        }
        return response()->json(['status' => 'error', 'msg' => 'Something went wrong.']);
    }
}
