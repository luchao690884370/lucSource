<?php

namespace plugin\lucSource\app\controller;
use support\Request;
use support\View;
use plugin\user\app\model\User;

class RegisterController extends Base
{
    public function index(Request $request) {
		return view('html/register',['msg'=>'']);
    }

	//用户注册
	public function register(Request $request){
		$username = $request->post('username', '');
		$password = $request->post('password', '');

		$value = ['success'=>true,'msg'=>'注册成功，请登录'];

		if($username==''){
			$value =['success'=>false,'msg'=>'请输入账号'];
		}
		if($password ==''){
			$value =['success'=>false,'msg'=>'请输入密码'];
		}
		if (User::where('username', $username)->first()) {
			 $value =['success'=>false,'msg'=>'用户名已经被占用'];
		} else{
			if($value['success']==true){
				$user = [
					'username' => $username,
					'password' =>  password_hash($password, PASSWORD_DEFAULT),
				];
				$waUser = new User();
				foreach ($user as $key => $val) {
					$waUser->$key = $val;
				}
				$waUser->nickname=$username;
				$waUser->status=1;
				$waUser->avatar = '/app/lucSource/default/images/logo.png';
				$waUser->save();
			}
		}

		return view('html/register',  ['msg'=>$value['msg']]    );
	}





}
