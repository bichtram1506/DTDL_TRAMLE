@extends('admin.layouts.main')
@section('title', 'Bảng điều khiển')
@section('style-css')
    <!-- fullCalendar -->
@stop
@section('content')
@include('admin.common.header')
<body onload="time()" class="app sidebar-mini rtl">
  <!-- Navbar-->
  
  <!-- Sidebar menu-->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
 
  <main class="app-content">
    <div class="row">
      <div class="col-md-12">
        <div class="app-title">
          <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><a href="#"><b>Báo cáo doanh thu    </b></a></li>
          </ul>
          <div id="clock"></div>
        </div>
      </div>
    </div>
        <div class="row">
            <div class="col-md-6 col-lg-3">
                <div class="widget-small primary coloured-icon"><i class='icon  bx bxs-user fa-3x'></i>
                    <div class="info">
                        <h4>Tổng Nhân viên</h4>
                        <p><b>{{ number_format($staff) }} nhân viên</b></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="widget-small info coloured-icon"><i class='icon bx bxs-purchase-tag-alt fa-3x' ></i>
                    <div class="info">
                        <h4>Tổng tour ghép</h4>
                        <p><b>{{ number_format($tour1) }} tour</b></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="widget-small info coloured-icon"><i class='icon bx bxs-purchase-tag-alt fa-3x' ></i>
                    <div class="info">
                        <h4>Tổng tour</h4>
                        <p><b>{{ number_format($tour0 + $tour1) }} tour</b></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="widget-small info coloured-icon"><i class='icon bx bxs-purchase-tag-alt fa-3x' ></i>
                    <div class="info">
                        <h4>Tổng tour yêu cầu</h4>
                        <p><b>{{ number_format($tour0) }} tour</b></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="widget-small warning coloured-icon"><i class='icon fa-3x bx bxs-shopping-bag-alt'></i>
                    <div class="info">
                        <h4>Tổng đơn hàng</h4>
                        <p><b>{{ number_format($bookTour) }} đơn hàng</b></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="widget-small danger coloured-icon"><i class='icon fa-3x bx bxs-info-circle' ></i>
                    <div class="info">
                        <h4>Bị cấm</h4>
                        <p><b>{{ number_format($bannedStaffCount) }} nhân viên</b></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="widget-small danger coloured-icon"><i class='icon fa-3x bx bxs-info-circle' ></i>
                    <div class="info">
                        <h4>Đang diễn ra</h4>
                        <p><b>{{ number_format($tourtoday) }} tour</b></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-lg-3">
                <div class="widget-small primary coloured-icon"><i class='icon fa-3x bx bxs-chart' ></i>
                    <div class="info">
                        <h4>Đơn đã hoàn thành</h4>
                        <p><b>{{ number_format($bookTourCount4) }} đơn hàng </b></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="widget-small info coloured-icon"><i class='icon fa-3x bx bxs-user-badge' ></i>
                    <div class="info">
                        <h4>Nhân viên mới</h4>
                        <p><b>{{ number_format($staffnew) }} nhân viên</b></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="widget-small warning coloured-icon"><i class='icon fa-3x bx bxs-tag-x' ></i>
                    <div class="info">
                        <h4>Chưa xác nhận</h4>
                        <p><b>{{ number_format($bookTourCount) }} đơn hàng</b></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="widget-small danger coloured-icon"><i class='icon fa-3x bx bxs-receipt' ></i>
                    <div class="info">
                        <h4>Hủy</h4> 
                        <p><b>{{ number_format($canceledOrdersCount) }} đơn hàng</b></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="widget-small danger coloured-icon"><i class='icon fa-3x bx bxs-receipt' ></i>
                    <div class="info">
                        <h4>Đã xác nhận</h4> 
                        <p><b>{{ number_format($OrdersCount2) }} đơn hàng</b></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="widget-small danger coloured-icon"><i class='icon fa-3x bx bxs-receipt' ></i>
                    <div class="info">
                        <h4>Đã hoàn thành</h4> 
                        <p><b>{{ number_format($OrdersCount2) }} đơn hàng</b></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div>
                        <h3 class="tile-title">TOUR BÁN CHẠY</h3>
                    </div>
                    <div class="tile-body">
                        <table class="table table-hover table-bordered" id="sampleTable">
                            <thead>
                                <tr>
                                    <th>Mã tour</th>
                                    <th>Tên tour</th>
                                    <th>Số lượng</th>
                                   
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tours as $tour)

                                <tr>
                                    <td><a href="{{ route('tour.detail', ['id' => $tour->id, 'slug' => safeTitle($tour->t_code)]) }}">{{ $tour->t_code }}</a></td>
                                      
                                    <td><a href="{{ route('tour.detail', ['id' => $tour->id, 'slug' => safeTitle($tour->t_title)]) }}">{{ $tour->t_title }}</a></td>
                                       
                                    <td>{{ $tour->tour_details_count }}</td>
                                </tr>
                              
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div>
                        <h3 class="tile-title">TOUR YÊU THÍCH</h3>
                    </div>
                    <div class="tile-body">
                        <table class="table table-hover table-bordered" id="sampleTable">
                            <thead>
                                <tr>
                                    <th>Mã Tour</th>
                                    <th>Tên Tour</th>
                                    <th>Lượt yêu thích</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($favoriteTours as $tour)
                                <tr>
                                    <td>{{ $tour->t_code }}</td>
                                    <td>{{ $tour->t_title }}</td>
                                    <td>{{ $tour->favorite_count }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        
                    </div>
                </div>
            </div>
        </div>
      {{--}  <div class="row">
                <div class="col-md-12">
                    <div class="tile">
                        <div>
                            <h3 class="tile-title">TỔNG ĐƠN HÀNG</h3>
                        </div>
                        <div class="tile-body">
                            <table class="table table-hover table-bordered" id="sampleTable">
                                <thead>
                                    <tr>
                                            <th>ID đơn hàng</th>
                                            <th>Khách hàng</th>
                                            <th>Đơn hàng</th>
                                            <th>Số lượng</th>
                                            <th>Tổng tiền</th>
                                    </tr>
                                </thead>s
                                <tbody>
                                    <tr>
                                            <td>MD0837</td>
                                            <td>Triệu Thanh Phú</td>
                                            <td>Ghế làm việc Zuno, Bàn ăn gỗ Theresa</td>
                                            <td>2 sản phẩm</td>
                                            <td>9.400.000 đ</td>
                                    </tr>
                                    <tr>
                                            <td>MĐ8265</td>
                                            <td>Nguyễn Thị Ngọc Cẩm</td>
                                            <td>Ghế ăn gỗ Lucy màu trắng</td>
                                            <td>1 sản phẩm</td>
                                            <td>3.800.000 đ</td>   
                                    </tr>
                                    <tr>
                                            <td>MT9835</td>
                                            <td>Đặng Hoàng Phúc</td>
                                            <td>Giường ngủ Jimmy, Bàn ăn mở rộng cao cấp Dolas, Ghế làm việc Zuno</td>
                                            <td>3 sản phẩm</td>
                                            <td>40.650.000 đ</td>
                                    </tr>
                                    <tr>
                                            <td>ER3835</td>
                                            <td>Nguyễn Thị Mỹ Yến</td>
                                            <td>Bàn ăn mở rộng Gepa</td>
                                            <td>1 sản phẩm</td>
                                            <td>16.770.000 đ</td>
                                    </tr>
                                    <tr>
                                            <td>AL3947</td>
                                            <td>Phạm Thị Ngọc</td>
                                            <td>Bàn ăn Vitali mặt đá, Ghế ăn gỗ Lucy màu trắng</td>
                                            <td>2 sản phẩm</td>
                                            <td>19.770.000 đ</td>
                                    </tr>
                                    <tr>
                                            <td>QY8723</td>
                                            <td>Ngô Thái An</td>
                                            <td>Giường ngủ Kara 1.6x2m</td>
                                            <td>1 sản phẩm</td>
                                            <td>14.500.000 đ</td>
                                    </tr>
                                    <tr>
                                       <th colspan="4">Tổng cộng:</th>
                                        <td>104.890.000 đ</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div> --}}
           

        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div>
                        <h3 class="tile-title">NHÂN VIÊN MỚI</h3>
                    </div>
                    <div class="tile-body">
                        <table class="table table-hover table-bordered" id="sampleTable">
                            <thead>
                                <tr>
                                    <th>Mã NV</th>
                                    <th>Họ và tên</th>
                                    <th>Email</th>
                                    <th>SĐT</th>
                                    <th>Chức vụ</th>
                                </tr>
                            </thead>
                            @foreach ($newestStaffs as $staff)
                            <tbody>
                              
                              <tr>
                                <td>{{ $staff->id }}</td>
                                <td>{{ $staff->name }}</td>
                                <td>{{ $staff->email }}</td>
                                <td><span class="tag tag-success">{{ $staff->phone }}</span></td>
                                <td>  @foreach ($staff->roles as $role)
                                {{ $role->display_name }}
                                {{-- Nếu bạn muốn thêm dấu phẩy giữa các vai trò --}}
                                @if (!$loop->last)
                                    ,
                                @endif 
                            @endforeach <td>
                              </tr>
                           
                            </tbody>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-7">
                <div class="tile">
                    <h3 class="tile-title">DOANH THU HÀNG THÁNG</h3>
                    <div id="dateSelector">
                        <label for="month">Chọn tháng:</label>
                        <select id="month"></select>
                        <label for="year">Chọn năm:</label>
                        <select id="year"></select>
                        <button id="searchButton">Tìm kiếm</button>
                    </div>
                    <div style="width: 100%; margin: 0 auto;">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="tile">
                    <h3 class="tile-title">TRẠNG THÁI</h3>
                    <div>
                        <label for="searchMonth">Tháng:</label>
                        <select id="searchMonth">
                          <?php
                          for ($month = 1; $month <= 12; $month++) {
                              echo '<option value="' . $month . '">Tháng ' . $month . '</option>';
                          }
                          ?>
                        </select>
                        
                        <label for="searchYear">Năm:</label>
                        <select id="searchYear">
                          <?php
                          $currentYear = date('Y');
                          for ($year = $currentYear; $year >= $currentYear - 10; $year--) {
                              echo '<option value="' . $year . '">' . $year . '</option>';
                          }
                          ?>
                        </select>
                        
                        <button onclick="searchChartData()">Tìm kiếm</button>
                    </div>
                    <div style="width: 80%; margin: 0 auto;">
                        <canvas id="pieChart"></canvas>
                    </div>
            
                </div>
            </div>
            </div>
       
    
        <script>
            // Hàm để đặt giá trị mặc định cho chọn tháng và năm
            function setDefaultMonthAndYear() {
                // Lấy tháng và năm hiện tại
                const currentDate = new Date();
                const currentMonth = currentDate.getMonth() + 1; // Vì tháng trong JavaScript tính từ 0 đến 11
                const currentYear = currentDate.getFullYear();
    
                // Đặt giá trị mặc định cho chọn tháng và năm
                const monthSelect = document.getElementById("month");
                const yearSelect = document.getElementById("year");
                monthSelect.value = currentMonth;
                yearSelect.value = currentYear;
            }
    
            // Gọi hàm setDefaultMonthAndYear sau khi trang đã được tải
            window.addEventListener("load", setDefaultMonthAndYear);
        </script>
        
        <script>
            const monthSelect = document.getElementById('month');
            const yearSelect = document.getElementById('year');
            const ctx = document.getElementById('revenueChart').getContext('2d');
            let chart = null;
            let currentData = []; // To store the current data being displayed
        
            for (let month = 1; month <= 12; month++) {
                const option = document.createElement('option');
                option.value = month;
                option.text = `Tháng ${month}`;
                monthSelect.appendChild(option);
            }
            const allOption = document.createElement('option');
            allOption.value = 'all';
            allOption.text = 'Tất cả';
            monthSelect.appendChild(allOption);
        
            const currentYear = new Date().getFullYear();
        
            for (let year = 2000; year <= currentYear; year++) {
                const option = document.createElement('option');
                option.value = year;
                option.text = year;
                yearSelect.appendChild(option);
            }
        
            fetchInitialData();
        
            function fetchInitialData() {
    const currentYear = new Date().getFullYear();
    fetch(`revenue-report/monthly-revenue/${currentYear}`)
        .then(response => response.json())
        .then(data => {
            currentData = data; // Store the current data
            const months = data.map(item => item.month);
            const revenueData = data.map(item => item.monthly_revenue);
            displayChart(months, revenueData, true); // Display monthly data for the current year
        });
}

        
            function displayChart(labels, data, isMonthly) {
                if (chart) {
                    chart.data.labels = labels;
                    chart.data.datasets[0].data = data;
                    chart.options.scales.x.title.text = isMonthly ? 'Tháng' : 'Ngày'; // Set the x-axis label
                    chart.update();
                } else {
                    chart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Doanh thu',
                                data: data,
                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                borderColor: 'rgba(75, 192, 192, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    title: {
                                        display: true,
                                        text: 'Doanh thu (VNĐ)',
                                        font: {
                                            size: 14,
                                            weight: 'bold'
                                        }
                                    }
                                },
                                x: {
                                    title: {
                                        display: true,
                                        text: isMonthly ? 'Tháng' : 'Ngày', // Set the x-axis label
                                        font: {
                                            size: 14,
                                            weight: 'bold'
                                        }
                                    }
                                }
                            },
                            plugins: {
                                legend: {
                                    display: false
                                }
                            }
                        }
                    });
                }
            }
        
                const searchButton = document.getElementById('searchButton');
    searchButton.addEventListener('click', () => {
        const selectedMonth = document.getElementById('month').value;
        const selectedYear = document.getElementById('year').value;

        if (selectedMonth === 'all') {
            if (selectedYear) {
                // Trường hợp bạn chọn "Tất cả" và một năm cụ thể
                fetch(`revenue-report/monthly-revenue/${selectedYear}`)
                    .then(response => response.json())
                    .then(data => {
                        const months = data.map(item => item.month);
                        const revenueData = data.map(item => item.monthly_revenue);
                        displayChart(months, revenueData, true); // Display monthly data for the selected year
                    });
            } 
        } else {
            // Xử lý trường hợp bạn chọn một tháng cụ thể bằng mã hiện tại
            fetch(`revenue-report/revenue-by-month/${selectedYear}/${selectedMonth}`)
                .then(response => response.json())
                .then(data => {
                    const days = data.map(item => item.day);
                    const revenueData = data.map(item => item.daily_revenue);
                    displayChart(days, revenueData, false); // Display daily data when searching
                });
        }
    });
            </script>
            
            <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                  // Set default values to the current month and year
                  var currentMonth = new Date().getMonth() + 1; // Months are zero-indexed
                  var currentYear = new Date().getFullYear();
              
                  // Set default values for the month and year dropdowns
                  document.getElementById("searchMonth").value = currentMonth;
                  document.getElementById("searchYear").value = currentYear;
                });
              
                // Function to handle the search
                function searchChartData() {
                  // Implement your search logic here
                  // ...
                }
              </script>
              
      <script>
        // Tạo biểu đồ tròn
        bookStatusData = @json($bookStatusData);
         // Các trạng thái tương ứng
    var statusLabels = {
        1: 'Tiếp nhận',
        2: 'Đã xác nhận',
        3: 'Đã thanh toán',
        4: 'Đã kết thúc',
        5: 'Đã hủy'
    };

    // Chuyển đổi giá trị trong dữ liệu thành các nhãn tương ứng
    var labels = [];
    var data = [];
    Object.keys(bookStatusData).forEach(function(key) {
        labels.push(statusLabels[key]);
        data.push(bookStatusData[key]);
    });

    // Tạo biểu đồ tròn
    const pieChart = new Chart(document.getElementById("pieChart"), {
        type: 'pie',
        data: {
            labels: labels,
            datasets: [{
                data: data,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.7)',
                    'rgba(54, 162, 235, 0.7)',
                    'rgba(255, 206, 86, 0.7)',
                    'rgba(75, 192, 192, 0.7)',
                    'rgba(153, 102, 255, 0.7)'
                ]
            }]
        },
        options: {
            responsive: true
        }
    });
