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
                        <li class="breadcrumb-item"><a href="{{ route('category.index') }}">Danh mục</a></li>
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

            <div class="row">
                <div class="col-12">
                    <div class="card">
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
                            <table class="table table-hover text-nowrap table-bordered">
                                <thead class="thead-dark">
                                    <tr>
                                        <th width="4%" class=" text-center">STT</th>
                                        <th>Tên danh mục</th>
                                        {{--<th>Danh mục cha</th>--}}
                                        {{--<th>Kiểu danh mục</th>--}}
                                        <th>Trạng thái</th>
                                        <th class=" text-center">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!$categories->isEmpty())
                                        @php $i = $categories->firstItem(); @endphp
                                        @foreach($categories as $category)
                                            <tr>
                                                <td class=" text-center">{{ $i }}</td>
                                                <td>{{ $category->c_name }}</td>
                                                {{--<td>{{ isset($category->parent->c_name) ? $category->parent->c_name : 'Danh mục cha' }}</td>--}}
                                                {{--<td>{{ $types[$category->c_type] }}</td>--}}
                                                <td>{{ $status[$category->c_status] }}</td>
                                                <td class="text-center">
                                                    <a class="btn btn-primary btn-sm edit-vehicle"
                                                    data-category-id="{{ $category->id }}"
                                                    data-name="{{ $category->c_name }}"
                                                    data-status="{{ $category->c_status }}"
                                                    data-description="{{ $category->c_description }}"
                                                    href="javascript:void(0);">
                                                    <i class="fas fa-pencil-alt"></i>
                                                 </a> 
                                                    <a class="btn btn-danger btn-sm btn-delete btn-confirm-delete" href="{{ route('category.delete', $category->id) }}">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            @php $i++ @endphp
                                        @endforeach
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
                                                    <label for="updated_name">Tên danh mục :</label>
                                                    <input type="text" class="form-control" name="c_name" id="updated_name">
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label for="c_status">Trạng thái</label>
                                                    <select class="form-control" name="c_status" id="updated_status">
                                                        <option value="1" {{ $category->c_status == 1 ? 'selected' : '' }}>Hiện</option>
                                                        <option value="2" {{ $category->c_status == 2 ? 'selected' : '' }}>Ẩn</option>
                                                    </select>
                                                </div>     
                                                <div class="form-group">
                                                    <label for="c_description">Mô tả</label>
                                                    <textarea name="c_description" id="updated_description" class="form-control" style="height: 225px"></textarea>
                                                </div>                            
                                                
                                                <input type="hidden" name="category_id" id="category_id">
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary btn-close-modal" data-dismiss="modal">Đóng</button>
                                                    <button type="submit" class="btn btn-primary">Lưu</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="createTourModal" style="z-index: 100000;" tabindex="-1" role="dialog" aria-labelledby="createTourModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="createTourModalLabel">Tạo danh mục</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Thêm biểu mẫu tạo mới điểm du lịch ở đây -->
                                            <form id="createAttractionForm" action="{{ route('category.store') }}" method="POST">
                                                @csrf
                                               
                                                <div class="form-group">
                                                    <label for="c_name">Tên danh mục</label>
                                                    <input type="text" class="form-control" name="c_name" id="c_name">
                                                </div>
                                              <div class="form-group">
                                                    <label for="c_status">Trạng thái</label>
                                                    <select class="form-control" name="c_status" id="c_status">
                                                        <option value="1" {{ $category->c_status == 1 ? 'selected' : '' }}>Hiện</option>
                                                        <option value="2" {{ $category->c_status == 2 ? 'selected' : '' }}>Ẩn</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="c_description">Mô tả</label>
                                                    <input type="text" class="form-control" name="c_description" id="c_description">
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
                            @if($categories->hasPages())
                                <div class="pagination float-right margin-20">
                                    {{ $categories->appends($query = '')->links() }}
                                </div>
                            @endif
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </section>
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
            var editVehicleButtons = document.querySelectorAll(".edit-vehicle");
            var updateVehicleForm = document.getElementById("updateVehicleForm");
            var updatedNameInput = document.getElementById("updated_name");
            var updatedStatusInput = document.getElementById("updated_status"); // Updated this line
            var updatedDescriptionInput = document.getElementById("updated_description"); // Updated this line
            var vehicleIdInput = document.getElementById("category_id"); // Updated this line
    
            editVehicleButtons.forEach(function (editButton) {
                editButton.addEventListener("click", function () {
                    var name = editButton.getAttribute("data-name");
                    var vehicleId = editButton.getAttribute("data-category-id");
                    var status = editButton.getAttribute("data-status");
                    var Description = editButton.getAttribute("data-description");
    
                    // Update the action attribute for the form
                    updateVehicleForm.action = "{{ route('category.update', '') }}" + "/" + vehicleId;
    
                    // Populate form fields with data
                    updatedNameInput.value = name;
                    updatedStatusInput.value = status;
                    updatedDescriptionInput.value = Description;
                    vehicleIdInput.value = vehicleId;
    
                    // Show the modal when clicking "Chỉnh sửa" button
                    $("#editVehicleModal").modal("show");
                });
            });
        });
    </script>
@stop
