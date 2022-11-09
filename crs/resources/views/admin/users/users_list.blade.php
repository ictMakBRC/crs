@extends('layouts.adminpages')

@section('content')
   
 <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header pt-0">
         <h1 class="h2">Users</h1>
        
      <a class="btn btn-sm btn-primary" href="{{route('users.index')}}">Add New User</a>
      <h2>{{$title}}</h2>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table id="example1" class="table w-100 nowrap">
          <thead>
            <tr>
              <th>Username</th>
              <th>Email</th>
              <th>Role</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
              @foreach($users as $user)
                  <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                    @foreach($user->roles as $r)
                        {{$r->display_name}}
                    @endforeach
                    </td>
                    <td>
                      <div class="btn-group">
                        <a  href="{{ route('assignment.edit', [$user->id]) }}" class="btn btn-info btn-xs"><i class="mdi mdi-pencil" title="Role"></i> </a>
                        <a onclick="return confirm('Are you sure you want to delete?');" href="{{ route('assignment.show', [$user->id]) }}" class="btn btn-danger btn-xs"><i class="mdi-mdi-delete" title="Delete"></i> </a>
                      </div>
                    </td>
                  </tr>
                  @endforeach
          </tbody>
        </table>
        {{ $users->links() }}
      </div>
    </div>
    </div>
  </div>
</div>
@endsection