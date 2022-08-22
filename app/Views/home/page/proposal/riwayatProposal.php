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
					  <p><a href="<?= base_url('home/proposal');?>" class="btn btn-info"><i class="fas fa-plus-square"></i> Pengajuan</a></p>
		      			<div class="card">
							<?php if (session()->getFlashdata('pesan')):?>
							<div class="alert alert-success">
								<?= session()->getFlashdata('pesan');?>
							</div>
							<div class="<?= ($validation->hasError('')) ?'alert alert-danger' : '' ;?>">
                          	<?= $validation->listErrors();?>
                      		</div>
							<br>
							<br>
							<?php endif;?>
		      				<div class="card-header">
		      					<h3 class="card-title">Riwayat Pengajuan</h3>
		      				</div>
		      				<!-- /.card-header -->
		      				<div class="card-body">
		      					<table id="example1" class="table table-bordered table-striped">
		      						<thead>
		      							<tr>
		      								<th>No</th>
		      								<th>Perihal</th>
		      								<th>Kepada</th>
		      								<th>Status</th>
		      								<th>Keterangan</th>
		      								<th>Tanggal Pos</th>
											<th>Aksi</th>
		      							</tr>
		      						</thead>
		      						<tbody>
									  <?php $no=1; foreach($proposal as $row):?>
		      							<tr>
		      								<td><?= $no++;?></td>
		      								<td><?= $row['judul_proposal'];?></td>
		      								<td><?= $row['nama_waka'];?></td>
											  <?php
												if($row['status']=='1'){
													$status ='ACC';
												}else{
													$status ='Pending';
												}
											  ?>
		      								<td><?= $status;?></td>
		      								<td><?= $row['ket'];?></td>
		      								<td><?= $row['tgl_pos'];?></td>
											<td>AKSI</td>
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
