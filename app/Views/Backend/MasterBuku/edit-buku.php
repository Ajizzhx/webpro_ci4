<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="<?= base_url('admin/dashboard-admin'); ?>"><span class="glyphicon glyphicon-home"></span></a></li>
            <li>Master Data</li>
            <li><a href="<?= base_url('admin/master-buku'); ?>">Data Buku</a></li>
            <li class="active">Edit Data Buku</li>
        </ol>
    </div><!--/.row-->

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Edit Data Buku : <?= isset($data_buku['judul_buku']) ? esc($data_buku['judul_buku']) : 'Data Buku'; ?>
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

                    // Cek jika data buku ada
                    if (empty($data_buku)) :
                        echo '<div class="alert alert-warning">Data buku tidak ditemukan atau tidak valid.</div>';
                    else :
                    ?>
                    <!-- Pastikan form action dan method benar, tambahkan enctype untuk upload file -->
                    <form class="form-horizontal" action="<?= base_url('admin/update-buku'); ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field() ?> <!-- Tambahkan CSRF field -->
                        <fieldset>
                            <!-- ID Buku (Readonly) -->
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="id_buku">ID Buku</label>
                                <div class="col-md-9">
                                    <input id="id_buku" name="id_buku" type="text" value="<?= esc($data_buku['id_buku']); ?>" class="form-control" readonly>
                                </div>
                            </div>

                            <!-- Judul Buku input-->
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="judul_buku">Judul Buku</label>
                                <div class="col-md-9">
                                    <input id="judul_buku" name="judul_buku" type="text" placeholder="Masukkan Judul Buku" class="form-control" required value="<?= esc(old('judul_buku', $data_buku['judul_buku'])); ?>">
                                </div>
                            </div>

                            <!-- Pengarang input-->
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="pengarang">Pengarang</label>
                                <div class="col-md-9">
                                    <input id="pengarang" name="pengarang" type="text" placeholder="Masukkan Nama Pengarang" class="form-control" required value="<?= esc(old('pengarang', $data_buku['pengarang'])); ?>">
                                </div>
                            </div>

                            <!-- Penerbit input-->
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="penerbit">Penerbit</label>
                                <div class="col-md-9">
                                    <input id="penerbit" name="penerbit" type="text" placeholder="Masukkan Nama Penerbit" class="form-control" required value="<?= esc(old('penerbit', $data_buku['penerbit'])); ?>">
                                </div>
                            </div>

                            <!-- Tahun Terbit input-->
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="tahun">Tahun Terbit</label>
                                <div class="col-md-9">
                                    <input id="tahun" name="tahun" type="number" placeholder="Masukkan Tahun Terbit (YYYY)" class="form-control" required min="1000" max="<?= date('Y') ?>" value="<?= esc(old('tahun', $data_buku['tahun'])); ?>">
                                </div>
                            </div>

                            <!-- Jumlah Eksemplar input-->
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="jumlah_eksemplar">Jumlah Eksemplar</label>
                                <div class="col-md-9">
                                    <input id="jumlah_eksemplar" name="jumlah_eksemplar" type="number" placeholder="Masukkan Jumlah Eksemplar" class="form-control" required min="0" value="<?= esc(old('jumlah_eksemplar', $data_buku['jumlah_eksemplar'])); ?>">
                                </div>
                            </div>

                            <!-- Kategori Buku Dropdown -->
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="kategori_buku">Kategori Buku</label>
                                <div class="col-md-9">
                                    <select id="kategori_buku" name="kategori_buku" class="form-control" required>
                                        <option value="">-- Pilih Kategori --</option>
                                        <?php if (!empty($data_kategori)) : ?>
                                            <?php foreach ($data_kategori as $kategori) : ?>
                                                <option value="<?= esc($kategori['id_kategori']); ?>" <?= (old('kategori_buku', $data_buku['id_kategori']) == $kategori['id_kategori']) ? 'selected' : ''; ?>>
                                                    <?= esc($kategori['nama_kategori']); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>

                            <!-- Keterangan input -->
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="keterangan">Keterangan</label>
                                <div class="col-md-9">
                                    <textarea class="form-control" id="keterangan" name="keterangan" placeholder="Masukkan Keterangan Tambahan (opsional)" rows="3"><?= esc(old('keterangan', $data_buku['keterangan'])); ?></textarea>
                                </div>
                            </div>

                            <!-- Lokasi Rak Dropdown -->
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="rak">Lokasi Rak</label>
                                <div class="col-md-9">
                                    <select id="rak" name="rak" class="form-control" required>
                                        <option value="">-- Pilih Rak --</option>
                                        <?php if (!empty($data_rak)) : ?>
                                            <?php foreach ($data_rak as $itemRak) : ?>
                                                <option value="<?= esc($itemRak['id_rak']); ?>" <?= (old('rak', $data_buku['id_rak']) == $itemRak['id_rak']) ? 'selected' : ''; ?>>
                                                    <?= esc($itemRak['nama_rak']); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>

                            <!-- Cover Buku input (Opsional saat edit) -->
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="cover_buku">Cover Buku</label>
                                <div class="col-md-9">
                                    <?php if (!empty($data_buku['cover_buku'])) : ?>
                                        <img src="<?= base_url('Assets/CoverBuku/' . esc($data_buku['cover_buku'])); ?>" alt="Cover Buku" style="max-width: 500px; margin-bottom: 10px; border: 1px solid #ddd; padding: 2px;">
                                    <?php endif; ?>
                                    <input id="cover_buku" name="cover_buku" type="file" class="form-control" accept="image/jpeg, image/png, image/jpg">
                                    <span class="help-block">Kosongkan jika tidak ingin mengganti cover. Format: JPG, JPEG, PNG. Maks: 1MB</span>
                                </div>
                            </div>

                            <!-- E-Book input (Opsional saat edit) -->
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="e_book">E-Book (PDF)</label>
                                <div class="col-md-9">
                                    <?php if (!empty($data_buku['e_book'])) : ?>
                                        <iframe src="<?= base_url('Assets/E-Book/' . esc($data_buku['e_book'])); ?>" width="100%" height="400px" style="border:1px solid #ccc;"></iframe>
                                    <?php endif; ?>
                                    <input id="e_book" name="e_book" type="file" class="form-control" accept="application/pdf">
                                    <span class="help-block">Kosongkan jika tidak ingin mengganti E-Book. Format: PDF. Maks: 10MB</span>
                                </div>
                            </div>


                            <!-- Form actions -->
                            <div class="form-group">
                                <div class="col-md-12 widget-right">
                                    <button type="submit" class="btn btn-primary btn-md pull-right">Update</button>
                                    <a href="<?= base_url('admin/master-buku'); ?>" class="btn btn-danger btn-md pull-right" style="margin-right: 10px;">Batal</a>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                    <?php endif; // End check data_buku ?>
                </div>
            </div>
        </div>
    </div><!--/.row-->
</div> <!--/.main-->