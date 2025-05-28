<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="<?= base_url('admin/dashboard-admin') ?>"><span class="glyphicon glyphicon-home"></span></a></li>
            <li>Transaksi</li>
            <li class="active">Data Peminjaman</li>
        </ol>
    </div><!--/.row-->

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Transaksi Peminjaman Buku</h1>
        </div>
    </div><!--/.row-->

    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success" role="alert">
            <?= session()->getFlashdata('success'); ?>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')) : ?>
        <div class="alert alert-danger" role="alert">
            <?= session()->getFlashdata('error'); ?>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Daftar Peminjaman
                    <a href="<?= base_url('admin/peminjaman-step-1') ?>" class="btn btn-primary pull-right btn-sm">Tambah Peminjaman Baru</a>
                </div>
                <div class="panel-body">
                    <table data-toggle="table" data-search="true" data-pagination="true">
                        <thead>
                            <tr>
                                <th>No Peminjaman</th>
                                <th>Nama Anggota</th>
                                <th>Tanggal Peminjaman</th>
                                <th>Total Buku Yang Dipinjam</th>
                                <th>Status Transaksi</th>
                                <th>Status Ambil Buku</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($dataPeminjaman as $data): ?>
                                <tr>
                                    <td><?= esc($data['no_peminjaman']); ?></td>
                                    <td><?= esc($data['nama_anggota']); ?></td>
                                    <td><?= date('Y-m-d', strtotime($data['tgl_pinjam'])); ?></td>
                                    <td><?= esc($data['total_pinjam']); ?></td>
                                    <td>
                                        <span class="label label-<?= ($data['status_transaksi'] == 'Berjalan') ? 'warning' : (($data['status_transaksi'] == 'Selesai') ? 'success' : 'danger'); ?>">
                                            <?= esc($data['status_transaksi']); ?>
                                        </span>
                                    </td>
                                    <td><?= esc($data['status_ambil_buku']); ?></td>
                                    <td>
                                        <a href="<?= base_url('admin/peminjaman-detail/' . $data['no_peminjaman']); ?>" class="btn btn-primary btn-sm">Lihat Detail</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div><!--/.row-->
</div>
