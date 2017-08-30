<section class="content-header">
    <h1><?php echo $button ?> Galeri Foto</h1>
</section>

<section class="content">
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title"><?php echo $button ?> Galeri Foto</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        <div class="box-body">
            <form action="<?php echo $action; ?>" enctype="multipart/form-data" class="form-horizontal" method="post">
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="varchar">Nama <?php echo form_error('nm_galeri') ?></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="nm_galeri" id="nm_galeri" placeholder="Nama" value="<?php echo $nm_galeri; ?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="int">Album <?php echo form_error('id_album') ?></label>
                    <div class="col-sm-10">
                        <?php echo form_dropdown(
                            'id_album',
                            $option_album,
                            set_value('id_album', isset($id_album) ? $id_album : ''),
                            'class="form-control selectFilter"  id="id_album"'
                        ); ?>
                    </div>
                </div>

                <?php if(!empty($pic_galeri)) {?>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Gambar <?php echo form_error('pic_galeri') ?></label>
                        <div class="col-sm-10">
                            <img src="<?php echo base_url(); ?>uploads/foto_galeri/<?php echo $pic_galeri ?>" class="img-responsive" style="max-width: 150px;" alt=""/>
                        </div>
                    </div>
                <?php } ?>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="varchar">Gambar <?php echo form_error('pic_galeri') ?></label>
                    <div class="col-sm-10">
                        <input type="file" name="userfile" id="userfile" class="" title="Pilih File" accept="image/*"/>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <input type="hidden" name="id_galeri" value="<?php echo $id_galeri; ?>" />
                        <button type="submit" class="btn btn-primary"><?php echo $button ?></button>
                        <a href="<?php echo site_url('dashboard/galeri') ?>" class="btn btn-warning">Batal</a>
                    </div>
                </div>

            </form>
        </div>
    </div>
</section>