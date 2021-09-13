<a href="/" class="btn btn-primary">トップに戻る</a>
<h1>退会</h1>
退会しますか？
<br>
@auth

<form action="{{route('users.destroy',Auth::id())}}" class="right" method="POST">
    @csrf
<input name="_method" type="hidden" value="DELETE">
<input type="submit"  value="退会する">
</form><br>

@endauth