<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="#"><span class="glyphicon glyphicon-home"></span></a></li>
            <li>Master Data Admin</li>
            <li class="active">Input Data Admin</li>
        </ol>
    </div><!--/.row-->

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h3>Input Admin</h3>
                    <hr />
                    <form action="<?= base_url('admin/simpan-admin'); ?>" method="post">
                        <div class="form-group col-md-6">
                            <label>Nama Admin</label>
                            <input type="text" class="form-control" name="nama" placeholder="Masukkan Nama Admin" required="required">
                        </div>
                        <div style="clear:both;"></div>

                        <div class="form-group col-md-6">
                            <label>Username Admin</label>
                            <input type="text" class="form-control" onKeyPress="return goodchars(event, 'abcdefghijklmnopqrstuvwxyz_ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789', this)" name="username" placeholder="Masukkan Username Admin" required="required">
                        </div>
                        <div style="clear:both;"></div>

                        <div class="form-group col-md-6">
                            <label>Akses Level</label>
                            <select class="form-control" name="level" required="required">
                                <option value="">-- Pilih Level --</option>
                                <option value="2">Kepala Perpustakaan</option>
                                <option value="3">Admin Perpustakaan</option>
                            </select>
                        </div>
                        <div style="clear:both;"></div>

                        <div class="form-group col-md-6">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="<?php echo base_url('admin/master-data-admin');?>"><button type="button" class="btn btn-danger">Batal</button></a>                           
                        </div>
                        <div style="clear:both;"></div>
                    </form>
                </div>
            </div>
        </div>

    </div><!--/.row-->

</div>