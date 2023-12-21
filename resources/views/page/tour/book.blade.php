@extends('page.layouts.page')
@section('title', 'Đặt tour')
@section('style')
@stop
@section('seo')
@stop
@section('content')

    <section class="ftco-section ftco-no-pb contact-section ">
        <div class="container">
            <p class="breadcrumbs"><span class="mr-2"><a href="{{ route('page.home') }}">Trang chủ <i class="fa fa-chevron-right"></i></a></span> <span>Tours <i class="fa fa-chevron-right"></i></span></p>
            <h1 class="text-center mb-0 bread title-highlight">Đặt Tour</h1>

        </div>
    </section>
    <section class="ftco-section contact-section ftco-no-pt">
        <div class="container">
   
            <form action="{{ isset($eventdate) ? route('post.book.tour', $eventdate->id) : route('post.book.tour', $tour->id) }}" method="POST" class="bg-light contact-form">
         @csrf
            <div class="row block-9">
                <div class=" col-md-6 text-center order-md-last ftco-animate fadeInUp ftco-animated project-wrapbook">
                    <div class="col-md-12 ">
                        <div class="project-wrapbook">
                            <div class="support-section">
                             
                                    <div class="row justify-content-center align-items-center text-center mb-4">
                                        <div class="col-md-12">
                                            <h2>Quý khách cần hỗ trợ?</h2>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 text-center support-item">
                                            <i class="fas fa-phone  mb-2"></i>
                                            <p class="mb-0">Gọi miễn phí</p>
                                        </div>
                                        <div class="col-md-6 text-center support-item">
                                            <i class="fas fa-envelope  mb-2"></i>
                                            <p class="mb-0">Gửi yêu cầu hỗ trợ ngay</p>
                                        </div>
                                    </div>
                                
                            </div>
                            <div class="project-wrapbook">
                                <div class="col-md-12 text-center ">
                                    <div class="content-box ">
                                     <h4 class="font-weight-bold mb-2  title-highlight">Tóm tắt chuyến đi</h4>
                                      <div class="d-flex">
                                        <div class="image-thumbnail  ">
                                            <img src="{{ asset(pare_url_file($tour->t_image)) }}" alt="" style="max-width: 100%;">
                                      </div>
                                        <h2 class="mb-3 title-book">{{ $tour->t_title }}</h2>  </div>   
                                        <h2 class="mb-3">{{ isset($tour->location) ? $tour->location->l_name : '' }}</h2>
                                        @if (isset($eventdate))
                                        <p class="mb-2">
                                            <i class="fas fa-calendar-alt mr-2"></i> Bắt đầu chuyến đi<br>
                                            <strong>{{ $eventdate->td_start_date }}</strong>
                                        </p>
                                        @endif
                                        @if (isset($eventdate))
                                        <i class="fas fa-long-arrow-alt-down my-2"></i>
                                        <p class="mb-2">
                                            <i class="fas fa-calendar-check mr-2"></i> Kết thúc chuyến đi<br>
                                           <strong> {{ $eventdate->td_end_date }} </strong>
                                        </p>
                                        @endif
                                        <p>Hành trình: {{ $tour->t_day }} ngày {{ $tour->t_night }} đêm </p>
                                        
                                        <div style="text-align: center;" class="col-md-12 text-center payment-method-section">
                                            <h4 class="font-weight-bold">Chọn Phương Thức Thanh Toán:</h4>
                                            <div class="payment-method-buttons">
                                                <button type="button" class="btn btn-outline-success payment-method-btn" data-method="VNPay" required>Thanh toán qua VNPAY</button>
                                                <button type="button" class="btn btn-outline-success payment-method-btn" data-method="cash" required>Thanh toán tiền mặt</button>
                                                <button type="button" class="btn btn-outline-success payment-method-btn" data-method="bankTransfer" required>Thanh toán chuyển khoản ngân hàng</button>
                                                <button type="button" class="btn btn-outline-success payment-method-btn" data-method="MOMO" required>Thanh toán qua MOMO</button>
                                                
                                                <!-- Thêm các nút PTTT khác tương tự nếu cần -->
                                            </div>
                                            @if ($errors->first('b_payment_method'))
                                                <div class="text-danger font-italic">{{ $errors->first('b_payment_method') }}</div>
                                            @endif
                                        </div>
                                        
                                        
                                        <div class="form-group">
                                            <label for="cc_code" class="control-label">Mã giảm giá (nếu có):</label>
                                            <div class="input-group">
                                                <input type="text" name="cc_code" id="cc_code" class="form-control" placeholder="Nhập mã giảm giá">
                                                <div class="input-group-append">
                                                    <button type="button" class="btn btn-primary" onclick="applyDiscount()">Áp dụng</button>
                                                    <button type="button" class="btn btn-danger" id="removeDiscountButton" style="display: none;" onclick="removeDiscount()">Xóa</button>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group" style="margin-bottom: 20px;">
                                            <!-- Tổng giá trị -->
                                            @if (isset($tour))
                                            <div class="event-prices" style="margin-bottom: 10px;">
                                                <p>
                                                    <span class="price-label">Giá người lớn:</span> <strong id="adult-price">{{ number_format($tour->t_price_adults - ($tour->t_price_adults * $tour->t_sale / 100)) }} VNĐ</strong> X <b> <span id="adult-count">0</span></b> = <span id="total-adult-price">0 VNĐ</span>
                                                </p>
                                                <p>
                                                    <span class="price-label">Giá trẻ em:</span> <strong id="children-price">{{ number_format($tour->t_price_children - ($tour->t_price_children * $tour->t_sale / 100)) }} VNĐ</strong> X <b> <span id="children-count">0</span></b> = <span id="total-children-price">0 VNĐ</span>
                                                </p>
                                                <p>
                                                    <span class="price-label">Giá trẻ em dưới 6 tuổi:</span> <strong id="child6-price">{{ number_format(($tour->t_price_children - ($tour->t_price_children * $tour->t_sale / 100)) * 50 / 100) }} VNĐ</strong> X <b> <span id="child6-count">0</span></b> = <span id="total-child6-price">0 VNĐ</span>
                                                </p>
                                                <p>
                                                    <span class="price-label">Giá trẻ em dưới 2 tuổi:</span> <strong id="child2-price">{{ number_format(($tour->t_price_children - ($tour->t_price_children * $tour->t_sale / 100)) * 25 / 100) }} VNĐ</strong> X <b> <span id="child2-count">0</span></b> = <span id="total-child2-price">0 VNĐ</span>
                                                </p>
                                            </div>
                                            <div style="margin-top: 10px;">
                                                <div style="color: #FF5733; font-size: 18px; font-weight: bold;">Dịch vụ cộng thêm:</div>
                                                <p id="extra-services-total" style="color: #FF5733; font-size: 18px; font-weight: bold;">0 VNĐ</p>
                                              </div>
                                            <p class="control-label" style="color: #FF5733; font-size: 18px; font-weight: bold;">Tổng giá trị: <strong id="total-price" style="color: #FF5733; font-size: 18px; font-weight: bold;">0 VNĐ</strong></p>
                                            <!-- Thêm một phần tử để hiển thị số tiền giảm giá -->
                                            <div id="discounted-price-container" style="display: none; margin-top: 10px;">
                                                <div id="discount-amount-container" style="display: none;">
                                                    <p class="font-weight-bold">Số tiền được giảm: <span id="discount-amount">0 VNĐ</span></p>
                                                </div>
                                                <span class="font-weight-bold">Giá sau khi áp dụng mã:</span>
                                                <del><span id="original-price">0đ</span></del>
                                                <span id="discounted-price">0đ</span>
                                                <input type="hidden" name="b_coupon_code_id" id="discountCodeId" value="">
                                            </div>
                                            <input type="hidden" name="b_total_price" id="totalPrice" value="">
                                        </div>
                                    @endif
                                        <div class="col-md-12 text-center">
                                            <div class="form-group">
                                                <input type="hidden" name="b_payment_method" id="selectedPaymentMethod">
                                                
                                                <input type="submit" value="Đặt Tour" class="btn btn-primary py-3 px-5">
                                            </div>
                                        </div>
                                        
                                        
                                    </div>
                                    
                                </div>
                            </div>   
                            
                    </div>
                 </div>
              </div>

                <div class="col-md-6 ">
                   
                        <div class="form-group">
                            <label for="inputEmail3" class="control-label">Điểm Đón <sup class="text-danger">(*)</sup></label>
                            <input type="text" name="b_address" value="{{ old('b_address', isset($user) ? $user->address : '') }}" class="form-control" placeholder="Địa chỉ">
                            @if ($errors->first('b_address'))
                                <span class="text-danger">{{ $errors->first('b_address') }}</span>
                            @endif
                        </div> 
                     
                        @if (!isset($eventdate))
                        <div class="form-group">
                            <label for="inputEmail3" class="control-label">Ngày khởi hành dự kiến <sup class="text-danger">(*)</sup></label>
                            <input type="date" name="td_start_date" value="{{ old('td_start_date') }}" class="form-control" required
                                   min="{{ \Carbon\Carbon::now()->addDays(7)->format('Y-m-d') }}">
                            @if ($errors->first('td_start_date'))
                                <span class="text-danger">{{ $errors->first('td_start_date') }}</span>
                            @endif
                        </div>
                    @endif
                    
                                
                        <div class="form-group">
                            <label for="inputEmail3" class="control-label">Số người lớn <sup class="text-danger">(*)</sup></label>
                            <input type="number"   name="b_number_adults"   id="b_number_adults"class="form-control"  min="1">
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
                   <!-- Mã HTML của bạn -->

                   <div class="form-group" style="margin-bottom: 20px;">
                    <label for="extra_services" class="control-label" style="display: block; font-weight: bold; margin-bottom: 10px;">Dịch vụ đi kèm</label>
                    <div class="checkbox-list" style="margin-left: 20px;">
                        @foreach ($tour->extra_services as $extraService)
                        <div class="checkbox-item" style="display: flex; align-items: center; margin-bottom: 10px;">
                            <input type="checkbox" id="extra_service{{ $extraService->id }}" name="extra_services[]" value="{{ $extraService->id }}" class="checkbox-input" style="margin-right: 10px;margin-bottom: 10px;">
                            <label for="extra_service{{ $extraService->id }}" class="checkbox-label" style="margin-left: 10px;margin-bottom: 10px;">{{ $extraService->sv_name }}</label>
                            <span class="price-label" style="margin-left: 10px; font-weight: bold;margin-bottom: 10px;">Giá:</span>
                            <span class="price-value" style="margin-left: 5px;margin-bottom: 10px;">{{ $extraService->pivot->price }} VNĐ</span>
                        </div>
                        @endforeach
                    </div>
                </div>
              <!-- Mã HTML còn lại của bạn -->
                        <div class="form-group">
                            <label for="inputEmail3" class="control-label">Ghi chú</label>
                            <textarea name="b_note"  placeholder="Thông tin chi tiết để chúng tôi liên hệ nhanh chóng..." id="message" cols="20" rows="5" class="form-control"></textarea>
                        </div> 
                        
                    </form>
                  
                </div>
            </div>
        </div>
        <script>
    $('.a').on('input',function(){
        var $a =$(this).val();
        var $p = $(this).parents('tr');
        var $b=300;
        var $t=$p.find('.t');
        $t.text($b*$a);
    })
