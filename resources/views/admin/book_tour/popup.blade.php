<div class="modal-body">
    <ul class="list-group">
      
            <li class="list-group-item">
                <div class="detail">
                    @if($bookTour->eventdate->tour->t_type==1)
                    <h2>Tour theo yêu cầu</h2>
                    @endif
                    <p><b><i class="fas fa-route"></i> Tour</b>: 
                        <a href="{{ route('tour.update', ['id' => $bookTour->eventdate->tour->id]) }}">
                            {{ isset($bookTour->eventdate->tour->t_title) ? $bookTour->eventdate->tour->t_title : '' }}
                        </a>
                    </p> 
                    <p style="color: red;">
                        <b><i class="far fa-calendar-alt"></i> Ngày dự kiến</b>: {{ $bookTour->eventdate->td_start_date }}
                        {{ $status_event[$bookTour->eventdate->td_status] }}
                      </p>
                    </div>
                @if (isset($extraServiceArray[$bookTour->id]) && count($extraServiceArray[$bookTour->id]) > 0)
                <ul>
                    <p><b>Dịch vụ tour kèm theo: <i class="fas fa-suitcase"></i></b></p>
                    @foreach ($extraServiceArray[$bookTour->id] as $extraService)
                        <li>
                            <div style="background-color: #f2f2f2; padding: 10px; margin-bottom: 10px; border-radius: 5px;">
                                <p style="margin: 0; color: #040303;">Dịch vụ: {{ $extraService['name'] }}</p>
                                <p style="margin: 0; color: #140c0c;">Giá: {{ $extraService['price'] }}</p>
                            </div>
                        </li>
                    @endforeach
                </ul>
                @endif

                <!-- Các phần tử khác -->

                @if ($bookTour->b_number_adults)
                <div class="detail">
                    <strong><i class="fas fa-user"></i> Số người lớn:</strong> {{ $bookTour->b_number_adults }} 
                    <strong><i class="fas fa-dollar-sign"></i> Giá/người:</strong> {{ $bookTour->b_price_adults > 0 ? number_format($bookTour->b_price_adults, 0, ',', '.') . ' VND' : 'Đang cập nhật' }}
                    <p><strong><i class="fas fa-money-bill-wave"></i> Thành tiền:</strong> {{ ($bookTour->b_number_adults * $bookTour->b_price_adults) > 0 ? number_format($bookTour->b_number_adults * $bookTour->b_price_adults, 0, ',', '.') . ' VND' : 'Đang cập nhật' }}</p>
                </div>
                @endif

                @if ($bookTour->b_number_children)
                <div class ="detail">
                    <b><i class="fas fa-child"></i> Số trẻ em:</b> {{ $bookTour->b_number_children }} 
                    <b><i class="fas fa-dollar-sign"></i> Giá trẻ em:</b> {{ $bookTour->b_price_children > 0 ? number_format($bookTour->b_price_children, 0, ',', '.') . ' VND' : 'Đang cập nhật' }}

                    <br> <!-- Xuống dòng cho thành tiền -->
                    <b><i class="fas fa-money-bill-wave"></i> Thành tiền trẻ em:</b> {{ ($bookTour->b_number_children * $bookTour->b_price_children) > 0 ? number_format($bookTour->b_number_children * $bookTour->b_price_children, 0, ',', '.') . ' VND' : 'Đang cập nhật' }}
                </div>
                @endif

                @if ($bookTour->b_number_child6)
                <div class="detail">
                    <b><i class="fas fa-child"></i> Số trẻ em (2-6 tuổi):</b> {{ $bookTour->b_number_child6 }} 
                    <b><i class="fas fa-dollar-sign"></i> Giá:</b> {{ $bookTour->b_price_child6 > 0 ? number_format($bookTour->b_price_child6, 0, ',', '.') . ' VND' : 'Đang cập nhật' }} <br>
                    <b><i class="fas fa-money-bill-wave"></i> Thành tiền:</b> {{ ($bookTour->b_number_child6 * $bookTour->b_price_child6) > 0 ? number_format($bookTour->b_number_child6 * $bookTour->b_price_child6, 0, ',', '.') . ' VND' : 'Đang cập nhật' }}
                </div>
                @endif

                @if ($bookTour->b_number_child2)
                <div class="detail">
                    <b><i class="fas fa-baby"></i> Số trẻ em (dưới 2 tuổi):</b> {{ $bookTour->b_number_child2 }} 
                    <b><i class="fas fa-dollar-sign"></i> Giá:</b> {{ $bookTour->b_price_child2 > 0 ? number_format($bookTour->b_price_child2, 0, ',', '.') . ' VND' : 'Đang cập nhật' }} <br>
                    <b><i class="fas fa-money-bill-wave"></i> Thành tiền:</b> {{ ($bookTour->b_number_child2 * $bookTour->b_price_child2) > 0 ? number_format($bookTour->b_number_child2 * $bookTour->b_price_child2, 0, ',', '.') . ' VND' : 'Đang cập nhật' }}
                </div>
                @endif
                <br>

                @if ($bookTour->selectedHotel)
                <p class="detail">
                    <b><i class="fas fa-hotel"></i> Khách sạn</b>: {{ $bookTour->selectedHotel->h_name }}
                    @if ($bookTour->selectedHotel->type)
                        <b><i class="fas fa-layer-group"></i> Loại khách sạn</b>: {{ $bookTour->selectedHotel->type->ht_name }}
                    @endif
                </p>
                @endif
                @if ($bookTour->b_note)
                <p class="detail">
                    <i class="fas fa-layer-group"></i>{{ $bookTour->b_note }}
                </p>
            @endif

                <!-- Các phần tử khác -->

                <!-- Thêm biểu tượng cho Tổng tiền -->
            

                <p><b>Phương thức thanh toán:</b>
                    @if ($bookTour->b_payment_method === 'cash')
                    <i class="fa fa-money"></i> Tiền mặt
                @elseif ($bookTour->b_payment_method === 'VNPay')
                    <i class="fa fa-bank"></i> Thanh toán VNPay
                    @elseif ($bookTour->b_payment_method === 'MOMO')
                    <i class="fa fa-mobile"></i> Thanh toán MOMO
                @elseif ($bookTour->b_payment_method === 'bankTransfer')
                    <i class="fa fa-university"></i> Chuyển khoản ngân hàng
                @endif
                </p>

                @if ($bookTour->couponCode)
                <div class="discount-info">
                  <p><b><i class="fas fa-tag"></i> Mã giảm giá:</b> {{ $bookTour->couponCode->cc_code }}</p>
                  @if ($bookTour->couponCode->cc_percentage > 0)
                  <p><b><i class="fas fa-percent"></i> Giảm giá:</b> {{ $bookTour->couponCode->cc_percentage }}%</p>
                  @endif
                  @php
                    $discountedAmount = ($bookTour->b_number_adults * $bookTour->b_price_adults) + ($bookTour->b_number_children * $bookTour->b_price_children) + ($bookTour->b_number_child6 * ($bookTour->b_price_children )) + ($bookTour->b_number_child2 * ($bookTour->b_price_children ));
                    $finalTotal =  $discountedAmount - $bookTour->b_total_price ;
                  @endphp
                <p><b><i class="fas fa-money-bill"></i> Số tiền đã giảm:</b> {{ number_format($finalTotal , 0, ',', '.') }} VND</p>
                
                </div>
              @endif
              <p class="total"><b><i class="fas fa-coins"></i> Tổng tiền</b>:{{ $bookTour->b_total_price > 0 ? number_format($bookTour->b_total_price, 0, ',', '.') . ' VND' : 'Đang cập nhật' }}</p>
                @if ($bookTour->b_note)
                <div class="detail">
                    <p><b>Ghi chú:</b>
                        {{ $bookTour->b_note }}</p>
                </div>
                @endif
                <!-- Thêm các thông tin chi tiết khác của mục đặt tour tại đây -->
                <hr>

                @if ($bookTour->payments)
                @foreach ($bookTour->payments as $payment)
                    <h3>  <strong class="text-center">Thông tin thanh toán</strong></h3>
                    <div class="discount-info">
                        <p>
                            <b><i class="fas fa-tag"></i> Số tiền</b> {{ $payment->p_total_price }}
                        </p>
                        @if ($payment->p_vnp_response_code === "00")
                        <p>
                            <b><i class="fas fa-check-circle"></i> Trạng thái:</b> Thành công
                        </p>
                    @elseif ($payment->p_vnp_response_code === "22")
                        <p>
                            <b><i class="fas fa-check-circle"></i> Trạng thái:</b> Đã hoàn tiền
                        </p>
                    @else
                        <p>
                            <b><i class="fas fa-times-circle"></i> Trạng thái:</b> Thất bại
                        </p>
                    @endif
                        @if(isset($payment->p_code_vnpay))
                        <p>
                            <b><i class="fas fa-barcode"></i> Mã giao dịch</b> {{ $payment->p_code_vnpay }}
                        </p>
                    @endif
                    
                    @if(isset($payment->p_code_bank))
                        <p>
                            <b><i class="fas fa-university"></i> Ngân hàng</b> {{ $payment->p_code_bank }}
                        </p>
                    @endif
                        <p>
                            <b><i class="fas fa-tag"></i> Ngày thanh toán</b> {{ $payment->created_at }}
                        </p>
                    </div>
                @endforeach
                @endif
            </li>
       
    </ul>
</div>
