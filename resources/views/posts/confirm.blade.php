@extends('layouts.app')
@section('content')
<div class="container">
<div class="row justify-content-center">
<div class="col-md-8">
<h1>スレッド作成確認画面</h1><br>

<form action="{{ route('posts.store') }}" method="POST">
{{csrf_field()}}
        <div class="md-form">
            <label for="title">スレッドタイトル</label>
            {{ $post->title }}
            <input class="form-control" type="hidden" id="title" name="title" required value="{{ $post->title }}">
        </div>
        <div class="md-form">
            <label for="body">コメント</label>
            {{ $post->body }}
            <input class="form-control" type="hidden" id="body" name="body" required value="{{ $post->body }}">
        </div>
        <button type="submit" class="btn btn-primary">スレッドを作成する</button><br><br>
        <button type="submit" class="btn btn-primary" name="back">前に戻る</button>
</form>
</div>
</div>
</div>
@endsection

