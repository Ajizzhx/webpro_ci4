<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="<?= base_url('admin/dashboard-admin'); ?>"><span class="glyphicon glyphicon-home"></span></a></li>
            <li>Master Data</li>
            <li class="active">Input Data Buku</li>
        </ol>
    </div><!--/.row-->

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Input Data Buku
                    <span class="pull-right clickable panel-toggle panel-button-tab-left"><em class="glyphicon glyphicon-chevron-up"></em></span>
                </div>
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
                    <!-- Pastikan form action dan method benar, tambahkan enctype untuk upload file -->
                    <form class="form-horizontal" action="<?= base_url('admin/simpan-buku'); ?>" method="post" enctype="multipart/form-data">
                        <fieldset>
                            <!-- Judul Buku input-->
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="judul_buku">Judul Buku</label>
                                <div class="col-md-9">
                                    <input id="judul_buku" name="judul_buku" type="text" placeholder="Masukkan Judul Buku" class="form-control" required value="<?= old('judul_buku') ?>">
                                </div>
                            </div>

                            <!-- Pengarang input-->
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="pengarang">Pengarang</label>
                                <div class="col-md-9">
                                    <input id="pengarang" name="pengarang" type="text" placeholder="Masukkan Nama Pengarang" class="form-control" required value="<?= old('pengarang') ?>">
                                </div>
                            </div>

                            <!-- Penerbit input-->
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="penerbit">Penerbit</label>
                                <div class="col-md-9">
                                    <input id="penerbit" name="penerbit" type="text" placeholder="Masukkan Nama Penerbit" class="form-control" required value="<?= old('penerbit') ?>">
                                </div>
                            </div>

                            <!-- Tahun Terbit input-->
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="tahun">Tahun Terbit</label>
                                <div class="col-md-9">
                                    <input id="tahun" name="tahun" type="number" placeholder="Masukkan Tahun Terbit (YYYY)" class="form-control" required min="1000" max="<?= date('Y') ?>" value="<?= old('tahun') ?>">
                                </div>
                            </div>

                            <!-- Jumlah Eksemplar input-->
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="jumlah_eksemplar">Jumlah Eksemplar</label>
                                <div class="col-md-9">
                                    <input id="jumlah_eksemplar" name="jumlah_eksemplar" type="number" placeholder="Masukkan Jumlah Eksemplar" class="form-control" required min="0" value="<?= old('jumlah_eksemplar') ?>">
                                </div>
                            </div>

                            <!-- =========================================== -->
                            <!--       BAGIAN DROPDOWN KATEGORI BUKU         -->
                            <!-- =========================================== -->
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="kategori_buku">Kategori Buku</label>
                                <div class="col-md-9">
                                    <select id="kategori_buku" name="kategori_buku" class="form-control" required>
                                        <option value="">-- Pilih Kategori --</option>
                                        <?php foreach ($data_kategori as $kategori) : ?>
                                            <option value="<?= esc($kategori['id_kategori']); ?>" <?= (old('kategori_buku') == $kategori['id_kategori']) ? 'selected' : ''; ?>>
                                                <?= esc($kategori['nama_kategori']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <!-- =========================================== -->

                            <!-- Keterangan input -->
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="keterangan">Keterangan</label>
                                <div class="col-md-9">
                                    <textarea class="form-control" id="keterangan" name="keterangan" placeholder="Masukkan Keterangan Tambahan (opsional)" rows="3"><?= old('keterangan') ?></textarea>
                                </div>
                            </div>

                            <!-- =========================================== -->
                            <!--          BAGIAN DROPDOWN LOKASI RAK         -->
                            <!-- =========================================== -->
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="rak">Lokasi Rak</label>
                                <div class="col-md-9">
                                    <select id="rak" name="rak" class="form-control" required>
                                        <option value="">-- Pilih Rak --</option>
                                        <?php foreach ($data_rak as $itemRak) : ?>
                                            <option value="<?= esc($itemRak['id_rak']); ?>" <?= (old('rak') == $itemRak['id_rak']) ? 'selected' : ''; ?>>
                                                <?= esc($itemRak['nama_rak']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <!-- =========================================== -->

                            <!-- Cover Buku input -->
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="cover_buku">Cover Buku</label>
                                <div class="col-md-9">
                                    <input id="cover_buku" name="cover_buku" type="file" class="form-control" required accept="image/jpeg, image/png, image/jpg">
                                    <span class="help-block">Format: JPG, JPEG, PNG. Maks: 1MB</span>
                                </div>
                            </div>

                            <!-- E-Book input -->
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="e_book">File E-Book (PDF)</label>
                                <div class="col-md-9">
                                    <input id="e_book" name="e_book" type="file" class="form-control" required accept="application/pdf">
                                     <span class="help-block">Format: PDF. Maks: 10MB</span>
                                </div>
                            </div>

                            <!-- Form actions -->
                            <div class="form-group">
                                <div class="col-md-12 widget-right">
                                    <button type="submit" class="btn btn-primary btn-md pull-right">Simpan</button>
                                    <a href="<?= base_url('admin/master-buku'); ?>" class="btn btn-danger btn-md pull-right" style="margin-right: 10px;">Batal</a>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div><!--/.row-->
</div> <!--/.main-->
