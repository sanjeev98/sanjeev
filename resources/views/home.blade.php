{{--<div>--}}
{{--    <ol style="block:inline">--}}
{{--        @foreach($users as $user)--}}
{{--        <li><h6>TITLE</h6><span>{{$user['title']}}</span></li>--}}
{{--        <li><h6>description</h6><span>{{$user['description']}}</span></li>--}}
{{--        <li><h6>posted_by</h6><span>{{$user['posted_by']}}</span></li>--}}
{{--        @endforeach--}}
{{--    </ol>--}}

{{--</div>--}}
@extends('layout')

@section('content')
    <table class="table table-bordered" id="users-table">
        <thead>
        <tr>
            <th>Id</th>
            <th>title</th>
            <th>description</th>
            <th>posted by</th>
            <th>Created At</th>
            <th>Updated At</th>
        </tr>
        </thead>
    </table>
@stop

@push('scripts')
    <script>
        $(function() {
            $('#users-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! route('get.users') !!}',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'title', name: 'title' },
                    { data: 'description', name: 'description' },
                    { data: 'posted_by', name: 'posted_by' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'updated_at', name: 'updated_at' }
                ]
            });
        });
    </script>
@endpush
