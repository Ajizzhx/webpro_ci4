<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar" style="padding:0;max-width:220px;min-width:180px;background:#fff;">
	<ul class="nav menu" style="margin-bottom:0;">
		<li><a href="<?= base_url('admin/dashboard-admin'); ?>"><span class="glyphicon glyphicon-dashboard"></span> Dashboard</a></li>
		<li class="parent">
			<a href="#">
				<span class="glyphicon glyphicon-list"></span> Master Data <span data-toggle="collapse" href="#sub-item-master" class="icon pull-right">
					<em class="glyphicon glyphicon-plus"></em></span>
			</a>
			<ul class="children collapse" id="sub-item-master">
				<li><a href="<?= base_url('admin/master-data-admin'); ?>"><span class="glyphicon glyphicon-cog"></span> Data Admin</a></li>
				<li class="<?= (service('uri')->getSegment(1) == 'anggota') ? 'active' : ''; ?>">
					<a href="<?= base_url('anggota/master-data-anggota'); ?>">
						<span class="glyphicon glyphicon-user"></span> Data Anggota
					</a>
				</li>
				<li><a href="<?= base_url('kategori/master-data-kategori'); ?>"><span class="glyphicon glyphicon-tags"></span> Data Kategori</a></li>
				<li><a href="<?= base_url('rak/master-data-rak'); ?>"><span class="glyphicon glyphicon-folder-open"></span> Data Rak</a></li>
				<li class="<?= (service('uri')->getSegment(2) == 'master-buku' || service('uri')->getSegment(2) == 'input-buku' || service('uri')->getSegment(2) == 'edit-buku') ? 'active' : ''; ?>">
					<a href="<?= base_url('admin/master-buku'); ?>">
						<span class="glyphicon glyphicon-book"></span> Data Buku
					</a>
				</li>
			</ul>
		</li>
		<li class="parent">
			<a href="#">
				<span class="glyphicon glyphicon-transfer"></span> Transaksi
				<span data-toggle="collapse" href="#sub-item-transaksi" class="icon pull-right">
					<em class="glyphicon glyphicon-plus"></em>
				</span>
			</a>
			<ul class="children collapse" id="sub-item-transaksi">
				<li><a href="<?= base_url('anggota/data-peminjaman'); ?>"><span class="glyphicon glyphicon-list-alt"></span> Data Peminjaman</a></li>
				<li><a href="<?= base_url('anggota/form-peminjaman'); ?>"><span class="glyphicon glyphicon-plus-sign"></span> Transaksi Peminjaman</a></li>
			</ul>
		</li>
		<li role="presentation" class="divider"></li>
		<li><a href="<?= base_url('admin/logout'); ?>"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
	</ul>
	<div class="attribution" style="font-size:11px;color:#333;padding:10px 0 0 10px;">Template by <a href="http://www.medialoot.com/item/lumino-admin-bootstrap-template/" style="color:#333;">Medialoot</a></div>
</div><!--/.sidebar-->