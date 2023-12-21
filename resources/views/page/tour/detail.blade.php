@extends('page.layouts.page')
@section('title', $tour->t_title)
@section('style')
@stop
@section('seo')
@stop
@section('content')

<?php

use App\Models\QuoteHistory;
?>
    <section class="ftco-section ftco-no-pt ftco-no-pb">
        <div class="container">
            <div class="col-md-9  text-left">
                <p class="breadcrumbs" style="margin-right: 10px;">
                    <span style="margin-right: 10px;"><a href="{{ route('page.home') }}">Trang chủ <i class="fa fa-chevron-right"></i></a></span>
                    <span style="margin-right: 10px;">Tours <i class="fa fa-chevron-right"></i></span>
                </p>
                
            </div>
            <div class="row">
                @if ($tour && isset($tour->t_type) && $tour->t_type == 1 )
    <button id="showQuoteHistoryBtn" class="btn btn-primary">Lịch sử báo giá</button>
    <div id="quoteHistoryContainer">
        <!-- Nút "Lịch sử báo giá" đã được thêm ở bước 1 -->
        @if ($tour && isset($tour->t_type) && $tour->t_type == 1 )
            <div class="card-body" id="quoteHistoryTable" style="display: none;">
                @if ($quoteHistory->count() > 0)
                    <h3>Lịch sử báo giá</h3>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Lần</th>
                                <th>Ngày</th>
                                <th>Giá người lớn</th>
                                <th>Giá trẻ em</th>
                                <th>Tình trạng</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $stt = 1;
                            @endphp
                            @foreach ($quoteHistory->sortBy('created_at') as $quote)
                                <tr>
                                    <td>{{ $stt++ }}</td>
                                    <td>{{ $quote->created_at->format('d/m/Y H:i:s') }}</td>
                                    <td>{{ number_format($quote->adult_price, 0, ',', ' ') }} VND</td>
                                    <td>{{ number_format($quote->child_price, 0, ',', ' ') }} VND</td>
                                    <td>
                                        <div style="background-color: 
                                            @php
                                                $statusColor = '#007bff'; // Màu mặc định cho trạng thái khác
                                                if ($quote->status == 2) {
                                                    $statusColor = '#ff0000'; // Màu cho trạng thái 0
                                                } elseif ($quote->status == 1) {
                                                    $statusColor = '#00ff00'; // Màu cho trạng thái 1
                                                } elseif ($quote->status == 0) {
                                                    $statusColor = '#0000ff'; // Màu cho trạng thái 2
                                                }
                                            @endphp
                                            {{ $statusColor }}; color: #fff; border: none; padding: 10px 20px; cursor: pointer; border-radius: 5px;">
                                            {{ $status_quote[$quote->status] }}
                                        </div>
                                        @if ($quote->reason)
                                            <div style="background-color: #f2f2f2; padding: 10px; border-radius: 5px; margin-top: 10px;">
                                                Lý Do: {{ $quote->reason }}
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p>Chưa có lịch sử báo giá cho tour này.</p>
                @endif
            </div>
        @endif
    </div>
@endif

