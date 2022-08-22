<?= $this->extend('admin/layout/template');?>
<?= $this->section('content');?>
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">

                <h4 class="page-header"><i class="fa fa-fw" aria-hidden="true" title="Copy to use plus-square"> </i>TAMBAH USERS</h4>
            </div>
        </div>       
            <div class="panel panel-info">
                <div class="panel-heading">
                    Users Registrasi
                </div>
                
                <div class="panel-body">
                	<div class="col-md-8">
                		<p> <?= view('Myth\Auth\Views\_message_block') ?></p>
                		<form action="<?= base_url('admin/save_users');?>" method="post">
                			<?= csrf_field() ?>
                			<div class="form-group">
                				<label for="fullname">Nama Lengkap (*)</label>
                				<input type="text" name="nama_lengkap" class="form-control form-registrasi input-upper <?= ($validation->hasError('nama_lengkap')) ? 'has-error' : '' ;?>" placeholder="Nama Lengkap" value="<?= old('nama_lengkap') ?>" required="required">
                                <div class="<?= ($validation->hasError('nama_lengkap')) ? 'invalid-feedback' : '' ;?>">
                                    <small><?= $validation->getError('nama_lengkap');?></small>
                                </div>
                			</div>
                			
                			<div class="form-group">
                				<label for="email">Email Aktif (*) </label>
                				<small id="emailHelp" class="form-text text-muted"><?=lang('Auth.weNeverShare')?></small>
                				<input type="email" name="email" class="form-control form-registrasi <?= ($validation->hasError('email')) ? 'has-error' : '' ;?>" value="<?= old('email') ?>" placeholder="<?=lang('Auth.email')?>" value="<?= old('email') ?>" required="required">
                                <div class="<?= ($validation->hasError('email')) ? 'invalid-feedback' : '' ;?>">
                                    <small><?= $validation->getError('email');?></small>
                                </div>
                			</div>
                			<div class="form-group">
                				<label for="username"><?=lang('Auth.username')?> (*)</label>
                				<input type="number" name="username" class="form-control form-registrasi<?= ($validation->hasError('username')) ? 'has-error' : '' ;?>" placeholder="<?=lang('Auth.username')?>" value="<?= old('username') ?>" required="required">
                                <div class="<?= ($validation->hasError('username')) ? 'invalid-feedback' : '' ;?>">
                                    <small><?= $validation->getError('username');?></small>
                                </div>
                			</div>
                			<div class="form-group">
                				<label for="password"><?=lang('Auth.password')?> (*)</label>
                				<input type="password" name="password" class="form-control pwd <?= ($validation->hasError('password')) ? 'has-error' : '' ;?>" placeholder="<?=lang('Auth.password')?>" autocomplete="off">
                                <div class="<?= ($validation->hasError('password')) ? 'invalid-feedback' : '' ;?>">
                                    <small><?= $validation->getError('password');?></small>
                                </div>
                			</div>
                			<div class="form-group">
                				<label for="pass_confirm"><?=lang('Auth.repeatPassword')?> (*)</label>
                				<input type="password" name="pass_confirm" class="form-control pwd <?= ($validation->hasError('pass_confirm')) ? 'has-error' : '' ;?>" placeholder="<?=lang('Auth.repeatPassword')?>" autocomplete="off">
                                <div class="<?= ($validation->hasError('pass_confirm')) ? 'invalid-feedback' : '' ;?>">
                                    <small><?= $validation->getError('pass_confirm');?></small>
                                </div>
                				<div class="checkbox">
                					<label style="font-size: .8em">
                						<input type="checkbox" class="reveal">
                						<small class="text"> Show Password</small>
                					</label>
                				</div>
                			</div>
                		</div>
                		
                		<div class="container col-md-8">
                			<button class="btn btn-info btn-block btn-login" type="submit" onclick="return confirm('Apakah anda yakin ingin menambahkan users baru?');"><?=lang('Auth.register')?></button><br>
                			
                		</div>
                		
                	</form>
                </div>
                
            </div>
                            
    </div>          
</div>
<?= $this->endSection();?>

