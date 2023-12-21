<div class="container-fluid">
    <form role="form" action="" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-9">
                <div class="card card-primary">
                    <!-- form start -->
                    <div class="card-body">
                        <h2>Chi tiết đơn hàng</h2>
                        <div class="row">
                            <div class="form-group col-6">
                              <label>Ngày vào</label>
                              <input type="datetime-local" class="form-control" name="check_in" value="{{ \Carbon\Carbon::parse($bookHotel->check_in)->format('Y-m-d\TH:i') }}">
                            </div>
                          
                            <div class="form-group col-6">
                              <label>Ngày ra</label>
                              <input type="datetime-local" class="form-control" name="check_out" value="{{ \Carbon\Carbon::parse($bookHotel->check_out)->format('Y-m-d\TH:i') }}">
                            </div>
                          </div>
                        <div class="form-group col-6">
                            <label>Phòng</label>
                            <select class="form-control" name="bh_room_id">
                                @foreach($rooms as $room)
                                    <option value="{{ $room->id }}" {{ $room->id == $bookHotel->bh_room_id ? 'selected' : '' }}>
                                        {{ $room->rm_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <!-- /.card-body -->
                        <div class="row">
                            <div class="form-group col-6{{ $errors->first('b_total_ticket') ? 'has-error' : '' }}">
                                <label>Tổng người</label>
                                <div>
                                    <input type="number" maxlength="100" class="form-control" name="num_guest" value="{{ old('b_total_ticket',isset($bookHotel) ? $bookHotel->num_guest : '') }}">
                                    <span class="text-danger "><p class="mg-t-5">{{ $errors->first('num_guest') }}</p></span>
                                </div>
                            </div>
                            <div class="form-group col-6">
                                <label>Tổng tiền</label>
                                <div>
                                    <input type="number" class="form-control" name="total_price" value="{{ old('total_price',isset($bookHotel) ? $bookHotel->total_price : '') }}">
                                    <span class="text-danger "><p class="mg-t-5">{{ $errors->first('total_price') }}</p></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <label>Ngày đặt</label>
                                <div>
                                    <input type="text" class="form-control" readonly value="{{ isset($bookHotel) ? $bookHotel->created_at : '' }}">
                                    <span class="text-danger "><p class="mg-t-5">{{ $errors->first('created_at') }}</p></span>
                                </div>
                            </div>
                    
                        </div>
                
                        
                       
                    </div>
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
