<div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Jumlah Karyawan</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= decimal($totalkaryawan, 0); ?></div>
                    </div>
                    <div class="col-auto"><i class="fas fa-users fa-2x text-gray-300"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Hadir Hari Ini</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_hadir_hari_ini; ?></div>
                    </div>
                    <div class="col-auto"><i class="fas fa-user-check fa-2x text-gray-300"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Terlambat</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $terlambat; ?></div>
                    </div>
                    <div class="col-auto"><i class="fas fa-clock fa-2x text-gray-300"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Belum Pulang</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $belum_pulang; ?></div>
                    </div>
                    <div class="col-auto"><i class="fas fa-door-open fa-2x text-gray-300"></i></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-6 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">Grafik Absensi Bulanan</h6></div>
            <div class="card-body">
                <canvas id="absensiChart" height="220"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-6 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">Peta Lokasi Absensi</h6></div>
            <div class="card-body">
                <div id="attendanceMap" style="height:220px;border:1px solid #ddd;border-radius:8px;"></div>
            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js?v=<?= time() ?>"></script>
<script>
const ctx = document.getElementById('absensiChart');
if (ctx) {
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des'],
            datasets: [{ label: 'Absensi', data: <?= json_encode($monthly_counts); ?>, backgroundColor: '#4e73df' }]
        },
        options: { responsive: true, maintainAspectRatio: false }
    });
}

const mapEl = document.getElementById('attendanceMap');
if (mapEl) {
    // Hapus map lama jika ada
    if (window.attendanceMapInstance) {
        window.attendanceMapInstance.remove();
    }
    const lat = -6.27291666666667;
    const lng = 106.873305555556;
    window.attendanceMapInstance = L.map('attendanceMap').setView([lat, lng], 17);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png?t=' + new Date().getTime(), { maxZoom: 19 }).addTo(window.attendanceMapInstance);
    L.circle([lat, lng], { radius: 50, color: 'red', fillColor: '#f03', fillOpacity: 0.15 }).addTo(window.attendanceMapInstance);
    L.marker([lat, lng]).addTo(window.attendanceMapInstance).bindPopup('<b>Titik Pusat Absensi</b><br>Radius 50m');
    <?php foreach ($absensi_lokasi as $row) { if (!empty($row->latitude) && !empty($row->longitude)) { ?>
    L.marker([<?= $row->latitude; ?>, <?= $row->longitude; ?>]).addTo(window.attendanceMapInstance).bindPopup('<?= addslashes(getnama($row->username)); ?>');
    <?php } } ?>
}
</script>
