<?php

namespace App\Controllers;

use App\Models\M_Rak; // Load Model Rak

class Rak extends BaseController
{
    // Method untuk menampilkan form input data rak
    public function input_data_rak()
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
            // Tampilkan view form input rak
            echo view('Backend/Template/header');
            echo view('Backend/Template/sidebar');
            echo view('Backend/MasterRak/input-rak'); // View untuk input rak
            echo view('Backend/Template/footer');
        }
    }

    // Method untuk menyimpan data rak baru
    public function simpan_data_rak()
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
            $modelRak = new M_Rak(); // Inisiasi model Rak

            // Ambil data dari form POST
            $nama_rak = $this->request->getPost('nama_rak');

            // Validasi dasar (tidak boleh kosong)
            if (empty($nama_rak)) {
                session()->setFlashdata('error', 'Nama Rak tidak boleh kosong!');
            ?>
                <script> history.go(-1); </script>
            <?php
                return;
            }

            // Generate ID Rak otomatis
            $hasil = $modelRak->autoNumber()->getRowArray();
            if (!$hasil) {
                $id = "RAK001"; // ID awal jika tabel kosong
            } else {
                $kode = $hasil['id_rak'];
                $noUrut = (int)substr($kode, -3);
                $noUrut++;
                $id = "RAK" . sprintf("%03s", $noUrut); // Format ID berikutnya
            }

            // Siapkan data untuk disimpan
            $datasimpan = [
                'id_rak' => $id,
                'nama_rak' => $nama_rak,
                'is_delete_rak' => '0', // Default status aktif
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            // Simpan data menggunakan model
            $simpan = $modelRak->saveDataRak($datasimpan); // Sebaiknya cek hasil simpan

            if ($simpan) {
                session()->setFlashdata('success', 'Data Rak Berhasil Ditambahkan!!');
                // Redirect ke halaman master data rak
            ?>
                <script>
                    document.location = "<?= base_url('rak/master-data-rak'); ?>";
                </script>
            <?php
            } else {
                 session()->setFlashdata('error', 'Gagal menambahkan data Rak!');
            ?>
                 <script> history.go(-1); </script>
            <?php
            }
        }
    }

    // Method untuk menampilkan daftar data rak
    public function master_data_rak()
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
            $modelRak = new M_Rak(); // Inisiasi model

            $uri = service('uri');
            $pages = $uri->getSegment(2); // Ambil segmen URI

            // Ambil semua data rak yang tidak dihapus (is_delete_rak = '0')
            $dataRak = $modelRak->getDataRak(['is_delete_rak' => '0'])->getResultArray();

            // Siapkan data untuk dikirim ke view
            $data['pages'] = $pages;
            $data['data_rak'] = $dataRak; // Kirim data rak ke view
            $data['web_title'] = "Master Data Rak"; // Judul halaman

            // Tampilkan view master data rak
            echo view('Backend/Template/header', $data);
            echo view('Backend/Template/sidebar', $data);
            echo view('Backend/MasterRak/master-data-rak', $data); // View tabel data rak
            echo view('Backend/Template/footer', $data);
        }
    }

    // Method untuk menampilkan form edit data rak
    public function edit_data_rak()
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
        $modelRak = new M_Rak();

        // Ambil data rak berdasarkan ID yang di-hash
        $dataRak = $modelRak->getDataRak(['sha1(id_rak)' => $idEdit])->getRowArray();

        // Jika data tidak ditemukan
        if (!$dataRak) {
            session()->setFlashdata('error', 'Data Rak tidak ditemukan!');
            ?> <script> document.location = "<?= base_url('rak/master-data-rak'); ?>"; </script> <?php
            return;
        }

        // Simpan ID asli ke session untuk proses update
        session()->set(['idUpdateRak' => $dataRak['id_rak']]); // Gunakan nama session unik

        $page = $uri->getSegment(2); // Ambil segmen URI

        // Siapkan data untuk view edit
        $data['page'] = $page;
        $data['web_title'] = "Edit Data Rak";
        $data['data_rak'] = $dataRak; // Kirim data rak ke view

        // Tampilkan view form edit
        echo view('Backend/Template/header', $data);
        echo view('Backend/Template/sidebar', $data);
        echo view('Backend/MasterRak/edit-rak', $data); // View untuk edit rak
        echo view('Backend/Template/footer', $data);
    }

    // Method untuk memproses update data rak
    public function update_data_rak()
    {
        // Cek session admin
        if (session()->get('ses_id') == "" || session()->get('ses_user') == "" || session()->get('ses_level') == "") {
             session()->setFlashdata('error', 'Silakan login terlebih dahulu!');
        ?>
             <script> document.location = "<?= base_url('admin/login-admin'); ?>"; </script>
        <?php
             return;
        }

        $modelRak = new M_Rak();

        // Ambil ID dari session yang disimpan saat edit
        $idUpdate = session()->get('idUpdateRak');

        // Jika ID tidak ada di session
        if (!$idUpdate) {
            session()->setFlashdata('error', 'Sesi update tidak valid!');
            ?> <script> document.location = "<?= base_url('rak/master-data-rak'); ?>"; </script> <?php
            return;
        }

        // Ambil data dari form POST
        $nama_rak = $this->request->getPost('nama_rak');

        // Validasi dasar (tidak boleh kosong)
        if (empty($nama_rak)) {
            session()->setFlashdata('error', 'Nama Rak tidak boleh kosong!');
        ?>
            <script>
                history.go(-1); // Kembali ke halaman edit
            </script>
            <?php
        } else {
            // Siapkan data untuk diupdate
            $dataUpdate = [
                'nama_rak' => $nama_rak,
                'updated_at' => date('Y-m-d H:i:s') // Update waktu terakhir diubah
            ];
            $whereUpdate = ['id_rak' => $idUpdate]; // Kondisi WHERE berdasarkan ID

            // Lakukan update menggunakan model
            $update = $modelRak->updateDataRak($dataUpdate, $whereUpdate);

            // Hapus ID dari session setelah update
            session()->remove('idUpdateRak');

            if($update){
                session()->setFlashdata('success', 'Data Rak Berhasil Diperbaharui!');
                // Redirect ke halaman master data
            ?>
                <script>
                    document.location = "<?= base_url('rak/master-data-rak'); ?>";
                </script>
            <?php
            } else {
                session()->setFlashdata('error', 'Gagal memperbaharui data Rak!');
            ?>
                <script> history.go(-1); </script>
            <?php
            }
        }
    }

    // Method untuk menghapus data rak (soft delete)
    public function hapus_data_rak()
    {
        // Cek session admin
        if (session()->get('ses_id') == "" || session()->get('ses_user') == "" || session()->get('ses_level') == "") {
             session()->setFlashdata('error', 'Silakan login terlebih dahulu!');
        ?>
             <script> document.location = "<?= base_url('admin/login-admin'); ?>"; </script>
        <?php
             return;
        }

        $modelRak = new M_Rak();

        $uri = service('uri');
        $idHapus = $uri->getSegment(3); // Ambil ID dari URL (hash sha1)

        // Siapkan data untuk update (mengubah flag is_delete)
        $dataUpdate = [
            'is_delete_rak' => '1', // Ubah status menjadi dihapus
            'updated_at' => date('Y-m-d H:i:s')
        ];
        $whereUpdate = ['sha1(id_rak)' => $idHapus]; // Kondisi WHERE berdasarkan ID yang di-hash

        // Lakukan update (soft delete)
        $hapus = $modelRak->updateDataRak($dataUpdate, $whereUpdate);

        if($hapus){
            session()->setFlashdata('success', 'Data Rak Berhasil Dihapus!');
        } else {
            session()->setFlashdata('error', 'Gagal menghapus data Rak!');
        }

        // Redirect ke halaman master data
        ?>
        <script>
            document.location = "<?= base_url('rak/master-data-rak'); ?>";
        </script>
    <?php
    }
}
