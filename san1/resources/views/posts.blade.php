<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <title>Hello, world!</title>
</head>
<body>

<section style="padding-top:60px;">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                     POST <a href="/add-post" class="btn btn-success">Create post</a>
                </div>
                <div class="card-body">
                    @if(Session::has('post_deleted'))
                        <div class="alert alert-success" role="alert">
                            {{Session::get('post_deleted')}}
                        </div>
                    @endif
                    <table class="table table-striped">
                        <tr>
                            <th>id</th>
                            <th>title</th>
                            <th>user_id </th>
                            <th>description </th>
                            <th>posted_by</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th width="280px">Action</th>
                        </tr>
                        @foreach ($posts as $post)
                            <tr>
                                <td>{{ $post->id }}</td>
                                <td>{{ $post->title }}</td>
                                <td>{{ $post->user_id }}</td>
                                <td>{{ $post->description }}</td>
                                <td>{{ $post->posted_by }}</td>
                                <td>{{ $post->created_at }}</td>
                                <td>{{$post->updated_at }}</td>
                                <td> <a href="/posts/{{$post->id}}" class="btn btn-info">Details</a></td>
                                <td> <a href="/edit-post/{{$post->id}}" class="btn btn-success">Edit</a></td>
                                <td><a href="/delete-post/{{$post->id}}" class="btn btn-danger">Delete</a></td>
                            </tr>


                        @endforeach
                    </table>

                </div>
            </div>
        </div>
    </div>

</section>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

<!-- Option 2: jQuery, Popper.js, and Bootstrap JS
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
-->
</body>
</html>
