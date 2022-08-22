<?= $this->extend('admin/layout/template');?>
<?= $this->section('content');?>
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">

                <h4 class="page-header"><i class="fa fa-fw" aria-hidden="true" title="Copy to use plus-square"> </i><?= $title ?></h4>
            </div>
        </div>       
            <div class="panel panel-info">
                <div class="panel-heading">
                    Users Registrasi
                </div>
                
                <div class="panel-body">
                	<div class="col-md-8">
                		<p> <?= view('Myth\Auth\Views\_message_block') ?></p>
                		<form action="<?= route_to('register') ?>" method="post">
                			<?= csrf_field() ?>
                			<div class="form-group">
                				<label for="fullname">Nama Lengkap (*)</label>
                				<input type="text" name="fullname" class="form-control form-registrasi input-upper" placeholder="Nama Lengkap" value="<?= old('fullname') ?>" required="required">
                			</div>
                			<div class="form-group">
                				<label for="no_wa">Nomor Tlp/Wa (*)</label>
                				<div class="mb-3 row">
                					<div class="col-xs-2">
                						<input class="form-control formnotlp" type="text" name="no_wa" placeholder="+62 :" aria-label="readonly input example" readonly="" style="width: 123px;">
                					</div>
                					
                					<div class="col-xs-10">
                						<input type="number" name="no_wa" class="form-control form-registrasi<?php if(session('errors.no_wa')) : ?>is-invalid<?php endif ?>" value="<?= old('no_wa') ?>" placeholder="8XXX" value="<?= old('no_wa') ?>" required="required">
                					</div>
                				</div>
                			</div>
                			<div class="form-group">
                				<label for="email"><?=lang('Auth.email')?> Aktif (*) </label>
                				<small id="emailHelp" class="form-text text-muted"><?=lang('Auth.weNeverShare')?></small>
                				<input type="email" name="email" class="form-control form-registrasi <?php if(session('errors.email')) : ?>is-invalid<?php endif ?>" value="<?= old('email') ?>" placeholder="<?=lang('Auth.email')?>" value="<?= old('email') ?>" required="required">

                			</div>
                			<div class="form-group">
                				<label for="username"><?=lang('Auth.username')?> (*)</label>
                				<input type="text" name="username" class="form-control form-registrasi<?php if(session('errors.username')) : ?>is-invalid<?php endif ?>" placeholder="<?=lang('Auth.username')?>" value="<?= old('username') ?>" required="required">
                			</div>
                			<div class="form-group">
                				<label for="password"><?=lang('Auth.password')?> (*)</label>
                				<input type="password" name="password" class="form-control pwd <?php if(session('errors.password')) : ?>is-invalid<?php endif ?>" placeholder="<?=lang('Auth.password')?>" autocomplete="off">
                			</div>
                			<div class="form-group">
                				<label for="pass_confirm"><?=lang('Auth.repeatPassword')?> (*)</label>
                				<input type="password" name="pass_confirm" class="form-control pwd <?php if(session('errors.pass_confirm')) : ?>is-invalid<?php endif ?>" placeholder="<?=lang('Auth.repeatPassword')?>" autocomplete="off">
                				<div class="checkbox">
                					<label style="font-size: .8em">
                						<input type="checkbox" class="reveal">
                						<small class="text"> Show Password</small>
                					</label>
                				</div>
                			</div>
                		</div>
                		
                		<div class="container col-md-8">
                			<button class="btn btn-info btn-block btn-login" type="submit" onclick="return window.alert('klik Activate account yang telah dikirim melalui email anda');"><?=lang('Auth.register')?></button><br>
                			
                		</div>
                		
                	</form>
                </div>
                
            </div>
                            
    </div>          
</div>
<?= $this->endSection();?>

