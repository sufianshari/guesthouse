<section class="content-header">
    <h1>Selamat Datang</h1>
</section>

<section class="content">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="box box-success">
                <div class="box-header with-border">
                    <div class="row">
                        <div class="col-md-4 col-xs-4">
                            Daftar Reservasi Kamar Terbaru
                        </div>
                        <div class="col-md-4 col-xs-4 text-center">
                            <div style="margin-top: 8px" id="message">
                                <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                            </div>
                        </div>
                        <div class="col-md-4 col-xs-4 text-right">
                            <form action="<?php echo site_url('dashboard/reservation/search'); ?>" class="form-inline" method="post">
                                <div class="input-group pull-right">
                                    <input name="keyword" class="form-control" value="<?php echo $keyword; ?>" />
                                    <span class="input-group-btn">
                                <?php
                                if ($keyword <> '')
                                {
                                    ?>
                                    <a href="<?php echo site_url('dashboard/reservation'); ?>" class="btn btn-default">Reset</a>
                                    <?php
                                }
                                ?>
                                        <input type="submit" value="Search" class="btn btn-primary" />
                            </span>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


                <div class="box-body">

                    <table class="table table-hover table-bordered table-striped table-condensed">
                        <tr class="bg-blue">
                            <th class="text-center">Check In</th>
                            <th class="text-center">Check Out</th>
                            <th class="text-center">Full Name</th>
                            <th class="text-center">Email</th>
                            <th class="text-center">Phone</th>
                            <th class="text-center">Adult/Child</th>
                            <th class="text-center">Booking Date</th>
                        </tr><?php
                        foreach ($reservation_data as $reservation)
                        {
                            ?>
                            <tr>
                                <td class="text-center"><?php echo tgl_indo($reservation->check_in); ?></td>
                                <td class="text-center"><?php echo tgl_indo($reservation->check_out); ?></td>
                                <td><?php echo $reservation->first_name; ?>, <?php echo $reservation->last_name; ?></td>
                                <td><?php echo $reservation->email; ?></td>
                                <td><?php echo $reservation->phone; ?></td>
                                <td class="text-center"><?php echo $reservation->adult_count; ?>/<?php echo $reservation->child_count; ?></td>
                                <td class="text-center"><?php echo tgl_jam_indo2($reservation->created_at); ?></td>
                            </tr>
                            <?php
                        }
                        ?>
                    </table>
                </div>
                <div class="panel-footer">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="#" class="btn btn-primary">Total Record : <?php echo $total_rows ?></a>
                        </div>
                        <div class="col-md-6 text-right">
                            <?php echo $pagination ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="box box-primary">
                <div class="box-body no-padding">
                    <!-- THE CALENDAR -->
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
</section>