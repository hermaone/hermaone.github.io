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
					<?php $no=1; foreach($data as $row);?>
					<div class="col-lg-12">
						<?php if (session()->getFlashdata('pesan')):?>
						<div class="alert alert-warning">
							<?= session()->getFlashdata('pesan');?>
						</div>
					<?php endif;?>
						<div class="card">
							<div class="card-header">
								<h3 class="card-title">Apa yang anda ingin Update?</h3>
							</div>
							<form action="<?= base_url('home/saveUpdatePekerjaan');?>" method="POST" enctype="multipart/form-data">
							<div class="card-body">
								<?= csrf_field();?>
								<?php
		      							date_default_timezone_set("Asia/Bangkok");
		      							$datetime = date('d-M-Y:H:i:sa');
		      					?>
									<input type="hidden" name="updatedAt" value="<?= $datetime;?>">
									<input type="hidden" name="id" value="<?= $row['id_pekerjaan'];?>">
									<input type="hidden" name="status" value="Available">
									<div class="form-group">
										<label for="exampleInputPassword1">Pekerjaan</label>
										<textarea name="pekerjaan" class="form-control" placeholder="Pekerjaan Anda" required><?= $row['pekerjaan'];?></textarea>
									</div>
									<div class="form-group">
										<label for="exampleInputPassword1">Jam Mulai</label>
										<input type="time" name="jamMulai" class="form-control" placeholder="Jam Mulai" required value="<?= $row['jam_mulai'];?>">
									</div>
									<div class="form-group">
										<label for="exampleInputPassword1">Jam Berakhir</label>
										<input type="time" name="jamBerakhir" class="form-control" placeholder="Jam Berakhir" required value="<?= $row['jam_selesai'];?>">
									</div>

									<div class="form-group">
										<label for="exampleInputPassword1">Keterangan</label>
										<textarea name="keterangan" class="form-control"placeholder="keterangan"><?= $row['keterangan'];?></textarea>
									</div>
									
									
							</div>
							<div class="card-footer">
								<button type="submit" class="btn btn-primary"><i class="far fa-save" ></i> UPDATE!</button>
							</div>
							</form>
						</div>
					</div>
		      	</div>
		    </div>
		</section>
	</div>
</div> 

<?= $this->endSection();?>
