<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// ======================================================
// RUTE HALAMAN DEPAN
// ======================================================
$routes->get('/', 'Home::index');


// ======================================================
// RUTE AUTENTIKASI
// ======================================================
$routes->get('login', 'AuthController::login');
$routes->post('login', 'AuthController::attemptLogin');

$routes->get('admin/login', 'AuthController::adminLogin');
$routes->post('admin/login', 'AuthController::attemptAdminLogin');

$routes->get('logout', 'AuthController::logout');


// ======================================================
// RUTE REGISTRASI MANDIRI USER
// User daftar sendiri, lalu menunggu approval admin
// ======================================================
$routes->get('register', 'RegisterController::index');
$routes->post('register/store', 'RegisterController::store');
$routes->get('register/success', 'RegisterController::success');


// ======================================================
// RUTE PROXY WILAYAH PUBLIK
// Dipakai oleh form register mandiri
// ======================================================
$routes->get('wilayah/proxy', 'WilayahPublicController::proxy');


// ======================================================
// GRUP ADMIN PUSAT
// Harus login dan harus admin
// ======================================================
$routes->group('admin', ['filter' => ['isLoggedIn', 'isAdmin']], function ($routes) {

    // Dashboard admin
    $routes->get('dashboard', 'AdminController::index');

    // Daftar akun PKK yang sudah approved
    $routes->get('users', 'AdminController::users');
    $routes->get('users/detail/(:num)', 'AdminController::detailUser/$1');

    // Approval pendaftaran mandiri user
    $routes->get('users/pending', 'AdminController::pendingUsers');
    $routes->get('users/approve/(:num)', 'AdminController::approveUser/$1');
    $routes->post('users/reject/(:num)', 'AdminController::rejectUser/$1');

    // Hapus akun PKK aktif
    $routes->get('users/delete/(:num)', 'AdminController::deleteUser/$1');
});


// ======================================================
// GRUP KETUA PKK DESA
// Harus login dan harus role ketua_pkk
// ======================================================
$routes->group('pkk', ['filter' => ['isLoggedIn', 'isPkk']], function ($routes) {

    // Dashboard PKK
    $routes->get('dashboard', 'PkkController::index');
    $routes->get('export-all', 'PkkController::exportAll');

    // ==================================================
    // MODUL PENDUDUK
    // ==================================================
    $routes->get('penduduk', 'PendudukController::index');
    $routes->get('penduduk/export', 'PendudukController::export');
    $routes->get('penduduk/create', 'PendudukController::create');
    $routes->post('penduduk/store', 'PendudukController::store');
    $routes->get('penduduk/detail/(:any)', 'PendudukController::detail/$1');
    $routes->get('penduduk/edit/(:any)', 'PendudukController::edit/$1');
    $routes->post('penduduk/update/(:any)', 'PendudukController::update/$1');
    $routes->get('penduduk/delete/(:any)', 'PendudukController::delete/$1');


    // ==================================================
    // MODUL KELAHIRAN
    // ==================================================
    $routes->get('kelahiran', 'KelahiranController::index');
    $routes->get('kelahiran/export', 'KelahiranController::export');
    $routes->get('kelahiran/create', 'KelahiranController::create');
    $routes->post('kelahiran/store', 'KelahiranController::store');
    $routes->get('kelahiran/detail/(:any)', 'KelahiranController::detail/$1');
    $routes->get('kelahiran/edit/(:any)', 'KelahiranController::edit/$1');
    $routes->post('kelahiran/update/(:any)', 'KelahiranController::update/$1');
    $routes->get('kelahiran/delete/(:any)', 'KelahiranController::delete/$1');


    // ==================================================
    // MODUL KEMATIAN
    // ==================================================
    $routes->get('kematian', 'KematianController::index');
    $routes->get('kematian/export', 'KematianController::export');
    $routes->get('kematian/create', 'KematianController::create');
    $routes->post('kematian/store', 'KematianController::store');
    $routes->get('kematian/edit/(:num)', 'KematianController::edit/$1');
    $routes->post('kematian/update/(:num)', 'KematianController::update/$1');
    $routes->get('kematian/delete/(:num)', 'KematianController::delete/$1');


    // ==================================================
    // MODUL LANSIA
    // ==================================================
    $routes->get('lansia', 'LansiaController::index');
    $routes->get('lansia/export', 'LansiaController::export');
    $routes->get('lansia/create', 'LansiaController::create');
    $routes->post('lansia/store', 'LansiaController::store');
    $routes->get('lansia/edit/(:num)', 'LansiaController::edit/$1');
    $routes->post('lansia/update/(:num)', 'LansiaController::update/$1');
    $routes->get('lansia/delete/(:num)', 'LansiaController::delete/$1');


    // ==================================================
    // API WILAYAH LAMA UNTUK AREA PKK
    // Ini bukan API untuk pihak luar.
    // Ini hanya endpoint internal untuk dropdown wilayah lama.
    // ==================================================
    $routes->get('api/provinsi', 'WilayahController::getProvinsi');
    $routes->get('api/kabupaten', 'WilayahController::getKabupaten');
    $routes->get('api/kecamatan', 'WilayahController::getKecamatan');
    $routes->get('api/desa', 'WilayahController::getDesa');
});