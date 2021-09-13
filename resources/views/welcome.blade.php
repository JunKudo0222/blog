<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">

        <!-- Styles -->
        <style>
            html,body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 95%;
                margin: 0;
            }

            .full-height {
                height: 100%;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }
            .top-left {
                position: absolute;
                left: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
            .parent{
                display:flex;
            }
            .child_1{
                order:1;
            }
            .child_2{
                order:0;
            }
            footer{
                width:100%;
                
                background-color:pink;
                
            }
            .right{
                float:right;
                margin-right:20px
            }







        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))

                <div class="top-left links parent">
                    @auth
                    ようこそ{{ Auth::user()->name_sei }}{{ Auth::user()->name_mei }}様
                    @endauth
                </div>    
                <div class="top-right links parent">
                    @auth
                                    <a  href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        ログアウト
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                    @else
                        <a href="{{ route('login') }}" class="child_1">ログイン</a>

                        @if (Route::has('user.register_show'))
                        <a href="{{ route('user.register_show') }}" class="child_2">新規会員登録</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
                
                <a href="{{ route('posts.index') }}">
                <div class="title m-b-md" >
                        スレッド一覧
                    </div>
                </a>

                <!-- <div class="links">
                    <a href="https://laravel.com/docs">Docs</a>
                    <a href="https://laracasts.com">Laracasts</a>
                    <a href="https://laravel-news.com">News</a>
                    <a href="https://blog.laravel.com">Blog</a>
                    <a href="https://nova.laravel.com">Nova</a>
                    <a href="https://forge.laravel.com">Forge</a>
                    <a href="https://vapor.laravel.com">Vapor</a>
                    <a href="https://github.com/laravel/laravel">GitHub</a>
                </div> -->
            </div>
            
        </div>
        <footer>
        
            @auth
            <a href="{{route('users.delete_confirm')}}" class="right">退会</a>
            @endauth
        
        </footer>
    </body>
</html>
