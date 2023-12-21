<style>
    /* CSS tùy chỉnh cho biểu mẫu tìm kiếm */
.custom-search-form {
    background-color:#d611111a;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 10px;
}

.custom-label {
    font-weight: bold;
    color: #333;
}

.custom-input,
.custom-select {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.custom-button {
    background-color: #007bff;
    color: #fff;
    font-weight: bold;
    border: none;
    border-radius: 5px;
    padding: 10px 20px;
    cursor: pointer;
}

.custom-button:hover {
    background-color: #0056b3;
}

    </style>
<form action="{{ route('hotel') }}" class="custom-search-form">
    <div class="form-row ">
        <div class="form-group col-md-4">
            <label for="key_hotel" class="custom-label">Tìm khách sạn giá tốt</label>
            <input type="text" name="key_hotel" class="form-control custom-input" id="key_hotel" placeholder="Tên khách sạn">
        </div>
        <div class="form-group col-md-3">
            <label class="custom-label">Địa điểm</label>
            <div class="form-field">
                <div class="select-wrap">
                    <div class="icon"></div>
                    <select name="location_id" id="" class="form-control">
                        <option value="">Chọn địa điểm</option>
                        @foreach($locations as $location)
                            <option value="{{ $location->id }}">{{ $location->l_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="form-group col-md-3">
            <label for="price" class="custom-label">Khoảng giá</label>
            <select name="price" id="price" class="form-control custom-select">
                <option value="">Chọn khoảng giá</option>
                <option value="0-1000000">0->1.000.000</option>
                <!-- Thêm các tùy chọn khoảng giá khác ở đây -->
            </select>
        </div>
        <div class="form-group col-md-3">
            <label for="check_in" class="custom-label">Ngày nhận phòng</label>
            <input type="date" name="check_in" class="form-control custom-input" id="check_in">
        </div>
        <div class="form-group col-md-3">
            <label for="check_out" class="custom-label">Ngày trả phòng</label>
            <input type="date" name="check_out" class="form-control custom-input" id="check_out">
        </div>
        <div class="col-lg d-flex">
            <div class="form-group p-4">
            
                <div class="form-field">
                    <div class="select-wrap">
                  
                        <select name="hoteltype_id" id="" class="form-control">
                            <option value="">Chọn loại khách sạn</option>
                            @foreach($hoteltypes as $hoteltype)
                            <option value="{{ $hoteltype->id }}">{{ $hoteltype->ht_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group col-md-2 align-self-end mb-2">
            <button type="submit" class="btn btn-primary custom-button">Tìm kiếm</button>
        </div>
    </div>
</form>
