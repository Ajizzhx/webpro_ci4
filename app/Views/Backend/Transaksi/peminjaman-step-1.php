<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="#"><span class="glyphicon glyphicon-home"></span></a></li>
            <li>Transaksi</li>
            <li class="active">Peminjaman</li>
        </ol>
    </div><!--/.row-->

    <div class="row">
    <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <?php
                    // Menampilkan pesan error/sukses
                    $error = session()->getFlashdata('error');
                    $success = session()->getFlashdata('success');
                    if ($error) {
                        echo '<div class="alert alert-danger">' . esc($error) . '</div>';
                    }
                    if ($success) {
                        echo '<div class="alert alert-success">' . esc($success) . '</div>';
                    }
                    ?>
                    <h3>Input Anggota</h3>
                    <form action="<?= base_url('admin/peminjaman-step-2');?>" method="post">
                        <?= csrf_field() ?> <!-- Tambahkan CSRF Field -->
                        <div class="form-group col-md-6">
                            <label>ID Anggota</label>
                            <input type="text" class="form-control" name="id_anggota" placeholder="Masukkan ID Anggota" required="required">
                        </div>
                        <div style="clear:both;"></div>
                        <div class="form-group col-md-6">
                            <button type="submit" class="btn btn-primary">Next</button>
                            <a href="<?= base_url('admin/data-transaksi-peminjaman');?>"><button type="button" class="btn btn-danger">Batal</button></a> 
                        </div>
                        <div style="clear:both;"></div>
                    </form>
                </div>
            </div>
        </div>
    </div><!--/.row-->
</div>
