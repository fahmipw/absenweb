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

<li class="nav-item  <?= ($content == "view_index") ? "active" : "" ?>">
    <a class="nav-link" href="<?php echo site_url('home'); ?>">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Home</span>
    </a>
</li>

<!-- Divider -->
<hr class="sidebar-divider">

<li class="nav-item">
    <a class="nav-link" href="<?php echo site_url('home/login'); ?>">
        <i class="fas fa-fw fa-sign-in-alt"></i>
        <span>Login</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider d-none d-md-block">