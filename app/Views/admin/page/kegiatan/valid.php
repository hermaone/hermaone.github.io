<a href="#"><span style="text-align: left;"><i class="fa fa-fw" aria-hidden="true" title="Validasi" data-toggle="modal" data-target="#myModalvalid<?= $row['user_name'];?>"></i></span></a>

    <div class="modal fade" id="myModalvalid<?= $row['user_name'];?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">1
        <div class="modal-dialog" role="document">
            <div class="col-md-8">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel" style="text-align: left;"><span style="text-align: left;color: #337ab7;font-weight: bold;"><?=$row['nama_lengkap'];?></span></h4>
                    <p style="text-align: left;">Kegiatan : <?=$k['nama_kegiatan'];?></span></p>
                </div>
                <div class="modal-body">
                        <form role="form" action="<?= base_url('admin/save_presensi_kegiatan');?>" method="POST">
                        <?=csrf_field();?>
                        <input type="hidden" name="user_name" value="<?= $row['user_name'];?>">
                        <input type="hidden" name="id_kegiatan" value="<?= $k['id_kegiatan'];?>">
                        <input type="hidden" name="tgl_absen" value="<?php date_default_timezone_set('Asia/Jakarta'); echo date("Y-m-d H:i:s");?>">
                        <h3 style="text-align: center;">Konfirmasi Kehadiran</h3>
                        <div class="form-group">
                            <label class="radio-inline">
                                <input type="radio" name="status" value="Hadir" checked="">Hadir
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="status" value="Alpa">Alpa
                            </label>

                        </div>
                        <br>
                        <br>
                        
                        <div class="bulet">?</div>  
                </div>
                        <div class="modal-footer">
                                <button type="submit" class="btn btn-info radius"><i class="fa fa-fw" aria-hidden="true" title="Validasi"></i>Save</button>
                        </div>
                        </form>
                    </div>
                </div>
                
            </div>
        </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
                       
