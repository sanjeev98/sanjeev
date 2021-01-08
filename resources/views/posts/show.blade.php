@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-lg-10 margin-tb">
            <div class="pull-left">
                <h2>Post</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('posts.index') }}"> Back</a>
            </div>
        </div>
    </div>
    <hr>
    <div class="container">
        <div class="row">
            <div class="col-xs-10 col-sm-10 col-md-10">
                <div class="form-group">
                    <strong>{{ $post->title }}</strong>
                </div>
                <hr>
            </div>
            <div class="col-xs-10 col-sm-10 col-md-10">
                <div class="form-group">
                    <strong>{{ $post->posted_by }}</strong>
                </div>
                <hr>
            </div>
            <div class="col-xs-10 col-sm-10 col-md-10">
                <div class="form-group">
                    @if(count($images) > 0)
                        <div id="images" class="carousel slide carousel-fade" data-ride="carousel">
                            <div class="carousel-inner">
                                @foreach($images as $image)
                                    @if($loop->iteration == 1)
                                        <div class="carousel-item active">
                                            <img src="{{ asset('files/' . $image->name . '') }}" alt="Los Angeles"
                                                 style="width: 100%;">
                                        </div>
                                    @else
                                        <div class="carousel-item">
                                            <img src="{{ asset('files/' . $image->name . '') }}" alt="Los Angeles"
                                                 style="width: 100%;">
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                            <a class="carousel-control-prev" href="#images" role="button"
                               data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#images" role="button"
                               data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    @endif
                    <hr>
                </div>
            </div>
            <div class="col-xs-8 col-sm-8 col-md-8">
                <div class="form-group">
                    <label for="comment">Comment:</label>
                    <form id="post-form" name="post-form" class="form-horizontal">
                        @csrf
                        <input type="hidden" name="post_id" id="id" value="{{ $post->id }}">
                        <textarea class="form-control" name="comment" rows="5" id="comment"></textarea>
                        <hr>
                        <button type="submit" class="btn btn-success" id="create">create
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-xs-4 col-sm-4 col-md-4" id="user-comment">
        </div>
    </div>
    <div class="modal fade" id="ajax-model" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="model-heading"></h4>
                </div>
                <div class="modal-body">
                    <form id="comment-form" name="comment-form" class="form-horizontal">
                        @csrf
                        @method('put')
                        <input type="hidden" name="id" id="update-id">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Comment</label>
                            <div class="col-sm-12">
                                <textarea id="update-comment" name="comment" placeholder="Enter Description"
                                          class="form-control"></textarea>
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
    <script>
        $('#create').click(function (e) {
            e.preventDefault();
            $.ajax({
                data: $('#post-form').serialize(),
                url: "comments",
                method: 'post',
                dataType: 'json',
                success: function (data) {
                    $('#user-comment').append('<div class=' + data[0].id + '><hr><span>' + data[0].id + '</span> <hr><span>' + data[1] + '</span><br> <hr><p id=' + data[0].id + '>' + data[0].comment + '</p><br> <a href="javascript:void(0)" data-toggle="tooltip"  data-id=' + data[0].id + ' data-original-title="Edit" class="edit btn btn-primary btn-sm edit-comment">Edit</a><hr><a href="javascript:void(0)"  data-id=' + data[0].id + ' class="edit btn btn-primary btn-sm delete-comment">delete</a></div>');
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        });
        $('body').on('click', '.edit-comment', function () {
            var comment_id = $(this).data('id');
            $.ajax({
                url: "comments" + '/' + comment_id + '/edit',
                success: function (data) {
                    $('#model-heading').html("Edit comment");
                    $('#update').val("edit-comment");
                    $('#ajax-model').modal('show');
                    $('#update-id').val(data.id);
                    $('#update-comment').val(data.comment);
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        });
        $('#update').click(function (e) {
            e.preventDefault();
            $.ajax({
                data: $('#comment-form').serialize(),
                url: "comments" + '/' + $('#update-id').val(),
                method: 'put',
                dataType: 'json',
                success: function (data) {
                    $('#ajaxModel').modal('hide');
                    $('#' + data.id).html(data.comment);
                },
                error: function (data) {
                    console.log('Error:', data);
                    $('update').html('Save Changes');
                }
            });
        });
        $('body').on('click', '.delete-comment', function () {
            var comment_id = $(this).data("id");
            confirm("Are You sure want to delete !");
            $.ajax({
                type: "DELETE",
                url: "comments/" + comment_id,
                data: {
                    "id": comment_id,
                    '_token': '{{ csrf_token() }}',
                },
                success: function (data) {
                    $('.' + comment_id).remove();
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        });
    </script>
@endsection


