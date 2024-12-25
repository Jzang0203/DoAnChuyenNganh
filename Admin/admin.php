<?php include '../header.php'; ?>
<?php include '../connect.php'; ?>

<main>
    <hr>
    <br><br>
    <h2 style="font-size: 36px; text-align: center;">Quản lý sản phẩm</h2> <!-- Tăng kích thước chữ -->
    <div class="manage-options">
        <ul style="list-style-type: none; padding: 0; text-align: center;"> <!-- Bỏ dấu chấm ở đầu các mục -->
            <li><a href="./AddProduct.php" style="color: black; font-size: 18px; text-decoration: none;">Thêm Sản Phẩm</a></li>
            <li><a href="product_edit.php" style="color: black; font-size: 18px; text-decoration: none;">Sửa Sản Phẩm</a></li>
            <li><a href="product_delete.php" style="color: black; font-size: 18px; text-decoration: none;">Xóa Sản Phẩm</a></li>
        </ul>
    </div>

    <hr>

    <?php
    // Lấy tất cả sản phẩm một lần
    $sql = "SELECT * FROM sanpham";
    $result = $conn->query($sql);

    // Lưu tất cả sản phẩm vào mảng
    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }

    // Kiểm tra và hiển thị sản phẩm theo nhóm
    $brands = ['Adidas', 'Puma', 'Nike', 'CatSneaker'];
    foreach ($brands as $brand) {
        echo "<h2>$brand</h2>";
        echo "<div class='product'>";
        echo "<button class='slider-btn left' onclick=\"moveSlider('$brand', -1)\">&#10094;</button>";
        echo "<div class='product-slider' id='slider-$brand'>"; // Slider sản phẩm
        foreach ($products as $row) {
            if (strpos($row['ten_sanpham'], $brand) !== false) {
                echo "<div class='sp'>";
                echo "<a href='CTSP.php?id=" . htmlspecialchars($row['ma_sanpham']) . "'>";
                echo "<img src='/Demo/img/" . htmlspecialchars($row['hinh_anh']) . "' alt='" . htmlspecialchars($row['ten_sanpham']) . "'>";
                echo "</a>";
                echo "<p>" . htmlspecialchars($row['ten_sanpham']) . "</p>";
                echo "<p>Giá: \$" . number_format($row['gia'], 2) . "</p>";
                echo '<button class="btn" onclick="addToCart(\'' . addslashes($row['ma_sanpham']) . '\', \'' . addslashes($row['ten_sanpham']) . '\', ' . $row['gia'] . ')">Thêm vào giỏ hàng</button>';
                echo "</div>";
            }
        }
        echo "</div><br>";
        echo "<button class='slider-btn right' onclick=\"moveSlider('$brand', 1)\">&#10095;</button>"; 
        echo "</div><br>";
    }
    ?>

    <div class="global-icon-right-zalo">
        <a href="https://zalo.me/0388073445" target="_blank">
            <img src="https://www.tncstore.vn/static/assets/default/images/icon_zalo_2023.png" width="50px" height="50px" alt="icon-zalo">
        </a>
    </div>
    <div class="global-icon-right-facebook">
        <a href="https://www.facebook.com/puma.vietnam.official/?brand_redir=56470448215&locale=vi_VN" target="_blank">
            <img src="https://upload.wikimedia.org/wikipedia/commons/b/b9/2023_Facebook_icon.svg" width="50px" height="50px" alt="icon-zalo">
        </a>
    </div>
</main>

<script>
    const sliderState = {};
    function moveSlider(brand, direction) {
        const slider = document.getElementById(`slider-${brand}`);
        const products = slider.querySelectorAll('.sp');
        const productWidth = products[0].getBoundingClientRect().width + 15; // Kích thước thực tế của sản phẩm
        const visibleWidth = slider.offsetWidth; // Chiều rộng hiển thị của slider
        const totalWidth = products.length * productWidth; // Tổng chiều rộng của tất cả sản phẩm

        // Đảm bảo trạng thái cuộn cho slider
        if (!sliderState[brand]) sliderState[brand] = 0;

        // Tính toán vị trí mới
        sliderState[brand] += direction * productWidth;
        sliderState[brand] = Math.max(0, Math.min(sliderState[brand], totalWidth - visibleWidth)); // Giới hạn trong khoảng hợp lệ

        // Cập nhật vị trí bằng transform
        slider.style.transform = `translateX(-${sliderState[brand]}px)`;
    }
</script>

<?php include '../footer.php'; ?>
</body>
</html>
