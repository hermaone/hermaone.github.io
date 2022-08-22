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
                    Data Kegiatan
                </div>
                 
                <form role="form" action="<?= base_url('admin/save_kegiatan');?>" method="POST">
                    <?= csrf_field();?>
                    <input type="hidden" name="tgl_post" value="<?php echo date ("Y-m-d h:i:s");?>">
                <div class="panel-body">
                    <div class="form-group <?= ($validation->hasError('nama_kegiatan')) ? 'has-error' : '' ;?>">
                        <label for="exampleFormControlInput1" class="form-label">Nama Kegiatan (*)</label>
                        <input type="text" name="nama_kegiatan" class="form-control" placeholder="Nama Kegiatan" value="<?= old('nama_kegiatan') ?>" >
                        <div class="<?= ($validation->hasError('nama_kegiatan')) ? 'invalid-feedback' : '' ;?>">
                            <small><?= $validation->getError('nama_kegiatan');?></small>
                        </div>
                    </div>

                    <div class="form-group <?= ($validation->hasError('deskripsi_kegiatan')) ? 'has-error' : '' ;?>">
                        <label for="exampleFormControlInput1" class="form-label">Deskripsi Kegiatan (*)</label>
                        <textarea name="deskripsi_kegiatan" class="form-control" rows="3" placeholder="Deskripsi Kegiatan"><?= old('deskripsi_kegiatan') ?></textarea>
                        <div class="<?= ($validation->hasError('deskripsi_kegiatan')) ? 'invalid-feedback' : '' ;?>">
                            <small><?= $validation->getError('deskripsi_kegiatan');?></small>
                        </div>
                    </div>

                    <div class="form-group">
                         <button type="submit" class="btn btn-info radius"><i class="fa fa-fw" aria-hidden="true" title="save"></i> Save</button>
                         <button type="reset" class="btn btn-default radius"><i class="fa fa-fw" aria-hidden="true" title="Reset"></i> Reset</button>
                         <a class="btn btn-warning radius" href="<?= base_url('admin/get_kegiatan');?>"><i class="fa fa-fw" aria-hidden="true" title="Kembali"></i> Kembali</a>
                    </div>

                </div>
                </form>
            </div>
                            
    </div>          
</div>
<?= $this->endSection();?>

