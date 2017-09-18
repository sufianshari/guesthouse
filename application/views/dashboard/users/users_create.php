<section class="content-header">
    <h1><?php echo lang('create_user_heading');?></h1>
</section>

<section class="content">
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title"><?php echo lang('create_user_subheading');?></h3>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        <div class="box-body">
            <?php echo $message;?>
            <?php if (!empty($this->session->userdata('message'))) :
                echo notify($this->session->userdata('message'),'info');
            endif ?>
            <div class="row">
                <div class="col-md-12">
                    <form action="<?php echo $action; ?>" class="form-horizontal" method="post">
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="first_name"><?php echo lang('create_user_fname_label', 'first_name');?></label>
                            <div class="col-sm-9">
                                <?php echo form_input($first_name);?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="last_name"><?php echo lang('create_user_lname_label', 'last_name');?></label>
                            <div class="col-sm-9">
                                <?php echo form_input($last_name);?>
                            </div>
                        </div>
                        <?php
                        if($identity_column!=='email') { ?>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="identity"><?php echo lang('create_user_identity_label', 'identity');?></label>
                                <div class="col-sm-9">
                                    <?php
                                    echo form_error('identity');
                                    echo form_input($identity);
                                    ?>
                                    ?>
                                </div>
                            </div>
                        <?php } ?>

                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="company"><?php echo lang('create_user_company_label', 'company');?></label>
                            <div class="col-sm-9">
                                <?php echo form_input($company);?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="email"><?php echo lang('create_user_email_label', 'email');?></label>
                            <div class="col-sm-9">
                                <?php echo form_input($email);?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="phone"><?php echo lang('create_user_phone_label', 'phone');?></label>
                            <div class="col-sm-9">
                                <?php echo form_input($phone);?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="password"><?php echo lang('create_user_password_label', 'password');?></label>
                            <div class="col-sm-9">
                                <?php echo form_input($password);?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="password_confirm"><?php echo lang('create_user_password_confirm_label', 'password_confirm');?></label>
                            <div class="col-sm-9">
                                <?php echo form_input($password_confirm);?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-9">
                                <button type="submit" class="btn btn-success"><?php echo lang('create_user_submit_btn'); ?></button>
                                <button type="reset" class="btn btn-danger">Reset</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

