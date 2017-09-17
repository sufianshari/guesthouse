<?php echo $script_captcha; // javascript recaptcha ?>

<section class="section-header page-title title-center">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <h1>Reservation</h1>
            </div>
        </div>
    </div>
</section>

<section class="not-found">
    <div class="container">
        <div class="row">
            <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
        </div>
        <form action="<?php echo $action;?>" method="post" class="form-horizontal">
            <div class="form-group">
                <label class="col-sm-2 control-label" for="check_in">Check In</label>
                <div class="col-sm-4">
                    <div class="input-group input-group-sm">
                        <input required name="check_in" type="text" id="check_in" value="" class="form-control input-sm" placeholder="Check In Date"/>
                        <span class="input-group-addon" id="sizing-addon3"><i class="fa fa-calendar"></i></span>
                    </div>
                </div>
                <label class="col-sm-2 control-label" for="check_out">Check Out</label>
                <div class="col-sm-4">
                    <div class="input-group input-group-sm">
                        <input required name="check_out" type="text" id="check_out" value="" class="form-control input-sm" placeholder="Check Out Date"/>
                        <span class="input-group-addon" id="sizing-addon3"><i class="fa fa-calendar"></i></span>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="adult">Adult Count</label>
                <div class="col-sm-4">
                    <input required name="adult_count" type="number" id="adult_count" value="" class="form-control input-sm" placeholder="Adult Count"/>
                </div>
                <label class="col-sm-2 control-label" for="child">Child Count</label>
                <div class="col-sm-4">
                    <input required name="child_count" type="number" id="child_count" value="" class="form-control input-sm" placeholder="Child Count"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="first_name">First Name</label>
                <div class="col-sm-4">
                    <input required name="first_name" type="text" id="first_name" value="" class="form-control input-sm" placeholder="First Name"/>
                </div>
                <label class="col-sm-2 control-label" for="last_name">Last Name</label>
                <div class="col-sm-4">
                    <input required name="last_name" type="text" id="last_name" value="" class="form-control input-sm" placeholder="Last Name"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="email">Email Address</label>
                <div class="col-sm-4">
                    <input required name="email" type="text" id="email" value="" class="form-control input-sm" placeholder="Email"/>
                </div>
                <label class="col-sm-2 control-label" for="phone">Phone</label>
                <div class="col-sm-4">
                    <input required name="phone" type="text" id="phone" value="" class="form-control input-sm" placeholder="Phone"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label"></label>
                <div class="col-sm-4">
                    <?php echo $captcha // tampilkan recaptcha ?>
                </div>

            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label"></label>
                <div class="col-sm-4">
                    <button type="submit" class="btn btn-primary pull-left" id="btnContactUs">Book Now</button>
                </div>
            </div>
        </form>

    </div>
</section>