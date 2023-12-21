@extends('page.layouts.page')
@section('title', 'Thông tin tài khoản - Tin tức Du lịch - Thông tin Du lịch, Tin tức Du Lịch Việt Nam 2021')
@section('style')

@stop
@section('seo')
@stop
@section('content')
<section class="ftco-section ftco-no-pt ftco-no-pb">
    <div class="container">
        <div class="row" style="margin-right: -100px;">
            @include('page.common.sideBarUser')
                    <!-- Cột bên trái (Thông tin tour) -->
                    <div class="col-md-4">
                        <div class="card">
                            <img src="{{ asset(pare_url_file($tour->t_image)) }}" alt="{{ $tour->t_title }}" class="card-img-top" style="max-height: 300px;">
                            <div class="card-body">
                                <h5 class="card-title">{{ $tour->t_title }}</h5>
                                <p class="card-text">Ngày khởi hành: {{ $eventdate->td_start_date }}</p>
                                <!-- Hiển thị thông tin tour khác nếu cần -->
                            </div>
                        </div>
                    </div>
                    <!-- Cột bên phải (Biểu mẫu đánh giá) -->
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Đánh giá tour</h5>
                                <form action="{{ route('submit.review') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="cm_booktour_id" value="{{ $bookTour->id }}">
                                    
                                    <!-- Hiển thị biểu mẫu đánh giá dưới dạng icon ngôi sao từ Font Awesome -->
                                    <div class="form-group">
                                        <label for="cm_rating">Đánh giá:</label>
                                        <div class="rating" id="ratingStars">
                                            <i class="fas fa-star" data-rating="1"></i>
                                            <i class="fas fa-star" data-rating="2"></i>
                                            <i class="fas fa-star" data-rating="3"></i>
                                            <i class="fas fa-star" data-rating="4"></i>
                                            <i class="fas fa-star" data-rating="5"></i>
                                        </div>
                                        
                                        <input type="hidden" name="cm_rating" id="selectedRating" value="0">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="cm_content">Nội dung đánh giá:</label>
                                        <textarea name="cm_content" id="cm_content" rows="8" class="form-control" required></textarea>
                                    </div>
                            
                                    <!-- Các trường khác của đánh giá (nếu có) -->
                                    
                                    <button class="btn btn-primary btn-block" type="submit">Gửi đánh giá</button>
                                    <input type="hidden" name="cm_user_id" value="{{ Auth::guard('users')->user()->id }}">
                                </form>
                            </div>
                        </div>
                    </div>
               
         
        </div>
    </div>
   
    <script>
   // JavaScript
   document.addEventListener("DOMContentLoaded", function () {
    const ratingStars = document.querySelectorAll(".rating i");
    const selectedRating = document.getElementById("selectedRating");

    ratingStars.forEach((star) => {
        star.addEventListener("click", function () {
            const ratingValue = parseInt(star.getAttribute("data-rating"));
            selectedRating.value = ratingValue;
            highlightStars(ratingValue);
        });
    });

    function highlightStars(rating) {
        ratingStars.forEach((star) => {
            const starValue = parseInt(star.getAttribute("data-rating"));
            if (starValue <= rating) {
                star.classList.add("active");
            } else {
                star.classList.remove("active");
            }
        });
    }
});


</script>
    
</section>

@stop
@section('script')
@stop
