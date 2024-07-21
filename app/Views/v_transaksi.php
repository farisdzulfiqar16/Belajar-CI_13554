<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<h1>Transaksi</h1>

<a href="<?= base_url('transaksi/download-pdf') ?>" class="btn btn-primary">
    Download PDF
</a>

<!-- Tabel transaksi -->
<table class="table datatable">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Username</th>
            <th scope="col">Total Harga</th>
            <th scope="col">Alamat</th>
            <th scope="col">Ongkir</th>
            <th scope="col">Status</th>
            <th scope="col">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($transactions)) : ?>
            <?php foreach ($transactions as $transaction) : ?>
                <tr>
                    <td><?= $transaction['id'] ?></td>
                    <td><?= $transaction['username'] ?></td>
                    <td><?= number_format($transaction['total_harga'], 0, ',', '.') ?></td>
                    <td><?= $transaction['alamat'] ?></td>
                    <td><?= number_format($transaction['ongkir'], 0, ',', '.') ?></td>
                    <td><?= $transaction['status'] ?></td>
                    <td>
                        <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#editStatusModal<?= $transaction['id'] ?>">
                            Ubah Status
                        </button>
                    </td>
                </tr>

                <!-- Modal untuk mengubah status -->
                <div class="modal fade" id="editStatusModal<?= $transaction['id'] ?>" tabindex="-1" aria-labelledby="editStatusModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editStatusModalLabel">Ubah Status Transaksi</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="<?= base_url('transaksi/updateStatus/' . $transaction['id']) ?>" method="post">
                                <?= csrf_field() ?>
                                <div class="modal-body">
                                    <input type="hidden" name="transaction_id" value="<?= $transaction['id'] ?>">
                                    <div class="mb-3">
                                        <label for="status" class="form-label">Status</label>
                                        <select name="status" id="status" class="form-select">
                                            <option value="0" <?= $transaction['status'] == 0 ? 'selected' : '' ?>>0</option>
                                            <option value="1" <?= $transaction['status'] == 1 ? 'selected' : '' ?>>1</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <tr>
                <td colspan="7">Tidak ada data transaksi.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<!-- Pemberitahuan Status -->
<?php if (session()->getFlashdata('status_updated')) : ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('status_updated') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>