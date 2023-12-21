
<style>
    /* Tùy chỉnh CSS cho câu hỏi và câu trả lời */
    .faqs {
        background-color: #6e642db1;
        padding: 50px;
    }

    .card-header {
        background-color: #dcc2cd;
        color: #fff;
    }

    .card-body {
        background-color: #fff;
        color: #333;
    }

    .card {
        margin-bottom: 10px;
    }

    /* Đổi màu mũi tên khi câu trả lời được mở */
    .btn-link[aria-expanded="true"] {
        color: #ff6b6b;
    }
</style>

<section class="faqs read-content-middle">
    <div class="accordion" id="questionAccordion">
        <div class="card">
            <div class="card-header" id="question1">
                <h5 class="mb-0">
                    <button class="btn btn-link" data-toggle="collapse" data-target="#answer1" aria-expanded="true" aria-controls="answer1">
                        Câu hỏi 1: Làm thế nào để đặt tour du lịch?
                    </button>
                </h5>
            </div>

            <div id="answer1" class="collapse show" aria-labelledby="question1" data-parent="#questionAccordion">
                <div class="card-body">
                    Để đặt tour du lịch, bạn có thể thực hiện các bước sau:
                    <ol>
                        <li>Truy cập trang web của chúng tôi.</li>
                        <li>Tìm kiếm tour du lịch mà bạn muốn tham gia.</li>
                        <li>Chọn tour du lịch và điền thông tin đặt tour.</li>
                        <li>Xác nhận đặt tour và thực hiện thanh toán.</li>
                        <li>Chờ xác nhận từ chúng tôi và sẵn sàng tham gia tour!</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header" id="question2">
                <h5 class="mb-0">
                    <button class="btn btn-link" data-toggle="collapse" data-target="#answer2" aria-expanded="false" aria-controls="answer2">
                        Câu hỏi 2: Làm thế nào để thay đổi hoặc hủy đặt tour?
                    </button>
                </h5>
            </div>

            <div id="answer2" class="collapse" aria-labelledby="question2" data-parent="#questionAccordion">
                <div class="card-body">
                    Để thay đổi hoặc hủy đặt tour, bạn có thể liên hệ với chúng tôi qua số hotline hoặc email được cung cấp trên trang web của chúng tôi. Chúng tôi sẽ hỗ trợ bạn trong quá trình này và cung cấp thông tin về quy định về việc thay đổi hoặc hủy đặt tour.
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header" id="question3">
                <h5 class="mb-0">
                    <button class="btn btn-link" data-toggle="collapse" data-target="#answer3" aria-expanded="false" aria-controls="answer3">
                        Câu hỏi 3: Làm thế nào để tìm tour du lịch phù hợp với ngân sách của tôi?
                    </button>
                </h5>
            </div>

            <div id="answer3" class="collapse" aria-labelledby="question3" data-parent="#questionAccordion">
                <div class="card-body">
                    Để tìm tour du lịch phù hợp với ngân sách của bạn, bạn có thể sử dụng các tính năng tìm kiếm trên trang web của chúng tôi để lọc các tour theo khoảng giá. Bạn cũng có thể tham khảo các chương trình khuyến mãi hoặc tour giảm giá nếu có sẵn.
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header" id="question4">
                <h5 class="mb-0">
                    <button class="btn btn-link" data-toggle="collapse" data-target="#answer4" aria-expanded="false" aria-controls="answer4">
                        Câu hỏi 4: Có bất kỳ chi phí ẩn nào khi tham gia tour du lịch?
                    </button>
                </h5>
            </div>

            <div id="answer4" class="collapse" aria-labelledby="question4" data-parent="#questionAccordion">
                <div class="card-body">
                    Chúng tôi cam kết cung cấp thông tin rõ ràng về các chi phí liên quan đến tour du lịch. Trước khi đặt tour, bạn nên kiểm tra kỹ thông tin về giá tour và các dịch vụ bao gồm trong giá. Không có chi phí ẩn, và nếu có bất kỳ điều gì không rõ ràng, bạn có thể liên hệ với chúng tôi để được giải đáp.
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header" id="question5">
                <h5 class="mb-0">
                    <button class="btn btn-link" data-toggle="collapse" data-target="#answer5" aria-expanded="false" aria-controls="answer5">
                        Câu hỏi 5: Tôi cần mang theo những gì khi tham gia tour du lịch?
                    </button>
                </h5>
            </div>

            <div id="answer5" class="collapse" aria-labelledby="question5" data-parent="#questionAccordion">
                <div class="card-body">
                    Khi tham gia tour du lịch, bạn nên mang theo các tài liệu và vật phẩm quan trọng như:
                    <ul>
                        <li>Giấy tờ cá nhân (hộ chiếu, thẻ căn cước, …).</li>
                        <li>Vé máy bay hoặc vé tàu (nếu có).</li>
                        <li>Thẻ bảo hiểm du lịch.</li>
                        <li>Tiền mặt và thẻ tín dụng.</li>
                        <li>Điện thoại di động và sạc dự phòng.</li>
                    </ul>
                    Bạn cũng nên mang theo các vật dụng cá nhân như quần áo, giày dép, thuốc men (nếu cần), và máy ảnh để ghi lại những khoảnh khắc đáng nhớ trong chuyến du lịch.
                </div>
            </div>
        </div>
    </div>
</section>


<!-- Link tới Bootstrap JS và Popper.js -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

