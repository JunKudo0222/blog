<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Prefecture;

class ManageUserController extends Controller
{
    function showUserList(){
		$user_list = User::orderBy("id")->paginate(10)->onEachSide(1);
        // dd($user_list);
        $prefectures = Prefecture::all();
		return view("admin.user_list", [
			"user_list" => $user_list
		],compact('prefectures'));
	}
	function showUserDetail($id){
		$user = User::find($id);
        $prefectures = Prefecture::all();
		return view("admin.user_detail",compact('user','prefectures'));
	}
    function search(Request $request){
        $query = User::query();
        // dd($request->gender_id);
        if(isset($request->id)){
            $query->where('users.id',$request->id);

        }

        if(isset($request->gender_id)){
            
                $query->where('users.gender_id', $request->gender_id);
            
        }
        if(isset($request->prefecture)){
            
                $query->where('users.prefecture_id', $request->prefecture);
            
        }
        // dd(User::query()->get());
        
        if(isset($request->search)){
            $query->where('name_sei','like','%'.$request->search.'%')
            ->orWhere('name_mei','like','%'.$request->search.'%')
            ->orWhere('email','like','%'.$request->search.'%');
        }
        $prefectures = Prefecture::all();

        $user_list = $query->get()->paginate(10)->onEachSide(1);
        // dd($user_list);

        $search_result = $request->search.'の検索結果'.$query->get()->count().'件';
    

        return view('admin.user_list',[
			"user_list" => $user_list
		],compact('search_result','prefectures'));    

    }


    
    public function edit($id)
    {
        $user = User::find($id);
        $prefectures = Prefecture::all();
        
        return view('admin.user_edit', compact('user','prefectures'));
    }

    public function editconfirm(Request $request)
    {
        $input=$request->session()->get();
        return view('admin.user_edit_confirm');

    }

    public function update(Request $request,$id)
    {
        $user = User::find($id);


    }


    
}
