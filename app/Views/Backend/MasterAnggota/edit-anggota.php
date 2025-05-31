<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="<?= base_url('admin/dashboard-admin'); ?>"><span class="glyphicon glyphicon-home"></span></a></li>
            <li>Master Data</li>
            <li><a href="<?= base_url('anggota/master-data-anggota'); ?>">Data Anggota</a></li>
            <li class="active">Edit Data Anggota</li>
        </ol>
    </div><!--/.row-->

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                 <div class="panel-heading">
                    Edit Data Anggota : <?= esc($data_anggota['nama_anggota']); ?>
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
                    <form class="form-horizontal" action="<?= base_url('anggota/update-data-anggota'); ?>" method="post">
                        <fieldset>
                            <!-- ID Anggota (Readonly) -->
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="id_anggota">ID Anggota</label>
                                <div class="col-md-9">
                                    <input id="id_anggota" name="id_anggota" type="text" value="<?= esc($data_anggota['id_anggota']); ?>" class="form-control" readonly>
                                </div>
                            </div>

                            <!-- Nama Anggota input-->
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="nama">Nama Anggota</label>
                                <div class="col-md-9">
                                    <input id="nama" name="nama" type="text" value="<?= esc($data_anggota['nama_anggota']); ?>" placeholder="Masukkan Nama Anggota" class="form-control" required>
                                </div>
                            </div>

                            <!-- Jenis Kelamin input -->
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="jenis_kelamin">Jenis Kelamin</label>
                                <div class="col-md-9">
                                    <select id="jenis_kelamin" name="jenis_kelamin" class="form-control" required>
                                        <option value="">-- Pilih Jenis Kelamin --</option>
                                        <option value="Laki-laki" <?= ($data_anggota['jenis_kelamin'] == 'Laki-laki') ? 'selected' : ''; ?>>Laki-laki</option>
                                        <option value="Perempuan" <?= ($data_anggota['jenis_kelamin'] == 'Perempuan') ? 'selected' : ''; ?>>Perempuan</option>
                                    </select>
                                </div>
                            </div>

                            <!-- No Telp input-->
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="no_tlp">No. Telepon</label>
                                <div class="col-md-9">
                                    <input id="no_tlp" name="no_tlp" type="text" value="<?= esc($data_anggota['no_tlp']); ?>" placeholder="Masukkan Nomor Telepon" class="form-control" required>
                                </div>
                            </div>

                            <!-- Alamat body -->
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="alamat">Alamat</label>
                                <div class="col-md-9">
                                    <textarea class="form-control" id="alamat" name="alamat" placeholder="Masukkan Alamat Lengkap" rows="5" required><?= esc($data_anggota['alamat']); ?></textarea>
                                </div>
                            </div>

                            <!-- Email input-->
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="email">Email</label>
                                <div class="col-md-9">
                                    <input id="email" name="email" type="email" value="<?= esc($data_anggota['email']); ?>" placeholder="Masukkan Email" class="form-control" required>
                                </div>
                            </div>

                            <!-- Password tidak diedit di sini -->
                            <!-- Jika ingin ada fitur ubah password, buat form/halaman terpisah -->

                            <!-- Form actions -->
                            <div class="form-group">
                                <div class="col-md-12 widget-right">
                                    <button type="submit" class="btn btn-primary btn-md pull-right">Update</button>
                                    <a href="<?= base_url('anggota/master-data-anggota'); ?>" class="btn btn-danger btn-md pull-right" style="margin-right: 10px;">Batal</a>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div><!--/.row-->
</div> <!--/.main-->
