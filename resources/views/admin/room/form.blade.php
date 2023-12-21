<div class="container-fluid">
    <form role="form" action="" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-9">
                <div class="card card-primary">
                    <!-- form start -->
                    <div class="card-body">
                        <div class="form-group {{ $errors->first('rm_name') ? 'has-error' : '' }} ">
                            <label for="inputEmail3" class="control-label default">Tên phòng <sup class="text-danger">(*)</sup></label>
                            <div>
                                <input type="text" maxlength="100" class="form-control"  placeholder="Tên phòng khách sạn" name="rm_name" value="{{ old('rm_name',isset($room) ? $room->rm_name : '') }}">
                                <span class="text-danger "><p class="mg-t-5">{{ $errors->first('rm_name') }}</p></span>
                            </div>
                        </div>
                     
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Giá từ / ngày</label>
                                    <div>
                                        <input type="number" class="form-control"  placeholder="Giá" name="rm_price" value="{{ old('rm_price',isset($room) ? $room->rm_price : '') }}">
                                        <span class="text-danger "><p class="mg-t-5">{{ $errors->first('rm_price') }}</p></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tầng</label>
                                    <div>
                                        <input type="text" class="form-control"  placeholder="Số tầng" name="rm_floor" value="{{ old('rm_floor',isset($room) ? $room->rm_floor : '') }}">
                                        <span class="text-danger "><p class="mg-t-5">{{ $errors->first('rm_floor') }}</p></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="status">Trạng thái phòng:</label>
                                <select id="status" name="status">
                                    @foreach ($status as $key => $value)
                                        <option value="{{ $key }}" {{ old('status', isset($room) && $room->status == $key ? 'selected' : '') }}>{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Mã phòng</label>
                                <div>
                                    <input type="number" class="form-control"  placeholder="Số lượng" name="rm_code" value="{{ old('rm_code',isset($room) ? $room->rm_code : '') }}">
                                    <span class="text-danger "><p class="mg-t-5">{{ $errors->first('rm_code') }}</p></span>
                                </div>
                            </div>
                        </div>  
                    
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="rm_type">Loại phòng</label>
                                    <div>
                                        <select class="form-control" name="rm_type">
                                            <option value="">Chọn loại phòng</option>
                                            <option value="1" {{ old('rm_type', isset($room) ? $room->rm_type : '') == 1 ? 'selected' : '' }}>Phòng đơn</option>
                                            <option value="2" {{ old('rm_type', isset($room) ? $room->rm_type : '') == 2 ? 'selected' : '' }}>Phòng đôi</option>
                                            <option value="3" {{ old('rm_type', isset($room) ? $room->rm_type : '') == 3 ? 'selected' : '' }}>Phòng gia đình</option>
                                            <option value="4" {{ old('rm_type', isset($room) ? $room->rm_type : '') == 4 ? 'selected' : '' }}>Phòng hướng biển</option>
                                            <option value="5" {{ old('rm_type', isset($room) ? $room->rm_type : '') == 5 ? 'selected' : '' }}>Phòng hạng sang</option>
                                            <!-- Thêm các tùy chọn khác -->
                                        </select>
                                        <span class="text-danger"><p class="mg-t-5">{{ $errors->first('rm_type') }}</p></span>
                                    </div>
                            
                            </div>
                        </div>
                    </div>
                        <div class="row">
                    
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Chọn khách sạn</label>
                                    <select class="custom-select" name="rm_hotel_id">
                                        <option value="">Chọn khách sạn</option>
                                        @foreach ($hotels as $hotel)
                                            <option value="{{ $hotel->id }}" {{ old('rm_hotel_id', isset($room) && $room->rm_hotel_id == $hotel->id ? 'selected' : '') }}>
                                                {{ $hotel->h_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
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
                                    @if(isset($room) && !empty($room->image))
                                        <img src="{{ asset(pare_url_file($room->image)) }}" alt="" class="margin-auto-div img-rounded"  id="image_render" style="height: 150px; width:100%;">
                                    @else
                                        <img src="{{ asset('admin/dist/img/no-image.png') }}" alt="" class="margin-auto-div img-rounded"  id="image_render" style="height: 150px; width:100%;">
                                    @endif
                                </div>
                            </div>
                            </div>
                        </div>
                        
                        
                        <div class="form-group {{ $errors->first('rm_description') ? 'has-error' : '' }}">
                            <label for="inputEmail3" class="control-label default">Mô tả</label>
                            <div>
                                <textarea name="rm_description" id="rm_description" cols="20" rows="8" style="resize:vertical; height: 218px;" class="form-control" placeholder="Mô tả ...">{{ old('rm_description',isset($room) ? $room->rm_description : '') }}</textarea>
                                <span class="text-danger"><p class="mg-t-5">{{ $errors->first('rm_description') }}</p></span>
                                <script>
                                    ckeditor(rm_description);
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
