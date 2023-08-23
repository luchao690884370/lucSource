<?php

namespace plugin\lucSource\app\controller;

use support\Request;
use support\View;
use plugin\user\app\model\User;


class LoginController  extends Base
{
    public function index(Request $request){
		return view('html/login',['msg'=>'']);
    }


   public function login(Request $request){

	   $username = $request->post('username', '');
	   $password = $request->post('password', '');
	   $value =['success'=>true,'msg'=>''];
	   if($username==''){
		   $value =['success'=>false,'msg'=>'请输入账号'];
	   }
	   if($password ==''){
		   $value =['success'=>false,'msg'=>'请输入密码'];
	   }

	   $user = User::where('username', $username)
						   ->orWhere('email', $username)
						   ->orWhere('mobile', $username)
						   ->first();
	   if(!$user){
		   $value =['success'=>false,'msg'=>'账号未注册'];
	   } else{
		   if($user->status==0){
			   $value =['success'=>false,'msg'=>'账号已被禁用'];
		   }
		
		   if (password_verify($password, $user->password)==false) {
			   $value =['success'=>false,'msg'=>'密码错误'];
		   }
	   }



	   if($value['success']==true){

		   $user->last_time = date('Y-m-d H:i:s');
		   $user->save();

		   $request->session()->set('user', [
			   'id' => $user->id,
			   'username' => $user->username,
			   'nickname' => $user->nickname,
			   'avatar' => $user->avatar,
			   'email' => $user->email,
			   'mobile' => $user->mobile,
		   ]);
		   return  redirect('/');
	   } else{
		   return view('html/login',['msg'=>$value['msg']]);
	   }
   }

   //退出
   public function logout(Request $request)
   {
	   $session = $request->session();
	   $userId = session('user.id');
	   if ($userId && $user = User::find($userId)) {
		        //  Event::emit('user.logout', $user);
	   }
	   $session->delete('user');
	   return redirect('/login');
   }

}
