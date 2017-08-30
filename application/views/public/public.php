<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $judul_pendek; ?> | <?php echo $iden_data['nm_website']; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="<?php echo base_url(); ?>templates/guesthouse/images/favicon/favicon.png">
    <link rel="stylesheet" href="<?php echo base_url(); ?>templates/guesthouse/css/style.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>templates/guesthouse/css/responsive.css">

    <meta name="description" content="<?php echo $iden_data['meta_deskripsi'];?>">
    <meta name="keywords" content="<?php echo $iden_data['meta_keyword'];?>">
    
</head>
<body>
<!-- main wrapper -->
<div class="wrapper">
    <!-- header -->
    <?php $this->load->view('includes/public-header'); ?>
    <!-- /header -->

    <?php $this->load->view($main_view); ?>

    <!-- footer -->
    <?php $this->load->view('includes/public-footer'); ?>
</div>
<!-- /footer -->
<!-- Scripts -->



<script type="text/javascript" src="<?php echo base_url(); ?>templates/guesthouse/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>templates/guesthouse/js/tether.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>templates/guesthouse/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>templates/guesthouse/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>templates/guesthouse/js/moment.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>templates/guesthouse/js/jquery.smartmenus.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>templates/guesthouse/js/jquery.parallax.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>templates/guesthouse/js/jquery.shuffle.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>templates/guesthouse/js/owl.carousel.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>templates/guesthouse/js/main.js"></script>
<!-- /Scripts -->
</body>
</html>

