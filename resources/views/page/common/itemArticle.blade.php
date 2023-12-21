<style>
    .blog-entry {
    position: relative;
    overflow: hidden;
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    transition: 0.3s;
}

.blog-img {
    height: 300px; /* Điều chỉnh kích thước ảnh nền */
    background-size: cover;
    background-position: center;
}

.text {
    padding: 20px;
}

.meta {
    display: flex;
    justify-content: space-between;
    margin-bottom: 15px;
}

.meta .date {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.meta .date .day {
    font-size: 24px;
    font-weight: bold;
    color: #fff;
    background-color: #007bff;
    border-radius: 50%;
    padding: 5px 10px;
}

.meta .date .month-year {
    margin-top: 5px;
    text-align: center;
    color: #555;
}

.heading a {
    color: #333;
    text-decoration: none;
    font-size: 20px;
    font-weight: bold;
    transition: color 0.3s;
}

.heading a:hover {
    color: #007bff;
}

.excerpt {
    color: #777;
    font-size: 16px;
    line-height: 1.6;
    margin-bottom: 20px;
}

.read-more a {
    color: #fff;
    background-color: #007bff;
    padding: 10px 15px;
    border-radius: 5px;
    text-decoration: none;
    transition: background-color 0.3s;
}

.read-more a:hover {
    background-color: #0056b3;
}

</style>
<div class="col-md-4 d-flex ftco-animate fadeInUp ftco-animated">
    <div class="blog-entry justify-content-end">
        <a href="{{ route('articles.detail', ['id' => $article->id, 'slug' => safeTitle($article->a_title)]) }}" class="block-20 blog-img"
           style="background-image: url({{ asset(pare_url_file($article->a_avatar)) }});" alt="{{ $article->a_title }}">
        </a>
        <div class="text">
            <div class="meta">
                <div class="date">
                    <span class="day">{{ date('d', strtotime($article->created_at)) }}</span>
                    <span class="month-year">
                        <span class="month">{{ date('M', strtotime($article->created_at)) }}</span>
                        <span class="year">{{ date('Y', strtotime($article->created_at)) }}</span>
                    </span>
                </div>
            </div>
            <h3 class="heading" title="{{ $article->a_title }}">
                <a href="{{ route('articles.detail', ['id' => $article->id, 'slug' => safeTitle($article->a_title)]) }}">
                    {{ the_excerpt($article->a_title, 100) }}
                </a>
            </h3>
            <p class="excerpt">{!! the_excerpt($article->a_description, 200) !!}</p>
            <p class="read-more">
                <a href="{{ route('articles.detail', ['id' => $article->id, 'slug' => safeTitle($article->a_title)]) }}" class="btn btn-primary">Xem thêm</a>
            </p>
        </div>
    </div>
</div>
