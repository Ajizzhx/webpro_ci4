<!-- File: app/Views/Backend/Transaksi/peminjaman-step-1.php -->

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="<?= base_url('admin/dashboard-admin') ?>"><span class="glyphicon glyphicon-home"></span></a></li>
            <li>Transaksi</li>
            <li class="active">Peminjaman - Langkah 1</li>
        </ol>
    </div><!--/.row-->

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">Input ID Anggota</div>
                <div class="panel-body">
                    <?php if (session()->getFlashdata('error')) : ?>
                        <div class="alert alert-danger">
                            <?= session()->getFlashdata('error') ?>
                        </div>
                    <?php endif; ?>
                    <?php if (session()->getFlashdata('warning')) : ?>
                        <div class="alert alert-warning">
                            <?= session()->getFlashdata('warning') ?>
                        </div>
                    <?php endif; ?>

                    <form role="form" action="<?= base_url('admin/peminjaman-step-2') ?>" method="POST">
                        <?= csrf_field() ?>
                        <div class="form-group">
                            <label>ID Anggota</label>
                            <input type="text" class="form-control" name="id_anggota" placeholder="Masukkan ID Anggota" value="<?= old('id_anggota') ?>" autofocus required>
                        </div>
                        <button type="submit" class="btn btn-primary">Next</button>
                        <a href="<?= base_url('admin/dashboard-admin') ?>" class="btn btn-default">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div><!--/.row-->
</div><!--/.main-->