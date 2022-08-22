<?= $this->extend('home/layout/template');?>
<?= $this->section('content');?>
<div id="page-wrapper">
	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<section class="content">
			<div class="container-fluid">
		      	<div class="row">
		      		<div class="col-sm-6">
						<h2>Pengajuan Proposal</h2>
					</div>
					<div class="col-lg-12">
						<?php if (session()->getFlashdata('pesan')):?>
						<div class="alert alert-warning">
							<?= session()->getFlashdata('pesan');?>
						</div>
					<?php endif;?>
						<div class="card">
						
							<div class="card-header">
								<h3 class="card-title">Form Pengajuan Proposal</h3>
							</div>
							<form action="<?= base_url('home/saveProposal');?>" method="POST" enctype="multipart/form-data">
							<?=csrf_field();?>
							<?php
							date_default_timezone_set("Asia/Bangkok");
							?>
							<input type="hidden" name="username" value="<?= $session->get('user_name');?>">
							<input type="hidden" name="tglPos" value="<?= date('d-M-Y: H:i:s');?>.Wib">
							<input type="hidden" name="status" value="0">  
							<div class="card-body">
									<div class="form-group">
										<label for="exampleInputEmail1">Perihal Pengajuan</label>
										<input type="text" name="perihal" class="form-control" placeholder="Perihal" required>
									</div>
									<div class="form-group">
										<label for="exampleInputPassword1">Keterangan</label>
										<textarea name="keterangan" class="form-control"placeholder="Keterangan" required></textarea>
									</div>
									<div class="form-group">
									<?php $no=1; foreach($waka as $row):?>
										<?php endforeach ?>
										<label>Tujuan Pengajuan</label>
										<select name="tujuan" class="form-control select2" style="width: 100%;" required>
										<?php $no=1; foreach($waka as $row):?>
											<?php
                                            if($row['nama_waka']!='KETUA STIKES'){
                                            ?>
                                            <option value="<?= $row['id_waka'];?>" selected><?= $row['nama_waka'];?></option>
                                            <?php } ?>
										<?php endforeach;?>	
										</select>
									</div>
									<div class="form-group">
										<label for="exampleInputFile">File Proposal</label>
										<div class="input-group">
											<div class="custom-file">
												<input type="file" name="filePengajuan" class="custom-file-input" id="exampleInputFile" required>
												<label class="custom-file-label" for="exampleInputFile">Choose file</label>
											</div>
											<div class="input-group-append">
												<span class="input-group-text" id="">Upload</span>
											</div>
										</div>
									</div>
							</div>
							<div class="card-footer">
								<button type="submit" class="btn btn-info" onclick="return confirm('Apakah data Pengajuan anda sudah Benar?');"><i class="far fa-save"></i> SAVE!</button>
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
