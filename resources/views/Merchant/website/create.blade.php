<form action="{{route('merchant.website.store')}}" method="post">
    @csrf

    <label for="Website Name">Website Name:</label>
    <input type="text" name="name">
    @error('name')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    <br>
    <label for="Website Domain">Website Domain:</label>
    <input type="text" name="domain">
    @error('domain')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    <br>
    <input type="submit" value="create">
</form>