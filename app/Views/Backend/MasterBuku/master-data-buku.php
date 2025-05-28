<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="<?= base_url('admin/dashboard-admin'); ?>"><span class="glyphicon glyphicon-home"></span></a></li>
            <li>Master Data</li>
            <li class="active">Data Buku</li>
        </ol>
    </div><!--/.row-->

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Data Buku
                    <a href="<?= base_url('admin/input-buku'); ?>" class="btn btn-primary btn-sm pull-right">
                        Tambah Data Buku
                    </a>
                </div>

                <div class="panel-body">
                    <?php
                    if ($error = session()->getFlashdata('error')) {
                        echo '<div class="alert alert-danger">' . esc($error) . '</div>';
                    }
                    if ($success = session()->getFlashdata('success')) {
                        echo '<div class="alert alert-success">' . esc($success) . '</div>';
                    }
                    ?>

                    <!-- Ganti tabel biasa dengan Bootstrap Table -->
                    <table data-toggle="table" data-show-refresh="true" data-show-toggle="true" data-show-columns="true" data-search="true" data-select-item-name="toolbar1" data-pagination="true" data-sort-name="judul" data-sort-order="asc">
                            <thead>
                                <tr>
                                    <th data-field="no" data-sortable="false">No</th>
                                    <th data-field="cover" data-sortable="false">Cover</th>
                                    <th data-field="judul" data-sortable="true">Judul Buku</th>
                                    <th data-field="pengarang" data-sortable="true">Pengarang</th>
                                    <th data-field="penerbit" data-sortable="true">Penerbit</th>
                                    <th data-field="tahun" data-sortable="true">Tahun</th>
                                    <th data-field="jumlah" data-sortable="true">Jumlah Eksemplar</th>
                                    <th data-field="kategori" data-sortable="true">Kategori Buku</th>
                                    <th data-field="keterangan" data-sortable="false">Keterangan</th>
                                    <th data-field="rak" data-sortable="true">Rak</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                if (isset($dataBuku) && !empty($dataBuku)) :
                                    foreach ($dataBuku as $buku) : ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td>
                                                <?php if (!empty($buku['cover_buku'])) : ?>
                                                    <img src="<?= base_url('Assets/CoverBuku/' . esc($buku['cover_buku'])); ?>" alt="cover" width="50" style="max-height: 75px; object-fit: cover;">
                                                <?php else : ?>
                                                    <span class="text-muted">Tidak ada</span>
                                                <?php endif; ?>
                                            </td>
                                            <td><?= esc($buku['judul_buku']); ?></td>
                                            <td><?= esc($buku['pengarang']); ?></td>
                                            <td><?= esc($buku['penerbit']); ?></td>
                                            <td><?= esc($buku['tahun']); ?></td>
                                            <td><?= esc($buku['jumlah_eksemplar']); ?></td>
                                            <td><?= esc($buku['nama_kategori'] ?? 'N/A'); ?></td>
                                            <td><?= esc($buku['keterangan']); ?></td>
                                            <td><?= esc($buku['nama_rak'] ?? 'N/A'); ?></td>
                                            <td>
                                                <a href="<?= base_url('admin/edit-buku/' . sha1($buku['id_buku'])); ?>" class="btn btn-warning btn-xs" title="Edit">
                                                    <span class="glyphicon glyphicon-edit"></span>
                                                </a>
                                                <a href="javascript:void(0)" onclick="konfirmasiHapus('<?= base_url('admin/hapus-buku/' . sha1($buku['id_buku'])); ?>')" class="btn btn-danger btn-xs" title="Hapus">
                                                    <span class="glyphicon glyphicon-trash"></span>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach;
                                else : ?>
                                    <tr>
                                        <td colspan="11" class="text-center">Tidak ada data buku.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>

                </div>
            </div>
        </div>
    </div><!--/.row-->
</div> <!--/.main-->

<script>
    function konfirmasiHapus(url) {
        if (confirm("Apakah Anda yakin ingin menghapus data buku ini?")) {
            window.location.href = url;
        }
    }
</script>
