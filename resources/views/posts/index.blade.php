@extends('layouts.app')　
<style>
    .topright{
        float:right;
    }
    .bottom-center{
        margin-top:50px;
        margin-left:auto;
        margin-right:auto;
    }
    .left{
        float:left;
    }
    
</style>
<div class="topbar">
<div class="col-md-2 topright">
           <a href="{{ route('posts.create') }}" class="btn btn-primary">新規スレッド作成</a>
</div>
</div>
@section('content')
<div class="container">
    
    
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="text-center">
                




            <form action="{{route('posts.search')}}" method="get">
					@csrf
					
  					<input type="search" name="search" placeholder="キーワードを入力">
  					<input type="submit"  value="スレッド検索">
				</form>
				@isset($search_result)
				<div>
		
				
				<h3>
				{{$search_result}}
				</h3>
				</div>
				@endisset






            @foreach ($posts as $post)
                <div class="card-body">
                    <h5 class="card-title left">
                        ID:{{$post->id}}

                        <a href="{{ route('posts.show', $post->id) }}" >
                            {{ $post->title }}
                        </a>
                        {{ $post->created_at->format('Y.m.d H:i') }}
                    </h5>

                </div>
                @endforeach
        </div>
        </div>
        
    </div>
</div>
<div class="col-md-2 bottom-center">
                <a href="/" class="btn btn-primary">トップに戻る</a>
    </div>
@endsection