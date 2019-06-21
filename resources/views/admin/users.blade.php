@extends('layouts.master')

@section('content')
    <div class="content-wrapper">
        <div class="page-header page-header-light">
            <div class="page-header-content header-elements-md-inline">
                <div class="page-title d-flex">
                    <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">{{__('page.home')}}</span> - Users</h4>
                    <a href="index.html#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
                </div>

                <div class="header-elements d-none">
                    <div class="d-flex justify-content-center">
                    </div>
                </div>
            </div>

            <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
                <div class="d-flex">
                    <div class="breadcrumb">
                        <a href="{{url('/')}}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> {{__('page.home')}}</a>
                        <span class="breadcrumb-item active">Users</span>
                    </div>
                </div>
            </div>
        </div>
        @php
            $role = Auth::user()->role->slug;
        @endphp
        <div class="content">
            <div class="card">
                <div class="card-header">
                    @if ($role == 'admin')
                        <button type="button" class="btn btn-primary float-right" id="btn-add"><i class="icon-user-plus mr-2"></i> {{__('page.add_new')}}</button>
                    @endif
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr class="bg-blue">
                                    <th style="width:30px;">#</th>
                                    <th>Name</th>
                                    <th>Role</th>
                                    <th>Phone Number</th>
                                    @if ($role == 'admin')
                                        <th>Action</th>                                        
                                    @endif
                                </tr>
                            </thead>
                            <tbody>                                
                                @foreach ($data as $item)
                                    <tr>
                                        <td>{{ (($data->currentPage() - 1 ) * $data->perPage() ) + $loop->iteration }}</td>
                                        <td class="username">{{$item->name}}</td>
                                        <td class="role" data-id="{{$item->role_id}}">{{$item->role->name}}</td>
                                        <td class="phone">{{$item->phone_number}}</td>
                                        @if ($role == 'admin')
                                            <td class="py-1">
                                                <a href="#" class="btn bg-blue btn-icon rounded-round btn-edit" data-id="{{$item->id}}"  data-popup="tooltip" title="Edit" data-placement="top"><i class="icon-pencil7"></i></a>
                                                <a href="{{route('user.delete', $item->id)}}" class="btn bg-danger text-pink-800 btn-icon rounded-round ml-2" data-popup="tooltip" title="Delete" data-placement="top" onclick="return window.confirm('Are you sure?')"><i class="icon-trash"></i></a>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="clearfix mt-1">
                            <div class="float-left" style="margin: 0;">
                                <p>Total <strong style="color: red">{{ $data->total() }}</strong> Items</p>
                            </div>
                            <div class="float-right" style="margin: 0;">
                                {!! $data->appends([])->links() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>                
    </div>

    <!-- The Modal -->
    <div class="modal fade" id="addModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{__('page.add_new_user')}}</h4>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <form action="" id="create_form" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label">{{__('page.username')}}</label>
                            <input class="form-control" type="text" name="name" id="name" placeholder="{{__('page.username')}}">
                            <span id="name_error" class="invalid-feedback">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="form-group">
                            <label class="control-label">{{__('page.phone_number')}}</label>
                            <input class="form-control" type="text" name="phone_number" id="phone" placeholder="{{__('page.phone_number')}}">
                            <span id="phone_error" class="invalid-feedback">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="form-group">
                            <label class="control-label">{{__('page.role')}}</label>
                            <select name="role" id="role" class="form-control">
                                <option value="1">Admin</option>
                                <option value="2">User</option>
                            </select>
                            <span id="role_error" class="invalid-feedback">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="form-group password-field">
                            <label class="control-label">{{__('page.password')}}</label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="{{__('page.password')}}">
                            <span id="password_error" class="invalid-feedback">
                                <strong></strong>
                            </span>
                        </div>    
                        <div class="form-group password-field">
                            <label class="control-label">{{__('page.password_confirm')}}</label>
                            <input type="password" name="password_confirmation" id="confirmpassword" class="form-control" placeholder="{{__('page.password_confirm')}}">
                            <span id="confirmpassword_error" class="invalid-feedback">
                                <strong></strong>
                            </span>
                        </div>
                    </div>    
                    <div class="modal-footer">
                        <button type="button" id="btn_create" class="btn btn-primary btn-submit"><i class="icon-paperplane"></i>&nbsp;{{__('page.save')}}</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="icon-close2"></i>&nbsp;{{__('page.save')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{__('page.edit_user')}}</h4>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <form action="" id="edit_form" method="post">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id" id="edit_id" />                    
                        <div class="form-group">
                            <label class="control-label">{{__('page.username')}}</label>
                            <input class="form-control" type="text" name="name" id="edit_name" placeholder="{{__('page.username')}}">
                            <span id="edit_name_error" class="invalid-feedback">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="form-group">
                            <label class="control-label">{{__('page.phone_number')}}</label>
                            <input class="form-control" type="text" name="phone" id="edit_phone" placeholder="{{__('page.phone_number')}}">
                            <span id="edit_phone_error" class="invalid-feedback">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="form-group password-field">
                            <label class="control-label">{{__('page.new_password')}}</label>
                            <input type="password" name="password" id="edit_password" class="form-control" placeholder="{{__('page.new_password')}}">
                            <span id="edit_password_error" class="invalid-feedback">
                                <strong></strong>
                            </span>
                        </div>    
                        <div class="form-group password-field">
                            <label class="control-label">{{__('page.password_confirm')}}</label>
                            <input type="password" name="password_confirmation" id="edit_confirmpassword" class="form-control" placeholder="{{__('page.password_confirm')}}">
                            <span id="edit_confirmpassword_error" class="invalid-feedback">
                                <strong></strong>
                            </span>
                        </div>
                    </div>    
                    <div class="modal-footer">
                        <button type="button" id="btn_update" class="btn btn-primary btn-submit"><i class="icon-paperplane"></i>&nbsp;{{__('page.save')}}</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="icon-close2"></i>&nbsp;{{__('page.close')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script>
    $(document).ready(function () {
        
        $("#btn-add").click(function(){
            $("#create_form input.form-control").val('');
            $("#create_form .invalid-feedback strong").text('');
            $("#addModal").modal();
        });

        $("#btn_create").click(function(){          
            $.ajax({
                url: "{{route('user.create')}}",
                type: 'post',
                dataType: 'json',
                data: $('#create_form').serialize(),
                success : function(data) {
                    if(data == 'success') {
                        alert('Created successfully.');
                        window.location.reload();
                    }
                    else if(data.message == 'The given data was invalid.') {
                        alert(data.message);
                    }
                },
                error: function(data) {
                    console.log(data.responseJSON);
                    if(data.responseJSON.message == 'The given data was invalid.') {
                        let messages = data.responseJSON.errors;
                        if(messages.name) {
                            $('#name_error strong').text(data.responseJSON.errors.name[0]);
                            $('#name_error').show();
                            $('#create_form #name').focus();
                        }
                        
                        if(messages.role) {
                            $('#role_error strong').text(data.responseJSON.errors.role[0]);
                            $('#role_error').show();
                            $('#create_form #role').focus();
                        }

                        if(messages.password) {
                            $('#password_error strong').text(data.responseJSON.errors.password[0]);
                            $('#password_error').show();
                            $('#create_form #password').focus();
                        }

                        if(messages.phone_number) {
                            $('#phone_error strong').text(data.responseJSON.errors.phone_number[0]);
                            $('#phone_error').show();
                            $('#create_form #phone').focus();
                        }
                    }
                }
            });
        });

        $(".btn-edit").click(function(){
            let user_id = $(this).attr("data-id");
            let username = $(this).parents('tr').find(".username").text().trim();
            let phone = $(this).parents('tr').find(".phone").text().trim();

            $("#edit_form input.form-control").val('');
            $("#editModal #edit_id").val(user_id);
            $("#editModal #edit_name").val(username);
            $("#editModal #edit_phone").val(phone);

            $("#editModal").modal();
        });

        $("#btn_update").click(function(){
            $.ajax({
                url: "{{route('user.edit')}}",
                type: 'post',
                dataType: 'json',
                data: $('#edit_form').serialize(),
                success : function(data) {
                    console.log(data);
                    if(data == 'success') {
                        alert('Updated successfully.');
                        window.location.reload();
                    }
                    else if(data.message == 'The given data was invalid.') {
                        alert(data.message);
                    }
                },
                error: function(data) {
                    console.log(data.responseJSON);
                    if(data.responseJSON.message == 'The given data was invalid.') {
                        let messages = data.responseJSON.errors;
                        if(messages.name) {
                            $('#edit_name_error strong').text(data.responseJSON.errors.name[0]);
                            $('#edit_name_error').show();
                            $('#edit_form #edit_name').focus();
                        }

                        if(messages.password) {
                            $('#edit_password_error strong').text(data.responseJSON.errors.password[0]);
                            $('#edit_password_error').show();
                            $('#edit_form #edit_password').focus();
                        }

                        if(messages.phone) {
                            $('#edit_phone_error strong').text(data.responseJSON.errors.phone[0]);
                            $('#edit_phone_error').show();
                            $('#edit_form #edit_phone').focus();
                        }
                    }
                }
            });
        });

    });
</script>
@endsection
