<section class="content-header">
    <h1><?php echo $button ?> Fasilitas</h1>
</section>

<section class="content">
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title"><?php echo $button ?> Fasilitas</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        <div class="box-body">
            <form action="<?php echo $action; ?>" enctype="multipart/form-data" class="form-horizontal" method="post">
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="varchar">Fasilitas <?php echo form_error('nm_fasilitas') ?></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="nm_fasilitas" id="nm_fasilitas" placeholder="Fasilitas" value="<?php echo $nm_fasilitas; ?>" />
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <input type="hidden" name="id_fasilitas" value="<?php echo $id_fasilitas; ?>" />
                        <button type="submit" class="btn btn-primary"><?php echo $button ?></button>
                        <a href="<?php echo site_url('dashboard/fasilitas') ?>" class="btn btn-warning">Batal</a>
                    </div>
                </div>

            </form>
        </div>
    </div>
</section>