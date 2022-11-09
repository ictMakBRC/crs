@extends('layouts.adminpages')

@section('content')
 <div class="row">
    <div class="col-12">
        <div class="card">
        <div class="card-header pt-0">
         <h1 class="h2">Roles</h1>
         <a class="btn btn-sm btn-primary" href="{{route('roles.create')}}">Add New Role</a>
        </div>
      <h2>{{$title}}</h2>
      <div class="card-body">
          <div class="table-responsive">
           <table id="example1" class="table w-100 nowrap">
          <thead>
            <tr>
              <th>Role Display</th>
              <th>Role Description</th>
              <th>Role</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
              @foreach($roles as $role)
              <tr>
                <td>{{ $role->display_name }}</td>
                <td>{{ $role->description }}</td>
                <td>{{ $role->name }}</td>
                <td>
                  <div class="btn-group">
                    <a  href="{{ route('roles.edit', [$role->id]) }}" class="btn btn-info btn-xs"><i class="mdi mdi-pencil" title="Edit"></i> </a>
                    <a  href="{{ route('roles.show', [$role->id]) }}" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure you want to delete?');"><i class="mdi mdi-delete" title="Delete"></i> </a>
                  </div>
                </td>
              </tr>
              @endforeach
          </tbody>
        </table>
        {{ $roles->links() }}
      </div>
    </div>
  </div>
</div>
@endsection