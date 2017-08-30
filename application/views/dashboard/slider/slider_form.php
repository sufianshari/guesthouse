<section class="content-header">
    <h1><?php echo $button ?> Home Slider</h1>
</section>

<section class="content">
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title"><?php echo $button ?> Home Slider</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        <div class="box-body">
            <form action="<?php echo $action; ?>" enctype="multipart/form-data" class="form-horizontal" method="post">
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="varchar">Nama <?php echo form_error('nm_slider') ?></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="nm_slider" id="nm_slider" placeholder="Nama" value="<?php echo $nm_slider; ?>" />
                    </div>
                </div>
                <?php if(!empty($gambar)) {?>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Gambar <?php echo form_error('gambar') ?></label>
                        <div class="col-sm-10">
                            <img src="<?php echo base_url(); ?>uploads/foto_slider/<?php echo $gambar ?>" class="img-responsive" style="max-width: 150px;" alt=""/>
                        </div>
                    </div>
                <?php } ?>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="varchar">Gambar <?php echo form_error('gambar') ?></label>
                    <div class="col-sm-10">
                        <input type="file" name="userfile" id="userfile" class="" title="Pilih File" accept="image/*"/><small class="text-red">Ukuran Rekomendasi (1600px v 680px)</small>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <input type="hidden" name="id_slider" value="<?php echo $id_slider; ?>" />
                        <button type="submit" class="btn btn-primary"><?php echo $button ?></button>
                        <a href="<?php echo site_url('dashboard/slider') ?>" class="btn btn-warning">Batal</a>
                    </div>
                </div>

            </form>
        </div>
    </div>
</section>