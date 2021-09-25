
@extends('layouts.app')

<style>
    .{
        float:left;
        width:1000px;
    }
    .rightbutton{
        float:right;
    }
    .lefttitle{
        float:left;
    }
    </style>

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h1 class="lefttitle">会員編集</h1>
                    <a href="{{ route('users.userlist') }}" class="btn btn-primary rightbutton">一覧へ戻る</a>
                </div>
                @if ($errors->any())
                <div class="alert alert-success">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <div class="card-body">
                    
                    
                    
                    <form method="POST" action="{{ route('users.post') }}">
                        @isset($user)
                        ID {{$user->id}}
                        @endisset
                        @csrf
                        @isset($user)
                        <input id="id"  type="hidden" name="id" value="{{$user->id}}" >
                        @endisset
                        <div class="form-group row">
                            <label for="name_sei" class="col-md-4 col-form-label text-md-right ">{{ __('姓') }}</label>

                            <div class="col-md-6 ">
                                @if(old('name_sei')==!null)
                                <input id="name_sei" type="text" class="form-control @error('name_sei') is-invalid @enderror " name="name_sei" value="{{ old('name_sei') }}" required autocomplete="name_sei" autofocus>
                                @else
                                <input id="name_sei" type="text" class="form-control @error('name_sei') is-invalid @enderror " name="name_sei" value="{{ $user->name_sei }}" required autocomplete="name_sei" autofocus>
                                @endif

                                @error('name_sei')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <label for="name_mei" class="col-md-4 col-form-label text-md-right ">{{ __('名') }}</label>

                            <div class="col-md-6 ">
                                @if(old('name_mei')==!null)
                                <input id="name_mei" type="text" class="form-control @error('name_mei') is-invalid @enderror " name="name_mei" value="{{ old('name_mei') }}" required autocomplete="name_mei" autofocus>
                                @else
                                <input id="name_mei" type="text" class="form-control @error('name_mei') is-invalid @enderror " name="name_mei" value="{{ $user->name_mei }}" required autocomplete="name_mei" autofocus>
                                @endif

                                @error('name_mei')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <p>性別<br>
                        @if(old('gender_id')==!null)
                        @if(old('gender_id')==1)
                        <input type="radio" name="gender_id" value=1 checked> 男性
                        <input type="radio" name="gender_id" value=2> 女性
                        @elseif(old('gender_id')==2)
                        <input type="radio" name="gender_id" value=1> 男性
                        <input type="radio" name="gender_id" value=2 checked> 女性
                        @endif
                        @else
                        @if($user->gender_id==1)
                        <input type="radio" name="gender_id" value=1 checked> 男性
                        <input type="radio" name="gender_id" value=2> 女性
                        @else
                        <input type="radio" name="gender_id" value=1> 男性
                        <input type="radio" name="gender_id" value=2 checked> 女性
                        @endif
                        @endif
                        </p>


                        <div class="form-group">
                          <label for="exampleFormControlSelect1">都道府県</label>
                            <select class="form-control" id="exampleFormControlSelect1" name="prefecture">
                                @if(old('prefecture')==!null&&1<=old('prefecture')&&old('prefecture')<=47)
                                <option value="{{old('prefecture')}}" selected>{{$prefectures->find(old('prefecture'))->name}}</option>
                                @else
                                <option value="{{$user->prefecture_id}}" selected>{{$prefectures->find($user->prefecture_id)->name}}</option>
                                @endif
                             @foreach($prefectures as $prefecture)
                             
                            <option value="{{ $prefecture -> id }}">{{ $prefecture -> name }}</option>
                             
                             @endforeach
                            </select>
                        </div>













                        <div class="form-group row">
                            <label for="address" class="col-md-4 col-form-label text-md-right">{{ __('それ以降の住所') }}</label>

                            <div class="col-md-6">
                                @if(old('address')==!null)
                                <input id="address" type="text" class="form-control" name="address" value="{{ old('address') }}" required autocomplete="address">
                                @else
                                <input id="address" type="text" class="form-control" name="address" value="{{ $user->address }}" required autocomplete="address">
                                @endif
                                @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                                
                            </div>
                        </div>


                        
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('パスワード') }}</label>
                            
                            <div class="col-md-6">
                                @if(old('password')==!null)
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" value="{{old('password')}}"  autocomplete="new-password">
                                @else
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" value=""  autocomplete="new-password">
                                @endif
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('パスワード確認') }}</label>
                            
                            <div class="col-md-6">
                                @if(old('password')==!null)
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" value="{{old('password')}}"  autocomplete="new-password">
                                @else
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" value=""  autocomplete="new-password">
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('メールアドレス') }}</label>

                            <div class="col-md-6">
                                @if(old('email')==!null)
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                                @else
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}" required autocomplete="email">
                                @endif

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    確認画面へ
                                </button>
                            </div>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
