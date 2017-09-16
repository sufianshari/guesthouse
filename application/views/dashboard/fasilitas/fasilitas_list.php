<section class="content-header">
    <h1>Fasilitas</h1>
</section>

<section class="content">
    <div class="box box-success">
        <div class="box-header with-border">
            <div class="row">
                <div class="col-md-4 col-xs-4">
                    <?php echo anchor(site_url('dashboard/fasilitas/create'),'Tambah Data', 'class="btn btn-primary"'); ?>
                </div>
                <div class="col-md-4 col-xs-4 text-center">
                    <div style="margin-top: 8px" id="message">
                        <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                    </div>
                </div>
                <div class="col-md-4 col-xs-4 text-right">
                    <form action="<?php echo site_url('dashboard/fasilitas/search'); ?>" class="form-inline" method="post">
                        <div class="input-group pull-right">
                            <input name="keyword" class="form-control" value="<?php echo $keyword; ?>" />
                            <span class="input-group-btn">
                                <?php
                                if ($keyword <> '')
                                {
                                    ?>
                                    <a href="<?php echo site_url('dashboard/fasilitas'); ?>" class="btn btn-default">Reset</a>
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
                    <th class="text-center">Fasilitas</th>
                    <th class="text-center" width="150px">Proses</th>
                </tr><?php
                $start = 0;
                foreach ($fasilitas_data as $fasilitas)
                {
                    ?>
                    <tr>
                        <td class="text-center"><?php echo ++$start ?></td>
                        <td><?php echo $fasilitas->nm_fasilitas; ?></td>
                        <td class="text-center">
                            <div class="btn-group btn-group-xs" role="group">
                                <?php
                                echo anchor(site_url('dashboard/fasilitas/update/'.$fasilitas->id_fasilitas),'Update', 'class="btn btn-warning"');
                                echo anchor(site_url('dashboard/fasilitas/delete/'.$fasilitas->id_fasilitas),'Delete', 'class="btn btn-danger" onclick="javasciprt: return confirm(\'Are You Sure ?\')"');
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