<?php 
    if(isset($_SESSION['id_nv'])){
?>
<form method="post" action="">
    <h2>Thêm điện kế cho khách hàng mã: <span id="makhhtml"></span></h2>
    <input type="hidden" name="makh" id="makh" readonly>
    <label for="madk">Mã điện kế:</label>
    <?php if(isset($last_madk)){
        $id_dk = $last_madk['max_madk'];
        $id_dk = intval($id_dk) + 1;
        $id_dk_padded = str_pad($id_dk, 8, "0", STR_PAD_LEFT);
        echo '<input type="text" name="madk" id="madk" value="' . $id_dk_padded . '" required> <br>
        ';
    }else{ ?>
    <input type="text" name="madk" id="madk" required> <br>
    <?php } ?>
    
    <label for="ngaysx">Ngày sản xuất:</label>
    <input type="datetime-local" name="ngaysx" id="ngaysx" required><br><br>

    <label for="ngaylap">Ngày lắp:</label>
    <input type="datetime-local" name="ngaylap" id="ngaylap" required><br><br>

    <label for="mota">Mô tả:</label>
    <textarea name="mota" id="mota" rows="4" cols="50" required></textarea><br><br>

    <label for="trangthai">Trạng thái:</label>
    <select name="trangthai" id="trangthai" required>
        <option value="1">Sử dụng</option>
        <option value="0">Chưa sử dụng</option>
    </select><br><br>

    <input type="submit" name="addDienke" value="Thêm điện kế">
</form>
<button onclick="goBack()">Quay lại trang trước</button>
<script>
    function goBack() {
        window.history.back();
    }
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var selectedMakh = localStorage.getItem('selectedMakh');
    if (selectedMakh) {
        document.getElementById('makh').value = selectedMakh;
        document.getElementById('makhhtml').innerText = selectedMakh;
    } else {
        alert('Thông tin không hợp lệ. Vui lòng thử lại.');
    }
});
</script>

<?php }else{
    header('location: ../controller/nhanvien.php?act=login');
} ?>