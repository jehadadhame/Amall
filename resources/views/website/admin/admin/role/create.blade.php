<html>

<head></head>

<body>
    <form action="{{route('website.admin.admins.role.store', ['website' => $website])}}" method="Post">
        @csrf

        <label for="name">name</label>
        <input type="text" name="name" id="name ">
        <br>
        @error('name')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <label for="name">description</label>
        <input type="text" name="description" id="description ">
        <br>
        @error('description')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <button id="check_all">check all</button>
        @foreach ($groups as $groupName => $group) 
            <h1>{{$groupName}}</h1>
            @foreach ($group as $supgroupName => $permissions)
                <ul>
                    <li>
                        <h2>{{$supgroupName}}</h2>
                    </li>
                    <ul>
                        <li>
                            @foreach ($permissions as $permission)
                                <label for="{{$permission->name}}">{{$permission->name}}</label>
                                <input type="checkbox" name="{{$permission->id}}" id="{{$permission->id}}">
                            @endforeach
                        </li>
                    </ul>
                </ul>
            @endforeach
        @endforeach
        <br>
        <input type="submit" value="create">
    </form>
    <script>
        var checkall = document.getElementById('check_all');

        checkall.addEventListener('click', function (event) {
            event.preventDefault();
            var checkboxes = document.querySelectorAll('input[type="checkbox"]');
            checkboxes.forEach(function (checkbox) {
                checkbox.checked = true;
            });
        });


    </script>
</body>

</html>