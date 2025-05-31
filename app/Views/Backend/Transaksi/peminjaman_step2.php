<!-- File: app/Views/Backend/Transaksi/peminjaman-step-2.php -->

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="<?= base_url('admin/dashboard-admin') ?>"><span class="glyphicon glyphicon-home"></span></a></li>
            <li><a href="<?= base_url('admin/peminjaman_step1') ?>">Transaksi</a></li>
            <li class="active">Peminjaman - Langkah 2</li>
        </ol>
    </div><!--/.row-->

    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')) : ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('warning')) : ?>
        <div class="alert alert-warning"><?= session()->getFlashdata('warning') ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('info')) : ?>
        <div class="alert alert-info"><?= session()->getFlashdata('info') ?></div>
    <?php endif; ?>


    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">Data Anggota</div>
                <div class="panel-body">
                    <?php if (isset($anggota) && !empty($anggota)) : ?>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>ID Anggota:</label>
                                <p><?= esc($anggota['id_anggota']) ?></p>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Nama Anggota:</label>
                                <p><?= esc($anggota['nama_anggota']) ?></p>
                            </div>
                        </div>
                    <?php else : ?>
                        <p class="text-danger">Data anggota tidak ditemukan.</p>
                        <a href="<?= base_url('admin/peminjaman-step1') ?>" class="btn btn-warning">Kembali ke Langkah 1</a>
                        <?php return; // Hentikan render jika anggota tidak ada ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">Keranjang Peminjaman Buku</div>
                <div class="panel-body">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul Buku</th>
                                <th>Pengarang</th>
                                <th>Penerbit</th>
                                <th>Tahun</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($keranjang) && !empty($keranjang)) : ?>
                                <?php $no = 1; ?>
                                <?php foreach ($keranjang as $item) : ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= esc($item['judul_buku']) ?></td>
                                        <td><?= esc($item['pengarang']) ?></td>
                                        <td><?= esc($item['penerbit']) ?></td>
                                        <td><?= esc($item['tahun']) ?></td>
                                        <td>
                                            <a href="#" onclick="confirmDeleteTemp('<?= sha1($item['id_buku']) ?>', '<?= esc($item['judul_buku']) ?>')" class="btn btn-danger btn-xs">
                                                <span class="glyphicon glyphicon-trash"></span> Hapus
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="6" class="text-center">Keranjang peminjaman kosong.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    <?php if (isset($jumlah_item_keranjang) && $jumlah_item_keranjang > 0) : ?>
                        <hr>
                        <a href="<?= base_url('admin/simpan-transaksi-peminjaman') ?>" class="btn btn-primary btn-block">
                            <span class="glyphicon glyphicon-floppy-disk"></span> Simpan Transaksi Peminjaman
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">Daftar Buku Tersedia</div>
                <div class="panel-body">
                    <!-- Untuk fungsionalitas search dan sort yang canggih seperti di OCR, Anda perlu Bootstrap Table JS -->
                    <!-- Berikut adalah tabel HTML sederhana -->
                    <table id="tabelBukuTersedia" class="table table-hover table-striped table-bordered" 
                           data-toggle="table" 
                           data-search="true" 
                           data-show-refresh="true" 
                           data-show-toggle="true" 
                           data-show-columns="true" 
                           data-pagination="true" 
                           data-page-list="[10, 25, 50, 100, ALL]"
                           data-sort-name="judul_buku"
                           data-sort-order="asc">
                        <thead>
                            <tr>
                                <th data-field="no" data-sortable="false">No</th>
                                <th data-field="cover_buku" data-sortable="false" data-formatter="imageFormatter">Cover</th>
                                <th data-field="judul_buku" data-sortable="true">Judul Buku</th>
                                <th data-field="pengarang" data-sortable="true">Pengarang</th>
                                <th data-field="penerbit" data-sortable="true">Penerbit</th>
                                <th data-field="tahun" data-sortable="true">Tahun</th>
                                <th data-field="jumlah_eksemplar" data-sortable="true">Stok</th>
                                <th data-field="kategori_buku" data-sortable="true">Kategori</th>
                                <th data-field="rak_buku" data-sortable="true">Rak</th>
                                <th data-field="e_book" data-sortable="false" data-formatter="ebookLinkFormatter">E-Book</th>
                                <th data-field="opsi" data-sortable="false" data-formatter="opsiPinjamFormatter">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($buku_tersedia) && !empty($buku_tersedia)) : ?>
                                <?php $no_buku = 1; ?>
                                <?php foreach ($buku_tersedia as $buku) : ?>
                                    <tr>
                                        <td><?= $no_buku++ ?></td>
                                        <td>
                                            <?php if (!empty($buku['cover_buku'])) : ?>
                                                <img src="<?= base_url('Assets/CoverBuku/' . esc($buku['cover_buku'])) ?>" alt="Cover <?= esc($buku['judul_buku']) ?>" style="width:50px; height:auto;">
                                            <?php else : ?>
                                                -
                                            <?php endif; ?>
                                        </td>
                                        <td><?= esc($buku['judul_buku']) ?></td>
                                        <td><?= esc($buku['pengarang']) ?></td>
                                        <td><?= esc($buku['penerbit']) ?></td>
                                        <td><?= esc($buku['tahun']) ?></td>
                                        <td><?= esc($buku['jumlah_eksemplar']) ?></td>
                                        <td><?= esc($buku['nama_kategori']) ?></td> <!-- Asumsi dari join -->
                                        <td><?= esc($buku['nama_rak']) ?></td> <!-- Asumsi dari join -->
                                        <td>
                                            <?php if (!empty($buku['e_book'])) : ?>
                                                <a href="<?= base_url('Assets/E-Book/' . esc($buku['e_book'])) ?>" target="_blank" class="btn btn-info btn-xs">
                                                    <span class="glyphicon glyphicon-book"></span> Lihat
                                                </a>
                                            <?php else : ?>
                                                -
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($buku['jumlah_eksemplar'] > 0) : ?>
                                                <a href="<?= base_url('admin/simpan-temp-pinjam/' . sha1($buku['id_buku'])) ?>" class="btn btn-success btn-xs">
                                                    <span class="glyphicon glyphicon-plus"></span> Pinjam Buku
                                                </a>
                                            <?php else : ?>
                                                <button class="btn btn-default btn-xs" disabled>Stok Habis</button>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="11" class="text-center">Tidak ada buku yang tersedia.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div><!--/.row-->
