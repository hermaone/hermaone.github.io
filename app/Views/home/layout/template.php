<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <!-- <meta http-equiv="refresh" content="3600"/> -->
        <title><?= $title ;?></title>

        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>

        <link href="<?php base_url();?>../../assets/home/plugins/select2/css/select2.min.css" rel="stylesheet">
        <link href="<?php base_url();?>../../assets/home/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css" rel="stylesheet">
        <!-- Bootstrap Core CSS -->
        <link href="<?php base_url();?>../../assets/home/plugins/fontawesome-free/css/all.min.css" rel="stylesheet">
        <link href="<?php base_url();?>../../assets/home/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet">
        <link href="<?php base_url();?>../../assets/home/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
        <link href="<?php base_url();?>../../assets/home/dist/css/adminlte.min.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

        <link href="<?php base_url();?>../../assets/home/css/umam.min.css" rel="stylesheet">
        
    </head>
    <body>
        <?= $this->include('home/layout/navbar');?>
        <!-- /.navbar-top-links -->
        <?= $this->include('home/layout/content_menu');?>        
        <?= $this->renderSection('content');?>
        <?= $this->include('home/layout/footer');?>
        <!-- Page Content -->
        <!-- jQuery -->
        <script src="<?php base_url()?>../../assets/home/plugins/jquery/jquery.min.js"></script>
        <script src="<?php base_url()?>../../assets/home/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="<?php base_url()?>../../assets/home/dist/js/adminlte.min.js"></script>
        <script src="<?php base_url()?>../../assets/home/plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="<?php base_url()?>../../assets/home/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
        <script src="<?php base_url()?>../../assets/home/plugins/select2/js/select2.full.min.js"></script>

        <script src="<?php base_url()?>../../assets/home/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
        <script src="<?php base_url()?>../../assets/home/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
         <script src="<?php base_url()?>../../assets/home/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
        
        <!-- jQuery -->
        <script>
          $(function () {
            $("#example1").DataTable({
              "responsive": true,
              "autoWidth": false,
          });
            $('#example2').DataTable({
              "paging": true,
              "lengthChange": false,
              "searching": false,
              "ordering": true,
              "info": true,
              "autoWidth": false,
              "responsive": true,
          });
             //Initialize Select2 Elements
             $('.select2').select2()
            //Initialize Select2 Elements
            $('.select2bs4').select2({
              theme: 'bootstrap4'
            })
        });
    </script>

    <script type="text/javascript">
      $(document).ready(function () {
        bsCustomFileInput.init();
      });
    </script>

   
        
    </body>
</html>

