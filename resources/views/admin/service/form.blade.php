<div class="container-fluid">
    <form role="form" action="" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-9">
                <div class="card card-primary">
                    <!-- form start -->
                    <div class="card-body">
                        <div class="form-group {{ $errors->first('tt_name') ? 'has-error' : '' }} ">
                            <label for="inputEmail3" class="control-label default">Tên  <sup class="text-danger">(*)</sup></label>
                            <div>
                                <input type="text" maxlength="100" class="form-control"  placeholder="Tên" name="sv_name" value="{{ old('sv_name',isset($service) ? $service->sv_name : '') }}">
                                <span class="text-danger "><p class="mg-t-5">{{ $errors->first('sv_name') }}</p></span>
                            </div>
                        </div>

                        <div class="form-group {{ $errors->first('icon') ? 'has-error' : '' }} ">
                            <label for="inputEmail3" class="control-label default">Biểu tượng  <sup class="text-danger">(*)</sup></label>
                            <div>
                                <input type="text" maxlength="100" class="form-control"  placeholder="icon" name="icon" value="{{ old('icon',isset($service) ? $service->icon : '') }}">
                                <span class="text-danger "><p class="mg-t-5">{{ $errors->first('icon') }}</p></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Chọn loại dịch vụ</label>
                            <select class="custom-select" name="type">
                                <option value="">Chọn loại dịch vụ</option>
                                <option value="1" {{ $selectedValue == '1' ? 'selected' : '' }}>Dịch vụ trọn gói</option>
                                <option value="2" {{ $selectedValue == '2' ? 'selected' : '' }}>Dịch vụ đi kèm</option>
                            </select>
                        </div>
                        
                       
                        <div class="form-group {{ $errors->first('sv_description') ? 'has-error' : '' }}">
                            <label for="inputEmail3" class="control-label default">Mô tả</label>
                            <div>
                                <textarea name="sv_description" id="sv_description" cols="20" rows="8" style="resize:vertical; height: 100px;" class="form-control" placeholder="Mô tả ...">{{ old('sv_description',isset($service) ? $service->sv_description : '') }}</textarea>
                                <span class="text-danger"><p class="mg-t-5">{{ $errors->first('sv_description') }}</p></span>
                                <script>
                                    ckeditor(sv_description);
                                </script>
                            </div>
                        </div>
                        
                   
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
            <div class="col-md-3">
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
