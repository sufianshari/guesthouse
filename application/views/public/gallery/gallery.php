<section class="breadcrumbs" style="background-image: url(<?php echo base_url();?>uploads/system/about.jpg)">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h1 class="h1">Gallery</h1>
            </div>
            <div class="col-md-6">
                <ol class="breadcrumb">
                    <li><a href="<?php echo base_url();?>home/">Home</a><i class="fa fa-angle-right"></i></li>
                    <li class="active">Gallery</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="gallery">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h2 class="h2">Meet Our Great Guesthouse</h2>
                <ul class="portfolio-sorting">
                    <li><a href="#" data-group="all" class="active">All</a></li>
                    <?php
                    if($data_album) :
                        foreach ($data_album as $row) : ?>

                            <li><a href="#" data-group="<?php echo $row['nm_album'];?>"><?php echo $row['nm_album'];?></a></li>

                        <?php endforeach;
                    else:
                        echo notify('Data Lookbook Belum Tersedia','info');
                    endif; ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="container">
        <div id="grid" class="row portfolio-items">
            <?php
            if($data_gallery) :
                foreach ($data_gallery as $gallery) : ?>

                    <div data-groups="[&quot;<?php echo $gallery['nm_album'];?>&quot;]" class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <div class="portfolio-item">
                            <a href="#"><img src="<?php echo base_url(); ?>uploads/foto_galeri/<?php echo $gallery['pic_galeri'];?>" alt="" style="width: 620px; max-height: 250px;">
                                <div class="portfolio-overlay">
                                    <div class="caption"><?php echo $gallery['nm_galeri'];?><span><?php echo $gallery['nm_album'];?></span></div>
                                </div>
                            </a>
                        </div>
                    </div>

                <?php endforeach;
            else:
                echo notify('Data Lookbook Belum Tersedia','info');
            endif; ?>

        </div>
    </div>
</section>