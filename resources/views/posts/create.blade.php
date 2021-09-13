@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
        @if ($errors->any()) //追加
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('posts.confirm') }}" method="POST">
            {{csrf_field()}}
                <div class="form-group">
                    <label>タイトル</label>
                    <input type="text" class="form-control" value="{{old('title')}}" name="title" >
                </div>
                <div class="form-group">
                    <label>内容</label>
                    <textarea class="form-control"  rows="5" name="body" value="{{old('body')}}">{{ old('body') }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary">確認画面へ</button><br><br>
                <a href="/" class="btn btn-primary">{{ __('トップへ戻る') }}</a>
            </form>
        </div>
    </div>
</div>
@endsection