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
                                    List Users
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
                                                    <th>Fullname</th>
                                                    <th>Username</th>
                                                    <th>Email</th>
                                                    <th>Role</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                 <?php $no=1; foreach($users as $row):?>
                                                <tr class="odd gradeX">
                                                    <td><?= $no++;?></td>
                                                    <td><?= $row['fullname'];?></td>
                                                    <td><?= $row['username'];?></td>
                                                    <td><?= $row['email'];?></td>
                                                    <td><?= $row['name'];?></td>
                                                    <td style="text-align: center;">
                                                    <a href="<?= base_url('admin/get_updated_users/'. $row['userid']);?>" class="a"><i class="fa fa-fw" aria-hidden="true" title="edit"></i></a>
                                                    <?php include('delete_users.php');?> 
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