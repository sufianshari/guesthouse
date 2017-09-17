<section class="content-header">
    <h1>Kamar</h1>
</section>

<section class="content">
    <div class="box box-success">
        <div class="box-header with-border">
            <div class="row">
                <div class="col-md-4">
                    <?php echo anchor(site_url('dashboard/kamar/create'),'Tambah Data', 'class="btn btn-primary"'); ?>
                </div>
                <div class="col-md-4 text-center">
                    <div style="margin-top: 8px" id="message">
                        <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                    </div>
                </div>
                <div class="col-md-4 text-right">
                    <form action="<?php echo site_url('dashboard/kamar/search'); ?>" class="form-inline" method="post">
                        <div class="input-group pull-right">
                            <input name="keyword" class="form-control" placeholder="Cari Data" value="<?php echo $keyword; ?>" />
                            <span class="input-group-btn">
                                <?php
                                if ($keyword <> '')
                                {
                                    ?>
                                    <a href="<?php echo site_url('dashboard/kamar'); ?>" class="btn btn-warning">Reset</a>
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
                    <th class="text-center">Harga</th>
                    <th class="text-center">Fasilitas</th>
                    <th class="text-center">Gambar</th>
                    <th class="text-center">Action</th>
                </tr><?php
                $start=0;
                foreach ($kamar_data as $kamar)
                {
                    ?>
                    <tr>
                        <td class="text-center"><?php echo ++$start ?></td>
                        <td><?php echo $kamar->nm_kamar; ?></td>
                        <td class="text-right">Rp. <?php echo format_rupiah($kamar->harga_kamar); ?></td>
                        <td><?php echo $kamar->fasilitas; ?></td>
                        <td class="text-center"><img src="<?php echo base_url(); ?>uploads/foto_kamar/<?php echo $kamar->pic_kamar; ?>" style="max-width: 80px;" alt=""/></td>
                        <td class="text-center">
                            <div class="btn-group btn-group-xs" role="group">
                                <?php
                                echo anchor(site_url('dashboard/kamar/update/'.$kamar->id_kamar),'Update', 'class="btn btn-warning"');
                                echo anchor(site_url('dashboard/kamar/delete/'.$kamar->id_kamar),'Delete','class="btn btn-danger" onclick="javasciprt: return confirm(\'Are You Sure ?\')"');
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
                    <a href="#" class="btn btn-primary">Total Record : <?php echo $total_rows ?></a>
                </div>
                <div class="col-md-6 text-right">
                    <?php echo $pagination ?>
                </div>
            </div>
        </div>
    </div>
</section>