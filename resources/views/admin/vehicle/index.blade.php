
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
                        <li class="breadcrumb-item"><a href="{{ route('vehicle.index') }}">Phương tiện</a></li>
                        <li class="breadcrumb-item active">Danh sách</li>
                    </ol>
                       </ul>
                  </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

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
            <thead class="thead-dark">
                <tr>
                   <th class="gray-header">Tên phương tiện</th> 
                   <th class="gray-header">Số chỗ</th>
                   <th class="gray-header">Mô tả</th>
                   <th class="gray-header">Trạng thái</th>
                   <th class="text-center gray-header">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @if ($vehicles->isNotEmpty())
                @foreach ($vehicles as $vehicle)
                        <tr>    
                          
                            <td class="text-center" style="vertical-align: middle; width: 15%">
                                <p>{{ $vehicle->v_name }}</p>
                            </td>
                            <td class="text-center" style="vertical-align: middle; width: 10%">
                                <p>{{ $vehicle->v_capacity }}</p>
                            </td>
                            <td class="text-left" style="vertical-align: middle; width: 10% ;height :20px">
                                {!! $vehicle->v_description !!}
                            </td>    
                            <td class="text-left" style="vertical-align: middle; width: 10%; height: 10px;">
                                @if($vehicle->v_status == 1)
                                  Đang sử dụng
                                @elseif($vehicle->v_status == 2)
                                    Đang bảo trì
                                @endif
                            </td>                        
                            <td class="text-center" style="vertical-align: middle; width: 10%; height: 10px;">
                                <!-- Hành động -->                                          
                                <a class="btn btn-primary btn-sm edit-vehicle"
                                data-vehicle-id="{{ $vehicle->id }}"
                                data-name="{{ $vehicle->v_name }}"
                                data-capacity="{{ $vehicle->v_capacity }}"
                                data-description="{{ $vehicle->v_description }}"
                                data-status="{{ $vehicle->v_status }}"
                                href="javascript:void(0);">
                                <i class="fas fa-pencil-alt"></i>
                             </a>                                  
                                                    <a class="btn btn-danger btn-sm btn-delete btn-confirm-delete" href="{{ route('vehicle.delete', $vehicle->id) }}">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </a>   
                           </td>
                        </tr>
                    @endforeach
              @endif
            </tbody>
        </table>
         
        <div class="modal fade" id="editVehicleModal" tabindex="-1" role="dialog" aria-labelledby="editVehicleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editVehicleModalLabel">Chỉnh sửa </h5>
                        <button type="button" class="close btn-close-modal" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="updateVehicleForm" method="POST" action="">
                            @csrf
                            <!-- Các trường cập nhật dữ liệu ở đây -->
                            <div class="form-group">
                                <label for="updated_name">Tên  :</label>
                                <input type="text" class="form-control" name="v_name" id="updated_name">
                            </div>
                            <div class="form-group">
                                <label for="updated_capacity">Số chỗ:</label>
                                <input type="number" class="form-control" name="v_capacity" id="updated_capacity">
                            </div>
                            <div class="form-group">
                                <label for="v_status">Trạng thái</label>
                                <select name="v_status" id="updated_status" class="form-control">
                                    <option value="1" {{ $vehicle->v_status == 1 ? 'selected' : '' }}>Đang sử dụng</option>
                                    <option value="2" {{ $vehicle->v_status == 2 ? 'selected' : '' }}>Đang bảo trì</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="v_description">Mô tả</label>
                                <textarea name="v_description" id="updated_description" class="form-control" style="height: 225px"></textarea>
                            </div>                            
                            
                            <input type="hidden" name="vehicle_id" id="vehicle_id">
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
                <form id="createVehicleForm" action="{{ route('vehicle.store') }}" method="POST">
                    @csrf
                 
                    <div class="form-group">
                        <label for="v_name">Tên</label>
                        <input type="text" class="form-control" name="v_name" id="v_name">
                    </div>
                    <div class="form-group">
                        <label for="v_capacity">Số chỗ</label>
                        <input type="number" class="form-control" name="v_capacity" id="v_capacity">
                    </div>
                    <div class="form-group">
                        <label for="v_description">Mô tả :</label>
                        <textarea name="v_description" id="v_description" class="form-control" style="height: 225px;"></textarea>
                       
                    </div>
                    <div class="form-group">
                        <label for="v_status">Trạng thái</label>
                        <select name="v_status" id="v_status" class="form-control">
                            <option value="1">Đang sử dụng</option>
                            <option value="2">Đang bảo trì</option>
                        </select>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
        var createVehicleBtn = document.querySelector(".btn-info");
        var createVehicleModal = document.getElementById("myModal1");

        // Khi nút "Tạo mới" được nhấn, hiển thị hộp thoại modal
        createVehicleBtn.addEventListener("click", function () {
            createVehicleModal.style.display = "block";
        });

        // Khi nút "Đóng" trong hộp thoại được nhấn, ẩn hộp thoại modal
        var closeModalBtns = createVehicleModal.querySelectorAll(".btn-secondary");
        closeModalBtns.forEach(function (closeModalBtn) {
            closeModalBtn.addEventListener("click", function () {
                createVehicleModal.style.display = "none";
            });
        });
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var editVehicleButtons = document.querySelectorAll(".edit-vehicle");
        var updateVehicleForm = document.getElementById("updateVehicleForm");
        var updatedNameInput = document.getElementById("updated_name");
        var updatedStatusInput = document.getElementById("updated_status"); // Updated this line
        var updatedCapacityInput = document.getElementById("updated_capacity");
        var updatedDescriptionInput = document.getElementById("updated_description"); // Updated this line
        var vehicleIdInput = document.getElementById("vehicle_id"); // Updated this line

        editVehicleButtons.forEach(function (editButton) {
            editButton.addEventListener("click", function () {
                var name = editButton.getAttribute("data-name");
                var capacity = editButton.getAttribute("data-capacity");
                var status = editButton.getAttribute("data-status");
                var vehicleId = editButton.getAttribute("data-vehicle-id");
                var description = editButton.getAttribute("data-description");

                // Update the action attribute for the form
                updateVehicleForm.action = "{{ route('vehicle.update', '') }}" + "/" + vehicleId;

                // Populate form fields with data
                updatedNameInput.value = name;
                updatedStatusInput.value = status;
                updatedCapacityInput.value = capacity;
                updatedDescriptionInput.value = description;
                vehicleIdInput.value = vehicleId;

                // Show the modal when clicking "Chỉnh sửa" button
                $("#editVehicleModal").modal("show");
            });
        });
    });
</script>

</section>
@stop
