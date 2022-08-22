<b class="modaldusta"><i class="fa fa-fw" aria-hidden="true" title="Hapus" data-toggle="modal" data-target="#myModal<?= $row['id_kegiatan'];?>"></i></b>
    <div class="modal fade" id="myModal<?= $row['id_kegiatan'];?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="col-md-8">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">HAPUS DATA</h4>
                </div>
                <div class="modal-body">
                    <p>Anda Yakin ingin menghapus Data <b><?= $row['nama_kegiatan'];?> ?</b></p>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-warning radius" href="<?= base_url('admin/update_kegiatan/'. $row['id_kegiatan']);?>">Update</a>
                    <a class="btn btn-danger radius" href="<?= base_url('admin/deleteKegiatan/' . $row['id_kegiatan']);?>">Hapus</a>
                </div>
            </div>
        </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
                       
