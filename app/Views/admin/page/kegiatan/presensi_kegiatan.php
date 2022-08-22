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
                                    Pilih Kegiatan
                                </div>
                                <!-- /.panel-heading -->
        
                                <?php if (session()->getFlashdata('pesan')):?>
                                    <div class="alert alert-success">
                                        <?= session()->getFlashdata('pesan');?>
                                    </div>
                                <?php endif;?>
                                <?php $no=1; foreach($data as $row);?>
                                <div class="panel-body">
                                    <form action="<?=base_url('admin/tampil_presensi_kegiatan');?>" method="POST"class="f1">
                                  <?=csrf_field();?>
                                    <div class="form-group">
                                      <label for="exampleFormControlInput1" class="form-label  <?= ($validation->hasError('id_kegiatan')) ? 'has-error' : '' ;?>">Daftar Kegiatan<sup>*</sup></label>
                                      <select name="id_kegiatan" class="f1-last-name select2" Style="width: 100%;" required>
                                          <option value="">-pilih Kegiatan-</option>
                                        <?php $no=1; foreach($data as $row):?>
                                            <option value="<?= $row['id_kegiatan'];?>"><?= $row['nama_kegiatan'];?></option>
                                        <?php endforeach;?>
                                      </select>
                                      <div class="<?= ($validation->hasError('id_kegiatan')) ? 'invalid-feedback' : '' ;?>">
                                        <small><?= $validation->getError('id_kegiatan');?></small>
                                    </div>
                                      <small id="emailHelp" class="form-text text-muted">Silahkan Pilih Kegiatan</small>
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