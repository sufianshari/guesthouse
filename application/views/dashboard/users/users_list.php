<section class="content-header">
    <h1>Master User/Pengguna</h1>
</section>

<section class="content">
    <div class="box box-success">
        <div class="box-header with-border">
            <div class="row">
                <div class="col-md-4">
                    <?php echo anchor(site_url('dashboard/users/create'),'Tambah Data', 'class="btn btn-primary"'); ?>
                </div>
                <div class="col-md-4 text-center">
                    <div style="margin-top: 8px" id="message">
                        <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                    </div>
                </div>
                <div class="col-md-4 text-right">
                    <form action="<?php echo site_url('dashboard/users/search'); ?>" class="form-inline" method="post">
                        <div class="input-group pull-right">
                            <input name="keyword" class="form-control" placeholder="Cari Data" value="<?php echo $keyword; ?>" />

                            <span class="input-group-btn">
                                <?php
                                if ($keyword <> '')
                                {
                                    ?>
                                    <a href="<?php echo site_url('dashboard/users'); ?>" class="btn btn-warning">Reset</a>
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
                <tr class="bg-green">
                    <th class="text-center">No</th>
                    <th class="text-center">Username</th>
                    <th class="text-center">Email</th>
                    <th class="text-center">First Name</th>
                    <th class="text-center">Last Name</th>
                    <th class="text-center">Company</th>
                    <th class="text-center">Phone</th>
                    <th class="text-center">Action</th>
                </tr><?php
                foreach ($users_data as $users)
                {
                    ?>
                    <tr>
                        <td class="text-center"><?php echo ++$start ?></td>
                        <td><?php echo $users->username; ?></td>
                        <td><?php echo $users->email; ?></td>
                        <td><?php echo $users->first_name; ?></td>
                        <td><?php echo $users->last_name; ?></td>
                        <td><?php echo $users->company; ?></td>
                        <td><?php echo $users->phone; ?></td>
                        <td class="text-center">
                            <div class="btn-group btn-group-xs" role="group">
                                <?php
                                echo anchor(site_url('dashboard/users/edit/'.$users->id),'Update', 'class="btn btn-warning"');
//                                echo anchor(site_url('dashboard/users/delete/'.$users->id_user),'Delete','class="btn btn-danger" onclick="javasciprt: return confirm(\'Are You Sure ?\')"');
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