<html>
<head>
    <style>

        #customers {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #customers td, #customers th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #customers tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #customers tr:hover {
            background-color: #ddd;
        }

        #customers th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #4CAF50;
            color: white;
        }
    </style>
</head>
<body>
<table id="customers">
    <tr>
        <th>posted by</th>
        <th>title</th>
        <th>description</th>
    </tr>
    @foreach($posts as $post)
        <tr>
            <tb>{{ $post->posted_by }}</tb>
            <tb>{{ $post->title }}</tb>
            <tb>{{ $post->description }}</tb>
        </tr>
    @endforeach
</table>
</body>
</html>
