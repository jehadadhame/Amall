<h1>Admin Dashboard</h1>
<form action="{{route('website.admin.auth.logout', ['website' => $website])}}" method="post">
    @csrf
    <input type="submit" value="logout">
</form>



<a href="{{route('website.admin.catalog.index', ['website' => $website])}}">catalog</a>
<br>
<a href="{{route('website.admin.admins.role.index', ['website' => $website])}}">Roles</a>