</div><!--/.main-->

<!-- Panggil Bootstrap Table JS dan CSS jika belum di template utama -->
<!-- Pastikan file ini ada di public/Assets/bootstrap-table -->
<link rel="stylesheet" href="<?= base_url('Assets/bootstrap-table/bootstrap-table.min.css') ?>">
<script src="<?= base_url('Assets/bootstrap-table/bootstrap-table.min.js') ?>"></script>
<!-- Jika menggunakan ekstensi, misal untuk locale Indonesia -->
<!-- <script src="<?= base_url('Assets/bootstrap-table/locale/bootstrap-table-id-ID.min.js') ?>"></script> -->


<script>
    // Inisialisasi Bootstrap Table jika belum otomatis
    // $(function() {
    //     $('#tabelBukuTersedia').bootstrapTable();
    // });

    // Contoh formatter jika menggunakan data-formatter di <thead>
    // function imageFormatter(value, row) {
    //     if (row.cover_buku) {
    //         return '<img src="<?= base_url('Assets/CoverBuku/') ?>' + row.cover_buku + '" style="width:50px; height:auto;" />';
    //     }
    //     return '-';
    // }
    // function ebookLinkFormatter(value, row) {
    //      if (row.e_book) {
    //         return '<a href="<?= base_url('Assets/E-Book/') ?>' + row.e_book + '" target="_blank" class="btn btn-info btn-xs"><span class="glyphicon glyphicon-book"></span> Lihat</a>';
    //     }
    //     return '-';
    // }
    // function opsiPinjamFormatter(value, row) {
    //     if (row.jumlah_eksemplar > 0) {
    //         return '<a href="<?= base_url('admin/simpan-temp-pinjam/') ?>' + row.sha1_id_buku + '" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-plus"></span> Pinjam Buku</a>';
    //     }
    //     return '<button class="btn btn-default btn-xs" disabled>Stok Habis</button>';
    // }


    function confirmDeleteTemp(idBukuHashed, judulBuku) {
        swal({
            title: "Hapus dari Keranjang?",
            text: "Anda yakin ingin menghapus buku '" + judulBuku + "' dari keranjang peminjaman?",
            icon: "warning",
            buttons: ["Batal", "Ya, Hapus!"],
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                window.location.href = "<?= base_url('admin/hapus-temp-item/') ?>" + idBukuHashed;
            }
        });
    }
</script>