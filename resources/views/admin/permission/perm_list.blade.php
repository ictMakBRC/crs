@extends('layouts.adminpages')

@section('content')
 <div class="row">
    <div class="col-12">
        <div class="card">
        <div class="card-header pt-0">
      <a class="btn btn-sm btn-primary" href="{{route('permission.create')}}">Add New Permission</a>
      <h2>{{$title}}</h2>
      </div>
      <div class="card-body">
      <div class="table-responsive">
        <table id="example1" class="table w-100 nowrap">
          <thead>
            <tr>
              <th>Name</th>
              <th>Display Name</th>
              <th>Description</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
              @foreach($permissions as $row)
              <tr>
                <td>{{ $row->name }}</td>
                <td>{{ $row->display_name }}</td>
                <td>{{ $row->description }}</td>
                <td>
                  <div class="btn-group">
                    <a class="btn btn-primary" href="{{ route('permission.edit', [$row->id]) }}" class="btn btn-info btn-xs"><i class="mdi mdi-pencil" title="Edit"></i> </a>
                    <a onclick="return confirm('Are you sure you want to delete?');" href="{{ route('permission.show', [$row->id]) }}" class="btn btn-danger btn-xs"><i class="mdi mdi-delete" title="Delete"></i> </a>
                  </div>
                </td>
              </tr>
              @endforeach
          </tbody>
        </table>
        {{ $permissions->links() }}
      </div>
    </div>
    </div>
  </div>
</div>

@endsection