<section class="content-header">
    <h1><?php echo $button ?> Halaman Statis</h1>
</section>

<section class="content">
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title"><?php echo $button ?> Profil</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        <div class="box-body">
            <form action="<?php echo $action; ?>" enctype="multipart/form-data" class="form-horizontal" method="post">
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="varchar">Judul <?php echo form_error('judul') ?></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="judul" id="judul" placeholder="judul" value="<?php echo $judul; ?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="isi_halaman">Isi <?php echo form_error('isi_halaman') ?></label>
                    <div class="col-sm-10">
                        <textarea class="form-control" rows="10" name="isi_halaman" id="ckeditor1" placeholder="isi_halaman"><?php echo $isi_halaman; ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="enum">Aktif <?php echo form_error('aktif_hal') ?></label>
                    <div class="col-sm-10">
                        <?php echo form_dropdown(
                            'aktif_hal',
                            $option_aktif,
                            set_value('aktif_hal', $aktif_hal),
                            'class="form-control input-sm "  id="aktif_hal"'
                        ); ?>
                    </div>
                </div>
                <?php if(!empty($pic_halaman)) {?>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Gambar <?php echo form_error('pic_halaman') ?></label>
                        <div class="col-sm-10">
                            <img src="<?php echo base_url(); ?>uploads/foto_halaman/<?php echo $pic_halaman ?>" class="img-responsive" style="max-width: 150px;" alt=""/>
                        </div>
                    </div>
                <?php } ?>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="userfile">Gambar <?php echo form_error('pic_halaman') ?></label>
                    <div class="col-sm-10">
                        <input type="file" name="userfile" id="userfile" class="" title="Pilih File" accept="image/*"/>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <input type="hidden" name="id_halaman" value="<?php echo $id_halaman; ?>" />
                        <button type="submit" class="btn btn-primary"><?php echo $button ?></button>
                        <a href="<?php echo site_url('dashboard/halaman') ?>" class="btn btn-danger">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>