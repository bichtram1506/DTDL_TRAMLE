<aside class="main-sidebar bg-gradient-primary sidebar sidebar-dark accordion">
    <!-- Brand Logo -->


    <!-- Sidebar -->
    <div class="sidebar wrapper navbar-nav bg-gradient-primary sidebar sidebar-dark accordion">
        <!-- Sidebar user (optional) -->
        @php
             $user = Auth::user();
        @endphp
        <div class=" mt-3 pb-3 mb-3 d-flex sidebar-brand d-flex align-items-center justify-content-center">
           
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-laugh-wink"></i>
            </div>
            <div class="info">
                <a href="#" class="d-block">{!! $user->name !!}</a>
        </div>
        </div>

                    <!-- Sidebar Menu -->
                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column nav-legacy nav-child-indent  " data-widget="treeview" role="menu" data-accordion="false">
                            <!-- Add icons to the links using the .nav-icon class
                                with font-awesome or any other icon font library -->
                            @if(Auth::user()->can(['full-quyen-quan-ly', 'truy-cap-he-thong']))
                            <li class="nav-item has-treeview">
                                <a href="{{ route('admin.home') }}" class="nav-link {{ isset($home_active) ? $home_active : '' }}">
                                    <i class="nav-icon fas fa fa-home"></i>
                                    <p>Tổng quan</p>
                                </a>
                            </li> 
                            @endif 
                            @if(Auth::user()->can(['full-quyen-quan-ly', 'truy-cap-he-thong']))
                            <li class="nav-item has-treeview">
                                <a href="{{ route('admin.revenue_report.index') }}" class="nav-link {{ isset($revenue_report_active) ? $revenue_report_active : '' }}">
                                    <i class="nav-icon fas fa-chart-line"></i>
                                    <p>Báo cáo doanh thu</p>
                                </a>
                            </li> 
                            @endif 
                            @if(Auth::user()->can(['full-quyen-quan-ly', 'danh-sach-danh-muc']))
                            <li class="nav-item has-treeview">
                                <a href="{{ route('category.index') }}" class="nav-link {{ isset($category_active) ? $category_active : '' }}">
                                    <i class="nav-icon fas fa-folder"></i>
                                    <p>Danh mục</p>
                                </a>
                            </li>
                            @endif
                            @if(Auth::user()->can(['full-quyen-quan-ly', 'danh-sach-bai-viet']))
                            <li class="nav-item">
                                <a href="{{ route('article.index') }}" class="nav-link {{ isset($article_active) ? $article_active : '' }}">
                                    <i class="nav-icon fas fa-newspaper" aria-hidden="true"></i> <!-- Thay đổi biểu tượng tại đây -->
                                    <p>Bài viết</p>
                                </a>
                            </li>
                        @endif
                        
                        <li class="nav-item menu-open">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-location-arrow" aria-hidden="true"></i>
                                <p>
                                    Quản lý Địa điểm
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                           {{--     @if(Auth::user()->can(['full-quyen-quan-ly', 'danh-sach-dia-diem']))
                                <li class="nav-item">
                                    <a href="{{ route('region.index') }}" class="nav-link {{ isset($region_active) ? $region_active : '' }}">
                                        <i class="nav-icon fas fa-globe" aria-hidden="true"></i><!-- Thay đổi biểu tượng tại đây -->
                                        <p>Miền</p>
                                    </a>
                                </li>
                                @endif --}}
                        
                                @if(Auth::user()->can(['full-quyen-quan-ly', 'danh-sach-dia-diem']))
                                <li class="nav-item">
                                    <a href="{{ route('location.index') }}" class="nav-link {{ isset($location_active) ? $location_active : '' }}">
                                        <i class="nav-icon fas fa-map-marker-alt" aria-hidden="true"></i><!-- Thay đổi biểu tượng tại đây -->
                                        <p>Tỉnh</p>
                                    </a>
                                </li>
                                @endif
                        
                                @if(Auth::user()->can(['full-quyen-quan-ly', 'danh-sach-dia-diem']))
                                <li class="nav-item">
                                    <a href="{{ route('attraction.index') }}" class="nav-link {{ isset($attraction_active) ? $attraction_active : '' }}">
                                        <i class="nav-icon fas fa-map-marked" aria-hidden="true"></i><!-- Thay đổi biểu tượng tại đây -->
                                        <p>Điểm du lịch</p>
                                    </a>
                                </li>
                                @endif
                            </ul>
                        </li>

                            <li class="nav-item menu-open">
                                <a href="#" class="nav-link"data-target="#quanLyTourMenu">
                                    <i class="nav-icon fas fa-calendar-alt" aria-hidden="true"></i>
                                    <p>
                                        Quản lý Tour
                                        <i class="fas fa-angle-left right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview collapse" id="quanLyTourMenu">
                                    @if(Auth::user()->can(['full-quyen-quan-ly', 'danh-sach-tour']))
                                    <li class="nav-item">
                                        <a href="{{ route('tour.index') }}" class="nav-link {{ isset($tour_active) ? $tour_active : '' }}">
                                            <i class="nav-icon fas fa-map" aria-hidden="true"></i>
                                            <p>Quản lý Tour</p>
                                        </a>
                                    </li>
                                @endif
                                
                                    @if(Auth::user()->can(['full-quyen-quan-ly', 'danh-sach-dich-vu']))
                                        <li class="nav-item">
                                            <a href="{{ route('service.index') }}" class="nav-link {{ isset($service_active) ? $service_active : '' }}">
                                                <i class="nav-icon fas fa-tree" aria-hidden="true"></i>
                                                <p>Dịch vụ</p>
                                            </a>
                                        </li>
                                    @endif
                            
                                    @if(Auth::user()->can(['full-quyen-quan-ly', 'danh-sach-loai-tour']))
                                        <li class="nav-item">
                                            <a href="{{ route('tourtype.index') }}" class="nav-link {{ isset($tourtype_active) ? $tourtype_active : '' }}">
                                                <i class="nav-icon fas fa-mountain" aria-hidden="true"></i>
                                                <p>Quản lý Loại Tour</p>
                                            </a>
                                        </li>
                                    @endif
                            
                                    @if(Auth::user()->can(['danh-sach-lich-trinh|full-quyen-quan-ly']))
                                        <li class="nav-item">
                                            <a href="{{ route('eventdate.index') }}" class="nav-link {{ isset($eventdate_active) ? $eventdate_active : '' }}">
                                                <i class="nav-icon fas fa-clock" aria-hidden="true"></i>
                                                <p>Quản lý lịch khởi hành</p>
                                            </a>
                                        </li>
                                    @endif  
                                 
                            
                                    @if(Auth::user()->can(['full-quyen-quan-ly', 'danh-sach-phuong-tien']))
                                        <li class="nav-item">
                                            <a href="{{ route('vehicle.index') }}" class="nav-link {{ isset($vehicle_active) ? $vehicle_active : '' }}">
                                                <i class="nav-icon fas fa-bus" aria-hidden="true"></i>
                                                <p>Phương tiện</p>
                                            </a>
                                        </li>
                                    @endif 
                            
                                    @if(Auth::user()->can(['full-quyen-quan-ly', 'quan-ly-dat-tour']))
                                        <li class="nav-item">
                                            <a href="{{ route('book.tour.index') }}" class="nav-link {{ isset($book_tour_active) ? $book_tour_active : '' }}">
                                                <i class="nav-icon fas fa-tasks" aria-hidden="true"></i>
                                                <p>Danh sách đặt tour</p>
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </li>
                            
                            <li class="nav-item menu-open">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-hotel" aria-hidden="true"></i>
                                    <p>
                                        Quản lý Khách sạn
                                        <i class="fas fa-angle-left right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @if(Auth::user()->can(['full-quyen-quan-ly', 'danh-sach-khach-san']))
                                    <li class="nav-item">
                                        <a href="{{ route('hotel.index') }}" class="nav-link {{ isset($hotel_active) ? $hotel_active : '' }}">
                                            <i class="nav-icon fas fa-bed" aria-hidden="true"></i>
                                            <p>Khách sạn</p>
                                        </a>
                                    </li>
                                    @endif 
                                    @if(Auth::user()->can(['full-quyen-quan-ly', 'danh-sach-phong']))
                                    <li class="nav-item">
                                        <a href="{{ route('room.index') }}" class="nav-link {{ isset($room_active) ? $room_active : '' }}">
                                            <i class="nav-icon fas fa-check-square" aria-hidden="true"></i><!-- Thay đổi biểu tượng tại đây -->
                                            <p>Phòng</p>
                                        </a>
                                    </li>
                                    @endif
                                    @if(Auth::user()->can(['full-quyen-quan-ly', 'danh-sach-dat-hotel']))
                                    <li class="nav-item">
                                        <a href="{{ route('book.hotel.index') }}" class="nav-link {{ isset($book_hotel_active) ? $book_hotel_active : '' }}">
                                            <i class="nav-icon fas fa-check-square" aria-hidden="true"></i><!-- Thay đổi biểu tượng tại đây -->
                                            <p>Đơn đặt khách sạn</p>
                                        </a>
                                    </li>
                                    @endif
                                </ul>
                            </li>
                            
     
                        
                            @if(Auth::user()->can(['full-quyen-quan-ly']))
                            <li class="nav-item">
                                <a href="{{ route('couponcode.index') }}" class="nav-link {{ isset($couponcode_active) ? $couponcode_active : '' }}">
                                    <i class="nav-icon fas fa-tags" aria-hidden="true"></i>
                                    <p>Quản lý mã khuyến mãi</p>
                                </a>
                            </li>
                        @endif   
                                @if(Auth::user()->can(['full-quyen-quan-ly', 'quan-ly-binh-luan']))
                                    <li class="nav-item">
                                        <a href="{{ route('comment.index') }}" class="nav-link {{ isset($comment_active) ? $comment_active : '' }}">
                                            <i class="nav-icon fas fa-comments" aria-hidden="true"></i>
                                            <p>Quản lý bình luận </p>
                                        </a>
                                    </li>
                                @endif 
                 {{--<li class="nav-item">--}}
                    {{--<a href="{{ route('group.permission.index') }}" class="nav-link {{ isset($group_permission) ? $group_permission : '' }}">--}}
                        {{--<i class="nav-icon fa fa-hourglass" aria-hidden="true"></i>--}}
                        {{--<p>Nhóm quyền</p>--}}
                    {{--</a>--}}
                {{--</li>--}}
                {{--<li class="nav-item">--}}
                    {{--<a href="{{ route('permission.index') }}" class="nav-link {{ isset($permission_active) ? $permission_active : '' }}">--}}
                        {{--<i class="nav-icon fa fa-balance-scale"></i>--}}
                        {{--<p> Quyền </p>--}}
                    {{--</a>--}}
                {{--</li>--}}
                {{--   //    <li class="nav-item">
                    <a href="{{ route('tourdate.index') }}" class="nav-link {{ isset($eventdate_active) ? $eventdate_active : '' }}">
                        <i class="nav-icon fa fa-gavel" aria-hidden="true"></i>
                        <p> Tour theo ngày </p>
                    </a>
                </li>--}}
                <li class="nav-item menu-open">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-fw fa-address-card" aria-hidden="true"></i>
                        <p>
                            Quản lý Nhân viên
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
            
                    @if(Auth::user()->can(['full-quyen-quan-ly', 'danh-sach-nguoi-dung']))
                <li class="nav-item">
                    <a href="{{ route('staff.index') }}" class="nav-link {{ isset($staff_active) ? $staff_active : '' }}">
                        <i class="nav-icon fa fa-fw fa-address-card" aria-hidden="true"></i>
                        <p>Danh sách nhân viên</p>
                        
                    </a>
                </li>
                 @endif 
                 @if(Auth::user()->can(['full-quyen-quan-ly', 'danh-sach-vai-tro']))
                 <li class="nav-item">
                     <a href="{{ route('role.index') }}" class="nav-link {{ isset($role_active) ? $role_active : '' }}">
                         <i class="nav-icon fas fa-user-shield" aria-hidden="true"></i> <!-- Thay đổi biểu tượng tại đây -->
                         <p>Quản lý Vai trò</p>
                     </a>
                 </li>
             @endif
                    </ul>
                </li>

                 @if(Auth::user()->can(['full-quyen-quan-ly', ]))
                <li class="nav-item">
                    <a href="{{ route('user.index') }}" class="nav-link {{ isset($user_active) ? $user_active : '' }}">
                        <i class="nav-icon fa fa-fw fa-user" aria-hidden="true"></i>
                        <p> Quản lý khách hàng </p>
                    </a>
                </li>
                 @endif 
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar 
    <script>
        var tourMenu = document.querySelector('#tour-menu-collapse');
        var tourMenuButton = document.querySelector('#tour-menu-heading button');
        var isTourMenuVisible = localStorage.getItem('isTourMenuVisible') === 'true';
    
        // Kiểm tra và cập nhật trạng thái ban đầu của menu
        if (isTourMenuVisible) {
            tourMenu.classList.add('show');
        } else {
            tourMenu.classList.remove('show');
        }
    
        // Sử dụng JavaScript để xử lý sự kiện click cho nút mở menu
        tourMenuButton.addEventListener('click', function (event) {
            // Ngăn chặn hành vi mặc định của nút
            event.preventDefault();
    
            // Kiểm tra và cập nhật trạng thái hiển thị của menu
            if (tourMenu.classList.contains('show')) {
                localStorage.setItem('isTourMenuVisible', 'false');
            } else {
                localStorage.setItem('isTourMenuVisible', 'true');
            }
        });
    </script>-->
   
</aside>
