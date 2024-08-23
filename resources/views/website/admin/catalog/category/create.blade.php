<form action="{{route('website.admin.catalog.category.store', ['website' => $website])}}" method="post">
    @csrf
    <label for="name">name</label>
    <input type="text" name="name" id="name">
    @error('name')
        <div class="alert alert-danger">{{$message}}</div>
    @enderror
    <br>
    <label for="slug">slug</label>
    <input type="text" name="slug" id="slug">
    @error('slug')
        <div class="alert alert-danger">{{$message}}</div>
    @enderror
    <br>
    <label for="parent_id">parent category</label>
    <select name="parent_id" id="parent_id">
        @foreach ($categories as $cat)
            <option value="{{$cat->id}}">{{$cat->name}}</option>
        @endforeach
    </select>
    @error('parent_id')
        <div class="alert alert-danger">{{$message}}</div>
    @enderror
    <br>
    <input type="submit" value="create">
</form>