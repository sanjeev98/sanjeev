@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Users Management</h2>
            </div>
            <div class="pull-right">
                @can('user-create')
                    <a class="btn btn-success" href="{{ route('users.create') }}"> Create New User</a>
                @endcan
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <table class="table table-bordered" id="role-table">
        <thead>
        <th>Name</th>
        <th>Email</th>
        <th>Roles</th>
        <th width="280px">Action</th></thead>
        <tbody>
        </tbody>
    </table>
    <script src="https://code.jquery.com/jquery-3.5.0.js" integrity="sha256-r/AaFHrszJtwpe+tHyNi/XCfMxYpbsRg2Uqn0x3s2zc=" crossorigin="anonymous"></script>
    <script>
        $(function(){
            $('#role-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! route('roles.table') !!}',
                columns: [
                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'name'},
                    {data: 'role',
                        "render": function(data, type, row, meta){
                            data = '<label class="badge badge-success">+ data +</label>';
                            return data;
                        }
                    },
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });
        });
        $('body').on('click', '.delete-Post', function () {
            var role_id = $(this).data("id");
            var tab=$('#role-table').DataTable();
            confirm("Are You sure want to delete !");

            $.ajax({
                method: "DELETE",
                url: "users/"+role_id,
                data: {
                    "id": role_id,
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
