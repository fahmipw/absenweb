<style>
    .barcode-container { text-align: center; padding: 20px; display: flex; flex-direction: column; align-items: center; justify-content: center; }
    #qrcode { margin: 20px auto; background: white; padding: 15px; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
    #dateDisplay { font-size: 28px; font-weight: bold; color: #2c3e50; }
    #timeDisplay { font-size: 36px; font-weight: bold; color: #e74c3c; margin-top: 5px; }
    .instruction { font-size: 20px; color: #7f8c8d; margin-bottom: 10px; font-weight: 500; }
</style>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary"><?= $title ?></h6>
        <button class="btn btn-sm btn-primary" id="btnFullscreen"><i class="fas fa-expand"></i> Layar Penuh</button>
    </div>
    <div class="card-body">
        <div class="barcode-container">
            <div class="instruction"><i class="fas fa-qrcode"></i> Silakan Scan Barcode Ini untuk Absen Check In / Out</div>
            <div id="qrcode"></div>
            <div id="dateDisplay"></div>
            <div id="timeDisplay"></div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/qrcode@1.5.1/build/qrcode.min.js"></script>
<script>
    const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
    const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

    function formatDate() {
        const now = new Date();
        const dayName = days[now.getDay()];
        const day = now.getDate();
        const monthName = months[now.getMonth()];
        const year = now.getFullYear();
        return `${dayName}, ${day} ${monthName} ${year}`;
    }

    function formatTime() {
        const now = new Date();
        return now.toLocaleTimeString('id-ID');
    }

    let lastCode = '';

    function updateBarcode() {
        fetch("<?= site_url('admin/barcode/get_barcode_data') ?>")
            .then(res => res.json())
            .then(data => {
                document.getElementById('dateDisplay').innerText = formatDate();
                document.getElementById('timeDisplay').innerText = formatTime();
                
                if (lastCode !== data.barcode_code) {
                    lastCode = data.barcode_code;
                    const qrcodeContainer = document.getElementById('qrcode');
                    qrcodeContainer.innerHTML = "";
                    QRCode.toCanvas(data.barcode_code, {
                        width: 280,
                        height: 280
                    }, function (error, canvas) {
                        if (error) console.error(error);
                        else qrcodeContainer.appendChild(canvas);
                    });
                }
            });
    }

    updateBarcode();
    setInterval(updateBarcode, 1000);

    document.getElementById('btnFullscreen').addEventListener('click', function() {
        if (!document.fullscreenElement) {
            document.documentElement.requestFullscreen();
            this.innerHTML = '<i class="fas fa-compress"></i> Keluar Layar Penuh';
        } else {
            if (document.exitFullscreen) {
                document.exitFullscreen();
                this.innerHTML = '<i class="fas fa-expand"></i> Layar Penuh';
            }
        }
    });
</script>
