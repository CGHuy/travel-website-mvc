<?php
require_once __DIR__ . '/../models/User.php';

class UserController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }


    // Hiển thị danh sách người dùng
    public function index()
    {
        $users = $this->userModel->getAllUsers();
        include __DIR__ . '/../views/user_list.php';
    }

    // Hiển thị form thêm người dùng
    public function create()
    {
        include __DIR__ . '/../views/user_create.php';
    }

    // Xử lý lưu người dùng mới
    public function store()
    {
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        if ($name === '' || $email === '') {
            $error = "Tên và email không được để trống!";
            include __DIR__ . '/../views/user_create.php';
            return;
        }
        $this->userModel->createUser($name, $email);
        header("Location: /index.php?controller=user&action=index");
        exit;
    }


    // Hiển thị thông tin một người dùng
    public function show($id)
    {
        $user = $this->userModel->getUserById($id);
        include __DIR__ . '/../views/user_detail.php';
    }

    // Hiển thị form sửa người dùng
    public function edit($id)
    {
        $user = $this->userModel->getUserById($id);
        include __DIR__ . '/../views/user_edit.php';
    }

    // Xử lý cập nhật người dùng
    public function update($id)
    {
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        if ($name === '' || $email === '') {
            $error = "Thiếu thông tin cập nhật!";
            $user = ['id' => $id, 'name' => $name, 'email' => $email];
            include __DIR__ . '/../views/user_edit.php';
            return;
        }
        $this->userModel->updateUser($id, $name, $email);
        header("Location: /index.php?controller=user&action=index");
        exit;
    }


    // Xử lý xóa người dùng
    public function delete($id)
    {
        $this->userModel->deleteUser($id);
        header("Location: /index.php?controller=user&action=index");
        exit;
    }
}
?>