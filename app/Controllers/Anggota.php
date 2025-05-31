<?php

namespace App\Controllers;

use App\Models\M_Anggota; // Pastikan menggunakan Model Anggota

class Anggota extends BaseController
{

    // Method untuk menampilkan form input data anggota
    public function input_data_anggota()
    {
        // Cek session admin (karena hanya admin yang bisa input anggota)
        if (session()->get('ses_id') == "" || session()->get('ses_user') == "" || session()->get('ses_level') == "") {
            session()->setFlashdata('error', 'Silakan login terlebih dahulu!');
?>
            <script>
                document.location = "<?= base_url('admin/login-admin'); ?>";
            </script>
        <?php
        } else {
            // Tampilkan view form input anggota
            echo view('Backend/Template/header');
            echo view('Backend/Template/sidebar');
            echo view('Backend/MasterAnggota/input-anggota'); // View untuk input
            echo view('Backend/Template/footer');
        }
    }

    // Method untuk menyimpan data anggota baru
    public function simpan_data_anggota()
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
            $modelAnggota = new M_Anggota(); // Inisiasi model Anggota

            // Ambil data dari form POST
            $nama = $this->request->getPost('nama');
            $jenis_kelamin = $this->request->getPost('jenis_kelamin');
            $no_tlp = $this->request->getPost('no_tlp');
            $alamat = $this->request->getPost('alamat');
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password'); // Ambil password dari form

            // Optional: Validasi email unik jika diperlukan
            // $cekEmail = $modelAnggota->getDataAnggota(['email' => $email])->getNumRows();
            // if ($cekEmail > 0) {
            //     session()->setFlashdata('error', 'Email sudah terdaftar!!');
            // ?>
            //     <script> history.go(-1); </script>
            // <?php
            //     return;
            // }

            // Generate ID Anggota otomatis
            $hasil = $modelAnggota->autoNumber()->getRowArray();
            if (!$hasil) {
                $id = "AGT001"; // ID awal jika tabel kosong
            } else {
                $kode = $hasil['id_anggota'];
                $noUrut = (int)substr($kode, -3);
                $noUrut++;
                $id = "AGT" . sprintf("%03s", $noUrut); // Format ID berikutnya
            }

