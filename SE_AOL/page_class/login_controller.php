<?php
require '../page_class/db_controller.php';

class login_controller extends db_controller {
    private $email = null;
    private $password = null;
    public $email_placeholder = "Email";
    public $pass_placeholder = "Password";
    public $login_failed = false;

    public function set_credentials($data) {
        $this->email = trim($data['email_input']);
        $this->password = trim($data['pass_input']);
    }

    public function validate() {
        if (empty($this->email)) {
            $this->email_placeholder = "Email harus diisi!";
        }

        if (empty($this->password)) {
            $this->pass_placeholder = "Password harus diisi!";
        }

        return !empty($this->email) && !empty($this->password);
    }

    public function attempt_login() {
        $hashed = md5($this->password);

        $sql = "SELECT user_id, status_account FROM users WHERE email = ? AND pass = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$this->email, $hashed]);

        if ($stmt->rowCount() === 1) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result['status_account'] === 'aktif') {
                session_start();
                $_SESSION['user_id'] = $result['user_id'];
                header("Location: ../page_php/home.php");
                exit;
            } else {
                $this->email_placeholder = "Akun tidak aktif ({$result['status_account']})";
            }
        } else {
            $this->login_failed = true;
            $this->email_placeholder = "Email atau password salah!";
        }
    }
}