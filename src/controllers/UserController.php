<?php
require_once __DIR__ . '/../models/User.php';

class UserController
{
    private $userModel;
    private $userId = 1; // cố định

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function edit()
    {
        $user = $this->userModel->getById($this->userId);
        if (!$user) {
            http_response_code(404);
            echo "User không tồn tại";
            return;
        }
        include __DIR__ . '/../views/components/SettingAccount.php';
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . route('user.edit'));
            return;
        }

        $user = $this->userModel->getById($this->userId);
        if (!$user) {
            http_response_code(404);
            echo "User không tồn tại";
            return;
        }

        $fullname = $_POST['fullname'] ?? $user['fullname'];
        $phone = $_POST['phone'] ?? $user['phone'];
        $email = $_POST['email'] ?? $user['email'];
        $password = $_POST['password'] ?? '';
        if ($password === '') {
            $password = $user['password']; // giữ nguyên nếu không đổi
        }

        $this->userModel->update(
            $this->userId,
            $fullname,
            $phone,
            $email,
            $password,
            $user['role'],
            $user['status']
        );

        header('Location: ' . route('user.edit'));
    }
}