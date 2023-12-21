@extends('page.layouts.page')
@section('title', 'Đặt tour')
@section('style')
@stop
@section('seo')
@stop
@section('content')

    <section class="ftco-section ftco-no-pb contact-section ">
        <div class="container">
            <p class="breadcrumbs"><span class="mr-2"><a href="{{ route('page.home') }}">Trang chủ <i class="fa fa-chevron-right"></i></a></span> <span>Tour theo yêu cầu <i class="fa fa-chevron-right"></i></span></p>
            <h1 class="text-center mb-0 bread title-highlight">Du lịch theo yêu cầu</h1>

        </div>
    </section>
<style>
    .checkbox-group {
    display: flex;
    flex-direction: column;
}

.checkbox {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
}

.checkbox input[type="checkbox"] {
    margin-right: 10px;
}

/* Add more CSS styles as needed to achieve the desired look. */

    </style>
    <section class="ftco-section contact-section ftco-no-pt">
        <div class="container"> 
            <form action="{{route('despoke.postbook.tour')}}" method="POST" class="bg-light contact-form">
                @csrf
                <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h2 class="card-title">Kế hoạch về tour này</h2>
                            <div class="form-group">
                                <label for="t_starting_gate">Địa điểm xuất phát</label>
                                <select name="t_starting_gate" id="t_starting_gate" class="form-control">
                                    <option value="">Chọn địa điểm xuất phát</option>
                                    <option value="Hà Nội" {{ old('t_starting_gate', isset($tour) ? $tour->t_starting_gate : '') == 'Hà Nội' ? 'selected' : '' }}>Hà Nội</option>
                                    <option value="Hồ Chí Minh" {{ old('t_starting_gate', isset($tour) ? $tour->t_starting_gate : '') == 'Hồ Chí Minh' ? 'selected' : '' }}>Hồ Chí Minh</option>
                                    <option value="Đà Nẵng" {{ old('t_starting_gate', isset($tour) ? $tour->t_starting_gate : '') == 'Đà Nẵng' ? 'selected' : '' }}>Đà Nẵng</option>
                                    <option value="Nha Trang" {{ old('t_starting_gate', isset($tour) ? $tour->t_starting_gate : '') == 'Nha Trang' ? 'selected' : '' }}>Nha Trang</option>
                                    <option value="Phú Quốc" {{ old('t_starting_gate', isset($tour) ? $tour->t_starting_gate : '') == 'Phú Quốc' ? 'selected' : '' }}>Phú Quốc</option>
                                    <!-- Thêm các điểm đi khác vào đây -->
                                </select>
                                <span class="text-danger"><p class="mg-t-5">{{ $errors->first('t_starting_gate') }}</p></span>
                            </div>
                          <div class="row">
                                <div class="col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label>Chọn điểm đến <sup class="text-danger">*</sup></label>
                                        <input type="text" id="searchLocations" class="form-control" placeholder="Nhập tên điểm đến">
                                    </div>
                                    <span id="selectedLocations"></span>
                                        <div class="row">
                                            @foreach ($locations as $location)
                                                <div class="col-sm-6">
                                                    <div class="location-item" data-location-id="{{ $location->id }}">
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <span class="location-name">{{ $location->l_name }}</span>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="location-checkbox">
                                                                    <input type="checkbox" name="selected_locations[]" value="{{ $location->id }}"
                                                                        {{ in_array($location->id, old('selected_locations', isset($tour) ? $tour->locations->pluck('id')->toArray() : [])) ? 'checked' : '' }}>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div> 
                                </div>
                            </div> 
                        
                       {{--  <div class="row">
                            
                              <div class="form-group mt-3">
                                <label>Chọn khách sạn <sup class="text-danger">*</sup></label>
                                    <div class="col-md-8" > <!-- Điều chỉnh chiều dài ở đây -->
                                        <select class="custom-select" name="h_hoteltype_id" >
                                            <option value="">Chọn loại khách sạn</option>
                                            @foreach ($hoteltypes as $hoteltype)
                                                <option
                                                    {{old('h_hoteltype_id', isset($hotel->h_hoteltype_id ) ? $hotel->h_hoteltype_id  : '') == $hoteltype->id ? 'selected="selected"' : ''}}
                                                    value="{{$hoteltype->id}}"
                                                >
                                                    {{$hoteltype->ht_name}}
                                                </option>
                                            @endforeach
                                        </select>
                                   </div> </div>
                                    <div class="col-md-4"> 
                                    <div class="form-group mt-3">
                                        <label for="td_start_date">Ngày khởi hành <sup class="text-danger">*</sup></label>
                                        <input type="date" name="td_start_date" id="td_start_date" value="{{ old('td_start_date') }}" class="form-control" required min="{{ \Carbon\Carbon::now()->addDays(7)->format('Y-m-d') }}">
                                        @if ($errors->first('td_start_date'))
                                            <span class="text-danger">{{ $errors->first('td_start_date') }}</span>
                                        @endif
                                    </div>
                                </div>
                                </div> --}}
                        
                                <div class="form-group">
                                    <label>Loại tour <sup class="text-danger">(*)</sup></label>
                                    <select class="custom-select" name="t_tourtype_id">
                                        <option value="">Chọn loại tour</option>
                                        @foreach($tourtypes as $tourtype)
                                            <option
                                                    {{old('t_tourtype_id', isset($tour->t_tourtype_id ) ? $tour->t_tourtype_id  : '') == $tourtype->id ? 'selected="selected"' : ''}}
                                                    value="{{$tourtype->id}}"
                                            >
                                                {{$tourtype->tt_name}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="t_title">Tên tour <sup class="text-danger">*</sup></label>
                                    <input type="text" name="t_title" id="t_title" value="{{ old('t_title') }}" class="form-control">
                                    @if ($errors->first('t_title'))
                                        <span class="text-danger">{{ $errors->first('t_title') }}</span>
                                    @endif
                                </div>
                                <div class="form-group mt-3">
                                    <label for="td_start_date">Ngày khởi hành <sup class="text-danger">*</sup></label>
                                    <input type="date" name="td_start_date" id="td_start_date" value="{{ old('td_start_date') }}" class="form-control" required min="{{ \Carbon\Carbon::now()->addDays(7)->format('Y-m-d') }}">
                                    @if ($errors->first('td_start_date'))
                                        <span class="text-danger">{{ $errors->first('td_start_date') }}</span>
                                    @endif
                                </div>
                         
                            <div class="form-group">
                                <label for="t_note">Yêu cầu tour <sup class="text-danger">*</sup></label>
                                <textarea name="t_note" id="t_note" class="form-control"></textarea>
                                @if ($errors->first('t_note'))
                                    <span class="text-danger">{{ $errors->first('t_note') }}</span>
                                @endif
                            </div>
                            
                        
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            @if (!$user)
                            <div class="form-group">
                                <label for="inputEmail3" class="control-label">Tên khách hàng<sup class="text-danger">(*)</sup></label>
                                <input type="text" name="b_name" id="b_name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="control-label">Địa chỉ email<sup class="text-danger">(*)</sup></label>
                                <input type="email" name="b_email" id="b_email" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="control-label">SĐT<sup class="text-danger">(*)</sup></label>
                                <input type="phone" name="b_phone" id="b_phone" class="form-control">
                            </div>
                        @endif
                            <div class="form-group">
                                <label for="inputEmail3" class="control-label">Số người lớn <sup class="text-danger">(*)</sup></label>
                                <input type="number" name="b_number_adults"   id="b_number_adults"class="form-control" placeholder="Số người lớn" min="1">
                                @if ($errors->first('b_number_adults'))
                                    <span class="text-danger">{{ $errors->first('b_number_adults') }}</span>
                                @elseif ($errors->has('b_number_adults') && old('b_number_adults') < 1)
                                    <span class="text-danger">Số người phải lớn hơn 0</span>
                                @endif
                            </div>
                            
                            <div class="form-group">
                                <label for="inputEmail3" class="control-label">Số trẻ em (6 - 12 tuổi) </label>
                                <input type="number"  min="0" value="0"  id="b_number_children" name="b_number_children" class="form-control" placeholder="Số trẻ em">
                                @if ($errors->first('b_number_children'))
                                    <span class="text-danger">{{ $errors->first('b_number_children') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="control-label">Số trẻ em (2-6 tuổi) </label>
                                <input type="number"  min="0" value="0" id="b_number_child6" name="b_number_child6" class="form-control" placeholder="Số trẻ em">
                                @if ($errors->first('b_number_children'))
                                    <span class="text-danger">{{ $errors->first('b_number_children') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="control-label">Số trẻ em (Dưới 2 tuổi) </label>
                                <input type="number"  min="0" value="0" id="b_number_child2" name="b_number_child2" class="form-control a" placeholder="Số trẻ em">
                                @if ($errors->first('b_number_children'))
                                    <span class="text-danger">{{ $errors->first('b_number_children') }}</span>
                                @endif
                            </div>  
        
                            <div class="form-group">
                                <label for="t_day">Số ngày đi tour <sup class="text-danger">*</sup></label>
                                <input type="number" name="t_day" id="t_day" value="{{ old('t_day') }}" class="form-control" required min="1">
                                @if ($errors->first('t_day'))
                                    <span class="text-danger">{{ $errors->first('t_day') }}</span>
                                @endif
                            </div>
            
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="vehicles">Phương tiện <sup class="text-danger">*</sup></label>
                                <div class="checkbox-group">
                                    @foreach ($vehicles as $vehicle)
                                        <div class="checkbox">
                                            <input type="checkbox" name="vehicle_ids[]" id="vehicle_{{ $vehicle->id }}" value="{{ $vehicle->id }}">
                                            <label for="vehicle_{{ $vehicle->id }}">{{ $vehicle->v_name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="services">Dịch vụ <sup class="text-danger">*</sup></label>
                                <div class="checkbox-group">
                                    @foreach ($services as $service)
                                        <div class="checkbox">
                                            <input type="checkbox" name="service_ids[]" id="service_{{ $service->id }}" value="{{ $service->id }}">
                                            <label for="service_{{ $service->id }}">{{ $service->sv_name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div style="text-align: center;" class="col-md-12 text-center payment-method-section">
                        <h4 class="font-weight-bold">Chọn Phương Thức Thanh Toán:</h4>
                        <div class="payment-method">
                            <div class="payment-method-buttons">
                              <button type="button" class="btn btn-outline-success payment-method-btn" data-method="bankTransfer" required>Thanh toán qua Chuyển khoản</button>
                              <button type="button" class="btn btn-outline-success payment-method-btn" data-method="VNPay" required>Thanh toán qua VNPAY</button>
                              <button type="button" class="btn btn-outline-success payment-method-btn" data-method="cash" required>Thanh toán Tiền mặt</button>
                              <button type="button" class="btn btn-outline-success payment-method-btn" data-method="MOMO" required>Thanh toán Ví MOMO</button>
                            </div>
                          </div>
                        @if ($errors->first('b_payment_method'))
                            <div class="text-danger font-italic">{{ $errors->first('b_payment_method') }}</div>
                        @endif
                    </div>
                    
                </div>   
                       
                      
                </div>
                </div> 

                </div>  
             </div>
            <div class="col-md-12 text-center mt-3">
                <div class="form-group">
                    <input type="hidden" name="b_payment_method" id="selectedPaymentMethod">
                    <input type="submit" value="Đặt tour" class="btn btn-primary py-3 px-5" id="submitButton">
                </div>
            </div>
            
            </form>
             {{--  
                 
                    <div class="card">
                        <div class="card-body">
                            <h2 class="card-title">Thông tin đơn đặt</h2>
                    <div class="form-group">
                        <label for="inputEmail3" class="control-label">Số người lớn <sup class="text-danger">(*)</sup></label>
                        <input type="number" name="bd_number_adults"   id="bd_number_adults"class="form-control" placeholder="Số người lớn" min="1">
                        @if ($errors->first('bd_number_adults'))
                            <span class="text-danger">{{ $errors->first('bd_number_adults') }}</span>
                        @elseif ($errors->has('bd_number_adults') && old('bd_number_adults') < 1)
                            <span class="text-danger">Số người phải lớn hơn 0</span>
                        @endif
                    </div>
                    
                    <div class="form-group">
                        <label for="inputEmail3" class="control-label">Số trẻ em (6 - 12 tuổi) </label>
                        <input type="number"  min="0" value="0"  id="bd_number_children" name="bd_number_children" class="form-control" placeholder="Số trẻ em">
                        @if ($errors->first('bd_number_children'))
                            <span class="text-danger">{{ $errors->first('bd_number_children') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="control-label">Số trẻ em (2-6 tuổi) </label>
                        <input type="number"  min="0" value="0" id="bd_number_child6" name="bd_number_child6" class="form-control" placeholder="Số trẻ em">
                        @if ($errors->first('bd_number_children'))
                            <span class="text-danger">{{ $errors->first('bd_number_children') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="control-label">Số trẻ em (Dưới 2 tuổi) </label>
                        <input type="number"  min="0" value="0" id="bd_number_child2" name="bd_number_child2" class="form-control a" placeholder="Số trẻ em">
                        @if ($errors->first('bd_number_children'))
                            <span class="text-danger">{{ $errors->first('bd_number_children') }}</span>
                        @endif
                    </div> 
                    <div class="container text-center">
                        <h4 class="font-weight-bold">Chọn Phương Thức Thanh Toán:</h4>
                        <div class="row">
                            <div class="col-md-6 offset-md-3">
                                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                    <label class="btn btn-primary">
                                        <input type="radio" name="b_payment_method" value="bankTransfer" required> Thanh toán qua VNPAY
                                    </label>
                                    <label class="btn btn-primary">
                                        <input type="radio" name="b_payment_method" value="cash" required> Thanh Toán Tiền Mặt
                                    </label>
                                    <!-- Thêm các phương thức thanh toán khác tương tự nếu cần -->
                                </div>
                            </div>
                        </div>
                        @if ($errors->first('b_payment_method'))
                            <div class="text-danger font-italic">{{ $errors->first('b_payment_method') }}</div>
                        @endif
                    </div>
                    
                </div> 

            </div>
                </div> --}}
         
                
              <!-- Mã HTML còn lại của bạn -->   
        </div>
</section>

<script>
    function submitForm() {
        document.getElementById("submitButton").click();
    }
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $("#searchLocations").on("keyup", function () {
            var searchText = $(this).val().toLowerCase();

            // Ẩn tất cả các mục điểm đến
            $(".location-item").hide();

            // Lặp qua danh sách điểm đến và hiển thị các mục phù hợp với tìm kiếm
            $(".location-item").each(function () {
                var locationName = $(this).find(".location-name").text().toLowerCase();
                if (locationName.includes(searchText)) {
                    $(this).show();
                }
            });
        });

        // Hiển thị danh sách checkbox đã chọn cho điểm đến
        showSelectedCheckboxesForLocation();

        // Xử lý sự kiện khi một checkbox của điểm đến được thay đổi
        $("input[type='checkbox'][name='selected_locations[]']").on("change", function () {
            showSelectedCheckboxesForLocation();
        });

        // Hàm để hiển thị danh sách checkbox đã chọn cho điểm đến
        function showSelectedCheckboxesForLocation() {
            var selectedCheckboxes = $("input[type='checkbox'][name='selected_locations[]']:checked");

            if (selectedCheckboxes.length > 0) {
                var selectedText = "Các điểm đã chọn: ";
                selectedCheckboxes.each(function () {
                    selectedText += $(this).closest(".location-item").find(".location-name").text() + ", ";
                });
                selectedText = selectedText.slice(0, -2); // Loại bỏ dấu phẩy cuối cùng và khoảng trắng
                $("#selectedLocations").text(selectedText).show();
            } else {
                $("#selectedLocations").hide();
            }
        }
    });
</script>

    

@stop
@section('script')
@stop