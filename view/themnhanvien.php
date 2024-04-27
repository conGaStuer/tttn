<h2>Thêm tài khoản nhân viên </h2>
<form method="post" action="">

    <label for="taikhoan">Tài khoản:</label>
    <input type="email" id="taikhoan" name="taikhoan" required><br>

    <label for="matkhau">Mật khẩu:</label>
    <input type="password" id="matkhau" name="matkhau" required><br>

    <label for="tennv">Tên nhân viên:</label>
    <input type="text" id="tennv" name="tennv" required><br>

    <label for="diachi">Địa chỉ:</label>
    <input type="text" id="diachi" name="diachi"><br>

    <label for="dt">Điện thoại:</label>
    <input type="text" id="dt" name="dt"><br>

    <label for="cccd">CCCD:</label>
    <input type="text" id="cccd" name="cccd"><br>

    <label for="quyen">Quyền:</label>
    <select id="quyen" name="quyen">
        <option value="0">Nhân viên</option>
        <option value="1">Quản lý</option>
    </select><br>

    <input type="submit" name="themNhanVien" value="Thêm nhân viên">
</form>

<button><a href="../controller/nhanvien.php?act=quanlynhanvien">Quay lại</a></button>

