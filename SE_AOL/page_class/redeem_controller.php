<?php
require '../page_class/db_controller.php';

class redeem_controller extends db_controller {
    private $conn;
    private $user_id;
    private $user_point;
    public $voucher_list = [];

    public function __construct($user_id) {
        $this->user_id = $user_id;
        $this->fetch_user_point();
        $this->fetch_all_vouchers();
        $this->conn = $this->connect();
    }

    private function fetch_user_point() {
        $query = "SELECT poin_skrng FROM users WHERE user_id = ?";
        $stmt = $this->connect()->prepare($query);
        $stmt->execute([$this->user_id]);
        $this->user_point = $stmt->fetchColumn();
    }

    private function fetch_all_vouchers() {
        $stmt = $this->connect()->query("SELECT * FROM vouchers");
        $this->voucher_list = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($this->voucher_list as &$row) {
            $row['redeemable'] = $row['harga'] <= $this->user_point && $row['stok'] > 0;
        }
    }

    public function redeem($voucher_id) {
        $stmt = $this->connect()->prepare("SELECT harga, stok FROM vouchers WHERE voucher_id = :voucher_id");
        $stmt->execute(['voucher_id' => $voucher_id]);
        $voucher = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$voucher) return false;

        $harga = $voucher['harga'];
        $stok = $voucher['stok'];

        if ($harga > $this->user_point || $stok <= 0) return false;

        $this->conn->beginTransaction();

        try {
            $new_point = $this->user_point - $harga;

            $updateUser = $this->conn->prepare("
                UPDATE users 
                SET poin_skrng = poin_skrng - :harga, 
                    poin_keluar = poin_keluar + :harga 
                WHERE user_id = :user_id
            ");
            $updateUser->execute([
                'harga' => $harga,
                'user_id' => $this->user_id
            ]);

            $updateVoucher = $this->conn->prepare("
                UPDATE vouchers 
                SET stok = stok - 1 
                WHERE voucher_id = :voucher_id
            ");
            $updateVoucher->execute([
                'voucher_id' => $voucher_id
            ]);

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollBack();
            return false;
        }
    }

    public function get_user_point() {
        return $this->user_point;
    }
}
