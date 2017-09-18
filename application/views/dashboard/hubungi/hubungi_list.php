<section class="content-header">
    <h1>Kotak Masuk</h1>
</section>

<section class="content">
    <div class="box box-success">
        <div class="box-header with-border">
            <div class="row">
                <div class="col-md-4">
                    <?php //echo anchor(site_url('dashboard/hubungi/create'),'Tambah Data', 'class="btn btn-primary"'); ?>
                </div>
                <div class="col-md-4 text-center">
                    <div style="margin-top: 8px" id="message">
                        <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                    </div>
                </div>
                <div class="col-md-4 text-right">
                    <form action="<?php echo site_url('dashboard/hubungi/search'); ?>" class="form-inline" method="post">
                        <div class="input-group pull-right">
                            <input name="keyword" class="form-control" placeholder="Cari Data" value="<?php echo $keyword; ?>" />

                            <span class="input-group-btn">
                                <?php
                                if ($keyword <> '')
                                {
                                    ?>
                                    <a href="<?php echo site_url('dashboard/hubungi'); ?>" class="btn btn-warning">Reset</a>
                                <?php
                                }
                                ?>
                                <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i> Cari</button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="box-body">
            <table class="table table-bordered table-hover table-striped table-condensed">
                <tr class="bg-blue">
                    <th class="text-center">No</th>
                    <th class="text-center">Nama</th>
                    <th class="text-center">Email</th>
                    <th class="text-center">Subjek</th>
                    <th class="text-center">Tanggal</th>
                    <th class="text-center">Dibaca</th>
                    <th class="text-center">Action</th>
                </tr><?php
                foreach ($hubungi_data as $hubungi)
                {
                    ?>
                    <tr>
                        <td class="text-center"><?php echo ++$start ?></td>
                        <td><?php echo $hubungi->nama ?></td>
                        <td><?php echo $hubungi->email ?></td>
                        <td><?php echo $hubungi->subjek ?></td>
                        <td class="text-center"><?php echo tgl_jam_indo($hubungi->tanggal); ?></td>
                        <td class="text-center"><?php echo $hubungi->dibaca ?></td>
                        <td class="text-center">
                            <div class="btn-group btn-group-xs" role="group">
                            <?php
                            echo anchor(site_url('dashboard/hubungi/update/'.$hubungi->id_hubungi),'Reply','class="btn btn-success"');
                            echo anchor(site_url('dashboard/hubungi/delete/'.$hubungi->id_hubungi),'Delete','class="btn btn-danger" onclick="javasciprt: return confirm(\'Are You Sure ?\')"');
                            ?>
                                </div>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </table>
        </div>
        <div class="box-footer">
            <div class="row">
                <div class="col-md-6">
                    <ul class="pagination" style="margin-top: 0px">
                        <li class="active"><a href="#">Total Record : <?php echo $total_rows ?></a></li>
                    </ul>
                </div>
                <div class="col-md-6 text-right">
                    <?php echo $pagination ?>
                </div>
            </div>
        </div>
    </div>
</section>