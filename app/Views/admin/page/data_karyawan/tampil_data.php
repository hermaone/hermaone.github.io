<?= $this->extend('admin/layout/template');?>
<?= $this->section('content');?>
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h4 class="page-header"><i class="fa fa-fw" aria-hidden="true" title="Copy to use plus-square-o"></i><?= $title ?></h4>
            </div>
        </div>       
          	 <div class="row">
                        <div class="col-lg-12">
                        <p>
                            <a href="<?= base_url('admin/tambah_users');?>" class="btn btn-info radius"><i class="fa fa-fw" aria-hidden="true" title="Copy to use plus-circle"></i>Tambah Data</a>
                            <a href="<?= base_url('admin/import');?>" class="btn btn-info radius"><i class="fa fa-fw" aria-hidden="true" title="Copy to use cloud-upload"></i>Import Excell</a>
                        </p>
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    Daftar Users Karyawan
                                </div>
                                <!-- /.panel-heading -->
        
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
                                                    <th>Email</th>
                                                    <th style="text-align: center;">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $no=1; foreach($data as $row):?>
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
                                                    <td><?= $row['user_email'];?></td>
                                                    <td style="text-align: center;">
                                                        <a href="<?= base_url('admin/update_users/'. $row['user_id']);?>" ><i class="fa fa-fw" aria-hidden="true" title="UPDATE DATA <?= $row['nama_lengkap'];?>"></i></a>
                                                        <?php include('delete_data.php');?>
                                                    </td>
                                                </tr>
                                                <?php endforeach;?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.table-responsive -->
                                  
                                </div>
                                <!-- /.panel-body -->
                            </div>
                            <!-- /.panel -->
                        </div>
                        <!-- /.col-lg-12 -->
                    </div>
    </div>          
</div>
<?= $this->endSection();?>