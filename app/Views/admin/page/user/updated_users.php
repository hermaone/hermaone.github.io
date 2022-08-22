<?=$this->extend('admin/layout/template');?>
<?=$this->section('content');?>
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="page-header"><?=$title;?></h2>
            </div>
        </div>
            <div class="panel panel-info radius">
                <div class="panel-heading">
                FORM UPDATED USER
                </div>
               	<div class="panel-body">
                    <div class="row">
                        <div class="col-lg-8">
                            <?php $no=1; foreach($users as $row);?>
                           	<form action="<?=base_url('admin/updated_users/'. $row['userid']);?>" method="POST" enctype="multipart/form-data">
                               <?=csrf_field();?>
                               <input type="hidden" name="userid" value="<?= $row['userid'];?>">
                               <input type="hidden" name="namafotolama" value="<?= $row['user_img'];?>"> 
                                <div class="form-group">
                                    <label>Full Name (*)</label>
                                    <input class="form-control" name="fullname" type="text" value="<?= $row['fullname'];?>" placeholder="fullname" required="required" autofocus>
                                </div>
                                <div class="form-group">
                                    <label>Username (*)</label>
                                    <input class="form-control" name="username" type="text" value="<?= $row['username'];?>" placeholder="Username" required="required">
                                </div>
                                <div class="form-group">
                                    <label>Email (*)</label>
                                    <input class="form-control" name="email" type="email" value="<?= $row['email'];?>" placeholder="Email" required="required">
                                </div>

                                <div class="form-group">
                                <label for="no_wa">Nomor Tlp/Wa (*)</label>
                                <div class="mb-3 row">
                                    <div class="col-xs-2">
                                        <input class="form-control formnotlp" type="text" name="no_wa" placeholder="+62 :" aria-label="readonly input example" readonly="" style="width: 123px;">
                                    </div>
                                    
                                    <div class="col-xs-10">
                                        <input type="number" name="no_wa" class="form-control form-registrasi" placeholder="8XXX" value="<?= $row['no_wa']; ?>" required="required">
                                    </div>
                                </div>
                                </div>
                                <div class="form-group">
                                    <label>Role (*)</label>
                                    <select name="role" class="form-control select2 select2-hidden-accessible" style="width: 100%;" data-select2-id="1" tabindex="-1" aria-hidden="true" required="required">
                                        <option value="<?= $row['id_group'];?>"><?= $row['name'];?></option>
                                        <?php $no=1; foreach($role as $r):?>

                                        <option value="<?= $r['id'];?>"><?= $r['name'];?></option>
                                        
                                        <?php endforeach;?>
                                    </select>
                                </div>

                                <p><button type="submit" class="btn btn-info radius"><i class="fa fa-fw" aria-hidden="true" title="Copy to use save"></i> UPDATE</button> 
                                <a class="btn btn-warning radius" href="<?= base_url('admin/setting');?>"><i class="fa fa-fw" aria-hidden="true" title="Kembali"></i> Kembali</a></p>           
                            
                        </div>
                        <div class="col-lg-4">
                            <div class="container-fluid">
                            <div class="card" style="width: 18rem;display: block;margin-left: auto;margin-right: auto;">
                                
                                <img class="thumbnail-image" src="../../assets/home/images/<?= $row['user_img'];?>" title="<?= $row['fullname'];?>">
                                <div class="card-body"><br>
                                    <b><p class="card-text" style="text-align: center;"><?= $row['fullname'];?></p></b>
                                </div>
                                <div class="form-group <?= ($validation->hasError('foto_users')) ? 'has-error' : '' ;?>">
                                    <input class="form-control" name="foto_users" type="file">
                                    <div class="<?= ($validation->hasError('foto_users')) ? 'invalid-feedback' : '' ;?>">
                                        <small><?= $validation->getError('foto_users');?></small>
                                    </div>
                                </div>
                            </div>
                            </div>
                            </form>
                        </div>
                        <!-- /.col-lg-6 (nested) -->
                    </div>
                    <!-- /.row (nested) -->
                </div>
                <!-- /.panel-body -->
            </div>
    </div>          
</div>
<?=$this->endsection();
          