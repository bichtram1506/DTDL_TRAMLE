@extends('admin.layouts.main')
@section('title', '')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}"> <i class="nav-icon fas fa fa-home"></i> Trang chủ</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('tour.index') }}">Tour</a></li>
                        <li class="breadcrumb-item active">Chi Tiết</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4">
                    <div class="card card-primary">
                        <div class="card-body">
                            <h3><?php echo $tour->t_title; ?></h3>
                            <p><strong>Địa điểm:</strong> <?php echo $tour->location->l_name; ?></p>
                            <p><strong>Trạng thái:</strong> <?php echo $status[$tour->t_status]; ?></p>
                            <p><strong>Số lượng người tham gia:</strong> <?php echo $tour->t_number_guests; ?></p>
                            <p><strong>Giảm giá:</strong> <?php echo $tour->t_sale; ?></p>
                            <p><strong>Giá người lớn:</strong> <?php echo $tour->t_price_adults; ?></p>
                            <p><strong>Giá trẻ em:</strong> <?php echo $tour->t_price_children; ?></p>
                            <p><strong>Phương tiện di chuyển:</strong> <?php echo $tour->t_move_method; ?></p>
                            <p><strong>Chặng hành trình:</strong> <?php echo $tour->t_journeys; ?></p>
                            <p><strong>Cổng khởi hành:</strong> <?php echo $tour->t_starting_gate; ?></p>
                            <p><strong>Điểm đến:</strong> <?php echo $tour->t_destination; ?></p>
                            <p><strong>Ngày bắt đầu:</strong> <?php echo $tour->t_start_date; ?></p>
                            <p><strong>Số lượng đã đăng ký:</strong> <?php echo $tour->t_number_registered; ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h4><strong>Mô tả:</strong></h4>
                                    <p><?php echo $tour->t_description; ?></p>
                                    <h4><strong>Nội dung:</strong></h4>
                                    <p><?php echo $tour->t_content; ?></p>
                                </div>
                                <div class="col-md-6">
                                    <h4><strong>Hình ảnh:</strong></h4>
                                    <div class="text-center">
                                        @if(isset($tour) && !empty($tour->t_image))
                                            <img src="{{ asset(pare_url_file($tour->t_image)) }}" alt="Tour Image" class="img-rounded" style="max-height: 300px; width: auto;">
                                        @else
                                            <img src="{{ asset('admin/dist/img/no-image.png') }}" alt="No Image" class="img-rounded" style="max-height: 300px; width: auto;">
                                        @endif
                                    </div>
                                    <h4><strong>Menu:</strong></h4>
                                    <p><?php echo $tour->t_menu; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
                    
@stop