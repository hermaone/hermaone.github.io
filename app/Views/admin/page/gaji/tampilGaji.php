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
                        <p>
                            <a href="<?= base_url('admin/addGaji');?>" class="btn btn-info radius"><i class="fa fa-fw" aria-hidden="true" title="Copy to use plus-circle"></i>Tambah Gaji</a>
                            
                        </p>
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    Daftar Gaji Karyawan
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
                                                    <th>Salary Gaji</th>
                                                    <th>Tgl Post</th>
                                                    <th>Keterangan</th>
                                                    <th style="text-align: center;">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $no=1; foreach($data as $row):?>
                                                <tr class="odd gradeX">
                                                    <td style="text-align: center;"><?= $no++;?></td>
                                                    <td>Rp. <?= $row['salary'];?></td>
                                                    <td><?= $row['created_at'];?></td>
                                                    <td><?= $row['keterangan'];?></td>
                                                    
                                                  <td style="text-align: center;">
                                                    <a href="<?= base_url('admin/updateGaji/'.$row['id_gaji']);?>"><i class="fa fa-fw" aria-hidden="true" title="edit"></i></a>
                                                    <?php include('deleteGaji.php');?>
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