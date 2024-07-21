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

//halaman profil, account settings, dan FAQ
$routes->get('/profile', 'Home::profile', ['filter' => 'auth']);
$routes->get('/account-settings', 'Pages::accountSettings');
$routes->get('/faq', 'Home::faq', ['filter' => 'auth']);

//untuk memisahkan halaman pada user dan auth/admin
$routes->get('produk', 'ProdukController::index', ['filter' => 'auth']);

// CRUD untuk admin produk
$routes->group('produk', ['filter' => 'auth:admin'], function ($routes) {
    $routes->get('', 'ProdukController::index');                     // halaman produk
    $routes->post('', 'ProdukController::create');                   // membuat data
    $routes->post('edit/(:any)', 'ProdukController::edit/$1');       // edit data
    $routes->get('delete/(:any)', 'ProdukController::delete/$1');    // hapus data
    $routes->get('download', 'ProdukController::download');          // download data produk
});

// Halaman manajemen transaksi dan update status
$routes->group('transaksi', ['filter' => 'auth:admin'], function ($routes) {
    $routes->get('/', 'TransaksiController::transaksi');                 // Halaman manajemen transaksi
    $routes->post('updateStatus/(:num)', 'TransaksiController::updateStatus/$1');         // Update status transaksi
    $routes->get('download-pdf', 'TransaksiController::download');          // download data produk
    $routes->post('transaksi/update', 'TransaksiController::update');
});



//untuk keranjang
$routes->get('keranjang', 'TransaksiController::index', ['filter' => 'auth']);
$routes->group('keranjang', ['filter' => 'auth'], function ($routes) {
    $routes->get('', 'TransaksiController::index');
    $routes->post('', 'TransaksiController::cart_add');
    $routes->post('edit', 'TransaksiController::cart_edit');
    $routes->get('delete/(:any)', 'TransaksiController::cart_delete/$1');
    $routes->get('clear', 'TransaksiController::cart_clear');
});

//untuk transaksi beli dan checkout
$routes->get('checkout', 'TransaksiController::checkout', ['filter' => 'auth']);
$routes->get('getcity', 'TransaksiController::getcity', ['filter' => 'auth']);
$routes->get('getcost', 'TransaksiController::getcost', ['filter' => 'auth']);
$routes->post('buy', 'TransaksiController::buy', ['filter' => 'auth']);
$routes->post('transaksi/ubahStatus', 'TransaksiController::ubahStatus', ['filter' => 'auth:admin']);





//menu REST (Representational State Transfer)
$routes->group('api', function ($routes) {
    $routes->post('monthly', 'ApiController::monthly');
    $routes->post('annual', 'ApiController::annual');
});
$routes->resource('apiController');

// API routes for dashboard-toko
$routes->group('api', function ($routes) {
    $routes->post('annual/transaksi', 'ApiController::annualTransaction');
    $routes->post('annual/earning', 'ApiController::annualEarning');
    $routes->post('annual/user', 'ApiController::annualUser');
});


//halaman login sebagai auth, menampilkan semua konten
$routes->get('faq', 'Home::faq', ['filter' => 'auth']);
$routes->get('transaksi', 'Home::transaksi', ['filter' => 'auth']);
$routes->get('profile', 'Home::profile', ['filter' => 'auth']);
$routes->get('contact', 'Home::contact', ['filter' => 'auth']);
