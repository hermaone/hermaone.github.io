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
                        Import Users Karyawan
                    </div>
                    <div class="panel-body">
                        <?php if (session()->getFlashdata('pesan')):?>
                            <div class="alert alert-warning">
                                <?= session()->getFlashdata('pesan');?>
                            </div>
                        <?php endif;?>
                        <?php if (session()->getFlashdata('gagal')):?>
                            <div class="alert alert-danger">
                                <?= session()->getFlashdata('gagal');?>
                            </div>
                        <?php endif;?>
                        <div class="row">
                            <div class="col-xs-6">
                                <form action="<?=base_url('admin/save_add_import');?>" method="POST" enctype="multipart/form-data">
                                    <div class="form-group <?= ($validation->hasError('data_karyawan')) ? 'has-error' : '' ;?>">
                                        <label>File Data Karyawan</label>
                                        <input type="file" name="data_karyawan" required="required">
                                        <div class="<?= ($validation->hasError('data_karyawan')) ? 'invalid-feedback' : '' ;?>">
                                        <small><?= $validation->getError('data_karyawan');?></small>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submite" class="btn btn-info radius">IMPORT <i class="fa fa-save" aria-hidden="true" title="Next"></i></button>
                                    </div>
                                </form>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label></label><br>
                                <a href="<?= base_url('../../template_excel/tempdatedatakepegawaian.xlsx');?>" class="btn btn-outline btn-info btn-sm radius" style="display: block;width: min-content;margin-left: auto;margin-right: auto;"><i class="fa fa-fw" aria-hidden="true" title="Copy to use cloud-download"></i>Download Template</a>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <p><a href="<?= base_url('admin/get_users');?>" class="btn btn-info radius btn-sm" style="float: right;"><i class="fa fa-fw" aria-hidden="true" title="Kembali"></i>KEMBALI</a></p>
                        
                        
                    </div>
                </div>
                </div>  
            </div>
    </div>          
</div>
<?= $this->endSection();?>