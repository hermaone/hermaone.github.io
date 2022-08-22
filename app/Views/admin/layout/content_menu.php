                
<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <li class="sidebar-search">
               <img class="thumbnail-profile" src="../../assets/home/images/<?= user()->user_img;?>" title="<?= user()->fullname;?>">  <b  style="padding: 12px;"><?= user()->fullname;?></b>
            </li>
           
            <li>
                <a href="<?=base_url('/admin') ?>"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
            </li>

            <!-- AKSES ADMIN-->
            <?php if(in_groups('admin')) :?>
            
            <li class="Dropdown">
                <a href="#"><i class="fa fa-fw" aria-hidden="true" title="Copy to use users"></i> DATA KARYAWAN<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="<?= base_url('admin/get_users');?>">DATA USERS</a>
                    </li>
                    <li>
                        <a href="<?= base_url('admin/absensi');?>">DATA ABSENSI</a>
                    </li>
                    
                </ul>
            <!-- /.nav-second-level -->
            </li>
            <li class="Dropdown">
                <a href="#"><i class="fa fa-fw" aria-hidden="true" title="Copy to use folder-open-o"></i> DATA KEGIATAN<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="<?= base_url('admin/get_kegiatan');?>">KEGIATAN</a>
                    </li>
                   
                    <li>
                        <a href="<?= base_url('admin/PresensiKegiatan');?>">PRESENSI KEGIATAN</a>
                    </li>
                    
                </ul>
            <!-- /.nav-second-level -->
            </li>

            <li class="Dropdown">
                <a href="#"><i class="fa fa-fw" aria-hidden="true" title="Copy to use money"></i> PENGGAJIAN<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="<?= base_url('admin/getGaji');?>">ENTRY GAJI</a>
                    </li>
                   
                    <li>
                        <a href="<?= base_url('admin/rekapGaji');?>">REKAP GAJI</a>
                    </li>
                    
                </ul>
            <!-- /.nav-second-level -->
            </li>


            <li class="Dropdown">
                <a href="#"><i class="fa fa-fw" aria-hidden="true" title="Copy to use cogs"></i> SETTING<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="<?= base_url('admin/setting_jam');?>">JAM MASUK/PULANG</a>
                    </li>
                    
                </ul>
            <!-- /.nav-second-level -->
            </li>
            <?php endif ;?>
            <!-- SUPER ADMIN -->
            <?php if(in_groups('superadmin')) :?>
                
            <li class="Dropdown">
                <a href="#"><i class="fa fa-fw" aria-hidden="true" title="Copy to use users"></i> DATA KARYAWAN<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="<?= base_url('admin/get_users');?>">DATA USERS</a>
                    </li>
                    <li>
                        <a href="<?= base_url('admin/absensi');?>">DATA ABSENSI</a>
                    </li>
                    
                </ul>
            <!-- /.nav-second-level -->
            </li>

            <li class="Dropdown">
                <a href="#"><i class="fa fa-fw" aria-hidden="true" title="Copy to use cogs"></i> SETTING<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="<?= base_url('admin/setting_jam');?>">JAM MASUK/PULANG</a>
                    </li>
                    
                </ul>
            <!-- /.nav-second-level -->
            </li>
            <li class="Dropdown">
                <a href="#"><i class="fa fa-fw" aria-hidden="true" title="Copy to use users"></i> MASTER USER'S<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="<?= base_url('admin/setting');?>">SETTING USERS</a>
                    </li>
                    <li>
                        <a href="<?= base_url('admin/registrasi');?>">REGISTRASI</a>
                    </li>
                    <li>
                        <a href="<?= base_url('admin/forgout');?>">FORGOUT PASSWORD</a>
                    </li>
                    
                
                </ul>
            <!-- /.nav-second-level -->
            </li>

            



            <?php endif ;?>

            
    </ul>
</div>
<!-- /.sidebar-collapse -->
</div>
<!-- /.navbar-static-side -->
</nav>
