@extends('admin.layouts.main')
@section('title', 'Bảng điều khiển')
@section('style-css')
    <!-- fullCalendar -->
@stop
@section('content')
@include('admin.common.header')

  <body onload="time()" class="app sidebar-mini rtl">
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card card-default">
                <!-- /.card-header -->
                <main class="app-content">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="app-title">
                          <ul class="app-breadcrumb breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}"><b>Bảng điều khiển</b></a></li>
                          </ul>
                          <div id="clock"></div>    
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <!-- Left Column -->
                      <div class="col-md-12 col-lg-6">
                        <div class="row">
                          <!-- col-6 -->
                          <div class="col-md-6">
                            <div class="widget-small primary coloured-icon">
                              <i class='icon bx bxs-user-account fa-3x'></i>
                              <div class="info">
                                <h4>Tổng khách hàng</h4>
                                <p><b>{{ number_format($user) }}</b></p>
                                <p class="info-tong">Tổng số khách hàng được quản lý.</p>
                              </div>
                            </div>
                          </div>
                          <!-- col-6 -->
                          <div class="col-md-6">
                            <div class="widget-small info coloured-icon">
                              <i class='icon bx bxs-data fa-3x'></i>
                              <div class="info">
                                <h4>Tổng số tour</h4>
                                <p><b>{{ number_format($tour) }}</b></p>
                                <p class="info-tong">Tổng số sản phẩm được quản lý.</p>
                              </div>
                            </div>
                          </div>
                          <!-- col-6 -->
                          <div class="col-md-6">
                            <div class="widget-small warning coloured-icon">
                              <i class='icon bx bxs-shopping-bags fa-3x'></i>
                              <div class="info">
                                <h4>Tổng tour đã đặt</h4>
                                <p><b>{{ number_format($bookTour) }}</b></p>
                                <p class="info-tong">Tổng số hóa đơn bán hàng trong tháng.</p>
                              </div>
                            </div>
                          </div>
                          <!-- col-6 -->
                          <div class="col-md-6">
                            <div class="widget-small danger coloured-icon">
                              <i class='icon bx bxs-error-alt fa-3x'></i>
                              <div class="info">
                                <h4>Tổng doanh thu Hôm nay</h4>
                                <p><b>{{ number_format($totalRevenuetoday) }} VNĐ</b></p>
                                <p class="info-tong">Doanh thu</p>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="widget-small danger coloured-icon">
                              <i class='icon bx bxs-error-alt fa-3x'></i>
                              <div class="info">
                                <h4>Tổng doanh thu</h4>
                                <p><b>{{ number_format($totalRevenue) }} VNĐ</b></p>
                                <p class="info-tong">Doanh thu</p>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- /Left Column -->
                      
                      <!-- Right Column -->
                      <div class="col-md-12 col-lg-6">
                        <div class="tile">
                          <h3 class="tile-title">Khách hàng mới</h3>
                          <div>
                            <table class="table table-hover">
                              <thead>
                                <tr>
                                  <th>ID</th>
                                  <th>Tên khách hàng</th>
                                  <th>Email</th>
                                  <th>Số điện thoại</th>
                                </tr>
                              </thead>
                              <tbody>
                                @foreach ($newestUsers as $user)
                                <tr>
                                  <td>{{ $user->id }}</td>
                                  <td>{{ $user->name }}</td>
                                  <td>{{ $user->email }}</td>
                                  <td><span class="tag tag-success">{{ $user->phone }}</span></td>
                                </tr>
                                @endforeach
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                      <!-- /Right Column -->
                    </div>
                  </main>
                </div>
        </div>
    </section>
  

  <script>

    function updateTime() {
      var today = new Date();
      var options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit', timeZoneName: 'short' };
      var formattedDate = today.toLocaleDateString('en-US', options);
      document.getElementById("clock").textContent = formattedDate;
    }
  
    updateTime();
    setInterval(updateTime, 1000);
  </script>           
       <!-- /.row -->
       </body>
    <!-- /.content -->
@stop

@section('script')
    
@stop