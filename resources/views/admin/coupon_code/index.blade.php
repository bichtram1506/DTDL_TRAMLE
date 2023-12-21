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
                        <li class="breadcrumb-item"><a href="{{ route('couponcode.index') }}">Khuyến mãi</a></li>
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
                        <form action="" class="row">
                        
                            <div class="col-sm-12 col-md-3">
                                <div class="form-group">
                                    <label>Tên mã giảm giá</label>
                                    <input type="text" name="cc_name" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <div class="form-group">
                                    <label for="b_status">Trạng thái</label>
                                    <select class="form-control" id="cc_status" name="cc_status">
                                        <option value="">Tất cả</option>
                                        @foreach($status as $value => $label)
                                            <option value="{{ $value }}" class="{{ $status[$value] }}" @if($value == $request->cc_status) selected @endif>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    
                                </div>
                            </div>
    
                            <div class="col-sm-12 ">
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
                    <a class="btn btn-delete btn-sm pdf-file" type="button" title="In" onclick="myFunction(this)"><i class="fas fa-file-pdf"></i> Xuất PDF</a>
                    <div class="card">
                        <div class="card-header">
                            <div class="card-tools">
                                <div class="btn-group">
                                    <a href="{{ route('couponcode.create') }}"><button type="button" class="btn btn-block btn-info"> <i class="fas fa-pencil-alt"></i> Tạo mới</button></a>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover table-bordered">
                                <thead class="thead-dark">
                                <tr>
                                    <th width="4%" class=" text-center">STT</th>
                                    <th  class="text-center">Tên mã</th>
                                    <th  class="text-center">Mã giảm</th>
                                    <th  class="text-center">Ngày bắt đầu</th>
                                    <th  class="text-center">Ngày kết thúc</th>
                                    <th  class=" text-center">Số lượng</th>
                                    <th  class="text-center">Số giảm</th>
                                    <th  class=" text-center">Tình trạng</th>
                                    <th  class=" text-center">Hết hạn</th>
                                    <th  class=" text-center">Hành động</th>
                                
                                </tr>
                                </thead>
                                <tbody>
                                @if (!$couponcodes->isEmpty())
                                    @php $i = $couponcodes->firstItem(); @endphp
                                    @foreach ($couponcodes as $couponcode)
                                    <tr>
                                        
                                        <td class="text-center" style="vertical-align: middle; width: 2%">{{ $i }}</td>
                                        <td class="text-center"  style="vertical-align: middle; width: 10%" class="title-content">
                                                    <p>{{ $couponcode->cc_name }}</p>
                                        </td>   
                                        <td class="text-center" style="vertical-align: middle; width: 12%"> 
                                            <p>{{ $couponcode->cc_code }}</p>
                                            
                                        </td>
                                          <td class="text-center" style="vertical-align: middle; width: 12%"> 
                                            <p>{{ date('d/m/Y', strtotime($couponcode->cc_start_date)) }}</p>
                                            
                                        </td>
                                      
                                        <td class="text-center" style="vertical-align: middle; width: 10%"> 
                                            <p>{{ date('d/m/Y', strtotime($couponcode->cc_expiry_date)) }}</p>
                                        </td>
                                        <td class="text-center" style="vertical-align: middle; width: 10%"> 
                                            <p> {{  $couponcode->cc_remaining_code }}</p>
                                            <p><b>Đã sử dụng:</b> {{ $couponcode->usageCount()->count() }}</p>

                                        </td>
                                        <td class="text-center" style="vertical-align: middle; width: 8%"> 
                                            <p>{{  $couponcode->cc_percentage }} %</p>
                                        </td>
                                        <td style="vertical-align: middle; width: 11%">
                                            <button type="button" class="btn btn-block {{ $classStatus[$couponcode->cc_status] }} btn-xs">{{ $status[$couponcode->cc_status] }}</button>
                                        </td>
                                        <td class="text-center" style="vertical-align: middle; width: 10%">
                                            @php
                                            $expiryDate = strtotime($couponcode->cc_expiry_date);
                                            $currentDate = time();
                                            if ($expiryDate < $currentDate) {
                                                echo '<p style="color: red;">Đã hết hạn</p>';
                                            } else {
                                                echo '<p>Còn hạn</p>';
                                            }
                                        @endphp                                        
                                        </td>
                                        
                                        <td class="text-center" style="vertical-align: middle; width: 16%">
                                            <a class="btn btn-primary btn-sm" href="{{ route('couponcode.update', $couponcode->id) }}">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            <a class="btn btn-danger btn-sm btn-delete btn-confirm-delete" href="{{ route('couponcode.delete', $couponcode->id) }}">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                        <!-- ... Other columns ... -->
                        
                                        </tr>
                                        @php $i++ @endphp
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                            @if($couponcodes->hasPages())
                            <div class="pagination float-right margin-20">
                                {{ $couponcodes->appends($query = '')->links() }}
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
@stop
