<form action="{{ route('tour') }}" class="search-property-1">

    <div class="row no-gutters">
        <div class="col-md d-flex">
            <div class="form-group p-4 border-0">
                <label for="#">Tour</label>
                <div class="form-field">
                    <div class="icon"><span class="fa fa-search"></span></div>
                    <input type="text" name="key_tour" value="{{ Request::get('key_tour') }}" class="form-control" placeholder="Tìm kiếm">
                </div>
            </div>
        </div>
        <div class="col-md d-flex">
            <div class="form-group p-4">
                <label for="#">Ngày Khởi Hành</label>
                <div class="form-field">
                    <div class="icon"><span class="fa fa-calendar"></span></div>
                    <input type="text" name="td_start_date" value="{{ Request::get('td_start_date') }}" class="form-control checkin_date" placeholder="Ngày Khởi Hành" autocomplete="off">
                </div>
            </div>
        </div>
        <div class="col-lg d-flex">
            <div class="form-group p-4">
                <label for="#">Điểm xuất phát</label>
                <div class="form-field">
                    <div class="icon"><span class="fa fa-map-marker"></span></div>
                    <select name="t_starting_gate" class="form-control">
                        <option value="">Điểm đi</option>
                        <option value="Hà Nội" {{ (Request::get('t_starting_gate') == 'Hà Nội') ? 'selected' : '' }}>Hà Nội</option>
                        <option value="Hồ Chí Minh" {{ (Request::get('t_starting_gate') == 'Hồ Chí Minh') ? 'selected' : '' }}>Hồ Chí Minh</option>
                        <option value="Đà Nẵng" {{ (Request::get('t_starting_gate') == 'Đà Nẵng') ? 'selected' : '' }}>Đà Nẵng</option>
                        <option value="Nha Trang" {{ (Request::get('t_starting_gate') == 'Nha Trang') ? 'selected' : '' }}>Nha Trang</option>
                        <option value="Phú Quốc" {{ (Request::get('t_starting_gate') == 'Phú Quốc') ? 'selected' : '' }}>Phú Quốc</option>
                        <!-- Thêm các điểm đến khác vào đây -->
                    </select>                    
                </div>
            </div>
        </div>
  
        
        <div class="col-ld d-flex">
            <div class="form-group p-4">
                <label for="#">Khoảng giá</label>
                <div class="form-field">
                    <div class="select-wrap">
                        <div class="icon">
                            <span class="fa fa-chevron-down"></span>
                        </div>
                        <select name="price" id="price" class="form-control" style="width: 200px;">
                            <option value="">Chọn khoảng giá</option>
                            <option value="0-1000000" {{ Request::get('price') == '0-1000000' ? 'selected' : '' }}>Dưới 1,000,000 VNĐ</option>
                            <option value="1000000-2000000" {{ Request::get('price') == '1000000-2000000' ? 'selected' : '' }}>1,000,000 - 2,000,000 VNĐ</option>
                            <option value="2000000-3000000" {{ Request::get('price') == '2000000-3000000' ? 'selected' : '' }}>2,000,000 - 3,000,000 VNĐ</option>
                            <option value="3000000-4000000" {{ Request::get('price') == '3000000-4000000' ? 'selected' : '' }}>3,000,000 - 4,000,000 VNĐ</option>
                            <option value="4000000-5000000" {{ Request::get('price') == '4000000-5000000' ? 'selected' : '' }}>4,000,000 - 5,000,000 VNĐ</option>
                            <option value="5000000-6000000" {{ Request::get('price') == '5000000-6000000' ? 'selected' : '' }}>5,000,000 - 6,000,000 VNĐ</option>
                            <option value="6000000-7000000" {{ Request::get('price') == '6000000-7000000' ? 'selected' : '' }}>6,000,000 - 7,000,000 VNĐ</option>
                            <option value="7000000-8000000" {{ Request::get('price') == '7000000-8000000' ? 'selected' : '' }}>7,000,000 - 8,000,000 VNĐ</option>
                            <option value="8000000-9000000" {{ Request::get('price') == '8000000-9000000' ? 'selected' : '' }}>8,000,000 - 9,000,000 VNĐ</option>
                            <option value="9000000-10000000" {{ Request::get('price') == '9000000-10000000' ? 'selected' : '' }}>9,000,000 - 10,000,000 VNĐ</option>
                            <option value="10000000-11000000" {{ Request::get('price') == '10000000-11000000' ? 'selected' : '' }}>10,000,000 - 11,000,000 VNĐ</option>
                            <option value="11000000-12000000" {{ Request::get('price') == '11000000-12000000' ? 'selected' : '' }}>11,000,000 - 12,000,000 VNĐ</option>
                            <option value="12000000-13000000" {{ Request::get('price') == '12000000-13000000' ? 'selected' : '' }}>12,000,000 - 13,000,000 VNĐ</option>
                            <option value="13000000-14000000" {{ Request::get('price') == '13000000-14000000' ? 'selected' : '' }}>13,000,000 - 14,000,000 VNĐ</option>
                            <option value="14000000-15000000" {{ Request::get('price') == '14000000-15000000' ? 'selected' : '' }}>14,000,000 - 15,000,000 VNĐ</option>
                            <option value="15000000-16000000" {{ Request::get('price') == '15000000-16000000' ? 'selected' : '' }}>15,000,000 - 16,000,000 VNĐ</option>
                            <option value="16000000-20000000" {{ Request::get('price') == '16000000-20000000' ? 'selected' : '' }}>16,000,000 - 20,000,000 VNĐ</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
       
    </div>
    <div class="row no-gutters">
        <div class="col-md d-flex">
            <div class="form-group p-4 border-0">
                <label for="#">Số ngày</label>
                <div class="form-field">
                    <div class="icon"><span class="fa fa-search"></span></div>
                    <input type="number" name="t_day" value="{{ Request::get('t_day') }}" class="form-control" placeholder="Số ngày">
                </div>
            </div>
        </div>
        <div class="col-md d-flex"> 
            <div class="form-group p-4">
                <label for="#">Loại Tour</label>
                <div class="form-field">
                    <div class="select-wrap">
                        <div class="icon"><span class="fa fa-chevron-down"></span></div>
                        <select name="tourtype_id" id="" class="form-control" style="width: 200px;"> <!-- Adjust the width as needed -->
                            <option value="">Chọn Loại tour</option>
                            @foreach($tourtypes as $tourtype)
                                <option value="{{ $tourtype->id }}">{{ $tourtype->tt_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
        
       <div class="col-lg d-flex">
            <div class="form-group p-4">
                <label for="#">Địa điểm</label>
                <div class="form-field">
                    <div class="select-wrap">
                        <div class="icon"><span class="fa fa-chevron-down"></span></div>
                        <select name="location_id" id="" class="form-control"  style="width: 200px;">
                            <option value="">Chọn địa điểm</option>
                            @foreach($locations as $location)
                                <option value="{{ $location->id }}">{{ $location->l_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
            </div>
        </div> 
    <div class="col-md d-flex mt-1">
            <div class="form-group d-flex w-100 border-0">
                
                    <button type="submit" class="btn btn-primary border-0 w-100 align-items-center d-flex align-self-stretch form-control btn btn-primary">
                        Tìm kiếm
                        <i class="fas fa-search ml-2"></i>
                    </button>
                  
                </div>
            </div>
        </div> 
    </div>
</form>