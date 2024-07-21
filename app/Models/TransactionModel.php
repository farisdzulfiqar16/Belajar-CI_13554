<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionModel extends Model
{
    protected $table = 'transaction';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'username', 'total_harga', 'alamat', 'ongkir', 'status', 'created_at', 'updated_at'
    ];

    /**
     * Update status transaksi
     *
     * @param int $id - ID transaksi
     * @param int $status - Status baru (0 atau 1)
     * @return bool - Status pembaruan
     */
    public function updateStatus($id, $status)
    {
        // Validasi input
        if (empty($id) || !in_array($status, [0, 1])) {
            return false;
        }

        // Update status
        return $this->update($id, ['status' => $status]);
    }
}
