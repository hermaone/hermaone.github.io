<?= $this->extend('admin/layout/template');?>
<?= $this->section('content');?>
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h4 class="page-header"><?= $title ?></h4>
            </div>
        </div>       
             <div class="row">
                        <div class="col-lg-12">
                      
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    Pilih Pegawai
                                </div>
                                <!-- /.panel-heading -->
        
                                <?php if (session()->getFlashdata('pesan')):?>
                                    <div class="alert alert-success">
                                        <?= session()->getFlashdata('pesan');?>
                                    </div>
                                <?php endif;?>
                                
                                <div class="panel-body">
                                    <form action="<?=base_url('admin/chekGaji');?>" method="POST"class="f1">
                                  <?=csrf_field();?>
                                   
                                    <div class="form-group">
                                      <label for="exampleFormControlInput1" class="form-label  <?= ($validation->hasError('user_name')) ? 'has-error' : '' ;?>">Daftar Nama<sup>*</sup></label>
                                      <select name="user_name" class="f1-last-name select2" Style="width: 100%;" required>
                                          <option value="">-pilih Nama Karyawan-</option>
                                        <?php $no=1; foreach($data as $row):?>
                                            <option value="<?= $row['user_name'];?>"><?= $row['user_name'];?>-<?= $row['nama_lengkap'];?></option>
                                        <?php endforeach;?>
                                      </select>
                                      <div class="<?= ($validation->hasError('user_name')) ? 'invalid-feedback' : '' ;?>">
                                        <small><?= $validation->getError('user_name');?></small>
                                    </div>
                                      <small id="emailHelp" class="form-text text-muted">Silahkan Pilih Pegawai</small>
                                  </div>
                                  <div class="f1-buttons">
                                      <button type="submit" class="btn btn-info btn-login">Pilih <i class="fa fa-save" aria-hidden="true" title="Next"></i></button>
                                  </div>
                                </form>
                            </div>
                            <!-- /.panel -->
                        </div>
                        <!-- /.col-lg-12 -->
                    </div>
    </div>          
</div>
<?= $this->endSection();?>