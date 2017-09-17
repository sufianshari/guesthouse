<section class="content-header">
    <h1>Laporan Reservasi</h1>
</section>

<section class="content">
    <div class="box box-success">
        <div class="box-header with-border">
            <div class="row">
                <div class="col-md-4 col-xs-4">
<!--                    --><?php //echo anchor(site_url('dashboard/reservation/create'),'Tambah Data', 'class="btn btn-primary"'); ?>
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
                    <th class="text-center" width="50px">No</th>
                    <th class="text-center">Check In</th>
                    <th class="text-center">Check Out</th>
                    <th class="text-center">Full Name</th>
                    <th class="text-center">Email</th>
                    <th class="text-center">Phone</th>
                    <th class="text-center">Adult/Child</th>
                    <th class="text-center">Booking Date</th>
                    <th class="text-center" width="150px">Proses</th>
                </tr><?php
                $start = 0;
                foreach ($reservation_data as $reservation)
                {
                    ?>
                    <tr>
                        <td class="text-center"><?php echo ++$start ?></td>
                        <td class="text-center"><?php echo tgl_indo($reservation->check_in); ?></td>
                        <td class="text-center"><?php echo tgl_indo($reservation->check_out); ?></td>
                        <td><?php echo $reservation->first_name; ?>, <?php echo $reservation->last_name; ?></td>
                        <td><?php echo $reservation->email; ?></td>
                        <td><?php echo $reservation->phone; ?></td>
                        <td class="text-center"><?php echo tgl_indo_timestamp($reservation->created_at); ?></td>
                        <td class="text-center"><?php echo $reservation->adult_count; ?>/<?php echo $reservation->child_count; ?></td>
                        <td class="text-center">
                            <div class="btn-group btn-group-xs" role="group">
                                <?php
//                                echo anchor(site_url('dashboard/reservation/update/'.$reservation->id_reservation),'Update', 'class="btn btn-warning"');
                                echo anchor(site_url('dashboard/reservation/delete/'.$reservation->id_reservation),'Delete', 'class="btn btn-danger" onclick="javasciprt: return confirm(\'Are You Sure ?\')"');
                                ?>
                            </div>

                        </td>
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

</section>