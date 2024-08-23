<html>

<head>

    <style>
        /* Apply to the whole page */
        html,
        body {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f4;
        }

        /* Container for the table */
        .table-container {
            width: 100%;
            height: 100%;
            padding: 20px;
            box-sizing: border-box;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Table style */
        table {
            margin-top: 20px;
            width: 100%;
            max-width: 1200px;
            height: auto;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
        }

        /* Table header style */
        th {
            background-color: #007BFF;
            color: white;
            padding: 15px;
            text-align: left;
            font-size: 1rem;
        }

        /* Table cell style */
        td {
            padding: 15px;
            border-bottom: 1px solid #dddddd;
            text-align: left;
            font-size: 0.95rem;
        }

        /* Alternating row colors */
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        /* Responsive font size */
        th,
        td {
            font-size: 1rem;
        }

        /* Optional: Add hover effect */
        tr:hover {
            background-color: #e9e9e9;
        }

        /* Adjust for smaller screens */
        @media screen and (max-width: 768px) {
            table {
                width: 100%;
            }

            th,
            td {
                font-size: 0.85rem;
                padding: 10px;
            }
        }
    </style>
</head>

<body>
    <a href="{{route('website.admin.catalog.index', ['website' => $website])}}">back</a>
    <a href="{{route('website.admin.catalog.attribute.create', ['website' => $website])}}">Create</a>

    <table>

        <thead>
            <th>
                name
            </th>
            <th>
                description
            </th>
            <th>
                type
            </th>
            <th>
                created_At
            </th>
            <th>
                Update_At
            </th>
            <th>
                Actions
            </th>
        </thead>

        <tbody>
            @foreach ($attributes as $attribute)
                <tr>
                    <td>
                        {{$attribute->name}}
                    </td>
                    <td>
                        {{$attribute->description}}
                    </td>
                    <td>
                        {{$attribute->type}}
                    </td>
                    <td>
                        {{$attribute->created_at}}
                    </td>
                    <td>
                        {{$attribute->updated_at}}
                    </td>
                    <td>
                        <div class="continaer">

                            <form
                                action="{{route('website.admin.catalog.attribute.destroy', ['website' => $website, 'attribute' => $attribute->id])}}"
                                method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit">delete</button>
                            </form>
                            <a
                                href="{{route('website.admin.catalog.attribute.edit', ['website' => $website, 'attribute' => $attribute->id])}}">edit
                            </a>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>

    </table>

    <br><br><br>
    <table style="margin-top=200px" margin-top="200px">

        <thead>
            <th>
                name
            </th>
            <th>
                description
            </th>
            <th>
                created_At
            </th>
            <th>
                Update_At
            </th>
            <th>
                Actions
            </th>
        </thead>
        <tbody>
            @foreach ($trashs as $trash)
                <tr>
                    <td>
                        {{$trash->name}}
                    </td>
                    <td>
                        {{$trash->description}}
                    </td>

                    <td>
                        {{$trash->created_at}}
                    </td>
                    <td>
                        {{$trash->updated_at}}
                    </td>
                    <td>
                        <div class="continaer">
                            <form
                                action="{{route('website.admin.catalog.attribute.forcedelete', ['website' => $website, 'id' => $trash->id,])}}"
                                method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit">forcedelete</button>
                            </form>
                            <form
                                action="{{route('website.admin.catalog.attribute.restore', ['website' => $website, 'id' => $trash->id,])}}"
                                method="POST">
                                @method('put')
                                @csrf
                                <button type="submit">restore</button>
                            </form>

                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>

    </table>
</body>

</html>