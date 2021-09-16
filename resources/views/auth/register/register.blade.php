

@extends('layouts.app')

<style>
    .{
        float:left;
        width:1000px;
    }
</style>

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <h1 class="card-header">会員情報登録フォーム</h1>
                

                <div class="card-body">
                    <form method="POST" action="{{ route('user.register_post') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name_sei" class="col-md-4 col-form-label text-md-right ">{{ __('姓') }}</label>

                            <div class="col-md-6 ">
                                <input id="name_sei" type="text" class="form-control @error('name_sei') is-invalid @enderror " name="name_sei" value="{{ old('name_sei') }}" required autocomplete="name_sei" autofocus>

                                @error('name_sei')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <label for="name_mei" class="col-md-4 col-form-label text-md-right ">{{ __('名') }}</label>

                            <div class="col-md-6 ">
                                <input id="name_mei" type="text" class="form-control @error('name_mei') is-invalid @enderror " name="name_mei" value="{{ old('name_mei') }}" required autocomplete="name_mei" autofocus>

                                @error('name_mei')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <p>性別<br>
                        @if(old('gender_id')==1)
                        <input type="radio" name="gender_id" value=1 checked> 男性
                        <input type="radio" name="gender_id" value=2> 女性
                        @elseif(old('gender_id')==2)
                        <input type="radio" name="gender_id" value=1> 男性
                        <input type="radio" name="gender_id" value=2 checked> 女性
                        @else
                        <input type="radio" name="gender_id" value=1> 男性
                        <input type="radio" name="gender_id" value=2> 女性
                        @endif
                        </p>


                        <div class="form-group">
                          <label for="exampleFormControlSelect1">都道府県</label>
                            <select class="form-control" id="exampleFormControlSelect1" name="prefecture">
                                
                                
                                @if(old('prefecture')==!null)
                                <option value="{{old('prefecture')}}" selected>{{$prefectures->find(old('prefecture'))->name}}</option>
                                @else
                                <option value="" selected>選択してください</option>
                                @endif
                             @foreach($prefectures as $prefecture)
                            <option value="{{ $prefecture -> id }}">{{ $prefecture -> name }}</option>
                             @endforeach
                            </select>
                        </div>













                        <div class="form-group row">
                            <label for="address" class="col-md-4 col-form-label text-md-right">{{ __('それ以降の住所') }}</label>

                            <div class="col-md-6">
                                <input id="address" type="text" class="form-control" name="address" value="{{ old('address') }}" required autocomplete="address">
                                @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                                
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" value="{{ old('password') }}" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" value="{{ old('password') }}" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
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
