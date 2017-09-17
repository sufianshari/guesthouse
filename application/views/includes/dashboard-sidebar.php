<aside class="main-sidebar">
    <section class="sidebar">
        <ul class="sidebar-menu">
            <li class=""><a href="<?php echo base_url(); ?>dashboard/"><i class="fa fa-home text-red"></i><span>Beranda</span></a></li>
            <li class="treeview">
                <a href="#"><i class="fa fa-th"></i> <span>Manajemen Website</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo base_url(); ?>dashboard/identitas/"><i class="fa fa-circle-o"></i><span>Konfigurasi Website</span></a></li>
                    <li><a href="<?php echo base_url(); ?>dashboard/halaman/"><i class="fa fa-circle-o"></i><span>Halaman Statis</span></a></li>
<!--                    <li><a href="--><?php //echo base_url(); ?><!--dashboard/users/"><i class="fa fa-circle-o"></i><span>Master Users</span></a></li>-->
                    <li><a href="<?php echo base_url(); ?>dashboard/slider/"><i class="fa fa-circle-o"></i><span>Slider</span></a></li>
<!--                    <li><a href="--><?php //echo base_url(); ?><!--dashboard/change_password/"><i class="fa fa-key"></i><span>Ganti Password</span></a></li>-->
                </ul>
            </li>
            <li class="treeview">
                <a href="#"><i class="fa fa-th"></i> <span>Manajemen Kamar</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo base_url(); ?>dashboard/kamar/"><i class="fa fa-circle-o"></i> Kamar</a></li>
                    <li><a href="<?php echo base_url(); ?>dashboard/fasilitas/"><i class="fa fa-circle-o"></i> Fasilitas Kamar</a></li>
                    <li><a href="<?php echo base_url(); ?>dashboard/reservation/"><i class="fa fa-circle-o"></i> Laporan Reservasi</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#"><i class="fa fa-camera-retro"></i> <span>Manajemen Galeri Foto</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo base_url(); ?>dashboard/album/"><i class="fa fa-circle-o"></i> Album Galeri</a></li>
                    <li><a href="<?php echo base_url(); ?>dashboard/galeri/"><i class="fa fa-circle-o"></i>Galeri Foto</a></li>
                </ul>
            </li>
            <li><a href="<?php echo base_url(); ?>dashboard/logout/" class="text-red"><i class="fa fa-lock"></i><span>Log Out</span></a></li>
        </ul>
    </section>
</aside>