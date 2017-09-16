<section class="section-header page-title title-center">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <h1>Gallery Photo</h1>
            </div>
        </div>
    </div>
</section>


<div class="container">
    <div class="tz-gallery">
        <div class="row">
            <?php
            if($data_gallery) :
                foreach ($data_gallery as $gallery) : ?>
                    <div class="col-sm-6 col-md-4">
                        <a class="lightbox" href="<?php echo base_url(); ?>uploads/foto_galeri/<?php echo $gallery['pic_galeri'];?>">
                            <img src="<?php echo base_url(); ?>uploads/foto_galeri/<?php echo $gallery['pic_galeri'];?>" style="min-height: 200px; max-height: 230px;" alt="<?php echo $gallery['nm_album'];?>">
                        </a>
                    </div>


                <?php endforeach;
            else:
                echo notify('Data Lookbook Belum Tersedia','info');
            endif; ?>

        </div>
    </div>
</div>