</script>
 <!-- Cung cấp giá tiền cho mã JavaScript -->
<!-- Cung cấp giá tiền cho mã JavaScript -->
<script>
  // Lắng nghe sự kiện khi người dùng thay đổi số lượng người lớn hoặc trẻ em
function updateTotalPrice() {
    var numAdults = parseFloat(document.getElementsByName('b_number_adults')[0].value);
    var numChildren = parseFloat(document.getElementsByName('b_number_children')[0].value);
    var numChild6 = parseFloat(document.getElementsByName('b_number_child6')[0].value);
    var numChild2 = parseFloat(document.getElementsByName('b_number_child2')[0].value);

    var adultPriceString = document.getElementById('adult-price').textContent.split(' ')[0];
    var adultPrice = parseFloat(adultPriceString.replace(/,/g, ''));

    var childrenPriceString = document.getElementById('children-price').textContent.split(' ')[0];
    var child6PriceString = document.getElementById('child6-price').textContent.split(' ')[0];
    var child2PriceString = document.getElementById('child2-price').textContent.split(' ')[0];

    var childrenPrice = parseFloat(childrenPriceString.replace(/,/g, ''));
    var child6Price = parseFloat(child6PriceString.replace(/,/g, ''));
    var child2Price = parseFloat(child2PriceString.replace(/,/g, ''));


    var totalAdultPrice = numAdults * adultPrice;
    var totalChildrenPrice = numChildren * childrenPrice;
    var totalChild6Price = numChild6 * child6Price;
    var totalChild2Price = numChild2 * child2Price;

    document.getElementById('total-adult-price').textContent = totalAdultPrice.toFixed(0) + ' VNĐ';
    document.getElementById('total-children-price').textContent = totalChildrenPrice.toFixed(0) + ' VNĐ';
    document.getElementById('total-child6-price').textContent = totalChild6Price.toFixed(0) + ' VNĐ';
    document.getElementById('total-child2-price').textContent = totalChild2Price.toFixed(0) + ' VNĐ';

    var extraServicesTotal = getExtraServicesTotal();

    var totalPrice = totalAdultPrice + totalChildrenPrice + totalChild6Price + totalChild2Price + extraServicesTotal;

    document.getElementById('total-price').textContent = totalPrice.toFixed(0) + ' VNĐ';
     // Cập nhật giá trị của phần tử hiển thị tổng giá trị dịch vụ đi kèm
     document.getElementById('extra-services-total').textContent = extraServicesTotal.toFixed(0) + ' VNĐ';
}


