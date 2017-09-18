<section class="content-header">
    <h1>Balas Pesan</h1>
</section>

<section class="content">
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">Balas Pesan</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        <div class="box-body">
            <form action="<?php echo $action; ?>" enctype="multipart/form-data" class="form-horizontal" method="post">
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="varchar">Nama <?php echo form_error('nama') ?></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="nama" id="nama" placeholder="nama" value="<?php echo $nama; ?>" />
                    </div>

                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="varchar">Kepada <?php echo form_error('email') ?></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="email" id="email" placeholder="email" value="<?php echo $email; ?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="varchar">Subjek <?php echo form_error('subjek') ?></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="subjek" id="subjek" placeholder="subjek" value="<?php echo $subjek; ?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="pesan">Pesan <?php echo form_error('pesan') ?></label>
                    <div class="col-sm-10">
                        <textarea class="form-control" name="pesan" id="ckeditor1" placeholder="pesan"><br /><br /><hr /><?php echo $pesan; ?></textarea>
                    </div>
                </div>
                <div class="col-sm-offset-2 col-sm-10">
                    <input type="hidden" name="id_hubungi" value="<?php echo $id_hubungi; ?>" />
                    <button type="submit" class="btn btn-primary"><?php echo $button ?></button>
                    <a href="<?php echo site_url('dashboard/hubungi') ?>" class="btn btn-warning">Batal</a>
                </div>
            </form>
        </div>
    </div>
</section>