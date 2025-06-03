<?php
require '../page_class/db_controller.php';

class signup_controller extends db_controller {
    private $start = 0;


    private $id = null;
    private $nama_pertama = null;
    private $nama_akhir = null;
    private $photo_path = null;
    private $tanggal_lahir = null;
    private $handphone = null;
    private $email = null;
    private $pass = null;
    private $konfirmasi_pass = null;
    private $status = null;
    private $poin_skrng = null;
    private $poin_masuk = null;
    private $poin_keluar = null;

    public $temp_photo_path = null;
    public $temp_folder_path = '../page_assets/profile_pictures/temp/';
    public $display_photo = "../page_assets/profile_pictures/default.png";

    public $nama_pertama_placeholder = "Nama Pertama";
    public $nama_akhir_placeholder = "Nama Akhir";
    public $tanggal_lahir_placeholder = "Tanggal Lahir";
    public $handphone_placeholder = "No. Handphone";
    public $email_placeholder = "Email";
    public $pass_placeholder = "Password";
    public $konfirmasi_pass_placeholder = "Konfirmasi Password";

    private $pass_empty_validation = 0;
    private $pass_email_validation = 0;
    private $pass_duplicate_validation = 0;
    private $pass_full_validation = 0;
    private $pass_match_validation = 0;

    public function nama_pertama_temp(){
        echo $this->nama_pertama;
    }

    public function nama_akhir_temp(){
        echo $this->nama_akhir;
    }

    public function tanggal_lahir_temp(){
        echo $this->tanggal_lahir;
    }

    public function handphone_temp(){
        echo $this->handphone;
    }

    public function email_temp(){
        echo $this->email;
    }

    public function pass_temp(){
        echo $this->pass;
    }

    public function konfirmasi_pass_temp(){
        echo $this->konfirmasi_pass;
    }

    public function empty_folder($folder_path) {
        $files = glob($folder_path.'/*');  
        foreach($files as $file){
            if(is_file($file)) unlink($file);
        } 
    }

    private function user($data){
        $this->nama_pertama = $data["nama_pertama_input"];
        $this->nama_akhir = $data["nama_akhir_input"];
        $this->tanggal_lahir = $data["tanggal_lahir_input"];
        $this->handphone = $data["handphone_input"];
        $this->email = $data["email_input"];
        $this->pass = $data["pass_input"];
        $this->konfirmasi_pass = $data["konfirmasi_pass_input"];
    }

    private function validate_empty($img){
        if($this->start == 0){   
            $this->nama_pertama_placeholder = "Nama Pertama";
            $this->nama_akhir_placeholder = "Nama Akhir";
            $this->tanggal_lahir_placeholder = "Tanggal Lahir";
            $this->handphone_placeholder = "No. Handphone";
            $this->email_placeholder = "Email";
            $this->pass_placeholder = "Password";
            $this->konfirmasi_pass_placeholder = "Konfirmasi Password";
        } else{
            $this->nama_pertama_placeholder = empty(trim($this->nama_pertama)) ? "Nama pertama harus diisi!" : null;
            $this->nama_akhir_placeholder = empty(trim($this->nama_akhir)) ? "Nama akhir harus diisi!" : null;
            $this->tanggal_lahir_placeholder = empty(trim($this->tanggal_lahir)) ? "Tanggal lahir harus diisi!" : null;
            $this->handphone_placeholder = empty(trim($this->handphone)) ? "No. Handphone harus diisi!" : null;
            $this->email_placeholder = empty(trim($this->email)) ? "Email harus diisi!" : null;
            $this->pass_placeholder = empty(trim($this->pass)) ? "Password harus diisi!" : null;
            $this->konfirmasi_pass_placeholder = empty(trim($this->konfirmasi_pass)) ? "Konfirmasi password harus diisi!" : null;
        }

        if($img['error'] == UPLOAD_ERR_OK){
            $this->display_photo = "../page_assets/profile_pictures/temp/" . basename($img['name']);
            if($this->display_photo != $this->temp_photo_path){
                $this->temp_photo_path = $this->display_photo;
                $this->empty_folder($this->temp_folder_path);
                move_uploaded_file($img['tmp_name'], $this->temp_photo_path);
            }
        } else{
            $files = glob($this->temp_folder_path . '*');
            if(!empty($files)){
                $this->display_photo = reset($files);
                $this->temp_photo_path = $this->display_photo;
            } else{
                $this->display_photo = "../page_assets/profile_pictures/default_2.png";
            }
        }

        if($this->nama_pertama_placeholder == null && $this->nama_akhir_placeholder == null 
        && $this->tanggal_lahir_placeholder == null && $this->handphone_placeholder == null
        && $this->email_placeholder == null && $this->pass_placeholder == null
        && $this->konfirmasi_pass_placeholder == null && $this->temp_photo_path != null){
            $this->pass_empty_validation = 1;
        }
    }

    private function validate_email(){
        if(filter_var($this->email, FILTER_VALIDATE_EMAIL) === false){
            $this->email_placeholder = "Email format not valid!";
            $this->email = null;
        } else{
            $this->email_placeholder = null;
            $this->pass_email_validation = 1;
        }
    }

    private function validate_duplicate(){
        $all_Emails = $this->get_all_email();
        $this->pass_duplicate_validation = 1;
        $this->email_placeholder = null;

        foreach($all_Emails as $i){
            if($i == $this->email){
                $this->email = null;
                $this->email_placeholder = "Email sudah didaftarkan!";
                $this->pass_duplicate_validation = 0;
                break;
            }
        }
    }

    private function validate_match(){
        $this->pass_match_validation = 1;
        $this->pass_placeholder = null;
        $this->konfirmasi_pass_placeholder = null;

        if($this->pass != $this->konfirmasi_pass){
            $this->pass_placeholder = "Konfirmasi password tidak sama!";
            $this->konfirmasi_pass_placeholder = "Konfirmasi password tidak sama!";
            $this->pass_match_validation = 0;
        }
    }

    private function generate_id() {
        $last_ID = $this->get_last_id();

        if (!$last_ID || !preg_match('/^U\d+$/', $last_ID)) {
            $number = 1;
        } else {
            $number = (int)substr($last_ID, 1);
            $number += 1;
        }

        $this->id = 'U' . str_pad($number, 4, '0', STR_PAD_LEFT);
    }

    private function hash_password(){
        $this->temp_pass = $this->pass;
        $this->pass = md5($this->temp_pass);
    }

    private function move_photo(){
        $destination = "../page_assets/profile_pictures/";
    
        $extension = pathinfo($this->temp_photo_path, PATHINFO_EXTENSION);
        
        $this->photo_path = $destination . $this->id . "_Photo." . $extension;
    
        rename($this->temp_photo_path, $this->photo_path);
    }

    public function create_user($data, $img){
        $this->start += 1;
        $this->user($data);

        $this->validate_empty($img);
        if($this->pass_empty_validation == 0){
            return;
        }

        $this->validate_email();
        if($this->pass_email_validation == 0){
            return;
        }

        $this->validate_duplicate();
        if($this->pass_duplicate_validation == 0){
            return;
        }

        $this->validate_match();
        if($this->pass_match_validation == 0){
            return;
        }
        
        $this->generate_id();

        $this->hash_password();

        $this->move_photo();

        $this->insert_user($this->id, $this->nama_pertama, $this->nama_akhir, $this->photo_path,
         $this->tanggal_lahir, $this->handphone, $this->email, $this->pass, 'aktif', 0, 0, 0);
    
        header("Location: ../page_php/home.php");
    }
}