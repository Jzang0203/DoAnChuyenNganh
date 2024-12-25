<?php
// Kết nối cơ sở dữ liệu
include '../connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Nhận thông tin từ biểu mẫu
    $ten_sanpham = $_POST['ten_sanpham'];
    $gia = $_POST['gia'];
    $ma_loaisanpham = $_POST['ma_loaisanpham'];
    $mau = $_POST['mau'];
    $size = $_POST['size'];
    $mo_ta = $_POST['mo_ta'];

    $sql_loai = "SELECT ten_loaisanpham FROM loaisanpham WHERE ma_loaisanpham = $ma_loaisanpham";
    $result_loai = $conn->query($sql_loai);
    $row_loai = $result_loai->fetch_assoc();
    $ten_loaisanpham = $row_loai['ten_loaisanpham'];


    $target_dir = $ten_loaisanpham . "/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $hinh_anh = basename($_FILES["hinh_anh"]["name"]);
    $target_file = $target_dir . $hinh_anh;

    if (!move_uploaded_file($_FILES["hinh_anh"]["tmp_name"], $target_file)) {
        die("Lỗi khi tải lên ảnh.");
    }

    $image_path = $target_dir . $hinh_anh; 

    $sql = "INSERT INTO sanpham (ten_sanpham, gia, hinh_anh, ma_loaisanpham) 
            VALUES ('$ten_sanpham', $gia, '$image_path', $ma_loaisanpham)";
    $conn->query($sql);

    $ma_sanpham = $conn->insert_id;

    foreach ($mau as $m) {
        $sql = "INSERT INTO mausanpham (ma_sanpham, ten_mau) VALUES ($ma_sanpham, '$m')";
        $conn->query($sql);
    }

    foreach ($size as $s) {
        $sql = "INSERT INTO size (ma_sanpham, ten_size) VALUES ($ma_sanpham, '$s')";
        $conn->query($sql);
    }

    echo "Thêm sản phẩm thành công! Ảnh đã được lưu vào: $target_file";
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm sản phẩm</title>
    <link rel="stylesheet" href="/Demo/css/qtv.css">
</head>
<body>
    <div class="container">  
        <h1>Thêm sản phẩm mới</h1>
        <form method="POST" enctype="multipart/form-data">
            <label for="ten_sanpham">Tên sản phẩm:</label>
            <input type="text" name="ten_sanpham" id="ten_sanpham" required><br>

            <label for="gia">Giá:</label>
            <input type="number" name="gia" id="gia" required><br>

            <label for="hinh_anh">Hình ảnh:</label>
            <input type="file" name="hinh_anh" id="hinh_anh" required><br>

            <label for="ma_loaisanpham">Loại sản phẩm:</label>
            <select name="ma_loaisanpham" id="ma_loaisanpham">
                <?php
                $sql = "SELECT * FROM loaisanpham";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['ma_loaisanpham'] . "'>" . htmlspecialchars($row['ten_loaisanpham']) . "</option>";
                }
                ?>
            </select><br>

            <label for="mau">Màu sắc (Chọn nhiều):</label>
            <select name="mau[]" id="mau" multiple>
                <?php
                $sql = "SELECT DISTINCT ten_mau FROM mausanpham";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['ten_mau'] . "'>" . htmlspecialchars($row['ten_mau']) . "</option>";
                }
                ?>
            </select><br>

            <label for="size">Kích thước (Chọn nhiều):</label>
            <select name="size[]" id="size" multiple>
                <?php
                $sql = "SELECT DISTINCT ten_size FROM size";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['ten_size'] . "'>" . htmlspecialchars($row['ten_size']) . "</option>";
                }
                ?>
            </select><br>

            <label for="mo_ta">Mô tả sản phẩm:</label><br>
            <textarea name="mo_ta" id="mo_ta" rows="4" cols="50" required></textarea><br>

            <button type="submit">Thêm sản phẩm</button>
            <a href="admin.php">
                <button type="button" class="back-button">Quay lại</button>
            </a>
        </form>
    </div>
</body>
</html>
