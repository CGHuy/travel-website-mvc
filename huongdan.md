# HƯỚNG DẪN SỬ DỤNG VÀ MỞ RỘNG DỰ ÁN WEB DU LỊCH (PHP MVC)

---

## 1. Giới thiệu mô hình MVC

### MVC là gì? (Giải thích kỹ cho người mới)

**MVC** là viết tắt của **Model - View - Controller**. Đây là một mô hình tổ chức mã nguồn giúp chia nhỏ ứng dụng web thành 3 phần riêng biệt, mỗi phần có nhiệm vụ rõ ràng:

- **Model (M)**

  - Là nơi quản lý dữ liệu và các quy tắc xử lý dữ liệu.
  - Model thường kết nối tới cơ sở dữ liệu (MySQL), thực hiện các thao tác như lấy danh sách, thêm, sửa, xóa dữ liệu.
  - Ví dụ: Model User sẽ có các hàm như lấy danh sách người dùng, thêm người dùng mới, sửa thông tin người dùng...

- **View (V)**

  - Là phần giao diện hiển thị cho người dùng (HTML, CSS, JS).
  - View chỉ nhận dữ liệu từ Controller và hiển thị ra màn hình, không xử lý logic nghiệp vụ.
  - Ví dụ: View user_list.php sẽ nhận danh sách người dùng và hiển thị thành bảng.

- **Controller (C)**
  - Là nơi tiếp nhận yêu cầu từ người dùng (request), xử lý logic, gọi Model để lấy hoặc cập nhật dữ liệu, sau đó truyền dữ liệu sang View để hiển thị.
  - Controller đóng vai trò trung gian, điều phối luồng dữ liệu giữa Model và View.
  - Ví dụ: Khi người dùng nhấn nút “Thêm người dùng”, Controller sẽ nhận dữ liệu từ form, gọi Model để lưu vào database, rồi chuyển hướng về View danh sách.

#### Minh họa luồng hoạt động MVC

1. Người dùng truy cập website, gửi yêu cầu (request) qua trình duyệt.
2. Controller nhận request, xác định cần làm gì (hiển thị danh sách, thêm mới, sửa, xóa...).
3. Controller gọi Model để lấy hoặc cập nhật dữ liệu.
4. Controller truyền dữ liệu sang View.
5. View hiển thị kết quả cho người dùng.

#### Lợi ích khi dùng MVC

- **Dễ bảo trì**: Khi muốn thay đổi giao diện, chỉ cần sửa View. Muốn thay đổi logic, chỉ cần sửa Controller hoặc Model.
- **Dễ mở rộng**: Thêm chức năng mới chỉ cần thêm Controller, Model, View tương ứng.
- **Tổ chức mã nguồn rõ ràng**: Mỗi phần có nhiệm vụ riêng, tránh lẫn lộn giữa xử lý dữ liệu và giao diện.

#### Ví dụ thực tế

- Khi bạn muốn hiển thị danh sách người dùng:
  - Trình duyệt gửi request tới Controller.
  - Controller gọi Model để lấy danh sách người dùng từ database.
  - Controller truyền danh sách này sang View.
  - View hiển thị danh sách ra màn hình.

### MVC là gì?

MVC (Model - View - Controller) là một mô hình kiến trúc phần mềm phổ biến giúp tách biệt các phần của ứng dụng web:

- **Model**: Quản lý dữ liệu, truy vấn và xử lý với cơ sở dữ liệu (CSDL).
- **View**: Hiển thị giao diện cho người dùng (HTML, CSS, JS).
- **Controller**: Xử lý logic, nhận request từ người dùng, gọi model, truyền dữ liệu sang view.

**Lợi ích của MVC:**

- Dễ bảo trì, mở rộng.
- Tách biệt rõ ràng giữa giao diện và xử lý dữ liệu.
- Nhiều người có thể làm việc song song trên các phần khác nhau.

### Luồng hoạt động của MVC trong dự án

1. Trình duyệt gửi request tới [`public/index.php`](public/index.php) (qua [`public/.htaccess`](public/.htaccess) rewrite).
2. [`public/index.php`](public/index.php) đọc các tham số `controller`, `action` từ URL.
3. Đối chiếu với cấu hình route trong [`config/routes.php`](config/routes.php).
4. Gọi controller và action tương ứng.
5. Controller xử lý logic, gọi model lấy dữ liệu, truyền sang view.
6. View render HTML trả về trình duyệt.

---

## 2. Cấu trúc thư mục và các file cần thiết

```
config/
    database.php      // Kết nối CSDL
    helpers.php       // Hàm hỗ trợ (route, ...)
    routes.php        // Định nghĩa các route
public/
    .htaccess         // Rewrite về index.php
    index.php         // Entry point, router chính
src/
    controllers/
        UserController.php      // Controller cho user
    models/
        User.php                // Model cho user
        Destination.php         // Model cho địa điểm
    service/
        DestinationService.php  // Service cho địa điểm
    views/
        user_list.php           // View danh sách user
        user_detail.php         // View chi tiết user
        user_create.php         // Form thêm user
        user_edit.php           // Form sửa user
        partials/
            header.php          // Layout header
            footer.php          // Layout footer
            menu.php            // Menu điều hướng
README.md
huongdan.md
```

---

## 3. Giải thích các file chính

