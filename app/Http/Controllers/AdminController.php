<?php

namespace App\Http\Controllers;

use App\Admin;
use App\User;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    //
    public function login(Request $request){
        if($request->isMethod('post')){
            $data= $request->input();

          $adminCount= Admin::where(['username'=> $data['username'], 'password'=> md5($data['password']), 'status'=>1])->count();

            if($adminCount> 0){
                Session::put('adminSession', $data['username']);
                return redirect('/admin/dashboard');
            }else{
                return redirect('/admin')->with('flash_message_error', 'Invalid Username or Password');
            }

//            if(Auth::attempt(['email'=> $data['email'], 'password'=>$data['password'], 'admin'=> '1' ])){
////                echo "Success"; die;
////                first approach to authentication which is sent to dashboard function
//                Session::put('adminSession', $data['email']);
//
//                return redirect('admin/dashboard');
//            }else{
////                echo "Failed"; die;
//                return redirect('/admin')->with('flash_message_error', 'Invalid Username or Password');
//            }
        }
        return view("admin.admin_login");
    }
    public function dashboard(){

//        if(Session::has('adminSession')){
//            //Perform all dashboard task
//        }else{
//            return redirect('/admin')->with('flash_message_error', 'Please login to access');
//        }
        return view('admin.dashboard');
    }


    public function settings(){
        $adminDetails= Admin::where(['username'=>Session::get('adminSession')])->first();
//        echo "<pre>"; print_r($adminDetails); die;
        return view('admin.settings')->with(compact('adminDetails'));
    }


    public function chkPassword(Request $request){

        $data= $request->all();
        $adminCount= Admin::where(['username'=> Session::get('adminSession'), 'password'=>md5($data['current_pwd'])])->count();
        if($adminCount== 1){
            echo "true"; die;
        }else{
            echo "false"; die;
        }
//        $data= $request->all();
//        $current_password= $data['current_pwd'];
//        $check_password=   User::where(['admin'=>'1'])->first();
//
//        if(Hash::check($current_password, $check_password->password)){
//            echo "true"; die;
//        }else{
//            echo "false"; die;
//        }
    }

    public function updatePassword(Request $request){

        if($request->isMethod('post')){
            $data= $request->all();
//            echo "<pre>"; print_r($data); die;

            $adminCount= Admin::where(['username'=>Session::get('adminSession'), 'password'=> md5($data['current_pwd'])])->count();

            if($adminCount==1){

                $password= md5($data['new_pwd']);
                Admin::where('username', Session::get('adminSession'))->update(['password'=>$password]);
                return redirect('/admin/settings')->with('flash_message_success', 'Password updated successfully');
            }else{
                return redirect('/admin/settings')->with('flash_message_error', 'Incorrect Current Password');
            }
        }
//        if($request->isMethod('post')){
//            $data= $request->all();
////            echo "<pre>"; print_r($data); die;
//            $check_password= User::where(['email' => Auth::user()->email])->first();
//            $current_password= $data['current_pwd'];
//            if(Hash::check($current_password, $check_password->password)){
//                $password= bcrypt($data['new_pwd']);
//                User::where('id', '1')->update(['password'=>$password]);
//                return redirect('/admin/settings')->with('flash_message_success', 'Password updated successfully');
//            }else{
//                return redirect('/admin/settings')->with('flash_message_error', 'Incorrect Current Password');
//            }
//        }
    }


    public function logout(){
        Session::flush();
        return redirect('/admin')->with('flash_message_success', 'Logged out successfully');
    }

}
