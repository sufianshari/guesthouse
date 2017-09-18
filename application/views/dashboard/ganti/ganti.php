<section class="content-header">
    <h1><?php echo lang('change_password_heading');?></h1>
</section>

<section class="content">
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title"><?php echo lang('change_password_heading');?></h3>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        <div class="box-body">
            <?php if (!empty($this->session->userdata('message'))) :
                echo notify($this->session->userdata('message'),'info');
            endif ?>
            <div class="row">
                <div class="col-md-9">
                    <form action="<?php echo $action; ?>" class="form-horizontal" method="post">
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="varchar"><?php echo lang('change_password_old_password_label', 'old_password');?></label>
                            <div class="col-sm-9">
<!--                                <input type="password" class="form-control" name="password_lama" id="password_lama" placeholder="Password Lama" value="" required autofocus />-->
                                <?php echo form_input($old_password);?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="new_password"><?php echo sprintf(lang('change_password_new_password_label'), $min_password_length);?></label>
                            <div class="col-sm-9">
<!--                                <input type="password" class="form-control" name="password_baru" id="password_baru" placeholder="Password Baru" value="" required />-->
                                <?php echo form_input($new_password);?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="new_password_confirm"><?php echo lang('change_password_new_password_confirm_label', 'new_password_confirm');?></label>
                            <div class="col-sm-9">
<!--                                <input type="password" class="form-control" name="password_confirm" id="password_confirm" placeholder="Konfirmasi Password" value="" required />-->
                                <?php echo form_input($new_password_confirm);?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-9">
                                <?php echo form_input($user_id);?>
                                <button type="submit" class="btn btn-success"><?php echo lang('change_password_submit_btn'); ?></button>
                                <button type="reset" class="btn btn-danger">Reset</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-3">
                    Cara ganti password User: <br>
                    <ol>
                        <li>Masukkan password lama pada kolom Password Lama</li>
                        <li>Masukkan password baru pada kolom password baru</li>
                        <li>Masukkan passowrd baru kembali pada kolom Kofirmasi Password</li>
                        <li>Tekan tombol Update Password</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</section>

