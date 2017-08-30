<!-- parallax -->
<section class="bg-parallax parallax-window">
    <div class="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" style="min-height: 500px;">
                <div class="parallax-text">
                    <h2 class="parallax_t __white">Andy Guest House</h2>
                </div>
            </div>

        </div>
    </div>
</section>
<!-- /parallax -->

<!-- enjoy our services -->
<section class="section">
    <div class="container">
        <div class="title-main"><h2 class="h2">Our Services<span class="title-secondary">Great. Safe. Free.</span></h2></div>
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-6">
                <h3 class="service_title"><i class="fa fa-globe"></i> Different Tours</h3>
                <p>Improve ashamed married expense bed her comfort pursuit mrs. Four time took ye your as fail lady.</p>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6">
                <h3 class="service_title"><i class="fa fa-taxi"></i> Taxi Service</h3>
                <p>Improve ashamed married expense bed her comfort pursuit mrs. Four time took ye your as fail lady.</p>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6">
                <h3 class="service_title"><i class="fa fa-glass"></i> Bar Included</h3>
                <p>Improve ashamed married expense bed her comfort pursuit mrs. Four time took ye your as fail lady.</p>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6">
                <h3 class="service_title"><i class="fa fa-life-ring"></i> Discount System</h3>
                <p>Improve ashamed married expense bed her comfort pursuit mrs. Four time took ye your as fail lady.</p>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6">
                <h3 class="service_title"><i class="fa fa-leaf"></i> Professional Staff</h3>
                <p>Improve ashamed married expense bed her comfort pursuit mrs. Four time took ye your as fail lady.</p>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6">
                <h3 class="service_title"><i class="fa fa-eye"></i> Parking 24/7</h3>
                <p>Improve ashamed married expense bed her comfort pursuit mrs. Four time took ye your as fail lady.</p>
            </div>
        </div>
    </div>
</section>
<!-- /enjoy our services -->

<div class="container">
    <div class="title-main"><h1 class="h1">Our Location</h1></div>
</div>
<!-- map -->
<section class="map">
    <div id="map"></div>
</section>
<!-- /map -->


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