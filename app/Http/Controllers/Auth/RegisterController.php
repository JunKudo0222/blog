<?php

namespace App\Http\Controllers\Auth;


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


class RegisterController extends Controller
{
    private $form_show = 'Auth\RegisterController@showRegistrationForm';
    private $form_confirm = 'Auth\RegisterController@confirm';
    private $form_complete = 'Auth\RegisterController@complete';

    private $formItems = ["name_sei","name_mei", "email", "password","prefecture","address","gender_id"];

    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'complete']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        
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
        // return view('posts.confirm');
    }

    
        
    

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
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

    /*
     * ?????????????????????????????????????????????
     */
    function post(Request $request)
    {
        // dd($request);
        $this->validator($request->all())->validate();

        $input = $request->only($this->formItems);
        

        //??????????????????????????????
        $request->session()->put("form_input", $input);
        
        return redirect()->action($this->form_confirm);
    }

    /**
     * ????????????
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        //???????????????????????????????????????
        $input = $request->session()->get("form_input");
        
        // ???????????????
        if ($request->has("back")) {
            // dd($request);
            return redirect()->action($this->form_show)
            ->withInput($input);
        }
        
        
        //?????????????????????????????????????????????????????????
        if (!$input) {
            return redirect()->action($this->form_show);
        }

        
        // $this->validator($request->all())->validate();
        
        event(new Registered($user = $this->create($request->all())));

        //??????????????????????????????
        $request->session()->forget("form_input");

        // ?????????????????????????????????
        $this->guard()->login($user, true);

        return $this->registered($request, $user)
            ?  : redirect($this->redirectPath());
           
    }

    /*
     * ???????????????
     */
    function registered(Request $request, $user)
    {
        return redirect()->action($this->form_complete);
    }

    /**
     * ????????????????????????????????????
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        $prefectures = Prefecture::all();
        return view('auth.register.register',compact('prefectures'));
    }

    /*
     * ??????????????????
     */
    public function confirm(Request $request)
    {
        
        //???????????????????????????????????????
        $input = $request->session()->get("form_input");
        
        
        //?????????????????????????????????????????????????????????
        if (!$input) {
            return redirect()->action("Auth\RegisterController");
        }
        $id=(int)$input['prefecture'];
        
        $prefectures = Prefecture::find($id);
        // dd($prefectures);
        
        
        return view('auth.register.confirm', ["input" => $input],compact('prefectures'));
    }

    /*
     * ??????????????????
     */
    public function complete()
    {
        return view('auth.register.complete');
    }

    
}
