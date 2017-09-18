<section class="content-header">
    <h1><?php echo lang('create_group_heading');?></h1>
</section>

<section class="content">
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title"><?php echo lang('create_group_subheading');?></h3>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        <div class="box-body">
            <?php if (!empty($this->session->userdata('message'))) :
                echo notify($this->session->userdata('message'),'info');
            endif ?>
            <div class="row">
                <div class="col-md-12">
                    <form action="<?php echo $action; ?>" class="form-horizontal" method="post">
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="group_name"><?php echo lang('create_group_name_label', 'group_name');?></label>
                            <div class="col-sm-9">
                                <?php echo form_input($group_name);?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="description"><?php echo lang('create_group_desc_label', 'description');?></label>
                            <div class="col-sm-9">
                                <?php echo form_input($description);?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-9">
                                <button type="submit" class="btn btn-success"><?php echo lang('create_group_submit_btn'); ?></button>
                                <button type="reset" class="btn btn-danger">Reset</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

