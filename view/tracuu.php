<style>
    .manage-side {
        width: 90%;
        height: 200px;
        margin: 0 auto;
        position: relative;
        top: 40px;
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
    }

    .btn {
        width: 100%;
        height: 25%;
        border-radius: 10px;
        border: 1px solid var(--text-color-bold);
        display: flex;
        justify-content: space-around;
        flex-direction: column;
        align-items: center;
    }


    .btn a {
        text-decoration: none;
        color: var(--text-color-bold);
        font-weight: bold;
        font-size: 20px;
    }
</style>
<?php
session_start();


if (isset($_SESSION['id_nv'])) {
    ?> <button><a href="../controller/tiendien.php?act=quanly">Quay lại</a></button><br>
    <div class="manage-side">
        <button class="btn">

            <a href="../controller/tracuu.php?act=tracuukhachhang">Tra cứu khách hàng</a>
        </button>
        <button class="btn">
            <a href="../controller/tracuu.php?act=tracuudienke">Tra cứu điện kế</a>
        </button>

        <button class="btn">
            <a href="../controller/tracuu.php?act=tracuuhoadon">Tra cứu hóa đơn</a>
        </button>
        <button class="btn">
            <a href="../controller/tracuu.php?act=theodoino">Theo dõi nợ</a>
        </button>



    </div>











<?php } else {
    header('location: ../controller/nhanvien.php?act=login');
} ?>