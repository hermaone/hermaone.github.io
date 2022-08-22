<?= $this->extend('admin/layout/template');?>
<?= $this->section('content');?>
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h4 class="page-header"><?= $title ?></h4>
            </div>
        </div>       
            <div class="panel panel-info">
                <div class="panel-heading">
                    Update Data Sekolah
                </div>
                 <?php $no=1; foreach($data as $row);?>

                 <form role="form" action="<?= base_url('admin/save_update_jam/'. $row['id_waktu']);?>" method="POST">
                  <?=csrf_field();?>
                  <?php
                  date_default_timezone_set("Asia/Bangkok");
                  $tgl = date('d-M-Y:H:i:sa');
                  ?>
                  <input type="hidden" name="id" value="<?= $row['id_waktu'];?>">
                  <input type="hidden" name="tgl" value="<?= $tgl;?>">
                <div class="panel-body">
                    <div class="form-group <?= ($validation->hasError('jam_masuk')) ? 'has-error' : '' ;?>">
                        <label for="exampleFormControlInput1" class="form-label">Jam Masuk (*)</label>
                        <input type="time" name="jam_masuk" class="form-control" value="<?= $row['jam_masuk'];?>" placeholder="Data sekolah" >
                        <div class="<?= ($validation->hasError('jam_masuk')) ? 'invalid-feedback' : '' ;?>">
                            <small><?= $validation->getError('jam_masuk');?></small>
                        </div>
                    </div>

                    <div class="form-group <?= ($validation->hasError('jam_pulang')) ? 'has-error' : '' ;?>">
                        <label for="exampleFormControlInput1" class="form-label">Jam Pulang (*)</label>
                        <input type="time" name="jam_pulang" class="form-control" value="<?= $row['jam_pulang'];?>" placeholder="Data sekolah" >
                        <div class="<?= ($validation->hasError('jam_pulang')) ? 'invalid-feedback' : '' ;?>">
                            <small><?= $validation->getError('jam_pulang');?></small>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlTextarea1" class="form-label">Keterangan</label>
                        <textarea class="form-control" name="keterangan" rows="3"><?= $row['keterangan'];?></textarea>
                    </div>

                    <div class="form-group">
                         <button type="submit" class="btn btn-info radius"><i class="fa fa-fw" aria-hidden="true" title="save"></i> Update</button>
                         <a class="btn btn-warning radius" href="<?= base_url('admin/setting_jam');?>"><i class="fa fa-fw" aria-hidden="true" title="Kembali"></i> Kembali</a>
                    </div>

                </div>
                </form
            </div>
                            
    </div>          
</div>
<?= $this->endSection();?>