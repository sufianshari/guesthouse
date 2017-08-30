<section class="breadcrumbs" style="background-image: url(<?php echo base_url();?>uploads/system/about.jpg)">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h1 class="h1"><?php echo $data_halaman->judul;?></h1>
            </div>
            <div class="col-md-6">
                <ol class="breadcrumb">
                    <li><a href="<?php echo base_url();?>home/">Home</a><i class="fa fa-angle-right"></i></li>
                    <li class="active"><?php echo $data_halaman->judul;?></li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="about">
    <div class="container">
        <h2 class="h2"><?php echo $data_halaman->judul;?></h2>
        <div class="row">
            <div class="col-md-6">
                <div class="about_img"><img class="img-responsive" src="<?php echo base_url();?>uploads/system/front.jpg" alt=""/></div>
            </div>
            <div class="col-md-6">
                <div class="about_info">
                    <p><?php echo $data_halaman->isi_halaman;?></p>
                </div>
            </div>
        </div>
    </div>
</section>