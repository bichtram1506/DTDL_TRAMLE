<div class="col-lg-12 sidebar ftco-animate bg-light py-md-5 fadeInUp ftco-animated">
    <div class="sidebar-box ftco-animate fadeInUp ftco-animated">  
        
        <h3 class="text-center mb-4">
            <i class="fas fa-user-circle fa-8x" style="color: #0a680a;"></i> Tài Khoản
        </h3>
        <div class="categories related-tour d-flex justify-content-between">
         
            <ul class="d-flex">
                <li class="mb-2 ms-3 {{ request()->is('account.html') ? 'active-user' : '' }}">
                    <a href="{{ route('info.account') }}">
                        <i class="fas fa-user fa-3x" style="color: #ff0000;"></i> Thông tin tài khoản
                    </a>
                </li>
                <li class="mb-2 ms-3 {{ request()->is('list-tour.html') ? 'active-user' : '' }}">
                    <a href="{{ route('my.tour') }}">
                        <i class="fas fa-list fa-3x" style="color: #00ff00;"></i> Danh sách tour đã đặt
                    </a>
                </li>
                <li class="mb-2 ms-3 {{ request()->is('list-hotel.html') ? 'active-user' : '' }}">
                    <a href="{{ route('my.hotel') }}">
                        <i class="fas fa-box-open fa-3x" style="color: #0000ff;"></i> Danh sách phòng đã đặt
                    </a>
                </li>
                <li class="mb-2 ms-3 {{ request()->is('change-password.html') ? 'active-user' : '' }}">
                    <a href="{{ route('change.password') }}">
                        <i class="fas fa-lock fa-3x" style="color: #ff8800;"></i> Đổi mật khẩu
                    </a>
                </li>
                <li class="mb-2 ms-3 {{ request()->is('tour-comments.html') ? 'active-user' : '' }}">
                    <a href="{{ route('tour.comments') }}">
                        <i class="fas fa-star fa-3x" style="color: #800080;"></i> Đánh giá
                    </a>
                </li>
                <li class="ms-3 {{ request()->is('tour-favorites.html') ? 'active-user' : '' }}">
                    <a href="{{ route('tour.favorites') }}">
                        <i class="fas fa-heart fa-3x" style="color: #ff00ff;"></i> Tour yêu thích
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
