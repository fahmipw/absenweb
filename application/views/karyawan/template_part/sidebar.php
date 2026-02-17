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
    <a class="nav-link" href="<?= site_url('karyawan/home'); ?>">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Home</span>
    </a>
</li>

<?php
$arr_biaya = ['view_biaya'];
$arr_absen = ['view_absen'];
$arr_rekap_absen = ['view_rekap_absen'];
$arr_master = array_merge($arr_absen, $arr_rekap_absen);
?>
<li class="nav-item <?= in_array($content, $arr_master) ? "active" : "" ?>">
    <a class="nav-link" href="#" data-toggle="collapse" data-target="#arr_master" aria-expanded="true" aria-controls="arr_master">
        <i class="fas fa-fw fa-th-large" aria-hidden="true"></i>
        <span>Absensi</span>
    </a>
    <div id="arr_master" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <!-- <h6 class="collapse-header">Custom Components:</h6> -->
            <a class="collapse-item <?= in_array($content, $arr_absen) ? "active" : "" ?>" href="<?= site_url('karyawan/absen'); ?>">Absen Sekarang</a>
            <a class="collapse-item <?= in_array($content, $arr_rekap_absen) ? "active" : "" ?>" href="<?= site_url('karyawan/absen/rekap'); ?>">Rekap Absensi</a>
        </div>
    </div>
</li>
