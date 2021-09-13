
@extends('layouts.admin')

<style>
    .detailbar{
        float:left;
        margin:20;
    }
    .right{
        float:right;
        margin:20;
    }
    .left{
        float:left;
        margin:20;
    }
    .bg{
        background-color:pink;
        height:100px;
        width:100%;
        padding:0;
        margin:0;
    }
    
    .select{
        
        width:20%;
        
        margin-left:auto;
        margin-right:auto;
        margin-top:50px;
    }
    .ml{
        margin-left:500px;
    }
    
    
    
</style>
<div class="bg">
<h1 class="detailbar"> 掲示板管理画面メインメニュー</h1>
<h5 class="detailbar ml"> ようこそ工藤さん</h5>
    <div class="right">
        <a href="{{ route('admin.logout') }}" class="btn btn-primary">ログアウト</a>
    </div>
</div>
@section('content')
<div>
				<a href="{{ route('users.userlist') }}" class="btn btn-primary">会員一覧</a>
			</div>
@endsection

