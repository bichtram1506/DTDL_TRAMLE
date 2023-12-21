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
                             <div class="form-group {{ $errors->first('cc_name') ? 'has-error' : '' }} ">
                            <label for="inputEmail3" class="control-label default">Tên mã <sup class="text-danger">(*)</sup></label>
                            <div>
                                <input type="text" maxlength="100" class="form-control"  placeholder="Tên mã" name="cc_name" value="{{ old('cc_name',isset($couponcode) ? $couponcode->cc_name : '') }}">
                                <span class="text-danger "><p class="mg-t-5">{{ $errors->first('h_name') }}</p></span>
                            </div>
                        </div>  
                    </div>    
                     
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Trạng thái</label>
                                    <select class="custom-select" name="cc_status">
                                        @foreach($status as $key => $statu)
                                            <option
                                                    {{old('cc_status', isset($couponcode->cc_status ) ? $couponcode->cc_status : '') == $key ? 'selected="selected"' : ''}}
                                                    value="{{$key}}"
                                            >
                                                {{$statu}}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger"><p class="mg-t-5">{{ $errors->first('cc_status') }}</p></span>
                                </div>
                            </div>
                        </div>     
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Ngày bắt đầu</label>
                                    <div>
                                        <input type="date" class="form-control"  placeholder="Ngày bắt đầu" name="cc_start_date" value="{{ old('cc_start_date',isset($couponcode) ? $couponcode->cc_start_date : '') }}">
                                        <span class="text-danger "><p class="mg-t-5">{{ $errors->first('h_price') }}</p></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Ngày kết thúc</label>
                                    <div>
                                        <input type="date" class="form-control"  placeholder="Ngày kết thúc" name="cc_expiry_date" value="{{ old('cc_expiry_date',isset($couponcode) ? $couponcode->cc_expiry_date : '') }}">
                                        <span class="text-danger "><p class="mg-t-5">{{ $errors->first('cc_expiry_date') }}</p></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Số lượt</label>
                                    <div>
                                        <input type="text" class="form-control"  placeholder="Số lượt" name="cc_remaining_code" value="{{ old('cc_remaining_code',isset($couponcode) ? $couponcode->cc_remaining_code : '') }}">
                                        <span class="text-danger "><p class="mg-t-5">{{ $errors->first('cc_remaining_code') }}</p></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Số giảm</label>
                                    <div>
                                        <input type="text" class="form-control"  placeholder="% giảm" name="cc_percentage" value="{{ old('cc_percentage',isset($couponcode) ? $couponcode->cc_percentage : '') }}">
                                        <span class="text-danger "><p class="mg-t-5">{{ $errors->first('cc_percentage') }}</p></span>
                                    </div>
                                </div>
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
