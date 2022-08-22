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
					<?php foreach ($data as $key => $row): ?>
		      		<?php endforeach ?>
		      		<div class="col-sm-4 col-xs-4 col-md-12">
		      		<?php if (session()->getFlashdata('pesan')):?>
		      			<div class="alert alert-success">
		      				<?= session()->getFlashdata('pesan');?>
		      			</div>
		      		<?php endif;?>
		      		<div class="card">
		      			<div class="card-header">
		      					<h3 class="card-title">Profile <?= $row['nama_lengkap'];?></h3>
		      			</div>
		      			<div class="card-body">
		      				<div class="row">
		      					<div class="col-md-4">
		      						<div class="card card-widget widget-user">
		      							<!-- Add the bg color to the header using any of the bg-* classes -->
		      							<div class="widget-user-header bg-info">
		      								<h3 class="widget-user-username"><?= $row['nama_lengkap'];?></h3>
		      								<?php
		      								if($row['jabatan']==Null){
		      									$jabatan ="Pilih Jabatan";
		      								}else{
		      									$jabatan = $row['jabatan'];
		      								}
		      								?>
		      								<h5 class="widget-user-desc"><?= $jabatan ;?></h5>
		      							</div>
		      							<div class="widget-user-image">
		      								<?php
		      								if($row['foto']=='default.svg'){
		      									?>
		      									<img src="<?= base_url('../../file_foto/'.$row['foto']);?>.svg" class="img-circle elevation-2" alt="User Image">
		      								<?php } else { 
		      									?>
		      									<img src="<?= base_url('../../file_foto/'.$row['foto']);?>" class="img-circle elevation-2" alt="User Image" style="width: 100px;height: 100px;">
		      								<?php }?>

		      							</div>
		      						</div>
		      						<hr>
		      						<br>
		      						<form action="<?= base_url('home/savePp');?>" method="POST" enctype="multipart/form-data">
		      							<?php
		      							date_default_timezone_set("Asia/Bangkok");
		      							$tgl = date('d-M-Y:H:i:sa');
		      							?>
		      							<?= csrf_field();?>
		      							<input type="hidden" name="tgl" value="<?= $tgl ;?>">
		      							<input type="hidden" name="id" value="<?= $session->get('user_name');?>">
		      							<input type="hidden" name="foto_lama" value="<?= $session->get('foto');?>">
		      						<div class="form-group">
		      							<label for="exampleInputEmail1">Foto Profile</label>
		      							<div class="custom-file">
		      								<input type="file" name="foto_profile" class="custom-file-input" id="customFile">
		      								<label class="custom-file-label <?= ($validation->hasError('foto_profile')) ? 'has-error' : '' ;?>" for="customFile">Choose file</label>
		      								<small style="font-size: 12px;color: #525151;">Gunakan Ukuran foto 200 X 200px agar lebih presisi</small>
		      								<div class="<?= ($validation->hasError('foto_profile')) ? 'invalid-feedback' : '' ;?>">
		      									<small><?= $validation->getError('foto_profile');?></small>
		      								</div>
		      							</div>

		      						</div>

		      						
		      						
		      					</div>
		      					<div class="col-md-8">
		      						<div class="form-group">
		      							<label for="exampleInputEmail1">Nama Lengkap</label>
		      							<input type="text" name="nama_lengkap" class="form-control <?= ($validation->hasError('nama_lengkap')) ? 'has-error' : '' ;?>" placeholder="Nama Lengkap dan Gelar" value="<?= $row['nama_lengkap'];?>">
		      							<div class="<?= ($validation->hasError('nama_lengkap')) ? 'invalid-feedback' : '' ;?>">
		      								<small><?= $validation->getError('nama_lengkap');?></small>
		      							</div>
		      						</div>

		      						
		      						<div class="form-group">
		      							<label for="exampleInputEmail1">Tempat Lahir</label>
		      							<input type="text" name="tmp_lahir" class="form-control" placeholder="Tempat Lahir" value="<?= $row['tempat_lahir'];?>">
		      						</div>

		      						<div class="form-group">
		      							<label for="exampleInputEmail1">Tanggal Lahir</label>
		      							<input type="date" name="tgl_lahir" class="form-control" placeholder="Tanggal Lahir" value="<?= $row['tanggal_lahir'];?>">
		      						</div>
		      						<div class="form-group">
		      							<label>Jenis Kelamin</label>
		      							<select name="jk" class="form-control" required>
		      								<option value="<?= $row['jenis_kelamin'];?>"><?= $row['jenis_kelamin'];?></option>
		      								<option value="Laki-laki">Laki-laki</option>
		      								<option value="Wanita">Wanita</option>
		      							</select>
		      						</div>

		      						<div class="form-group">
		      							<label>Pendidikan Terakhir</label>
		      							<select name="pendidikan_terakhir" class="form-control" required>
		      								<option value="<?= $row['pendidikan_terakhir'];?>"><?= $row['pendidikan_terakhir'];?></option>
		      								<option value="SLTA">SMA/Sederajat</option>
		      								<option value="D3">Diploma</option>
		      								<option value="S1">Sarjana</option>
		      								<option value="S2">Magister</option>
		      								<option value="S3">Doktor</option>
		      							</select>
		      						</div>

		      						<div class="form-group">
		      							<label>Jabatan</label>
		      							<select name="jabatan" class="form-control" required>
		      								<option value="<?= $row['jabatan'];?>"><?= $row['jabatan'];?></option>
		      								<option value="Divisi IT">Divisi IT</option>
		      								<option value="Dosen">Dosen</option>
		      								<option value="Laboran">Laboran</option>
		      								<option value="Tendik">Administrasi</option>
		      								
		      							</select>
		      						</div>
		      						<div class="form-group">
		      							<label>Alamat Lengkap</label>
		      							<textarea name="alamat" class="form-control" placeholder="Alamat Lengkap"><?= $row['alamat_lengkap'];?></textarea>
		      						</div>

		      						<div class="form-group">
		      							<label for="exampleInputEmail1">Foto KTP</label>
		      							<div class="custom-file">
		      								<input type="file" name="ktp" class="custom-file-input" id="customFile">
		      								<label class="custom-file-label <?= ($validation->hasError('ktp')) ? 'has-error' : '' ;?>" for="customFile">Choose file</label>
		      								<div class="<?= ($validation->hasError('ktp')) ? 'invalid-feedback' : '' ;?>">
		      									<small><?= $validation->getError('ktp');?></small>
		      								</div>
		      							</div>
		      						</div>
		      						<div class="form-group">
		      							<label for="exampleInputEmail1">Foto KK</label>
		      							<div class="custom-file">
		      								<input type="file" name="kk" class="custom-file-input" id="customFile">
		      								<label class="custom-file-label <?= ($validation->hasError('kk')) ? 'has-error' : '' ;?>" for="customFile">Choose file</label>
		      								<div class="<?= ($validation->hasError('kk')) ? 'invalid-feedback' : '' ;?>">
		      									<small><?= $validation->getError('kk');?></small>
		      								</div>
		      							</div>
		      						</div>
		      						<div class="form-group">
		      							<label for="exampleInputEmail1">Foto Ijazah Terakhir</label>
		      							<div class="custom-file">
		      								<input type="file" name="ijazah" class="custom-file-input" id="customFile">
		      								<label class="custom-file-label <?= ($validation->hasError('ijazah')) ? 'has-error' : '' ;?>" for="customFile">Choose file</label>
		      								<div class="<?= ($validation->hasError('ijazah')) ? 'invalid-feedback' : '' ;?>">
		      									<small><?= $validation->getError('ijazah');?></small>
		      								</div>
		      							</div>
		      						</div>
		      						<div class="form-group">
		      							<label for="exampleInputEmail1">Foto Transkrip Nilai</label>
		      							<div class="custom-file">
		      								<input type="file" name="transkrip" class="custom-file-input" id="customFile">
		      								<label class="custom-file-label <?= ($validation->hasError('transkrip')) ? 'has-error' : '' ;?>" for="customFile">Choose file</label>
		      								<div class="<?= ($validation->hasError('transkrip')) ? 'invalid-feedback' : '' ;?>">
		      									<small><?= $validation->getError('transkrip');?></small>
		      								</div>
		      							</div>
		      						</div>
		      						<div class="form-group">
		      							<button type="submit" class="btn btn-info" onclick="return confirm('Apakah data yang anda Save Sudah Benar.?');" style="float: right;"><i class="far fa-save" ></i> SAVE!</button>
		      						</div>
		      						
		      					</div>
		      					
		      				</div>
		      				</form>
		      			</div>
		      		</div>
		      		</div>
		      	</div>
	      </div>
		</section>
	</div>
</div> 

<?= $this->endSection();?>
