<?= $this->extend('admin/layout/template');?>
<?= $this->section('content');?>

<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h3 class="page-header"><?= $title;?> : <?= user()->fullname;?></h3>
            </div>
        </div>
            <div class="row">     
                <?php $no=1; foreach($detail as $row);?>
                <div class="col-lg-9">
                    <div class="card mb-3" style="max-width: 540px;">
                        <div class="row g-0">
                        <div class="col-md-4">
                            <img src="../../assets/home/images/<?= user()->user_img;?>" title="<?= user()->fullname;?>" class="img-fluid rounded-start">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h3 class="card-title"><?= $row['fullname'];?></h3>
                                <table>
                                    <tr>
                                        <th>Email</th><th class="profile">:</th><td class="profile"><?=$row['email'];?></td>
                                    </tr>
                                    <tr>
                                        <th>No WhatsApps</th><th class="profile">:</th><td class="profile">+62 <?=$row['no_wa'];?></td>
                                    </tr>
                                    <tr>
                                        <th>Role</th><th class="profile">:</th><td class="profile"><span class="text-admin"><?=$row['name'];?></span></td>
                                    </tr>


                                </table>
                                <p class="card-text"><small class="text-muted">Created At : <?= $row['tgl_registrasi'];?></small></p>
                            </div>
                        </div>
                        </div>
                    </div>
                    
                </div>
            </div>
    </div>          
</div>
<?= $this->endSection();?>
          