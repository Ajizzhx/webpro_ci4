<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="<?= base_url('admin/dashboard-admin'); ?>"><span class="glyphicon glyphicon-home"></span></a></li>
            <li>Master Data</li>
            <li class="active">Data Anggota</li>
        </ol>
    </div><!--/.row-->

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Master Data Anggota
                    <a href="<?= base_url('anggota/input-data-anggota'); ?>" class="btn btn-primary btn-sm pull-right">Tambah Anggota</a>
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
                                <th data-field="id_anggota" data-sortable="true">ID Anggota</th>
                                <th data-field="nama_anggota" data-sortable="true">Nama Anggota</th>
                                <th data-field="jenis_kelamin" data-sortable="true">Jenis Kelamin</th>
                                <th data-field="no_tlp" data-sortable="true">No. Telp</th>
                                <th data-field="alamat" data-sortable="false">Alamat</th>
                                <th data-field="email" data-sortable="true">Email</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($data_user as $anggota) : // Ganti nama variabel $data_user ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= esc($anggota['id_anggota']); ?></td>
                                    <td><?= esc($anggota['nama_anggota']); ?></td>
                                    <td><?= esc($anggota['jenis_kelamin']); ?></td>
                                    <td><?= esc($anggota['no_tlp']); ?></td>
                                    <td><?= esc($anggota['alamat']); ?></td>
                                    <td><?= esc($anggota['email']); ?></td>
                                    <td>
                                        <a href="<?= base_url('anggota/edit-data-anggota/' . sha1($anggota['id_anggota'])); ?>" class="btn btn-warning btn-xs" title="Edit">
                                            <span class="glyphicon glyphicon-edit"></span>
                                        </a>
                                        <a href="#" onclick="konfirmasiHapus('<?= base_url('anggota/hapus-data-anggota/' . sha1($anggota['id_anggota'])); ?>')" class="btn btn-danger btn-xs" title="Hapus">
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
        if (confirm("Apakah Anda yakin ingin menghapus data anggota ini?")) {
            window.location.href = url;
        }
    }
</script>
