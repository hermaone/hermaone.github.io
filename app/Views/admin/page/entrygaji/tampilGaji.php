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
            <div class="col-lg-3">
                <div class="panel panel-default">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            Kegiatan
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                              <label for="exampleFormControlInput1" class="form-label  <?= ($validation->hasError('id_kegiatan')) ? 'has-error' : '' ;?>">Daftar Kegiatan<sup>*</sup></label>
                                <select name="id_kegiatan" class="f1-last-name select2" Style="width: 100%;" required>
                                  
                                    <?php $no=1; foreach($data as $k):?>
                                    <option value="<?= $k['nama_lengkap'];?>"><?= $k['nama_lengkap'];?></option>
                                    <?php endforeach;?>
                                </select>
                                  <div class="<?= ($validation->hasError('id_kegiatan')) ? 'invalid-feedback' : '' ;?>">
                                    <small><?= $validation->getError('id_kegiatan');?></small>
                                </div>
                                <small id="emailHelp" class="form-text text-muted">Kegiatan Terpilih secara otomatis by Sistem</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        Daftar Karyawan
                    </div>
                    <!-- /.panel-heading -->
                    <?php if (session()->getFlashdata('warning')):?>
                        <div class="alert alert-warning">
                            <?= session()->getFlashdata('warning');?>
                        </div>
                    <?php endif;?>

                    <?php if (session()->getFlashdata('pesan')):?>
                        <div class="alert alert-success">
                            <?= session()->getFlashdata('pesan');?>
                        </div>
                    <?php endif;?>
                <div class="panel-body">
                    

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th style="text-align: center;">Foto</th>
                                    <th>Nama Lengkap</th>
                                    <th>No Karpeg</th>
                                    <th>Jumlah Kehadiran</th>
                                    <th>Gaji Perhari</th>
                                    <th style="text-align: center;">Total Gaji</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                 <?php $no=1; foreach($gaji as $g):?>
                                 <?php endforeach;?>
                                
                                <?php $no=1; foreach($data as $row):?>
                                <?php 

                                    $j_hadir = $jmlHadir;

                                    $total = $j_hadir * $g['salary'];


                                ?> 
                                <tr>
                                    <td><?= $no++;?></td>
                                    <?php
                                    if($row['foto']=='default.svg'){
                                        ?>
                                        <td><img style="width: 3rem;display: block;margin-left: auto;margin-right: auto;" src="../../file_foto/<?= $row['foto'];?>.svg"></td>
                                    <?php } else { 
                                        ?>
                                        <td><img style="width: 3rem;display: block;margin-left: auto;margin-right: auto;" src="../../file_foto/<?= $row['foto'];?>"></td>
                                    <?php }?>

                                    <td><?= $row['nama_lengkap'];?></td>
                                    <td><?= $row['user_name'];?></td>
                                    <td><?= $j_hadir; ?></td>
                                    <td><?= $g['salary'];?></td>
                                    <td style="text-align: center;">
                                        <span><?= $total; ?></span>
                                    </td>
                                </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->

            </div>
                </div>
            </div>
        </div>          
</div>
<?= $this->endSection();?>