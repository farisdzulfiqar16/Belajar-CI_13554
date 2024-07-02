<?php

namespace App\Controllers;

use App\Database\Migrations\Transaction;
use App\Models\ProductModel;
use App\Models\TransactionModel;
use App\Database\Migrations\TransactionDetail;
use App\Models\TransactionDetailModel;

class Home extends BaseController
{
    protected $product;
    protected $transaction;
    protected $transaction_detail;
    
    function __construct()
    {
        helper('form');     //mengirim data produk yang dipilih user
        helper('number');   //untuk format harga barang (Rupiah)
        $this->product = new ProductModel();
        $this->transaction = new TransactionModel();
        $this->transaction_detail = new TransactionDetailModel();

    }

    public function index()
    {
        $product = $this->product->findAll();
        $data ['product'] = $product;
        
        return view('v_home',$data);
    }

    public function faq()
    {
        return view('v_faq');
    }

    public function profile()
    {
        return view('v_profile');
    }

    public function contact()
    {
        return view('v_contact');
    }

    
}
