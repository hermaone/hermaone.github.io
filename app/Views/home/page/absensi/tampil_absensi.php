<?= $this->extend('home/layout/template');?>
<?= $this->section('content');?>
<div id="page-wrapper">
	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<section class="content">
			<div class="container-fluid">
		      	<div class="row">
		      		<?php foreach ($data as $key => $row): ?>
		      		<?php endforeach ?>
		      		<div class="col-sm-4 col-xs-4 col-md-12">
		      		<?php if (session()->getFlashdata('pesan')):?>
		      			<div class="alert alert-success">
		      				<?= session()->getFlashdata('pesan');?>
		      			</div>
		      		<?php endif;?>

		      		<?php if (session()->getFlashdata('gagal')):?>
		      			<div class="alert alert-danger">
		      				<?= session()->getFlashdata('gagal');?>
		      			</div>
		      		<?php endif;?>

		      		<?php if (session()->getFlashdata('warning')):?>
		      			<div class="alert alert-warning">
		      				<?= session()->getFlashdata('warning');?>
		      			</div>
		      		<?php endif;?>

		      		<div class="<?= ($validation->hasError('tgl_masuk')) ? 'alert alert-danger' : '' ;?>">
		      			<small><?= $validation->getError('tgl_masuk');?></small>
		      		</div>

		      			<br>
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
		      				<div class="card-footer">
		      					<p class="nav-item d-none d-sm-inline-block">
		      						<?php
		      						date_default_timezone_set("Asia/Bangkok");
		      						$tgl = date('d-M-Y');
		      						$jam = date('H:i:s');
		      						?>

		      						<script type="text/javascript">
		      							function date_time1(id)
		      							{
		      								date = new Date;
		      								year = date.getFullYear();
		      								month = date.getMonth();
		      								months = new Array('January', 'February', 'March', 'April', 'May', 'June', 'Jully', 'August', 'September', 'October', 'November', 'December');
		      								d = date.getDate();
		      								day = date.getDay();
		      								days = new Array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
		      								h = date.getHours();
		      								if(h<10)
		      								{
		      									h = "0"+h;
		      								}
		      								m = date.getMinutes();
		      								if(m<10)
		      								{
		      									m = "0"+m;
		      								}
		      								s = date.getSeconds();
		      								if(s<10)
		      								{
		      									s = "0"+s;
		      								}
		      								result = ''+days[day]+' '+d+' '+months[month]+' '+year+' '+h+':'+m+':'+s;
		      								document.getElementById(id).innerHTML = result;
		      								setTimeout('date_time1("'+id+'");','1000');
		      								return true;
		      							}
		      						</script>

		      						<div style="text-align: center;"><span class="nav-link" id="date_time1"></span></div>
		      						<script type="text/javascript">window.onload = date_time1('date_time1');</script>
		      					</p>
		      					<div class="row">
		      						<div class="col-sm-6 col-xs-6 border-right">
		      							<div class="description-block">
		      							<?php foreach ($chekAbsen as $key => $chekAbsen): ?>
		      								
		      							<?php endforeach ?>

		      							
		      							<?php 
		      							if($chekAbsen['t_masuk'] !== $tgl){
		      								?>
		      								<form action="<?= base_url('home/masuk');?>" method="POST">
		      									<input type="hidden" name="id" value="<?= $session->get('user_name');?>">
		      									<input type="hidden" name="jam_masuk" value="<?= $jam;?>">
		      									<input type="hidden" name="tgl_masuk" value="<?= $tgl;?>">
		      									<button type="submit" class="btn btn-success"><h5 class="description-header">Masuk</h5></button>
		      								</form>
		      							<?php } else { 
		      								?>
		      								<form action="<?= base_url('home/masuk');?>" method="POST">
		      									<input type="hidden" name="id" value="<?= $session->get('user_name');?>">
		      									<input type="hidden" name="jam_masuk" value="<?= $jam;?>">
		      									<input type="hidden" name="tgl_masuk" value="<?= $tgl;?>">
		      									<button type="submit" class="btn btn-warning" disabled><h5 class="description-header">Sdh Absen!</h5></button>
		      								</form>
		      							<?php }?>

		      							</div>
		      							<!-- /.description-block -->
		      						</div>
		      						
		      						<!-- /.col -->
		      						<div class="col-sm-6 ol-xs-6">
		      							<?php foreach ($jam_plg as $key => $j): ?>
		      							<?php endforeach ?>
		      							<?php
		      							if($jam > $j['jam_pulang']){
		      								?>
		      								<div class="description-block">
		      									<form action="<?= base_url('home/pulang/'.$session->get('user_name'));?>" method="POST">
		      										<input type="hidden" name="id" value="<?= $session->get('user_name');?>">
		      										<input type="hidden" name="jam_plg" value="<?= $jam;?>">
		      										<input type="hidden" name="tgl_plg" value="<?= $tgl;?>">
		      										<button type="submit" class="btn btn-danger"><h5 class="description-header">Pulang</h5></button>
		      									</form>
		      								</div>
		      							<?php } else { 
		      								?>
		      								<div class="description-block">
		      									<form action="<?= base_url('home/pulang/'.$session->get('user_name'));?>" method="POST">
		      										<input type="hidden" name="id" value="<?= $session->get('user_name');?>">
		      										<input type="hidden" name="jam_plg" value="<?= $jam;?>">
		      										<input type="hidden" name="tgl_plg" value="<?= $tgl;?>">
		      										<button type="submit" class="btn btn-danger" disabled><h5 class="description-header">Pulang</h5></button>
		      									</form>
		      								</div>
		      							<?php }?>
		      							<!-- /.description-block -->
		      						</div>
		      						<!-- /.col -->
		      					</div>
		      					<!-- /.row -->
		      				</div>
		      			</div>
		      		

		      			<!-- /.widget-user -->
		      		</div>
		      	</div>
	      </div>
		</section>
	</div>
</div> 

<?= $this->endSection();?>
