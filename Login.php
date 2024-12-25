<?php include 'header.php'; ?>
<link rel="stylesheet" href="/Demo/css/FormLogin.css">
<body>
    <main class="login-container">
        <div class="login-form">
            <h1>Thông tin đăng nhập</h1>
            <form method="POST" autocomplete="off">
                <div class="form-group">
                    <label for="ma_khachhang">Tài khoản:</label>
                    <input type="text" placeholder="Nhập mã khách hàng..." id="ma_khachhang" name="ma_khachhang" required>
                </div>

                <div class="form-group">
                    <label for="matkhau">Mật khẩu:</label>
                    <input type="password" placeholder="Nhập mật khẩu..." id="matkhau" name="matkhau" required>
                </div>

                <div class="button-group">
                    <button type="submit" name="login" class="btn-login">Đăng nhập</button>
                    <a href="/SignUp.php" class="btn-register">
                        <button type="button">Đăng ký</button>
                    </a>
                </div>
            </form>
        </div>
    </main>
    <?php include 'footer.php'; ?>

    <?php
    // Xử lý đăng nhập
    if (isset($_POST['login'])) {
        include 'connect.php'; // Kết nối với cơ sở dữ liệu
    
        // Lấy dữ liệu từ form
        $ma_khachhang = $_POST['ma_khachhang'];
        $password = $_POST['matkhau'];
    
        // Truy vấn cơ sở dữ liệu để kiểm tra thông tin đăng nhập
        $sql = "SELECT * FROM khachhang WHERE ma_khachhang = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $ma_khachhang); // "s" chỉ định tham số là chuỗi
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            // Đăng nhập thành công
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['matkhau'])) {
                // Nếu mật khẩu đúng
                $_SESSION['ma_khachhang'] = $user['ma_khachhang']; // Lưu mã khách hàng vào session
                $_SESSION['ten_khachhang'] = $user['ten_khachhang']; // Lưu tên khách hàng vào session
                echo "<script>alert('Đăng nhập thành công!'); window.location.href = '/index.php';</script>";
            } else {
                // Nếu mật khẩu không đúng
                echo "<script>alert('Thông tin đăng nhập không đúng. Vui lòng thử lại!');</script>";
            }
        } else {
            // Tài khoản không tồn tại
            echo "<script>alert('Tài khoản không tồn tại. Vui lòng thử lại!');</script>";
        }
    
        $stmt->close();
        $conn->close();
    }
    ?>
</body>
</html>
