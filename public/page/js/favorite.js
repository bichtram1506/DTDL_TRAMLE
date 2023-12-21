// Xử lý sự kiện khi người dùng nhấn nút "Yêu thích"
$('#favorite-button').click(function(event) {
  event.preventDefault(); // Ngăn chặn hành vi mặc định của form submit

  // Gửi yêu cầu AJAX và xử lý phản hồi
  $.ajax({
      url: '/favorite/toggle', // Điều hướng đến action xử lý yêu thích
      type: 'POST',
      data: { tour_id: tourId }, // Dữ liệu bạn muốn gửi (ví dụ: ID của tour)
      success: function(response) {
          // Hiển thị thông báo cho người dùng dựa trên response.message
          alert(response.message);
          // Hoặc có thể làm gì đó khác để thông báo cho người dùng
      },
      error: function(error) {
          // Xử lý lỗi nếu cần
      }
  });
});


//////////////////đánh giá

const stars = document.querySelectorAll('.star');
const ratingInput = document.querySelector('#rating-input');
const ratingText = document.querySelector('#rating-text');
let ratingValue = 0;

stars.forEach((star, index) => {
    star.addEventListener('click', () => {
        ratingValue = star.dataset.value;
        ratingInput.value = ratingValue;
        ratingText.textContent = `Đánh giá ${ratingValue} sao`;
        // Thêm class 'selected' cho các sao được chọn
        stars.forEach((s, i) => {
            if (i <= index) {
                s.classList.add('selected');
            } else {
                s.classList.remove('selected');
            }
        });
    });
});

/////// 
$(document).ready(function() {
    // Ẩn tất cả các phần tử nội dung
    $(".tab-pane").hide();

    // Hiển thị phần tử đầu tiên
    $(".tab-pane:first").show();

    // Xử lý sự kiện khi nhấp vào các mục điểm nhấn
    $(".nav-link").click(function() {
        // Ẩn tất cả các phần tử nội dung
        $(".tab-pane").hide();

        // Lấy id của phần tử cần hiển thị
        var targetId = $(this).attr("href");

        // Hiển thị phần tử có id tương ứng
        $(targetId).show();
    });
});
///

///
var currentImageIndex = 0;
var thumbnailImages = document.querySelectorAll('.thumbnail-img');
var largeImage = document.querySelector('.large-image');
var thumbnailWrapper = document.querySelector('.thumbnail-wrapper');

function changeImage(direction) {
  currentImageIndex += direction;
  if (currentImageIndex < 0) {
      currentImageIndex = thumbnailImages.length - 1;
  } else if (currentImageIndex >= thumbnailImages.length) {
      currentImageIndex = 0;
  }
  largeImage.src = thumbnailImages[currentImageIndex].src;

  // Loại bỏ class 'active' từ tất cả các ảnh nhỏ khác
  thumbnailImages.forEach(img => {
      img.classList.remove('active');
  });

  // Thêm class 'active' cho ảnh mới được hiển thị
  thumbnailImages[currentImageIndex].classList.add('active');

  // Cuộn tự động để đẩy ảnh mới lên trên cùng dần dần
  scrollToThumbnail(thumbnailImages[currentImageIndex]);
}


function showLargeImage(clickedImage) {
  currentImageIndex = Array.from(thumbnailImages).indexOf(clickedImage);
  largeImage.src = clickedImage.src;

  // Loại bỏ class 'active' từ tất cả các ảnh nhỏ khác
  thumbnailImages.forEach(img => {
      img.classList.remove('active');
  });

  // Thêm class 'active' cho ảnh được chọn
  clickedImage.classList.add('active');

  // Cuộn tự động để đẩy ảnh lên trên cùng nếu cần
  scrollToThumbnail(clickedImage);
}



function scrollToThumbnail(thumbnail) {
    var thumbnailRect = thumbnail.getBoundingClientRect();
    var wrapperRect = thumbnailWrapper.getBoundingClientRect();

    // Kiểm tra xem ảnh nhỏ có bị che mất bởi phần cuối của danh sách không
    if (thumbnailRect.bottom > wrapperRect.bottom) {
        thumbnail.scrollIntoView({ behavior: 'smooth', block: 'end' });
    } else if (thumbnailRect.top < wrapperRect.top) {
        thumbnail.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
}


function changeImage(direction) {
    currentImageIndex += direction;
    if (currentImageIndex < 0) {
        currentImageIndex = thumbnailImages.length - 1;
    } else if (currentImageIndex >= thumbnailImages.length) {
        currentImageIndex = 0;
    }
    largeImage.src = thumbnailImages[currentImageIndex].src;

    // Loại bỏ class 'active' từ tất cả các ảnh nhỏ khác
    thumbnailImages.forEach(img => {
      img.classList.remove('active');
    });

    // Thêm class 'active' cho ảnh mới được hiển thị
    thumbnailImages[currentImageIndex].classList.add('active');
}
