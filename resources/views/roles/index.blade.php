@extends('layouts.app')

@section('content')

    <div class="row" >
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Role</h2>
            </div>
            <div class="pull-right">
                @can('role-create')
                    <a class="btn btn-success" href="{{ route('roles.create') }}">New</a>
                @endcan
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <div class="container mt-5">
        <table class="table mt-4" id="role-table">
            <thead>
            <th>Id</th>
            <th>Name</th>
            <th width="40%">Action</th>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.0.js" integrity="sha256-r/AaFHrszJtwpe+tHyNi/XCfMxYpbsRg2Uqn0x3s2zc=" crossorigin="anonymous"></script>
    <script>
        $(function(){
            $('#role-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! route('roles.get') !!}',
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });
        });
        $('body').on('click', '.delete-post', function () {
            var role_id = $(this).data("id");
            var tab=$('#role-table').DataTable();
            confirm("Are You sure want to delete !");

            $.ajax({
                method: "DELETE",
                url: "roles/" + role_id,
                data: {
                    "id": role_id,
                    '_token': '{{ csrf_token() }}',
                },
                success: function () {
                    tab.draw();
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        });
    </script>
@endsection
