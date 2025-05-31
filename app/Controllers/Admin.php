<?php

namespace App\Controllers;

//load models
use App\Models\M_Admin;
use App\Models\M_Buku;
use App\Models\M_Kategori;
use App\Models\M_Rak;
use App\Models\M_Anggota; // Ditambahkan
use App\Models\M_Peminjaman;
use Endroid\QrCode\Builder\Builder; // This import is correct
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel; // Updated for v6.x
use Endroid\QrCode\Label\LabelAlignment;
use Endroid\QrCode\Label\Font\Font;
use Endroid\QrCode\RoundBlockSizeMode; // Updated for v6.x
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\Label\Label;

$writer = new PngWriter();


class Admin extends BaseController
{
    public function login()
    {
        return view('Backend/Login/login');
    }

    public function dashboard()
    {
        if (session()->get('ses_id') == "" || session()->get('ses_user') == "" || session()->get('ses_level') == "") {
            session()->setFlashdata('error', 'Silakan login terlebih dahulu!');
            return redirect()->to(base_url('admin/login-admin'));
        } else {
            echo view('Backend/Template/header');
            echo view('Backend/Template/sidebar');
            echo view('Backend/Login/dashboard_admin');
            echo view('Backend/Template/footer');
        }
    }

    public function autentikasi()
    {
        $modelAdmin = new M_Admin(); //proses inisiasi model
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $cekusername = $modelAdmin->getDataAdmin(['username_admin' => $username, 'is_delete_admin' => '0'])->getNumRows();
        if ($cekusername == 0) {
            session()->setFlashData('error', 'Username Tidak Ditemukan!');
            return redirect()->back()->withInput();
        } else {
            $dataUser = $modelAdmin->getDataAdmin(['username_admin' => $username, 'is_delete_admin' => '0'])->getRowArray();
            $passwordUser = $dataUser['password_admin'];

            $verifikasiPassword = password_verify($password, $passwordUser);
            if (!$verifikasiPassword) {
                session()->setFlashdata('error', 'Password Tidak Sesuai!');
                return redirect()->back()->withInput();
            } else {
                $dataSession = [
                    'ses_id' => $dataUser['id_admin'],
                    'ses_user' => $dataUser['nama_admin'],
                    'ses_level' => $dataUser['akses_level']
                ];
                session()->set($dataSession);
                session()->setFlashdata('success', 'Login Berhasil!');
                return redirect()->to(base_url('admin/dashboard-admin'));
            }
        }
    }

    public function logout()
    {
        session()->remove('ses_id');
        session()->remove('ses_user');
        session()->remove('ses_level');
        session()->setFlashdata('info', 'Anda telah keluar dari sistem!');
        return redirect()->to(base_url('admin/login-admin'));
    }

    public function input_data_admin()
    {
        if (session()->get('ses_id') == "" || session()->get('ses_user') == "" || session()->get('ses_level') == "") {
            session()->setFlashdata('error', 'Silakan login terlebih dahulu!');
            return redirect()->to(base_url('admin/login-admin'));
        } else {
            echo view('Backend/Template/header');
            echo view('Backend/Template/sidebar');
            echo view('Backend/MasterAdmin/input-admin');
            echo view('Backend/Template/footer');
        }
    }

    public function simpan_data_admin()
    {
        if (session()->get('ses_id') == "" || session()->get('ses_user') == "" || session()->get('ses_level') == "") {
            session()->setFlashdata('error', 'Silakan login terlebih dahulu!');
            return redirect()->to(base_url('admin/login-admin'));
        } else {
            $modelAdmin = new M_Admin(); // inisiasi

            $nama = $this->request->getPost('nama');
            $username = $this->request->getPost('username');
            $level = $this->request->getPost('level');

            $cekUname = $modelAdmin->getDataAdmin(['username_admin' => $username, 'is_delete_admin' => '0'])->getNumRows(); // Check non-deleted users
            if ($cekUname > 0) {
                session()->setFlashdata('error', 'Username sudah digunakan!');
                return redirect()->back()->withInput(); // Redirect back to form
            } else {
                $hasil = $modelAdmin->autoNumber()->getRowArray();
                if (!$hasil) {
                    $id = "ADM001";
                } else {
                    $kode = $hasil['id_admin'];
                    $noUrut = (int) substr($kode, -3);
                    $noUrut++;
                    $id = "ADM" . sprintf("%03s", $noUrut);
                }

                $datasimpan = [
                    'id_admin' => $id,
                    'nama_admin' => $nama,
                    'username_admin' => $username,
                    'password_admin' => password_hash('pass_admin', PASSWORD_DEFAULT),
                    'akses_level' => $level,
                    'is_delete_admin' => '0',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];
                $modelAdmin->saveDataAdmin($datasimpan);
                session()->setFlashdata('success', 'Data Admin Berhasil Ditambahkan!');
                return redirect()->to(base_url('admin/master-data-admin')); // Redirect to master data
            }
        }
    }

