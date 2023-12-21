<style>
      
    .sorting-options {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 20px 0;
        border-bottom: 1px solid #a71b1b;
    }

    .sorting-label {
        font-size: 18px;
        font-weight: bold;
        margin-right: 10px;
    }

    .sorting-radio-container {
        display: flex;
        align-items: center;
    }

    .sorting-radio {
        margin-right: 5px;
    }

    /* Đặt màu sắc cho radio button và label khi được chọn */
    .sorting-radio:checked + label {
        color: #007bff;
        font-weight: bold;
    }
</style>

<section class="">
<div class="container">
    <div class="sorting-options">
        <label class="sorting-label">Sắp xếp theo:</label>
        <div class="sorting-radio-container">
            <input type="radio" class="sorting-radio" id="default" name="sorting" value="default" checked>
            <label for="default">Mặc định</label>
        </div>
        <div class="sorting-radio-container">
            <input type="radio" class="sorting-radio" id="price_asc" name="sorting" value="price_asc">
            <label for="price_asc">Giá: Tăng dần</label>
        </div>
        <div class="sorting-radio-container">
            <input type="radio" class="sorting-radio" id="price_desc" name="sorting" value="price_desc">
            <label for="price_desc">Giá: Giảm dần</label>
        </div>
        <div class="sorting-radio-container">
            <input type="radio" class="sorting-radio" id="rating_desc" name="sorting" value="rating_desc">
            <label for="rating_desc">Đánh giá: Cao đến thấp</label>
        </div>
        <div class="sorting-radio-container">
            <input type="radio" class="sorting-radio" id="rating_asc" name="sorting" value="rating_asc">
            <label for="rating_asc">Đánh giá: Thấp đến cao</label>
        </div>
    </div>
    <!-- Nội dung khác trong phần section -->
