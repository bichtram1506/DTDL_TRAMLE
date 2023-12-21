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
                                <input type="text" maxlength="100" class="form-control"  placeholder="Tên" name="tt_name" value="{{ old('tt_name',isset($tourtype) ? $tourtype->tt_name : '') }}">
                                <span class="text-danger "><p class="mg-t-5">{{ $errors->first('tt_name') }}</p></span>
                            </div>
                        </div>
                        
                        <div class="form-group {{ $errors->first('tt_description') ? 'has-error' : '' }}">
                            <label for="inputEmail3" class="control-label default">Mô tả</label>
                            <div>
                                <textarea name="tt_description" id="tt_description" cols="20" rows="8" style="resize:vertical; height: 218px;" class="form-control" placeholder="Mô tả ...">{{ old('tt_description',isset($tourtype) ? $tourtype->tt_description : '') }}</textarea>
                                <span class="text-danger"><p class="mg-t-5">{{ $errors->first('tt_description') }}</p></span>
                                <script>
                                    ckeditor(tt_description);
                                </script>
                            </div>
                        </div>
                        
                   
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        <h3 class="">Hình ảnh </h3>
                    </div>
                    <div class="card-body" style="min-height: 288px">
                        <div class="form-group">
                            <div class="input-group input-file" name="images">
                                <span class="input-group-btn">
                                    <button class="btn btn-default btn-choose" type="button">Chọn tệp</button>
                                </span>
                                <input type="text" class="form-control" placeholder='Không có tệp nào ...'/>
                                <span class="input-group-btn"></span>
                            </div>
                            <span class="text-danger "><p class="mg-t-5">{{ $errors->first('images') }}</p></span>
                            @if(isset($tourtype) && !empty($tourtype->tt_image))
                                <img src="{{ asset(pare_url_file($tourtype->tt_image)) }}" alt="" class="margin-auto-div img-rounded"  id="image_render" style="height: 150px; width:100%;">
                            @else
                                <img src="{{ asset('admin/dist/img/no-image.png') }}" alt="" class="margin-auto-div img-rounded"  id="image_render" style="height: 150px; width:100%;">
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="btn-set">
                            <button type="submit" name="submit" class="btn btn-info" onclick="return confirm('Bạn có chắc chắn muốn lưu không?');">
                                <i class="fa fa-save"></i> Lưu
                            </button>
                            <button type="reset" name="reset" value="reset" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn reset không?');">
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
