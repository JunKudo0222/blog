<style>
.topbar{
        float:left;
        width:100%;
        background-color:pink;
        margin-bottom:20px;
        padding:20px;   
       }
       .topbar-content{
           float:left;
       }
       .topbar-content2{
           float:right;
       }
       .idbox{
           width:50px;
       }
       .wordbox{
           width:200px;
       }
       .card{
           width:30%;
           margin-left:auto;
           margin-right:auto;
       }
       .searchtable{
           padding-bottom:10px;
       }
       .searchbutton{
           display:block;
           margin-top:10px;
           margin-bottom:10px;
           margin-left:auto;
           margin-right:auto;
           
       }
       .searchbar{
           width:100%;
        
       }
       tr{
           
       }
       .regist{
           margin-left:35%;
           margin-bottom:10px;
       }
       

</style>



<div class="topbar">
<h1 class="topbar-content">会員一覧</h1>
<a href="{{ route('admin.top') }}" class="btn btn-primary topbar-content2">トップへ戻る</a>
</div>
<a href="{{ route('users.register_show') }}" class="btn btn-primary regist">会員登録</a>

<form action="{{route('users.search')}}" method="get" class="searchbar">
					@csrf
                    <table class="searchtable card" border="5">
                    <tr>
                    <th bgcolor="lightblue">ID</th>
                    <th><input type="search" name="id" class="idbox"><br></th>
                    </tr>
                    <tr>
                    <th bgcolor="lightblue">性別</th>
                    <th><input type="checkbox" name="gender_id1" value=1> 男性
                    <input type="checkbox" name="gender_id2" value=1> 女性</th>
                    </tr>
                    <tr>
                    <th bgcolor="lightblue">都道府県</th>
                    <th><select  id="exampleFormControlSelect1" name="prefecture">
                        <option value="" selected>選択してください</option>
                        @foreach($prefectures as $prefecture)
                        <option value="{{ $prefecture -> id }}">{{ $prefecture -> name }}</option>
                        @endforeach
                    </select></th>
                    </tr>
                    <tr>
                    <th bgcolor="lightblue">フリーワード</th>
                    <th><input type="search" name="search"  class="wordbox"><br>
  					</th>
                    </tr>
                    </table>

                    
                    
                    
                    
                
                    
                
                
                    <input type="submit"  value="検索する" class="searchbutton">
                
				</form>
                

<body>
				<table border="1" class="sorttbl" id="sampleTable">
                <thead bgcolor="pink">
                    <tr>
                    <th>ID @if(isset($sort))<a href="{{ route('users.userlist') }}">▼</a> 
                        @else<a href="{{ route('users.userlist',['sort'=>'asc']) }}">▲</a>
                    
                    @endif</th>
                    <th>氏名</th>
                    <th>性別</th>
                    <th>住所</th>
                    <th>登録日時 @if(isset($sort))<a href="{{ route('users.userlist') }}">▼</a> 
                        @else<a href="{{ route('users.userlist',['sort'=>'asc']) }}">▲</a>
                    
                    @endif</th>
                    <th>編集</th>
                    <th>詳細</th>
                    
                </tr>
                <thead>
                <tbody>
                @foreach ($user_list as $user)
                <tr class="item">
				
					
						<td>{{$user->id}}</td>
                        <td><a href="{{ route('users.detail' , $user->id) }}">{{ $user->name_sei }}{{ $user->name_mei }}</a></td>
                        <td> @if($user->gender_id==1)男性@else 女性@endif </td>
                        <td>{{$prefectures->find($user->prefecture_id)->name}}{{$user->address}}</td>
                        <td> {{$user->created_at->format('Y/m/d')}}</td>
                        <td><a href="{{ route('users.edit' , $user->id) }}">編集</a></td>
                        <td><a href="{{ route('users.detail' , $user->id) }}">詳細</a></td>
					
				
                </tr>
				@endforeach
                </tbody>
            </table>
			
			
            <script src="{{ asset('/js/text.js') }}"></script>
            <link rel="stylesheet" href="{{ asset('/css/text.css') }}">
            
        </body>
        @extends('layouts.app')
        <div class="mt-3">
            {{ $user_list->appends(request()->input())->links('vendor/pagination/pagination_view3') }}
        </div>

        