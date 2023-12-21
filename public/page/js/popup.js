$(document).ready(function () {
    // Bắt sự kiện khi người dùng nhấp vào biểu tượng thông báo
    $(".notification-icon").click(function () {
        $("#notificationModal").modal("show"); // Hiển thị modal
    });
});