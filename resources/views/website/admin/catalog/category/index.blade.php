<html>

<head>
    <style>
        .container {
            display: flex;
            width: 200px;
            justify-content: space-between;
        }
    </style>
</head>

<body>
    <a href="{{route('website.admin.catalog.index', ['website' => $website])}}">back</a>
    <a href="{{route('website.admin.catalog.category.create', ['website' => $website])}}">Create</a>
    @php
        echo $tree;
    @endphp
</body>

</html>