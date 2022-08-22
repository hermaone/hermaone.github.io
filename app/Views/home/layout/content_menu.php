<!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?= base_url('home/dasboard');?>" class="brand-link">
      <img src="<?= base_url('../../img/logostikes.png');?>" alt="Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">KEPEGAWAIAN NHM</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
            <?php
            if($session->get('foto')=='default.svg'){
                ?>
                <img src="<?= base_url('../../file_foto/'.$session->get('foto'));?>.svg" class="img-circle elevation-2" alt="User Image">
            <?php } else { 
                ?>
                 <img src="<?= base_url('../../file_foto/'.$session->get('foto'));?>" class="img-circle elevation-2" alt="User Image" style="width: 100px;height: 100px;">
            <?php }?>
         
        </div>
        <div class="info">
          <a href="#" class="d-block"><?= $session->get('nama_lengkap');?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
         <li class="nav-item">
            <a href="<?= base_url('home/dasboard');?>" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>DASBOARD</p>
            </a>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>PENGAJUAN<i class="fas fa-angle-left right"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?= base_url('home/riwayatPengajuan');?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>RIWAYAT PENGAJUAN</p>
                </a>
              </li>
             
            </ul>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-book"></i>
              <p>
                DATAKU
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview" style="display: none;">
              <li class="nav-item">
                <a href="<?= base_url('home/riwayat_absensi');?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>RIWAYAT ABSENSI</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('home/profileKu');?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>PROFILEKU</p>
                </a>
              </li>
              
              <li class="nav-item">
                <a href="<?= base_url('home/pekerjaan');?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>PEKERJAAN HARI INI</p>
                </a>
              </li>
             
            </ul>
          </li>
          <li class="nav-item">
            <a href="<?= base_url('home/logout');?>" onclick="return confirm('Apakah anda yakin ingin Logout?');" class="nav-link">
              <i class="fas fa-sign-out-alt"></i>
              <p>
                LOGOUT
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
  
