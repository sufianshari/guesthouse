<header class="header">
    <div class="header-top">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 col-md-8 col-sm-8 col-xs-12">
                    <div class="header-location"><i class="fa fa-home"></i> <a href="#"><?php echo $iden_data['alamat']; ?></a></div>
                    <div class="header-email"><i class="fa fa-envelope-o"></i> <a href="mailto:<?php echo $iden_data['email_website']; ?>"><?php echo $iden_data['email_website']; ?></a></div>
                    <div class="header-phone"><i class="fa fa-phone"></i> <a href="#"><?php echo $iden_data['no_telp1']; ?></a></div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <div class="header-social pull-right">
                        <a href="#"><i class="fa fa-twitter"></i></a>
                        <a href="#"><i class="fa fa-facebook"></i></a>
                        <a href="#"><i class="fa fa-google-plus"></i></a>
                        <a href="#"><i class="fa fa-dribbble"></i></a>
                        <a href="#"><i class="fa fa-instagram"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="header-bottom">
        <nav class="navbar navbar-universal navbar-custom">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="logo"><a href="<?php echo base_url(); ?>home/" class="navbar-brand page-scroll"><img src="<?php echo base_url(); ?>uploads/system/<?php echo $iden_data['logo_website']; ?>" alt="<?php echo $iden_data['nm_website']; ?>" class="img-responsive" style="max-height: 50px;"/></a></div>
                    </div>
                    <div class="col-lg-9">
                        <div class="navbar-header">
                            <button type="button" data-toggle="collapse" data-target=".navbar-main-collapse" class="navbar-toggle"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
                        </div>
                        <div class="collapse navbar-collapse navbar-main-collapse">
                            <ul class="nav navbar-nav navbar-right">
                                <li><a href="<?php echo base_url();?>home/">Home</a></li>
                                <li><a href="<?php echo base_url();?>about/">About Us</a></li>
                                <li><a href="<?php echo base_url();?>how/">How to Booking</a></li>
                                <li><a href="<?php echo base_url();?>booking/">Reservation</a></li>
                                <li><a href="<?php echo base_url();?>gallery/">Gallery</a></li>
                                <li><a href="<?php echo base_url();?>contact/">Contact Us</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </div>
</header>
