<form action="{{route('merchant.auth.register')}}" method="POST">
    @csrf
    <label for="name">name: </label>
    <input type="text" name="name" id="name">
    @error('name')
        <div class="alert alert-danger">{{$message}}</div>
    @enderror
    <br>
    <label for="email">email: </label>
    <input type="email" name="email" id="email">
    @error('email')
        <div class="alert alert-danger">{{$message}}</div>
    @enderror
    <br>
    <label for="phone">phone: </label>
    <input type="phone" name="phone" id="phone">
    @error('phone')
        <div class="alert alert-danger">{{$message}}</div>
    @enderror
    <br>
    <label for="password">password: </label>
    <input type="password" name="password" id="password">
    @error('password')
        <div class="alert alert-danger">{{$message}}</div>
    @enderror
    <br>
    <input type="submit" value="submit">
</form>