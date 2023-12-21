  <!-- Thanh dải -->
<div class="top-bar">
    <div class="container">
        <div class="contact-info">
            Liên hệ : 0782910834
            <a href="#" class="social-icon"><i class="fab fa-facebook"></i></a>
            <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
        </div>
        @if (Auth::guard('users')->check())
            @php $user = Auth::guard('users')->user(); @endphp
            <ul class="navbar-nav12">
                <li class="nav-item {{ request()->is('account.html') || request()->is('change-password.html') || request()->is('list-tour.html') ? 'active' : '' }}">
                    <a href="{{ route('info.account') }}" class="nav-link" title="{{ $user->name }}">
                        <i class="fas fa-user-circle"></i> Xin chào: {{ the_excerpt($user->name, 15) }}
                      </a>
                      
                </li>
            
                <li class="nav-item {{ request()->is('dang-xuat.html') ? 'active' : '' }}">
                    <a href="{{ route('page.user.logout') }}" class="nav-link">Đăng xuất</a>
                </li>
                
                <div class="notification-icon" onclick="toggleNotificationMenu()">
                    <i class="fas fa-bell"></i>
                    <div class="notification-badge">3</div>
                    <div class="notification-menu">
                      <ul>
                        <li>Thông báo 1</li>
                        <li>Thông báo 2</li>
                        <li>Thông báo 3</li>
                      </ul>
                    </div>
                  </div>
                  
             
            </ul>
        @else
            <ul class="navbar-nav12">
                <li class="nav-item {{ request()->is('dang-ky-tai-khoan.html') ? 'active' : '' }}">
                    <a href="{{ route('user.register') }}" class="nav-link">Đăng ký</a>
                </li>
                <li class="nav-item {{ request()->is('dang-nhap.html') ? 'active' : '' }}">
                    <a href="{{ route('page.user.account') }}" class="nav-link">Đăng nhập</a>
                </li>
            </ul>
        @endif
    </div>
</div>

<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
    <div class="container">
        <a class="navbar-brand" href="{{ route('page.home') }}">
            <div class="logo-container">
              <img src="{{ asset('page/images/intro.png') }}" alt="Logo">
              <span class="logo-text">Du Lịch Việt<span>VietScapeJourneys</span></span>
            </div>
          </a>
          
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="oi oi-menu"></span> Menu
        </button>
        <div class="collapse navbar-collapse" id="ftco-nav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item {{ request()->is('/') ? 'active' : ''}}">
                    <a href="{{ route('page.home') }}" class="nav-link">
                        <i class="fas fa-home"></i> <!-- Đây là mã HTML chèn biểu tượng -->
                        TRANG CHỦ
                    </a>
                </li>
                
                <li class="nav-item {{ request()->is('ve-chung-toi.html') ? 'active' : '' }}">
                    <a href="{{ route('about.us') }}" class="nav-link">
                        <i class="fas fa-info-circle"></i> <!-- Đây là mã HTML chèn biểu tượng -->
                        GIỚI THIỆU
                    </a>
                </li>

                <li class="nav-item {{ request()->is('tour.html') || request()->is('tour/*') ? 'active' : '' }}">
                    <a href="{{ route('tour') }}" class="nav-link">
                      <i class="fas fa-hiking"></i>
                      TOUR
                    </a>
                    <!-- Danh sách thả xuống các vùng -->
                    <div class="location-list">
                      <ul>
                        @foreach ($regions as $region)
                        @php
                          $isActive = false;
                          foreach ($region->locations as $location) {
                            if (request()->is('tours.by.location') && request()->route('location_id') == $location->id) {
                              $isActive = true;
                              break;
                            }
                          }
                        @endphp
                        <li class="region-item {{ $isActive ? 'active' : '' }}">
                            <div class="region-name">
                                @if ($region->locations->first())
                                <a href="{{ route('tours.by.region', ['region_id' => $region->id ]) }}" class="{{ request()->route('region_id') == $region->id ? 'active' : '' }}">
                                  <div>{{ $region->r_name }}</div>
                                </a>
                                @else
                                <div>{{ $region->r_name }}</div>
                                @endif
                              </div>
                          <div class="location-names">
                            @foreach ($region->locations as $location)
                            <a href="{{ route('tours.by.location', ['location_id' => $location->id]) }}" class="{{ request()->route('location_id') == $location->id ? 'active' : '' }}">
                              Du lịch {{ $location->l_name }}
                            </a><br>
                            @endforeach
                          </div>
                        </li>
                        @endforeach
                      </ul>
                    </div>
                  </li>
                  
               
                <li class="nav-item {{ request()->is('ve-may-bay.html') || request()->is('ve-may-bay/*') || request()->is('khach-san.html') || request()->is('khach-san/*') ? 'active' : '' }}">
                    <a href="#" class="nav-link" id="service-link">
                        <i class="fas fa-cogs"></i> <!-- Đây là mã HTML chèn biểu tượng -->
                        DỊCH VỤ
                    </a>
                    <div class="location-list">
                    <ul class="submenu1" id="service-submenu">
                      {{-- <li class="{{ request()->is('ve-may-bay.html') || request()->is('ve-may-bay/*') ? 'active' : '' }}">
                            <a href="{{ route('flight.index') }}">
                                <i class="fas fa-plane"></i> <!-- Đây là mã HTML chèn biểu tượng máy bay -->
                                Vé máy bay
                            </a>
                        </li>--}} 
                        <li class="{{ request()->is('khach-san.html') || request()->is('khach-san/*') ? 'active' : '' }}">
                            <a href="{{ route('hotel') }}">
                                <i class="fas fa-hotel"></i> <!-- Đây là mã HTML chèn biểu tượng khách sạn -->
                                Khách sạn
                            </a>
                        </li>
                    </ul>
                </div>
                </li>
                <li class="nav-item {{ request()->is('tour-theo-yeu-cau.html') || request()->is('tour-theo-yeu-cau/*') ? 'active' : '' }}">
                    <a href="{{ route('despoke.book.index') }}" class="nav-link">
                        <i class="fas fa-newspaper"></i> <!-- Đây là mã HTML chèn biểu tượng -->
                      TOUR YÊU CẦU
                    </a>
                </li>
                
                
                <li class="nav-item {{ request()->is('tin-tuc.html') || request()->is('tin-tuc/*') ? 'active' : '' }}">
                    <a href="{{ route('articles.index') }}" class="nav-link">
                        <i class="fas fa-newspaper"></i> <!-- Đây là mã HTML chèn biểu tượng -->
                        TIN TỨC
                    </a>
                </li>
                
           
                <li class="nav-item {{ request()->is('lien-he.html') ? 'active' : '' }}">
                    <a href="{{ route('contact.index') }}" class="nav-link">
                        <i class="fas fa-phone-alt"></i> <!-- Đây là mã HTML chèn biểu tượng -->
                        LIÊN HỆ
                    </a>
                </li>
                
            </ul>
        </div>
    </div>


</nav>
<script>
    function toggleNotificationMenu() {
  var menu = document.querySelector(".notification-menu");
  menu.style.display = (menu.style.display === "none") ? "block" : "none";
}
    </script>