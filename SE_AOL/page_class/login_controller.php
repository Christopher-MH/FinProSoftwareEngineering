<?php
require 'db_controller.php';

class login_controller extends db_controller {
    private $email;
    private $pass;
    private $hashed_Pass;
    public $entered_email = "";

    public $email_placeholder = null;
    public $fail_login = "none";

    private $pass_empty_validation = 0;
    private $pass_email_validation = 0;


    private function set_user_input($data) {
        $this->email = isset($data["email_input"]) ? trim($data["email_input"]) : '';
        $this->entered_email = $this->email;
        $this->pass = isset($data["password_input"]) ? trim($data["password_input"]) : '';
    }

    private function validate_empty(){
        $this->pass_empty_validation = 0;
        $this->email_placeholder = empty($this->email) ? "Email harus diisi!" : null;

        if ($this->email_placeholder === null && !empty($this->pass)) {
            $this->pass_empty_validation = 1;
        }
    }

    private function validate_email_format(){
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $this->email_placeholder = "Email format tidak valid!";
            $this->pass_email_validation = 0;
        } else {
            $this->pass_email_validation = 1;
        }
    }

    public function login($data){
        $this->set_user_input($data);
        $this->validate_empty();

        if ($this->pass_empty_validation == 0) return;

        $this->validate_email_format();
        if ($this->pass_email_validation == 0) return;

        $this->hashed_Pass = md5($this->pass);

        $user = $this->get_user_by_email($this->email);

        if (!$user || $user["pass"] !== $this->hashed_Pass) {
            $this->fail_login = "block";
            return;
        }

        header("Location: ../page_php/profile.php");
        exit;
    }

}
