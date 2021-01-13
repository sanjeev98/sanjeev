@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Edit Role</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('roles.index') }}">Back</a>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('roles.update', $role->id) }}" method="post" enctype="multipart/form-data">
        @method('put')
        @csrf
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Name:</strong>
                    <input type="text" name="role" class="form-control" placeholder="role" minlength="3"
                        value="{{ $role->name }}"   maxlength="20" required>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Permission:</strong>
                    <br/>
                    @foreach($permissions as $permission)
                        <div class="form-check">
                            <label class="form-check-label">
                                @if(in_array($permission->id, $rolePermissions))
                                    <input type="checkbox" class="form-check-input" name="permissions[]"
                                           value="{{ $permission->id }}" checked>{{ $permission->name }}
                                @else
                                    <input type="checkbox" class="form-check-input" name="permissions[]"
                                           value="{{ $permission->id }}">{{ $permission->name }}
                                @endif
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>
@endsection