</div>
</section>
{{--
<section class="">
<div class="container d-flex align-items-center">
    <img loading="lazy" width="56" height="60" src="https://www.bestprice.vn/assets/img/core-value/13-nam.png" alt="13 năm chặng đường">
    <div class="accomplishment-content" data-gtm-vis-has-fired-6393024_358="1" data-gtm-vis-first-on-screen-6393024_357="4456745" data-gtm-vis-total-visible-time-6393024_357="15700" data-gtm-vis-first-on-screen-6393024_356="4456748" data-gtm-vis-total-visible-time-6393024_356="5600" data-gtm-vis-recent-on-screen-6393024_357="4463876" data-gtm-vis-recent-on-screen-6393024_356="4463877" data-gtm-vis-has-fired-6393024_356="1" data-gtm-vis-has-fired-6393024_357="1">
        <p class="title"><strong>13</strong> năm chặng đường</p>
        <span class="description">CHINH PHỤC MỘT NIỀM TIN</span>
    </div>
    <div class="col-xs-12 col-sm-10 col-md-10 why-us" data-gtm-vis-has-fired-6393024_358="1" data-gtm-vis-first-on-screen-6393024_357="4456746" data-gtm-vis-total-visible-time-6393024_357="15700" data-gtm-vis-first-on-screen-6393024_356="4456749" data-gtm-vis-total-visible-time-6393024_356="5600" data-gtm-vis-recent-on-screen-6393024_357="4463876" data-gtm-vis-recent-on-screen-6393024_356="4463877" data-gtm-vis-has-fired-6393024_356="1" data-gtm-vis-has-fired-6393024_357="1">
        <div class="row" data-gtm-vis-has-fired-6393024_358="1" data-gtm-vis-first-on-screen-6393024_357="4456746" data-gtm-vis-total-visible-time-6393024_357="15700" data-gtm-vis-first-on-screen-6393024_356="4456749" data-gtm-vis-total-visible-time-6393024_356="5600" data-gtm-vis-recent-on-screen-6393024_357="4463876" data-gtm-vis-recent-on-screen-6393024_356="4463877" data-gtm-vis-has-fired-6393024_356="1" data-gtm-vis-has-fired-6393024_357="1">
            <div class="col-xs-3 col-sm-3 col-md-3 text-center why-us-item why-us-item-1" data-gtm-vis-has-fired-6393024_358="1" data-gtm-vis-first-on-screen-6393024_357="4456746" data-gtm-vis-total-visible-time-6393024_357="15700" data-gtm-vis-first-on-screen-6393024_356="4456749" data-gtm-vis-total-visible-time-6393024_356="5600" data-gtm-vis-recent-on-screen-6393024_357="4463876" data-gtm-vis-recent-on-screen-6393024_356="4463877" data-gtm-vis-has-fired-6393024_356="1" data-gtm-vis-has-fired-6393024_357="1">
                <img height="42" width="42" loading="lazy" src="https://www.bestprice.vn/assets/img/core-value/luon-co-gia-tot-2.png" alt="Luôn có giá tốt">
                <div class="title" data-gtm-vis-first-on-screen-6393024_358="4452077" data-gtm-vis-total-visible-time-6393024_358="3000" data-gtm-vis-first-on-screen-6393024_356="4452078" data-gtm-vis-total-visible-time-6393024_356="8800" data-gtm-vis-first-on-screen-6393024_357="4452079" data-gtm-vis-total-visible-time-6393024_357="18900" data-gtm-vis-has-fired-6393024_358="1" data-gtm-vis-recent-on-screen-6393024_356="4463837" data-gtm-vis-recent-on-screen-6393024_357="4463839" data-gtm-vis-has-fired-6393024_356="1" data-gtm-vis-has-fired-6393024_357="1">Luôn có giá tốt</div>
            </div>
            <div class="col-xs-3 col-sm-3 col-md-3 text-center why-us-item why-us-item-2" data-gtm-vis-has-fired-6393024_358="1" data-gtm-vis-first-on-screen-6393024_357="4456747" data-gtm-vis-total-visible-time-6393024_357="15700" data-gtm-vis-first-on-screen-6393024_356="4456749" data-gtm-vis-total-visible-time-6393024_356="5600" data-gtm-vis-recent-on-screen-6393024_357="4463876" data-gtm-vis-recent-on-screen-6393024_356="4463877" data-gtm-vis-has-fired-6393024_356="1" data-gtm-vis-has-fired-6393024_357="1">
                <img height="42" width="42" loading="lazy" src="https://www.bestprice.vn/assets/img/core-value/dam-bao-chat-luong-2.png" alt="Đảm bảo chất lượng">
                <div class="title" data-gtm-vis-first-on-screen-6393024_358="4452077" data-gtm-vis-total-visible-time-6393024_358="3000" data-gtm-vis-first-on-screen-6393024_356="4452078" data-gtm-vis-total-visible-time-6393024_356="8800" data-gtm-vis-first-on-screen-6393024_357="4452080" data-gtm-vis-total-visible-time-6393024_357="18900" data-gtm-vis-has-fired-6393024_358="1" data-gtm-vis-recent-on-screen-6393024_356="4463838" data-gtm-vis-recent-on-screen-6393024_357="4463840" data-gtm-vis-has-fired-6393024_356="1" data-gtm-vis-has-fired-6393024_357="1">Đảm bảo chất lượng</div>
            </div>
            <div class="col-xs-3 col-sm-3 col-md-3 text-center why-us-item why-us-item-3" data-gtm-vis-has-fired-6393024_358="1" data-gtm-vis-first-on-screen-6393024_357="4456747" data-gtm-vis-total-visible-time-6393024_357="15700" data-gtm-vis-first-on-screen-6393024_356="4456749" data-gtm-vis-total-visible-time-6393024_356="5600" data-gtm-vis-recent-on-screen-6393024_357="4463876" data-gtm-vis-recent-on-screen-6393024_356="4463878" data-gtm-vis-has-fired-6393024_356="1" data-gtm-vis-has-fired-6393024_357="1">
                <img height="42" width="42" loading="lazy" src="https://www.bestprice.vn/assets/img/core-value/am-hieu-tuyen-diem-2.png" alt="Am hiểu tuyến điểm, tận tình chu đáo">
                <div class="title" data-gtm-vis-first-on-screen-6393024_358="4452077" data-gtm-vis-total-visible-time-6393024_358="3000" data-gtm-vis-first-on-screen-6393024_356="4452079" data-gtm-vis-total-visible-time-6393024_356="8800" data-gtm-vis-first-on-screen-6393024_357="4452080" data-gtm-vis-total-visible-time-6393024_357="18900" data-gtm-vis-has-fired-6393024_358="1" data-gtm-vis-recent-on-screen-6393024_356="4463838" data-gtm-vis-recent-on-screen-6393024_357="4463840" data-gtm-vis-has-fired-6393024_356="1" data-gtm-vis-has-fired-6393024_357="1">Am hiểu tuyến điểm, tận tình chu đáo</div>
            </div>
            <div class="col-xs-3 col-sm-3 col-md-3 text-center why-us-item why-us-item-4" data-gtm-vis-has-fired-6393024_358="1" data-gtm-vis-first-on-screen-6393024_357="4456747" data-gtm-vis-total-visible-time-6393024_357="15700" data-gtm-vis-first-on-screen-6393024_356="4456749" data-gtm-vis-total-visible-time-6393024_356="5600" data-gtm-vis-recent-on-screen-6393024_357="4463876" data-gtm-vis-recent-on-screen-6393024_356="4463877" data-gtm-vis-has-fired-6393024_356="1" data-gtm-vis-has-fired-6393024_357="1">
                <img height="42" width="42" loading="lazy" src="https://vegayacht.vn/wp-content/uploads/2020/02/icon-staff.png" alt="Nhân viên tận tâm">
                <div class="title" data-gtm-vis-first-on-screen-6393024_358="4452077" data-gtm-vis-total-visible-time-6393024_358="3000" data-gtm-vis-first-on-screen-6393024_356="4452078" data-gtm-vis-total-visible-time-6393024_356="8800" data-gtm-vis-first-on-screen-6393024_357="4452080" data-gtm-vis-total-visible-time-6393024_357="18900" data-gtm-vis-has-fired-6393024_358="1" data-gtm-vis-recent-on-screen-6393024_356="4463838" data-gtm-vis-recent-on-screen-6393024_357="4463840" data-gtm-vis-has-fired-6393024_356="1" data-gtm-vis-has-fired-6393024_357="1">Hướng dẫn viên tận tâm</div>
            </div>
        </div>
    </div>
</div>
--}}
</section>

