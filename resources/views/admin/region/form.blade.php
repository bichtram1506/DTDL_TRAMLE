<div class="container-fluid">
    <form role="form" action="" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-9">
                <div class="card card-primary">
                    <!-- form start -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group {{ $errors->first('r_name') ? 'has-error' : '' }}">
                                    <label for="inputEmail3" class="control-label default">Tên miền <sup class="text-danger">(*)</sup></label>
                                    <div>
                                        <input type="text" maxlength="100" class="form-control" placeholder="Tên miền" name="r_name" value="{{ old('r_name', isset($region) ? $region->r_name : '') }}">
                                        <span class="text-danger"><p class="mg-t-5">{{ $errors->first('r_name') }}</p></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="inputEmail3" class="control-label default">Trạng thái <sup class="text-danger">(*)</sup></label>
                                <div class="">
                                    <select class="custom-select" name="r_status" style="width: 200px;">
                                        @foreach($status as $key => $item)
                                            <option {{ old('r_status', isset($region->r_status) ? $region->r_status : '') == $key ? 'selected="selected"' : '' }}
                                                    value="{{$key}}">
                                                {{$item}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card-header">
                            <h3 class="card-title">Hình ảnh </h3>
                        </div>
                        <div class="" style="min-height: 288px">
                            <div class="form-group">
                                <div class="input-group input-file" name="images">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default btn-choose" type="button">Chọn tệp</button>
                                    </span>
                                    <input type="text" class="form-control" placeholder='Không có tệp nào ...'/>
                                    <span class="input-group-btn"></span>
                                </div>
                                <span class="text-danger "><p class="mg-t-5">{{ $errors->first('images') }}</p></span>
                                @if(isset($region) && !empty($region->r_image))
                                    <img src="{{ asset(pare_url_file($region->r_image)) }}" alt="" class="margin-auto-div img-rounded"  id="image_render" style="height: 150px; width:100%;">
                                @else
                                    <img src="{{ asset('admin/dist/img/no-image.png') }}" alt="" class="margin-auto-div img-rounded"  id="image_render" style="height: 150px; width:100%;">
                                @endif
                            </div>
                        </div>
                        <div class="form-group {{ $errors->first('r_description') ? 'has-error' : '' }}">
                            <label for="inputEmail3" class="control-label default">Mô tả</label>
                            <div>
                                <textarea name="r_description" cols="20" rows="8" style="resize:vertical; height: 218px;" class="form-control" placeholder="Mô tả ...">{{ old('r_description',isset($region) ? $region->r_description : '') }}</textarea>
                                <span class="text-danger"><p class="mg-t-5">{{ $errors->first('r_description') }}</p></span>
                            </div>
                        </div>
                        <div class="form-group {{ $errors->first('r_content') ? 'has-error' : '' }} ">
                            <label for="inputEmail3" class="control-label default">Giới thiệu </label>
                            <div>
                                <textarea name="r_content" id="r_content" cols="30" rows="10" class="form-control" style="height: 225px;">{{ old('r_content', isset($region) ? $region->r_content : '') }}</textarea>
                                <script>
                                    ckeditor(r_content);
                                </script>
                                @if ($errors->first('r_content'))
                                    <span class="text-danger">{{ $errors->first('r_content') }}</span>
                                @endif
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
                                <i class="fa fa-save"></i> Lưu
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
