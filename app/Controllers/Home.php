<?php

namespace App\Controllers;

use App\Models\ProductModel;

class Home extends BaseController
{
    protected $product;
    
    function __construct()
    {
        helper('form');     //mengirim data produk yang dipilih user
        helper('number');   //untuk format harga barang (Rupiah)
        $this->product = new ProductModel();
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
