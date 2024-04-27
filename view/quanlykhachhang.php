<?php
session_start();

if (isset($_SESSION['id_nv'])) {
    ?>
    <button><a href="../controller/tiendien.php?act=quanly">Quay lại</a></button>

    <div>
        <form action="../view/themkhachhang.php" method="post">
            <input type="submit" value="Thêm khách hàng">
        </form>
    </div>

    <h2>Tìm kiếm khách hàng</h2>
    <form id="searchForm">
        <div>
            <b>Tìm theo mã</b>
            <input name="searchKH" type="radio" value="0" onclick="chosseSearch_KH();" <?php if (!isset($search_KH_by_Name))
                echo "checked"; ?>>
        </div>
        <div>
            <b>Tìm theo tên</b>
            <input name="searchKH" type="radio" value="1" onclick="chosseSearch_KH();" <?php if (isset($search_KH_by_Name))
                echo "checked"; ?>>
        </div>

        <div id="search_By_ID" style="display: <?php if (!isset($search_KH_by_Name))
            echo "block";
        else
            echo "none"; ?>;">
            <input type="text" id="makh" name="makh" placeholder="Nhập mã khách hàng...">
        </div>
        <div id="search_By_Name" style="display: <?php if (isset($search_KH_by_Name))
            echo "block";
        else
            echo "none"; ?>;">
            <input type="text" id="nameKH" name="nameKH" placeholder="Nhập tên khách hàng...">
        </div>
    </form>
    <div id="searchResults"></div>

    <?php
    if (isset($khachhangs)) {
        $listsPerPage = isset($_GET['size']) ? (int) $_GET['size'] : 10;
        $currentPage = isset($_GET['p']) ? (int) $_GET['p'] : 1;
        $startIndex = ($currentPage - 1) * $listsPerPage; // tính sl kh ở mỗi trang và trang htai
        $filteredCustomers = array_filter($khachhangs, function ($khachhang) {
            return isset ($khachhang['makh']);
        });

        // xếp mảng giảm dần theo mã
        usort($filteredCustomers, function ($a, $b) {
            return $b['makh'] <=> $a['makh'];
        });

        // lấy sl dữ liệu của khách hàng
        $totalCustomers = count($filteredCustomers);
        // tính trang
        $totalPages = ceil($totalCustomers / $listsPerPage);
        // hiện dl cho trang hiện tại
        $listsToShow = array_slice($filteredCustomers, $startIndex, $listsPerPage);
        ?>

        <h1>Danh sách khách hàng</h1>
        <table border='1'>
            <tr>
                <th>Mã KH</th>
                <th>Tên KH</th>
                <th>Địa chỉ</th>
                <th>Điện thoại</th>
                <th>CCCD</th>
                <th colspan="2">Hành động</th>
            </tr>
            <?php foreach ($listsToShow as $khachhang): ?>
                <tr>
                    <td><?php echo $khachhang['makh']; ?></td>
                    <td><?php echo $khachhang['tenkh']; ?></td>
                    <td><?php echo $khachhang['diachi']; ?></td>
                    <td><?php echo $khachhang['dt']; ?></td>
                    <td><?php echo $khachhang['cccd']; ?></td>
                    <td>
                        <a href="../view/suakhachhang.php?makh=<?php echo $khachhang['makh']; ?>">Sửa</a>
                    </td>
                    <?php if (!checkXoaKH($khachhang['makh'])) { ?>
                        <td><a href="../controller/xuly_xoaKH.php?makh=<?php echo $khachhang['makh']; ?>"
                                onclick="return confirm('Bạn có chắc chắn muốn xóa khách hàng này không?')">Xóa</a></td>
                    <?php } else { ?>
                        <td>Không thể xóa khách hàng do đã tồn tại hóa đơn.</td>
                    <?php } ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
        <?php
    }
    // hiện các liên kết phân trang
    if ($totalPages > 1) {
        echo '<div></div>
                <div>';
        if ($currentPage > 1) {
            echo '<a href="?act=quanlykhachhang&p=' . ($currentPage - 1) . '&size=' . $listsPerPage . '">&lt;</a>';
        }
        // Tính & hiện các liên kết phân trang
        $start = max(1, $currentPage - 1);
        $end = min($totalPages, $start + 3);
        for ($i = $start; $i <= $end; $i++) {
            if ($i == $currentPage) {
                echo '<span >' . $i . '</span>';
            } else {
                echo '<a href="?act=quanlykhachhang&p=' . $i . '&size=' . $listsPerPage . '">' . $i . '</a>';
            }
        }
        if ($currentPage < $totalPages) {
            echo '<a href="?act=quanlykhachhang&p=' . ($currentPage + 1) . '&size=' . $listsPerPage . '">&gt;</a>';
        }
        echo '</div>';
    }

    ?>
    <script src="../assets/js/dienkekh.js"></script>
    <script src="../assets/js/timkhachhang.js"></script>
    <script src="../assets/js/autosubmitsearch.js"></script>
    <script>
        function showConfirmation() {
            if (confirm("Bạn có chắc chắn muốn xóa không?")) {
                // Nếu xác nhận, thay đổi giá trị action và submit form
                document.getElementById("deleteForm").action = "../controller/dienke.php?act=xoadienke";
                document.getElementById("deleteForm").submit();
            } else {

                event.preventDefault();
                return false;
            }
        }
    </script>
    <script>
        function addNewDienKe(makh) {
            localStorage.setItem('selectedMakh', makh);
            window.location.href = "../controller/dienke.php?act=themdienke";
        }
    </script>
<?php } else {
    header('location: ../controller/nhanvien.php?act=login');
} ?>