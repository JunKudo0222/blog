@extends('layouts.app')
@section('content')
<form method="POST" action="{{ route('users.update',['id'=>$input['id']]) }}" enctype="multipart/form-data">
                        @csrf
                        {{method_field('PUT')}}

ID：         <input value="{{$input['id']}}"><br>
氏名：        <input value="{{$input['name_sei']}}"> <input value="{{$input['name_mei']}}"><br>
@if(

    $input['gender_id']==1
)
性別：        男性
@else
性別：        女性
@endif
<br>
住所：        {{$prefecture->name}} {{$input['address']}}<br>
パスワード：   セキュリティのため非表示<br>
メールアドレス：{{$input['email']}}<br>



<div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    確認画面へ
                                </button>
                            </div>
                        </div>
                        
                        <button href="#" class="btn btn-block blue-gradient mt-2 mb-2" onclick="history.back(-1);return false;">戻る</button>
                    </form>
                                

@endsection