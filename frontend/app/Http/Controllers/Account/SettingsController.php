<?php

namespace App\Http\Controllers\Account;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Account\SettingsEmailRequest;
use App\Http\Requests\Account\SettingsInfoRequest;
use App\Http\Requests\Account\SettingsPasswordRequest;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Http\Request;
use App\Models\UserInfo;
use App\Models\User;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $info = User::where('id', Auth::user()->id)->first();

        // get the default inner page
        return view('pages.account.settings.settings', compact('info'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $user
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(SettingsInfoRequest $request)
    {
        // save user name
        $validator = Validator::make($request->all(),[
            'full_name' => 'required|string|max:255',
            'email'  => 'required|email|unique:users,email,'.auth()->user()->id.',id',            
        ]);

        if($validator->passes()){
            $userObj = User::find(auth()->user()->id);
            $userObj->name = $request->full_name;
            $userObj->email = $request->email;
            $userObj->update();
            return response()->json(['status' =>'success', 'msg' => 'Profile updated successfully.']);
        }else{
            return response()->json(['status' =>'error' , 'msg' => $validator->errors()]);
        }
    }

    /**
     * Function for upload avatar image
     *
     * @param  string  $folder
     * @param  string  $key
     * @param  string  $validation
     *
     * @return false|string|null
     */
    public function upload($folder = 'user_assets/profileImages', $key = 'avatar', $validation = 'image|mimes:jpeg,png,jpg,gif,svg|max:2048|sometimes')
    {
        request()->validate([$key => $validation]);

        $file = null;

        if(request()->hasFile($key)){
            $filename = time().'_profile.'.request()->file($key)->extension();
            request()->file($key)->move('user_assets/profileImages',$filename);
          $file  = env('SERVER_URL').'user_assets/profileImages/'.$filename;
        }
        return $file;
    }

    /**
     * Function to accept request for change email
     *
     * @param  SettingsEmailRequest  $request
     */
    public function changeEmail(SettingsEmailRequest $request)
    {
        // prevent change email for demo account
        if ($request->input('current_email') === 'demo@demo.com') {
            return redirect()->intended('account/settings');
        }

        auth()->user()->update(['email' => $request->input('email')]);

        if ($request->expectsJson()) {
            return response()->json($request->all());
        }

        return redirect()->intended('account/settings');
    }

    /**
     * Function to accept request for change password
     *
     *
     */
    public function changePassword(Request $request)
    {
        $userObj = User::find(auth()->user()->id);
        if(Hash::check($request->current_password,$userObj->password) == true){
            $validator = Validator::make($request->all(),[
                'password' => ['required', 'confirmed', Password::defaults()],
            ],[
                'password.required' => 'Password Field is Required',
            ]);
            if($validator->passes()){
                $userObj->password = Hash::make($request->password);
                $userObj->update();
                return response()->json(['status' => 'success' , 'msg' =>'Password has been updated successfully.']);
            }
            else{
                return response()->json(['status' => 'error' , 'msg' => $validator->errors()]);
            }

        }else{
            return response()->json(['status' => 'incorrect' , 'msg' => 'Current password is incorrect']);
        }
    }
}
