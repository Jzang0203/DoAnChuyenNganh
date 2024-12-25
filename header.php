<?php session_start();  ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JzangSneaker Shop</title>
    <link rel="stylesheet" href="/Demo/css/style.css">
</head>
<body>
    <header>
        <h1>Jzang Sneaker</h1>
        <div class="search-container">
            <input type="text" id="search-bar" placeholder="Search...">
            <button id="search-button">Search</button>
            <button><a href="/cart.php"><img src="/Demo/img/Banner/shoppingcart.png" width="10" height="10"></a></button>
        </div>
        <nav class="headerNAV">
            <ul>
                <li><a href="/index.php">Home</a></li>
                <li>
                    <a href="#">Danh Mục Sản Phẩm</a>
                    <ul class="dropdown">
                        <li><a href="/Adidas.php">Adidas</a></li>
                        <li><a href="/Nike.php">Nike</a></li>
                        <li><a href="/Puma.php">Puma</a></li>
                    </ul>
                </li>
                <li><a href="/About.php">About</a></li>
                <li><a href="#" id="contact-link">Contact</a></li>
                <li><a href="/ThanhToan.php">Pay</a></li>

                <!-- Kiểm tra xem người dùng đã đăng nhập chưa -->
                <?php if (isset($_SESSION['ma_khachhang'])): ?>
                    <li><a href="/info_kh.php"><?php echo $_SESSION['ten_khachhang']; ?></a></li>
                    <li><a href="/logout.php">Đăng xuất</a></li>
                <?php else: ?>
                    <li><a href="/Login.php">Login</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
