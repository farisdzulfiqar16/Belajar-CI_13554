<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class TransaksiController extends BaseController
{
    protected $cart;

    public function __construct()
    {
        // Memuat helper yang diperlukan
        helper('number');
        helper('form');
        
        // Inisialisasi layanan cart
        $this->cart = \Config\Services::cart();
        
        // Debugging output untuk memastikan layanan cart diinisialisasi
        if (is_null($this->cart)) {
            // Tambahkan logging jika layanan cart tidak diinisialisasi dengan benar
            log_message('error', 'Cart service not initialized.');
        } else {
            // Logging untuk memastikan layanan cart berhasil diinisialisasi
            log_message('info', 'Cart service initialized successfully.');
        }
    }

    public function index()
    {
        // Cek apakah layanan cart telah diinisialisasi
        if (is_null($this->cart)) {
            // Redirect ke halaman error jika layanan cart tidak tersedia
            return redirect()->to(base_url('error'))->with('error', 'Cart service is not available.');
        }

        // Mengambil isi dan total cart
        $data['items'] = $this->cart->contents();
        $data['total'] = $this->cart->total();
        
        // Mengembalikan view dengan data cart
        return view('v_keranjang', $data);
    }

    public function cart_add()
    {
        // Cek apakah layanan cart telah diinisialisasi
        if (is_null($this->cart)) {
            // Redirect ke halaman error jika layanan cart tidak tersedia
            return redirect()->to(base_url('error'))->with('error', 'Cart service is not available.');
        }

        // Menambahkan item ke cart
        $this->cart->insert(array(
            'id'        => $this->request->getPost('id'),
            'qty'       => 1,
            'price'     => $this->request->getPost('harga'),
            'name'      => $this->request->getPost('nama'),
            'options'   => array('foto' => $this->request->getPost('foto'))
        ));
        
        // Mengatur pesan sukses
        session()->setFlashdata('success', 'Produk berhasil ditambahkan ke keranjang. (<a href="' . base_url() . 'keranjang">Lihat</a>)');
        
        // Redirect ke halaman utama
        return redirect()->to(base_url('/'));
    }

    public function cart_clear()
    {
        // Cek apakah layanan cart telah diinisialisasi
        if (is_null($this->cart)) {
            // Redirect ke halaman error jika layanan cart tidak tersedia
            return redirect()->to(base_url('error'))->with('error', 'Cart service is not available.');
        }

        // Menghapus semua isi cart
        $this->cart->destroy();
        
        // Mengatur pesan sukses
        session()->setFlashdata('success', 'Keranjang Berhasil Dikosongkan');
        
        // Redirect ke halaman keranjang
        return redirect()->to(base_url('keranjang'));
    }

    public function cart_edit()
    {
        // Cek apakah layanan cart telah diinisialisasi
        if (is_null($this->cart)) {
            // Redirect ke halaman error jika layanan cart tidak tersedia
            return redirect()->to(base_url('error'))->with('error', 'Cart service is not available.');
        }

        // Mengedit isi cart
        $i = 1;
        foreach ($this->cart->contents() as $value) {
            $this->cart->update(array(
                'rowid' => $value['rowid'],
                'qty'   => $this->request->getPost('qty' . $i++)
            ));
        }

        // Mengatur pesan sukses
        session()->setFlashdata('success', 'Keranjang Berhasil Diedit');
        
        // Redirect ke halaman keranjang
        return redirect()->to(base_url('keranjang'));
    }

    public function cart_delete($rowid)
    {
        // Cek apakah layanan cart telah diinisialisasi
        if (is_null($this->cart)) {
            // Redirect ke halaman error jika layanan cart tidak tersedia
            return redirect()->to(base_url('error'))->with('error', 'Cart service is not available.');
        }

        // Menghapus item dari cart
        $this->cart->remove($rowid);

        // Mengatur pesan sukses
        session()->setFlashdata('success', 'Keranjang Berhasil Dihapus');
        
        // Redirect ke halaman keranjang
        return redirect()->to(base_url('keranjang'));
    }
}
