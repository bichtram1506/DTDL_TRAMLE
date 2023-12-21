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
                            <li class="breadcrumb-item"><a href="{{ route('location.index') }}">Địa điểm</a></li>
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
                                    <input type="text" name="l_name" class="form-control mg-r-15" placeholder="Tên địa điểm">
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
                                @if ($locations->isNotEmpty())
                                    @foreach ($locations as $location)
                                        <tr>
                                            <td class="text-center" style="vertical-align: middle; width: 2%">{{ $location->id }}</td>
                                          
                                            <td style="vertical-align: middle; width: 18%" class="title-content">
                                                {{ $location->l_name }}
                                            </td>
                                            <td style="vertical-align: middle; width: 38%" class="title-content">
                                                {{ $location->l_description }}
                                            </td>
                                            <td class="text-center" style="vertical-align: middle;">
                                                <a class="btn btn-primary btn-sm edit-vehicle"
                                                data-location-id="{{ $location->id }}"
                                                data-name="{{ $location->l_name }}"
                                                data-description="{{ $location->l_description }}"
                                                data-region-id="{{ $location->region->id }}"
                                                href="javascript:void(0);">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            
                                                <a class="btn btn-danger btn-sm btn-delete btn-confirm-delete" href="{{ route('location.delete', $location->id) }}">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                            </table>
                            <div class="modal fade" id="editVehicleModal" tabindex="-1" role="dialog" style="z-index: 100000;" aria-labelledby="editVehicleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editVehicleModalLabel">Chỉnh sửa</h5>
                                            <button type="button" class="close btn-close-modal" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="updateVehicleForm" method="POST" action="">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="updated_region_id">Vùng miền</label>
                                                    <select class="form-control" name="l_region_id" id="updated_region_id">
                                                        @foreach ($regions as $region)
                                                            <option value="{{ $region->id }}">{{ $region->r_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="updated_name">Tên</label>
                                                    <input type="text" class="form-control" name="l_name" id="updated_name">
                                                </div>
                                                <div class="form-group">
                                                    <label for="updated_description">Mô tả</label>
                                                    <textarea name="l_description" id="updated_description" class="form-control" style="height: 225px"></textarea>
                                                </div>
                                                <input type="hidden" name="location_id" id="location_id">
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary btn-close-modal" data-dismiss="modal">Đóng</button>
                                                    <button type="submit" class="btn btn-primary">Lưu</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="createTourModal" tabindex="-1" style="z-index: 9999;" role="dialog" aria-labelledby="createTourModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="createTourModalLabel">Tạo mới tỉnh</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="createLocationForm" action="{{ route('location.store') }}" method="POST">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="l_region_id">Vùng miền</label>
                                                    <select class="form-control" name="l_region_id" id="l_region_id">
                                                      
                                                        @foreach ($regions as $region)
                                                            <option value="{{ $region->id }}">{{ $region->r_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="l_name">Tên</label>
                                                    <input type="text" class="form-control" name="l_name" id="l_name">
                                                </div>
                                                <div class="form-group">
                                                    <label for="l_description">Mô tả</label>
                                                    <textarea name="l_description" id="l_description" class="form-control" style="height: 225px"></textarea>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                                                    <button type="submit" class="btn btn-primary">Lưu</button>
                                                </div>
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
    var editVehicleButtons = document.querySelectorAll(".edit-vehicle");
    var editVehicleModal = document.getElementById("editVehicleModal");

    createTourBtn.addEventListener("click", function () {
        $(createTourModal).modal("show");
    });

    
});
</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var editVehicleButtons = document.querySelectorAll(".edit-vehicle");
        var updateVehicleForm = document.getElementById("updateVehicleForm");
        var updatedRegionIdInput = document.getElementById("updated_region_id");
        var updatedNameInput = document.getElementById("updated_name");
        var updatedDescriptionInput = document.getElementById("updated_description");
        var locationIdInput = document.getElementById("location_id");
    
        editVehicleButtons.forEach(function (editButton) {
            editButton.addEventListener("click", function () {
                var locationId = editButton.getAttribute("data-location-id");
                var name = editButton.getAttribute("data-name");
                var description = editButton.getAttribute("data-description");
                var regionId = editButton.getAttribute("data-region-id");
    
                updatedRegionIdInput.value = regionId;
                // Update the action attribute for the form
                updateVehicleForm.action = "{{ route('location.update', '') }}" + "/" + locationId;

                updatedNameInput.value = name;
                updatedDescriptionInput.value = description;
                locationIdInput.value = locationId;
    
                // Show the modal when clicking "Chỉnh sửa" button
                $("#editVehicleModal").modal("show");
            });
        });
    });
    </script>
    
<!-- Modal -->

@stop
