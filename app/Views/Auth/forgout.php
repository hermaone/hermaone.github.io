<?= $this->extend('Auth/template/index');?>
<?= $this->section('content');?>
    <div class="registration-form">
        
        <form action="<?= route_to('forgot') ?>" method="post">
            <?= csrf_field() ?>
            <div class="form-icon">
                <span><i class="glyphicon glyphicon-user"><!-- <img src="<?php echo base_url('../../assets/home/images/END_PNG.PNG');?>"> --></i></span>
            </div>
            <h1 style="text-align:center;"><i>O</i>-ND</h1>
            <p style="text-align:center;font-size: 20px;color: #5891ff;"><i>Online</i> Nursing Diagnosis</p>
            <h3><?=lang('Auth.forgotPassword')?> </h3>
             <p>Lupa Kata Password? Tidak masalah! Masukkan email Anda di bawah ini dan kami akan mengirimkan code verifikasi untuk mengatur ulang kata sandi Anda.</p>
            <p><?= view('Myth\Auth\Views\_message_block') ?></p>
            
            <div class="form-group">
                            <label for="email">Email Aktif (*)</label>
                            <input type="email" class="form-control <?php if(session('errors.email')) : ?>is-invalid<?php endif ?>"
                                   name="email" aria-describedby="emailHelp" placeholder="<?=lang('Auth.email')?>">
                                   <small style="color: #908c8c;">Masukan email aktif yang bisa di buka, untuk mereset Password Anda</small>
                            <div class="invalid-feedback">
                                <?= session('errors.email') ?>
                            </div>
                        </div>

                        <br>
            <div class="form-group">
            <button type="submit" class="btn btn-block create-account"><?=lang('Auth.sendInstructions')?></button>
             
            </div>
        </form>
        <div class="social-media">
            <p style="text-align: center;">PKM-PI STIKES NHM</p>
        </div>
        </div>
<?= $this->endSection();?>
    