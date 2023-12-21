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
                                <label>Số người lớn</label>
                                <input type="text" class="form-control" name="b_number_adults" value="{{ $bookTour->b_number_adults }}">
                            </div>

                            <div class="form-group col-6">
                                <label>Giá tiền(Người lớn)/người</label>
                                <input type="text" class="form-control" name="b_price_adults" value="{{ $bookTour->b_price_adults }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <label>Số trẻ em( 6->15 tuổi)</label>
                                <input type="text" class="form-control" name="b_number_children" value="{{ $bookTour->b_number_children }}">
                            </div>
                            <div class="form-group col-6">
                                <label>Giá tiền( 6->15 tuổi)/người</label>
                                <input type="text" class="form-control" name="b_price_children" value="{{ $bookTour->b_price_children }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <label>Số trẻ em(2-> 6 tuổi)</label>
                                <input type="text" class="form-control" name="b_number_child6" value="{{ $bookTour->b_number_child6 }}">
                            </div>
                            <div class="form-group col-6">
                                <label>Giá tiền( 2-> 6 tuổi)/người</label>
                                <input type="text" class="form-control" name="b_price_child6" value="{{ $bookTour->b_price_child6 }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <label>Số trẻ sơ sinh( < 2 tuổi)</label>
                                <input type="text" class="form-control" name="b_number_child2" value="{{ $bookTour->b_number_child2 }}">
                            </div>
                            <div class="form-group col-6">
                                <label>Giá tiền( < 2 tuổi)/người</label>
                                <input type="text" class="form-control" name="b_price_child2" value="{{ $bookTour->b_price_child2 }}">
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="row">
                            <div class="form-group col-6{{ $errors->first('b_total_ticket') ? 'has-error' : '' }}">
                                <label>Tổng vé</label>
                                <div>
                                    <input type="text" maxlength="100" class="form-control" name="b_total_ticket" value="{{ old('b_total_ticket',isset($bookTour) ? $bookTour->b_total_ticket : '') }}">
                                    <span class="text-danger "><p class="mg-t-5">{{ $errors->first('b_total_ticket') }}</p></span>
                                </div>
                            </div>
                            <div class="form-group col-6">
                                <label>Tổng tiền</label>
                                <div>
                                    <input type="text" class="form-control" name="b_total_price" value="{{ old('b_total_price',isset($bookTour) ? $bookTour->b_total_price : '') }}">
                                    <span class="text-danger "><p class="mg-t-5">{{ $errors->first('b_total_price') }}</p></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <label>Ngày khởi hành</label>
                                <div>
                                    <input type="text" class="form-control" readonly value="{{ isset($bookTour) ? $bookTour->eventdate->td_start_date : '' }}">
                                    <span class="text-danger "><p class="mg-t-5">{{ $errors->first('td_start_date') }}</p></span>
                                </div>
                            </div>
                            <div class="form-group col-6">
                                <label>Trạng thái thanh toán</label>
                                <div>
                                    @if($bookTour->payments->isEmpty())
                                        <p>Chưa thanh toán</p>
                                    @else
                                        <select class="form-control" name="p_vnp_response_code"readonly>
                                            @foreach($bookTour->payments as $payment)
                                                <option value="00" {{ $payment->p_vnp_response_code == '00' ? 'selected' : '' }}>Thành công</option>
                                                <option value="22" {{ $payment->p_vnp_response_code == '22' ? 'selected' : '' }}>Đã hoàn trả</option>
                                                <option value="11" {{ $payment->p_vnp_response_code == '11' ? 'selected' : '' }}>Thất bại</option>
                                            @endforeach
                                        </select>
                                    @endif
                                    <span class="text-danger "><p class="mg-t-5">{{ $errors->first('p_vnp_response_code') }}</p></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <label>Ngày đặt</label>
                                <div>
                                    <input type="timestamp" class="form-control" name="b_book_date" value="{{ old('b_book_date',isset($bookTour) ? $bookTour->b_book_date : '') }}">
                                    <span class="text-danger "><p class="mg-t-5">{{ $errors->first('b_book_date') }}</p></span>
                                </div>
                            </div>
                            <div class="form-group col-6">
                                <label for="b_payment_method">Phương thức thanh toán</label>
                                <div>
                                    <select class="form-control" name="b_payment_method">
                                        @foreach($PAYMENT_METHODS as $key => $method)
                                            <option value="{{ $key }}" {{ old('b_payment_method', isset($bookTour) ? $bookTour->b_payment_method : '') == $key ? 'selected' : '' }}>{{ $method }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger "><p class="mg-t-5">{{ $errors->first('b_payment_method') }}</p></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <label for="b_coupon_code_id">Mã giảm giá</label>
                                <select class="form-control" name="b_coupon_code_id">
                                    <option value="">Chọn mã giảm giá</option>
                                    @foreach($couponCodes as $couponCode)
                                        <option value="{{ $couponCode->id }}" {{ old('b_coupon_code_id', isset($bookTour) ? $bookTour->b_coupon_code_id : '') == $couponCode->id ? 'selected' : '' }}>
                                            {{ $couponCode->cc_code }}
                                        </option>
                                    @endforeach
                                </select>
                                <!-- Các thông báo lỗi nếu có -->
                                <span class="text-danger"><p class="mg-t-5">{{ $errors->first('b_coupon_code_id') }}</p></span>
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
