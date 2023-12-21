<?php

use App\Models\QuoteHistory;
?>
<div class="container-fluid">

    <style>
        .hotel-item {
            display: flex;
            align-items: center;
            cursor: pointer;
            margin-bottom: 10px;
        }
        
        .hotel-checkbox {
            margin-left: auto;
        }
  
    /* CSS cho danh sách đã chọn */
    #selectedLocations {
        display: none;
        margin-top: 10px;
        font-weight: bold;
    }

    /* CSS cho mục đã chọn */
    .selected-item {
        background-color: #f2f2f2;
        padding: 5px;
        border: 1px solid #ddd;
        margin-bottom: 5px;
    }
    .hotel-list {
        max-height: 300px; /* Đặt chiều cao tối đa cho danh sách */
        overflow-y: auto; /* Sử dụng thanh cuộn khi danh sách vượt quá chiều cao tối đa */
    }
    .scrollable-list {
    max-height: 400px; /* Đặt chiều cao tối đa cho khung chứa */
    overflow-y: auto; /* Tạo thanh cuộn dọc khi cần */
}
h4.location-name {
        color: #333; /* Dark gray text color */
        font-size: 20px; /* Larger font size */
        font-weight: bold; /* Bold text */
    }

    /* Input Styles */
    #searchLocations {
        border: 2px solid #007BFF; /* Blue border */
        border-radius: 5px; /* Rounded corners */
        padding: 10px; /* Adequate padding */
    }

    /* Button Styles */
    .btn-primary {
        background-color: #007BFF; /* Blue background */
        border: none;
        border-radius: 5px;
        color: #fff; /* White text color */
        padding: 10px 20px; /* Padding for the button */
    }

    /* Location and Hotel Styles */
    .location-item {
        border: 1px solid #ddd; /* Light gray border */
        padding: 15px; /* Adequate spacing */
        margin: 10px 0; /* Margin between items */
        border-radius: 5px;
        background-color: #f9f9f9; /* Light background color */
    }

    .hotel-item {
        margin: 5px 0; /* Margin between hotel items */
    }

    .hotel-name {
        color: #555; /* Slightly darker text color */
        font-size: 16px; /* Smaller font size */
    }
    .form-control {
        border: 2px solid #007BFF; /* Blue border */
        border-radius: 5px; /* Rounded corners */
    }

    /* Scrollable List */
    .scrollable-list {
        max-height: 400px; /* Set a max height for scrollability */
        overflow-y: auto;
    }
    </style>
       @if($tour && isset($tour->t_type) && $tour->t_type == 1)    
       <button id="showQuoteHistoryBtn" class="btn btn-outline-primary">Lịch sử báo giá</button>
       <div id="quoteHistoryContainer">
           <!-- Nút "Lịch sử báo giá" đã được thêm ở bước 1 -->
           
           @if($tour && isset($tour->t_type) && $tour->t_type == 1)
           <div class="card-body" id="quoteHistoryTable" style="display: none;">
               @if($quoteHistory->count() >=0)
                   <h3>Lịch sử báo giá</h3>
                   <table class="table">
                       <thead>
                           <tr>
                               <th>Lần</th>
                               <th>Ngày</th>
                               <th>Giá người lớn</th>
                               <th>Giá trẻ em</th>
                               <th>Tình trạng</th>
                               <th>Gửi báo giá</th> <!-- Added column for "Gửi báo giá" button -->
                               <th>Hành động</th> <!-- Added column for "Gửi báo giá" button -->
                           </tr>
                       </thead>
                       <tbody>
                           @php
                               $stt = 1;
                           @endphp
                           @foreach($quoteHistory->sortBy('created_at') as $quote)
                               <tr>
                                   <td>{{ $stt++ }}</td>
                                   <td>{{ $quote->created_at->format('d/m/Y H:i:s') }}</td>
                           <td>
                            @if ($quote->adult_price == 0)
                                Đang cập nhật...
                            @else
                                {{ number_format($quote->adult_price, 0, ',', ' ') }} VND
                            @endif
                        </td>
                        <td>
                            @if ($quote->child_price == 0)
                                Đang cập nhật...
                            @else
                                {{ number_format($quote->child_price, 0, ',', ' ') }} VND
                            @endif
                        </td>
                                   <td>
                                       <div style="">
                                           <button style="background-color: 
                                           @if ($quote->status == 2)
                                               #ff0000; /* Màu cho trạng thái 0 */
                                           @elseif ($quote->status == 1)
                                               #00ff00; /* Màu cho trạng thái 1 */
                                           @elseif ($quote->status == 0)
                                               #0000ff; /* Màu cho trạng thái 2 */
                                           @else
                                               #007bff; /* Màu mặc định cho trạng thái khác */
                                           @endif
                                           color: #fff; border: none; padding: 10px 20px; cursor: pointer; border-radius: 5px;">
                                           {{ $status_quote[$quote->status] }}
                                       </button>
                                       
                                           @if($quote->reason)
                                               <div style="background-color: #f2f2f2; padding: 10px; border-radius: 5px; margin-top: 10px;">
                                                   Lý Do: {{ $quote->reason }}
                                               </div>
                                           @endif
                                       </div>
                                   </td>   <td>
                                   @if ($quote->status_admin == 0)
                                   <!-- Hiển thị nút "Gửi báo giá" -->
                                   <a class="btn btn-sm" style="background-color: #17a2b8; color: #fff;" href="{{ route('bao-gia', ['quote_id' => $quote->id]) }}">Gửi Báo giá</a>
                               @elseif ($quote->status_admin == 1)
                                   <!-- Hiển thị nút "Đã báo giá" -->
                                   <a class="btn btn-sm" style="background-color: #28a745; color: #fff;">Đã báo giá</a>
                               @endif </td>
                                   <td>  
                                    <a class="btn btn-danger btn-sm btn-delete btn-confirm-delete" href="{{ route('quote.delete', $quote->id) }}">
                                    <i class="fas fa-trash-alt"></i>
                                </a></td>
                               </tr>
                               
                           @endforeach
                       </tbody>
                   </table>
                
                   <!-- Hiển thị dòng để tạo báo giá khi nút "Tạo báo giá" được bấm -->
                   <tr id="createQuoteRow" style="display: none;">
                    <td>{{ $stt++ }}</td>
                    <td>
                        <!-- Hiển thị form để nhập thông tin mới -->
                        <form action="{{ route('create-quote') }}" method="POST">
                            @csrf
                        {{--   <input type="text" name="adult_price" class="form-control" placeholder="Giá người lớn">
                            <input type="text" name="child_price" class="form-control" placeholder="Giá trẻ em">--}} 
                            <input type="hidden" name="tour_id" value="{{ $tour->id }}">
                            <button type="submit" class="btn btn-sm btn-success">Tạo báo giá</button>
                        </form>
                    </td>
                </tr>
                
                <script>
                    document.getElementById('createQuoteBtn').addEventListener('click', function() {
                        document.getElementById('createQuoteRow').style.display = 'table-row';
                    });
                </script>
               @else
                   <p>Chưa có lịch sử báo giá cho tour này.</p>
               @endif
           </div>
           @endif
       </div> 
       @endif
       @if($tour)
       <button id="toggleEventDateButton"  class="btn btn-outline-primary">Thông tin chung</button>
       <button id="toggleTourItineraryButton"  class="btn btn-outline-primary">Chương Trình tour</button>
       <button id="toggleTourEventButton" class="btn btn-outline-primary">Lịch khởi hành</button>
       <button id="toggleTourImagesButton" class="btn btn-outline-primary">Hình ảnh tour</button>
       <div id="tourItineraryContent" style="display: none;">
           @include('admin.tour.eventdate.tour_itineraries')
       </div>
       <div id="tourImagesContent" style="display: none;">
           @include('admin.tour.eventdate.tour_images')
       </div>
       <div id="tourEventContent" style="display: none;">
           @include('admin.tour.eventdate.index')
       </div>
       <div id="eventDateContent" class="card" style="display: none;">
             @endif
       <form role="form" action="" method="post" enctype="multipart/form-data">   <div class="row">
                <div class="col-md-9" >       
                       <div class="card card-primary">
                    <!-- form start -->
                    <div class="card-body">
                    @csrf  
                
                        @if(isset($tour) && $tour->updated_at)
                        Thời gian cập nhật gần nhất: {{ $tour->updated_at->format('H:i:s, d/m/Y') }}
                    @endif   
                        @if(isset($tour) && $tour->t_note)
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title"> Yêu cầu tour</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <textarea class="form-control" placeholder="" name="t_note" style="overflow: visible; white-space: normal; height: 300px; ">{{ old('t_note', isset($tour) ? $tour->t_note : '') }}</textarea>
                                    <span class="text-danger"><p class="mg-t-5">{{ $errors->first('t_note') }}</p></span>
                                </div>
                    </div>
                </div>@endif
              
            
                        <div class="form-group {{ $errors->first('t_title') ? 'has-error' : '' }} ">
                            <label for="inputEmail3" class="control-label default">Tên tour <sup class="text-danger">(*)</sup></label>
                            <div>
                                <input type="text" class="form-control"  placeholder="Tiêu tour" name="t_title" value="{{ old('t_title',isset($tour) ? $tour->t_title : '') }}">
                                <span class="text-danger "><p class="mg-t-5">{{ $errors->first('t_title') }}</p></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
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
                                    <span class="text-danger"><p class="mg-t-5">{{ $errors->first('t_tourtype_id') }}</p></span>
                                </div>
                            </div>
                 
            
                       
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label>Trạng thái</label>
                                    <select class="custom-select" name="t_status">
                                        @foreach($status as $key => $statu)
                                            <option
                                                    {{old('t_status', isset($tour->t_status ) ? $tour->t_status : '') == $key ? 'selected="selected"' : ''}}
                                                    value="{{$key}}"
                                            >
                                                {{$statu}}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger"><p class="mg-t-5">{{ $errors->first('t_status') }}</p></span>
                                </div>
                            </div>
                        </div> 

                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group {{ $errors->first('t_day') || $errors->first('t_night') ? 'has-error' : '' }}">
                                    <label class="control-label default">Lịch trình <sup class="text-danger">(*)</sup></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <input type="number" class="form-control" placeholder="Số ngày" name="t_day" value="{{ old('t_day', isset($tour) ? $tour->t_day : '') }}"> Ngày
                                            </span>
                                            <div class="input-group-text">
                                                <input type="number" class="form-control" placeholder="Số đêm" name="t_night" value="{{ old('t_night', isset($tour) ? $tour->t_night : '') }}"> Đêm
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <span class="text-danger"><p class="mg-t-5">{{ $errors->first('t_day') }}</p></span>
                                    <span class="text-danger"><p class="mg-t-5">{{ $errors->first('t_night') }}</p></span>
                                </div> 
                             </div>
                                <div class="col-sm-12 col-md-3">
                                    <div class="form-group">
                                        <label>Số lượng người tham gia <sup class="text-danger">(*)</sup></label>
                                        <input type="text" class="form-control"  placeholder="" name="t_number_guests" value="{{ old('t_number_guests',isset($tour) ? $tour->t_number_guests : '') }}">

                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-3">
                                    <div class="form-group">
                                        <label>Số lượng người tối thiểu <sup class="text-danger">(*)</sup></label>
                                        <input type="text" class="form-control"  placeholder="" name="t_min_participants" value="{{ old('t_min_participants',isset($tour) ? $tour->t_min_participants : '') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <h3 class="text-center" style="font-size: 24px;">Dịch vụ Tour trọn gói</h3>
                                        <div class="service-list" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px;">
                                            @foreach ($services as $service)
                                                <div class="checkbox" style="display: flex; align-items: center;">
                                                    <input type="checkbox" name="service_ids[]" value="{{ $service->id }}" 
                                                        @if ($tour && is_array(json_decode($tour->service_ids, true)['selected_services']) && in_array($service->id, json_decode($tour->service_ids, true)['selected_services'])) checked @endif>
                                                    <span class="service-name">{{ $service->sv_name }}</span>
                                                    <textarea name="service_descriptions[{{ $service->id }}]" id="service_description_{{ $service->id }}" 
                                                        @if ($tour && isset(json_decode($tour->service_ids, true)['descriptions'][$service->id])) 
                                                            style="display: block;" 
                                                        @else
                                                            style="display: none;" 
                                                        @endif>{{ $tour && isset(json_decode($tour->service_ids, true)['descriptions'][$service->id]) ? json_decode($tour->service_ids, true)['descriptions'][$service->id] : '' }}</textarea>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <h4>Chọn phương tiện</h4>
                                        @foreach ($vehicles as $vehicle)
                                            <div class="checkbox">
                                                <input type="checkbox" name="vehicle_ids[]" value="{{ $vehicle->id }}" 
                                                    @if ($tour && is_array(json_decode($tour->vehicle_ids, true)) && in_array($vehicle->id, json_decode($tour->vehicle_ids, true))) checked @endif> 
                                                {{ $vehicle->v_name }}
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                  
                                <div class="col-sm-6">
                                    <h4>Chọn dịch vụ tour đi kèm</h4>
                                    @foreach ($extra_services as $service)
                                        <div class="service-checkbox">
                                            <input type="checkbox" name="selected_extraServices[]" value="{{ $service->id }}"
                                                {{ in_array($service->id, old('selected_extraServices', isset($tour) ? $tour->extra_services->pluck('id')->toArray() : [])) ? 'checked' : '' }}>
                                            {{ $service->sv_name }}
                                            <div class="price-form" style="display: none;">
                                                <label for="price_{{ $service->id }}">Nhập giá dịch vụ:</label>
                                                @php
                                                $value = isset($tour) ? $tour->extra_services->find($service->id) : null;
                                                $price = $value ? $value->pivot->price : null;
                                                $oldValue = old('service_prices.' . $service->id, $price);
                                                @endphp
                                                <input type="text" name="service_prices[{{ $service->id }}]" id="price_{{ $service->id }}" value="{{ $oldValue }}">VND
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                
                         <!-- Your HTML code remains the same -->

                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <div class="form-group">
                            <label for="searchLocations">Tìm kiếm điểm đến</label>
                            <input type="text" id="searchLocations" class="form-control" placeholder="Nhập tên điểm đến">
                        </div>
                        <span id="selectedLocations"></span>
                    </div>
                </div>
                <div class="location-list scrollable-list">
                    <div class="row">
                        @foreach ($locations as $location)
                            <div class="col-sm-6">
                                <div class="location-item" data-location-id="{{ $location->id }}">
                                    <h4 class="location-name" style="color: #ff0000;">{{ $location->l_name }}</h4>

                                    <div class="location-checkbox">
                                        <input type="checkbox" name="selected_locations[]" value="{{ $location->id }}"
                                            {{ in_array($location->id, old('selected_locations', isset($tour) ? $tour->locations->pluck('id')->toArray() : [])) ? 'checked' : '' }}>
                                    </div>
                                    <div class="hotel-list">
                                        <label>Chọn khách sạn</label>
                                        @foreach ($location->hotels as $hotel)
                                                <div class="hotel-checkbox">
                                                    <input type="checkbox" name="selected_hotels[]" value="{{ $hotel->id }}"
                                                        {{ in_array($hotel->id, old('selected_hotels', isset($tour) ? $tour->hotels->pluck('id')->toArray() : [])) ? 'checked' : '' }}>
                                                        {{ $hotel->h_name }}  
                                                     </div>
                                        @endforeach
                                    </div>
                                    <div>  
                                        <label>Chọn điểm du lịch</label>
                                        @foreach ($location->attractions as $attraction)
                                            <div class="checkbox">
                                                <input type="checkbox" name="attraction_ids[]" value="{{ $attraction->id }}" 
                                                    @if ($tour && is_array(json_decode($tour->attraction_ids, true)) && in_array($attraction->id, json_decode($tour->attraction_ids, true))) checked @endif> 
                                                {{ $attraction->at_name }}
                                            </div>
                                        @endforeach
                                    </div>
                                    
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
               

                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label>Giảm giá</label>
                                        <input type="number" max="100" class="form-control" placeholder="" name="t_sale" value="{{ old('t_sale',isset($tour) ? $tour->t_sale : 0) }}">
                                        <span class="text-danger"><p class="mg-t-5">{{ $errors->first('t_sale') }}</p></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label>Giá người lớn <sup class="text-danger">(*)</sup></label>
                                    <input type="number" class="form-control"  placeholder="" name="t_price_adults" value="{{ old('t_price_adults',isset($tour) ? $tour->t_price_adults : '') }}">
                                    <span class="text-danger"><p class="mg-t-5">{{ $errors->first('t_price_adults') }}</p></span>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label>Giá trẻ em <sup class="text-danger">(*)</sup></label>
                                        <input type="number" class="form-control"  placeholder="" name="t_price_children" value="{{ old('t_price_children',isset($tour) ? $tour->t_price_children : '') }}">
                                        <span class="text-danger"><p class="mg-t-5">{{ $errors->first('t_price_children') }}</p></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                     <div class="row">
                         <div class="col-sm-12 col-md-6">
                             <div class="form-group">
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
                                                           
                             <span class="text-danger"><p class="mg-t-5">{{ $errors->first('t_starting_gate') }}</p></span>
                             </div>
                           </div>
                
                </div>

                        <div class="form-group {{ $errors->first('t_description') ? 'has-error' : '' }} ">
                            <label for="inputEmail3" class="control-label default">Mô tả </label>
                            <div>
                                <textarea name="t_description" id="t_description" cols="30" rows="10" class="form-control" style="height: 225px;">{{ old('t_description', isset($tour) ? $tour->t_description : '') }}</textarea>
                                <script>
                                    ckeditor(t_description);
                                </script>
                                @if ($errors->first('t_description'))
                                    <span class="text-danger">{{ $errors->first('t_description') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group {{ $errors->first('t_content') ? 'has-error' : '' }} ">
                            <label for="inputEmail3" class="control-label default">Giới thiệu tour </label>
                            <div>
                                <textarea name="t_content" id="t_content" cols="30" rows="10" class="form-control" style="height: 225px;">{{ old('t_content', isset($tour) ? $tour->t_content : '') }}</textarea>
                                <script>
                                    ckeditor(t_content);
                                </script>
                                @if ($errors->first('t_content'))
                                    <span class="text-danger">{{ $errors->first('t_content') }}</span>
                                @endif
                            </div>
                        </div>
                        
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
            
                            <div class="col-md-3">
                            
                                <div class="card">
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
                                            @if(isset($tour) && !empty($tour->t_image))
                                                <img src="{{ asset(pare_url_file($tour->t_image)) }}" alt="" class="margin-auto-div img-rounded"  id="image_render" style="height: 150px; width:100%;">
                                            @else
                                                <img src="{{ asset('admin/dist/img/no-image.png') }}" alt="" class="margin-auto-div img-rounded"  id="image_render" style="height: 150px; width:100%;">
                                            @endif
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="btn-set">
                                            <button type="submit" name="submit" class="btn btn-info" onclick="return confirm('Bạn có chắc chắn muốn lưu không?');">
                                                <i class="fa fa-save"></i> Lưu
                                            </button>
                                            <button type="reset" name="reset" value="reset" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn reset không?');">
                                                <i class="fa fa-undo"></i> Reset
                                            </button>
                                            
                                        </div>
                                    </div>
                          
                                    <!-- /.card-body -->
                                </div>
                            </div>
                        </div>
                    </form>

                                
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
        <script>
            $(document).ready(function() {
$('.service-checkbox input[type="checkbox"]').each(function() {
 var priceForm = $(this).parent().find('.price-form');
 var priceInput = priceForm.find('input[type="text"]');

 // Kiểm tra giá trị của input giá
 if (priceInput.val() !== '') {
     priceForm.show();
     $(this).prop('checked', true);
 } else {
     priceForm.hide();
     $(this).prop('checked', false);
 }
});

$('input[type="checkbox"]').on('change', function() {
 var priceForm = $(this).parent().find('.price-form');
 if ($(this).is(':checked')) {
     priceForm.show();
 } else {
     priceForm.hide();
 }
});
});
     </script>
            @if($tour)
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var toggleEventDateButton = document.getElementById("toggleEventDateButton");
            var toggleTourItineraryButton = document.getElementById("toggleTourItineraryButton");
            var toggleTourImagesButton = document.getElementById("toggleTourImagesButton");
            var toggleTourEventButton = document.getElementById("toggleTourEventButton");
    
            var eventDateContent = document.getElementById("eventDateContent");
            var tourItineraryContent = document.getElementById("tourItineraryContent");
            var tourImagesContent = document.getElementById("tourImagesContent");
            var tourEventContent = document.getElementById("tourEventContent");
    
            var localStorageKey = "tourContentState";
            var savedContentState = localStorage.getItem(localStorageKey);
    
            // Default initial content state: event dates
            if (savedContentState === "tourItinerary") {
                eventDateContent.style.display = "none";
                tourItineraryContent.style.display = "block";
                tourImagesContent.style.display = "none";
                tourEventContent.style.display = "none";
    
                toggleTourItineraryButton.classList.add("active");
                toggleEventDateButton.classList.remove("active");
                toggleTourImagesButton.classList.remove("active");
                toggleTourEventButton.classList.remove("active");
            } else if (savedContentState === "tourImages") {
                eventDateContent.style.display = "none";
                tourItineraryContent.style.display = "none";
                tourImagesContent.style.display = "block";
                tourEventContent.style.display = "none";
    
                toggleTourItineraryButton.classList.remove("active");
                toggleEventDateButton.classList.remove("active");
                toggleTourImagesButton.classList.add("active");
                toggleTourEventButton.classList.remove("active");
            } else if (savedContentState === "tourEvent") {
                eventDateContent.style.display = "none";
                tourItineraryContent.style.display = "none";
                tourImagesContent.style.display = "none";
                tourEventContent.style.display = "block";
    
                toggleTourItineraryButton.classList.remove("active");
                toggleEventDateButton.classList.remove("active");
                toggleTourImagesButton.classList.remove("active");
                toggleTourEventButton.classList.add("active");
            } else {
                eventDateContent.style.display = "block";
                tourItineraryContent.style.display = "none";
                tourImagesContent.style.display = "none";
                tourEventContent.style.display = "none";
    
                toggleEventDateButton.classList.add("active");
                toggleTourItineraryButton.classList.remove("active");
                toggleTourImagesButton.classList.remove("active");
                toggleTourEventButton.classList.remove("active");
            }
    
            toggleEventDateButton.addEventListener("click", function () {
                eventDateContent.style.display = "block";
                tourItineraryContent.style.display = "none";
                tourImagesContent.style.display = "none";
                tourEventContent.style.display = "none";
    
                toggleEventDateButton.classList.add("active");
                toggleTourItineraryButton.classList.remove("active");
                toggleTourImagesButton.classList.remove("active");
                toggleTourEventButton.classList.remove("active");
    
                localStorage.setItem(localStorageKey, "eventDate");
            });
    
            toggleTourItineraryButton.addEventListener("click", function () {
                eventDateContent.style.display = "none";
                tourItineraryContent.style.display = "block";
                tourImagesContent.style.display = "none";
                tourEventContent.style.display = "none";
    
                toggleTourItineraryButton.classList.add("active");
                toggleEventDateButton.classList.remove("active");
                toggleTourImagesButton.classList.remove("active");
                toggleTourEventButton.classList.remove("active");
    
                localStorage.setItem(localStorageKey, "tourItinerary");
            });
    
            toggleTourImagesButton.addEventListener("click", function () {
                eventDateContent.style.display = "none";
                tourItineraryContent.style.display = "none";
                tourImagesContent.style.display = "block";
                tourEventContent.style.display = "none";
    
                toggleTourItineraryButton.classList.remove("active");
                toggleEventDateButton.classList.remove("active");
                toggleTourImagesButton.classList.add("active");
                toggleTourEventButton.classList.remove("active");
    
                localStorage.setItem(localStorageKey, "tourImages");
            });
    
            toggleTourEventButton.addEventListener("click", function () {
                eventDateContent.style.display = "none";
                tourItineraryContent.style.display = "none";
                tourImagesContent.style.display = "none";
                tourEventContent.style.display = "block";
    
                toggleTourItineraryButton.classList.remove("active");
                toggleEventDateButton.classList.remove("active");
                toggleTourImagesButton.classList.remove("active");
                toggleTourEventButton.classList.add("active");
    
                localStorage.setItem(localStorageKey, "tourEvent");
            });
        });
    </script>
    @endif
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
<script>
    // Hiển thị trường nhập mô tả cho các dịch vụ đã được chọn ban đầu
    var checkboxes = document.querySelectorAll('input[name="service_ids[]"]');
    checkboxes.forEach(function(checkbox) {
        var serviceId = checkbox.value;
        var descriptionInput = document.getElementById('service_description_' + serviceId);
        if (checkbox.checked) {
            descriptionInput.style.display = 'inline-block';
        } else {
            descriptionInput.style.display = 'none';
        }
        
        checkbox.addEventListener('change', function() {
            if (this.checked) {
                descriptionInput.style.display = 'inline-block';
            } else {
                descriptionInput.style.display = 'none';
            }
        });
    });
</script>
</div>

        
    