    public function master_data_admin()
    {
        if (session()->get('ses_id') == "" || session()->get('ses_user') == "" || session()->get('ses_level') == "") {
            session()->setFlashdata('error', 'Silakan login terlebih dahulu!');
            return redirect()->to(base_url('admin/login-admin'));
        } else {
            $modelAdmin = new M_Admin(); // inisiasi

            $uri = service('uri');
            $pages = $uri->getSegment(2);
            $dataUser = $modelAdmin->getDataAdmin(['is_delete_admin' => '0', 'akses_level !=' => '1'])->getResultArray();

            $data['pages'] = $pages;
            $data['data_user'] = $dataUser;

            echo view('Backend/Template/header', $data);
            echo view('Backend/Template/sidebar', $data);
            echo view('Backend/MasterAdmin/master-data-admin', $data);
            echo view('Backend/Template/footer', $data);
        }
    }

    public function edit_data_admin()
    {
        if (session()->get('ses_id') == "" || session()->get('ses_user') == "" || session()->get('ses_level') == "") {
            session()->setFlashdata('error', 'Silakan login terlebih dahulu!');
            return redirect()->to(base_url('admin/login-admin'));
        }

        $uri = service('uri');
        $idEdit = $uri->getSegment(3);
        $modelAdmin = new M_Admin();
        $dataAdmin = $modelAdmin->getDataAdmin(['sha1(id_admin)' => $idEdit])->getRowArray();

        if (!$dataAdmin) {
            session()->setFlashdata('error', 'Data Admin tidak ditemukan!');
            return redirect()->to(base_url('admin/master-data-admin'));
        }

        session()->set(['idUpdate' => $dataAdmin['id_admin']]);

        $page = $uri->getSegment(2);

        $data['page'] = $page;
        $data['web_title'] = "Edit Data Admin";
        $data['data_admin'] = $dataAdmin;

        echo view('Backend/Template/header', $data);
        echo view('Backend/Template/sidebar', $data);
        echo view('Backend/MasterAdmin/edit-admin', $data);
        echo view('Backend/Template/footer', $data);
    }

    public function update_data_admin()
    {
        if (session()->get('ses_id') == "" || session()->get('ses_user') == "" || session()->get('ses_level') == "") {
            session()->setFlashdata('error', 'Silakan login terlebih dahulu!');
            return redirect()->to(base_url('admin/login-admin'));
        }

        $modelAdmin = new M_Admin();
        $idUpdate = session()->get('idUpdate');

        if (!$idUpdate) {
            session()->setFlashdata('error', 'Sesi update tidak valid atau telah berakhir.');
            return redirect()->to(base_url('admin/master-data-admin'));
        }

        $nama = $this->request->getPost('nama');
        $level = $this->request->getPost('level');

        if ($nama == "" || $level == "") {
            session()->setFlashdata('error', 'Isian tidak boleh kosong!');
            return redirect()->back()->withInput();
        } else {
            $dataUpdate = [
                'nama_admin' => $nama,
                'akses_level' => $level,
                'updated_at' => date('Y-m-d H:i:s')
            ];
            $whereUpdate = ['id_admin' => $idUpdate];

            $modelAdmin->updateDataAdmin($dataUpdate, $whereUpdate);
            session()->remove('idUpdate');
            session()->setFlashdata('success', 'Data Admin Berhasil Diperbaharui!');
            return redirect()->to(base_url('admin/master-data-admin'));
        }
    }

    public function hapus_data_admin()
    {
        if (session()->get('ses_id') == "" || session()->get('ses_user') == "" || session()->get('ses_level') == "") {
            session()->setFlashdata('error', 'Silakan login terlebih dahulu!');
            return redirect()->to(base_url('admin/login-admin'));
        }

        $modelAdmin = new M_Admin();
        $uri = service('uri');
        $idHapus = $uri->getSegment(3);

        $dataUpdate = [
            'is_delete_admin' => '1',
            'updated_at' => date('Y-m-d H:i:s')
        ];
        $whereUpdate = ['sha1(id_admin)' => $idHapus];
        $modelAdmin->updateDataAdmin($dataUpdate, $whereUpdate);
        session()->setFlashdata('success', 'Data Admin Berhasil Dihapus!');
        return redirect()->to(base_url('admin/master-data-admin'));
    }

    // Awal Modul Buku
    public function master_buku()
    {
        if (session()->get('ses_id') == "" || session()->get('ses_user') == "" || session()->get('ses_level') == "") {
            session()->setFlashdata('error', 'Silakan login terlebih dahulu!');
            return redirect()->to(base_url('admin/login-admin'));
        }
        $modelBuku = new M_Buku();
        $dataBuku = $modelBuku->getDataBukuJoin(['tbl_buku.is_delete_buku' => '0'])->getResultArray();

        $uri = service('uri');
        $page = $uri->getSegment(2);

        $data['page'] = $page;
        $data['web_title'] = "Master Data Buku";
        $data['dataBuku'] = $dataBuku;

        echo view('Backend/Template/header', $data);
        echo view('Backend/Template/sidebar', $data);
        echo view('Backend/MasterBuku/master-data-buku', $data);
        echo view('Backend/Template/footer', $data);
    }

