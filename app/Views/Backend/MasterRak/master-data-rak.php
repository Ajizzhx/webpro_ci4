<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="<?= base_url('admin/dashboard-admin'); ?>"><span class="glyphicon glyphicon-home"></span></a></li>
            <li>Master Data</li>
            <li class="active">Data Rak</li>
        </ol>
    </div><!--/.row-->

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Master Data Rak
                    <a href="<?= base_url('admin/input-rak'); ?>" class="btn btn-primary btn-sm pull-right">Tambah Rak</a>
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
                    <table data-toggle="table" data-show-refresh="true" data-show-toggle="true" data-show-columns="true" data-search="true" data-select-item-name="toolbar1" data-pagination="true" data-sort-name="nama" data-sort-order="asc">
                        <thead>
                            <tr>
                                <th data-field="no" data-sortable="true">No</th>
                                <th data-field="id_rak" data-sortable="true">ID Rak</th>
                                <th data-field="nama_rak" data-sortable="true">Nama Rak</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($dataRak as $rak) : ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= esc($rak['id_rak']); ?></td>
                                    <td><?= esc($rak['nama_rak']); ?></td>
                                    <td>
                                        <a href="<?= base_url('admin/edit-rak/' . sha1($rak['id_rak'])); ?>" class="btn btn-warning btn-xs" title="Edit">
                                            <span class="glyphicon glyphicon-edit"></span>
                                        </a>
                                        <a href="#" onclick="konfirmasiHapus('<?= base_url('admin/hapus-rak/' . sha1($rak['id_rak'])); ?>')" class="btn btn-danger btn-xs" title="Hapus">
                                            <span class="glyphicon glyphicon-trash"></span>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div><!--/.row-->

</div> <!--/.main-->

<script>
    function konfirmasiHapus(url) {
        // Ganti dengan sweet alert jika ingin seperti master admin
        if (confirm("Apakah Anda yakin ingin menghapus data rak ini?")) {
            window.location.href = url;
        }
    }
</script>
