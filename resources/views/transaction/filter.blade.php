<form action="" method="POST" class="form-inline float-left" id="searchForm">
    @csrf
    <select class="form-control form-control-sm mr-sm-2 mb-2" name="type" id="search_type">
        <option value="">Select a type</option>
        <option value="1" @if ($type == 1) selected @endif>Expense</option>
        <option value="2" @if ($type == 2) selected @endif>Incoming</option>
        <option value="3" @if ($type == 3) selected @endif>Transfer</option>
    </select>
    <input type="text" class="form-control form-control-sm mr-sm-2 mb-2" name="user" id="search_user" value="{{$user}}" placeholder="Username">
    <select class="form-control form-control-sm mr-sm-2 mb-2" name="account" id="search_account">
        <option value="">Select an account</option>
        @foreach ($accountgroups as $accountgroup)
            <optgroup label="{{$accountgroup->name}}">
                @foreach ($accountgroup->accounts as $item)
                    <option value="{{$item->id}}" data-icon="wallet" @if($account == $item->id) selected @endif>{{$item->name}}</option>                                            
                @endforeach
            </optgroup>
        @endforeach      
    </select>
    <select class="form-control form-control-sm mr-sm-2 mb-2" name="category" id="search_category">
        <option value="">Select a category</option>
        @foreach ($categories as $item)
            <option value="{{$item->id}}" @if ($category == $item->id) selected @endif>{{$item->name}}</option>
        @endforeach
    </select>
    <input type="text" class="form-control form-control-sm mr-sm-2 mb-2" name="period" id="period" autocomplete="off" value="{{$period}}" placeholder="Timestamp" style="max-width:170px;">
    <button type="submit" class="btn btn-sm btn-primary mb-2"><i class="icon-search4"></i>&nbsp;&nbsp;Search</button>
    <button type="button" class="btn btn-sm btn-info mb-2 ml-1" id="btn-reset"><i class="icon-eraser"></i>&nbsp;&nbsp;Reset</button>
</form>