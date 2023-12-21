
    <!-- Main content -->
                        <div class="card-header">
                            <div class="card-tools">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-block btn-info btn-create-tour" data-toggle="modal" data-target="#createTourModal">
                                        <i class="fas fa-pencil-alt"></i> Tạo mới
                                    </button>
                                </div>
                                
                            </div>
                        </div>
                        
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover table-bordered">
                                <thead class="gray-header">
                                    <tr>
                                        <th width="4%" class=" text-center">STT</th>
                                        <th>Tour</th>
                                        <th>Ngày đi/Ngày về</th>
                                        <th class="text-center">Giá</th>
                                        <th class="text-center">Thông tin chỗ</th>
                                        <th class="text-center">Hướng dẫn viên</th> <!-- Thêm cột hướng dẫn viên -->
                                        <th class="text-center">Tình trạng</th>
                                        @if(Auth::user()->can(['full-quyen-quan-ly', 'xoa-va-cap-nhat-trang-thai']))
                                        <th class="text-center">Hành động</th>
                                        @endif
                                </tr>
                                </thead>
                                <tbody>
                                    @if ($tour->eventdate->isNotEmpty())
                                        @foreach ($tour->eventdate as $eventdate)
                                            <tr>
                                              
                                                <td class="text-center" style="vertical-align: middle; width: 2%">{{ $eventdate->id }}</td>
                                                <td style="vertical-align: middle; width: 18%" class="title-content" >
                                                        {{ $tour->t_title }}  
                                                </td>
                                                <td class="text-center" style="vertical-align: middle; width: 12%">{{ date('d/m/Y', strtotime($eventdate->td_start_date)) }} {{ date('d/m/Y', strtotime($eventdate->td_end_date)) }}
                                                </td>
                                                <td class="text-center" style="vertical-align: middle; width: 20%"> 
                                                    @if ($tour->t_sale > 0)
                                                    <span class="badge badge-warning sale-badge">Sale {{ $tour->t_sale }}%</span>
                                                @endif
                                                    <p><b>Người lớn :</b>{{ number_format($tour->t_price_adults - ($tour->t_price_adults * $tour->t_sale / 100), 0, ',', '.') }} vnd</p>
                                                    <p><b>Trẻ em 6-13 tuổi :</b> {{ number_format($tour->t_price_children-($tour->t_price_children*$tour->t_sale/100),0,',','.') }} vnd</p>
                                                    <p><b>Trẻ em 2-6 tuổi :</b>{{  number_format(($tour->t_price_children-($tour->t_price_children*$tour->t_sale/100))*50/100,0,',','.') }} vnd</p>
                                                    <p><b>Trẻ em < 2 tuổi :</b>{{  number_format(($tour->t_price_children-($tour->t_price_children*$tour->t_sale/100))*25/100,0,',','.') }} vnd
                                                </td>
                                                <td class="text-center" style="vertical-align: middle; width: 15%"> 
                                                    <p><b>Đã đăng ký :</b> {{ $eventdate->number_registered }}</p>
                                                
                                                    <p><b>Đang đăng ký :</b> {{ $eventdate->td_follow }}</p>
                                               
                                                    <p><b>Số người tối thiểu :</b> {{ $tour->t_min_participants }}</p>
                                                    @if ($eventdate->number_registered < $tour->t_min_participants)
                                                    <p><b style="color: red;">Không đủ điều kiện khởi hành.</b></p>
                                                @else
                                                    <p>Đủ điều kiện khởi hành.</p>
                                                @endif                                                
                                                </td>
                                                <td>
                                                    <p>{{ $eventdate->guide ? $eventdate->guide->name : 'Đang cập nhật' }}</p>
                                                </td>
                                                
                                                
                                                <td style="vertical-align: middle; width: 11%">
                                                <button type="button" class="btn btn-block {{ $classStatus[$eventdate->td_status] }} btn-xs">{{ $statusevent[$eventdate->td_status] }}</button>
                                            </td>
                                                
                                                @if(Auth::user()->can(['full-quyen-quan-ly', 'xoa-va-cap-nhat-trang-thai']))
                                                <td style="vertical-align: middle; width: 15%">
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-success btn-sm">Action</button>
                                                          <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                            <span class="caret"></span>
                                                            <span class="sr-only">Toggle Dropdown</span>
                                                        </button>
                                                        <ul class="dropdown-menu action-transaction" role="menu">
                                                            <li><a href="{{ route('eventdate.delete', $eventdate->id) }}" class="btn-confirm-delete"><i class="fa fa-trash"></i>  Delete</a></li>
                                                            @foreach($statusevent as $key => $item)
                                                            <li class="update_book_tour" url='{{ route('eventdate.update.status', ['status' => $key, 'id' => $eventdate->id]) }}'>
                                                                <a>
                                                                    @if ($key == 0)
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
                                                        <button type="button" class="btn btn-danger btn-view-detail eventdate" data-eventdate-id="{{ $eventdate->id }}">
                                                            <i class="fa fa-eye"></i> 
                                                        </button>
                                                    </div>
                                                    {{--<a class="btn btn-info btn-sm" target="_blank" href="" title="Thông tin đơn hàng">--}}
                                                        {{----}}
                                                    {{--</a>--}}
                                                @endif
                                  
                                                    <a class="btn btn-primary btn-sm edit-eventdate"
                                                        data-eventdate-id="{{ $eventdate->id }}"
                                                        data-start-date="{{ $eventdate->td_start_date }}"
                                                        data-end-date="{{ $eventdate->td_end_date }}"
                                                        data-staff-id="{{ $eventdate->td_guide_id }}"
                                                    href="javascript:void(0);"> <!-- Sử dụng href javascript:void(0); để tránh chuyển hướng -->
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </a>                                       
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="7" class="text-center">Không có sự kiện nào cho tour này.</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                             <!-- Modal -->
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
                               <!-- Modal -->
                            
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
                             <!-- Modal -->
                               <!-- Modal -->
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
                                                            <!-- Modal -->
                           
                        </div>
                      
                        <!-- /.card-body -->
              
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

