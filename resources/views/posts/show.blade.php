@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
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
                <div id="carouselExampleFade" class="carousel slide carousel-fade" data-ride="carousel">
                    <div class="carousel-inner">
                        @foreach($images as $image)
                            @if($loop->iteration==1)
                                <div class="item active">
                                    <img src="{{asset('files/'.$image->name.'')}}" alt="Los Angeles"
                                         style="width:100%;">
                                </div>
                            @else
                                <div class="item">
                                    <img src="{{asset('files/'.$image->name.'')}}" alt="Los Angeles"
                                         style="width:100%;">
                                </div>
                            @endif
                        @endforeach
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleFade" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleFade" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
                <hr>
            </div>
        </div>
        <div class="col-xs-8 col-sm-8 col-md-8">
            <div class="form-group">
                <label for="comment">Comment:</label>
                <form id="PostForm" name="PostForm" class="form-horizontal">
                    @csrf
                    <input type="hidden" name="id" id="id" value="{{$post->id}}">
                    <textarea class="form-control" name="comments" rows="5" id="comment" ></textarea>
                    <hr>
                    <button type="submit" class="btn btn-success" id="create" >create
                    </button>
                </form>
            </div>
        </div>
    </div>
        <div class="col-xs-4 col-sm-4 col-md-4" id="c">

        </div>
    </div>

    <div class="modal fade" id="ajaxModel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading"></h4>
                </div>
                <div class="modal-body">
                    <form id="commentForm" name="commentForm" class="form-horizontal">
                        @csrf
                        @method('put')
                        <input type="hidden" name="id1" id="id1">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Comment</label>
                            <div class="col-sm-12">
                                <textarea id="comment1" name="comment1"  placeholder="Enter Description" class="form-control"></textarea>
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
    <script src="https://code.jquery.com/jquery-3.5.0.js" integrity="sha256-r/AaFHrszJtwpe+tHyNi/XCfMxYpbsRg2Uqn0x3s2zc=" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <script>
        $('#create').click(function (e) {
            e.preventDefault();
            $.ajax({
                data: $('#PostForm').serialize(),
                url: "comments"+'/'+$('#id').val(),
                method:'post',
                dataType: 'json',
                success: function (data) {
                    $('#c').append('<div class='+data[0].id+'><hr><span>'+data[0].id+'</span> <hr><span>'+data[1]+'</span><br> <hr><p id='+data[0].id+'>'+data[0].comment+'</p><br> <a href="javascript:void(0)" data-toggle="tooltip"  data-id='+data[0].id+' data-original-title="Edit" class="edit btn btn-primary btn-sm editcomment">Edit</a><hr><a href="javascript:void(0)"  data-id='+data[0].id+' class="edit btn btn-primary btn-sm deletecomment">delete</a></div>');
                },
                error: function (data) {
                    console.log('Error:', data);
                    $('update').html('Save Changes');
                }
            });
        });
        $('body').on('click', '.editcomment', function () {
            var comment_id = $(this).data('id');
            $.ajax({
                url: "comments"+'/' + comment_id +'/edit',
                success: function (data) {
                    console.log('m');
                    $('#modelHeading').html("Edit comment");
                    $('#update').val("edit-comment");
                    $('#ajaxModel').modal('show');
                    $('#id1').val(data.id);
                    $('#comment1').val(data.comment);
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        });
        $('#update').click(function (e) {
            e.preventDefault();
            $.ajax({
                data: $('#commentForm').serialize(),
                url: "comments"+'/'+$('#id1').val(),
                method:'put',
                dataType: 'json',
                success: function (data) {
                    $('#ajaxModel').modal('hide');
                    $('#'+data.id1).html(data.comment1);
                },
                error: function (data) {
                    console.log('Error:', data);
                    $('update').html('Save Changes');
                }
            });
        });
        $('body').on('click','.deletecomment', function () {
            var comment_id = $(this).data("id");
            confirm("Are You sure want to delete !");
            $.ajax({
                type: "DELETE",
                url: "comments/"+comment_id,
                data: {
                    "id": comment_id,
                    '_token': '{{ csrf_token() }}',
                },
                success: function (data) {
                    alert(data.success);
                    $('.'+comment_id).remove();
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        });
    </script>

@endsection


