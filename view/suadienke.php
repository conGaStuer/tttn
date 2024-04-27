<?php 
    session_start();

    if(isset($_SESSION['id_nv'])){
?>
<?php 
    if(isset($showDataDienke) && !empty($showDataDienke)){
?>
<button onclick="goBack()">Quay lại trang trước</button>

<h2> Sửa thông tin điện kế:
<br>
- Khách hàng có mã: <?php echo $show_makh ?>
<br>
- Điện kế có mã: <?php echo $show_madk ?></h2>
<form method="post" action="">
    <input type="hidden" name="madk" id="madk" value="<?php echo $show_madk ?>" readonly> <br>
    
    <label for="ngaysx">Ngày sản xuất:</label>
    <input type="datetime-local" name="ngaysx" id="ngaysx" value="<?php echo $show_ngaysx ?>" required><br><br>

    <label for="ngaylap">Ngày lắp:</label>
    <input type="datetime-local" name="ngaylap" id="ngaylap" value="<?php echo $show_ngaylap ?>" required><br><br>

    <label for="mota">Mô tả:</label>
    <textarea name="mota" id="mota" rows="4" cols="50" required><?php echo $show_mota_dk ?></textarea><br><br>


    <label for="trangthai">Trạng thái:</label>
    <select name="trangthai" id="trangthai" required>
    <?php if($show_trangthai == 1){?>
        <option value="1">Còn sử dụng</option>
        <option value="0">Ngừng sử dụng</option>
    <?php }else{ ?>
        <option value="0">Ngừng sử dụng</option>
        <option value="1">Còn sử dụng</option>
    <?php } ?>
    </select><br><br>

    <input type="submit" name="suaDienKe" value="Sửa">
</form>
<?php } ?>

<script>
    function goBack() {
        window.history.back();
    }
</script>

<?php }else{
    header('location: ../controller/nhanvien.php?act=login');
} ?>