// Lấy tổng giá trị của các dịch vụ đi kèm được chọn
    function getExtraServicesTotal() {
        var checkboxes = document.querySelectorAll('input[name="extra_services[]"]:checked');
        var total = 0;
        checkboxes.forEach(function(checkbox) {
            var price = parseFloat(checkbox.parentNode.querySelector('.price-value').textContent);
            total += price;
        });
        return total;
    }
//

    // Lắng nghe sự kiện khi số lượng người lớn hoặc trẻ em thay đổi
    var inputElements = document.querySelectorAll('input[name="b_number_adults"], input[name="b_number_children"], input[name="b_number_child6"], input[name="b_number_child2"]');
    inputElements.forEach(function(inputElement) {
        inputElement.addEventListener('change', updateTotalPrice);
    });

    // Lắng nghe sự kiện khi dịch vụ đi kèm thay đổi
    var checkboxes = document.querySelectorAll('input[name="extra_services[]"]');
    checkboxes.forEach(function(checkbox) {
        checkbox.addEventListener('change', updateTotalPrice);
    });


   //Hàm áp dụng mã giảm
   function applyDiscount() {
    var discountCode = document.getElementById('cc_code').value;
    var totalPriceElement = document.getElementById('total-price');
    var originalPriceElement = document.getElementById('original-price');
    var discountedPriceContainer = document.getElementById('discounted-price-container');
    var discountedPriceElement = document.getElementById('discounted-price');
    var discountCodeIdInput = document.getElementById('discountCodeId');
    var totalPriceInput = document.getElementById('totalPrice');

    $.ajax({
        url: '/apply-discount',
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            cc_code: discountCode,
            total_price: parseFloat(totalPriceElement.textContent.replace(' VNĐ', '').trim()) // Adjusted to handle ' VNĐ' suffix
        },
        success: function(response) {
            if (response.success) {
                var totalPrice = parseFloat(totalPriceElement.textContent.replace(' VNĐ', '').trim());
         


                // Apply discount and update displayed prices
                var discountedPrice = totalPrice - response.discountAmount;
                originalPriceElement.textContent = totalPrice.toFixed(0) + ' VNĐ';
                discountedPriceElement.textContent = discountedPrice.toFixed(0) + ' VNĐ';
                discountedPriceContainer.style.display = 'block';

                // Update total price
                totalPriceElement.textContent = discountedPrice.toFixed(0) + ' VNĐ';

                // Update hidden inputs
                discountCodeIdInput.value = response.discountCodeId;
                totalPriceInput.value = discountedPrice.toFixed(0);
                // Tính số tiền giảm giá
                var discountAmount = totalPrice - discountedPrice;

                                // Hiển thị số tiền giảm giá
                document.getElementById('discount-amount').textContent = discountAmount.toFixed(0) + ' VNĐ';
                document.getElementById('discount-amount-container').style.display = 'block';
                // Display the remove discount button
                document.getElementById("removeDiscountButton").style.display = "block";
            } else {
                alert(response.message || 'Đã có lỗi xảy ra trong quá trình xử lý.');
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log("Error:", textStatus, errorThrown);
            alert('Đã có lỗi xảy ra trong quá trình xử lý.');
        }
            });
        // Khóa input số lượng người
        document.getElementById('b_number_adults').readOnly = true;
        document.getElementById('b_number_children').readOnly = true;
        document.getElementById('b_number_child6').readOnly = true;
        document.getElementById('b_number_child2').readOnly = true;

        // Khóa checkbox dịch vụ
        var checkboxes = document.querySelectorAll('input[name="extra_services[]"]');
        checkboxes.forEach(function(checkbox) {
            checkbox.disabled = true;
        });

        }
            var adultInput = document.getElementById('b_number_adults');
            var childrenInput = document.getElementById('b_number_children');
            var child6Input = document.getElementById('b_number_child6');
            var child2Input = document.getElementById('b_number_child2');

            function updateCounts() {
                var adultCount = parseInt(adultInput.value);
                var childrenCount = parseInt(childrenInput.value);
                var child6Count = parseInt(child6Input.value);
                var child2Count = parseInt(child2Input.value);

                document.getElementById('adult-count').textContent = adultCount;
                document.getElementById('children-count').textContent = childrenCount;
                document.getElementById('child6-count').textContent = child6Count;
                document.getElementById('child2-count').textContent = child2Count;
            }

            adultInput.addEventListener('change', updateCounts);
            childrenInput.addEventListener('change', updateCounts);
            child6Input.addEventListener('change', updateCounts);
            child2Input.addEventListener('change', updateCounts);


    // Hàm xử lý khi hủy giảm giá
    function removeDiscount() {
    var totalPriceElement = document.getElementById('total-price');
    var originalPriceElement = document.getElementById('original-price');
    var discountedPriceContainer = document.getElementById('discounted-price-container');
    var discountCodeIdInput = document.getElementById('discountCodeId');
    var totalPriceInput = document.getElementById('totalPrice');

    // Reset the displayed prices to their original values
    var originalPrice = parseFloat(originalPriceElement.textContent.replace(' VNĐ', '').trim());
    originalPriceElement.textContent = originalPrice.toFixed(0) + ' VNĐ';
    discountedPriceContainer.style.display = 'none';

    // Reset the total price to its original value
    totalPriceElement.textContent = originalPrice.toFixed(0) + ' VNĐ';

    // Clear the discount code ID and total price in hidden inputs
    discountCodeIdInput.value = "";
    totalPriceInput.value = originalPrice.toFixed(0);

    // Hide the remove discount button
    document.getElementById("removeDiscountButton").style.display = "none";
       // Thêm dòng sau vào hàm để mở khóa input số lượng người
    document.getElementById('b_number_adults').readOnly = false;
    document.getElementById('b_number_children').readOnly = false;
    document.getElementById('b_number_child6').readOnly = false;
    document.getElementById('b_number_child2').readOnly = false;
    // Mở khóa checkbox dịch vụ
var checkboxes = document.querySelectorAll('input[name="extra_services[]"]');
checkboxes.forEach(function (checkbox) {
    checkbox.disabled = false;
});
}



    </script>
    
</section>
@stop
@section('script')
@stop