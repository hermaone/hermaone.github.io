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
                    Entry Salary Gaji
                </div>
                 
                <form role="form" action="<?= base_url('admin/saveGaji');?>" method="POST">
                    <?= csrf_field();?>
                    <input type="hidden" name="tgl_post" value="<?php echo date ("Y-m-d h:i:s");?>">
                <div class="panel-body">
                    <div class="form-group <?= ($validation->hasError('salaryGaji')) ? 'has-error' : '' ;?>">
                        <label for="exampleFormControlInput1" class="form-label">Salary Gaji (*)</label>
                        <input type="number" name="salaryGaji" class="form-control" placeholder="Salary Gaji" value="<?= old('salaryGaji') ?>" >
                        <div class="<?= ($validation->hasError('salaryGaji')) ? 'invalid-feedback' : '' ;?>">
                            <small><?= $validation->getError('salaryGaji');?></small>
                        </div>
                    </div>

                    <div class="form-group">
                      <label for="exampleFormControlInput1" class="form-label  <?= ($validation->hasError('jabatan')) ? 'has-error' : '' ;?>">Jabatan<sup>*</sup></label>
                        <select name="jabatan" class="formf1-last-name select2 form-control form-control " Style="width: 100%;" required>
                          <option value="">-pilih Jabatan-</option>
                          <option value="Ketua">Ketua STIKES</option>
                          <option value="Waka">Wakil Ketua</option>
                          <option value="Ka. Prodi">Prodi</option>
                          <option value="Ka. Divisi">Divisi</option>
                          <option value="Staf">Staf</option>
                        </select>
                          <div class="<?= ($validation->hasError('jabatan')) ? 'invalid-feedback' : '' ;?>">
                            <small><?= $validation->getError('jabatan');?></small>
                        </div>
                    </div>


                    <div class="form-group <?= ($validation->hasError('keterangan')) ? 'has-error' : '' ;?>">
                        <label for="exampleFormControlInput1" class="form-label">Keterangan (*)</label>
                        <textarea name="keterangan" class="form-control" rows="3" placeholder="Keterangan"><?= old('keterangan') ?></textarea>
                        <div class="<?= ($validation->hasError('keterangan')) ? 'invalid-feedback' : '' ;?>">
                            <small><?= $validation->getError('keterangan');?></small>
                        </div>
                    </div>

                    <div class="form-group">
                         <button type="submit" class="btn btn-info radius"><i class="fa fa-fw" aria-hidden="true" title="save"></i> Save</button>
                         <button type="reset" class="btn btn-default radius"><i class="fa fa-fw" aria-hidden="true" title="Reset"></i> Reset</button>
                         <a class="btn btn-warning radius" href="<?= base_url('admin/getGaji');?>"><i class="fa fa-fw" aria-hidden="true" title="Kembali"></i> Kembali</a>
                    </div>

                </div>
                </form>
            </div>
                            
    </div>          
</div>
<?= $this->endSection();?>

