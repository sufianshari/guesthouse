<section class="content-header">
    <h1><?php echo $button ?> Kamar</h1>
</section>

<section class="content">
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title"><?php echo $button ?> Kamar</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        <div class="box-body">
            <form action="<?php echo $action; ?>" enctype="multipart/form-data" class="form-horizontal" method="post">
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="varchar">Nama <?php echo form_error('nm_kamar') ?></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="nm_kamar" id="nm_kamar" placeholder="Nama" value="<?php echo $nm_kamar; ?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="varchar">Harga Kamar <?php echo form_error('harga_kamar') ?></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="harga_kamar" id="harga_kamar" placeholder="Harga Kamar" value="<?php echo $harga_kamar; ?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="deskripsi">Deskripsi <?php echo form_error('deskripsi') ?></label>
                    <div class="col-sm-10">
                        <textarea class="form-control" rows="10" name="deskripsi" id="ckeditor1" placeholder="Deskripsi Kamar"><?php echo $deskripsi; ?></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label" for="int">Fasilitas <?php echo form_error('fasilitas') ?></label>
                    <div class="col-sm-10">
                        <select name="fasilitas[]" id="fasilitas" class="form-control selectFilterMulti" multiple="multiple">
                            <?php foreach($option_fasilitas as $rowfal){?>
                                <option value="<?=$rowfal->nm_fasilitas?>"><?=$rowfal->nm_fasilitas?></option>
                            <?php }?>
                        </select>
                    </div>
                </div>
                <?php if(!empty($pic_kamar)) {?>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Gambar <?php echo form_error('pic_kamar') ?></label>
                        <div class="col-sm-10">
                            <img src="<?php echo base_url(); ?>uploads/foto_kamar/<?php echo $pic_kamar ?>" class="img-responsive" style="max-width: 150px;" alt=""/>
                        </div>
                    </div>
                <?php } ?>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="varchar">Gambar <?php echo form_error('pic_kamar') ?></label>
                    <div class="col-sm-10">
                        <input type="file" name="userfile" id="userfile" class="" title="Pilih File" accept="image/*"/>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <input type="hidden" name="id_kamar" value="<?php echo $id_kamar; ?>" />
                        <button type="submit" class="btn btn-primary"><?php echo $button ?></button>
                        <a href="<?php echo site_url('dashboard/kamar') ?>" class="btn btn-warning">Batal</a>
                    </div>
                </div>

            </form>
        </div>
    </div>
</section>