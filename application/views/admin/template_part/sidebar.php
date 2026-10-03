<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center">
    <div class="sidebar-brand-icon rotate-n-15xxx">
        <!-- <i class="fas fa-laugh-wink"></i> -->
        <img src="<?= asset_url(); ?>/images/logo.png" width="100%" alt="">
    </div>
    <div class="sidebar-brand-text mx-3xxx"> <sup></sup></div>
</a>

<!-- Divider -->
<hr class="sidebar-divider my-0">

<li class="nav-item <?= ($content == "view_index") ? "active" : "" ?>">
    <a class="nav-link" href="<?= site_url('admin/home'); ?>">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Home</span>
    </a>
</li>

<li class="nav-item <?= ($content == "view_user") ? "active" : "" ?>">
    <a class="nav-link" href="<?= site_url('admin/user'); ?>">
        <i class="fas fa-fw fa-user-circle"></i>
        <span>Management User</span>
    </a>
</li>

<li class="nav-item <?= ($content == "view_jabatan") ? "active" : "" ?>">
    <a class="nav-link" href="<?= site_url('admin/jabatan'); ?>">
        <i class="fas fa-fw fa-briefcase"></i>
        <span>Jabatan</span>
    </a>
</li>

<li class="nav-item <?= ($content == "view_barcode") ? "active" : "" ?>">
    <a class="nav-link" href="<?= site_url('admin/barcode'); ?>">
        <i class="fas fa-fw fa-qrcode"></i>
        <span>Barcode Absensi</span>
    </a>
</li>

<?php
$arr_biaya = ['view_biaya'];
$arr_absen = ['view_absen'];
$arr_rekap_absen = ['view_rekap_absen'];
$arr_master = array_merge($arr_absen, $arr_rekap_absen);
?>
<li class="nav-item <?= in_array($content, $arr_master) ? "active" : "" ?>">
    <a class="nav-link" href="#arr_master" data-toggle="collapse" data-target="#arr_master" aria-expanded="<?= in_array($content, $arr_master) ? "true" : "false" ?>" aria-controls="arr_master">
        <i class="fas fa-fw fa-clipboard-list" aria-hidden="true"></i>
        <span>Absensi</span>
        <i class="fas fa-chevron-down ml-auto"></i>
    </a>
    <div id="arr_master" class="collapse <?= in_array($content, $arr_master) ? "show" : "" ?>" data-parent="#accordionSidebar" style="margin-left: 1.2rem; border-left: 2px solid rgba(255,255,255,0.14); padding-left: 0.6rem;">
        <a class="nav-link py-2 pl-2 pr-3 text-white-50 <?= in_array($content, $arr_absen) ? "active" : "" ?>" href="<?= site_url('admin/absen'); ?>">
            <i class="fas fa-fw fa-fingerprint mr-2"></i>Absen Sekarang
        </a>
        <a class="nav-link py-2 pl-2 pr-3 text-white-50 <?= in_array($content, $arr_rekap_absen) ? "active" : "" ?>" href="<?= site_url('admin/absen/rekap'); ?>">
            <i class="fas fa-fw fa-chart-bar mr-2"></i>Rekap Absensi
        </a>
    </div>
</li>
