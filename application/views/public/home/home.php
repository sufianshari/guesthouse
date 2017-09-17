<div id="myCarousel" class="carousel slide slider-home" data-ride="carousel">

    <?php if($slider_data) : ?>

        <!-- Indicators -->
        <ol class="carousel-indicators">
            <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
            <li data-target="#carousel-example-generic" data-slide-to="1"></li>
            <li data-target="#carousel-example-generic" data-slide-to="2"></li>
        </ol>


        <ol class="carousel-indicators">
            <?php
            $n=0;
            foreach ($slider_data as $row) :
                if($n == "0") { ?>
                    <li data-target="#myCarousel" data-slide-to="<?php echo $n; ?>" class="active"></li>
                <?php } else { ?>
                    <li data-target="#myCarousel" data-slide-to="<?php echo $n; ?>"></li>
                <?php } $n++;
            endforeach; ?>
        </ol>

        <div class="carousel-inner">
            <?php
            $n=0;
            foreach ($slider_data as $row) : if($n == "0") { ?>
                <div class="item active">
                    <img src="<?php echo base_url(); ?>uploads/foto_slider/<?php echo $row->gambar; ?>" alt="<?php echo $row->nm_slider; ?>" title="<?php echo $row->nm_slider; ?>">
                    <div class="container">
                        <div class="carousel-caption">
                        </div>
                    </div>
                </div>
            <?php } else { ?>
                <div class="item">
                    <img src="<?php echo base_url(); ?>uploads/foto_slider/<?php echo $row->gambar; ?>" alt="<?php echo $row->nm_slider; ?>; ?>" title="<?php echo $row->nm_slider; ?>">
                    <div class="container">
                        <div class="carousel-caption">
                            <h3></h3>
                        </div>
                    </div>
                </div>
            <?php } $n++;
            endforeach; ?>
        </div>


    <?php else: ?>
        <?php  echo notify('Data Slider Belum Tersedia','info');?>
    <?php endif; ?>

    <!-- Controls -->
    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
    <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
</div>

<div class="container">
    <h3 class="lined-heading"><span>All Room</span></h3>
    <div class="tz-gallery">
        <div class="row">
            <?php if($room_data) :
                foreach ($room_data as $kamar) :  ?>
                    <div class="col-sm-6 col-md-3">
                        <div class="thumbnail">
                            <a class="lightbox" href="<?php echo base_url(); ?>uploads/foto_kamar/<?php echo $kamar->pic_kamar; ?>">
                                <img src="<?php echo base_url(); ?>uploads/foto_kamar/<?php echo $kamar->pic_kamar; ?>" alt="<?php echo $kamar->nm_kamar; ?>" style="max-height: 160px;">
                            </a>
                            <div class="caption">
                                <h3><?php echo $kamar->nm_kamar; ?></h3>
                                <h4 class="text-primary">IDR. <?php echo format_rupiah($kamar->harga_kamar); ?></h4>
                                <p><?php echo $kamar->fasilitas; ?></p>
                            </div>
                        </div>
                    </div>

                    <?php
                endforeach;
            else:
                echo notify('Data Kamar Belum Tersedia','info');
            endif; ?>
        </div>
    </div>
</div>


