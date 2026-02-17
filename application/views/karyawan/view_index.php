<div class="row">

    <div class="col-xl-4 col-md-4 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Absen Sekarang
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
							<a class="btn btn-primary btn-smxxx" href="<?= site_url('karyawan/absen'); ?>"><?= format_hari_tanggal(date("Y-m-d")); ?> <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
						</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-th fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-4 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Check-In Hari ini
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= current(explode('|', checkabsensi($this->session->userdata('username'), date('Y-m-d'), 'In'))) == '' ? 'Belum Absen Check-In' : date('H:i', strtotime(current(explode('|', checkabsensi($this->session->userdata('username'), date('Y-m-d'), 'In'))))); ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-th-list fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-4 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Check-Out Hari ini
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= current(explode('|', checkabsensi($this->session->userdata('username'), date('Y-m-d'), 'Out'))) == '' ? 'Belum Absen Check-Out' : date('H:i', strtotime(current(explode('|', checkabsensi($this->session->userdata('username'), date('Y-m-d'), 'Out'))))); ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-money-bill-wave fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
