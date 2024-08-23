<html>

<head></head>

<body>
    <form action="{{route('website.admin.admins.role.update', ['website' => $website, 'role' => $role->id])}}"
        method="Post">
        @csrf
        @method('PUT')
        <label for="name">name</label>
        <input type="text" name="name" value="{{$role->name}}" id="name ">
        <br>
        @error('name')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <label for="name">description</label>
        <input type="text" name="description" value="{{$role->description}}" id="description ">
        <br>
        @error('description')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror


        @foreach ($permissions as $permission)
            <label for="{{$permission->name}}">{{$permission->name}}</label>
            <input type="checkbox" name="{{$permission->id}}" id="{{$permission->id}}" {{in_array($permission->id, $per) ? 'checked' : ''}}>
        @endforeach

        <br>
        <input type="submit" value="update">
    </form>
</body>

</html>