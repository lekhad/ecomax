<?php

namespace App\Http\Controllers;

use App\Country;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UsersController extends Controller
{
    //

    public function userLoginRegister(){
//        echo "test"; die;
        return view('users.login_register');
    }

    public function login(Request $request){
        if($request->isMethod('post')){
            $data= $request->all();
//            echo "<pre>"; print_r($data); die;
            if(Auth::attempt(['email'=>$data['email'], 'password'=>$data['password']])){
                Session::put('frontSession', $data['email']);

                if(!empty(Session::get('session_id'))){
                    $session_id= Session::get('session_id');
                    DB::table('cart')->where('session_id',  $session_id)->update(['user_email'=>$data['email']]);
                }

                return redirect('/cart');
            }else{
                return redirect()->back()->with('flash_message_error','Invalid Username or Password');
            }
        }
    }

    public function register(Request $request){
        if($request->isMethod('post')){
            $data= $request->all();
//            echo "<pre>"; print_r($data); die;

            //Check if user already Exusts
            $userCount= User::where('email', $data['email'])->count();
            if($userCount> 0){
                return redirect()->back()->with('flash_message_error', 'Email already exists');
            }else{
//                echo "Success";die;
                $user= new User;
                $user->name=     $data['name'];
                $user->email=    $data['email'];
                $user->password= bcrypt($data['password']);
                $user->save();
                if(Auth::attempt(['email'=>$data['email'], 'password'=>$data['password']])){
                    Session::put('frontSession', $data['email']);

                    if(!empty(Session::get('session_id'))){
                        $session_id= Session::get('session_id');
                        DB::table('cart')->where('session_id',  $session_id)->update(['user_email'=>$data['email']]);
                    }
                    return redirect('/cart');
                }
            }
        }
//        return view('users.login_register');
    }

    public function account(Request $request){
        $user_id= Auth::user()->id;
        $userDetails= User::find($user_id);
//        echo "<pre>"; print_r($userDetails); die;
        $countries= Country::get();

        if($request->isMethod('post')){
            $data= $request->all();
//            echo "<pre>"; print_r($data); die;
            if(empty($data['name'])){
                return redirect()->back()->with('flash_message_error', 'Please enter your name to update your account details');
            }
            if(empty($data['address'])){
                $data['address']='';
            }
            if(empty($data['city'])){
                $data['city']='';
            }
            if(empty($data['state'])){
                $data['state']='';
            }
            if(empty($data['country'])){
                $data['country']='';
            }
            if(empty($data['pincode'])){
                $data['pincode']='';
            }
            if(empty($data['mobile'])){
                $data['mobile']='';
            }

            $user= User::find($user_id);
            $user->name= $data['name'];
            $user->address= $data['address'];
            $user->city= $data['city'];
            $user->state= $data['state'];
            $user->country= $data['country'];
            $user->pincode= $data['pincode'];
            $user->mobile= $data['mobile'];
            $user->save();
            return redirect()->back()->with('flash_message_success', 'Your account details has been successfully Updated');

        }
        return view('users.account')->with(compact('countries', 'userDetails'));
    }

    public function chkUserPassword(Request $request){
        $data= $request->all();
//        echo "<pre>"; print_r($data); die;
        $current_password= $data['current_pwd'];
        $user_id= Auth::user()->id;
        $check_password= User::where('id', $user_id)->first();
        if(Hash::check($current_password, $check_password->password)){
            echo "true"; die;
        }else{
            echo "false"; die;
        }
    }

    public function updatePassword(Request $request){
        if($request->isMethod('post')){
            $data= $request->all();
//            echo "<pre>"; print_r($data); die;
            $old_pwd= User::where('id', Auth::user()->id)->first();
            $current_pwd= $data['current_pwd'];
            if(Hash::check($current_pwd, $old_pwd->password)){
                //Updated Password
                $new_pwd= bcrypt($data['new_pwd']);
                User::where('id', Auth::user()->id)->update(['password'=>$new_pwd]);
                return redirect()->back()->with('flash_message_success', 'Password Updated Successfully');
            }else{
                return redirect()->back()->with('flash_message_error', 'Current Password is Incorrect');
            }
        }
    }

    public function logout(){
        Auth::logout();
        Session::forget('frontSession');
        Session::forget('session_id');
        return redirect('/');
    }

    public function checkEmail(Request $request){
        $data= $request->all();
        $userCount= User::where('email', $data['email'])->count();
        if($userCount> 0){
            echo "false";
        }else{
            echo "true"; die;
        }
    }

}
