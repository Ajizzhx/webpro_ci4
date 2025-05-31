<!-- File: app/Views/Backend/Transaksi/detail-transaksi-peminjaman.php -->

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="<?= base_url('admin/dashboard-admin') ?>"><span class="glyphicon glyphicon-home"></span></a></li>
            <li><a href="<?= base_url('admin/data-transaksi-peminjaman') ?>">Data Peminjaman</a></li>
            <li class="active">Detail Transaksi</li>
        </ol>
    </div><!--/.row-->

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Detail Transaksi Peminjaman: <?= esc($transaksi['no_peminjaman']) ?>
                    <a href="<?= base_url('admin/data-transaksi-peminjaman') ?>" class="btn btn-default btn-sm pull-right" style="margin-top:-5px;">
                        <span class="glyphicon glyphicon-arrow-left"></span> Kembali
                    </a>
                </div>
                <div class="panel-body">
                    <?php if (session()->getFlashdata('success')) : ?>
                        <div class="alert alert-success">
                            <?= session()->getFlashdata('success') ?>
                        </div>
                    <?php endif; ?>
                    <?php if (session()->getFlashdata('error')) : ?>
                        <div class="alert alert-danger">
                            <?= session()->getFlashdata('error') ?>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($transaksi) && !empty($transaksi)) : ?>
                        <h4>Informasi Peminjaman</h4>
                        <table class="table table-bordered">
                            <tr>
                                <th style="width:200px;">No. Peminjaman</th>
                                <td><?= esc($transaksi['no_peminjaman']) ?></td>
                            </tr>
                            <tr>
                                <th>Nama Anggota</th>
                                <td><?= esc($transaksi['nama_anggota']) ?> (<?= esc($transaksi['id_anggota']) ?>)</td>
                            </tr>
                            <tr>
                                <th>Tanggal Pinjam</th>
                                <td><?= date('d F Y', strtotime(esc($transaksi['tgl_pinjam']))) ?></td>
                            </tr>
                            <tr>
                                <th>Total Buku Dipinjam</th>
                                <td><?= esc($transaksi['total_pinjam']) ?></td>
                            </tr>
                            <tr>
                                <th>Status Transaksi</th>
                                <td>
                                    <?php if ($transaksi['status_transaksi'] == 'Berjalan') : ?>
                                        <span class="label label-warning">Berjalan</span>
                                    <?php elseif ($transaksi['status_transaksi'] == 'Selesai') : ?>
                                        <span class="label label-success">Selesai</span>
                                    <?php else: ?>
                                        <span class="label label-default"><?= esc($transaksi['status_transaksi']) ?></span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                             <tr>
                                <th>Status Ambil Buku</th>
                                <td><?= esc($transaksi['status_ambil_buku']) ?></td>
                            </tr>
                            <tr>
                                <th>Admin yang Melayani</th>
                                <td><?= esc($transaksi['nama_admin']) ?></td>
                            </tr>
                            <tr>
                                <th>QR Code</th>
                                <td>
                                    <?php if (!empty($transaksi['qr_code'])) : ?>
                                        <img src="<?= base_url('Assets/qr_code/' . esc($transaksi['qr_code'])) ?>" alt="QR Code Peminjaman" style="width:100px; height:100px; border:1px solid #ccc; padding:5px;">
                                    <?php else : ?>
                                        -
                                    <?php endif; ?>
                                </td>
                            </tr>
                        </table>

                        <hr>
                        <h4>Daftar Buku yang Dipinjam</h4>
                        <?php if (!empty($transaksi['detail_buku'])) : ?>
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>ID Buku</th>
                                        <th>Judul Buku</th>
                                        <th>Pengarang</th>
                                        <th>Tanggal Harus Kembali</th>
                                        <th>Status Pinjam</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; foreach ($transaksi['detail_buku'] as $buku) : ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= esc($buku['id_buku']) ?></td>
                                            <td><?= esc($buku['judul_buku']) ?></td>
                                            <td><?= esc($buku['pengarang']) ?></td>
                                            <td><?= date('d F Y', strtotime(esc($buku['tgl_kembali']))) ?></td>
                                            <td><?= esc($buku['status_pinjam']) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else : ?>
                            <p class="text-muted">Tidak ada detail buku untuk transaksi ini.</p>
                        <?php endif; ?>

                    <?php else : ?>
                        <p class="text-danger">Detail transaksi tidak ditemukan.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div><!--/.row-->
</div><!--/.main-->