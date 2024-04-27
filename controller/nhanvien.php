<?php
    include_once "../model/config.php"; 
    include_once "../model/DienKeKhachHang.php"; 
    include_once "../model/GiaDien.php"; 
    include_once "../model/HoaDon.php"; 
    include_once "../model/CTHoaDon.php"; 
    include_once "../model/TinhTien.php"; 
    include_once "../model/NhanVien.php"; 

    if (isset($_GET['act'])) {  
        switch ($_GET['act']) {
            case "login":
                session_start();
                if(isset($_POST['dangnhap'])){
                    $username = $_POST['username'];
                    $password = md5($_POST['password']);
                    $userLogin = checkAcccount($username,$password);
                    if (!empty($username) && !empty($password)) {
                        if ($userLogin && !empty($userLogin)) {
                            foreach ($userLogin as $row) {
                                extract($row);
                                $_SESSION['name'] = $tennv;
                                $_SESSION['username'] = $taikhoan;
                                $_SESSION['id_nv'] = $manv;
                                $_SESSION['password'] = $matkhau;
                                $_SESSION['quyen'] =  $quyen;
                            }
                            header("Location: ../controller/tiendien.php?act=quanly");
                            exit;
                        } else {
                            echo "<script>alert('Sai tên đăng nhập hoặc mật khẩu.')</script>";
                        }
                    } else {
                        echo "<script>alert('Vui lòng nhập đầy đủ thông tin')</script>";
                    }
                }
                include '../view/login.php';
                break;
            case "quanlynhanvien":
                session_start();

                $show_All_NV = show_All_NhanVien();

                if(isset($_SESSION['id_nv'])){
                    $usser_login = $_SESSION['id_nv'];
                    $checkinfouser=check_Info_ById($usser_login);
                }else{
                    echo '<br>ERROR<br>';
                }

                if(isset($_POST['changePass'])){
                    $oldpass = md5($_POST['oldPassword']);
                    $newpass = md5($_POST['newPassword']);
                    $tk = $_POST['taikhoan'];
                
                    if($tk == $_SESSION['username']){
                        if($checkinfouser['matkhau'] != $oldpass){
                            echo "<script>alert('Thông tin mật khẩu cũ không chính xác')</script>";
                        } else {
                            updateInfo_NV($newpass, $tk, $oldpass);
                            echo "<script>alert('Thay đổi mật khẩu thành công'); window.location.href = '../controller/nhanvien.php?act=quanlynhanvien';</script></script>";
                        }
                    } else {
                        echo "<script>alert('Tài khoản không hợp lệ')</script>";
                    }
                }
                
                include "../view/quanlynhanvien.php";
                break;
            case "suanhanvien":
                session_start();
                if(isset($_POST['edituser'])){
                    $mauser= $_POST['iduser'];
                    $showin4= check_Info_ById($mauser);
                }
                if(isset($_POST['suaNhanVien'])){
                    $error_messages = array();
                    $manv = $_POST['manv'];
                    $name = $_POST['tennv'];
                    $dc = $_POST['diachi'];
                    $dt = $_POST['dt'];
                    $cccd = $_POST['cccd'];
                    if(isset($_POST['quyen'])){
                        $quyen= $_POST['quyen'];
                        if($quyen == -1){
                            $quyen=1;
                        }elseif($quyen == 0 ){
                            $quyen = 0;
                        }elseif($quyen == 1){
                            $quyen = 1;
                        }
                    }
                    if(!isset($_POST['quyen'])){
                        $quyen = 0;
                    }
                    
                    if(!kiem_tra_so_dien_thoai_user($dt)){
                        $error_messages[] = "Số điện thoại tối ta 10 số và phải thuộc đầu số các nhà mạng.";
                    }
                    if(strlen($name) > 50){
                        $error_messages[] = "Độ lớn của tên vượt quá giới hạn cho phép[Tối đa 50].";
                    }
                    if(!is_numeric($cccd) || strlen($cccd) > 12){
                        $error_messages[] = "Căn cước công dân vui lòng nhập số và tối đa 12 số.";  
                    }
                    if(strlen($cccd) != 12){
                        $error_messages[] = "Căn cước công dân nhập đủ 12 số";  
                    }
                    if(strlen($dc) > 100){
                        $error_messages[] = "Độ lớn của địa chỉ vượt quá giới hạn cho phép[Tối đa 100].";
                    }
                    
                    if($quyen != 1 && $quyen != 0){
                        $error_messages[] = "Quyền account không hợp lệ.";
                    }
                    if($name == '' || $dc == '' || $dt == '' || $cccd == '' || $quyen == ''){
                        $error_messages[] = "Các thông tin không được rỗng.";
                    }
                    if (empty($error_messages)) {
                        suaNhanVien($name, $dc, $dt, $cccd, $quyen, $manv);
                        $_SESSION['success_messager'] = "Sửa thành công";
                        echo "<script>window.location.href = '../controller/nhanvien.php?act=quanlynhanvien';</script>";   
                    } 
                //lưu các lỗi check đc vào session
                $_SESSION['error_messages'] = $error_messages;
                
                if(isset($_SESSION['error_messages']) && !empty($_SESSION['error_messages'])) {
                    echo '<p style="color: red; font-weight: bold;">';
                    foreach($_SESSION['error_messages'] as $error_message) {
                        echo $error_message . '<br>';
                    }
                    echo '</p>';
                    unset($_SESSION['error_messages']);
                }
                if(isset($_SESSION['success_messager']) && !empty($_SESSION['success_messager'])){
                    echo '<div style="color: green; font-weight: bold;">';
                    echo $_SESSION['success_messager'] . '<br>';
                    echo '</div>';
                    unset($_SESSION['success_messager']);
                }

                }
                include "../view/suanhanvien.php";
                break;
            case "themnhanvien":
                session_start();
                if(isset($_POST['themNhanVien'])){
                    $tenlogin = $_POST['taikhoan'];
                    $password = md5($_POST['matkhau']);
                    $name = $_POST['tennv'];
                    $dc = $_POST['diachi'];
                    $dt = $_POST['dt'];
                    $cccd = $_POST['cccd'];
                    $quyen=$_POST['quyen'];

                    $check_trung_taikhoan = checktrungtenuser($tenlogin);
                    $error_messages = array();

                    // Kiểm tra xem $tenlogin có đúng định dạng email với tên miền là "@gmail.com" hay không
                    if (!filter_var($tenlogin, FILTER_VALIDATE_EMAIL) || !strpos($tenlogin, '@gmail.com')) {
                        $error_messages[] = "Tên đăng nhập phải là địa chỉ email có tên miền @gmail.com";
                    }
                    if(!kiem_tra_so_dien_thoai_user($dt)){
                        $error_messages[] = "Số điện thoại tối ta 10 số và phải thuộc đầu số các nhà mạng.";
                    }
                    if($check_trung_taikhoan){
                        $error_messages[] = "Thông tin tài khoản đã tồn tại.";
                    }
                    if(strlen($name) > 50){
                        $error_messages[] = "Độ lớn của tên vượt quá giới hạn cho phép[Tối đa 50].";
                    }
                    if(!is_numeric($cccd) || strlen($cccd) > 12){
                        $error_messages[] = "Căn cước công dân vui lòng nhập số và tối đa 12 số.";  
                    }
                    if(strlen($cccd) != 12){
                        $error_messages[] = "Căn cước công dân nhập đủ 12 số";  
                    }
                    if(strlen($dc) > 100){
                        $error_messages[] = "Độ lớn của địa chỉ vượt quá giới hạn cho phép[Tối đa 100].";
                    }
                    if(strlen($tenlogin) > 255){
                        $error_messages[] = "Độ lớn của tài khoản vượt quá giới hạn cho phép[Tối đa 255].";
                    }
                    if(strlen($password) > 255){
                        $error_messages[] = "Độ lớn của mật khẩu vượt quá giới hạn cho phép[Tối đa 255].";
                    }
                    if($quyen != 1 && $quyen != 0){
                        $error_messages[] = "Quyền account không hợp lệ.";
                    }
                    if($tenlogin == '' || $password == '' || $name == '' || $dc == '' || $dt == '' || $cccd == '' || $quyen == ''){
                        $error_messages[] = "Các thông tin không được rỗng.";
                    }                    

                    if (empty($error_messages)) {
                            themNhanVien($tenlogin, $password, $name, $dc, $dt, $cccd, $quyen);
                            $_SESSION['success_messager'] = "Thêm thành công";   
                        } 
                    //lưu các lỗi check đc vào session
                    $_SESSION['error_messages'] = $error_messages;
                    
                    if(isset($_SESSION['error_messages']) && !empty($_SESSION['error_messages'])) {
                        echo '<p style="color: red; font-weight: bold;">';
                        foreach($_SESSION['error_messages'] as $error_message) {
                            echo $error_message . '<br>';
                        }
                        echo '</p>';
                        unset($_SESSION['error_messages']);
                    }
                    if(isset($_SESSION['success_messager']) && !empty($_SESSION['success_messager'])){
                        echo '<div style="color: green; font-weight: bold;">';
                        echo $_SESSION['success_messager'] . '<br>';
                        echo '</div>';
                        unset($_SESSION['success_messager']);
                    }
                }
                include "../view/themnhanvien.php";
                break;
            case "xoanhanvien":
                if(isset($_POST['xoaNhanVien'])){
                    $manv = $_POST['iduser'];
                    $checkxoa = kiemTraTruocXoa($manv);
                    if(!$checkxoa){
                        deleteNhanVien($manv);
                        echo "<script>alert('Đã xóa nhân viên này');window.location.href = '../controller/nhanvien.php?act=quanlynhanvien';</script>";  
                    }else{
                        echo "<script>alert('Không thể nhân viên này do đã tồn tại trong hóa đơn!');window.location.href = '../controller/nhanvien.php?act=quanlynhanvien';</script>";  
                    }
                }
                break;
            case 'logout':
                include "../view/logout.php";
                break;
            default:
            include "../view/login.php";
            break;
        }
    } else { 
        include "../view/login.php";
    }
?>