    public function input_buku()
    {
        if (session()->get('ses_id') == "" || session()->get('ses_user') == "" || session()->get('ses_level') == "") {
            session()->setFlashdata('error', 'Silakan login terlebih dahulu!');
            return redirect()->to(base_url('admin/login-admin'));
        }
        $modelKategori = new M_Kategori();
        $modelRak = new M_Rak();
        $uri = service('uri');
        $page = $uri->getSegment(2);

        $data['page'] = $page;
        $data['web_title'] = "Input Data Buku";
        $data['data_kategori'] = $modelKategori->getDataKategori(['is_delete_kategori' => '0'])->getResultArray();
        $data['data_rak'] = $modelRak->getDataRak(['is_delete_rak' => '0'])->getResultArray();

        echo view('Backend/Template/header', $data);
        echo view('Backend/Template/sidebar', $data);
        echo view('Backend/MasterBuku/input-buku', $data);
        echo view('Backend/Template/footer', $data);
    }

    public function simpan_buku()
    {
        if (session()->get('ses_id') == "" || session()->get('ses_user') == "" || session()->get('ses_level') == "") {
            session()->setFlashdata('error', 'Silakan login terlebih dahulu!');
            return redirect()->to(base_url('admin/login-admin'));
        }

        $modelBuku = new M_Buku();

        $judulBuku = $this->request->getPost('judul_buku');
        $pengarang = $this->request->getPost('pengarang');
        $penerbit = $this->request->getPost('penerbit');
        $tahun = $this->request->getPost('tahun');
        $jumlahEksemplar = $this->request->getPost('jumlah_eksemplar');
        $kategoriBuku = $this->request->getPost('kategori_buku');
        $keterangan = $this->request->getPost('keterangan');
        $rak = $this->request->getPost('rak');

        if (!$this->validate([
            'cover_buku' => 'uploaded[cover_buku]|max_size[cover_buku,1024]|ext_in[cover_buku,jpg,jpeg,png]',
            'e_book' => 'uploaded[e_book]|max_size[e_book,10240]|ext_in[e_book,pdf]',
        ])) {
            // Get all errors
            $errors = $this->validator->getErrors();
            $errorString = "";
            if (isset($errors['cover_buku'])) $errorString .= "Cover Buku: " . $errors['cover_buku'] . " ";
            if (isset($errors['e_book'])) $errorString .= "E-Book: " . $errors['e_book'];
            
            if(empty($errorString)) $errorString = "Terjadi kesalahan validasi file.";

            session()->setFlashdata('error', trim($errorString));
            return redirect()->to(base_url('admin/input-buku'))->withInput();
        }

        $coverBuku = $this->request->getFile('cover_buku');
        $ext1 = $coverBuku->getClientExtension();
        $namaFile1 = "Cover-Buku-" . date("ymdhis") . "." . $ext1;
        $coverBuku->move(FCPATH . 'Assets/CoverBuku', $namaFile1); // Save to public/Assets/CoverBuku

        $eBook = $this->request->getFile('e_book');
        $ext2 = $eBook->getClientExtension();
        $namaFile2 = "E-Book-" . date("ymdhis") . "." . $ext2;
        $eBook->move(FCPATH . 'Assets/E-Book', $namaFile2); // Save to public/Assets/E-Book

        $hasil = $modelBuku->autoNumber()->getRowArray();
        if (!$hasil) {
            $id = "BKU001";
        } else {
            $kode = $hasil['id_buku'];
            $noUrut = (int) substr($kode, -3);
            $noUrut++;
            $id = "BKU" . sprintf("%03s", $noUrut);
        }
        $dataSimpan = [
            'id_buku' => $id,
            'judul_buku' => ucwords($judulBuku),
            'pengarang' => ucwords($pengarang),
            'penerbit' => ucwords($penerbit),
            'tahun' => $tahun,
            'jumlah_eksemplar' => $jumlahEksemplar,
            'id_kategori' => $kategoriBuku,
            'keterangan' => $keterangan,
            'id_rak' => $rak,
            'cover_buku' => $namaFile1,
            'e_book' => $namaFile2,
            'is_delete_buku' => '0',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $modelBuku->saveDataBuku($dataSimpan);
        session()->setFlashdata('success', 'Data Buku Berhasil Ditambahkan!'); // Changed from Diperbaharui
        return redirect()->to(base_url('admin/master-buku'));
    }

    public function hapus_buku()
    {
        if (session()->get('ses_id') == "" || session()->get('ses_user') == "" || session()->get('ses_level') == "") {
            session()->setFlashdata('error', 'Silakan login terlebih dahulu!');
            return redirect()->to(base_url('admin/login-admin'));
        }

        $modelBuku = new M_Buku();
        $uri = service('uri');
        $idHapus = $uri->getSegment(3); // This should be sha1(id_buku) as per edit_buku pattern

        // Important: Assuming idHapus is sha1(id_buku)
        $dataHapus = $modelBuku->getDataBuku(['sha1(id_buku)' => $idHapus])->getRowArray();

        if ($dataHapus) {
            // Use FCPATH for consistency, assuming Assets is in public directory
            if (!empty($dataHapus['cover_buku']) && file_exists(FCPATH . 'Assets/CoverBuku/' . $dataHapus['cover_buku'])) {
                unlink(FCPATH . 'Assets/CoverBuku/' . $dataHapus['cover_buku']);
            }
            if (!empty($dataHapus['e_book']) && file_exists(FCPATH . 'Assets/E-Book/' . $dataHapus['e_book'])) {
                unlink(FCPATH . 'Assets/E-Book/' . $dataHapus['e_book']);
            }
            // Use the actual ID for deletion, not the hash
            $modelBuku->hapusDataBuku(['id_buku' => $dataHapus['id_buku']]);
            session()->setFlashdata('success', 'Data Buku Berhasil Dihapus!');
        } else {
            session()->setFlashdata('error', 'Data Buku tidak ditemukan!');
        }
        return redirect()->to(base_url('admin/master-buku')); // Corrected redirect
    }

    public function edit_buku($id_buku_hashed = null)
    {
        if (session()->get('ses_id') == "" || session()->get('ses_user') == "" || session()->get('ses_level') == "") {
            session()->setFlashdata('error', 'Silakan login terlebih dahulu!');
            return redirect()->to(base_url('admin/login-admin'));
        }

        if ($id_buku_hashed === null) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('ID Buku tidak valid.');
        }

        $modelBuku = new M_Buku();
        $modelKategori = new M_Kategori();
        $modelRak = new M_Rak();

        $bukuData = $modelBuku->getDataBuku(['sha1(id_buku)' => $id_buku_hashed])->getRowArray();

        if (!$bukuData) {
            session()->setFlashdata('error', 'Data Buku tidak ditemukan!');
            return redirect()->to(base_url('admin/master-buku'));
        }

        session()->set(['idUpdateBuku' => $bukuData['id_buku']]);

        $data = [
            'web_title' => 'Edit Data Buku',
            'data_buku' => $bukuData,
            'data_kategori' => $modelKategori->getDataKategori(['is_delete_kategori' => '0'])->getResultArray(),
            'data_rak' => $modelRak->getDataRak(['is_delete_rak' => '0'])->getResultArray(),
        ];

        echo view('Backend/Template/header', $data);
        echo view('Backend/Template/sidebar', $data);
        echo view('Backend/MasterBuku/edit-buku', $data);
        echo view('Backend/Template/footer', $data);
    }