            // Siapkan data untuk disimpan
            $datasimpan = [
                'id_anggota' => $id,
                'nama_anggota' => $nama,
                'jenis_kelamin' => $jenis_kelamin,
                'no_tlp' => $no_tlp,
                'alamat' => $alamat,
                'email' => $email,
                'password_anggota' => password_hash($password, PASSWORD_DEFAULT), // Hash password sebelum disimpan
                'is_delete_anggota' => '0', // Default status aktif
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            // Simpan data menggunakan model
            $modelAnggota->saveDataAnggota($datasimpan);
            session()->setFlashdata('success', 'Data Anggota Berhasil Ditambahkan!!');

            // Redirect ke halaman master data anggota
            ?>
            <script>
                document.location = "<?= base_url('anggota/master-data-anggota'); ?>";
            </script>
        <?php
        }
    }

    // Method untuk menampilkan daftar data anggota
    public function master_data_anggota()
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
            $modelAnggota = new M_Anggota(); // Inisiasi model

            $uri = service('uri');
            $pages = $uri->getSegment(2); // Ambil segmen URI untuk keperluan view jika ada

            // Ambil semua data anggota yang tidak dihapus (is_delete_anggota = '0')
            $dataUser = $modelAnggota->getDataAnggota(['is_delete_anggota' => '0'])->getResultArray();

            // Siapkan data untuk dikirim ke view
            $data['pages'] = $pages;
            $data['data_user'] = $dataUser; // Ganti nama variabel agar lebih deskriptif
            $data['web_title'] = "Master Data Anggota"; // Judul halaman

            // Tampilkan view master data anggota
            echo view('Backend/Template/header', $data);
            echo view('Backend/Template/sidebar', $data);
            echo view('Backend/MasterAnggota/master-data-anggota', $data); // View tabel data
            echo view('Backend/Template/footer', $data);
        }
    }

    // Method untuk menampilkan form edit data anggota
    public function edit_data_anggota()
    {
        // Cek session admin (opsional, bisa juga tidak perlu jika link edit hanya muncul saat login)
        if (session()->get('ses_id') == "" || session()->get('ses_user') == "" || session()->get('ses_level') == "") {
             session()->setFlashdata('error', 'Silakan login terlebih dahulu!');
        ?>
             <script> document.location = "<?= base_url('admin/login-admin'); ?>"; </script>
        <?php
             return; // Hentikan eksekusi jika belum login
        }

        $uri = service('uri');
        $idEdit = $uri->getSegment(3); // Ambil ID dari URL (hash sha1)
        $modelAnggota = new M_Anggota();

        // Ambil data anggota berdasarkan ID yang di-hash
        $dataAnggota = $modelAnggota->getDataAnggota(['sha1(id_anggota)' => $idEdit])->getRowArray();

        // Jika data tidak ditemukan
        if (!$dataAnggota) {
            session()->setFlashdata('error', 'Data Anggota tidak ditemukan!');
            ?> <script> document.location = "<?= base_url('anggota/master-data-anggota'); ?>"; </script> <?php
            return;
        }

        // Simpan ID asli ke session untuk proses update
        session()->set(['idUpdate' => $dataAnggota['id_anggota']]);

        $page = $uri->getSegment(2); // Ambil segmen URI

        // Siapkan data untuk view edit
        $data['page'] = $page;
        $data['web_title'] = "Edit Data Anggota";
        $data['data_anggota'] = $dataAnggota; // Kirim data anggota ke view

        // Tampilkan view form edit
        echo view('Backend/Template/header', $data);
        echo view('Backend/Template/sidebar', $data);
        echo view('Backend/MasterAnggota/edit-anggota', $data); // View untuk edit
        echo view('Backend/Template/footer', $data);
    }

    // Method untuk memproses update data anggota
    public function update_data_anggota()
    {
        // Cek session admin
        if (session()->get('ses_id') == "" || session()->get('ses_user') == "" || session()->get('ses_level') == "") {
             session()->setFlashdata('error', 'Silakan login terlebih dahulu!');
        ?>
             <script> document.location = "<?= base_url('admin/login-admin'); ?>"; </script>
        <?php
             return;
        }

        $modelAnggota = new M_Anggota();

        // Ambil ID dari session yang disimpan saat edit
        $idUpdate = session()->get('idUpdate');

        // Jika ID tidak ada di session (misalnya session expired atau akses langsung)
        if (!$idUpdate) {
            session()->setFlashdata('error', 'Sesi update tidak valid!');
            ?> <script> document.location = "<?= base_url('anggota/master-data-anggota'); ?>"; </script> <?php
            return;
        }

        // Ambil data dari form POST
        $nama = $this->request->getPost('nama');
        $jenis_kelamin = $this->request->getPost('jenis_kelamin');
        $no_tlp = $this->request->getPost('no_tlp');
        $alamat = $this->request->getPost('alamat');
        $email = $this->request->getPost('email');
        // Password biasanya tidak diupdate di form edit biasa,
        // kecuali ada fitur khusus "Ubah Password"

        // Validasi dasar (tidak boleh kosong)
        if ($nama == "" || $jenis_kelamin == "" || $no_tlp == "" || $alamat == "" || $email == "") {
            session()->setFlashdata('error', 'Isian tidak boleh kosong!!');
        ?>
            <script>
                history.go(-1); // Kembali ke halaman edit
            </script>
            <?php
        } else {
            // Siapkan data untuk diupdate
            $dataUpdate = [
                'nama_anggota' => $nama,
                'jenis_kelamin' => $jenis_kelamin,
                'no_tlp' => $no_tlp,
                'alamat' => $alamat,
                'email' => $email,
                'updated_at' => date('Y-m-d H:i:s') // Update waktu terakhir diubah
            ];
            $whereUpdate = ['id_anggota' => $idUpdate]; // Kondisi WHERE berdasarkan ID

            // Lakukan update menggunakan model
            $modelAnggota->updateDataAnggota($dataUpdate, $whereUpdate);

            // Hapus ID dari session setelah update berhasil
            session()->remove('idUpdate');
            session()->setFlashdata('success', 'Data Anggota Berhasil Diperbaharui!');

            // Redirect ke halaman master data
            ?>
            <script>
                document.location = "<?= base_url('anggota/master-data-anggota'); ?>";
            </script>
        <?php
        }
    }

    // Method untuk menghapus data anggota (soft delete)
    public function hapus_data_anggota()
    {
        // Cek session admin
        if (session()->get('ses_id') == "" || session()->get('ses_user') == "" || session()->get('ses_level') == "") {
             session()->setFlashdata('error', 'Silakan login terlebih dahulu!');
        ?>
             <script> document.location = "<?= base_url('admin/login-admin'); ?>"; </script>
        <?php
             return;
        }

        $modelAnggota = new M_Anggota();

        $uri = service('uri');
        $idHapus = $uri->getSegment(3); // Ambil ID dari URL (hash sha1)

        // Siapkan data untuk update (mengubah flag is_delete)
        $dataUpdate = [
            'is_delete_anggota' => '1', // Ubah status menjadi dihapus
            'updated_at' => date('Y-m-d H:i:s')
        ];
        $whereUpdate = ['sha1(id_anggota)' => $idHapus]; // Kondisi WHERE berdasarkan ID yang di-hash

        // Lakukan update (soft delete)
        $modelAnggota->updateDataAnggota($dataUpdate, $whereUpdate);
        session()->setFlashdata('success', 'Data Anggota Berhasil Dihapus!');

        // Redirect ke halaman master data
        ?>
        <script>
            document.location = "<?= base_url('anggota/master-data-anggota'); ?>";
        </script>
<?php
    }

    // Method untuk menampilkan form transaksi peminjaman
    public function form_peminjaman()
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
            $modelAnggota = new \App\Models\M_Anggota();
            $modelBuku = new \App\Models\M_Buku();
            // Perbaiki: gunakan getResultArray() agar hasil array, bukan object
            $data['anggota'] = $modelAnggota->getDataAnggota(['is_delete_anggota' => '0'])->getResultArray();
            $data['buku'] = $modelBuku->getDataBuku(['is_delete_buku' => '0'])->getResultArray();
            $data['dataBuku'] = $data['buku']; // Tambahkan baris ini agar $dataBuku tersedia di view
            $data['web_title'] = "Form Transaksi Peminjaman";
            echo view('Backend/Template/header', $data);
            echo view('Backend/Template/sidebar', $data);
            // GANTI: echo view('Backend/Transaksi/form-peminjaman', $data);
            echo view('Backend/Transaksi/peminjaman_step1', $data);
            echo view('Backend/Template/footer', $data);
        }
    }

    // Method untuk menyimpan transaksi peminjaman
    public function simpan_peminjaman()
    {
        if (session()->get('ses_id') == "" || session()->get('ses_user') == "" || session()->get('ses_level') == "") {
            session()->setFlashdata('error', 'Silakan login terlebih dahulu!');
?>
            <script>
                document.location = "<?= base_url('admin/login-admin'); ?>";
            </script>
        <?php
            return;
        }
        $modelPeminjaman = new \App\Models\M_Peminjaman();
        $id_anggota = $this->request->getPost('id_anggota');
        $id_buku = $this->request->getPost('id_buku');
        $tanggal_pinjam = $this->request->getPost('tanggal_pinjam');
        $tanggal_kembali = $this->request->getPost('tanggal_kembali');
        // Generate ID Peminjaman otomatis (misal: PMJ001 dst)
        $last = $modelPeminjaman->orderBy('id_peminjaman', 'DESC')->first();
        if (!$last) {
            $id_peminjaman = 'PMJ001';
        } else {
            $kode = $last['id_peminjaman'];
            $noUrut = (int)substr($kode, -3);
            $noUrut++;
            $id_peminjaman = 'PMJ' . sprintf('%03s', $noUrut);
        }
        $data = [
            'id_peminjaman' => $id_peminjaman,
            'id_anggota' => $id_anggota,
            'id_buku' => $id_buku,
            'tanggal_pinjam' => $tanggal_pinjam,
            'tanggal_kembali' => $tanggal_kembali,
            'status_peminjaman' => 'Dipinjam',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        $modelPeminjaman->saveDataPeminjaman($data);
        session()->setFlashdata('success', 'Transaksi peminjaman berhasil disimpan!');
?>
        <script>
            document.location = "<?= base_url('anggota/form-peminjaman'); ?>";
        </script>
    <?php
    }

    // Method untuk menampilkan data peminjaman
    public function data_peminjaman()
    {
        if (session()->get('ses_id') == "" || session()->get('ses_user') == "" || session()->get('ses_level') == "") {
            session()->setFlashdata('error', 'Silakan login terlebih dahulu!');
?>
            <script>document.location = "<?= base_url('admin/login-admin'); ?>";</script>
        <?php
            return;
        }
        $modelPeminjaman = new \App\Models\M_Peminjaman();
        $modelAnggota = new \App\Models\M_Anggota();
        $modelBuku = new \App\Models\M_Buku();

        // Mengambil logika dari Admin::data_transaksi_peminjaman()
        $dataPeminjamanUtama = $modelPeminjaman->getDataPeminjamanJoin()->getResultArray(); // Join dengan anggota & admin
        
        $dataTransaksiLengkap = [];
        foreach ($dataPeminjamanUtama as $transaksi) {
            // Pastikan 'no_peminjaman' ada sebelum mengambil detail
            if (isset($transaksi['no_peminjaman'])) {
                $detailBuku = $modelPeminjaman->getDataDetail(['no_peminjaman' => $transaksi['no_peminjaman']])->getResultArray();
                $judulBukuDipinjam = [];
                foreach ($detailBuku as $detail) {
                    // Pastikan 'id_buku' ada
                    if (isset($detail['id_buku'])) {
                        $bukuInfo = $modelBuku->getDataBuku(['id_buku' => $detail['id_buku']])->getRowArray();
                        if ($bukuInfo && isset($bukuInfo['judul_buku'])) {
                            $judulBukuDipinjam[] = $bukuInfo['judul_buku'];
                        }
                    }
                }
                $transaksi['daftar_judul_buku'] = implode(', ', $judulBukuDipinjam);
            } else {
                $transaksi['daftar_judul_buku'] = 'N/A'; // Default jika no_peminjaman tidak ada
            }
            $dataTransaksiLengkap[] = $transaksi;
        }

        $uri = service('uri');
        $viewData['page'] = $uri->getSegment(2) ?: 'data-peminjaman'; // Sesuaikan jika perlu
        $viewData['web_title'] = "Transaksi Peminjaman Buku";
        $viewData['data_peminjaman'] = $dataTransaksiLengkap;

        echo view('Backend/Template/header', $viewData);
        echo view('Backend/Template/sidebar', $viewData);
        echo view('Backend/Transaksi/data-peminjaman', $viewData);
        echo view('Backend/Template/footer', $viewData);
    }

    // Method untuk menampilkan detail peminjaman
    public function detail_peminjaman($id)
    {
        if (session()->get('ses_id') == "" || session()->get('ses_user') == "" || session()->get('ses_level') == "") {
            session()->setFlashdata('error', 'Silakan login terlebih dahulu!');
?>
            <script>document.location = "<?= base_url('admin/login-admin'); ?>";</script>
        <?php
            return;
        }
        $modelPeminjaman = new \App\Models\M_Peminjaman();
        $modelAnggota = new \App\Models\M_Anggota();
        $modelBuku = new \App\Models\M_Buku();
        $row = $modelPeminjaman->where('id_peminjaman', $id)->first();
        if ($row) {
            $anggota = $modelAnggota->getDataAnggota(['id_anggota' => $row['id_anggota']])->getRowArray();
            $buku = $modelBuku->find($row['id_buku']);
            $row['nama_anggota'] = $anggota ? $anggota['nama_anggota'] : '-';
            $row['judul_buku'] = $buku ? $buku['judul_buku'] : '-';
        }
        $data['detail'] = $row;
        $data['web_title'] = "Detail Peminjaman Buku";
        echo view('Backend/Template/header', $data);
        echo view('Backend/Template/sidebar', $data);
        echo view('Backend/Transaksi/detail-peminjaman', $data);
        echo view('Backend/Template/footer', $data);
    }
}
