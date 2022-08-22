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
                                    Daftar Mahasiswa Baru STIKES NHM
                                </div>
                                <div class="panel-body">
                                    <!-- Tab panes -->
                                    <div class="tab-content">
                                        <div class="tab-pane fade active in" id="home">
                                            
                                        <br>
                                        <a href="<?= base_url('admin/cetak_kartu_semua');?>" target="_blank" class="btn btn-info radius btn-sm"><i class="fa fa-fw" aria-hidden="true" title="Cetak Kartu Ujian"></i>Cetak Semua</a>
                                                <div class="row">
                                                <div class="panel-body">
                                                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                                        <thead>
                                                            <tr>
                                                                <th rowspan="2" style="padding-bottom: 30px;">No</th>
                                                                <th rowspan="2" style="padding-bottom: 30px;">NIK</th>
                                                                 <th rowspan="2" style="padding-bottom: 30px;">Cetak</th>
                                                                <th rowspan="2" style="padding-bottom: 30px;">foto</th>
                                                                <th rowspan="2" style="padding-bottom: 18px;">Nama Mahasiswa</th>
                                                                <th rowspan="2" style="padding-bottom: 18px;">Jalur Penerimaan</th>
                                                                <th colspan="2" style="text-align: center;">Program Studi</th>
                                                            </tr>
                                                            <tr>
                                                                <th>Pilihan1</th>
                                                                <th>Pilihan2</th>
                                                            </tr>
                                                        </thead>

                                                        <tbody>
                                                            <?php $no=1; foreach($data as $row):?>
                                                            <tr>
                                                                <td><?= $no++;?></td>
                                                                <td><?= $row['nikmaba'];?></td>
                                                                <td align="center"><a href="<?= base_url('admin/cetak_kartu_pdf/'.$row['nikmaba']);?>" target="_blank"><i class="fa fa-fw" aria-hidden="true" title="Cetak Kartu Ujian"></i>Cetak</a></td>
                                                                <td>
                                                                    <img class="thumbnail-image" style="width: 3rem;display: block;margin-left: auto;margin-right: auto;" src="../../file_foto_maba/<?= $row['foto_maba'];?>">
                                                                </td>
                                                                <td><?= $row['fullname'];?></td>
                                                                <td><?= $row['jalur_penerimaan'];?></td>
                                                                <td><?= $row['prodi_satu'];?></td>
                                                                <td><?= $row['prodi_dua'];?></td>    
                                                            </tr>
                                                            <?php endforeach;?>

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                                <!-- /.table-responsive -->

                                            </div>
                                            <!-- /.panel-body -->
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                            <!-- /.panel -->
                        </div>
                        <!-- /.col-lg-12 -->
                    </div>
    </div>          
</div>
<?= $this->endSection();?>