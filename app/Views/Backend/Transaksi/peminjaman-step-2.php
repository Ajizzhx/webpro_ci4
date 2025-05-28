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
                    <h3>Data Anggota</h3> 
                    <hr /> 
                    <div class="form-group col-md-6"> 
                        <label>ID Anggota</label> 
                        <br /><?= esc(session()->get('idAnggotaPeminjam'));?> 
                    </div> 
                    <div style="clear:both;"></div> 
 
                    <div class="form-group col-md-6"> 
                        <label>Nama Anggota</label> 
                        <br /><?= $dataAnggota['nama_anggota'];?> 
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
                        $no = 0; 
                        foreach($dataTemp as $data){ 
                        ?> 
                        <tr> 
                            <td data-sortable="true"><?php echo $no=$no+1;?></td> 
                            <td data-sortable="true"><?php echo $data['judul_buku'];?></td> 
                            <td data-sortable="true"><?php echo $data['pengarang'];?></td> 
                            <td data-sortable="true"><?php echo $data['penerbit'];?></td> 
                            <td data-sortable="true"><?php echo $data['tahun'];?></td> 
                            <td data-sortable="true"> 
                                <a href="#" onclick="doDelete('<?= sha1($data['id_buku']);?>')"><button 
type="button" class="btn btn-warning"><span class="glyphicon glyphicon-trash"></span> 
Hapus</button></a> 
                            </td> 
                        </tr> 
 
                        <?php } ?> 
                        </tbody> 
                    </table> 
                    <?php 
                    if($jumlahTemp > 0){ 
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
                <div class="panel-body"> 
                    <table data-toggle="table" data-url="tables/data1.json"  data-show-refresh="true" data
show-toggle="true" data-show-columns="true" data-search="true" data-select-item-name="toolbar1" 
data-pagination="true" data-sort-name="name" data-sort-order="desc"> 
                        <thead> 
                        <tr> 
                            <th data-sortable="true">No</th> 
                            <th data-sortable="true">Judul Buku</th> 
                            <th data-sortable="true">Pengarang</th> 
                            <th data-sortable="true">Penerbit</th> 
                            <th data-sortable="true">Tahun</th> 
                            <th data-sortable="true">Jumlah Eksemplar</th> 
                            <th data-sortable="true">Kategori Buku</th> 
                            <th data-sortable="true">Keterangan</th> 
                            <th data-sortable="true">Rak</th> 
                            <th data-sortable="true">Cover Buku</th>
                            <th data-sortable="true">E-Book</th> 
                            <th data-sortable="true">Opsi</th> 
                        </tr> 
                        </thead> 
                        <tbody> 
                        <?php 
                        $no = 0; 
                        foreach($dataBuku as $data){ 
                        ?> 
                        <tr> 
                            <td data-sortable="true"><?php echo $no=$no+1;?></td> 
                            <td data-sortable="true"><?php echo $data['judul_buku'];?></td> 
                            <td data-sortable="true"><?php echo $data['pengarang'];?></td> 
                            <td data-sortable="true"><?php echo $data['penerbit'];?></td> 
                            <td data-sortable="true"><?php echo $data['tahun'];?></td> 
                            <td data-sortable="true"><?php echo $data['jumlah_eksemplar'];?></td> 
                            <td data-sortable="true"><?php echo $data['nama_kategori'];?></td> 
                            <td data-sortable="true"><?php echo $data['keterangan'];?></td> 
                            <td data-sortable="true"><?php echo $data['nama_rak'];?></td> 
                            <td data-sortable="true"><img src="<?= base_url('Assets/CoverBuku/' . $data['cover_buku']); ?>" width="80px"></td>
                            <td data-sortable="true"><a href="<?= base_url('Assets/E-Book/' . $data['e_book']); ?>" target="_blank"><?php echo $data['e_book'];?></a></td>
                            <td data-sortable="true"> 
                                <?php 
                                if($data['jumlah_eksemplar']!="0"){ 
                                ?> 
                                <a href="<?= base_url('admin/simpan-temp
pinjam')."/".sha1($data['id_buku']);?>"><button type="button" class="btn btn-primary">Pinjam 
Buku</button></a> 
                                <?php } else { echo "<span class='text-danger'>Stok Habis</span>"; } ?>
                            </td> 
                        </tr> 
 
                        <?php } ?> 
                        </tbody> 
                    </table> 
                </div> 
            </div> 
        </div> 
    </div><!--/.row-->   
</div> 
 
<script type="text/javascript"> 
    function doDelete(idDelete) { 
        swal({ 
            title: "Hapus Data Peminjaman?", 
            text: "Data ini akan terhapus permanen!!", 
            icon: "warning", 
            buttons: true, 
            dangerMode: false, 
        }) 
        .then(ok => { 
if (ok) { 
window.location.href = '<?= base_url('admin/hapus-temp-pinjam/') ?>' + idDelete;
} else { 
$(this).removeAttr('disabled') 
} 
}) 
} 
</script> 