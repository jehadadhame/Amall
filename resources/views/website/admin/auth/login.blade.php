<form action="{{route('website.admin.auth.login', ['website' => $website])}}" method="post">
    @csrf

    <label for="email">email</label>
    <input type="email" name="email">
    @error('email')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    <br>
    <label for="password">password</label>
    <input type="password" name="password">
    @error('password')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    <br>
    <input type="submit" value="submit">
</form>