<?php echo $script_captcha; // javascript recaptcha ?>

<section class="section-header page-title title-center">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <h1>Contact Us</h1>
            </div>
        </div>
    </div>
</section>

<section class="contact-block">
    <div class="container">
        <div class="contact-block_form">
            <div class="row">
                <div class="contact-block_info">
                    <div class="col-md-4">
                        <div class="contact-block_i">
                            <div class="info_icon">
                                <i class="fa fa-home"></i>
                            </div>
                            <div class="info_txt"><span><?php echo $iden_data['alamat']; ?></span></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="contact-block_i">
                            <div class="info_icon">
                                <i class="fa fa-envelope-o"></i>
                            </div>
                            <div class="info_txt"><span><a href="mailto:<?php echo $iden_data['email_website']; ?>"><?php echo $iden_data['email_website']; ?></a></span></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="contact-block_i">
                            <div class="info_icon">
                                <i class="fa fa-phone"></i>
                            </div>
                            <div class="info_txt"><span><?php echo $iden_data['no_telp1']; ?>, <?php echo $iden_data['no_telp2']; ?></span></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row marg50">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><h2 class="h2">Drop Us Some Lines...</h2></div>
                <div class="col-lg-2 col-md-2 col-sm-1 col-xs-1"></div>
                <div class="col-lg-8 col-md-8 col-sm-11 col-xs-11">
                    <form action="<?php echo $action;?>" method="POST" class="form-horizontal form-wizzard">
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <div id="name-group" class="form-group">
                                    <input type="text" name="nama" id="name" class="form-control" placeholder="Enter your name ..."/>
                                    <?php echo form_error('nama') ?>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <div id="surname-group" class="form-group">
                                    <input type="email" name="email" class="form-control" placeholder="Enter your email ..."/>
                                    <?php echo form_error('email') ?>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <div id="phone-group" class="form-group">
                                    <input type="text" name="subjek" class="form-control" placeholder="Enter subject ..."/>
                                    <?php echo form_error('subjek') ?>
                                </div>
                            </div>
                        </div>
                        <div id="comment-group" class="form-group">
                            <textarea rows="10" name="pesan" class="form-control" placeholder="Additional note type here ..."></textarea>
                        </div>
                        <div  id="comment-group" class="form-group">
                            <?php echo $captcha // tampilkan recaptcha ?>
                        </div>
                        <div class="form-group text-center">
                            <input type="submit" value="Send message" class="btn btn-default"/>
                        </div>
                    </form>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-1 col-xs-1"></div>
            </div>
        </div>
    </div>
</section>
<section class="map">
    <div id="map"></div>
</section>


<script>
    function initMap() {
        var myicon = '<?php echo base_url(); ?>uploads/ico/home.png';
        var myLatLng = {lat: <?php echo $iden_data['latitude']; ?>, lng: <?php echo $iden_data['longitude']; ?>};

        // Create a map object and specify the DOM element for display.
        var map = new google.maps.Map(document.getElementById('map'), {
            center: myLatLng,
            zoom: 15
        });

        // Create a marker and set its position.
        var marker = new google.maps.Marker({
            map: map,
            icon: myicon,
            position: myLatLng,
            title: 'Andy Guest House'
        });
    }

</script>

<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBbP5YOX1ctcMIbH4_rKGjqTXcz4-acDGs&callback=initMap" type="text/javascript"></script>