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
					
		      		<div class="col-sm-4 col-xs-4 col-md-12">
		      			<div class="card">
		      				<div class="card-header">
		      					<h3 class="card-title">Riwayat Pekerjaan</h3>
		      				</div>
		      				<!-- /.card-header -->

		      				<div class="card-body">
		      					<?php if (session()->getFlashdata('pesan')):?>
		      					<div class="alert alert-success">
		      						<?= session()->getFlashdata('pesan');?>
		      					</div>
		      					<?php endif;?>
		      					<table id="example1" class="table table-bordered table-striped">
		      						<p><a href="<?= base_url('home/addPekerjaan');?>" class="btn btn-info"><i class="fas fa-plus-circle"></i> Pekerjaan</a></p>
		      						<thead>
		      							<tr>
		      								<th>No</th>
		      								<th>Pekerjaan</th>
		      								<th>Tanggal</th>
		      								<th>Dari Jam</th>
		      								<th>S/d Jam</th>
		      								<th>Keterangan</th>
		      								<th>Status</th>
		      								<th style="text-align: center;">Aksi</th>
		      							</tr>
		      						</thead>
		      						<tbody>
		      							<?php $no=1; foreach($data as $row):?>
		      							<tr>
		      								<td><?= $no++;?></td>
		      								<td><?= $row['pekerjaan'];?></td>
		      								<td><?= $row['tanggal'];?></td>
		      								<td><?= $row['jam_mulai'];?>. Wib</td>
		      								<td><?= $row['jam_selesai'];?>. Wib</td>
		      								<td><?= $row['keterangan'];?></td>
		      								<td><?= $row['status'];?></td>
		      								<td style="text-align: center;">
		      									<a href="<?= base_url('home/updatePekerjaan/'. $row['id_pekerjaan']);?>"><i class="far fa-edit" title="Update"></i></a></td>
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
