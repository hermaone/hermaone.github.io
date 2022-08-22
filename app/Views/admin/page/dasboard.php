<?= $this->extend('admin/layout/template');?>
<?= $this->section('content');?>
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="page-header"><?= $title ?></h2>
            </div>
        </div>       
          	<p>Selamat datang admin <b> <?= user()->fullname;?> </b></p>
    </div>          
</div>
<?= $this->endSection();?>
          