<?= $this->extend('Auth/template/index');?>
<?= $this->section('content');?>
    <div class="registration-form">
    	
        <form action="<?= base_url('home/auth');?>" method="post">
			<?= csrf_field() ?>
			<?php if(session()->getFlashdata('msg')):?>
                    <div class="alert alert-danger"><?= session()->getFlashdata('msg') ?></div>
                <?php endif;?>
            <div class="form-icon">
                <span><i class="glyphicon glyphicon-user"><!-- <img src="<?php echo base_url('../../assets/home/images/END_PNG.PNG');?>"> --></i></span>
            </div>
            <h3 style="text-align:center;">SYSTEM KEPEGAWAIAN</h3>
            <p style="text-align:center;font-size: 20px;color: #5891ff;">STIKES Ngudia Husada Madura</p>
			<p><?=lang('Auth.loginTitle')?> Menggunakan Karpeg Anda </p>
			<p><?= view('Myth\Auth\Views\_message_block') ?></p>
            <div class="input-group grup-login">
					<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
					
					<input type="number" name="email" class="form-control" placeholder="Username" style="padding: 20px;">
					
					
				</div><small id="emailHelp" class="form-text text-muted">Karpeg</small>
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
				</div><small id="emailHelp" class="form-text text-muted">Password Login</small><br>
				
				<div class="form-check">
					<label class="form-check-label">
						<input type="checkbox" name="remember" class="form-check-input" <?php if(old('remember')) : ?> checked <?php endif ?>>
						<small><?=lang('Auth.rememberMe')?></small>
					</label>
				</div>

				<div class="form-group">
                <button type="submit" class="btn btn-block create-account">LOGIN</button>
             
            	</div>
        </form>
        <div class="social-media">
            <p style="text-align: center;">IT SOFTWARE NHM</p>
        </div>
        </div>
<?= $this->endSection();?>
    