<?php

namespace App\Http\Controllers\admin;


use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use App\Prefecture;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Rules\Hankaku;
use App\Rules\Gender;
use App\Rules\PrefectureRule;

class ManageUserController extends Controller
{
    private $form_show = 'admin\ManageUserController@edit';
    private $form_confirm = 'admin\ManageUserController@editconfirm';
    private $form_complete = 'admin\ManageUserController@complete';

    private $formItems = ["id","name_sei","name_mei", "email", "password","prefecture","address","gender_id"];




    function showUserList(Request $request){
        if(isset($request->sort)){

            $user_list = User::orderBy('id','asc')->paginate(10)->onEachSide(1);
            // dd($user_list);
            $prefectures = Prefecture::all();
            $sort='asc';
            return view("admin.user_list", [
                "user_list" => $user_list
            ],compact('prefectures','sort'));
        }
        else{
            $user_list = User::orderBy('id','desc')->paginate(10)->onEachSide(1);
            // dd($user_list);
            $prefectures = Prefecture::all();
            
            return view("admin.user_list", [
                "user_list" => $user_list
            ],compact('prefectures'));

        }
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
        
        if(isset($request->gender_id1)&&$request->gender_id2==null){
            
            $query->where('users.gender_id', 1);
            
        }
        if(isset($request->gender_id2)&&$request->gender_id1==null){
            
            $query->where('users.gender_id', 2);
            
        }
        if(isset($request->prefecture)){
            
            $query->where('users.prefecture_id', $request->prefecture);
            
            
        }
        if(isset($request->search)){
            $query->where('name_sei','like','%'.$request->search.'%')
            ->orWhere('name_mei','like','%'.$request->search.'%')
            ->orWhere('email','like','%'.$request->search.'%');
            
        }
        // dd(User::query()->get());
        
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

    /*
     * 入力から確認へ遷移する際の処理
     */
    function post(Request $request)
    {
        
        
        $this->validator($request->all())->validate();
        
        $input = $request->only($this->formItems);
        
        
        
        // //セッションに書き込む
        $request->session()->put("form_input", $input);
        $prefecture=Prefecture::find($input['prefecture']);
        // $id=$input['id'];

        return view('admin.user_edit_confirm', ["input" => $input],compact('prefecture'));
        
        
        
    }


    protected function validator(array $data)
    {
        if(isset($data['id'])){
        $user=User::find($data['id']);
        if($user->email==$data['email']){
            
            
            return Validator::make($data, [
                
                'name_sei' => ['required', 'string', 'max:20'],
                'name_mei' => ['required', 'string', 'max:20'],
                'gender_id' => ['required',new Gender],
                'prefecture' => ['required','between:1,47','integer' ],
                'address' => ['nullable','string','max:100' ],
                'password' => ['nullable','string', 'min:8','max:20',new Hankaku, 'confirmed'],
                
                
                
            ]);
        }
        else{
            return Validator::make($data, [
            'name_sei' => ['required', 'string', 'max:20'],
            'name_mei' => ['required', 'string', 'max:20'],
            'gender_id' => ['required',new Gender],
            'prefecture' => ['required','between:1,47','integer' ],
            'address' => ['nullable','string','max:100' ],
            'password' => ['nullable','string', 'min:8','max:20',new Hankaku, 'confirmed'],
            // 'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'email' => 'required|string|email|max:200|unique:users,email,NULL,id,deleted_at,NULL',
        ]);
        }}
        else{
            return Validator::make($data, [
                'name_sei' => ['required', 'string', 'max:20'],
                'name_mei' => ['required', 'string', 'max:20'],
                'gender_id' => ['required',new Gender],
                'prefecture' => ['required','between:1,47','integer' ],
                'address' => ['nullable','string','max:100' ],
                'password' => ['required','string', 'min:8','max:20',new Hankaku, 'confirmed'],
                // 'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'email' => 'required|string|email|max:200|unique:users,email,NULL,id,deleted_at,NULL',
            ]);

        }
        
        // return view('posts.confirm');
    }
    



    public function editconfirm(Request $request)
    {
        dd($request);
        //セッションから値を取り出す
        $input = $request->session()->get("form_input");
        
        
        //セッションに値が無い時はフォームに戻る
        if (!$input) {
            
            return redirect()->action("admin\ManageUserController");
        }
        $id=(int)$input['prefecture'];
        
        $prefectures = Prefecture::find($id);
        // dd($prefectures);
        
        
        return view('admin.user_edit_confirm', ["input" => $input],compact('prefectures'));

    }

    public function update(Request $request)
    {
        $request->session()->regenerateToken();
        //セッションから値を取り出す
        $input = $request->session()->get("form_input");
        
        $user=User::find($input['id']);
        
        $user->name_sei=$input['name_sei'];
        $user->name_mei=$input['name_mei'];
        $user->email=$input['email'];
        if($input['password']==!null){

            $user->password=Hash::make($input['password']);
        }
        $user->gender_id=$input['gender_id'];
        $user->prefecture_id=$input['prefecture'];
        $user->address=$input['address'];
        
        $user->save();
        
        
        //セッションに値が無い時はフォームに戻る
        // if (!$input) {
        //     return redirect()->action($this->form_show);
        // }

        
        // $this->validator($request->all())->validate();
        
        // event(new Registered($user = $this->create($request->all())));

        //セッションを空にする
        $request->session()->forget('form_input');
        
        
        // 登録データーでログイン
        // $this->guard()->login($user, true);

        return $this->registered($request);
        

    }

    function registered(Request $request)
    {
        // return $this->showUserList();
        return redirect()->route('users.userlist');
    }

    public function showRegistrationForm()
    {
        $prefectures = Prefecture::all();
        return view('admin.user_regist',compact('prefectures'));
    }

    public function register(Request $request)
    {
        $request->session()->regenerateToken();
        //セッションから値を取り出す
        $input = $request->session()->get("form_input");
        
        
        // $this->validator($request->all())->validate();
        event(new Registered($user = $this->create($input)));

        //セッションを空にする
        $request->session()->forget("form_input");
        return redirect()->route('users.userlist');
           
    }
    protected function create(array $data)
    {
        
        
        return User::create([
            'name_sei' => $data['name_sei'],
            'name_mei' => $data['name_mei'],
            'gender_id' => $data['gender_id'],
            'prefecture_id' => $data['prefecture'],
            'address' => $data['address'],
            'password' => Hash::make($data['password']),
            'email' => $data['email'],
        ]);
    }


    
}
