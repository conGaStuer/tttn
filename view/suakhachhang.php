<?php 
    session_start();

    if(isset($_SESSION['id_nv'])){
?>
<?php
// Include các file cần thiết
require_once "../model/KhachHang_Model.php";
require_once('../model/config.php');

// Kiểm tra nếu có mã khách hàng được truyền từ trang quản lý khách hàng
if (isset($_GET['makh'])) {
    // Lấy mã khách hàng từ URL
    $makh = $_GET['makh'];
    
    // Tạo đối tượng KhachHang_Model
    $khachhangModel = new KhachHang_Model();
    
    // Lấy thông tin khách hàng từ CSDL
    $khachhang = $khachhangModel->getKhachHangByMaKH($makh);
    
    // Kiểm tra nếu khách hàng tồn tại
    if ($khachhang) {
        // Gán các giá trị vào biến
        $tenkh = $khachhang['tenkh'];
        $diachi = $khachhang['diachi'];
        $dt = $khachhang['dt'];
        $cccd = $khachhang['cccd'];
    } else {
        // Hiển thị thông báo nếu không tìm thấy khách hàng
        echo "Không tìm thấy thông tin khách hàng.";
        exit();
    }
} else {
    // Hiển thị thông báo nếu không có mã khách hàng được truyền
    echo "Mã khách hàng không được cung cấp.";
    exit();
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Sửa thông tin khách hàng</title>
</head>
<body>
    <h1>Sửa thông tin khách hàng</h1>
    <form action="../controller/xuly_suaKH.php" method="post">
        <!-- Hiển thị mã khách hàng -->
        Mã KH: <?php echo $makh; ?><br>
        <!-- Sử dụng input hidden để truyền mã khách hàng -->
    
        <input type="hidden" name="makh" value="<?php echo $makh; ?>"><br>
        Tên KH: <input type="text" name="tenkh" value="<?php echo $tenkh; ?>"><br>
        Địa chỉ: <input type="text" name="diachi" value="<?php echo $diachi; ?>"><br>
        Điện thoại: <input type="text" name="dt" value="<?php echo $dt; ?>"><br>
        CCCD: <input type="text" name="cccd" value="<?php echo $cccd; ?>"><br>
        <input type="submit" value="Sửa">
    </form>
    <br>
    <a href="../controller/khachhang.php?act=quanlykhachhang">Quay lại</a>
</body>
</html>

<?php }else{
    header('location: ../controller/nhanvien.php?act=login');
} ?>