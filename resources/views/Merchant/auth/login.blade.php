<form action="{{route('merchant.auth.login') }}" method="POST">
    @csrf
    <input type="email" name="email" id="password">
    @error('email')
        <div class="alert alert-danger">{{$message}}</div>
    @enderror
    <input type="password" name="password" id="password">
    @error('password')
        <div class="alert alert-danger">{{$message}}</div>
    @enderror
    <input type="submit" value="submit">
</form>