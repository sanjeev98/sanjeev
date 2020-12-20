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
                <a class="btn btn-success" href="{{ route('posts.create') }}"> Create New Post</a>
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
    <div class="modal fade" id="ajaxModel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading"></h4>
                </div>
                <div class="modal-body">
                    <form id="PostForm" name="PostForm" class="form-horizontal">
                        @csrf
                        @method('put')
                        <input type="hidden" name="id" id="id">
                        <div class="form-group">
                            <label for="title" class="col-sm-2 control-label">title</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="title" name="title"
                                       placeholder="Enter title" value="" maxlength="50" required="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">description</label>
                            <div class="col-sm-12">
                                <textarea id="description" name="description" required=""
                                          placeholder="Enter Description" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="posted_by" class="col-sm-2 control-label">posted_by</label>
                            <div class="col-sm-12">
                                <input type="email" class="form-control" id="posted_by" name="posted_by"
                                       placeholder="Enter posted_by" value="" maxlength="50" required="">
                            </div>
                        </div>
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary" id="update" value="create">Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.0.js"
            integrity="sha256-r/AaFHrszJtwpe+tHyNi/XCfMxYpbsRg2Uqn0x3s2zc=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
            integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
            crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
            integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
            crossorigin="anonymous"></script>
    <script>
        $(function () {
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
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });
        });
        $('body').on('click', '.editPost', function () {
            var user_id = $(this).data('id');
            $.ajax({
                url: "posts" + '/' + user_id + '/edit',
                success: function (data) {
                    $('#modelHeading').html("Edit Customer");
                    $('#update').val("edit-post");
                    $('#ajaxModel').modal('show');
                    $('#id').val(data.id);
                    $('#title').val(data.title);
                    $('#description').val(data.description);
                    $('#posted_by').val(data.posted_by);
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        });
        $('#update').click(function (e) {
            e.preventDefault();
            var tab = $('#post-table').DataTable();
            $.ajax({
                data: $('#PostForm').serialize(),
                url: "posts" + '/' + $('#id').val(),
                method: 'put',
                dataType: 'json',
                success: function (data) {
                    $('#PostForm').trigger("reset");
                    $('#ajaxModel').modal('hide');
                    tab.draw();
                },
                error: function (data) {
                    console.log('Error:', data);
                    $('update').html('Save Changes');
                }
            });
        });
        $('body').on('click', '.deletePost', function () {
            var post_id = $(this).data("id");
            var tab = $('#post-table').DataTable();
            confirm("Are You sure want to delete !");
            $.ajax({
                type: "DELETE",
                url: "posts/" + post_id,
                data: {
                    "id": post_id,
                    '_token': '{{ csrf_token() }}',
                },
                success: function (data) {
                    tab.draw();
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        });
    </script>
@endsection
