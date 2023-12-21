@extends('admin.layouts.main')
@section('title', '')
@section('content')
@include('admin.common.header')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12">
                    <div class="app-title">
                        <ul class="app-breadcrumb breadcrumb">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}"> <i class="nav-icon fas fa fa-home"></i> Trang chủ</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('eventdate.index') }}">Ngày đi</a></li>
                        <li class="breadcrumb-item active">Danh sách</li>
                    </ol>
                       </ul>
                   </div>
                 </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <section class="content">
                <div class="card card-default">
                    <div class="card-header card-header-border-bottom">
                        <h3 class="card-title">Tìm kiếm</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-search"></i> Thu gọn
                            </button>
                        </div>
                    </div>
                    
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form action="" class="row" >
                            <div class="col-sm-12 col-md-3">
                                <label>Tên Tour</label>
                                <div class="form-group">
                                    <select name="t_title" class="form-control">
                                        <option value="">Chọn tên tour</option>
                                        @foreach ($tourList as $tour)
                                            <option value="{{ $tour->t_title }}">{{ $tour->t_title }} - {{ $tour->t_code }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-sm-12 col-md-3">
                                <div class="form-group">
                                    <label>Ngày khởi hành</label>
                                    <input type="date" name="td_start_date" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <div class="form-group">
                                    <label for="td_status">Trạng thái</label>
                                    <select class="form-control" id="b_status" name="td_status">
                                        <option value="">Tất cả</option>
                                        @foreach($status as $value => $label)
                                            <option value="{{ $value }}" class="{{ $status[$value] }}" @if($value == $request->td_status) selected @endif>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <label>Lọc lịch khởi hành trong tương lai</label>
                                <div class="form-group">
                                    <select id="future-days-select" name="future_days" class="form-control">
                                        <option value="0" {{ $futureDays == 0 ? 'selected' : '' }}>Tất cả</option>
                                        <option value="7" {{ $futureDays == 7 ? 'selected' : '' }}>7 ngày tới</option>
                                        <option value="6" {{ $futureDays == 6 ? 'selected' : '' }}>6 ngày tới</option>
                                        <option value="5" {{ $futureDays == 5 ? 'selected' : '' }}>5 ngày tới</option>
                                        <option value="4" {{ $futureDays == 4 ? 'selected' : '' }}>4 ngày tới</option>
                                        <option value="3" {{ $futureDays == 3 ? 'selected' : '' }}>3 ngày tới</option>
                                        <option value="2" {{ $futureDays == 2 ? 'selected' : '' }}>2 ngày tới</option>
                                        <option value="1" {{ $futureDays == 1 ? 'selected' : '' }}>1 ngày tới</option>
                                    </select>
                                    
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success"><i class="fas fa-search"></i> Tìm kiếm</button>
                            
                                </div>
                            </div>
                        </form>
                        
                    </div>
                </div>
        
        </section>
            <div class="row">
                <div class="col-12">
                 
                    <div class="card">
                        
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover table-bordered">
                                <thead class="thead-dark">
                                <tr>
                                    <th width="4%" class=" text-center">STT</th>
                                    <th>Tour</th>
                                    <th>Ngày đi/Ngày về</th>
                                    <th  class=" text-center">Giá</th>
                                    <th  class=" text-center">Thông tin chỗ</th>
                                    <th class="text-center">Hướng dẫn viên</th>
                                    <th class="text-center">Tình trạng</th>
                                   
                                    <th class=" text-center">Hành động</th>
                                   
                                </tr>
                                </thead>
                                <tbody>
                                @if (!$eventdates->isEmpty())
                                    @php $i = $eventdates->firstItem(); @endphp
                                    @foreach ($eventdates as $eventdate)
                                    <tr>
                                        
                                        <td class="text-center" style="vertical-align: middle; width: 2%">{{ $i }}</td>
                                        <td style="vertical-align: middle; width: 20%" class="title-content">
                                                @if ($eventdate->tour)
                                                <p>
                                                    <a href="{{ route('tour.update', ['id' => $eventdate->tour->id, 'slug' => $eventdate->tour->t_title]) }}">
                                                    {{$eventdate->tour->t_title}}
                                                    </a>
                                                  </p>
                                                    @if($eventdate->tour->t_type==1)<p class="text-danger">Tour yêu cầu</p> @endif
                                                @endif
                                                
                                        </td>   
                                          <td class="text-center" style="vertical-align: middle; width: 16%"> 
                                            <p><b>Ngày đi:</b> {{ date('d/m/Y', strtotime($eventdate->td_start_date)) }}</p>
                                            <p><b>Ngày về:</b> {{ date('d/m/Y', strtotime($eventdate->td_end_date)) }}</p>
                                            
                                        </td>
                                        <td class="text-center" style="vertical-align: middle; width: 35%"> 
                                            @if ($eventdate->tour->t_sale > 0)
                                            <span class="badge badge-warning sale-badge">Sale {{ $eventdate->tour->t_sale }}%</span>
                                        @endif
                                            <p><b>Người lớn :</b>{{ number_format($eventdate->tour->t_price_adults - ($eventdate->tour->t_price_adults * $eventdate->tour->t_sale / 100), 0, ',', '.') }} vnd</p>
                                            <p><b>Trẻ em 6-13 tuổi :</b> {{ number_format($eventdate->tour->t_price_children-($eventdate->tour->t_price_children*$eventdate->tour->t_sale/100),0,',','.') }} vnd</p>
                                            <p><b>Trẻ em 2-6 tuổi :</b>{{  number_format(($eventdate->tour->t_price_children-($eventdate->tour->t_price_children*$eventdate->tour->t_sale/100))*50/100,0,',','.') }} vnd</p>
                                            <p><b>Trẻ em < 2 tuổi :</b>{{  number_format(($eventdate->tour->t_price_children-($eventdate->tour->t_price_children*$eventdate->tour->t_sale/100))*25/100,0,',','.') }} vnd
                                        </td>
                                        <td class="text-center" style="vertical-align: middle; width: 30%"> 
                                            <p><b>Đã đăng ký :</b> {{ $eventdate->number_registered }}</p>
                                            <p><b>Đang đăng ký :</b> {{ $eventdate->td_follow }}</p>
                                            @if($eventdate->tour->t_type!=1 && $eventdate->tour->t_number_guests !=NULL) <p><b>Số người tối đa :</b> {{ $eventdate->tour->t_number_guests }}</p> @endif
                                            @if ($eventdate->tour)
                                            <p><b>Số người tối thiểu :</b> {{ $eventdate->tour->t_min_participants }}</p>
                                            @if ($eventdate->number_registered < $eventdate->tour->t_min_participants)
                                            <p><b style="color: red;">Không đủ điều kiện khởi hành.</b></p>
                                        @else
                                            <p>Đủ điều kiện khởi hành.</p>
                                        @endif 
                                        @endif                   
                                        </td>

                                        <td style="vertical-align: middle; width: 40%">
                                           
                                                <p>{{ $eventdate->guide ? $eventdate->guide->name : 'Đang cập nhật' }}</p>
                                            </td>
                                       
                                        <!-- ... Other columns ... -->
                                
                                            <td style="vertical-align: middle; width: 5%">
                                                <button type="button" class="btn btn-block {{ $classStatus[$eventdate->td_status] }} btn-xs">{{ $status[$eventdate->td_status] }}</button>
                                            </td>
                                         
                                            <td style="vertical-align: middle; width: 2%">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-success btn-sm">Action</button>
                                                    <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                        <span class="caret"></span>
                                                        <span class="sr-only">Toggle Dropdown</span>
                                                    </button>
                                                    <ul class="dropdown-menu action-transaction" role="menu">
                                                        <li><a href="{{ route('eventdate.delete', $eventdate->id) }}" class="btn-confirm-delete"><i class="fa fa-trash"></i>  Delete</a></li>
                                                        @foreach($status as $key => $item)
                                                        <li class="update_book_tour" url='{{ route('eventdate.update.status', ['status' => $key, 'id' => $eventdate->id]) }}'>
                                                            <a> @if ($key == 0)
                                                                <i class="fas fa-exclamation-circle"></i>  {{ $item }}
                                                                @elseif ($key == 1)
                                                                <i class="fas fa-circle-notch"></i> {{ $item }}
                                                            @elseif ($key == 2)
                                                                <i class="fas fa-hourglass-start"></i> {{ $item }}
                                                            @elseif ($key == 3)
                                                                <i class="fas fa-play-circle"></i> {{ $item }}
                                                            @elseif ($key == 4)
                                                                <i class="fas fa-check-circle"></i> {{ $item }}
                                                            @elseif ($key == 5)
                                                                <i class="fas fa-times-circle"></i> {{ $item }}
                                                            @endif
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                    
                                                    </ul>
                                                 <!-- Thêm một class 'eventdate' để xác định các sự kiện -->
                                                                <button type="button" class="btn btn-primary btn-view-detail eventdate" data-eventdate-id="{{ $eventdate->id }}">
                                                                    <i class="fa fa-eye"></i> Xem chi tiết
                                                                </button>
                                                                <a class="btn btn-primary btn-sm edit-eventdate"
                                                                data-eventdate-id="{{ $eventdate->id }}"
                                                                data-start-date="{{ $eventdate->td_start_date }}"
                                                                data-end-date="{{ $eventdate->td_end_date }}"
                                                                data-staff-id="{{ $eventdate->td_guide_id }}"
                                                            href="javascript:void(0);"> <!-- Sử dụng href javascript:void(0); để tránh chuyển hướng -->
                                                                <i class="fas fa-pencil-alt"></i>
                                                            </a>                                       
                                                </div>
                                                {{--<a class="btn btn-info btn-sm" target="_blank" href="" title="Thông tin đơn hàng">--}}
                                                    {{----}}
                                                {{--</a>--}}
                                            </td>
                                         
                                        </tr>
                                        @php $i++ @endphp
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                            <div class="modal fade" id="editEventDateModal" tabindex="-1" role="dialog" aria-labelledby="editEventDateModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editEventDateModalLabel">Chỉnh sửa lịch khởi hành</h5>
                                            <button type="button" class="close btn-close-modal" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="updateEventDateForm" method="POST" action="">
                                                @csrf
                                                <!-- Các trường cập nhật dữ liệu ở đây -->
                                                <div class="form-group">
                                                    <label for="updated_start_date">Ngày đi mới:</label>
                                                    <input type="datetime-local" class="form-control" name="td_start_date" id="updated_start_date">
                                                </div>
                                                <div class="form-group">
                                                    <label for="updated_end_date">Ngày về mới:</label>
                                                    <input type="datetime-local" class="form-control" name="td_end_date" id="updated_end_date">
                                                </div>
                                                <div class="form-group">
                                                    <label for="updated_td_guide_id">Hướng dẫn viên:</label>
                                                    <select class="form-control" name="td_guide_id" id="updated_td_guide_id">
                                                        <option value="">Chọn hướng dẫn viên</option>
                                                        @foreach ($staffs as $guide)
                                                            <option value="{{ $guide->id }}">{{ $guide->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <input type="hidden" name="eventdate_id" id="eventdate_id">
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary btn-close-modal" data-dismiss="modal">Đóng</button>
                                                    <button type="submit" class="btn btn-primary">Lưu</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="createTourModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="createTourModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="createTourModalLabel">Thêm lịch khởi hành</h5>
                                            <button type="button" class="close btn-close-modal" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="createTourForm" action="{{ route('eventdate.store') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="td_guide_id" id="td_guide_id_hidden">
                                                <input type="hidden" name="td_tour_id" value="{{ $tour->id }}">
                                  
                                                <div class="form-group">
                                                    <label for="td_start_date">Ngày đi:</label>
                                                    <input type="datetime-local" class="form-control" name="td_start_date" id="td_start_date" min="<?php echo date('Y-m-d', strtotime('+7 days')); ?>" required>
                                                    <span class="text-danger"><p class="mg-t-5">{{ $errors->first('td_start_date') }}</p></span>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label for="td_end_date">Ngày về:</label>
                                                    <input type="datetime-local" class="form-control" name="td_end_date" id="td_end_date">
                                                    <span class="text-danger"><p class="mg-t-5">{{ $errors->first('td_end_date') }}</p></span>
                                                </div>
                                                <div class="form-group">
                                                    <label for="td_guide_id">Hướng dẫn viên:</label>
                                                    <select class="form-control" name="td_guide_id" id="td_guide_id" >
                                                        <option value="">Chọn hướng dẫn viên</option>
                                                        @foreach ($staffs as $guide)
                                                            <option value="{{ $guide->id }}">{{ $guide->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            
                                                <!-- ... -->
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary btn-close-modal" data-dismiss="modal">Đóng</button>
                                            <button type="submit" class="btn btn-primary">Lưu</button>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                                      <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Danh sách khách hàng </h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body" id="modalContent"> <!-- Đặt ID mới cho phần content -->
                                                    <!-- Nội dung modal sẽ được điền thông qua JavaScript -->
                                                </div>
                                                <div class="modal-footer bg-light"> <!-- Thêm lớp bg-light để đổi màu nền -->
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                            @if($eventdates->hasPages())
                            <div class="pagination float-right margin-20">
                                {{ $eventdates->appends($query = '')->links() }}
                            </div>
                        @endif
                     
                        </div>
                        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                        <script>
                            // Sử dụng class 'eventdate' thay vì 'btn-view-detail'
                            $('.eventdate').click(function() {
                                var eventDateId = $(this).data('eventdate-id');
                                // Lấy thông tin người dùng của sự kiện từ server và điền vào modal
                                $.ajax({
                                    url: '{{ route('book.user.detail', '') }}/' + eventDateId,
                                    method: 'GET',
                                    success: function(response) {
                                        // Điền thông tin người dùng vào modal hoặc hiển thị ở đây
                                        $('#modalContent').html(response); // Điền thông tin vào phần body của modal
                                        $('#exampleModal').modal('show'); // Hiển thị modal
                                    },
                                    error: function(error) {
                                        console.error(error);
                                    }
                                });
                            });
                        </script>
                        
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </section>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var tDay = "<?php echo $tour->t_day; ?>"; // Get the value of t_day from PHP
        
            var tdStartDateInput = document.getElementById("td_start_date");
            var tdEndDateInput = document.getElementById("td_end_date");
        
            var updatedStartDateInput = document.getElementById("updated_start_date"); // Start date field in the edit form
            var updatedEndDateInput = document.getElementById("updated_end_date"); // End date field in the edit form
        
            // Event handler when the start date in the add form changes
            tdStartDateInput.addEventListener("change", function () {
                updateEndDate();
            });
        
            // Event handler when the start date in the edit form changes
            updatedStartDateInput.addEventListener("change", function () {
                updateEndDate();
            });
        
            // Function to update the end date
            function updateEndDate() {
                // Get the start date value
                var startDate;
                if (tdStartDateInput.value) {
                    startDate = new Date(tdStartDateInput.value);
                } else if (updatedStartDateInput.value) {
                    startDate = new Date(updatedStartDateInput.value);
                } else {
                    return;
                }
        
                // Calculate the end date by adding tDay
                var endDate = new Date(startDate);
                endDate.setDate(startDate.getDate() + parseInt(tDay) + 1); // Subtract 1 day to have a total of 3 days
        
                // Set the end date value
                if (tdEndDateInput) {
                    tdEndDateInput.value = endDate.toISOString().slice(0, 16); // Format the end date in the add form (YYYY-MM-DDTHH:MM)
                }
                if (updatedEndDateInput) {
                    updatedEndDateInput.value = endDate.toISOString().slice(0, 16); // Format the end date in the edit form (YYYY-MM-DDTHH:MM)
                }
            }
        });
         </script>
              <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script>
                // Sử dụng class 'eventdate' thay vì 'btn-view-detail'
                $('.eventdate').click(function() {
                    var eventDateId = $(this).data('eventdate-id');
                    // Lấy thông tin người dùng của sự kiện từ server và điền vào modal
                    $.ajax({
                        url: '{{ route('book.user.detail', '') }}/' + eventDateId,
                        method: 'GET',
                        success: function(response) {
                            // Điền thông tin người dùng vào modal hoặc hiển thị ở đây
                            $('#modalContent').html(response); // Điền thông tin vào phần body của modal
                            $('#exampleModal').modal('show'); // Hiển thị modal
                        },
                        error: function(error) {
                            console.error(error);
                        }
                    });
                });
            </script>
            <script>
                document.getElementById('td_guide_id').addEventListener('change', function() {
                    document.getElementById('td_guide_id_hidden').value = this.value;
                });
            </script>
                <script>
                    document.addEventListener("DOMContentLoaded", function () {
                        var editEventDateButtons = document.querySelectorAll(".edit-eventdate");
                        var updateEventDateForm = document.getElementById("updateEventDateForm");
                        var updatedStartDateInput = document.getElementById("updated_start_date");
                        var updatedEndDateInput = document.getElementById("updated_end_date");
                         var updateStaffInput = document.getElementById("updated_td_guide_id");
                        var eventdateIdInput = document.getElementById("eventdate_id");
                
                        editEventDateButtons.forEach(function (editButton) {
                            editButton.addEventListener("click", function () {
                                var startDate = editButton.getAttribute("data-start-date");
                                var endDate = editButton.getAttribute("data-end-date");
                                var eventId = editButton.getAttribute("data-eventdate-id");
                            
                                var Staff = editButton.getAttribute("data-staff-id");
                                // Cập nhật giá trị id cho action của form chỉnh sửa
                                updateEventDateForm.action = "{{ route('eventdate.update', '') }}" + "/" + eventId;
                
                                // Đổ dữ liệu từ mỗi sự kiện vào form chỉnh sửa
                                updatedStartDateInput.value = startDate;
                                updatedEndDateInput.value = endDate;
                                eventdateIdInput.value = eventId;
                                updateStaffInput.value =Staff;
                              
                
                                // Hiển thị modal khi bấm nút "Chỉnh sửa"
                                $("#editEventDateModal").modal("show");
                            });
                        });
                    });
                </script>
        
                <script>
             document.addEventListener("DOMContentLoaded", function () {
                    var createTourBtn = document.querySelector(".btn-create-tour"); // Chọn bằng class thay vì thẻ a
                    var createTourModal = document.getElementById("createTourModal");
                    
                    // Khi nút "Tạo mới" được nhấn, hiển thị hộp thoại modal
                    createTourBtn.addEventListener("click", function () {
                        createTourModal.style.display = "block";
                    });
                    
                    // Khi nút "Đóng" trong hộp thoại được nhấn, ẩn hộp thoại modal
                    var closeModalBtns = createTourModal.querySelectorAll(".btn-close-modal");
                    closeModalBtns.forEach(function (closeModalBtn) {
                        closeModalBtn.addEventListener("click", function () {
                            createTourModal.style.display = "none";
                        });
                    });
                });
                </script>
                <script>
        document.addEventListener("DOMContentLoaded", function () {
            var tdStartDateInput = document.getElementById("td_start_date"); // Lấy thẻ input ngày bắt đầu
        
            // Lấy mảng bookedDates từ PHP
            var bookedDates = @json($bookedDates);
        
            // Lặp qua tất cả các ngày trong lịch
            var calendarDays = document.querySelectorAll(".calendar-day");
            for (var i = 0; i < calendarDays.length; i++) {
                var calendarDay = calendarDays[i];
                var calendarDate = new Date(calendarDay.getAttribute("data-date"));
        
                // Kiểm tra xem ngày trong lịch có trong bookedDates hay không
                if (isDateBooked(calendarDate)) {
                    calendarDay.classList.add("booked-date"); // Thêm lớp booked-date nếu đã tồn tại
                }
            }
        
            tdStartDateInput.addEventListener("change", function () {
                var selectedStartDate = new Date(tdStartDateInput.value);
                if (isDateBooked(selectedStartDate)) {
                    // Đánh dấu ngày bắt đầu đã tồn tại trong lịch
                    alert("Ngày bắt đầu này đã được đặt trước đó.");
                    tdStartDateInput.value = ""; // Xóa giá trị ngày bắt đầu
                }
            });
            document.getElementById('updateEventDateForm').addEventListener('submit', function (event) {
                event.preventDefault(); // Ngăn chặn gửi biểu mẫu mặc định
        
                // Lấy giá trị ngày khởi hành mới
                var updatedStartDate = new Date(document.getElementById('updated_start_date').value);
        
                // Kiểm tra ngày khởi hành mới với danh sách ngày đã đặt
                if (isDateBooked(updatedStartDate)) {
                    alert('Ngày khởi hành đã được đặt. Vui lòng chọn ngày khác.');
                    return; // Ngăn người dùng lưu thông tin
                }
        
                // Nếu không có trùng lặp ngày, tiếp tục gửi biểu mẫu
                this.submit();
            });
        
            function isDateBooked(selectedDate) {
            for (var i = 0; i < bookedDates.length; i++) {
                var bookedDate = new Date(bookedDates[i]);
                if (selectedDate.toDateString() === bookedDate.toDateString()) {
                    return true; // Ngày đã tồn tại trong lịch
                }
            }
            return false; // Ngày không tồn tại trong lịch
        }
        });
        
        
        </script>
@stop
