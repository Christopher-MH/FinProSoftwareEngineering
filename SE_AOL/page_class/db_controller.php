<?php
require '../page_database/db_connect.php';

class db_controller extends db_connect {
    protected function insert_user($user_id, $nama_pertama, $nama_akhir, $photo_path, $tanggal_lahir, $handphone,
                                     $email, $pass, $status, $poin_skrng, $poin_masuk, $poin_keluar) {
        $sql = "INSERT INTO users (user_id, nama_pertama, nama_akhir, photo_path, tanggal_lahir,
                                     handphone, email, pass, status_account, poin_skrng, poin_masuk, poin_keluar) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $statement = $this->connect()->prepare($sql);
        $statement->execute([
            $user_id,
            $nama_pertama,
            $nama_akhir,
            $photo_path,
            $tanggal_lahir,
            $handphone,
            $email,
            $pass,
            $status,
            $poin_skrng,
            $poin_masuk,
            $poin_keluar
        ]);
        $this->close();
    }

    protected function get_all_email(){
        $sql = "SELECT email FROM users;";
        $statement = $this->connect()->query($sql);
        $results = $statement->fetchAll(PDO::FETCH_COLUMN);
        return $results;
    }

    protected function get_last_id(){
        $sql = "SELECT user_id FROM users ORDER BY user_id DESC LIMIT 1;";
        $statement = $this->connect()->query($sql);
        $results = $statement->fetchColumn();
        return $results;
    }
}
