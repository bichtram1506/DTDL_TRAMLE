
<div  class="card">
    <div class="card-header">
        <div class="card-tools">
            <div class="btn-group">
                <button type="button" class="btn btn-block btn-info" data-toggle="modal" data-target="#myModal1">
                    <i class="fa fa-plus"></i> Tạo mới
                </button>
            </div>
            
        </div>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap table-bordered">
            <thead>
                <tr>
                   <th class="gray-header">Ngày</th> 
                   <th class="gray-header">Tiêu đề</th>
                   <th class="gray-header">Mô tả</th>
                   <th class="gray-header">Hình ảnh</th>
                   <th class="text-center gray-header">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @if ($tour->touritineraries->isNotEmpty())
                @foreach ($tour->touritineraries as $touritinerarie)
                        <tr>    
                          
                            <td class="text-center" style="vertical-align: middle; width: 10%">
                                <p>{{ $touritinerarie->ti_day }}</p>
                            </td>
                            <td class="text-center" style="vertical-align: middle; width: 25%; white-space: normal;">
                                <p style="max-width: 200px;">{{ $touritinerarie->ti_content }}</p>
                              </td>
                              <td class="text-left" style="vertical-align: middle; width: 40%; height: 10px; white-space: normal;">
                                <div style="max-width: 400px;">{!! $touritinerarie->ti_description !!}</div>
                              </td>     
                              <td style="vertical-align: middle; width:15%;">
                                @if(isset($touritinerarie) && !empty($touritinerarie->ti_images))
                                    <img src="{{ asset(pare_url_file($touritinerarie->ti_images)) }}" alt="" class="margin-auto-div img-rounded"  id="image_render" style="height: 100px; width:100%;">
                                @else
                                    <img src="{{ asset('admin/dist/img/no-image.png') }}" alt="" class="margin-auto-div img-rounded"  id="image_render" style="height: 100px; width:100%;">
                                @endif
                            </td>                     
                            <td class="text-center" style="vertical-align: middle;">
                                <!-- Hành động -->                                          
                                <a class="btn btn-primary btn-sm edit-touritinerarie"
                                                        data-touritinerarie-id="{{ $touritinerarie->id }}"
                                                        data-day="{{ $touritinerarie->ti_day }}"
                                                        data-content="{{ $touritinerarie->ti_content }}"
                                                        data-description="{{ $touritinerarie->ti_description }}"
                                                        data-images="{{ $touritinerarie->ti_images }}"
                                                    href="javascript:void(0);"> <!-- Sử dụng href javascript:void(0); để tránh chuyển hướng -->
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </a>                                   
                                                    <a class="btn btn-danger btn-sm btn-delete btn-confirm-delete" href="{{ route('touritinerarie.delete', $touritinerarie->id) }}">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </a>   
                           </td>
                        </tr>
                    @endforeach
              @endif
            </tbody>
        </table>
         
        <div class="modal fade" id="editTourItinerarieModal" tabindex="-1" role="dialog" aria-labelledby="editTourItinerarieModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editTourItinerarieModalLabel">Chỉnh sửa chương trình tour</h5>
                        <button type="button" class="close btn-close-modal" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="updateTourItinerarieForm" method="POST" action="" enctype="multipart/form-data">
                            @csrf
                            <!-- Các trường cập nhật dữ liệu ở đây -->
                            <div class="form-group">
                                <label for="updated_day">Ngày :</label>
                                <input type="number" class="form-control" name="ti_day" id="updated_day">
                            </div>
                            <div class="form-group">
                                <label for="updated_content">Tiêu đề:</label>
                                <input type="text" class="form-control" name="ti_content" id="updated_content">
                            </div>
                            <div class="form-group">
                                <label for="updated_description">Mô tả</label>
                                <textarea name="ti_description" id="updated_description" class="form-control" style="height: 225px;"></textarea>
                            </div>
                            <div class="form-group">
                                <div class="input-group input-file" name="images" id="update_image" >
                                    <span class="input-group-btn">
                                        <button class="btn btn-default btn-choose" type="button">Chọn tệp</button>
                                    </span>
                                    <input type="text" class="form-control" placeholder='Không có tệp nào ...'/>
                                    <span class="input-group-btn"></span>
                                </div>
                                <span class="text-danger"><p class="mg-t-5">{{ $errors->first('images') }}</p></span>
                                @if(isset($tour->touritinerarie) && !empty($tour->touritinerarie->ti_images))
                                    <img src="{{ asset(pare_url_file($touritinerarie->ti_images)) }}" alt=""  class="margin-auto-div img-rounded"  id="image_render" style="height: 150px; width:100%;">
                                @else
                                    <img src="{{ asset('admin/dist/img/no-image.png') }}" alt="" class="margin-auto-div img-rounded"  id="image_render" style="height: 300px; width:100%;">
                                @endif
                            </div>
                   
                            <input type="hidden" name="touritinerarie_id" id="touritinerarie_id">
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
<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Tạo mới</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Nội dung modal -->
                <!-- Đặt các trường và biểu mẫu tạo mới ở đây -->
                <form id="createTourForm" action="{{ route('touritinerarie.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="ti_tour_id" value="{{ $tour->id }}">
                    <div class="form-group">
                        <label for="ti_day">Ngày thứ :</label>
                        <input type="number" class="form-control" name="ti_day" id="ti_day">
                    </div>
                    <div class="form-group">
                        <label for="ti_content">Tiêu đề</label>
                        <input type="text" class="form-control" name="ti_content" id="ti_content">
                    </div>
                    <div class="form-group">
                        <label for="ti_description">Mô tả :</label>
                        <textarea name="ti_description" id="ti_description" class="form-control" style="height: 225px;"></textarea>
                       
                    </div>
                             <div class="form-group">
                                <div class="input-group input-file" name="images" id="update_image">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default btn-choose" type="button">Chọn tệp</button>
                                    </span>
                                    <input type="text" class="form-control" placeholder='Không có tệp nào ...'/>
                                    <span class="input-group-btn"></span>
                                </div>
                                <span class="text-danger"><p class="mg-t-5">{{ $errors->first('images') }}</p></span>
                                <div id="image_preview"> <!-- Thêm một thẻ div để hiển thị hình ảnh -->
                                    @if(isset($tour->touritinerarie) && !empty($tour->touritinerarie->ti_images))
                                    <img src="{{ asset(pare_url_file($touritinerarie->ti_images)) }}" alt="" class="margin-auto-div img-rounded"  id="image_render" style="height: 300px; width:100%;">
                                @else
                                    <img src="{{ asset('admin/dist/img/no-image.png') }}" alt="" class="margin-auto-div img-rounded"  id="image_render" style="height: 300px; width:100%;">
                                @endif
                                </div>
                            </div>
                            
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                <button type="submit" class="btn btn-primary">Lưu</button>
              </form>
            </div>
        </div>
    </div>