@if ($tour && isset($tour->t_type) && $tour->t_type == 1 && $tour->quoteHistory()->latest()->first()->status == 0 && $tour->quoteHistory()->latest()->first()->status_admin == 1)
                    <td style="vertical-align: middle; width: 20%">
                    
                        @php
                        $quoteStatus = QuoteHistory::where('tour_id', $tour->id)->where('status', 1)->first();
                        $rejectedStatus = QuoteHistory::where('tour_id', $tour->id)->where('status', 2)->first();
                        $latestUpdate = $tour->updated_at;
                        $formattedUpdate = $latestUpdate->format('H:i:s, d/m/Y');
                    @endphp

                 
                       </td>
                       <td style="vertical-align: middle; width: 20%">
    
                            @foreach ($tour->quoteHistory_user as $quote)
                        
                            <form method="POST" action="{{ route('quote.processAction', ['id' => $quote->id]) }}">
                                @csrf
                                <input type="radio" name="action" value="approve" id="approve{{ $quote->id }}">
                                <label for="approve{{ $quote->id }}">Duyệt</label>
                        
                                <input type="radio" name="action" value="reject" id="reject{{ $quote->id }}">
                                <label for="reject{{ $quote->id }}">Từ chối</label>
                        
                                <div id="reason-input{{ $quote->id }}" style="display: none;">
                                    <input type="text" name="reason" placeholder="Lý do từ chối">
                                </div>
                        
                                <button type="submit">Cập nhật</button>
                            </form>
                        
                   @endforeach
              
                      @endif
                <div class="col-lg-12 ftco-animate mt-md-5 fadeInUp ftco-animated">
                    
                    <div class="custom-container">
             
                        <div class="d-flex flex-column align-items-center">
                            <img class="core-value" loading="lazy" width="93" height="75" alt="Đảm bảo chất lượng" src="https://www.bestprice.vn/assets/img/icon/icon-core-value-quality.png" style="position: absolute; top: 0; left: 12px;">
                            <div class="title mb-3" style="display: inline-block; font-size: 26px; font-weight: 600; color: #000; text-transform: uppercase; letter-spacing: 0.5px; line-height: 1.4; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2); background: linear-gradient(45deg, #ff5733, #ffde33); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">{{ $tour->t_title }}</div>

                            <div class="details d-flex justify-content-between align-items-center">
                                <div class="social-buttons">
                                    <div class="fb-like" data-href="{{ route('tour.detail', ['id' => $tour->id, 'slug' => safeTitle($tour->t_title)]) }}" data-width="" data-layout="button" data-action="like" data-size="small" data-share="false"></div>
                                    <div class="fb-share-button" data-href="{{ route('tour.detail', ['id' => $tour->id, 'slug' => safeTitle($tour->t_title)]) }}" data-layout="button_count" data-size="small">
                                        <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{ route('tour.detail', ['id' => $tour->id, 'slug' => safeTitle($tour->t_title)]) }}" class="fb-xfbml-parse-ignore">Chia sẻ</a>
                                    </div>
                                </div>
                                <div class="view-count">
                                    <span class="label">Lượt xem:</span>
                                    <span class="count">{{ $tour->t_views }}</span>
                                </div>
                                @if (Auth::guard('users')->check())
                                    @php
                                        $isFavorited = auth()->guard('users')->user()->favorites()->where('f_tour_id', $tour->id)->exists();
                                    @endphp
                                    <form action="{{ route('favorite.toggle', $tour) }}" method="POST" class="favorite-form">
                                        @csrf
                                        <button type="submit" class="btn btn-{{ $isFavorited ? 'danger' : 'primary' }}">
                                            <i class="fa {{ $isFavorited ? 'fas fa-heart' : 'far fa-heart' }}" aria-hidden="true"></i>
                                            {{ $isFavorited ? 'Đã yêu thích' : 'Yêu thích' }}
                                        </button>
                                    </form>
                                    <div class="favorite-count">
                                        {{ $tour->favorites()->count() }} <i class="fa fa-heart"></i> lượt yêu thích
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                </div>
                <div class="col-lg-8 ftco-animate fadeInUp ftco-animated">
                    <div class="description">
                        <div class="thumbnail-controls">
                            <div class="image-container" style="position: relative;">
                                @php
                                    $imageURL = $tour->t_image ? asset(pare_url_file($tour->t_image)) : ($tourImages->count() > 0 ? asset(pare_url_file($tourImages->first()->tm_image_url)) : asset('admin/dist/img/no-image.png'));
                                @endphp
                                <img src="{{ $imageURL }}" alt="" class="img-fluid large-image">
                            
                                <!-- Chất lượng hình ảnh đè lên -->
                                <img class="core-value" loading="lazy" width="93" height="75" alt="Đảm bảo chất lượng" src="https://www.bestprice.vn/assets/img/icon/icon-core-value-quality.png" style="position: absolute; top: 0; left: 0;">
                            </div>
                            
                    </div>
                 </div>
                    
                    <div class="description-thumbnails">
                        <div class="thumbnail-controls">
                            <button onclick="changeImage(-1)">&#60;</button>
                        </div>
                        <div class="thumbnail-wrapper">
                            @foreach ($tourImages as $image)
                                <img src="{{ $image->tm_image_url ? asset(pare_url_file($image->tm_image_url)) : asset('admin/dist/img/no-image.png') }}" alt="" class="thumbnail-img img-fluid" onclick="showLargeImage(this)">
                            @endforeach
                        </div>
                        <div class="thumbnail-controls">
                            <button onclick="changeImage(1)">&#62;</button>
                        </div>
                    </div>
                    
                                     
                    
                    <div class="content mt-4">
                        <ul class="nav nav-pills">
                            <li class="nav-item">
                                <a class="nav-link active" href="#journeys" data-toggle="tab">
                                    <div class="d-flex flex-row">
                                        <i class="fas fa-star mr-2"></i>
                                        <p class="mr-3">Điểm nhấn </p>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#schedule" data-toggle="tab">
                                    <div class="d-flex flex-row">
                                        <i class="far fa-calendar-alt mr-2"></i>
                                        <p class="mr-3">Chương trình tour</p>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#tour-introduction" data-toggle="tab">
                                    <div class="d-flex flex-row">
                                        <i class="fas fa-info-circle mr-2"></i>
                                        <p class="mr-3">Dịch vụ tour</p>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#menu" data-toggle="tab">
                                    <div class="d-flex flex-row">
                                        <i class="fas fa-bars mr-2"></i>
                                        <p class="mr-3">
                                            <span class="icon-title">Lịch khởi hành</span>
                                        </p>
                                    </div>
                                </a>
                            </li>
                            
                        </ul>
                        
            
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="journeys">
                                @if ($tour->attraction_ids)
                                @foreach (json_decode($tour->attraction_ids) as $attractionId)
                                    @php
                                    $attraction = \App\Models\Attraction::find($attractionId);
                                    @endphp
                      <p class="attraction-description">
                        <strong>{{ $attraction->at_name }}</strong><br>
                            {{ $attraction->at_description }}
                      </p>
                    
                                @endforeach
                            @endif
                                <p>{!! $tour->t_content !!}</p>
                                <p>{!! $tour->t_description !!}</p>
                                    <?php $number = $tour->t_number_guests - $tour->t_number_registered ?>
                                </table>
                            </div>
            
                            <div  class="tab-pane fade" id="schedule">
                                <!-- Display the tour itineraries here -->
                                @if(count($touritineraries) > 0)
                                <!-- Hiển thị lịch trình -->
                                <a href="{{ route('download.itineraries', ['tourId' => $tour->id]) }}">
                                    <i class="fas fa-download"></i> Tải về lịch trình
                                </a>
                                

                                @foreach($touritineraries as $itinerary)
                                    <div class="itinerary-item" data-day="{{ $itinerary->ti_day }}">
                                        <div class="day-content">
                                            <strong class="day">Ngày {{ $itinerary->ti_day }}</strong>
                                            <span class="content1">|{{ $itinerary->ti_content }}</span>
                                            <div class="day-destcription">
                                                <p class="itinerary-description">{!! $itinerary->ti_description !!}
                                                <img src="{{ asset(pare_url_file($itinerary->ti_images )) }}" alt="" style="max-width: 100%;"></p>
                                            </div>
                                          
                                        </div>

                                    </div>
                                @endforeach
                            @else
                                <!-- Hiển thị thông báo hoặc liên kết tải về -->
                                <img src="https://www.matbao.net/Content/images/LandingPageFreeVN/Gan_luoi.svg" alt="Hình ảnh mặc định">
                                <p>Chưa có lịch trình nào cho tour này.</p>
                                
                            @endif
                            
                            </div>
                            <!-- Add more tab panes as needed -->
                     
                        
                            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
                            <script>
                                $(document).ready(function() {
                                    // Hide all itinerary descriptions initially
                                    $(".itinerary-description").hide();
                            
                                    // Add click event to each itinerary item
                                    $(".itinerary-item").on("click", function() {
                                        var day = $(this).data("day");
                                        $(".itinerary-item").not(this).find(".itinerary-description").hide();
                                        $(this).find(".itinerary-description").toggle();
                                    });
                                });
                            </script>
                            
                            <div class="tab-pane fade" id="tour-introduction">
                                <h2 style="font-size: 18px; color: #0f0550;"><strong>Giá bao gồm</strong></h2>
                                @if ($tour->service_ids)
                                @php
                                    $serviceData = json_decode($tour->service_ids, true);
                                    $selectedServices = $serviceData['selected_services'];
                                    $descriptions = isset($serviceData['descriptions']) ? $serviceData['descriptions'] : [];
                                @endphp
                            
                                @if (!empty($selectedServices))
                                    @foreach ($selectedServices as $serviceId)
                                        @php
                                            $service = \App\Models\Service::find($serviceId);
                                            $description = isset($descriptions[$serviceId]) ? $descriptions[$serviceId] : '';
                                        @endphp
                            
                                        <div style="background-color: #f5f5f5; border: 1px solid #ccc; border-radius: 10px; margin-bottom: 15px; padding: 15px;">
                                            <strong style="font-size: 16px; color: #ff0000; margin-bottom: 10px; display: block;">{{ $service->sv_name }}</strong>
                                            <p style="font-size: 14px; color: #000000;">{{ $description }}</p>
                                        </div>
                            
                                    @endforeach
                                @else
                                    {{-- Xử lý khi mảng không có phần tử --}}
                                    <p>Không có dịch vụ nào được chọn</p>
                                @endif
                            @endif
                            
                            
                            <h3 style="border: 1px solid #ccc; padding: 10px; border-radius: 5px; background-color: #f1f1f1; color: #333; font-size: 18px; font-weight: bold;">Chính Sách Hoàn Hủy Tour</h3>

                            <ol style="margin-left: 20px; margin-bottom: 20px;">
                                <li>
                                    <strong>Trường hợp bị hủy bỏ do Du lịch Việt:</strong>
                                    <p>
                                        Nếu Du lịch Việt không thực hiện được chuyến du lịch, Du lịch Việt phải báo ngay cho khách hàng biết và thanh toán lại cho khách hàng toàn bộ số tiền khách hàng đã đóng trong vòng 3 ngày kể từ lúc việc thông báo hủy chuyến du lịch bằng tiền mặt hoặc chuyển khoản.
                                    </p>
                                </li>
                                <li>
                                    <strong>Trường hợp bị hủy bỏ do khách hàng:</strong>
                                    <ul style="margin-left: 20px;">
                                        <li>
                                            Trường hợp hủy chuyến du lịch ngay sau khi đăng ký đến 10 ngày trước ngày khởi hành, Quý khách sẽ chịu phạt 30% trên giá vé du lịch.
                                        </li>
                                        <li>
                                            Trường hợp hủy chuyến du lịch trong vòng từ 5 - 10 ngày trước ngày khởi hành, Quý khách sẽ chịu phí 50% trên giá vé du lịch.
                                        </li>
                                        <li>
                                            Trường hợp hủy chuyến du lịch trong vòng từ 3 - 5 ngày trước ngày khởi hành, Quý khách sẽ chịu phí 75% trên giá vé du lịch.
                                        </li>
                                        <li>
                                            Quý khách hủy chuyến du lịch trong vòng từ 0 - 3 ngày trước ngày khởi hành, Quý khách sẽ chịu phí 100% trên giá vé du lịch.
                                        </li>
                                    </ul>
                                </li>
                            </ol>
                            
                            <p style="margin-bottom: 10px;"><strong>Lưu ý:</strong> Trường hợp hủy tour do sự cố khách quan như thiên tai, dịch bệnh, hoãn và hủy chuyến của các phương tiện vận chuyển công cộng… Du lịch Việt sẽ không chịu trách nhiệm bồi thường thêm bất kỳ chi phí nào ngoài việc hoàn trả tiền tour.</p>
                            
                            <p style="margin-bottom: 10px;">Trên đây là mức phạt hủy tối đa, chi phí này có thể được giảm tùy theo điều kiện của từng nhà cung cấp dịch vụ cho Du lịch Việt.</p>
                            
                            <p style="margin-bottom: 10px;">Thời gian hủy chuyến du lịch được tính cho ngày làm việc, không tính thứ 7, Chủ Nhật và các ngày Lễ, Tết.</p>
                            
                            <h4 style="margin-bottom: 10px;">Trường hợp bất khả kháng</h4>
                            
                            <p>Nếu chương trình du lịch bị hủy bỏ hoặc thay đổi bởi một trong hai bên vì một lý do bất khả kháng (hỏa hoạn, thời tiết, tai nạn, thiên tai, chiến tranh, hoãn và hủy chuyến của các phương tiện vận chuyển công cộng…).</p>
                            </div>
                            
                            <div class="tab-pane fade" id="menu">
                                @if ($tour->eventdate->isNotEmpty())
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>STT</th>
                                            <th>Ngày khởi hành</th>
                                            <th>Giá từ</th>
                                            @if($tour->t_type!=1) <th>Số chỗ</th> @else <th>Chi tiết</th>  @endif
                                            @if($tour->t_type!=1)   <th>Book tour</th> @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tour->eventdate as $key => $eventdate)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>
                                               
                                                {{ date('d/m/Y H:i', strtotime($eventdate->td_start_date)) }}
                                            </td>
                                            
                                            <td>
                                                <strong>
                                                    @php
                                                    $calculatedPrice = $tour->t_price_adults - ($tour->t_price_adults * $tour->t_sale / 100);
                                                @endphp
                                                @if ($calculatedPrice == 0)
                                                    Đang cập nhật
                                                @else
                                                    {{ number_format($calculatedPrice, 0, ',', '.') }} VND
                                                @endif
                                                </strong>
                                                @if ($tour->t_sale > 0)
                                                    <br>
                                                    <del>{{ number_format($tour->t_price_adults, 0, ',', '.') }} VND</del>
                                                @endif
                                            </td>
                                            @if($tour->t_type!=1)
                                            <td>
                                                Còn {{number_format($tour->t_number_guests - $eventdate->number_registered)}} chỗ
                                                @if($eventdate->number_registered < $tour->t_number_guests)
                                                    <br> Đang đăng ký: {{ $eventdate->td_follow  }}
                                                @endif
                                                @if($number - $eventdate->td_follow < 2 && $eventdate->number_registered != $tour->t_number_guests)
                                                   <br> <a style="color:red"> Sắp hết </a>
                                                @endif
                                            </td>
                                            @endif
                                            <td>
                                                @if (($tour->t_status == 1 || $tour->t_status == 4))
                                                @if($tour->t_type!=1)
                                                @if ($eventdate->number_registered < $tour->t_number_guests )
                                                <a href="{{ route('book.tour', ['id' => $eventdate->id, 'slug' => safeTitle($tour->t_title)]) }}" class="btn btn-primary px-4 mr-3">
                                                    <i class="fas fa-shopping-cart"></i> Đặt Tour
                                                </a>
                                                
                                                @else
                                                <a href="{{ route('loi.loi') }}" class="btn btn-secondary disabled mr-4">Đã hết chỗ</a>
                                                @endif    @endif
                                                   @endif
                                                <a href="javascript:void(0)" class="btn btn-info show-details-btn">Chi tiết</a>
                                            </td>
                                        </tr>
                                        <tr class="details-row">
                                            <td colspan="5">
                                                <div class="details-collapse">
                                                    <table style="border-collapse: collapse; width: 100%; margin-top: 15px;" border="1">
                                                        <tbody>
                                                            <tr>
                                                                <td style="width: 10%;">Loại giá/Độ tuổi</td>
                                                                <td style="width: 20%;">Người lớn(trên 12 tuổi)</td>
                                                                <td style="width: 20%;">Trẻ em(6-12 tuổi)</td>
                                                                <td style="width: 20%;">Trẻ em(2-6 tuổi)</td>
                                                                <td style="width: 20%;">Sơ sinh(&lt;2 tuổi)</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="width: 10%;">Giá</td>
                                                                <td style="width: 20%;">
                                                                    @if ($tour->t_type == 1 && $tour->t_price_adults == 0)
                                                                        Đang cập nhật
                                                                    @else
                                                                        {{ number_format($tour->t_price_adults - ($tour->t_price_adults * $tour->t_sale / 100), 0, ',', '.') }} vnd
                                                                    @endif
                                                                </td>
                                                                <td style="width: 20%;">
                                                                    @if ($tour->t_type == 1 && $tour->t_price_children == 0)
                                                                        Đang cập nhật
                                                                    @else
                                                                        {{ number_format($tour->t_price_children - ($tour->t_price_children * $tour->t_sale / 100), 0, ',', '.') }} vnd
                                                                    @endif
                                                                </td>
                                                                <td style="width: 20%;">
                                                                    @if ($tour->t_type == 1 && $tour->t_price_children == 0)
                                                                        Đang cập nhật
                                                                    @else
                                                                        {{ number_format(($tour->t_price_children - ($tour->t_price_children * $tour->t_sale / 100)) * 50 / 100, 0, ',', '.') }} vnd
                                                                    @endif
                                                                </td>
                                                                <td style="width: 20%;">
                                                                    @if ($tour->t_type == 1 && $tour->t_price_children == 0)
                                                                        Đang cập nhật
                                                                    @else
                                                                        {{ number_format(($tour->t_price_children - ($tour->t_price_children * $tour->t_sale / 100)) * 25 / 100, 0, ',', '.') }} vnd
                                                                    @endif
                                                                </td>
                                                                
                                                            </tr>
                                                            <tr>
                                                                <td colspan="5" style="text-align: center; font-weight: bold; background-color: #f0f0f0;">
                                                                    @empty($eventdate->guide)
                                                                        Hướng dẫn viên: Đang cập nhật
                                                                    @else
                                                                        Hướng dẫn viên: {{ $eventdate->guide->name }}
                                                                    @endempty
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <form action="{{ route('update.tour') }}" method="post">
                                    @csrf
                                    @if ($tour->t_type == 1)
                                        <table class="table table-bordered">
                                            <tr>
                                                <td>
                                                    <label for="additional-requirement">Yêu cầu tour:</label>
                                                    <textarea name="t_note" id="additional-requirement" placeholder="Nhập yêu cầu thêm" style="height: 300px; width: 700px;">{{ $tour->t_note }}</textarea>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <button type="submit" class="btn btn-primary" name="update_button">Cập nhật</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    @if ($tour->updated_at)
                                                    <p class="badge badge-info" style="font-size: 16px; font-weight: bold;">
                                                        Thời gian cập nhật gần nhất: {{ $tour->updated_at->format('H:i:s, d/m/Y') }}
                                                    </p>
                                                    
                                                    @endif
                                                </td>
                                            </tr>
                                            <input type="hidden" name="id" value="{{ $tour->id }}">
                                        </table>
                                    @endif
                                </form>
                                
                                
                                <script>
                                    $(document).ready(function() {
                                        // Ẩn tất cả các phần tử nội dung chi tiết ban đầu
                                        $(".details-collapse").hide();
                                
                                        // Xử lý sự kiện khi nhấp vào nút "Chi tiết"
                                        $(".show-details-btn").click(function() {
                                            // Tìm phần tử chứa chi tiết tương ứng
                                            var detailsCollapse = $(this).closest("tr").next(".details-row").find(".details-collapse");
                                
                                            // Ẩn tất cả các phần tử chi tiết khác
                                            $(".details-collapse").not(detailsCollapse).slideUp();
                                
                                            // Hiển thị hoặc ẩn phần tử chi tiết tương ứng
                                            detailsCollapse.slideToggle();
                                        });
                                    });
                                </script>
                                
                                @else
                                <div class="no-schedule-message">
                                    <img src="https://www.matbao.net/Content/images/LandingPageFreeVN/Gan_luoi.svg" alt="Hình ảnh mặc định">
                                    <p>Chưa có lịch khởi hành cho tour này.</p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="pt-5 mt-5 py-5" style="border-top: 1px solid #ccc;">
                        @php
                        $commentCount = $tour->comments->whereNotNull('cm_rating')->count();
                        $totalRating = $tour->comments->whereNotNull('cm_rating')->sum('cm_rating');
                        $avgRating = $commentCount > 0 ? round($totalRating / $commentCount, 1) : 0;
                    @endphp
                    
                    @if ($avgRating > 0)
                        <span class="font-weight-bold">Điểm đánh giá:</span>
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= $avgRating)
                                <span class="fa fa-star checked" style="color: gold;"></span>
                            @else
                                @if ($i - $avgRating <= 0.5)
                                    <span class="fa fa-star-half" style="color: gold;font-family: 'FontAwesome';"></span>
                                @else
                                    <span class="fa fa-star unchecked" style="color: gray;"></span>
                                @endif
                            @endif
                        @endfor
                            
                    @php
                    $descriptions = [
                        "Tệ", 
                        "Chưa tốt",
                        "Bình thường",
                        "Tốt",
                        "Xuất sắc"
                    ];
                @endphp
          <span style="font-size: 15px; font-weight: bold; font-family: 'Arial', sans-serif; color: #214c7a;">
            {{ $avgRating }} sao / {{ $descriptions[floor($avgRating) - 1] }}
        </span>
                       
                    @else
                    
                        <img src="https://www.matbao.net/Content/images/LandingPageFreeVN/Gan_luoi.svg" alt="Hình ảnh mặc định">
                            <span class="font-weight-bold">Chưa có đánh giá</span>
                        @endif                    
                        <h3 class="mb-3" style="font-size: 20px; font-weight: bold;">Danh sách đánh giá</h3>
                        <nav class="comment-rating navbar navbar-expand-lg navbar-light bg-light mb-5">
                            <ul class="navbar-nav mr-auto">
                                <li class="nav-item">
                                    <a class="nav-link selected" href="#" id="all-comments"><i class="fas fa-list"></i> Tất cả</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#" id="5-star-comments"><i class="fas fa-star"></i> 5 sao</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#" id="4-star-comments"><i class="fas fa-star"></i> 4 sao</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#" id="3-star-comments"><i class="fas fa-star"></i> 3 sao</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#" id="2-star-comments"><i class="fas fa-star"></i> 2 sao</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#" id="1-star-comments"><i class="fas fa-star"></i> 1 sao</a>
                                </li>
                                
                                <!-- Các liên kết số sao khác tương tự -->
                                
                            </ul>
                        </nav>
                        
                        
                        
                        <ul class="comment-list">
                            @if ($tour->comments->count() > 0)
                                @foreach($tour->comments as $key => $comment)
                                <li class="comment" data-rating="{{ $comment->cm_rating }}">
                                    @include('page.common.itemComment', compact('comment'))
                                </li>
                                @endforeach
                            @endif
                        </ul>



                        <!-- END comment-list -->
                 
                        
                        
                    

                        <div class="comment-form-wrap pt-5 mt-4">
                            <h3 class="mb-5" style="text-align: center;" style="font-size: 20px; font-weight: bold;">
                                {{ Auth::guard('users')->check() ? 'Để lại bình luận của bạn' : 'Bạn cần đăng nhập để bình luận' }}
                            </h3>
                            @if (Auth::guard('users')->check())
                                <!-- Kiểm tra xem có một đơn đặt tour cụ thể đã tồn tại -->
                                <form action="#" class="p-5 bg-light" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="cm_rating" id="rating-input" value="">
                                 {{--   <div class="form-group">
                                        <label for="stars">Đánh giá:</label>
                                        <div class="stars" data-rating="0">
                                            <span class="star" data-value="1"><i class="fa fa-star"></i></span>
                                            <span class="star" data-value="2"><i class="fa fa-star"></i></span>
                                            <span class="star" data-value="3"><i class="fa fa-star"></i></span>
                                            <span class="star" data-value="4"><i class="fa fa-star"></i></span>
                                            <span class="star" data-value="5"><i class="fa fa-star"></i></span>
                                        </div>
                                        <span id="rating-text"></span>
                                    </div> --}}
                                    <div class="form-group">
                                        <label for="message">Nội dung</label>
                                        <textarea name="cm_content" id="message" cols="30" rows="5" class="form-control"></textarea>
                                        <span class="text-errors-comment" style="display: none;">Vui lòng nhập nội dung bình luận !!!</span>
                                    </div>
                
                                    <div class="form-group">
                                        <input type="hidden" name="cm_tour_id" value="{{ $tour->id }}">
                                        <input type="hidden" name="cm_user_id" value="{{ Auth::guard('users')->user()->id }}">
                                        <input type="submit" value="Gửi bình luận" class="btn py-3 px-4 btn-primary btn-comment" tour_id="{{ $tour->id }}">
                                    </div>
                                </form>
                    
                            @endif
                        </div>
                        

                     
                    </div>
                </div> <!-- .col-md-8 -->
                <div class="col-lg-4">

                    <table class="table table-bordered boxDesign1">
                        <tr>
                            <td class="t_title" colspan="2" style="color: #cf5337; background-color: #f9dddd;">{{ $tour->t_title }}</td>
                        </tr>
                      
                              
                            <td width="40%"><strong><i class="fas fa-barcode" style="color: blue;"></i> Mã tour</strong></td>
                          <td>{{ $tour->t_code }}</td>
                        </tr>
                        <tr>
                          <td width="40%"><img src="https://travel.com.vn/Content/Theme/images/icons/thoi%20gian.png" alt="Phương tiện" width="20" height="20"  style="margin-right: 9px;"><strong>Hành trình</strong></td>
                          <td>{{ $tour->t_day }} ngày {{ $tour->t_night }} đêm</td>
                        </tr>

                        @if ($tour->hotels->isNotEmpty())
                        <tr>
                          <td width="40%"><i class="fas fa-hotel" style="color: #6464ffc7; margin-right: 9px;"></i><strong style="color: #000000c7;">Khách sạn</strong></td>
                          <td>
                            @foreach ($tour->hotels as $hotel)
                              <span >{{ $hotel->h_name }}</span><br>
                            @endforeach
                          </td>
                        </tr>
                        @endif
                        
                        <tr>
                            <td width="40%"> <img src="https://travel.com.vn/Content/Theme/images/icons/phuong%20tien%20di%20chuyen.png" alt="Phương tiện" width="20" height="20"  style="margin-right: 9px;"><strong>Phương tiện</strong> </td>
                            <td>
                                @if ($tour->vehicle_ids)
                                    @php
                                    $vehicleNames = [];
                                    foreach (json_decode($tour->vehicle_ids) as $vehicleId) {
                                        $vehicle = \App\Models\Vehicle::find($vehicleId);
                                        if ($vehicle) {
                                            $vehicleNames[] = $vehicle->v_name;
                                        }
                                    }
                                    $vehicleNamesString = implode(', ', $vehicleNames);
                                    @endphp
                                    {{ $vehicleNamesString }}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td width="50%">   <img src="https://travel.com.vn/Content/Theme/images/icons/diem%20tham%20quan.png" alt="Phương tiện" width="20" height="20" style="margin-right: 9px;"><strong>Điểm tham quan</strong> </td>
                            <td> 
                                @if ($tour->attraction_ids)
                                    @foreach (json_decode($tour->attraction_ids) as $attractionId)
                                        @php
                                        $attraction = \App\Models\Attraction::find($attractionId);
                                        @endphp
                                        {{ $attraction->at_name }}<br>
                                    @endforeach
                                @else    <strong><span class="unavailable" style="color: red;">Đang cập nhật...</span></strong>
                                @endif
                            </td>
                          </tr>
                          </tr>
                        <tr>
                            <td width="20%"><strong><i class="far fa-calendar-alt" style="color: #6464ffc7;"></i> Khởi hành</strong></td>
                            <td>
                                @if ($tour->eventdate->isEmpty())
                                <strong><span class="unavailable" style="color: red;">Đang cập nhật...</span></strong>

                                @else
                                    @foreach ($tour->eventdate as $eventdates)
                                        {{ date('d-m-Y', strtotime($eventdates->td_start_date)) }} <br>
                                    @endforeach
                                @endif
                            </td>
                            
                          <tr>
                            <td width="40%"><strong><i class="fas fa-map-marker-alt" style="color: #5b47c8e3;"></i> Nơi xuất phát</strong></td>
                            <td>{{ $tour->t_starting_gate }}</td>
                          </tr>
                        <tr>
                      </table>

                      <table class="table table-bordered boxDesign1">
                        <tr>
                            <td colspan="2" style="text-align: center; font-weight: bold; font-size: 20px; background-color: #007bff; color: #fff;">Dịch vụ sử dụng</td>
                        </tr>
                        @if ($tour->service_ids)
                        @php $selectedServices = json_decode($tour->service_ids, true)['selected_services']; @endphp
                    
                        @if (!empty($selectedServices))
                            @foreach ($selectedServices as $serviceId)
                                @php $service = \App\Models\Service::find($serviceId); @endphp
                                <td class="col-md-6">
                                    <span style="font-size: 32px; color: #007bff; font-weight: bold; text-align: center; line-height: 1.2;">✔</span>
                                    <i class="{{ $service->icon }}"></i>  {{ $service->sv_name }}
                                </td>
                                @if ($loop->iteration % 2 == 0)
                                    </tr><tr>
                                @endif
                            @endforeach
                        @else
                            {{-- Xử lý khi mảng không có phần tử --}}
                            <p>Không có dịch vụ nào được chọn</p>
                        @endif
                    @endif
                    
                    
                    </table>                    
                    
                    <div class="register-tour ">
                        @if (isset($tour))
                        @php
                            $price = $tour->t_price_adults - ($tour->t_price_adults * $tour->t_sale / 100);
                        @endphp
                        @if ($price == 0)
                            <p class="price-tour">Giá từ : <span>Đang cập nhật</span></p>
                        @else
                            <p class="price-tour">Giá từ : <span>{{ number_format($price, 0, ',', '.') }}</span> 🔥VND</p>
                        @endif
               
                        @if (($tour->t_status == 1 || $tour->t_status == 4) && $tour->t_type != 1)
                        <a href="{{ route('book.tour.user', ['id' => $tour->id, 'slug' => safeTitle($tour->t_title)]) }}" class="btn btn-primary py-3 px-4" style="width: 80%"><i class="fas fa-shopping-cart"></i> Đặt Ngày khác</a>
                    @endif
                        {{-- Sử dụng JavaScript để kích hoạt DatePicker --}}
               
                    @else
                        <p class="price-tour">Giá: 🔥 Liên hệ</p>
                        <a href="{{ route('loi.loi') }}" class="btn btn-primary py-3 px-4" style="width: 80%">Đã hết chỗ</a>
                    @endif
                    
                    </div>
                    
                    @if ($tours->count() > 0)
                        <div class="bg-light sidebar-box ftco-animate fadeInUp ftco-animated related-tour">
                            <h3>Danh Sách Tour Liên Quan</h3>
                            <?php $itemTour = 'item-related-tour' ?>
                            @foreach($tours as $tour)
                                @include('page.common.itemTour', compact('tour', 'itemTour'))
                            @endforeach
                        </div>
                    @endif
                </div>

            </div>
        </div>     
    </section>
   <script src="{{ asset('page/js/favorite.js') }}"></script>

   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  
   <script>
    $(document).ready(function () {
        $('form.favorite-form').on('submit', function (e) {
            e.preventDefault();
            var form = $(this);

            $.ajax({
                type: 'POST',
                url: form.attr('action'),
                data: form.serialize(),
                dataType: 'json',
                success: function (data) {
                    var button = form.find('button');
                    var icon = button.find('i.fa');
                    var favoriteCountElement = form.siblings('.favorite-count'); // Add a container for the favorite count

                    if (data.isFavorited) {
                        button.removeClass('btn-primary').addClass('btn-danger');
                        icon.removeClass('far fa-heart').addClass('fas fa-heart');
                        button.text('Đã yêu thích');
                    } else {
                        button.removeClass('btn-danger').addClass('btn-primary');
                        icon.removeClass('fas fa-heart').addClass('far fa-heart');
                        button.text('Yêu thích');
                    }

                    // Update the favorite count
                    favoriteCountElement.text(data.favoriteCount + ' lượt yêu thích');
                }
            });
        });
    });
   </script>
