<h3>Edit Admin</h3>
<hr />
<form action="<?php echo base_url('admin/update-admin');?>" method="post" style="margin-left: 300px;">
    <div class="form-group col-md-6">
        <label>Nama Admin</label>
        <input type="text" class="form-control" name="nama" placeholder="Masukkan Nama Admin" value="<?php echo $data_admin['nama_admin'];?>" required="required">
    </div>
    <div style="clear:both;"></div>

    <div class="form-group col-md-6">
        <label>Username Admin</label>
        <input type="text" class="form-control" value="<?php echo $data_admin['username_admin'];?>" readonly="readonly" onKeyPress="return goodchars(event, 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789',this)" name="username" placeholder="Masukkan Username Pengguna" required="required">
    </div>
    <div style="clear:both;"></div>

    <div class="form-group col-md-6">
        <label>Akses Level</label>
        <select class="form-control" name="level" required="required">
            <option value="">-- Pilih Level --</option>
            <option value="2" <?php if($data_admin['akses_level']=="2"){ echo "selected"; }else echo "";?>>Kepala Perpustakaan</option>
            <option value="3" <?php if($data_admin['akses_level']=="3"){ echo "selected"; }else echo "";?>>Admin Perpustakaan</option>
        </select>
    </div>
    <div style="clear:both;"></div>

    <div class="form-group col-md-6">
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="<?php echo base_url('admin/master-data-admin');?>"><button type="button" class="btn btn-danger">Batal</button></a>
    </div>
    <div style="clear:both;"></div>
</form>