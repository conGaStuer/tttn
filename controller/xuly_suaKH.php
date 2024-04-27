<?php
// Include các file cần thiết
require_once "../model/KhachHang_Model.php";
require_once('../model/config.php');

// Kiểm tra nếu form đã được submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form
    $makh = $_POST['makh'];
    $tenkh = $_POST['tenkh'];
    $diachi = $_POST['diachi'];
    $dt = $_POST['dt'];
    $cccd = $_POST['cccd'];
    
    // Tạo đối tượng KhachHang_Model
    $khachhangModel = new KhachHang_Model();

    // Thực hiện cập nhật thông tin khách hàng trong CSDL
    $result = $khachhangModel->updateKhachHang($makh, $tenkh, $diachi, $dt, $cccd);

    // Kiểm tra kết quả cập nhật
    if ($result) {
        session_start();
        
        echo "<script>alert('Sửa khách hàng có mã : $makh thành công!');window.location.href = '../controller/khachhang.php';</script>";  
    } else {
        echo "Cập nhật thông tin khách hàng không thành công.";
    }
} else {
    // Hiển thị thông báo nếu không có dữ liệu được gửi từ form
    echo "Dữ liệu không được gửi từ form.";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Thông báo</title>
</head>
<body>
    <br>
    <a href="<?php echo htmlspecialchars($_SERVER['HTTP_REFERER']); ?>">Quay lại</a>
</body>
</html>
