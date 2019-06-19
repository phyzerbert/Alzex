@extends('layouts.master')

@section('content')
    <div class="content-wrapper">
        <div class="page-header page-header-light">
            <div class="page-header-content header-elements-md-inline">
                <div class="page-title d-flex">
                    <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Home</span> - Account</h4>
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
                        <a href="{{url('/')}}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
                        <span class="breadcrumb-item active">Account</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="container content">
            <div class="card">
                <div class="card-header">
                    <button type="button" class="btn btn-primary float-right" id="btn-add"><i class="icon-plus-circle2 mr-2"></i> Add Account</button>
                    <button type="button" class="btn btn-info float-right mr-2" id="btn-group"><i class="icon-folder-plus2 mr-2"></i> Add Group</button>
                </div>
                <div class="card-body sidebar-light">
                    <div class="row bg-blue-400 p-2">
                        <div class="col-md-4" style="padding-left:67px">Name</div>
                        <div class="col-md-6" style="padding-left:48px">Comment</div>
                        <div class="col-md-2" style="padding-left:38px">Action</div>
                    </div>
                    <ul class="nav nav-sidebar" data-nav-type="collapsible">
                        @foreach ($data as $item)
                            @php
                                $accounts = $item->accounts;
                            @endphp
                            <li class="nav-item nav-item-submenu">                                    
                                <div class="nav-link"><i class="icon-arrow-right15"></i>
                                    <div class="text-primary col-md-4 name">{{$item->name}}</div>
                                    <div class="text-info col-md-6 comment">{{$item->comment}}</div>
                                    <div class="text-primary col-md-2 list-icons" style="padding-left:36px;">
                                        <a href="#" class="list-icons-item text-primary-600 btn-group-edit" data-id="{{$item->id}}"><i class="icon-pencil7"></i></a>
                                        <a href="{{route('accountgroup.delete', $item->id)}}" class="list-icons-item text-danger-600" onclick="return window.confirm('Are you sure?')"><i class="icon-trash"></i></a>
                                    </div>
                                </div>
                                <ul class="nav nav-group-sub">
                                    @foreach ($accounts as $child)
                                        <li class="nav-item">
                                            <div class="nav-link"><i class="icon-arrow-right15"></i>
                                                <div class="d-none group" data-id="{{$item->id}}"></div>
                                                <div class="text-primary col-md-4 name">{{$child->name}}</div>
                                                <div class="text-info col-md-6 comment">{{$child->comment}}</div>
                                                <div class="text-primary col-md-2 list-icons">
                                                    <a href="#" class="list-icons-item text-primary-600 btn-edit" data-id="{{$child->id}}"><i class="icon-pencil7"></i></a>
                                                    <a href="{{route('account.delete', $child->id)}}" class="list-icons-item text-danger-600" onclick="return window.confirm('Are you sure?')"><i class="icon-trash"></i></a>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>                
    </div>

    <!-- The Modal -->
    <div class="modal fade" id="addModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add New Account</h4>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <form action="{{route('account.create')}}" id="create_form" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label">Name</label>
                            <input class="form-control" type="text" name="name" placeholder="Name">
                        </div>

                        <div class="form-group">
                            <label class="control-label">Group</label>
                            <select class="form-control" name="group">
                                <option value="">Select a group</option>
                                @foreach ($data as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>                                    
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="control-label">Comment</label>
                            <input class="form-control" type="text" name="comment" placeholder="Comment">
                        </div>
                    </div>    
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-submit"><i class="icon-paperplane"></i>&nbsp;Save</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="icon-close2"></i>&nbsp;Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="addgroupModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add New Group</h4>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <form action="{{route('accountgroup.create')}}" id="addgroup_form" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label">Name</label>
                            <input class="form-control" type="text" name="name" placeholder="Name">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Comment</label>
                            <input class="form-control" type="text" name="comment" placeholder="Comment">
                        </div>
                    </div>    
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-submit"><i class="icon-paperplane"></i>&nbsp;Save</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="icon-close2"></i>&nbsp;Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Account</h4>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <form action="{{route('account.edit')}}" id="edit_form" method="post">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id" class="id" />                    
                        <div class="form-group">
                            <label class="control-label">Name</label>
                            <input class="form-control name" type="text" name="name" placeholder="Name">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Group</label>
                            <select class="form-control group" name="group">
                                <option value="">Select a group</option>
                                @foreach ($data as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>                                    
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Comment</label>
                            <input class="form-control comment" type="text" name="comment" placeholder="Comment">
                        </div>
                    </div>
    
                    <div class="modal-footer">
                        <button type="submit" id="btn_update" class="btn btn-primary btn-submit"><i class="icon-paperplane"></i>&nbsp;Save</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="icon-close2"></i>&nbsp;Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="editgroupModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Group</h4>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <form action="{{route('accountgroup.edit')}}" id="edit_group_form" method="post">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" class="id" name="id" />                    
                        <div class="form-group">
                            <label class="control-label">Name</label>
                            <input class="form-control name" type="text" name="name" placeholder="Name">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Comment</label>
                            <input class="form-control comment" type="text" name="comment" placeholder="Comment">
                        </div>
                    </div>
    
                    <div class="modal-footer">
                        <button type="submit" id="btn_update" class="btn btn-primary btn-submit"><i class="icon-paperplane"></i>&nbsp;Save</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="icon-close2"></i>&nbsp;Close</button>
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
            $("#addModal").modal();
        });

        $("#btn-group").click(function(){
            $("#addgroup_form input.form-control").val('');
            $("#addgroupModal").modal();
        });

        $(".btn-edit").click(function(){
            let id = $(this).attr("data-id");
            let name = $(this).parents('.nav-link').find(".name").text().trim();
            let comment = $(this).parents('.nav-link').find(".comment").text().trim();
            let group = $(this).parents('.nav-link').find(".group").data('id');

            $("#edit_form input.form-control").val('');
            $("#editModal .id").val(id);
            $("#editModal .name").val(name);
            $("#editModal .group").val(group);
            $("#editModal .comment").val(comment);

            $("#editModal").modal();
        });

        $(".btn-group-edit").click(function(){
            let id = $(this).attr("data-id");
            let name = $(this).parents('.nav-link').find(".name").text().trim();
            let comment = $(this).parents('.nav-link').find(".comment").text().trim();

            $("#edit_group_form input.form-control").val('');
            $("#edit_group_form .id").val(id);
            $("#edit_group_form .name").val(name);
            $("#edit_group_form .comment").val(comment);

            $("#editgroupModal").modal();
        });

    });
</script>
@endsection
