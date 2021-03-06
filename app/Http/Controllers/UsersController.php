<?php

namespace App\Http\Controllers;

use App\Country;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
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

                $userStatus= User::where('email', $data['email'])->first();
                if($userStatus->status==0){
                    return redirect()->back()->with('flash_message_error', 'Your account is not activated! Please confirm your email to activate your account');
                }
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

                // Send  Register Email

//                $email= $data['email'];
//                $messageData= ['email'=> $data['email'], 'name'=> $data['name']];
//                Mail::send('emails.register', $messageData, function($message) use($email){
//                    $message->to($email)->subject('Registration with E-commerce Website');
//                });

                //Send Confirmation Email

                $email= $data['email'];
                $messageData= ['email'=> $data['email'], 'name'=> $data['name'], 'code'=> base64_encode($data['email'])];
                Mail::send('emails.confirmation', $messageData, function($message) use($email){
                   $message->to($email)->subject('Confirm your E-commerce Website');
                });

                return redirect()->back()->with('flash_message_success', 'Please Confirm Your email to activate your account!');


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

    public function forgotPassword(Request $request){
        if($request->isMethod('post')){
            $data= $request->all();
//            echo "<pre>"; print_r($data); die;
            $userCount= User::where('email', $data['email'])->count();
            if($userCount== 0){
                return redirect()->back()->with('flash_message_error', 'Email does not exists');
            }

            //Get User Details
            $userDetails= User::where('email', $data['email'])->first();

            // Generate Random Password
            $random_password= str_random(8);



            // Encode/Secure Password

//            echo $new_password=  bcrypt($random_password); die;
            $new_password= bcrypt($random_password);

            //Update Password
            User::where('email', $data['email'])->update(['password' => $new_password]);

            //Send Forgot Password Email Code

            $email= $data['email'];
            $name= $userDetails->name;
            $messageData= [
                'email'=> $email,
                'name'=> $name,
                'password'=> $random_password
            ];

            Mail::send('emails.forgotpassword',$messageData,function($message) use($email){
                $message->to($email)->subject('New Password - E-com Website');
            });

//            $messageData= ['email'=> $email, 'name'=> $userDetails->name];
//            Mail::send('emails.welcome', $messageData, function($message) use($email){
//                $message->to($email)->subject('Welcome to E-commerce Website');
//            });

            return redirect('login-register')->with('flash_message_success', 'Please check your email for new Password!');
        }
        return view('users.forgot_password');
    }

    public function confirmAccount($email){

//        echo $email= base64_decode($email);

        $email= base64_decode($email);
        $userCount= User::where('email', $email)->count();
        if($userCount> 0){
//            echo "success";
            $userDetails= User::where('email', $email)->first();
            if($userDetails->status==1){
                return redirect('login-register')->with('flash_message_success', 'Your Email account is already activated, You can login');
            }else{

                User::where('email', $email)->update(['status'=>1]);

//                Send  Welcome Email

//                $email= $data['email'];

                $messageData= ['email'=> $email, 'name'=> $userDetails->name];
                Mail::send('emails.welcome', $messageData, function($message) use($email){
                    $message->to($email)->subject('Welcome to E-commerce Website');
                });

                return redirect('login-register')->with('flash_message_success', 'Your Email Account is activated. You can login now');
            }
        }else{
            abort(404);
        }
//        echo $email; die;
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


    public function viewUsers(){
        $users= User::get();
        return view('admin.users.view_users')->with(compact('users'));
    }

}
