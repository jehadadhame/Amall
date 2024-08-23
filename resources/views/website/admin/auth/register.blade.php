<form action="{{route('website.admin.auth.register', ['website' => $website])}}" method="post">
    @csrf
    <label for="name">name</label>
    <input type="text" name="name" id="name">
    <br>
    <label for="email">email</label>
    <input type="email" name="email" id="email">
    <br>
    <label for="phone">phone</label>
    <input type="phone" name="phone" id="phone">
    <br>
    <label for="role_id">role_id</label>
    <input type="text" name="role_id" id="role_id">
    <br>
    <label for="password">password</label>
    <input type="password" name="password" id="password">
    <br>
    <input type="submit" value="submit">
</form>