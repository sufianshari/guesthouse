<footer>
    <div class="footer" id="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-6  col-md-6 col-sm-12 col-xs-12">
                    <h3><?php echo $iden_data['nm_website']; ?></h3>
                    <ul>
                        <li> <i class="fa fa-home"></i> <?php echo $iden_data['alamat']; ?>alamat </li>
                        <li> <i class="fa fa-phone"></i> <?php echo $iden_data['no_telp1']; ?> </li>
                        <li> <a href="mailto:<?php echo $iden_data['email_website']; ?>"><i class="fa fa-envelope-o"></i> <?php echo $iden_data['email_website']; ?></a> </li>
                    </ul>
                </div>
                <div class="col-lg-6  col-md-6 col-sm-12 col-xs-12">
                    <h3> Our Location </h3>
                    <section class="map-footer">
                        <div id="map-footer"></div>
                    </section>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="container">
            <p class="pull-left"> Copyright &copy; Andy Guest House <?php echo date('Y');?>. All right reserved. </p>
            <div class="pull-right">
                <ul class="nav nav-pills payments">
                    <li><i class="fa fa-cc-visa"></i></li>
                    <li><i class="fa fa-cc-mastercard"></i></li>
                    <li><i class="fa fa-cc-amex"></i></li>
                    <li><i class="fa fa-cc-paypal"></i></li>
                </ul>
            </div>
        </div>
    </div>
</footer>


<script>
    function initMap() {
        var myicon = '<?php echo base_url(); ?>uploads/ico/home.png';
        var myLatLng = {lat: <?php echo $iden_data['latitude']; ?>, lng: <?php echo $iden_data['longitude']; ?>};

        // Create a map object and specify the DOM element for display.
        var map = new google.maps.Map(document.getElementById('map-footer'), {
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

        var contentString = '<div id="content">'+
            '<strong><?php echo $iden_data['nm_website']; ?></strong><br />'+
            '<?php echo $iden_data['alamat']; ?><br />'+
            '<?php echo $iden_data['no_telp1']; ?>'+
            '</div>';

        var infowindow = new google.maps.InfoWindow({
            content: contentString
        });

        marker.addListener('click', function() {
            infowindow.open(map, marker);
        });
    }

</script>

<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBbP5YOX1ctcMIbH4_rKGjqTXcz4-acDGs&callback=initMap" type="text/javascript"></script>