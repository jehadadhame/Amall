<form action="{{route('website.admin.catalog.category.update', ['website' => $website, 'category' => $id])}}"
    method="post">
    @csrf
    @method('put')
    <label for="name">name</label>
    <input type="text" name="name" value="{{$category->name}}" id="name">
    <br>
    <label for="slug">slug</label>
    <input type="text" name="slug" value="{{$category->slug}}" id="slug">
    <br>
    <label for="parent_id">parent category</label>
    <select name="parent_id" id="parent_id">
        @foreach ($categories as $cat)
            @if ($cat->id != $category->id)
                <option value="{{$cat->id}}" {{$category->parent_id == $cat->id ? "selected" : ""}}>{{$cat->name}}</option>
            @endif
        @endforeach
    </select>
    <br>
    <input type="submit" value="edit">
</form>