@extends('layouts.master')

@section('content')
    <div class="content-wrapper">
        <div class="page-header page-header-light">
            <div class="page-header-content header-elements-md-inline">
                <div class="page-title d-flex">
                    <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">{{__('page.home')}}</span> - {{__('page.category')}}</h4>
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
                        <span class="breadcrumb-item active">{{__('page.category')}}</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="container content">
            <div class="card">
                <div class="card-header">
                    <button type="button" class="btn btn-primary float-right" id="btn-add"><i class="icon-plus-circle2 mr-2"></i> {{__('page.add_new')}}</button>
                </div>
                <div class="card-body">                    
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr class="bg-blue">
                                    <th style="width:30px;">#</th>
                                    <th>{{__('page.name')}}</th>
                                    <th>{{__('page.comment')}}</th>
                                    <th>{{__('page.action')}}</th>
                                </tr>
                            </thead>
                            <tbody>                                
                                @foreach ($data as $item)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td class="name">{{$item->name}}</td>
                                        <td class="comment">{{$item->comment}}</td>
                                        <td class="py-1">
                                            <a href="#" class="btn bg-blue btn-icon rounded-round btn-edit" data-id="{{$item->id}}"  data-popup="tooltip" title="{{__('page.edit')}}" data-placement="top"><i class="icon-pencil7"></i></a>
                                            <a href="{{route('category.delete', $item->id)}}" class="btn bg-danger text-pink-800 btn-icon rounded-round ml-2" data-popup="tooltip" title="{{__('page.delete')}}" data-placement="top" onclick="return window.confirm('{{__('page.are_you_sure')}}')"><i class="icon-trash"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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
                    <h4 class="modal-title">{{__('page.add_new')}}</h4>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <form action="{{route('category.create')}}" id="create_form" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label">{{__('page.name')}}</label>
                            <input class="form-control" type="text" name="name" placeholder="Name">
                        </div>

                        {{-- <div class="form-group">
                            <label class="control-label">Parent</label>
                            <select class="form-control" name="parent">
                                <option value="">Select parent category</option>
                                @foreach ($data as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>                                    
                                @endforeach
                            </select>
                        </div> --}}

                        <div class="form-group">
                            <label class="control-label">{{__('page.comment')}}</label>
                            <input class="form-control" type="text" name="comment" placeholder="Comment">
                        </div>
                    </div>    
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-submit"><i class="icon-paperplane"></i>&nbsp;{{__('page.save')}}</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="icon-close2"></i>&nbsp;{{__('page.close')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{__('page.edit')}}</h4>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <form action="{{route('category.edit')}}" id="edit_form" method="post">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" class="id" name="id" />                    
                        <div class="form-group">
                            <label class="control-label">{{__('page.name')}}</label>
                            <input class="form-control name" type="text" name="name" placeholder="{{__('page.name')}}">
                        </div>
                        <div class="form-group">
                            <label class="control-label">{{__('page.comment')}}</label>
                            <input class="form-control comment" type="text" name="comment" placeholder="{{__('page.comment')}}">
                        </div>
                    </div>
    
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-submit"><i class="icon-paperplane"></i>&nbsp;{{__('page.save')}}</button>
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


        $(".btn-edit").click(function(){
            let id = $(this).data("id");
            let name = $(this).parents('tr').find(".name").text().trim();
            let comment = $(this).parents('tr').find(".comment").text().trim();
            
            $("#edit_form input.form-control").val('');
            $("#edit_form .id").val(id);
            $("#edit_form .name").val(name);
            $("#edit_form .comment").val(comment);

            $("#editModal").modal();
        });

    });
</script>
@endsection
