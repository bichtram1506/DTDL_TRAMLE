@extends('page.layouts.page')
@section('title', 'Tour yêu thích - Tin tức Du lịch - Thông tin Du lịch, Tin tức Du Lịch Việt Nam 2021')
@section('style')
@stop
@section('seo')
@stop
@section('content')

    <section class="ftco-section ftco-no-pt ftco-no-pb">
        <div class="container">
            <div class="row" style="margin-right: -100px;">
                @include('page.common.sideBarUser')
                <div class="col-lg-12 ftco-animate">
                    <?php

                    use App\Models\QuoteHistory;
                    ?>
                    <h3 class="mb-0 bread text-center p-5">Tour Theo yêu cầu</h3>
                    <table class="table table-hover table-bordered my-tour">
                        <thead class="thead-dark">
                            <tr>
                                <th style="vertical-align: middle; width: 3%">STT</th>
                                <th style="vertical-align: middle;">Tour</th>
                                <th style="vertical-align: middle;">Thông tin</th>
                                <th style="vertical-align: middle;">Trạng thái</th>
                                <th style="vertical-align: middle;">Báo giá</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($requireTours as $requireTour)
                                <tr>
                                    <td style="vertical-align: middle; width: 3%">{{ $loop->iteration }}</td>
                                    <td style="vertical-align: middle; width: 30%">
                                        <p style="color: red; font-weight: bold;">
                                            Mã Tour: {{ $requireTour->t_code }}
                                        </p>
                                        
                                        <p><a href="{{ route('tour.detail', ['id' => $requireTour->id, 'slug' => safeTitle($requireTour->t_title)]) }}">{{ $requireTour->t_title }}</a></p>
                                       
                                    </td>
                                    <td style="vertical-align: middle; width: 10%">
                                     <p>Số chỗ : {{$requireTour->t_number_guests}}</p>
                                    </td>
                                    <td style="vertical-align: middle; width: 20%">
                                        <p>  {{ $statustour[$requireTour->t_status] }}</p>
                                        @php
                                        $quoteStatus = QuoteHistory::where('tour_id', $requireTour->id)->where('status', 1)->first();
                                        $rejectedStatus = QuoteHistory::where('tour_id', $requireTour->id)->where('status', 2)->first();
                                        $latestUpdate = $requireTour->updated_at;
                                        $formattedUpdate = $latestUpdate->format('H:i:s, d/m/Y');
                                    @endphp

                                    @if ($quoteStatus)
                                        <a class="btn btn-sm" style="background-color: #5a37e5; color: #fff;">Đã Duyệt</a>
                                        <span class="badge badge-info">Cập nhật gần đây: {{ $formattedUpdate }}</span>
                                    @elseif ($rejectedStatus)
                                        <a class="btn btn-sm" style="background-color: #FF0000; color: #fff;">Từ chối</a>
                                        <span class="badge badge-info">Cập nhật gần đây: {{ $formattedUpdate }}</span>
                                    @endif
                                       </td>
                                       <td style="vertical-align: middle; width: 20%">
                    
                                            @foreach ($requireTour->quoteHistory_user as $quote)
                                            <p>Trạng thái báo giá: {{ $quote->status }}</p>
                                        
                                            <form method="POST" action="{{ route('quote.processAction', ['id' => $quote->id]) }}">
                                                @csrf
                                                <input type="radio" name="action" value="approve" id="approve{{ $quote->id }}">
                                                <label for="approve{{ $quote->id }}">Chấp nhận báo</label>
                                        
                                                <input type="radio" name="action" value="reject" id="reject{{ $quote->id }}">
                                                <label for="reject{{ $quote->id }}">Từ chối</label>
                                        
                                                <div id="reason-input{{ $quote->id }}" style="display: none;">
                                                    <input type="text" name="reason" placeholder="Lý do từ chối">
                                                </div>
                                        
                                                <button type="submit">Cập nhật</button>
                                            </form>
                                        
                                            <script>
                                                const approveInput{{ $quote->id }} = document.getElementById(`approve{{ $quote->id }}`);
                                                const rejectInput{{ $quote->id }} = document.getElementById(`reject{{ $quote->id }}`);
                                                const reasonInput{{ $quote->id }} = document.getElementById(`reason-input{{ $quote->id }}`);
                                        
                                                // Xác minh trạng thái mặc định
                                                if (rejectInput{{ $quote->id }}.checked) {
                                                    reasonInput{{ $quote->id }}.style.display = 'block';
                                                }
                                        
                                                approveInput{{ $quote->id }}.addEventListener('change', function() {
                                                    reasonInput{{ $quote->id }}.style.display = 'none';
                                                });
                                        
                                                rejectInput{{ $quote->id }}.addEventListener('change', function() {
                                                    reasonInput{{ $quote->id }}.style.display = 'block';
                                                });
                                            </script>
                                            @endforeach
                                             
                                    
                                    
                                        @if ($requireTour->t_status == 4)
                                            <a href="{{ route('book.tour', ['id' => $requireTour->eventdate->first()->id, 'slug' => safeTitle($requireTour->t_title)]) }}" style="background-color: #ff1d2c; color: #fff; padding: 10px 20px; text-decoration: none;">
                                                <i class="fas fa-shopping-cart"></i> Đặt Tour
                                            </a>
                                        @endif
                                    </td>
                                    
                                </tr>
                            @endforeach
                        </tbody>
                        
                    </table>
                <div class="row mt-5">
                    <div class="col text-center">
                        <div class="block-27">
                    </div>
                    </div>
                </div>
            </div>
            <!-- .col-md-8 -->
        </div>
 
        
        
        
    </section>
@stop
@section('script')
@stop
