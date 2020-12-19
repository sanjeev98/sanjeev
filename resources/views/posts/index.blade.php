@extends('layouts.app')

@section('title')
    Posts
@endsection

@section('content')

    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Posts</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('posts.create') }}">New</a>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <div class="container mt-5">
        <table class="table mt-4" id="post-table">
            <thead>
            <th>id</th>
            <th>user_id</th>
            <th>title</th>
            <th>description</th>
            <th>posted_by</th>
            <th>created_at</th>
            <th>Action</th>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

        <script src="https://code.jquery.com/jquery-3.5.0.js" integrity="sha256-r/AaFHrszJtwpe+tHyNi/XCfMxYpbsRg2Uqn0x3s2zc=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <script>
            $(function(){
                $('#post-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: '{!! route('posts.index') !!}',
                    columns: [
                        {data: 'id', name: 'id'},
                        {data: 'user_id', name: 'user_id'},
                        {data: 'title', name: 'title'},
                        {data: 'description', name: 'description'},
                        {data: 'posted_by', name: 'posted_by'},
                        {data: 'created_at', name: 'created_at'},
                    ]

                });

            });
        </script>
@endsection
