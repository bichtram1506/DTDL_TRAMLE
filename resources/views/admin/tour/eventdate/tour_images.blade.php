
<div  class="card">
    <div class="card-header">
        <div class="card-tools">
            <div class="btn-group">
                <button type="button" class="btn btn-block btn-info" data-toggle="modal" data-target="#myModal2">
                    <i class="fas fa-pencil-alt"></i> Tạo mới
                </button>
            </div>
            
        </div>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap table-bordered">
            <thead>
                <tr>
                   <th width="4%" class=" gray-header text-center">STT</th>
                   <th class="gray-header">Tiêu đề</th> 
                   <th class="gray-header">Hình ảnh</th>
                   <th class="text-center gray-header">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @if ($tour->tourImages->isNotEmpty())
                @foreach ($tour->tourImages as $tourImage)
                        <tr>    
                            <td class="text-center" class="title-content" style="vertical-align: middle; width: 2%">{{ $tourImage->id }}</td>
                            <td class="text-center" style="vertical-align: middle; width: 30%">
                                <p>{{ $tourImage->tm_name }}</p>
                            </td>
                            <td style="vertical-align: middle; width:15%;">
                                @if(isset($tourImage) && !empty($tourImage->tm_image_url))
                                    <img src="{{ asset(pare_url_file($tourImage->tm_image_url)) }}" alt="" class="margin-auto-div img-rounded"  id="image_render" style="height: 100px; width:100%;">
                                @else
                                    <img src="{{ asset('admin/dist/img/no-image.png') }}" alt="" class="margin-auto-div img-rounded"  id="image_render" style="height: 100px; width:100%;">
                                @endif
                            </td>                       
                            <td class="text-center" style="vertical-align: middle;">
                                <!-- Hành động -->                                          
                                <a class="btn btn-primary btn-sm edit-tourimage"
                                data-tourimage-id="{{ $tourImage->id }}"
                                data-name="{{ $tourImage->tm_name }}"
                                data-images="{{ $tourImage->tm_image_url }}"
                            href="javascript:void(0);"> <!-- Sử dụng href javascript:void(0); để tránh chuyển hướng -->
                                <i class="fas fa-pencil-alt"></i>
                            </a>   
                                                         
                            <a class="btn btn-danger btn-sm btn-delete btn-confirm-delete" href="#">
                               <i class="fas fa-trash-alt"></i>
                            </a>   
                           </td>
                        </tr>
                    @endforeach
              @endif
            </tbody>
        </table>
     <!-- Modal -->
        <div class="modal fade" id="editTourImageModal" tabindex="-1" role="dialog" aria-labelledby="editTourImageModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editTourImageModalLabel">Chỉnh sửa chương trình tour</h5>
                        <button type="button" class="close btn-close-modal" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="updateTourImageForm" method="POST" action="" enctype="multipart/form-data">
                            @csrf
                            <!-- Các trường cập nhật dữ liệu ở đây -->
                            <div class="form-group">
                                <label for="updated_name">Tiêu đề :</label>
                                <input type="text" class="form-control" name="tm_name" id="updated_name">
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
                                @if(isset($tour->tourImage) && !empty($tour->tourImage->tm_image_url))
                                    <img src="{{ asset(pare_url_file($tourImage->tm_image_url)) }}" alt="" class="margin-auto-div img-rounded"  id="image_render" style="height: 300px; width:100%;">
                                @else
                                    <img src="{{ asset('admin/dist/img/no-image.png') }}" alt="" class="margin-auto-div img-rounded"  id="image_render" style="height: 300px; width:100%;">
                                @endif
                            </div>
                            <input type="hidden" name="tourimage_id" id="tourimage_id">
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
        <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModal2Label" aria-hidden="true" >
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModal2Label">Tạo mới hình ảnh tour</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="createTourImageForm" action="{{ route('tourimage.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="tm_tour_id" value="{{ $tour->id }}">
                            <div class="form-group">
                                <label for="tm_name">Tiêu đề</label>
                                <input type="text" class="form-control" name="tm_name" id="tm_name">
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
                                    @if(isset($tour->tourImage) && !empty($tour->tourImage->tm_image_url))
                                        <img src="{{ asset(pare_url_file($tourImage->tm_image_url)) }}" alt="" class="margin-auto-div img-rounded"  id="image_render" style="height: 300px; width:100%;">
                                    @else
                                        <img src="{{ asset('admin/dist/img/no-image.png') }}" alt="" class="margin-auto-div img-rounded"  id="image_render" style="height: 300px; width:100%;">
                                    @endif
                                </div>
                            </div>
                            
                            
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                                <button type="submit" form="createTourImageForm" class="btn btn-primary">Lưu</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
 </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        var createNewButton = document.querySelector(".btn-info[data-target='#myModal2']");
        var modal = document.querySelector("#myModal2");

        createNewButton.addEventListener("click", function () {
            // Hiển thị modal khi bấm vào nút "Tạo mới"
            $(modal).modal("show");
        });
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var editTourImageButtons = document.querySelectorAll(".edit-tourimage");
        var updateTourImageForm = document.getElementById("updateTourImageForm");
        var updatedNameInput = document.getElementById("updated_name");
        var updatedImageInput = document.getElementById("update_image");
      
        var tourImageIdInput = document.getElementById("tourimage_id");

        editTourImageButtons.forEach(function (editButton) {
            editButton.addEventListener("click", function () {
                var name = editButton.getAttribute("data-name");
                var image = editButton.getAttribute("data-images"); // Thay đổi ở đây
                var tourImageId = editButton.getAttribute("data-tourimage-id");
                
                // Cập nhật giá trị id cho action của form chỉnh sửa
                updateTourImageForm.action = "{{ route('tourimage.update', '') }}" + "/" + tourImageId;

                // Đổ dữ liệu từ mỗi sự kiện vào form chỉnh sửa
                updatedNameInput.value = name;
                updatedImageInput.value = image; // Thay đổi ở đây
                tourImageIdInput.value = tourImageId;
             

                // Hiển thị modal khi bấm nút "Chỉnh sửa"
                $("#editTourImageModal").modal("show");
            });
        });
    });
</script>

<!-- Đặt mã JavaScript tại đây -->

