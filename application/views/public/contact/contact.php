<?php echo $script_captcha; // javascript recaptcha ?>

<section class="section-header page-title title-center">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <h1>Contact Us</h1>
            </div>
        </div>
    </div>
</section>

<div class="container">
    <div class="row">
        <?php if (!empty($this->session->userdata('message'))) :
            echo notify($this->session->userdata('message'),'info');
        endif ?>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="well well-sm">
                <form action="<?php echo $action;?>" method="POST">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                                    <input type="text" class="form-control" name="nama" id="name" placeholder="Enter Full Name" required="required" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="email"> Email Address</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
                                    <input type="email" class="form-control" name="email" id="email" placeholder="Enter email" required="required" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="subject">Subject</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-tag"></span></span>
                                    <input type="text" class="form-control" name="subjek" id="subjek" placeholder="Enter Subject" required="required" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Message</label>
                                <textarea name="pesan" id="message" class="form-control" rows="5" cols="25" required="required" placeholder="Message"></textarea>
                            </div>
                            <div class="form-group">
                                <?php echo $captcha // tampilkan recaptcha ?>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary pull-right" id="btnContactUs">Send Message</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-4">
            <form>
                <legend><span class="glyphicon glyphicon-globe"></span> Our Guesthouse</legend>
                <address>
                    <strong><?php echo $iden_data['nm_website']; ?></strong><br>
                    <?php echo $iden_data['alamat']; ?><br>
                    <?php echo $iden_data['no_telp1']; ?><br>
                    <?php echo $iden_data['no_telp2']; ?><br>

                </address>
                <address>
                    <strong>Email Address</strong><br>
                    <a href="mailto:<?php echo $iden_data['email_website']; ?>"><?php echo $iden_data['email_website']; ?></a>
                </address>
            </form>
        </div>
    </div>
</div>