- **config/database.php**: Kết nối và thao tác với database MySQL theo hướng OOP.
- **config/helpers.php**: Chứa các hàm tiện ích dùng chung, ví dụ hàm `route()` để sinh URL.
- **config/routes.php**: Định nghĩa các route (đường dẫn) của ứng dụng, ánh xạ tên route sang controller/action.
- **public/.htaccess**: Rewrite tất cả request về `index.php` để xử lý routing tập trung.
- **public/index.php**: Entry point, nhận request, gọi controller/action phù hợp.
- **src/controllers/**: Chứa các controller, mỗi controller xử lý logic cho một module (vd: UserController cho user).
- **src/models/**: Chứa các model, mỗi model quản lý dữ liệu cho một bảng trong CSDL.
- **src/service/**: Chứa các service, xử lý logic phức tạp hoặc truy vấn nhiều bảng.
- **src/views/**: Chứa các view, mỗi view là một file giao diện cho một chức năng cụ thể.
- **src/views/partials/**: Chứa các thành phần giao diện dùng chung như header, footer, menu.

---

## 4. Quy trình thêm chức năng CRUD (Create, Read, Update, Delete)

### Bước 1: Định nghĩa route

- Mở [`config/routes.php`](config/routes.php)
- Thêm các route mới cho chức năng CRUD, ví dụ:
  ```php
  return [
      'user.index'  => ['controller' => 'UserController', 'action' => 'index'],
      'user.show'   => ['controller' => 'UserController', 'action' => 'show'],
      'user.create' => ['controller' => 'UserController', 'action' => 'create'],
      'user.store'  => ['controller' => 'UserController', 'action' => 'store'],
      'user.edit'   => ['controller' => 'UserController', 'action' => 'edit'],
      'user.update' => ['controller' => 'UserController', 'action' => 'update'],
      'user.delete' => ['controller' => 'UserController', 'action' => 'delete'],
      // Thêm các route cho model khác nếu cần
  ];
  ```

### Bước 2: Tạo/Chỉnh sửa Controller

- Mở [`src/controllers/UserController.php`](src/controllers/UserController.php)
- Thêm các phương thức tương ứng:
  - `index()` // Hiển thị danh sách
  - `show($id)` // Hiển thị chi tiết
  - `create()` // Hiển thị form thêm mới
  - `store()` // Xử lý lưu mới (POST)
  - `edit($id)` // Hiển thị form sửa
  - `update($id)` // Xử lý cập nhật (POST)
  - `delete($id)` // Xử lý xóa

Ví dụ:

```php
public function create() {
    include __DIR__ . '/../views/user_create.php';
}
public function store() {
    // Xử lý dữ liệu POST, gọi model để lưu
}
```

### Bước 3: Tạo/Chỉnh sửa Model

- Mở [`src/models/User.php`](src/models/User.php)
- Đảm bảo có các phương thức:
  - `getAllUsers()`
  - `getUserById($id)`
  - `createUser($name, $email)`
  - `updateUser($id, $name, $email)`
  - `deleteUser($id)`

### Bước 4: Tạo View

- Tạo các file view trong [`src/views`](src/views)
  - [`src/views/user_list.php`](src/views/user_list.php) // Hiển thị danh sách
  - [`src/views/user_detail.php`](src/views/user_detail.php) // Hiển thị chi tiết
  - `user_create.php` // Form thêm mới
  - `user_edit.php` // Form sửa

Các view chỉ nhận biến từ controller và render HTML, không xử lý logic.

### Bước 5: Cập nhật menu hoặc điều hướng

- Mở [`src/views/partials/menu.php`](src/views/partials/menu.php)
- Thêm link tới các chức năng CRUD, ví dụ:
  ```php
  <a class="nav-link" href="<?= route('user.index'); ?>">Danh sách người dùng</a>
  <a class="nav-link" href="<?= route('user.create'); ?>">Thêm người dùng</a>
  ```

### Bước 6: Kiểm tra và hoàn thiện

- Truy cập các chức năng qua menu hoặc URL, kiểm tra hoạt động.
- Đảm bảo sau khi thêm/sửa/xóa, controller chuyển hướng về trang phù hợp.

---

## 5. Ví dụ luồng thêm người dùng

1. Truy cập menu "Thêm người dùng" (`user.create`) → gọi `UserController::create()` → hiển thị form.
2. Submit form → gọi `UserController::store()` → lưu vào DB qua model → chuyển về danh sách (`user.index`).

---

## 6. Lưu ý mở rộng

- Khi thêm chức năng cho model khác (ví dụ: Destination), lặp lại các bước trên với controller/model/view tương ứng.
- Sử dụng helper `route()` để tạo URL cho các route.
- Tách layout header/footer/menu để dễ bảo trì.

---

## 7. Tóm tắt luồng hoạt động (ASCII)

```
[Trình duyệt]
     |
     v
[.htaccess] --(rewrite)--> [public/index.php]
     |
     v
[Router đọc controller/action]
     |
     v
[Gọi Controller phù hợp]
     |
     v
[Controller xử lý logic]
     |
     v
[Gọi Model lấy dữ liệu]
     |
     v
[Truyền dữ liệu sang View]
     |
     v
[View render HTML trả về trình duyệt]
```

---

**Tài liệu này giúp bạn hiểu và mở rộng dự án theo chuẩn MVC, phù hợp cho người mới bắt đầu. Nếu gặp lỗi, kiểm tra lại các bước, đặc biệt là cấu hình route và tên phương thức controller.**
