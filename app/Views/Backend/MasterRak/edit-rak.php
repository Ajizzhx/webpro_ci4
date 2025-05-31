<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="<?= base_url('admin/dashboard-admin'); ?>"><span class="glyphicon glyphicon-home"></span></a></li>
            <li>Master Data</li>
            <li><a href="<?= base_url('rak/master-data-rak'); ?>">Data Rak</a></li>
            <li class="active">Edit Data Rak</li>
        </ol>
    </div><!--/.row-->

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Edit Data Rak : <?= esc($data_rak['nama_rak']); ?>
                    <span class="pull-right clickable panel-toggle panel-button-tab-left"><em class="glyphicon glyphicon-chevron-up"></em></span>
                </div>
                <div class="panel-body">
                    <?php
                    // Menampilkan pesan error
                    $error = session()->getFlashdata('error');
                    if ($error) {
                        echo '<div class="alert alert-danger">' . esc($error) . '</div>';
                    }
                    ?>
                    <form class="form-horizontal" action="<?= base_url('rak/update-data-rak'); ?>" method="post">
                        <fieldset>
                            <!-- ID Rak (Readonly) -->
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="id_rak">ID Rak</label>
                                <div class="col-md-9">
                                    <input id="id_rak" name="id_rak" type="text" value="<?= esc($data_rak['id_rak']); ?>" class="form-control" readonly>
                                </div>
                            </div>

                            <!-- Nama Rak input-->
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="nama_rak">Nama Rak</label>
                                <div class="col-md-9">
                                    <input id="nama_rak" name="nama_rak" type="text" value="<?= esc($data_rak['nama_rak']); ?>" placeholder="Masukkan Nama Rak" class="form-control" required>
                                </div>
                            </div>

                            <!-- Form actions -->
                            <div class="form-group">
                                <div class="col-md-12 widget-right">
                                    <button type="submit" class="btn btn-primary btn-md pull-right">Update</button>
                                    <a href="<?= base_url('rak/master-data-rak'); ?>" class="btn btn-danger btn-md pull-right" style="margin-right: 10px;">Batal</a>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div><!--/.row-->
</div> <!--/.main-->
