<?= $this->extend('Auth/template/index');?>
<?= $this->section('content');?>
    <div class="registration-form">
    	
        <form action="<?= route_to('login') ?>" method="post">
			<?= csrf_field() ?>
            <div class="form-icon">
                <span><i class="glyphicon glyphicon-user"><!-- <img src="<?php echo base_url('../../assets/home/images/END_PNG.PNG');?>"> --></i></span>
            </div>
            <h3 style="text-align:center;">ADMINISTRATOR</h3>
            <p style="text-align:center;font-size: 20px;color: #5891ff;">SYTEM KEPEGAWAIAN NHM</p>
			<p><?=lang('Auth.loginTitle')?> Menggunakan Account Anda </p>
			<p><?= view('Myth\Auth\Views\_message_block') ?></p>
            <div class="input-group grup-login">
					<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
					<input id="username" type="text" class="form-control form-login <?php if(session('errors.login')) : ?>is-invalid<?php endif ?>"
					name="login" placeholder="<?=lang('Auth.emailOrUsername')?>" style="padding: 20px;">
					<div class="invalid-feedback">
						<?= session('errors.login') ?>
					</div>
				</div><small id="emailHelp" class="form-text text-muted"><?=lang('Auth.emailOrUsername')?></small>
				<br>
				<br>
				<div class="input-group grup-login">
					<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
					<input type="password" name="password" class="form-control pwd <?php if(session('errors.password')) : ?>is-invalid<?php endif ?>" placeholder="<?=lang('Auth.password')?>" style="padding: 20px;">
					<div class="invalid-feedback">
						<?= session('errors.password') ?>
					</div>
					<span class="input-group-btn">
			            <button class="btn btn-default reveal" type="button" style="padding: 10px;"><i class="glyphicon glyphicon-eye-open"></i></button>
			         </span>
				</div><small id="emailHelp" class="form-text text-muted">Password 8 Caracter</small><br>
				<p style="float: right;"><a href="<?= route_to('forgot') ?>"><?=lang('Auth.forgotYourPassword')?></a></p>
				<!-- <p style="float: right;"><a href="<?= base_url('home/lupa_password');?>">Lupa Password.?</a></p> -->
				<div class="form-check">
					<label class="form-check-label">
						<input type="checkbox" name="remember" class="form-check-input" <?php if(old('remember')) : ?> checked <?php endif ?>>
						<small><?=lang('Auth.rememberMe')?></small>
					</label>
				</div>

				<div class="form-group">
                <button type="submit" class="btn btn-block create-account"><?=lang('Auth.loginAction')?></button>
              <!--  <p><a href="<?= route_to('register') ?>"><?=lang('Auth.needAnAccount')?></a></p> -->
            	</div>
        </form>
        <div class="social-media">
            <p style="text-align: center;">PKM-PI STIKES NHM</p>
        </div>
        </div>
<?= $this->endSection();?>
    