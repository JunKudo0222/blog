<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PostRequest; 
use App\Post; 
use App\User; 
use Auth;  

class PostController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();
        $posts->load('user');
        return view('posts.index', compact('posts'));
        //return view('posts.index');
        
    }
   /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        $input = $request->only('title','body');
        $request->session()->put("form_input", $input);
        //セッションから値を取り出す
        $input = $request->session()->get("form_input");
        if ($request->has("back")) {
            // dd($input);
            // dd($request);
            return redirect()->route('posts.create')->withInput($input);
        }
        $post = new Post; //インスタンスを作成
        $post -> title    = $request -> title; //ユーザー入力のtitleを代入
        $post -> body     = $request -> body; //ユーザー入力のbodyを代入
        $post -> user_id  = Auth::id(); //ログイン中のユーザーidを代入
        $post -> save(); //保存してあげましょう
        
        return redirect()->route('posts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        $post->load('user', 'comments');
        // $user=User::find($post->user_id);
        $user = User::withTrashed()
                ->where('id',$post->user_id)
                ->find($post->user_id);
                // dd($user->name_sei);
                
                
            $comments=$post->comments->paginate(5);
            
            
            return view('posts.show', compact('post','comments','user'));
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);
        if(Auth::id() !== $post->user_id){
            return abort(404);
        }
        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $post = Post::find($id);
        if(Auth::id() !== $post->user_id){
            return abort(404);
        }
        $post -> title    = $request -> title;
        $post -> body     = $request -> body;
        $post -> save();
        return view('posts.show', compact('post'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        if(Auth::id() !== $post->user_id){
            return abort(404);
        }
        $post -> delete();
        return redirect()->route('posts.index');
    }




    public function confirm(PostRequest $request)
    {
        $post = new Post; //インスタンスを作成
        $post -> title    = $request -> title; //ユーザー入力のtitleを代入
        $post -> body     = $request -> body; //ユーザー入力のbodyを代入
        $post -> user_id  = Auth::id(); //ログイン中のユーザーidを代入

        return view('posts.confirm',compact('post'));
    }

    public function search(Request $request)
    {                
        $query = Post::query();

        if(isset($request->search)){
            $query->where('title','like','%'.$request->search.'%')
            ->orWhere('body','like','%'.$request->search.'%');
        }

         $posts = $query->get();

        $search_result = $request->search.'の検索結果'.$posts->count().'件';

        return view('posts.index',compact('posts','search_result'));    
    }
}
