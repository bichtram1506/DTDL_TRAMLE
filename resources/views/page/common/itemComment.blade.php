<li class="comment">
    <div class="vcard bio">
        <img src="{{ asset(isset($comment) && !empty($comment->user->avatar) ? asset(pare_url_file($comment->user->avatar)) : 'page/images/person_1.jpg') }}" alt="Image placeholder">
    </div>
    <div class="comment-body">
        <h3>{{ isset($comment) && !empty($comment->user->name) ? $comment->user->name : 'User Default' }}</h3>
        @if ($comment->cm_status == 2)
            <span class="badge badge-warning">Nổi bật</span>
        @endif
        <div>
            @if (isset($comment->cm_rating))
            @if (isset($comment->cm_hotel_id) && !isset($comment->cm_tour_id))
                <span class="badge badge-success">Khách hàng đã trải nghiệm khách sạn</span>
            @elseif (isset($comment->cm_tour_id) && !isset($comment->cm_hotel_id))
                <span class="badge badge-success">Khách hàng đã trải nghiệm tour</span>
            @endif
        @endif
        
            <div class="starability-result" data-rating="{{ $comment->cm_rating }}">
                <span class="starability-outer">
                    <span class="starability-inner" style="width: {{ $comment->cm_rating/5*100 }}%"></span>
                </span>
                <span class="starability-text">
                    @if (isset($comment->cm_rating)) <!-- Kiểm tra xem $comment->cm_rating có tồn tại -->
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= $comment->cm_rating)
                                <span class="fa fa-star checked"></span>
                            @else
                                <span class="fa fa-star" style="color: gray;"></span>
                            @endif
                        @endfor
                    @endif
                </span>
            
            </div>
            
            {!! str_replace('\n', '</br>', $comment->cm_content) !!}
            <div class="text-muted small">{{ $comment->created_at->format('d/m/Y H:i') }}</div>
            <div class="text-primary font-weight-bold">{{ $comment->created_at->locale('vi')->diffForHumans() }}</div>
        </div>        
        @if(Auth::guard('users')->check() && ($comment->cm_user_id == Auth::guard('users')->user()->id || Auth::guard('users')->user()->role == 'admin'))
        <form action="{{ route('commentuser.delete', $comment->id) }}" method="GET">
            @csrf
            <button type="submit" class="btn btn-sm btn-outline-danger">Xóa bình luận</button>
        </form>
        @endif
    </div>
</li>
