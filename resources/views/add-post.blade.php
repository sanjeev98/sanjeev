<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
          integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <title>Hello, world!</title>
</head>
<body>
<section style="padding-top:60px;">
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset -md-3">
                <div class="card">
                    Add POST
                </div>
                <div class="card-body">
                    @if(Session::has('post_created'))
                        <div class="alert alert-success" role="alert">
                            {{session::get('post_created')}}
                        </div>
                    @endif
                    <form method="POST" action="{{route('post.create')}}">
                        @csrf
                        <div class="form-group">
                            <strong>title:</strong>
                            <input type="text" name="title" class="form-control" placeholder="title">
                        </div>
                        <div class="form-group">
                            <strong>description:</strong>
                            <textarea class="form-control" style="height:150px" name="description"
                                      placeholder="description"></textarea>
                        </div>
                        <div class="form-group">
                            <strong>posted-by:</strong>
                            <input type="text" name="posted_by" class="form-control" placeholder="posted_by">
                        </div>
                        <button type="submit" class="btn btn-success">Add Post</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx"
        crossorigin="anonymous"></script>
</body>
</html>
