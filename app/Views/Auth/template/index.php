<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
        <meta name="generator" content="Jekyll v4.1.1">
        <title>KEPEGAWAIAN STIKES NHM</title>
        <!-- Bootstrap Core CSS -->
        <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
        <link href="<?php base_url()?>../../assets/home/css/custom.css" rel="stylesheet">
        <link href="<?php base_url();?>../../assets/home/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php base_url()?>../../assets/home/css/umam.min.css" rel="stylesheet">
        <link href="<?php base_url()?>../../assets/home/css/font-awesome.css" rel="stylesheet">
        
    </head>
    <body style="background-image: url('../../assets/home/images/wizard-v3.jpg');">
        <?= $this->renderSection('content');?>
        <!-- jQuery -->
        <script src="<?php base_url()?>../../assets/home/js/jquery.min.js"></script>
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
    </body>
    
</html> 