<?php 
    session_start();

    if(isset($_SESSION['id_nv'])){
?>
<!DOCTYPE html>
<html>
<head>
    <title>Thêm khách hàng</title>
    <script>
        function validateForm() {
            var makh = document.forms["addForm"]["makh"].value;
            var tenkh = document.forms["addForm"]["tenkh"].value;
            var diachi = document.forms["addForm"]["diachi"].value;
            var dt = document.forms["addForm"]["dt"].value;
            var cccd = document.forms["addForm"]["cccd"].value;

            // Kiểm tra makh có đủ 13 ký tự không
            if (makh.length != 13) {
                alert("Mã khách hàng phải có đủ 13 số.");
                return false;
            }

            if (tenkh == "" || diachi == "" || dt == "" || cccd == "") {
                alert("Vui lòng nhập đầy đủ thông tin.");
                return false;
            }
            if(makh.length > 15){
                alert("Độ dài của mã khách hàng vượt quá giới hạn cho phép.");
                return false;
            }
            if(tenkh.length > 50){
                alert("Độ dài của tên khách hàng vượt quá giới hạn cho phép.");
                return false;
            }
            if(diachi.length >100){
                alert("Độ dài của địa chỉ vượt quá giới hạn cho phép.");
                return false;
            }
            if (isNaN(dt)) {
                alert("Số điện thoại không hợp lệ.");
                return false;
            }

            if (isNaN(cccd) || cccd.length != 12) {
                alert("CCCD không hợp lệ.");
                return false;
            }

            return true;
        }
    </script>
</head>
<body>
<h1>Thêm khách hàng</h1>
    <form name="addForm" action="../controller/xuly_themKH.php" method="post" onsubmit="return validateForm()">
        <!-- Hiển thị mã mới trong trường nhập liệu -->
        <?php 
            include_once('../model/KhachHang.php');
            include_once "../model/config.php"; 
            $getid=getLastCustomerID();
            if(isset($getid)){
                $id_kh = $getid['last_makh'];
                $id_kh = intval($id_kh) + 1;
                $id_kh_padded = str_pad($id_kh, 13, "0", STR_PAD_LEFT);
        ?>
        <input type="hidden" name="makh" value="<?php echo $id_kh_padded ?>">
        <?php }else{ ?>
        <input type="hidden" name="makh" value="0000000000001">
        <?php } ?>
        Tên KH: <input type="text" name="tenkh"><br>
        Địa chỉ: <input type="text" name="diachi"><br>
        Điện thoại: <input type="text" name="dt"><br>
        CCCD: <input type="text" name="cccd"><br>
        <input type="submit" value="Thêm">
    </form>
    <br>
    <br>
    <a href="../controller/khachhang.php?act=quanlykhachhang">Quay lại</a>
    
</body>
</html>

<?php }else{
    header('location: ../controller/nhanvien.php?act=login');
} ?>