<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">            
    <div class="row"> 
        <ol class="breadcrumb"> 
            <li><a href="<?= base_url('admin/dashboard-admin') ?>"><span class="glyphicon glyphicon-home"></span></a></li> 
            <li>Transaksi</li> 
            <li class="active">Peminjaman</li> 
        </ol> 
    </div><!--/.row--> 
 
    <div class="row"> 
        <div class="col-md-12"> 
            <div class="panel panel-default"> 
                <div class="panel-heading">Proses Peminjaman Buku - Langkah 2</div>
                <div class="panel-body"> 
                     <?php if (session()->getFlashdata('success')) : ?>
                        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
                    <?php endif; ?>
                    <?php if (session()->getFlashdata('error')) : ?>
                        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
                    <?php endif; ?>
                    <?php if (session()->getFlashdata('warning')) : ?>
                        <div class="alert alert-warning"><?= session()->getFlashdata('warning') ?></div>
                    <?php endif; ?>
                    <?php if (session()->getFlashdata('info')) : ?>
                        <div class="alert alert-info"><?= session()->getFlashdata('info') ?></div>
                    <?php endif; ?>

                    <h3>Data Anggota</h3> 
                    <hr /> 
                    <div class="form-group col-md-6"> 
                        <label>ID Anggota</label> 
                        <br /><?= isset($anggota['id_anggota']) ? esc($anggota['id_anggota']) : 'Data anggota tidak ditemukan';?> 
                    </div> 
                    <div style="clear:both;"></div> 
 
                    <div class="form-group col-md-6"> 
                        <label>Nama Anggota</label> 
                        <br /><?= isset($anggota['nama_anggota']) ? esc($anggota['nama_anggota']) : 'Data anggota tidak ditemukan';?> 
                    </div> 
                    <div style="clear:both;"></div> 
                    <br /> 
 
                    <h3>Keranjang Peminjaman Buku</h3> 
                    <table data-toggle="table"> 
                        <thead> 
                        <tr> 
                            <th data-sortable="true">No</th> 
                            <th data-sortable="true">Judul Buku</th>
                            <th data-sortable="true">Pengarang</th> 
                            <th data-sortable="true">Penerbit</th> 
                            <th data-sortable="true">Tahun</th> 
                            <th data-sortable="true">Opsi</th> 
                        </tr> 
                        </thead> 
                        <tbody> 
                        <?php 
                        $no_keranjang = 0; 
                        if (isset($keranjang) && !empty($keranjang)) :
                            foreach($keranjang as $item){ 

                        ?> 
                        <tr> 
                            <td data-sortable="true"><?php echo ++$no_keranjang;?></td> 
                            <td data-sortable="true"><?= esc($item['judul_buku']);?></td> 
                            <td data-sortable="true"><?= esc($item['pengarang']);?></td> 
                            <td data-sortable="true"><?= esc($item['penerbit']);?></td> 
                            <td data-sortable="true"><?= esc($item['tahun']);?></td> 
                            
                            <td data-sortable="true"> 
                                <a href="#" onclick="confirmDeleteTemp('<?= sha1($item['id_buku']);?>', '<?= esc($item['judul_buku']) ?>')"><button 
type="button" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash"></span> 
Hapus</button></a> 
                            </td> 
                        </tr> 
 
                       <?php } else : ?>
                            <tr><td colspan="6" class="text-center">Keranjang peminjaman kosong.</td></tr>
                        <?php endif; ?> 
                        </tbody> 
                    </table> 
                    <?php 
                    if(isset($jumlah_item_keranjang) && $jumlah_item_keranjang > 0){ 
                    ?> 
                    <br />
                    <form action="<?= base_url('admin/simpan-transaksi-peminjaman');?>" method="post">
                        <?= csrf_field() ?>
                        <button type="submit" class="btn btn-primary btn-block">Simpan Transaksi Peminjaman Buku</button>
                    </form> 
                    <?php } ?> 
                </div> 
            </div> 
        </div> 
    </div><!--/.row--> 
 
    <div class="row"> 
        <div class="col-lg-12"> 
            <div class="panel panel-default"> 
                <div class="panel-heading">Daftar Buku Tersedia</div>
                <div class="panel-body"> 
                    <table data-toggle="table" data-search="true" data-show-refresh="true" data-show-toggle="true" data-show-columns="true" data-pagination="true" data-sort-name="judul_buku" data-sort-order="asc"> 
                        <thead> 
                        <tr> 
                            <th data-sortable="true">No</th> 
                            <th data-sortable="true">Judul Buku</th> 
                            <th data-sortable="true">Pengarang</th> 
                            <th data-sortable="true">Penerbit</th> 
                            <th data-sortable="true">Tahun</th> 
                            <th data-sortable="true">Jumlah Eksemplar</th> 
                            <th data-sortable="true">Kategori Buku</th>
                            <th data-sortable="true">Rak</th> 
                            <th data-sortable="true">Cover Buku</th>
                            <th data-sortable="true">E-Book</th> 
                            <th data-sortable="true">Opsi</th> 
                        </tr> 
                        </thead> 
                        <tbody> 
                        <?php 
                       $no_buku = 0; 
                        if (isset($buku_tersedia) && !empty($buku_tersedia)) :
                            foreach($buku_tersedia as $buku){ 
                        ?> 
                        <tr> 
                           <td data-sortable="true"><?php echo ++$no_buku;?></td> 
                            <td data-sortable="true"><?= esc($buku['judul_buku']);?></td> 
                            <td data-sortable="true"><?= esc($buku['pengarang']);?></td> 
                            <td data-sortable="true"><?= esc($buku['penerbit']);?></td> 
                            <td data-sortable="true"><?= esc($buku['tahun']);?></td> 
                            <td data-sortable="true"><?= esc($buku['jumlah_eksemplar']);?></td> 
                            <td data-sortable="true"><?= esc($buku['nama_kategori']);?></td>                             
                            <td data-sortable="true"><?= esc($buku['nama_rak']);?></td> 
                            <td data-sortable="true">
                                <?php if (!empty($buku['cover_buku'])) : ?>
                                    <img src="<?= base_url('Assets/CoverBuku/' . esc($buku['cover_buku'])); ?>" alt="Cover <?= esc($buku['judul_buku']) ?>" style="width:50px; height:auto;">
                                <?php else : echo '-'; endif; ?>
                            </td>
                            <td data-sortable="true">
                                <?php if (!empty($buku['e_book'])) : ?>
                                    <a href="<?= base_url('Assets/E-Book/' . esc($buku['e_book'])); ?>" target="_blank" class="btn btn-info btn-xs"><span class="glyphicon glyphicon-book"></span> Lihat</a>
                                <?php else : echo '-'; endif; ?>
                            </td>
                            <td data-sortable="true"> 
                                <?php 
                                if($buku['jumlah_eksemplar'] > 0){ 
                                ?> 
                                <a href="<?= base_url('admin/simpan-temp-pinjam')."/".sha1($buku['id_buku']);?>"><button type="button" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-plus"></span> Pinjam Buku</button></a> 
                                <?php } else { echo "<span class='text-danger'>Stok Habis</span>"; } ?>
                            </td> 
                        </tr> 
 
                         <?php } else : ?>
                            <tr><td colspan="11" class="text-center">Tidak ada buku yang tersedia.</td></tr>
                        <?php endif; ?> 
                        </tbody> 
                    </table> 
                </div> 
            </div> 
        </div> 
    </div><!--/.row-->   
</div> 
 
<script type="text/javascript"> 
    function confirmDeleteTemp(idBukuHashed, judulBuku) { 

        swal({ 
            title: "Hapus Data Peminjaman?", 
            t text: "Anda yakin ingin menghapus buku '" + judulBuku + "' dari keranjang peminjaman?", 
            icon: "warning", 
            buttons: ["Batal", "Ya, Hapus!"], 
            dangerMode: true, 
        }) 
 .then((willDelete) => { 
            if (willDelete) { 
                window.location.href = "<?= base_url('admin/hapus-temp-item/') ?>" + idBukuHashed;
            }
        }); 
} 
</script> 