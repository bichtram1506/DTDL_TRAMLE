@if ($comment->cm_rating)
    <div class="starability-result" data-rating="{{ $comment->cm_rating }}">
        <span class="starability-outer">
            <span class="starability-inner" style="width: {{ $comment->cm_rating/5*100 }}%"></span>
        </span>
        <span class="starability-text">
            @for ($i = 1; $i <= 5; $i++)
                @if ($i <= $comment->cm_rating)
                    <span class="fa fa-star checked"></span>
                @else
                    <span class="fa fa-star"></span>
                @endif
            @endfor
        </span>
    </div>
@else
    Chưa có đánh giá
@endif

<style>
    .starability-result .checked {
        color: #FFD700; /* Đây là màu sắc ví dụ, bạn có thể thay đổi thành màu sắc mong muốn */
    }
</style>
