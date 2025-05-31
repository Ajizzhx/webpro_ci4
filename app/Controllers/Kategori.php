<?php

namespace App\Controllers;

use App\Models\M_Kategori; // Load Model Kategori

class Kategori extends BaseController
{
    // Method untuk menampilkan form input data kategori
    public function input_data_kategori()
    {
        // Cek session admin
        if (session()->get('ses_id') == "" || session()->get('ses_user') == "" || session()->get('ses_level') == "") {
            session()->setFlashdata('error', 'Silakan login terlebih dahulu!');
?>
            <script>
                document.location = "<?= base_url('admin/login-admin'); ?>";
            </script>
        <?php
        } else {
            // Tampilkan view form input kategori
            echo view('Backend/Template/header');
            echo view('Backend/Template/sidebar');
            echo view('Backend/MasterKategori/input-kategori'); // View untuk input kategori
            echo view('Backend/Template/footer');
        }
    }

    // Method untuk menyimpan data kategori baru
    public function simpan_data_kategori()
    {
        // Cek session admin
        if (session()->get('ses_id') == "" || session()->get('ses_user') == "" || session()->get('ses_level') == "") {
            session()->setFlashdata('error', 'Silakan login terlebih dahulu!');
?>
            <script>
                document.location = "<?= base_url('admin/login-admin'); ?>";
            </script>
            <?php
        } else {
            $modelKategori = new M_Kategori(); // Inisiasi model Kategori

            // Ambil data dari form POST
            $nama_kategori = $this->request->getPost('nama_kategori');

            // Validasi dasar (tidak boleh kosong)
            if (empty($nama_kategori)) {
                session()->setFlashdata('error', 'Nama Kategori tidak boleh kosong!');
            ?>
                <script> history.go(-1); </script>
            <?php
                return;
            }

            // Generate ID Kategori otomatis
            $hasil = $modelKategori->autoNumber()->getRowArray();
            if (!$hasil) {
                $id = "KAT001"; // ID awal jika tabel kosong
            } else {
                $kode = $hasil['id_kategori'];
                $noUrut = (int)substr($kode, -3);
                $noUrut++;
                $id = "KAT" . sprintf("%03s", $noUrut); // Format ID berikutnya
            }

            // Siapkan data untuk disimpan
            $datasimpan = [
                'id_kategori' => $id,
                'nama_kategori' => $nama_kategori,
                'is_delete_kategori' => '0', // Default status aktif
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            // Simpan data menggunakan model
            $simpan = $modelKategori->saveDataKategori($datasimpan);

            if ($simpan) {
                session()->setFlashdata('success', 'Data Kategori Berhasil Ditambahkan!!');
                // Redirect ke halaman master data kategori
            ?>
                <script>
                    document.location = "<?= base_url('kategori/master-data-kategori'); ?>";
                </script>
            <?php
            } else {
                 session()->setFlashdata('error', 'Gagal menambahkan data Kategori!');
            ?>
                 <script> history.go(-1); </script>
            <?php
            }
        }
    }

    // Method untuk menampilkan daftar data kategori
    public function master_data_kategori()
    {
        // Cek session admin
        if (session()->get('ses_id') == "" || session()->get('ses_user') == "" || session()->get('ses_level') == "") {
            session()->setFlashdata('error', 'Silakan login terlebih dahulu!');
        ?>
            <script>
                document.location = "<?= base_url('admin/login-admin'); ?>";
            </script>
        <?php
        } else {
            $modelKategori = new M_Kategori(); // Inisiasi model

            $uri = service('uri');
            $pages = $uri->getSegment(2); // Ambil segmen URI

            // Ambil semua data kategori yang tidak dihapus (is_delete_kategori = '0')
            $dataKategori = $modelKategori->getDataKategori(['is_delete_kategori' => '0'])->getResultArray();

            // Siapkan data untuk dikirim ke view
            $data['pages'] = $pages;
            $data['data_kategori'] = $dataKategori; // Kirim data kategori ke view
            $data['web_title'] = "Master Data Kategori"; // Judul halaman

            // Tampilkan view master data kategori
            echo view('Backend/Template/header', $data);
            echo view('Backend/Template/sidebar', $data);
            echo view('Backend/MasterKategori/master-data-kategori', $data); // View tabel data kategori
            echo view('Backend/Template/footer', $data);
        }
    }

    // Method untuk menampilkan form edit data kategori
    public function edit_data_kategori()
    {
        // Cek session admin
        if (session()->get('ses_id') == "" || session()->get('ses_user') == "" || session()->get('ses_level') == "") {
             session()->setFlashdata('error', 'Silakan login terlebih dahulu!');
        ?>
             <script> document.location = "<?= base_url('admin/login-admin'); ?>"; </script>
        <?php
             return;
        }

        $uri = service('uri');
        $idEdit = $uri->getSegment(3); // Ambil ID dari URL (hash sha1)
        $modelKategori = new M_Kategori();

        // Ambil data kategori berdasarkan ID yang di-hash
        $dataKategori = $modelKategori->getDataKategori(['sha1(id_kategori)' => $idEdit])->getRowArray();

        // Jika data tidak ditemukan
        if (!$dataKategori) {
            session()->setFlashdata('error', 'Data Kategori tidak ditemukan!');
            ?> <script> document.location = "<?= base_url('kategori/master-data-kategori'); ?>"; </script> <?php
            return;
        }

        // Simpan ID asli ke session untuk proses update
        session()->set(['idUpdateKategori' => $dataKategori['id_kategori']]); // Gunakan nama session unik

        $page = $uri->getSegment(2); // Ambil segmen URI

        // Siapkan data untuk view edit
        $data['page'] = $page;
        $data['web_title'] = "Edit Data Kategori";
        $data['data_kategori'] = $dataKategori; // Kirim data kategori ke view

        // Tampilkan view form edit
        echo view('Backend/Template/header', $data);
        echo view('Backend/Template/sidebar', $data);
        echo view('Backend/MasterKategori/edit-kategori', $data); // View untuk edit kategori
        echo view('Backend/Template/footer', $data);
    }

    // Method untuk memproses update data kategori
    public function update_data_kategori()
    {
        // Cek session admin
        if (session()->get('ses_id') == "" || session()->get('ses_user') == "" || session()->get('ses_level') == "") {
             session()->setFlashdata('error', 'Silakan login terlebih dahulu!');
        ?>
             <script> document.location = "<?= base_url('admin/login-admin'); ?>"; </script>
        <?php
             return;
        }

        $modelKategori = new M_Kategori();

        // Ambil ID dari session yang disimpan saat edit
        $idUpdate = session()->get('idUpdateKategori');

        // Jika ID tidak ada di session
        if (!$idUpdate) {
            session()->setFlashdata('error', 'Sesi update tidak valid!');
            ?> <script> document.location = "<?= base_url('kategori/master-data-kategori'); ?>"; </script> <?php
            return;
        }

        // Ambil data dari form POST
        $nama_kategori = $this->request->getPost('nama_kategori');

        // Validasi dasar (tidak boleh kosong)
        if (empty($nama_kategori)) {
            session()->setFlashdata('error', 'Nama Kategori tidak boleh kosong!');
        ?>
            <script>
                history.go(-1); // Kembali ke halaman edit
            </script>
            <?php
        } else {
            // Siapkan data untuk diupdate
            $dataUpdate = [
                'nama_kategori' => $nama_kategori,
                'updated_at' => date('Y-m-d H:i:s') // Update waktu terakhir diubah
            ];
            $whereUpdate = ['id_kategori' => $idUpdate]; // Kondisi WHERE berdasarkan ID

            // Lakukan update menggunakan model
            $update = $modelKategori->updateDataKategori($dataUpdate, $whereUpdate);

            // Hapus ID dari session setelah update
            session()->remove('idUpdateKategori');

            if($update){
                session()->setFlashdata('success', 'Data Kategori Berhasil Diperbaharui!');
                // Redirect ke halaman master data
            ?>
                <script>
                    document.location = "<?= base_url('kategori/master-data-kategori'); ?>";
                </script>
            <?php
            } else {
                session()->setFlashdata('error', 'Gagal memperbaharui data Kategori!');
            ?>
                <script> history.go(-1); </script>
            <?php
            }
        }
    }

    // Method untuk menghapus data kategori (soft delete)
    public function hapus_data_kategori()
    {
        // Cek session admin
        if (session()->get('ses_id') == "" || session()->get('ses_user') == "" || session()->get('ses_level') == "") {
             session()->setFlashdata('error', 'Silakan login terlebih dahulu!');
        ?>
             <script> document.location = "<?= base_url('admin/login-admin'); ?>"; </script>
        <?php
             return;
        }

        $modelKategori = new M_Kategori();

        $uri = service('uri');
        $idHapus = $uri->getSegment(3); // Ambil ID dari URL (hash sha1)

        // Siapkan data untuk update (mengubah flag is_delete)
        $dataUpdate = [
            'is_delete_kategori' => '1', // Ubah status menjadi dihapus
            'updated_at' => date('Y-m-d H:i:s')
        ];
        $whereUpdate = ['sha1(id_kategori)' => $idHapus]; // Kondisi WHERE berdasarkan ID yang di-hash

        // Lakukan update (soft delete)
        $hapus = $modelKategori->updateDataKategori($dataUpdate, $whereUpdate);

        if($hapus){
            session()->setFlashdata('success', 'Data Kategori Berhasil Dihapus!');
        } else {
            session()->setFlashdata('error', 'Gagal menghapus data Kategori!');
        }

        // Redirect ke halaman master data
        ?>
        <script>
            document.location = "<?= base_url('kategori/master-data-kategori'); ?>";
        </script>
    <?php
    }
}
