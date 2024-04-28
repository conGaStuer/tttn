<style>
    body {
        font-family: Arial, sans-serif;
    }

    form {
        width: 90%;
        padding: 20px;
        margin: 0 auto;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    label {
        color: #333;
        display: block;
        margin-bottom: 10px;
    }

    input[type="email"],
    input[type="password"],
    input[type="text"],
    input[type="number"],
    select {
        width: calc(100% - 10px);
        padding: 10px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-sizing: border-box;
    }

    input[type="submit"] {
        background-color: #333;
        color: white;
        padding: 14px 20px;
        margin: 8px 0;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    input[type="submit"]:hover {
        background-color: #45a049;
    }

    button a {
        text-decoration: none;
        color: #333;
    }

    button {
        background-color: #f0f0f0;
        border: none;
        color: #333;
        padding: 10px 20px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 4px 2px;
        cursor: pointer;
        border-radius: 4px;
        transition-duration: 0.4s;
    }

    button:hover {
        background-color: #ddd;
    }
</style>
<?php
session_start();

if (isset($_SESSION['id_nv'])) {
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
                if (makh.length > 15) {
                    alert("Độ dài của mã khách hàng vượt quá giới hạn cho phép.");
                    return false;
                }
                if (tenkh.length > 50) {
                    alert("Độ dài của tên khách hàng vượt quá giới hạn cho phép.");
                    return false;
                }
                if (diachi.length > 100) {
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
        <div class="content">

            <div class="manage">
                <h1>Thêm khách hàng</h1>
                <form name="addForm" action="../controller/xuly_themKH.php" method="post" onsubmit="return validateForm()">
                    <!-- Hiển thị mã mới trong trường nhập liệu -->
                    <?php
                    include_once ('../model/KhachHang.php');
                    include_once "../model/config.php";
                    $getid = getLastCustomerID();
                    if (isset($getid)) {
                        $id_kh = $getid['last_makh'];
                        $id_kh = intval($id_kh) + 1;
                        $id_kh_padded = str_pad($id_kh, 13, "0", STR_PAD_LEFT);
                        ?>
                        <input type="hidden" name="makh" value="<?php echo $id_kh_padded ?>">
                    <?php } else { ?>
                        <input type="hidden" name="makh" value="0000000000001">
                    <?php } ?>
                    <div>
                        <span>
                            Tên KH:
                        </span> <input type="text" name="tenkh">
                    </div>
                    <div><span>Địa chỉ: </span> <input type="text" name="diachi"></div>
                    <div><span> Điện thoại: </span><input type="text" name="dt"></div>
                    <div> <span>CCCD: </span><input type="text" name="cccd"></div>
                    <input type="submit" value="Thêm">




                </form>
                <br>
                <br>
                <button> <a href="../controller/khachhang.php?act=quanlykhachhang">Quay lại</a></button>
            </div>
    </body>

    </html>

<?php } else {
    header('location: ../controller/nhanvien.php?act=login');
} ?>