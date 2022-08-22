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

        <!-- Bootstrap Core CSS -->
        <link href="<?php base_url();?>../../assets/admin/css/bootstrap.min.css" rel="stylesheet">

        <!-- MetisMenu CSS -->
        <link href="<?php base_url();?>../../assets/admin/css/metisMenu.min.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="<?php base_url();?>../../assets/admin/css/startmin.css" rel="stylesheet">

        <link href="<?php base_url();?>../../assets/admin/css/admin-custom.css" rel="stylesheet">

        <link href="<?php base_url();?>../../assets/admin/css/metisMenu.min.css" rel="stylesheet">

        <link href="<?php base_url();?>../../assets/admin/css/dataTables/dataTables.bootstrap.css" rel="stylesheet">

        <link href="<?php base_url();?>../../assets/admin/css/custom.css" rel="stylesheet">

        <link href="<?php base_url()?>../../assets/home/css/select2.min.css" rel="stylesheet"> 

        <link href="<?php base_url();?>../../assets/admin/css/dataTables/dataTables.responsive.css" rel="stylesheet">


        

        <!-- Custom Fonts -->
        <link href="<?php base_url();?>../../assets/admin/css/font-awesome.min.css" rel="stylesheet" type="text/css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
         <?= $this->include('admin/layout/navbar');?>
        <!-- /.navbar-top-links -->
        <?= $this->include('admin/layout/content_menu');?>        
        <?= $this->renderSection('content');?>
        <!-- Page Content -->
                <!-- /#wrapper -->

        <!-- jQuery -->
        <script src="<?php base_url();?>../../assets/admin/js/jquery.min.js"></script>
        <!-- Custom Theme JavaScript -->
        <script src="<?php base_url();?>../../assets/admin/js/startmin.js"></script>
        <script src="<?php base_url();?>../../assets/admin/js/jquery.min.js"></script>
        <!-- Bootstrap Core JavaScript -->
        <script src="<?php base_url();?>../../assets/admin/js/bootstrap.min.js"></script>
        <!-- Metis Menu Plugin JavaScript -->
        <script src="<?php base_url();?>../../assets/admin/js/metisMenu.min.js"></script>
        <!-- DataTables JavaScript -->
        <script src="<?php base_url();?>../../assets/admin/js/dataTables/jquery.dataTables.min.js"></script>
        <script src="<?php base_url();?>../../assets/admin/js/dataTables/dataTables.bootstrap.min.js"></script>

        <script src="<?php base_url()?>../../assets/home/js/select2.full.min.js"></script>

        <!-- Custom Theme JavaScript -->
        <script src="<?php base_url();?>../../assets/admin/js/startmin.js"></script>

        <script src="<?php base_url();?>../../assets/admin/dist/sweetalert2.all.min.js"></script>

        <!-- Page-Level Demo Scripts - Tables - Use for reference -->
        <script>
            $(document).ready(function() {
                $('#dataTables-example').DataTable({
                        responsive: true
                });
            });
        </script>
        <script type="text/javascript">
            $('.carousel').carousel({
            interval: 2000
            })
            $(function() {
                $( "li.dropdown" ).hover(
                    function() {
                        $( this ).addClass( "open" );
                    },
                    function(){ $(this).removeClass( "open" ) }
                );      
            });
        </script>

        <script>
          $(function () {
            //Initialize Select2 Elements
            $('.select2').select2()

            //Initialize Select2 Elements
            $('.select2bs4').select2({
              theme: 'bootstrap4'
            })
          })
        </script>
         <script type="text/javascript">  
            $(".reveal").on('click',function() {
                var $pwd = $(".pwd");
                if ($pwd.attr('type') === 'password') {
                    $pwd.attr('type', 'text');
                } else {
                    $pwd.attr('type', 'password');
                }
            });
        </script>
        <script>
          // ketika document sudah siap (termasuk jquery sudah terload)
          $(document).ready(function() {
            // tunggu jika ada input di element yang punya class 'input-upper'
            $('.input-upper').bind('input', function() {
              // ubah nilainya menjadi kapital
              $(this).val($(this).val().toUpperCase())
          })
        })
        </script>
        
    </body>
</html>

