<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $judul_pendek; ?> - <?php echo $iden_data['nm_website']; ?></title>
    <meta name="desciption" content="<?php echo $iden_data['meta_deskripsi'];?>">
    <meta name="keywords" content="<?php echo $iden_data['meta_keyword'];?>">
    <meta name="author" content="Muhammad Anshari">

    <!-- FONTS ONLINE -->
    <link href='http://fonts.googleapis.com/css?family=Playfair+Display:400,700,900,400italic,700italic,900italic' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>

    <!--MAIN STYLE-->
    <link href="<?php echo base_url(); ?>assets-app/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url(); ?>assets-app/css/main.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url(); ?>assets-app/css/style.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url(); ?>assets-app/css/responsive.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url(); ?>assets-app/css/animate.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url(); ?>assets-app/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!-- ADD YOUR OWN STYLING HERE. AVOID TO USE STYLE.CSS AND MAIN.CSS. IT WILL BE HELPFUL FOR YOU IN FUTURE UPDATES -->
    <link href="<?php echo base_url(); ?>assets-app/css/custom.css" rel="stylesheet" type="text/css">

    <!-- SLIDER REVOLUTION 4.x CSS SETTINGS -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets-app/rs-plugin/css/settings.css" media="screen" />

    <!-- JavaScripts -->
    <script src="<?php echo base_url(); ?>assets-app/js/modernizr.js"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body>
<!-- LOADER ===========================================-->
<div id="loader">
    <div class="loader">
        <div class="position-center-center"> <img src="<?php echo base_url(); ?>files/system/<?php echo $iden_data['logo_website']; ?>" style="height: 35px;" alt="">

            <p class="font-playfair text-center">Please Wait...</p>
            <div class="loading">
                <div class="ball"></div>
                <div class="ball"></div>
                <div class="ball"></div>
            </div>
        </div>
    </div>
</div>

<!-- Page Wrap -->
<div id="wrap">

    <!-- Header -->
    <?php $this->load->view('includes/app-header'); ?>
    <!-- Header End -->
    <div class="content">
        <?php $this->load->view($main_view); ?>
    </div>
    <!--======= Footer =========-->
    <footer>
        <?php $this->load->view('includes/app-footer'); ?>
    </footer>
    <!-- GO TO TOP -->
    <a href="#" class="cd-top"><i class="fa fa-angle-up"></i></a>
    <!-- GO TO TOP End -->
</div>
<!-- Wrap End -->
<script src="<?php echo base_url(); ?>assets-app/js/jquery-1.11.3.js"></script>
<script src="<?php echo base_url(); ?>assets-app/js/wow.min.js"></script>
<script src="<?php echo base_url(); ?>assets-app/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets-app/js/own-menu.js"></script>
<script src="<?php echo base_url(); ?>assets-app/js/owl.carousel.min.js"></script>
<script src="<?php echo base_url(); ?>assets-app/js/jquery.magnific-popup.min.js"></script>
<script src="<?php echo base_url(); ?>assets-app/js/jquery.flexslider-min.js"></script>
<script src="<?php echo base_url(); ?>assets-app/js/jquery.isotope.min.js"></script>

<!-- SLIDER REVOLUTION 4.x SCRIPTS  -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets-app/rs-plugin/js/jquery.themepunch.tools.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets-app/rs-plugin/js/jquery.themepunch.revolution.min.js"></script>
<script src="<?php echo base_url(); ?>assets-app/js/main.js"></script>
<!-- begin map script-->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCoGCLEi3mnqqSdGymcrsInIU5ptb3pI5w&callback=initMap"  type="text/javascript"></script>
</body>
</html>