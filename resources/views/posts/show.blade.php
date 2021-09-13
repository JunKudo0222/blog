<style>
    .pager{
        margin-left: auto;
    margin-right: auto;
    width: 8em;
    
    }
    .topbutton{
        float:right;
        width:20%;

    }
</style>


@extends('layouts.app')
@section('content')
<div class="topbutton">
    <a class="btn btn-primary" href="{{route('posts.index')}}">スレッド一覧に戻る</a>
</div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card-header">
                <h5>{{ $post->title }}</h5><br>
                <a>{{ $post->comments->count() }}コメント {{ $post->created_at->format('n/j/y H:i') }}</a>
            </div>
            <div class="mt-3 pager">
                {{ $comments->links('vendor/pagination/pagination_view') }}
            </div>
            <div class="card-body">
                <p class="card-text">投稿者：@if(!isset($post->user))削除済みユーザ @else{{ $post->user->name_sei }}{{ $post->user->name_mei }}@endif {{ $post->created_at->format('Y.m.d H:i') }}</p>
                <p class="card-text">{{ $post->body }}</p>
                <!-- @if($post->user_id===Auth::id())
                <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-primary">編集する</a>
                <form action='{{ route('posts.destroy', $post->id) }}' method='post'>
                 {{ csrf_field() }}
                 {{ method_field('DELETE') }}
                 <input type='submit' value='削除' class="btn btn-danger" onclick='return confirm("削除しますか？？");'>
               </form>
                @endif -->
            </div>
        </div>
    </div>



    








    <div class="row justify-content-center">
        <div class="col-md-8">
            @foreach ($comments as $index=>$comment)
            <div class="card mt-3">
                <h5 class="card-header">{{$index+1}}.@if(!isset($comment->user))削除済みユーザ@else{{ $comment->user->name_sei }} {{ $comment->user->name_mei }}@endif</h5>
                <div class="card-body">
                    <h5 class="card-title">投稿日時：{{ $comment->created_at->format('Y.m.d H:i') }}</h5>
                    <p class="card-text">内容：{{ $comment->body }}</p>
                </div>
            </div>
            @if($comment->users()->where('user_id', Auth::id())->exists())
            <div class="col-md-3">
                <form action="{{ route('unfavorites', $comment) }}" method="POST">
                    @csrf
                    <input type="submit" value="いいね取り消す" class="fas btn btn-danger">
                </form>
            </div>
            @else
            <div class="col-md-3">
                <form action="{{ route('favorites', $comment) }}" method="POST">
                    @csrf
                    <input type="submit" value="いいね" class="fas btn btn-success">
                </form>
            </div>
            @endif
            <div class="row justify-content-left">
                <p>{{ $comment->users()->count() }}</p>
            </div>
            @endforeach
        </div>
    </div>
    <div class="justify-content-center pager">
                {{ $comments->links('vendor/pagination/pagination_view') }}
    </div>
    @if( Auth::check() )
    <div class="row justify-content-center">
        <div class="col-md-8">
            <form action="{{ route('comments.store') }}" method="POST">
            {{csrf_field()}}
        <input type="hidden" name="post_id" value="{{ $post->id }}">
                <div class="form-group">
                    <label>コメント</label>
                    <textarea class="form-control" 
                     placeholder="内容" rows="5" name="body"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">コメントする</button>
            </form>
        </div>
    </div>
    @endif
</div>
@endsection