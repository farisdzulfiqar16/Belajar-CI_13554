<?php

use App\Controllers\ProdukController;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

//halaman awal
    $routes->get('/', 'Home::index', ['filter' => 'auth']);

//login dan mengarahkan halaman untuk user
    $routes->get('login', 'AuthController::login');
    $routes->post('login', 'AuthController::login', ['filter' => 'redirect']);
    $routes->get('logout', 'AuthController::logout');

//untuk memisahkan halaman pada user dan auth/admin
    $routes->get('produk', 'ProdukController::index', ['filter' => 'auth']);

//CRUD untuk admin 
    //dalam bentuk satuan
        //untuk edit produk
            // $routes->post('produk', 'ProdukController::create', ['filter' => 'auth']);
            // $routes->post('produk/edit/(:any)', 'ProdukController::edit/$1', ['filter' => 'auth']);
            // $routes->get('produk/delete/(:any)', 'ProdukController::delete/$1', ['filter' => 'auth']);

    //altrenatif CRUD untuk mengedit data (dalam bentuk grup)
    $routes->group('produk', ['filter'=> 'auth'],function($routes){
        $routes->get('','ProdukController::index');                     //halaman produk
        $routes->post('','ProdukController::create');                   //untuk membuat data
        $routes->post('edit/(:any)','ProdukController::edit/$1');       //untuk edit data
        $routes->get('delete/(:any)','ProdukController::delete/$1');    //untuk menghapus data
        $routes->get('download','ProdukController::download');           //untuk download data produk
    });;

    
    //untuk keranjang
    //$routes->get('keranjang', 'TransaksiController::index', ['filter' => 'auth']);
        $routes->group('keranjang', ['filter' => 'auth'], function ($routes) {
            $routes->get('', 'TransaksiController::index');
            $routes->post('', 'TransaksiController::cart_add');
            $routes->post('edit', 'TransaksiController::cart_edit');
            $routes->get('delete/(:any)', 'TransaksiController::cart_delete/$1');
            $routes->get('clear', 'TransaksiController::cart_clear');
        });

    // untuk transaksi beli dan checkout
        $routes->get('checkout', 'TransaksiController::checkout', ['filter' => 'auth']);
        $routes->get('getcity', 'TransaksiController::getcity', ['filter' => 'auth']);
        $routes->get('getcost', 'TransaksiController::getcost', ['filter' => 'auth']);
        $routes->get('buy', 'TransaksiController::buy', ['filter' => 'auth']);

    // menu profil
    $routes->get('profile', 'Home::profile', ['filter' => 'auth']);

    //halaman login sebagai auth, menampilkan semua konten
    $routes->get('faq', 'Home::faq', ['filter' => 'auth']);
    $routes->get('profile', 'Home::profile', ['filter' => 'auth']);
    $routes->get('contact', 'Home::contact', ['filter' => 'auth']);
