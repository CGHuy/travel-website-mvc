# Hướng dẫn lấy và hiển thị ảnh từ database (MySQL, kiểu BLOB) bằng PHP

## 1. Cách lưu ảnh vào database

- Cột lưu ảnh nên dùng kiểu `BLOB` hoặc `LONGBLOB`.
- Khi upload, dùng PHP để đọc file ảnh và lưu vào cột blob.

**Ví dụ lưu ảnh:**

```php
$imageData = file_get_contents($_FILES['file']['tmp_name']);
$sql = "INSERT INTO tours (name, cover_image) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sb", $name, $imageData);
$stmt->execute();
```

---

## 2. Cách SELECT và hiển thị ảnh từ database

**Bước 1:** Kết nối database qua class Database (tối ưu, dễ tái sử dụng).
**Bước 2:** Truy vấn lấy dữ liệu ảnh (blob).
**Bước 3:** Kiểm tra dữ liệu, lấy mime-type, encode base64, hiển thị ảnh.

### Code tối ưu (dễ hiểu, dễ tái sử dụng):

```php
require_once __DIR__ . '/../config/database.php';
function showTourImage($tourId) {
    $db = new Database();
    $conn = $db->getConnection();
    $sql = "SELECT name, cover_image FROM tours WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $tourId);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res && $row = $res->fetch_assoc()) {
        if (!empty($row['cover_image'])) {
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mime = $finfo->buffer($row['cover_image']);
            if (strpos($mime, 'image/') === 0) {
                $imgData = base64_encode($row['cover_image']);
                echo '<img src="data:' . $mime . ';base64,' . $imgData . '" width="300" alt="' . htmlspecialchars($row['name']) . '">';
            } else {
                echo "<div class=\'text-danger\'>Dữ liệu không phải ảnh hợp lệ!</div>";
            }
        } else {
            echo "<div class=\'text-warning\'>Chưa có ảnh cho tour này.</div>";
        }
    } else {
        echo "<div class=\'text-danger\'>Không tìm thấy tour hoặc ảnh.</div>";
    }
    $db->close();
}
// Gọi hàm hiển thị ảnh cho tour id=8
showTourImage(8);
```

---

## 3. Giải thích từng bước

- **Kết nối:** Sử dụng class Database để quản lý kết nối, dễ đóng/mở, tái sử dụng.
- **Truy vấn:** Dùng prepared statement để tránh lỗi SQL injection.
- **Kiểm tra dữ liệu:** Nếu blob rỗng hoặc không phải ảnh, báo lỗi rõ ràng.
- **Hiển thị:** Dùng base64 và mime-type tự động, đảm bảo hiển thị đúng mọi loại ảnh (jpg, png, gif...).

---

## 4. Lưu ý

- Nếu ảnh không hiển thị, kiểm tra lại dữ liệu blob (phải là ảnh hợp lệ).
- Nên kiểm tra kích thước ảnh khi lưu vào database (tránh quá lớn).
- Nếu muốn tối ưu hiệu năng, nên lưu ảnh ra file và chỉ lưu đường dẫn vào database.

---

## 5. Tài liệu ngắn gọn cho team

**Cách lấy và hiển thị ảnh từ database:**

- Sử dụng class Database để kết nối.
- Truy vấn lấy blob ảnh bằng prepared statement.
- Dùng finfo lấy mime-type, encode base64.
- Hiển thị ảnh bằng thẻ `<img src="data:{mime};base64,{data}">`.
- Kiểm tra dữ liệu, báo lỗi rõ ràng nếu không có ảnh hoặc dữ liệu lỗi.
