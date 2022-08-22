<?= $this->extend('home/layout/template');?>
<?= $this->section('content');?>
<div id="page-wrapper">
	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<section class="content">
			<div class="container-fluid">
				<div class="row">
					<div class="col-sm-6">
						<h2><?= $title ;?></h2>
					</div>
					<?php $no=1; foreach($data as $row):?>
		      		<?php endforeach ?>
		      		<div class="col-sm-4 col-xs-4 col-md-12">
		      			<div class="card">
		      				<div class="card-header">
		      					<h3 class="card-title">Riwayat Absensi <?= $row['nama_lengkap'];?></h3>
		      				</div>
		      				<!-- /.card-header -->
		      				<div class="card-body">
		      					<table id="example1" class="table table-bordered table-striped">
		      						<thead>
		      							<tr>
		      								<th>No</th>
		      								<th>Nama</th>
		      								<th>Tgl Masuk</th>
		      								<th>Jam Masuk</th>
		      								<th>Tgl Pulang</th>
		      								<th>Jam Pulang</th>
		      								<th>Keterangan</th>
		      							</tr>
		      						</thead>
		      						<tbody>
		      							<?php $no=1; foreach($data as $row):?>
		      							<tr>
		      								<td><?= $no++;?></td>
		      								<td><?= $row['nama_lengkap'];?></td>
		      								<td><?= $row['tgl_masuk'];?></td>
		      								<td><?= $row['jam_masuk'];?></td>
		      								<td><?= $row['tgl_pulang'];?></td>
		      								<td><?= $row['jam_pulang'];?></td>
		      								<td><span class="<?= ($row['keterangan']=='Late') ? 'late' : 'ontime' ;?>"><?= $row['keterangan'];?></span></td>
		      							</tr>
		      							<?php endforeach;?>
		      					</table>
		      				</div>
		      				<!-- /.card-body -->
		      			</div>
		      		</div>
		      	</div>
	      </div>
		</section>
	</div>
</div> 

<?= $this->endSection();?>
