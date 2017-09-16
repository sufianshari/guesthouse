<div id="myCarousel" class="carousel slide" data-ride="carousel">

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
