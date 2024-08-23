<form action="{{route('merchant.website.store')}}" method="post">
    @csrf
    <label for="Website Name:"></label>
    <br>
    <input type="text" name="name" value="{{$website->name}}">
    <label for="Website Domain:"></label>
    <br>
    <input type="text" name="domain" value="{{$website->domain}}">
    <input type="submit" value="create">
</form>