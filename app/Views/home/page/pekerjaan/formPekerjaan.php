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
					
					<div class="col-lg-12">
						<?php if (session()->getFlashdata('pesan')):?>
						<div class="alert alert-warning">
							<?= session()->getFlashdata('pesan');?>
						</div>
					<?php endif;?>
						<div class="card">
							<div class="card-header">
								<h3 class="card-title">Apa yang anda lakukan hari ini?</h3>
							</div>
							<form action="<?= base_url('home/savePekerjaan');?>" method="POST" enctype="multipart/form-data">
							<div class="card-body">
								<?= csrf_field();?>
								<?php
		      							date_default_timezone_set("Asia/Bangkok");
		      							$datetime = date('d-M-Y:H:i:sa');
		      					?>
		      						<input type="hidden" name="tgl" value="<?= date('d-M-Y') ;?>">
									<input type="hidden" name="createdAt" value="<?= $datetime;?>">
									<input type="hidden" name="id" value="<?= session('user_name');?>">
									<input type="hidden" name="status" value="Available">
									<div class="form-group">
										<label for="exampleInputPassword1">Pekerjaan</label>
										<textarea name="pekerjaan" class="form-control" placeholder="Pekerjaan Anda" required></textarea>
									</div>
									<div class="form-group">
										<label for="exampleInputPassword1">Jam Mulai</label>
										<input type="time" name="jamMulai" class="form-control" placeholder="Jam Mulai" required>
									</div>
									<div class="form-group">
										<label for="exampleInputPassword1">Jam Berakhir</label>
										<input type="time" name="jamBerakhir" class="form-control" placeholder="Jam Berakhir" required>
									</div>

									<div class="form-group">
										<label for="exampleInputPassword1">Keterangan</label>
										<textarea name="keterangan" class="form-control"placeholder="keterangan"></textarea>
									</div>
									
									
							</div>
							<div class="card-footer">
								<button type="submit" class="btn btn-primary"><i class="far fa-save" ></i> SAVE!</button>
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