@if(isset($quote))
<script>
    const quoteId = {{ $quote->id }};
    const approveInput = document.getElementById(`approve${quoteId}`);
    const rejectInput = document.getElementById(`reject${quoteId}`);
    const reasonInput = document.getElementById(`reason-input${quoteId}`);

    // Xác minh trạng thái mặc định
    if (rejectInput.checked) {
        reasonInput.style.display = 'block';
    }

    approveInput.addEventListener('change', function() {
        reasonInput.style.display = 'none';
    });

    rejectInput.addEventListener('change', function() {
        reasonInput.style.display = 'block';
    });
</script>
@endif
   <script>
    $(document).ready(function() {
        // Xử lý khi người dùng nhấp vào liên kết "Tất cả"
        $("#all-comments").click(function(e) {
            e.preventDefault();
            // Loại bỏ lớp "selected" khỏi tất cả các liên kết
            $(".comment-rating a").removeClass("selected");
            // Hiển thị tất cả các bình luận
            $(".comment").show();
            // Đánh dấu liên kết được chọn
            $(this).addClass("selected");
        });
    
        // Xử lý khi người dùng nhấp vào liên kết "5 sao"
        $("#5-star-comments").click(function(e) {
            e.preventDefault();
            // Loại bỏ lớp "selected" khỏi tất cả các liên kết
            $(".comment-rating a").removeClass("selected");
            // Hiển thị các bình luận có data-rating bằng 5
            $(".comment").hide();
            $(".comment .starability-result[data-rating='5']").closest(".comment").show();
            // Đánh dấu liên kết được chọn
            $(this).addClass("selected");
        });
    
        // Xử lý khi người dùng nhấp vào liên kết "4 sao"
        $("#4-star-comments").click(function(e) {
            e.preventDefault();
            // Loại bỏ lớp "selected" khỏi tất cả các liên kết
            $(".comment-rating a").removeClass("selected");
            // Hiển thị các bình luận có data-rating bằng 4
            $(".comment").hide();
            $(".comment .starability-result[data-rating='4']").closest(".comment").show();
            // Đánh dấu liên kết được chọn
            $(this).addClass("selected");
        });
    
        // Xử lý khi người dùng nhấp vào liên kết "3 sao"
        $("#3-star-comments").click(function(e) {
            e.preventDefault();
            // Loại bỏ lớp "selected" khỏi tất cả các liên kết
            $(".comment-rating a").removeClass("selected");
            // Hiển thị các bình luận có data-rating bằng 3
            $(".comment").hide();
            $(".comment .starability-result[data-rating='3']").closest(".comment").show();
            // Đánh dấu liên kết được chọn
            $(this).addClass("selected");
        });
    
        // Xử lý khi người dùng nhấp vào liên kết "2 sao"
        $("#2-star-comments").click(function(e) {
            e.preventDefault();
            // Loại bỏ lớp "selected" khỏi tất cả các liên kết
            $(".comment-rating a").removeClass("selected");
            // Hiển thị các bình luận có data-rating bằng 2
            $(".comment").hide();
            $(".comment .starability-result[data-rating='2']").closest(".comment").show();
            // Đánh dấu liên kết được chọn
            $(this).addClass("selected");
        });
    
        // Xử lý khi người dùng nhấp vào liên kết "1 sao"
        $("#1-star-comments").click(function(e) {
            e.preventDefault();
            // Loại bỏ lớp "selected" khỏi tất cả các liên kết
            $(".comment-rating a").removeClass("selected");
            // Hiển thị các bình luận có data-rating bằng 1
            $(".comment").hide();
            $(".comment .starability-result[data-rating='1']").closest(".comment").show();
            // Đánh dấu liên kết được chọn
            $(this).addClass("selected");
        });
    });
</script>
<script>
    $(document).ready(function () {
        $("#showQuoteHistoryBtn").on("click", function () {
            // Kiểm tra trạng thái hiển thị của bảng lịch sử báo giá
            var isShown = $("#quoteHistoryTable").is(":visible");
            
            if (isShown) {
                // Nếu bảng đang hiển thị, ẩn nó khi bấm nút "Lịch sử báo giá" một lần nữa
                $("#quoteHistoryTable").hide();
            } else {
                // Nếu bảng không hiển thị, hiển thị nó khi bấm nút "Lịch sử báo giá"
                $("#quoteHistoryTable").show();
            }
        });
    });
    </script>
@stop
@section('script')
@stop