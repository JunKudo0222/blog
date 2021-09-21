<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    function showLoginForm(){
        
		return view('admin.admin_login');
	}
	
	function login(Request $request){
		//入力内容をチェックする
		$user_id = $request->input("user_id");
		$password = $request->input("password");
		//ログイン成功
		if($user_id == "hogehoge" && $password == "fugafuga"){
			$request->session()->put("admin_auth", true);
            
			return redirect()->route('admin.top');
		}
		//ログイン失敗
		return redirect()->route('admin.login')->withErrors([
			"login" => "ユーザーIDまたはパスワードが違います"
		]);
		
	}
}
