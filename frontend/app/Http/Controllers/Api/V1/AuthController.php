<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Traits\ApiResponse;
use App\Models\EmployeeInOutDetail;
use App\Models\UserDeviceInfo;
use App\Models\UserInfo;
use Response;
use DB;

class AuthController extends Controller
{
    use ApiResponse;

    public function register(Request $request)
    {
        // Validate request data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|min:6',
        ]);

        // Return errors if validation error occur.
        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json([
                'error' => $errors
            ], 400);
        }

        // Check if validation pass then create user and auth token. Return the auth token
        if ($validator->passes()) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
            ]);
        }
    }

    public function login(Request $request)
    {   
        if (!Auth::attempt($request->only('email', 'password'))) {
            return $this->errorResponse('from task', 401);
        }
        $user = User::where('email', $request['email'])->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;
       
        $user_details= User::where('id', $request->user()->id)->first();
        $data = [
            'access_token'  => $token,
            'token_type'    => 'Bearer',
            'user_details'  => $user_details,
        ];
        return $this->successResponse($data, "Login Successfully");
    }

    public function usertaskLogin(Request $request)
    {   
        // if (!Auth::attempt($request->only('email'))) {
        //     return $this->errorResponse('error from task trackers invalid data !!', 401);
        // }
        $user = User::where('email', $request['email'])->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;
       
        $user_details= User::where('id', $user->id)->first();
        $data = [
            'access_token'  => $token,
            'token_type'    => 'Bearer',
            'user_details'  => $user_details,
        ];
        return $this->successResponse($data, "Login Successfully");
    }
    public function me(Request $request)
    {
        if (!empty($request->user())) {
            
            $employee = employee::where('user_id', $request->user()->id)->first();
            $last_satust = EmployeeInOutDetail::where('employee_id', '=', $request->user()->id)->where('punch_date', date('Y-m-d'))->orderBy('id', 'DESC')->first();
            if (isset($last_satust) && !empty($last_satust)) {
            $check_time = $employee->punch_type == 1 ? (date('g:i a', strtotime($last_satust->punch_out_time))) : (date('g:i a', strtotime($last_satust->punch_in_time)));
            }
            $employee_inout_object = new EmployeeInOutDetail();
            $data = $request->user();
            $data['punch_type'] = $employee['punch_type'];
            $data['punch_time'] = isset($check_time) ? $check_time : "00:00";
            $data['punch_type_name'] = !empty($employee['punch_type']) && $employee['punch_type'] == 2 ? 'In' : 'Out';
            $data['designation_id'] = $employee['designation_id'];
            $data['designation_name'] = $employee->designation->name;
            $data['picture'] =  asset('Employee/' . $employee->picture);
            $data['total_time'] = $employee_inout_object->total_time_of_employee($employee->id);
            $data['workstacker_access_token'] =(isset($request->user()->access_token) && !empty($request->user()->access_token)) ? $request->user()->access_token : '';
            $data['workstacker_api_base_url'] = "https://workstacker.co/api/";
            $data['week'] = $employee_inout_object->weekly_attendance_graph($employee->id);

            return $this->successResponse($data, "User Details");
        } else {
            return $this->errorResponse('Invalid details', 401);
        }
    }
   
    public function logout(Request $request)
    {
        auth('sanctum')->user()->tokens()->delete();
        return response()->json(['status'=>true,'message'=>'Logout Successful.'],200);
    }
    
}
