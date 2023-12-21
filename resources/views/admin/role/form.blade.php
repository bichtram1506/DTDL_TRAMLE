<div class="container-fluid">
    <form role="form" action="" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <!-- form start -->
                    <div class="card-body">
                        <div class="form-group {{ $errors->first('name') ? 'has-error' : '' }} ">
                            <label for="inputEmail3" class="control-label default">Tên vai trò <sup class="text-danger">(*)</sup></label>
                            <div>
                                <input type="text" maxlength="100" class="form-control"  placeholder="Tên vai trò" name="name" value="{{ old('name',isset($role) ? $role->display_name : '') }}">
                                <span class="text-danger "><p class="mg-t-5">{{ $errors->first('name') }}</p></span>
                            </div>
                        </div>
                        <div class="form-group {{ $errors->first('description') ? 'has-error' : '' }}">
                            <label for="inputEmail3" class="control-label default">Mô tả </label>
                            <div>
                                <textarea name="description" style="resize:vertical" class="form-control" placeholder="Mô tả vai trò">{{ old('description',isset($role) ? $role->description : '') }}</textarea>
                                <span class="text-danger"><p class="mg-t-5">{{ $errors->first('description') }}</p></span>
                            </div>
                        </div>
                    <div class="form-group">
                            <label for="exampleInputEmail1">Thiết lập quyền</label>
                            <div class="col-md-12 permission_role" style="padding: 0px;">
                                @if($permissionGroups)
                                    <div class="row">
                                        @foreach($permissionGroups as $permissionGroup)
                                        <div class="col-md-4">
                                            <div class="role text-center"> <!-- Thêm lớp text-center -->
                                                <h4 class="title-role">{{$permissionGroup->name}}</h4>
                                                <div class="row content-role">
                                                    @foreach($permissionGroup->permissions as $permissions)
                                                        <div class="col-md-12 role-item">
                                                            <div class="custom-checkbox">
                                                                <input type="checkbox" class="checkbox-group-{{safeTitle($permissionGroup->name)}}"
                                                                    {{ isset($listPermission) && in_array($permissions->id, $listPermission) ? 'checked' : '' }}
                                                                    value="{{$permissions->id}}" name="permissions[]" id="checkbox{{ $permissions->id }}">
                                                                <label for="checkbox{{ $permissions->id }}">
                                                                    {{$permissions->display_name}}
                                                                </label>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <div class="row btn-check-role">
                                                    <div class="col-md-6">
                                                        <a class="btn btn-block btn-success checkAll" href="#" title="Chọn tất cả" onclick="$('.checkbox-group-{{safeTitle($permissionGroup->name)}}').prop('checked', true);return false;">
                                                            <i class="fas fa-check-square"></i> Chọn tất cả
                                                        </a>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <a class="btn btn-block btn-danger uncheckAll" href="#" title="Hủy tất cả" onclick="$('.checkbox-group-{{safeTitle($permissionGroup->name)}}').prop('checked', false);return false;">
                                                            <i class="fas fa-times"></i> Hủy tất cả
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div> 
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
           
                    <div class="card-body">
                        <div class="btn-set">
                            <button type="submit" name="submit" class="btn btn-info">
                                <i class="fa fa-save"></i> Lưu dữ liệu
                            </button>
                            <button type="reset" name="reset" value="reset" class="btn btn-danger">
                                <i class="fa fa-undo"></i> Reset
                            </button>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
    </form>
</div>
