@extends('layouts.master')

@section('content')
    <div class="content-wrapper">
        <div class="page-header page-header-light">
            <div class="page-header-content header-elements-md-inline">
                <div class="page-title d-flex">
                    <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">{{__('page.home')}}</span> - Category</h4>
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
                        <span class="breadcrumb-item active">Catetory</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="container content">
            <div class="card">
                <div class="card-header">
                    <button type="button" class="btn btn-primary float-right" id="btn-add"><i class="icon-user-plus mr-2"></i> Add New</button>
                </div>
                <div class="card-body sidebar-light">
                    <ul class="nav nav-sidebar" data-nav-type="collapsible">
                        @foreach ($data as $item)
                            @php
                                $children = $item->children;
                                $parent = $item->parent;
                                // dump($children);
                                // dump($parent);
                            @endphp
                            @if (!$parent && $children->isEmpty())
                                <li class="nav-item">
                                    <a href="#" class="nav-link"><i class="icon-arrow-right15"></i>{{$item->name}}</a>
                                </li>
                            @endif
                            @if (!$parent && $children->isNotEmpty())
                                <li class="nav-item nav-item-submenu">                                    
                                    <a href="#" class="nav-link"><i class="icon-arrow-right15"></i> {{$item->name}}</a>
                                    <ul class="nav nav-group-sub">
                                        @foreach ($children as $child)
                                            <li class="nav-item"><a href="#" class="nav-link"><i class="icon-arrow-right15"></i> {{$child->name}}</a></li>
                                        @endforeach
                                    </ul>
                                </li>
                            @endif
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
                    <h4 class="modal-title">Add New Category</h4>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <form action="{{route('category.create')}}" id="create_form" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label">Name</label>
                            <input class="form-control" type="text" name="name" placeholder="Name">
                        </div>

                        <div class="form-group">
                            <label class="control-label">Parent</label>
                            <select class="form-control" name="parent">
                                <option value="">Select parent category</option>
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
    <div class="modal fade" id="editModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Category</h4>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <form action="" id="edit_form" method="post">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id" id="edit_id" />                    
                        <div class="form-group">
                            <label class="control-label">Name</label>
                            <input class="form-control" type="text" name="name" id="edit_name" placeholder="Name">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Comment</label>
                            <input class="form-control" type="text" name="comment" id="edit_phone" placeholder="Comment">
                        </div>
                    </div>
    
                    <div class="modal-footer">
                        <button type="button" id="btn_update" class="btn btn-primary btn-submit"><i class="icon-paperplane"></i>&nbsp;Save</button>
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
            $("#create_form .invalid-feedback strong").text('');
            $("#addModal").modal();
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

    });
</script>
@endsection
