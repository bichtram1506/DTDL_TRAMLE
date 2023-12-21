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
                            <li class="breadcrumb-item"><a href="{{ route('tour.index') }}">Miền</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('location.index') }}">Tỉnh</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('attraction.index') }}">Địa điểm du lịch</a></li>
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
    <section class="content">
        <div class="container-fluid">
            <div class="card card-default">
                <div class="card-header card-header-border-bottom">
                    <h3 class="card-title">Form tìm kiếm</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form action="">
                        <div class="row">
                            <div class="col-sm-12 col-md-4">
                                <div class="form-group">
                                    <input type="text" name="at_name" class="form-control mg-r-15" placeholder="Tên địa điểm">
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-success btn-search" style="padding: 10px 20px; font-size: 16px;"><i class="fas fa-search"></i> Tìm kiếm</button>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <a class="btn btn-delete btn-sm pdf-file" type="button" title="In" onclick="myFunction(this)"><i class="fas fa-file-pdf"></i> Xuất PDF</a>
                <div  class="card" >
                    <div class="card-header">
                        <div class="card-tools">
                            <div class="btn-group">
                                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#createTourModal">
                                    <i class="fas fa-pencil-alt"></i> Tạo mới
                                </a>
                                
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">

                        <table class="table table-hover table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th width="4%" class=" text-center">STT</th>
                                      <th class="text-center">Tên</th>
                                      <th class="text-center">Mô tả</th>
                                    @if(Auth::user()->can(['full-quyen-quan-ly', 'xoa-va-cap-nhat-trang-thai']))
                                    <th class="text-center">Hành động</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @if ($attractions->isNotEmpty()) 
                                @foreach ($attractions as $attraction)
                                    <tr>
                                        <td class="text-center" style="vertical-align: middle; width: 2%">{{ $attraction->id }}</td>
                                    
                                        <td style="vertical-align: middle; width: 25%" class="title-content">
                                            {{ $attraction->at_name }}
                                        </td>
                                   
                                        <td style="vertical-align: middle; width: 55%" class="title-content">
                                            {{ $attraction->at_description }} 
                                        </td>
                                        <td class="text-center" style="vertical-align: middle;">
                                           
                                            <a class="btn btn-primary btn-sm edit-vehicle"
                                            data-attraction-id="{{ $attraction->id }}"
                                            data-name="{{ $attraction->at_name }}"
                                            data-description="{{ $attraction->at_description }}"
                                            data-location-id="{{ $attraction->location->id }}"
                                            href="javascript:void(0);">
                                            <i class="fas fa-pencil-alt"></i>
                                         </a> 
                                            <a class="btn btn-danger btn-sm btn-delete btn-confirm-delete" href="{{ route('attraction.delete', $attraction->id) }}">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                       
                                    </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="7" class="text-center">Không có điểm du lịch nào cho tỉnh này.</td>
                                </tr>
                            @endif
                            
                            </tbody>
                        </table>
                        <div class="modal fade" id="editVehicleModal" tabindex="-1" role="dialog" style="z-index: 100000;" aria-labelledby="editVehicleModalLabel" aria-hidden="true">
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
                                                <input type="text" class="form-control" name="at_name" id="updated_name">
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="at_description">Mô tả</label>
                                                <textarea name="at_description" id="updated_description" class="form-control" style="height: 225px"></textarea>
                                            </div>                            
                                            <div class="form-group">
                                                <label for="updated_location">Tỉnh:</label>
                                                <select class="form-control" name="at_location_id" id="updated_location_id">
                                                    @foreach ($locations as $location)
                                                        <option value="{{ $location->id }}" {{ $attraction->at_location_id == $location->id ? 'selected' : '' }}>
                                                            {{ $location->l_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <input type="hidden" name="attraction_id" id="attraction_id">
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
                        <div class="modal fade" id="createTourModal" style="z-index: 100000;" tabindex="-1" role="dialog" aria-labelledby="createTourModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="createTourModalLabel">Tạo mới điểm du lịch</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Thêm biểu mẫu tạo mới điểm du lịch ở đây -->
                                        <form id="createAttractionForm" action="{{ route('attraction.store') }}" method="POST">
                                            @csrf
                                            
                                            <div class="form-group">
                                                <label for="at_name">Tên địa điểm</label>
                                                <input type="text" class="form-control" name="at_name" id="at_name">
                                            </div>
                                            <div class="form-group">
                                                <label for="at_description">Mô tả</label>
                                                <input type="text" class="form-control" name="at_description" id="at_description">
                                            </div>
                                            <div class="form-group">
                                                <label for="at_location">Tỉnh:</label>
                                                <select class="form-control" name="at_location_id" id="at_location_id">
                                                    @foreach ($locations as $location)
                                                        <option value="{{ $location->id }}">{{ $location->l_name }}</option>
                                                    @endforeach
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
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>
</section>

<!-- Modal -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var createTourBtn = document.querySelector(".btn-info");
        var createTourModal = document.getElementById("createTourModal");

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
        var editVehicleButtons = document.querySelectorAll(".edit-vehicle");
        var updateVehicleForm = document.getElementById("updateVehicleForm");
        var updatedNameInput = document.getElementById("updated_name");
        var updatedDescriptionInput = document.getElementById("updated_description");
        var updatedLocationIdInput = document.getElementById("updated_location_id");
        var vehicleIdInput = document.getElementById("attraction_id");

        editVehicleButtons.forEach(function (editButton) {
            editButton.addEventListener("click", function () {
                var name = editButton.getAttribute("data-name");
                var vehicleId = editButton.getAttribute("data-attraction-id");
                var description = editButton.getAttribute("data-description");
                var locationId = editButton.getAttribute("data-location-id");
    
          updatedLocationIdInput.value = locationId;
                // Update the action attribute for the form
                updateVehicleForm.action = "{{ route('attraction.update', '') }}" + "/" + vehicleId;

                // Populate form fields with data
                updatedNameInput.value = name;
                updatedDescriptionInput.value = description;
                vehicleIdInput.value = vehicleId;

                // Show the modal when clicking "Chỉnh sửa" button
                $("#editVehicleModal").modal("show");
            });
        });
    });
</script>
    <!-- Your modal content here -->
</div>
@stop
