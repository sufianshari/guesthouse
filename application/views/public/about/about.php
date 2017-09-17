<section class="section-header page-title title-left">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <h1><?php echo $data_halaman->judul;?></h1>
            </div>
        </div>
    </div>
</section>

<section class="about">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                    <p><?php echo $data_halaman->isi_halaman;?></p>
            </div>
        </div>
    </div>
</section>

<section class="section-header page-title title-left">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <h1>All Room</h1>
            </div>
        </div>
    </div>
</section>
<div class="container">
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