function searchChartData() {
    var searchMonth = document.getElementById("searchMonth").value;
    var searchYear = document.getElementById("searchYear").value;

    // Thực hiện AJAX request để tìm kiếm dữ liệu theo tháng và năm
    axios.get('revenue-report/search-revenue', {
        params: {
            month: searchMonth,
            year: searchYear
        }
    })
    .then(function(response) {
        // Xử lý kết quả tìm kiếm
        var searchData = response.data;

        // Cập nhật dữ liệu biểu đồ
        updateChartData(searchData);

        // Vẽ lại biểu đồ
        pieChart.update();
    })
    .catch(function(error) {
        console.log('Lỗi khi thực hiện AJAX request:', error);
    });
}
// Hàm cập nhật dữ liệu biểu đồ
function updateChartData(data) {
    // Chuyển đổi giá trị trong dữ liệu thành các nhãn tương ứng
    var labels = [];
    var chartData = [];
    Object.keys(data).forEach(function(key) {
        labels.push(statusLabels[key]);
        chartData.push(data[key]);
    });

    // Cập nhật dữ liệu biểu đồ
    pieChart.data.labels = labels;
    pieChart.data.datasets[0].data = chartData;
}

// Khởi tạo biểu đồ ban đầu
function initChart() {
          // Tạo biểu đồ tròn
          bookStatusData = @json($bookStatusData);
         // Các trạng thái tương ứng
    var statusLabels = {
        1: 'Tiếp nhận',
        2: 'Đã xác nhận',
        3: 'Đã thanh toán',
        4: 'Đã kết thúc',
        5: 'Đã hủy'
    };

    // Chuyển đổi giá trị trong dữ liệu thành các nhãn tương ứng
    var labels = [];
    var data = [];
    Object.keys(bookStatusData).forEach(function(key) {
        labels.push(statusLabels[key]);
        data.push(bookStatusData[key]);
    });

    // Tạo biểu đồ tròn
    const pieChart = new Chart(document.getElementById("pieChart"), {
        type: 'pie',
        data: {
            labels: labels,
            datasets: [{
                data: data,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.7)',
                    'rgba(54, 162, 235, 0.7)',
                    'rgba(255, 206, 86, 0.7)',
                    'rgba(75, 192, 192, 0.7)',
                    'rgba(153, 102, 255, 0.7)'
                ]
            }]
        },
        options: {
            responsive: true
        }
 })} ;
    </script>
    
    
     
    </main>
    <!-- Essential javascripts for application to work-->
    <script src="{{ asset('admin/dist/js1/js/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('admin/dist/js1/js/popper.min.js') }}"></script>
    <script src="{{ asset('admin/dist/js1/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('admin/dist/js1/js/main.js') }}"></script>
    <!-- The javascript plugin to display page loading on top-->
    <script src="{{ asset('admin/dist/js1/js/plugins/pace.min.js') }}"></script>
    <!-- Page specific javascripts-->

 
</body>
</section>
@stop


