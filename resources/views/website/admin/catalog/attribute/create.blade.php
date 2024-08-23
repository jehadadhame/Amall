<html>

<head></head>

<body>
    <form action="{{route('website.admin.catalog.attribute.store', ['website' => $website])}}" method="Post">
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
        <br>
        <label for="name">type</label>
        <select name="type" id="type">
            @foreach ($types as $type)
                <option value="{{$type}}">{{$type}}</option>
            @endforeach
        </select>
        <br>
        @error('type')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <br>

        <h1>Attribute Elements</h1>
        <div class="options" id="attribute_options">
            <div class="container" id="attribute_option">
                <label for="name">option_name</label>
                <input type="text" name="option_name[]" id="option_name ">
                <br>
                @error('option_name')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror

                <br>
                <br>
            </div>
        </div>
        <button id="add_option">add</button>
        <input type="submit" value="create">
    </form>
    <script>
        var counter = 0;
        var btn = document.getElementById('add_option')
        document.getElementById('add_option').addEventListener('click', function (event) {
            event.preventDefault();
            var container = document.getElementById('attribute_option');
            var attribute_options = document.getElementById('attribute_options');

            var clone = container.cloneNode(true);
            attribute_options.appendChild(clone)
        });


    </script>
</body>

</html>