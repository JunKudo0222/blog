<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
	private $formItems = ["user_id","password"];

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
		$input = $request->only($this->formItems);
		//ログイン失敗
		return redirect()->route('admin.login')->withErrors([
			"login" => "ユーザーIDまたはパスワードが違います"
		])->withInput($input);
		
	}
}
