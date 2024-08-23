<html>

<head></head>

<body>
    <form
        action="{{route('website.admin.catalog.attribute.update', ['website' => $website, 'attribute' => $attribute->id])}}"
        method="Post">
        @csrf
        @method('put')
        <label for="name">name</label>
        <input type="text" name="name" value="{{$attribute->name}}" id="name ">
        <br>
        @error('name')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <label for="name">description</label>
        <input type="text" name="description" value="{{$attribute->description}}" id="description ">
        <br>
        @error('description')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <br>

        <h1>Attribute Elements</h1>
        @foreach ($options as $option)
            <div class="options" id="attribute_options">
                <div class="container" id="attribute_option">
                    <label for="name">option_name</label>
                    <input type="text" name="option_name[]" id="option_name" value="{{$option->name}}">
                    <br>
                    @error('option_name')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <br>
                    <br>
                </div>
            </div>

        @endforeach
        <button id="add_option">add</button>
        <input type="submit" value="update">
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