</div>
       
    </div>
</div>
<!-- Thư viện jQuery -->


<script>
    $(document).ready(function() {
        // Khi nút "Tạo mới" được nhấn
        $(".btn-info").click(function() {
            // Hiển thị hộp thoại popup tạo mới
            $("#myModal1").modal("show");
        });
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        var createTourBtn = document.querySelector(".btn-info");
        var createTourModal = document.getElementById("myModal1");

        // Khi nút "Tạo mới" được nhấn, hiển thị hộp thoại modal
        createTourBtn.addEventListener("click", function () {
            createTourModal.style.display = "block";
        });

        // Khi nút "Đóng" trong hộp thoại được nhấn, ẩn hộp thoại modal
        var closeModalBtns = createTourModal.querySelectorAll(".btn-secondary");
        closeModalBtns.forEach(function (closeModalBtn) {
            closeModalBtn.addEventListener("click", function () {
                createTourModal.style.display = "none";
            });
        });
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var editTourItinerarieButtons = document.querySelectorAll(".edit-touritinerarie");
        var updateTourItinerarieForm = document.getElementById("updateTourItinerarieForm");
        var updatedDayInput = document.getElementById("updated_day");
        var updatedContentInput = document.getElementById("updated_content");
        var updatedDescriptionInput = document.getElementById("updated_description");
        var updatedImageInput = document.getElementById("update_image");
        var touritinerarieIdInput = document.getElementById("touritinerarie_id");

        editTourItinerarieButtons.forEach(function (editButton) {
            editButton.addEventListener("click", function () {
                var Day = editButton.getAttribute("data-day");
                var Content = editButton.getAttribute("data-content");
                var tourItinerarieId = editButton.getAttribute("data-touritinerarie-id");
                var Description = editButton.getAttribute("data-description");
                var image = editButton.getAttribute("data-images"); // Thay đổi ở đây
                // Cập nhật giá trị id cho action của form chỉnh sửa
                updateTourItinerarieForm.action = "{{ route('touritinerarie.update', '') }}" + "/" + tourItinerarieId;

                // Đổ dữ liệu từ mỗi sự kiện vào form chỉnh sửa
                updatedDayInput.value = Day;
                updatedContentInput.value = Content;
                updatedDescriptionInput.value = Description;
                touritinerarieIdInput.value = tourItinerarieId;
             

                // Hiển thị modal khi bấm nút "Chỉnh sửa"
                $("#editTourItinerarieModal").modal("show");
            });
        });
    });
</script>