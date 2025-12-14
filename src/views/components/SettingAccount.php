<?php
include __DIR__ . '/../partials/menu.php';
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Du Lịch</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend+Deca:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/AppStyle.css">
    <link rel="stylesheet" href="css/SettingAccount.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">


</head>

<body>
    <div class="container-fluid my-4">
        <div class="d-flex gap-4 px-5">
            <div class="card menu menu-card" style="flex: 0 0 20%;">
                <div class="card-body p-3">
                    <ul class="menu-list">
                        <li class="menu-item active">
                            <i class="fa-solid fa-user"></i>
                            <a href="<?= route('user.edit'); ?>" class="text-decoration-none flex-grow-1"
                                style="color: inherit;">Thông tin cá nhân</a>
                        </li>
                        <li class="menu-item">
                            <i class="fa-solid fa-lock"></i>
                            <a href="#" class="text-decoration-none flex-grow-1" style="color: inherit;">Đổi mật
                                khẩu</a>
                        </li>
                        <li class="menu-item">
                            <i class="fa-solid fa-clock-rotate-left"></i>
                            <a href="#" class="text-decoration-none flex-grow-1" style="color: inherit;">Lịch sử đặt
                                tour</a>
                        <li class="menu-item">
                            <i class="fa-solid fa-heart"></i>
                            <a href="#" class="text-decoration-none flex-grow-1" style="color: inherit;">Tour yêu
                                thích</a>
                        </li>
                        </li>
                        <li class="menu-item">
                            <i class="fa-solid fa-right-from-bracket"></i>
                            <a href="#" class="text-decoration-none flex-grow-1" style="color: inherit;">Đăng xuất</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="card card_form" style="flex: 0 0 calc(80% - 1rem);">
                <div class="card-header">
                    <h5 class="card-title">Thông tin cá nhân</h5>
                    <p style="color: #636465ff ;">Cập nhật thông tin và ảnh đại diện của bạn</p>
                </div>
                <div class="card-body">
                    <form method="post" action="<?= route('user.update'); ?>">
                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Họ và tên</label>
                                    <input name="fullname" type="text" class="form-control"
                                        value="<?= htmlspecialchars($user['fullname'] ?? '') ?>">
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Số điện thoại</label>
                                    <input name="phone" type="text" class="form-control"
                                        value="<?= htmlspecialchars($user['phone'] ?? '') ?>">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input name="email" type="email" class="form-control"
                                        value="<?= htmlspecialchars($user['email'] ?? '') ?>">
                                </div>
                            </div>



                            <div class="col-12 d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary btn-sm px-3">Lưu thay đổi</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>
<?php include __DIR__ . '/../partials/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</html>