    public function update_buku()
    {
        if (session()->get('ses_id') == "" || session()->get('ses_user') == "" || session()->get('ses_level') == "") {
            session()->setFlashdata('error', 'Silakan login terlebih dahulu!');
            return redirect()->to(base_url('admin/login-admin'));
        }

        $modelBuku = new M_Buku();
        $idUpdate = session()->get('idUpdateBuku');

        if (!$idUpdate) {
            session()->setFlashdata('error', 'Sesi update buku tidak valid atau sudah berakhir!');
            return redirect()->to(base_url('admin/master-buku'));
        }

        $bukuLama = $modelBuku->getDataBuku(['id_buku' => $idUpdate])->getRowArray();
        if (!$bukuLama) {
            session()->setFlashdata('error', 'Data buku yang akan diupdate tidak ditemukan!');
            return redirect()->to(base_url('admin/master-buku'));
        }

        $judulBuku = $this->request->getPost('judul_buku');
        $pengarang = $this->request->getPost('pengarang');
        $penerbit = $this->request->getPost('penerbit');
        $tahun = $this->request->getPost('tahun');
        $jumlahEksemplar = $this->request->getPost('jumlah_eksemplar');
        $kategoriBuku = $this->request->getPost('kategori_buku');
        $keterangan = $this->request->getPost('keterangan');
        $rak = $this->request->getPost('rak');

        if (empty($judulBuku) || empty($pengarang) || empty($penerbit) || empty($tahun) || !is_numeric($jumlahEksemplar) || empty($kategoriBuku) || empty($rak)) {
            session()->setFlashdata('error', 'Semua field wajib diisi dengan benar (kecuali keterangan, cover, dan e-book)! Jumlah eksemplar harus angka.');
            return redirect()->back()->withInput();
        }

        $dataUpdate = [
            'judul_buku' => ucwords($judulBuku),
            'pengarang' => ucwords($pengarang),
            'penerbit' => ucwords($penerbit),
            'tahun' => $tahun,
            'jumlah_eksemplar' => $jumlahEksemplar,
            'id_kategori' => $kategoriBuku,
            'keterangan' => $keterangan,
            'id_rak' => $rak,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $coverBukuFile = $this->request->getFile('cover_buku');
        if ($coverBukuFile && $coverBukuFile->isValid() && !$coverBukuFile->hasMoved()) {
            if (!$this->validate(['cover_buku' => 'max_size[cover_buku,1024]|ext_in[cover_buku,jpg,jpeg,png]'])) {
                session()->setFlashdata('error', 'Cover: ' . $this->validator->getError('cover_buku'));
                return redirect()->back()->withInput();
            }
            if (!empty($bukuLama['cover_buku']) && file_exists(FCPATH . 'Assets/CoverBuku/' . $bukuLama['cover_buku'])) {
                unlink(FCPATH . 'Assets/CoverBuku/' . $bukuLama['cover_buku']);
            }
            $namaFileCover = "Cover-Buku-" . date("ymdhis") . "." . $coverBukuFile->getClientExtension();
            $coverBukuFile->move(FCPATH . 'Assets/CoverBuku', $namaFileCover); // Save to public/Assets/CoverBuku
            $dataUpdate['cover_buku'] = $namaFileCover;
        }

        $eBookFile = $this->request->getFile('e_book');
        if ($eBookFile && $eBookFile->isValid() && !$eBookFile->hasMoved()) {
            if (!$this->validate(['e_book' => 'max_size[e_book,10240]|ext_in[e_book,pdf]'])) {
                session()->setFlashdata('error', 'E-Book: ' . $this->validator->getError('e_book'));
                return redirect()->back()->withInput();
            }
            if (!empty($bukuLama['e_book']) && file_exists(FCPATH . 'Assets/E-Book/' . $bukuLama['e_book'])) {
                unlink(FCPATH . 'Assets/E-Book/' . $bukuLama['e_book']);
            }
            $namaFileEbook = "E-Book-" . date("ymdhis") . "." . $eBookFile->getClientExtension();
            $eBookFile->move(FCPATH . 'Assets/E-Book', $namaFileEbook); // Save to public/Assets/E-Book
            $dataUpdate['e_book'] = $namaFileEbook;
        }

        $whereUpdate = ['id_buku' => $idUpdate];
        $modelBuku->updateDataBuku($dataUpdate, $whereUpdate);

        session()->remove('idUpdateBuku');
        session()->setFlashdata('success', 'Data Buku Berhasil Diperbaharui!');
        return redirect()->to(base_url('admin/master-buku'));
    }
    // Akhir Modul Buku
    public function peminjaman_step1()
    {
        if (session()->get('ses_id') == "" || session()->get('ses_user') == "" || session()->get('ses_level') == "") {
            session()->setFlashdata('error', 'Silakan login terlebih dahulu!');
            return redirect()->to(base_url('admin/login-admin'));
        }

        // Hapus session idAnggota jika ada dari transaksi sebelumnya
        session()->remove('idAnggotaPeminjaman'); // Menggunakan nama session yang lebih spesifik

        $uri = service('uri');
        $data = [
            'page' => $uri->getSegment(2) ?: 'peminjaman-step-1',
            'web_title' => "Transaksi Peminjaman - Langkah 1",
        ];

        echo view('Backend/Template/header', $data);
        echo view('Backend/Template/sidebar', $data);
        echo view('Backend/Transaksi/peminjaman_step1', $data); // View ini berisi form input id_anggota
        echo view('Backend/Template/footer', $data);
    }

    // Pertemuan VII - Langkah 2: Tampilkan detail anggota, buku, dan keranjang
    // (Gabungan logika dari OCR halaman 69-72)
    public function peminjaman_step2()
    {
        if (session()->get('ses_id') == "" || session()->get('ses_user') == "" || session()->get('ses_level') == "") {
            session()->setFlashdata('error', 'Silakan login terlebih dahulu!');
            return redirect()->to(base_url('admin/login-admin'));
        }

        $modelAnggota = new M_Anggota();
        $modelBuku = new M_Buku();
        $modelPeminjaman = new M_Peminjaman();
        $uri = service('uri');

        $idAnggota = null;
        if ($this->request->getPost('id_anggota')) {
            $idAnggota = $this->request->getPost('id_anggota');
            session()->set('idAnggotaPeminjaman', $idAnggota);
        } else {
            $idAnggota = session()->get('idAnggotaPeminjaman');
        }

        if (!$idAnggota) {
            session()->setFlashdata('error', 'ID Anggota belum diinput. Silakan mulai dari Langkah 1.');
            return redirect()->to(base_url('admin/peminjaman-step1'));
        }

        $dataAnggota = $modelAnggota->getDataAnggota(['id_anggota' => $idAnggota, 'is_delete_anggota' => '0'])->getRowArray();
        if (!$dataAnggota) {
            session()->remove('idAnggotaPeminjaman');
            session()->setFlashdata('error', 'ID Anggota tidak ditemukan atau tidak aktif. Silakan coba lagi.');
            return redirect()->to(base_url('admin/peminjaman-step1'));
        }

        // Cek apakah anggota masih punya transaksi berjalan
        $cekPeminjamanAktif = $modelPeminjaman->getDataPeminjaman([
            'id_anggota' => $idAnggota,
            'status_transaksi' => 'Berjalan'
        ])->getNumRows();

        if ($cekPeminjamanAktif > 0) {
            session()->remove('idAnggotaPeminjaman');
            session()->setFlashdata('error', 'Anggota ini masih memiliki transaksi peminjaman yang belum diselesaikan!');
            return redirect()->to(base_url('admin/peminjaman-step1'));
        }

        $dataBukuTersedia = $modelBuku->getDataBukuJoin([
            'tbl_buku.is_delete_buku' => '0',
            'tbl_buku.jumlah_eksemplar >' => 0
        ])->getResultArray();

        $keranjangPeminjaman = $modelPeminjaman->getDataTempJoin([
            'tbl_temp_peminjaman.id_anggota' => $idAnggota
        ])->getResultArray();
        
        $jumlahItemDiKeranjang = count($keranjangPeminjaman);

        $data = [
            'page' => $uri->getSegment(2) ?: 'peminjaman-step-2',
            'web_title' => 'Transaksi Peminjaman - Langkah 2',
            'anggota' => $dataAnggota,
            'buku_tersedia' => $dataBukuTersedia, // Daftar semua buku yang bisa dipinjam
            'keranjang' => $keranjangPeminjaman, // Daftar buku di tabel temp
            'jumlah_item_keranjang' => $jumlahItemDiKeranjang
        ];

        echo view('Backend/Template/header', $data);
        echo view('Backend/Template/sidebar', $data);
        echo view('Backend/Transaksi/peminjaman_step2', $data); // View ini menampilkan detail & daftar buku
        echo view('Backend/Template/footer', $data);
    }

    // Pertemuan VII - Proses simpan buku ke tabel temp peminjaman
    // (Sesuai OCR halaman 73, route GET /admin/simpan-temp-pinjam/(:alphanum))
    public function simpan_temp_pinjam($idBukuHashed = null)
    {
        if (session()->get('ses_id') == "" || session()->get('ses_user') == "" || session()->get('ses_level') == "") {
            session()->setFlashdata('error', 'Silakan login terlebih dahulu!');
            return redirect()->to(base_url('admin/login-admin'));
        }

        $modelPeminjaman = new M_Peminjaman();
        $modelBuku = new M_Buku();
        
        $idAnggota = session()->get('idAnggotaPeminjaman');

        if (!$idAnggota) {
             session()->setFlashdata('error', 'Sesi anggota tidak valid. Silakan ulangi dari Langkah 1.');
             return redirect()->to(base_url('admin/peminjaman-step-1'));
        }
        if ($idBukuHashed == null) {
            session()->setFlashdata('error', 'ID Buku tidak valid.');
            return redirect()->to(base_url('admin/peminjaman-step-2'));
        }

        $dataBuku = $modelBuku->getDataBuku(['sha1(id_buku)' => $idBukuHashed, 'is_delete_buku' => '0'])->getRowArray();
        if (!$dataBuku) {
            session()->setFlashdata('error', 'Buku tidak ditemukan atau sudah dihapus.');
            return redirect()->to(base_url('admin/peminjaman-step-2'));
        }
        if ($dataBuku['jumlah_eksemplar'] < 1) {
            session()->setFlashdata('error', 'Stok buku "' . $dataBuku['judul_buku'] . '" habis.');
            return redirect()->to(base_url('admin/peminjaman-step-2'));
        }
        
        $idBukuAsli = $dataBuku['id_buku'];

        // Cek apakah buku sudah ada di temp untuk anggota ini
        $adaDiTemp = $modelPeminjaman->getDataTemp([
            'id_buku' => $idBukuAsli,
            'id_anggota' => $idAnggota
        ])->getNumRows();

        if ($adaDiTemp > 0) {
            session()->setFlashdata('warning', 'Buku "' . $dataBuku['judul_buku'] . '" sudah ada di keranjang Anda.');
            return redirect()->to(base_url('admin/peminjaman-step-2'));
        }
        
        // Cek lagi peminjaman aktif, sebagai double check
        $adaPinjamAktif = $modelPeminjaman->getDataPeminjaman([
            'id_anggota' => $idAnggota,
            'status_transaksi' => 'Berjalan'
        ])->getNumRows();
        if($adaPinjamAktif > 0){
            session()->setFlashdata('error', 'Masih ada transaksi peminjaman yang belum diselesaikan!');
            return redirect()->to(base_url('admin/peminjaman-step1'));
        }

        // Simpan ke temp
        $dataTemp = [
            'id_anggota' => $idAnggota,
            'id_buku' => $idBukuAsli,
            // 'tgl_temp' => date('Y-m-d H:i:s'), // M_Peminjaman mungkin punya default created_at
            'jumlah_temp' => 1 // Asumsi selalu 1 per penambahan
        ];
        $modelPeminjaman->saveDataTemp($dataTemp); // Asumsi method ini adalah insert ke tbl_temp_peminjaman

        // Kurangi stok buku
        $stokBaru = $dataBuku['jumlah_eksemplar'] - 1;
        $modelBuku->updateDataBuku(['jumlah_eksemplar' => $stokBaru], ['id_buku' => $idBukuAsli]);

        session()->setFlashdata('success', 'Buku "' . $dataBuku['judul_buku'] . '" berhasil ditambahkan ke keranjang.');
        return redirect()->to(base_url('admin/peminjaman-step-2'));
    }

    // Pertemuan VII - Proses hapus buku dari tabel temp peminjaman dan kembalikan stok
    // (Sesuai OCR halaman 74, route GET /admin/hapus-temp/(:alphanum), di OCR disebut hapus_peminjaman)
    // Saya akan menggunakan nama hapus_temp_item untuk lebih jelas
    public function hapus_temp_item($idBukuHashed = null)
    {
        if (session()->get('ses_id') == "" || session()->get('ses_user') == "" || session()->get('ses_level') == "") {
            session()->setFlashdata('error', 'Silakan login terlebih dahulu!');
            return redirect()->to(base_url('admin/login-admin'));
        }

        $modelPeminjaman = new M_Peminjaman();
        $modelBuku = new M_Buku();
        $idAnggota = session()->get('idAnggotaPeminjaman');

        if (!$idAnggota) {
             session()->setFlashdata('error', 'Sesi anggota tidak valid.');
             return redirect()->to(base_url('admin/peminjaman-step1'));
        }
        if ($idBukuHashed == null) {
            session()->setFlashdata('error', 'ID Buku tidak valid untuk dihapus.');
            return redirect()->to(base_url('admin/peminjaman-step-2'));
        }

        $dataBuku = $modelBuku->getDataBuku(['sha1(id_buku)' => $idBukuHashed])->getRowArray();
        if (!$dataBuku) {
            session()->setFlashdata('error', 'Data buku yang akan dihapus dari keranjang tidak ditemukan!');
            return redirect()->to(base_url('admin/peminjaman-step-2'));
        }
        $idBukuAsli = $dataBuku['id_buku'];

        // Hapus dari temp
        $modelPeminjaman->hapusDataTemp([
            'id_buku' => $idBukuAsli, // Hapus berdasarkan ID asli
            'id_anggota' => $idAnggota
        ]);

        // Kembalikan stok buku
        $stokBaru = $dataBuku['jumlah_eksemplar'] + 1;
        $modelBuku->updateDataBuku(['jumlah_eksemplar' => $stokBaru], ['id_buku' => $idBukuAsli]);

        session()->setFlashdata('info', 'Buku "' . $dataBuku['judul_buku'] . '" telah dihapus dari keranjang.');
        return redirect()->to(base_url('admin/peminjaman-step-2'));
    }

    public function simpan_transaksi_peminjaman()
    {
        $modelPeminjaman = new M_Peminjaman();
        $idPeminjaman = date("ymdhis");
        $time_sekarang = time();
        $tgl_kembali = date("Y-m-d", strtotime("+7 days", $time_sekarang));
        $idAnggota = session()->get('idAnggotaPeminjaman');
        $itemDiKeranjang = $modelPeminjaman->getDataTemp(['id_anggota' => $idAnggota])->getResultArray();
        $jumlahPinjam = count($itemDiKeranjang);

        // QR Code config
        $dataQR = $idPeminjaman;
        $labelQR = "No: " . $idPeminjaman;
        $logoPath = FCPATH . 'Assets/logo_ubsi.png';
        $qrPathDir = FCPATH . 'Assets/qr_code/';
        if (!is_dir($qrPathDir)) {
            mkdir($qrPathDir, 0775, true);
        }
        $namaQR = "qr_" . $idPeminjaman . ".png";

        // QR Code generation (tanpa builder, langsung pakai QrCode)
        $qrCode = new QrCode(
            data: $dataQR,
            encoding: new Encoding('UTF-8'),
            errorCorrectionLevel: ErrorCorrectionLevel::Low,
            size: 300,
            margin: 10,
            roundBlockSizeMode: RoundBlockSizeMode::Margin,
            foregroundColor: new Color(0, 0, 0),
            backgroundColor: new Color(255, 255, 255)
        );
        $logo = null;
        if (file_exists($logoPath)) {
            $logo = new Logo(
                path: $logoPath,
                resizeToWidth: 50,
                punchoutBackground: true
            );
        }
        $fontPath = FCPATH . 'Assets/fonts/glyphicons-halflings-regular.ttf';
        $font = new Font($fontPath, 16);
        $label = new Label(
            text: $labelQR,
            font: $font,
            textColor: new Color(255, 0, 0)
        );
        $writer = new PngWriter();
        $result = $writer->write($qrCode, $logo, $label);
        $result->saveToFile($qrPathDir . $namaQR);

        // Simpan ke tabel peminjaman utama (tbl_peminjaman)
        $dataPeminjamanUtama = [
            'no_peminjaman' => $idPeminjaman,
            'id_anggota' => $idAnggota,
            'tgl_pinjam' => date('Y-m-d'),
            'total_pinjam' => $jumlahPinjam,
            'id_admin' => session()->get('ses_id'),
            'status_transaksi' => 'Berjalan',
            'status_ambil_buku' => 'Sudah Diambil',
            'qr_code' => $namaQR
        ];
        $modelPeminjaman->saveDataPeminjaman($dataPeminjamanUtama);

        // Simpan ke tabel detail peminjaman (tbl_detail_peminjaman)
        $detailPeminjamanBatch = [];
        foreach ($itemDiKeranjang as $item) {
            $detailPeminjamanBatch[] = [
                'no_peminjaman' => $idPeminjaman,
                'id_buku' => $item['id_buku'],
                'status_pinjam' => 'Sedang Dipinjam',
                'tgl_kembali' => $tgl_kembali,
            ];
        }
        if (!empty($detailPeminjamanBatch)) {
            $modelPeminjaman->saveDataDetail($detailPeminjamanBatch);
        }

        // Hapus data dari tabel temp
        $modelPeminjaman->hapusDataTemp(['id_anggota' => $idAnggota]);
        session()->remove('idAnggotaPeminjaman');
        session()->setFlashdata('success', 'Transaksi peminjaman buku No. ' . $idPeminjaman . ' berhasil disimpan!');
        return redirect()->to(base_url('admin/data-transaksi-peminjaman')); // (Sesuai OCR hal 76)
    }

    // Untuk menampilkan data transaksi yang sudah ada
    // (Mirip dengan yang sudah ada di kode Anda, disesuaikan sedikit untuk konteks)
    public function data_transaksi_peminjaman()
    {
        if (session()->get('ses_id') == "" || session()->get('ses_user') == "" || session()->get('ses_level') == "") {
            session()->setFlashdata('error', 'Silakan login terlebih dahulu!');
            return redirect()->to(base_url('admin/login-admin'));
        }
        $modelPeminjaman = new M_Peminjaman();
        $modelBuku = new M_Buku(); // Untuk mengambil judul buku

        $dataPeminjamanUtama = $modelPeminjaman->getDataPeminjamanJoin()->getResultArray(); // Join dengan anggota & admin
        
        $dataTransaksiLengkap = [];
        foreach ($dataPeminjamanUtama as $transaksi) {
            $detailBuku = $modelPeminjaman->getDataDetail(['no_peminjaman' => $transaksi['no_peminjaman']])->getResultArray();
            $judulBukuDipinjam = [];
            foreach ($detailBuku as $detail) {
                $bukuInfo = $modelBuku->getDataBuku(['id_buku' => $detail['id_buku']])->getRowArray();
                if ($bukuInfo) {
                    $judulBukuDipinjam[] = $bukuInfo['judul_buku'];
                }
            }
            $transaksi['daftar_judul_buku'] = implode(', ', $judulBukuDipinjam);
            $dataTransaksiLengkap[] = $transaksi;
        }

        $uri = service('uri');
        $data = [
            'page' => $uri->getSegment(2) ?: 'data-transaksi-peminjaman',
            'web_title' => "Data Transaksi Peminjaman",
            'data_peminjaman' => $dataTransaksiLengkap
        ];

        echo view('Backend/Template/header', $data);
        echo view('Backend/Template/sidebar', $data);
        echo view('Backend/Transaksi/data-peminjaman', $data); // View untuk menampilkan daftar transaksi
        echo view('Backend/Template/footer', $data);
    }
    public function detail_transaksi_peminjaman($no_peminjaman = null)
    {
        if (session()->get('ses_id') == "" || session()->get('ses_user') == "" || session()->get('ses_level') == "") {
            session()->setFlashdata('error', 'Silakan login terlebih dahulu!');
            return redirect()->to(base_url('admin/login-admin'));
        }

        if ($no_peminjaman === null) {
            session()->setFlashdata('error', 'Nomor peminjaman tidak valid.');
            return redirect()->to(base_url('admin/data-transaksi-peminjaman'));
        }

        $modelPeminjaman = new M_Peminjaman();
        $modelBuku = new M_Buku();

        // Ambil data peminjaman utama (join dengan anggota dan admin)
        $transaksi = $modelPeminjaman->getDataPeminjamanJoin(['tbl_peminjaman.no_peminjaman' => $no_peminjaman])->getRowArray();

        if (!$transaksi) {
            session()->setFlashdata('error', 'Data transaksi peminjaman tidak ditemukan.');
            return redirect()->to(base_url('admin/data-transaksi-peminjaman'));
        }

        // Ambil detail buku yang dipinjam
        $detailItems = $modelPeminjaman->getDataDetail(['no_peminjaman' => $no_peminjaman])->getResultArray();
        $bukuDipinjam = [];
        foreach ($detailItems as $item) {
            $bukuInfo = $modelBuku->getDataBuku(['id_buku' => $item['id_buku']])->getRowArray();
            if ($bukuInfo) {
                $item['judul_buku'] = $bukuInfo['judul_buku'];
                $item['pengarang'] = $bukuInfo['pengarang'];
                // Tambahkan info lain jika perlu
            }
            $bukuDipinjam[] = $item;
        }
        $transaksi['detail_buku'] = $bukuDipinjam;

        $data = [
            'page' => 'detail-transaksi-peminjaman',
            'web_title' => "Detail Transaksi Peminjaman - " . $no_peminjaman,
            'transaksi' => $transaksi
        ];

        echo view('Backend/Template/header', $data);
        echo view('Backend/Template/sidebar', $data);
        echo view('Backend/Transaksi/detail-transaksi-peminjaman', $data); // View baru untuk detail
        echo view('Backend/Template/footer', $data);
    }
}

