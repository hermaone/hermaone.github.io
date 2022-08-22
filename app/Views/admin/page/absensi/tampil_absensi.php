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
                                    Daftar Absensi Karyawan
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
                                                    <th>Institusi</th>
                                                    <th>Nama Lengkap</th>
                                                    <th>Tgl Masuk</th>
                                                    <th>Jam Masuk</th>
                                                    <th>Tgl Pulang</th>
                                                    <th>Jam Pulang</th>
                                                    <th>Keterangan</th>
                                                    <!-- <th style="text-align: center;">Aksi</th> -->
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $no=1; foreach($data as $row):?>
                                                <tr class="odd gradeX">
                                                    <td style="text-align: center;"><?= $no++;?></td>
                                                    <td>073154</td>
                                                    <td><a href="<?= base_url('admin/get_absensi/'.$row['user_name']);?>"><?= $row['nama_lengkap'];?></a></td>
                                                    <td><?= $row['tgl_masuk'];?></td>
                                                    <td><?= $row['jam_masuk'];?></td>
                                                    <td><?= $row['tgl_pulang'];?></td>
                                                    <td><?= $row['jam_pulang'];?></td>
                                                    <td><span class="<?= ($row['keterangan']=='Late') ? 'late' : 'ontime' ;?>"><?= $row['keterangan'];?></span></td>
                                                  <!--  <td style="text-align: center;">
                                                    <a href="<?= base_url('admin/get_absensi/'.$row['user_name']);?>" class="a"><i class="fa fa-fw" aria-hidden="true" title="edit"></i></a></td> -->
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