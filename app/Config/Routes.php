<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Admin::login');
$routes->get('/home/coba-parameter/(:alpha)/(:num)/(:alphanum)', 'home::belajar_segment/$1/$2/$3');
$routes->get('/percabangan', 'Home::percabangan');
$routes->get('/perulangan', 'Home::perulangan');
$routes->get('/admin/login-admin', 'Admin::login');
$routes->get('/admin/dashboard-admin', 'Admin::dashboard');
$routes->post('/admin/autentikasi-login', 'Admin::autentikasi');
$routes->get('/admin/logout', 'Admin::logout');
//routes module admin
$routes->get('/admin/master-data-admin', 'Admin::master_data_admin');
$routes->get('/admin/input-data-admin', 'Admin::input_data_admin');
$routes->post('/admin/simpan-admin', 'Admin::simpan_data_admin');
$routes->get('/admin/edit-data-admin/(:alphanum)', 'Admin::edit_data_admin/$1');
$routes->post('/admin/update-admin', 'Admin::update_data_admin');
$routes->get('/admin/hapus-data-admin/(:alphanum)', 'Admin::hapus_data_admin/$1');
// Routes untuk Anggota
$routes->get('/admin/master-anggota', 'Admin::master_anggota');
$routes->get('/admin/input-anggota', 'Admin::input_anggota');
$routes->post('/admin/simpan-anggota', 'Admin::simpan_anggota');
$routes->get('/admin/edit-anggota/(:segment)', 'Admin::edit_anggota/$1');
$routes->post('/admin/update-anggota', 'Admin::update_anggota');
$routes->get('/admin/hapus-anggota/(:segment)', 'Admin::hapus_anggota/$1');
//buku
$routes->get('/admin/master-buku', 'Admin::master_buku');
$routes->get('/admin/edit-buku/(:alphanum)', 'Admin::edit_buku/$1');
$routes->post('/admin/update-buku', 'Admin::update_buku');
$routes->get('/admin/hapus-buku/(:alphanum)', 'Admin::hapus_buku/$1');
$routes->get('/admin/input-buku', 'Admin::input_buku');
$routes->post('/admin/simpan-buku', 'Admin::simpan_buku');
// Routes untuk Rak
$routes->get('/admin/master-rak', 'Admin::master_rak');
$routes->get('/admin/input-rak', 'Admin::input_rak');
$routes->post('/admin/simpan-rak', 'Admin::simpan_rak');
$routes->get('/admin/edit-rak/(:segment)', 'Admin::edit_rak/$1');
$routes->post('/admin/update-rak', 'Admin::update_rak');
$routes->get('/admin/hapus-rak/(:segment)', 'Admin::hapus_rak/$1');

// Routes untuk Kategori
$routes->get('/admin/master-kategori', 'Admin::master_kategori');
$routes->get('/admin/input-kategori', 'Admin::input_kategori');
$routes->post('/admin/simpan-kategori', 'Admin::simpan_kategori');
$routes->get('/admin/edit-kategori/(:segment)', 'Admin::edit_kategori/$1');
$routes->post('/admin/update-kategori', 'Admin::update_kategori');
$routes->get('/admin/hapus-kategori/(:segment)', 'Admin::hapus_kategori/$1');

// peminjaman
$routes->get('/admin/data-transaksi-peminjaman', 'Admin::data_transaksi_peminjaman');
$routes->get('/admin/peminjaman-step-1', 'Admin::peminjaman_step1');
$routes->get('/admin/tes-qr', 'Admin::tes_qr');
$routes->get('/admin/peminjaman-step-2', 'Admin::peminjaman_step2');
$routes->post('/admin/peminjaman-step-2', 'Admin::peminjaman_step2'); // Handles POST from step 1
$routes->get('/admin/simpan-temp-pinjam/(:alphanum)', 'Admin::simpan_temp_pinjam/$1');
$routes->get('/admin/hapus-temp-pinjam/(:alphanum)', 'Admin::hapus_temp_pinjam/$1'); // Corrected route name
$routes->post('/admin/simpan-transaksi-peminjaman', 'Admin::simpan_transaksi_peminjaman');

