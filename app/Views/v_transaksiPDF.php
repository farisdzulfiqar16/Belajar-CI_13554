<h1>Data Transaksi</h1>

    <table border="1" width="100%" cellpadding="5">
        <tr>
            <th>No</th>
            <th>Username</th>
            <th>Total Harga</th>
            <th>Alamat</th>
            <th>Ongkir</th>
            <th>Status</th>
        </tr>
        <?php
        $no = 1;
        foreach ($transactions as $index => $transaction):
        ?>
        <tr>
            <td align="center"><?= $no++ ?></td>
            <td><?= $transaction['username'] ?></td>
            <td align="right"><?= "Rp " . number_format($transaction['total_harga'], 2, ",", ".") ?></td>
            <td><?= $transaction['alamat'] ?></td>
            <td align="right"><?= "Rp " . number_format($transaction['ongkir'], 2, ",", ".") ?></td>
            <td><?= $transaction['status'] == 1 ? 'Selesai' : 'Pending' ?></td>
        </tr>
        <?php endforeach; ?>
    </table>

<p>Downloaded on <?= date("Y-m-d H:i:s") ?></p>