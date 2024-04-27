<button><a href="../controller/nhanvien.php?act=quanlynhanvien">Quay lại</a></button>

<?php 
    if(isset($showin4) && !empty($showin4)){
?>
<h2>Sửa thông tin </h2>
<form method="post" action="">
    <input type="hidden" id="manv" name="manv" value="<?php echo $showin4['manv'] ?>" required>

    <label for="tennv">Tên nhân viên:</label>
    <input type="text" id="tennv" name="tennv" value="<?php echo $showin4['tennv'] ?>"required><br>

    <label for="diachi">Địa chỉ:</label>
    <input type="text" id="diachi" name="diachi" value="<?php echo $showin4['diachi'] ?>"><br>

    <label for="dt">Điện thoại:</label>
    <input type="text" id="dt" name="dt" value="<?php echo $showin4['dt'] ?>"><br>

    <label for="cccd">CCCD:</label>
    <input type="text" id="cccd" name="cccd" value="<?php echo $showin4['cccd'] ?>"><br>
    
    <label for="quyen">Quyền:</label>
    
    <?php 
        if(isset($_SESSION['quyen']) && $_SESSION['quyen'] == 1){
    ?>
    <?php
        if($showin4['quyen'] == 0){
            echo '
            <select id="quyen" name="quyen">
            <option value="0">Nhân viên</option>
            <option value="1">Quản lý</option>
            </select><br>

            ';
        }else{
            echo '
            <input type="hidden" name="quyen" value="-1">
            Không thể sửa quyền người này do đang là quản lý, muốn chỉnh sửa vui lòng liên hệ QTV.<br>
            ';
        }
    
    }
    ?>    

    <input type="submit" name="suaNhanVien" value="Sửa thông tin">
</form>
<?php } ?>