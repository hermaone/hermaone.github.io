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
                <?php $no=1; foreach($users as $row);?>
                <div class="panel-body">
                	<div class="col-md-8">
                		<p> <?= view('Myth\Auth\Views\_message_block') ?></p>
                		<form action="<?= base_url('admin/save_update_users/'. $row['user_id']);?>" method="post">
                			<?= csrf_field() ?>
                            <input type="hidden" name="id" value="<?= $row['user_id'];?>">
                			<div class="form-group">
                				<label for="fullname">Nama Lengkap (*)</label>
                				<input type="text" name="nama_lengkap" class="form-control form-registrasi input-upper <?= ($validation->hasError('nama_lengkap')) ? 'has-error' : '' ;?>" placeholder="Nama Lengkap" value="<?= $row['nama_lengkap']; ?>" required="required">
                                <div class="<?= ($validation->hasError('nama_lengkap')) ? 'invalid-feedback' : '' ;?>">
                                    <small><?= $validation->getError('nama_lengkap');?></small>
                                </div>
                			</div>
                			
                			<div class="form-group">
                				<label for="email">Email Aktif (*) </label>
                				<small id="emailHelp" class="form-text text-muted"><?=lang('Auth.weNeverShare')?></small>
                				<input type="email" name="email" class="form-control form-registrasi <?= ($validation->hasError('email')) ? 'has-error' : '' ;?>" value="<?= $row['user_email']; ?>" placeholder="<?=lang('Auth.email')?>" value="<?= old('email') ?>" required="required">
                                <div class="<?= ($validation->hasError('email')) ? 'invalid-feedback' : '' ;?>">
                                    <small><?= $validation->getError('email');?></small>
                                </div>
                			</div>
                			<div class="form-group">
                				<label for="username"><?=lang('Auth.username')?> (*)</label>
                				<input type="number" name="username" class="form-control form-registrasi<?= ($validation->hasError('username')) ? 'has-error' : '' ;?>" placeholder="<?=lang('Auth.username')?>" value="<?= $row['user_name']; ?>" required="required">
                                <div class="<?= ($validation->hasError('username')) ? 'invalid-feedback' : '' ;?>">
                                    <small><?= $validation->getError('username');?></small>
                                </div>
                			</div>
                			
                			
                		</div>
                		
                		<div class="container col-md-8">
                			<button class="btn btn-info btn-block btn-login" type="submit" onclick="return confirm('Apakah anda yakin ingin menambahkan users baru?');">UPDATED</button><br>
                			
                		</div>
                		
                	</form>
                </div>
                
            </div>
                            
    </div>          
</div>
<?= $this->endSection();?>

