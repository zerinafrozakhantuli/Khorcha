@extends('layouts.admin')
@section('content')

<div class="row">
<div class="col-md-12">
<div class="card mb-3">
<div class="card-header">
  <div class="row">
      <div class="col-md-8 card_title_part">
          <i class="fab fa-gg-circle"></i>All User Information
      </div>  
      <div class="col-md-4 card_button_part">
          <a href="{{url('dashboard/user/add')}}" class="btn btn-sm btn-dark"><i class="fas fa-plus-circle"></i>Add User</a>
      </div>  
  </div>
</div>
<div class="card-body">
<table id="alltableinfo" class="table table-bordered table-striped table-hover custom_table">
    <thead class="table-dark">
      <tr>
        <th>Name</th>
        <th>Phone</th>
        <th>Email</th>
        <th>Username</th>
        <th>Role</th>
        <th>Photo</th>
        <th>Manage</th>
      </tr>
    </thead>
    <tbody>
      @foreach($allU as $all)
      <tr>
        <td>{{$all->name}}</td>
        <td>{{$all->phone}}</td>
        <td>{{$all->email}}</td>
        <td>{{$all->username}}</td>
        <td>{{$all->roleInfo->role_name}}</td>
        <td>
          @if($all->photo!='')
          <img height="30" src="{{asset('uploads/users/'.$all->photo)}}" alt="User Photo">
          @else
          <img height="30" src="{{asset('contents/admin')}}/images/avatar.png" alt="User Photo">
          @endif
        </td>
        <td>
            <div class="btn-group btn_group_manage" role="group">
              <button type="button" class="btn btn-sm btn-dark dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Manage</button>
              <ul class="dropdown-menu">
<li><a class="dropdown-item" href="{{url('dashboard/user/view/'.$all->slug)}}">View</a></li>
<li><a class="dropdown-item" href="{{url('dashboard/user/edit/'.$all->slug)}}">Edit</a></li>
<li><a class="dropdown-item" href="#" id="softDelete" data-bs-toggle="modal" data-bs-target="#softDeleteModal" data-id="{{$all->id}}" >Delete</a></li>

          </ul>
          </div>
        </td>
      </tr>
      @endforeach
        
    </tbody>
  </table>
</div>
<div class="card-footer">
  <div class="btn-group" role="group" aria-label="Button group">
    <button type="button" class="btn btn-sm btn-dark">Print</button>
    <button type="button" class="btn btn-sm btn-secondary">PDF</button>
    <button type="button" class="btn btn-sm btn-dark">Excel</button>
  </div>
</div>  
</div>
</div>
</div>

<!-- --modal delete--  -->

  <div class="modal fade" id="softDeleteModal" tabindex="-1" aria-labelledby="softDeleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="{{url('dashboard/user/softdelete')}}">
      @csrf
      
    <div class="modal-content modal_content">
      <div class="modal-header modal_header">
      <h1 class="modal-title modal_title" id="softDeleteModalLabel"><i class="fab fa-gg-circle"></i> Confirm Message</h1>
      </div>
      <div class="modal-body modal_body">
        Do U Really Want To Delete Data?
        <input type="hidden" name="modal_id" id="modal_id" />
      </div>
      <div class="modal-footer modal_footer">
        <button type="submit" class="btn btn-sm btn-success" >Confirm</button>
        <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal">close</button>
      </div>
    </div>
     </form>
  </div>
</div>

 @endsection
