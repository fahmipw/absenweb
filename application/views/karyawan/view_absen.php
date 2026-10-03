<style>
	.jam-digital { width: 100%; }
	#jam span { float: left; text-align: center; font-size: 35px; color: white; margin: 0 2.5%; padding: 10px; width: 15%; border-radius: 10px; box-sizing: border-box; }
	#jam span:nth-child(1) { background: #a70c0c; }
	#jam span:nth-child(2) { background: #f6ab29; }
	#jam span:nth-child(3) { background: #298f19; }
	#jam::after { content: ""; display: block; clear: both; }
	#unit span { float: left; width: 20%; margin-top: 30px; text-align: center; text-transform: uppercase; letter-spacing: 2px; font-size: 18px; text-shadow: 1px 1px 1px rgba(10, 10, 10, 0.7) }
	span.turn { animation: turn 0.7s ease; }
	@keyframes turn { 0% {transform: rotateX(0deg)} 100% {transform: rotateX(360deg)} }
	@media screen and (max-width: 980px){ #jam span { float: left; text-align: center; font-size: 50px; margin: 0 1.5%; padding: 20px; width: 20%; } h1 { margin: 20px 5%; } .jam-digital { width: 100%; margin: 10% 20%; } #unit span { width: 23%; } }
	#selfiePreview { max-width: 100%; border: 1px solid #ddd; border-radius: 8px; display: none; margin-top: 10px; }
	.status-pill { display: inline-block; padding: 4px 8px; border-radius: 999px; font-size: 12px; }
	.status-pill.success { background: #e8f5e9; color: #2e7d32; }
	.status-pill.primary { background: #e3f2fd; color: #1976d2; }
	.status-pill.warning { background: #fff3e0; color: #ef6c00; }
	#barcodeScannerPreview { width: 100%; max-height: 240px; background: #000; border-radius: 8px; overflow: hidden; display: none; margin-bottom: 10px; position: relative; }
	#barcodeScannerPreview video { width: 100%; height: auto; display: block; }
	#scannerLoadingOverlay { position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); display: none; justify-content: center; align-items: center; z-index: 10; }
	#scannerLoadingOverlay .spinner { border: 3px solid #f3f3f3; border-top: 3px solid #3498db; border-radius: 50%; width: 40px; height: 40px; animation: spin 1s linear infinite; }
	.loading-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.7); display: none; z-index: 9999; justify-content: center; align-items: center; flex-direction: column; }
	.loading-spinner { border: 4px solid #f3f3f3; border-top: 4px solid #3498db; border-radius: 50%; width: 50px; height: 50px; animation: spin 1s linear infinite; }
	@keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
</style>
<br />
<strong><?= $title ?></strong><br />
<hr />
<div id="liveMessage" style="display: none;"></div>

<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahAbsen" id="btnAbsenSekarang">
    <i class="fas fa-fingerprint"></i> Absen Sekarang
</button>

<div class="loading-overlay" id="loadingOverlay">
    <div class="loading-spinner"></div>
    <div class="text-white mt-3">Memproses absensi...</div>
</div>

<script>
document.getElementById('btnAbsenSekarang').addEventListener('click', function() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            function(position) {
                console.log("Lokasi berhasil diambil:", position.coords.latitude, position.coords.longitude);
            },
            function(error) {
                Swal.fire("Error", "Izin lokasi diperlukan untuk melakukan absensi!", "error");
                console.error("Error lokasi:", error);
            },
            { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
        );
    }
});
</script>

<div class="modal fade" id="tambahAbsen" tabindex="-1" role="dialog" aria-labelledby="tambahAbsenLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahAbsenLabel">Absen Sekarang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="<?= site_url('karyawan/absen/save') ?>" id="formTambahAbsen">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="jam-digital">
                                    <div id="jam"></div>
                                </div>
                                <hr>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="username">Nama Karyawan</label>
                                    <input type="text" class="form-control" name="username" required value="<?= $this->session->userdata('username'); ?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <?php $arr_io = ['In','Out']; ?>
                                <div class="form-group">
                                    <label for="checkinout">Check In/Out</label>
                                    <select class="form-control" name="checkinout" id="checkinout" required>
                                        <option value="">Pilih In/Out</option>
                                        <?php foreach ($arr_io as $item) : ?>
                                            <option value="<?= $item ?>"><?= $item ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="keterangan">Keterangan</label>
                                    <textarea class="form-control" name="keterangan" placeholder="Opsional"></textarea>
                                </div>
                            </div>
                            <div class="col-md-12" style="display:none;">
                                <div class="form-group">
                                    <label for="barcode_code">Kode Barcode</label>
                                    <input type="text" class="form-control" name="barcode_code" id="barcode_code" value="" autocomplete="off" required>
                                    <input type="hidden" name="latitude" id="latitude">
                                    <input type="hidden" name="longitude" id="longitude">
                                </div>
                            </div>
                            <div class="col-md-12">
                                 <div class="form-group">
                                    <label>Scan Barcode Kamera</label>
                                    <div id="barcodeScannerPreview" class="mt-2">
                                        <div id="scannerLoadingOverlay">
                                            <div class="spinner"></div>
                                            <div class="text-white mt-2">Memproses scan...</div>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-wrap gap-2 mt-2">
                                        <button type="button" class="btn btn-outline-primary btn-sm" id="startCameraScan"><i class="fas fa-camera"></i> Mulai Kamera</button>
                                        <button type="button" class="btn btn-outline-secondary btn-sm" id="stopCameraScan" style="display:none;"><i class="fas fa-stop"></i> Stop Kamera</button>
                                    </div>
                                    <small id="scanStatus" class="form-text text-muted">Klik Mulai Kamera untuk melakukan scan barcode.</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<hr>
<div class="table-responsive">
    <table class="table table-sm table-bordered table-striped nw" id="dataTable" width="100%" cellspacing="0">
        <thead>
            <tr>
                 <th>No</th>
                 <th>ID Absen</th>
                 <th>Nama Karyawan</th>
                 <th>Jabatan</th>
                 <th>Waktu Absen</th>
                 <th>Check In/Out</th>
                 <th>Device</th>
                 <th>Status</th>
                 <th>Keterangan</th>
                 <th hidden></th>
            </tr>
        </thead>
        <tbody>
            <?php $page = isset($_GET['page']) ? $_GET['page'] : 0;
            $no = $page + 1;
            foreach ($tabelabsen as $rowabsen) { ?>
                <tr title="<?= $rowabsen->id_absen; ?>">
                    <td><?= $no++; ?></td>
                    <td><?= $rowabsen->id_absen; ?> </td>
                    <td><?= getnama($rowabsen->username); ?> </td>
                    <td><?= getjabatan($rowabsen->username); ?> </td>
                    <td><?= $rowabsen->waktu; ?> </td>
                    <td><?= $rowabsen->checkinout; ?> </td>
                    <td><small><?= htmlspecialchars($rowabsen->device_info) ?></small></td>
                    <td>
                        <?php if ($rowabsen->checkinout == 'Out') { ?>
                            <span class="status-pill primary">Pulang</span>
                        <?php } else { ?>
                            <?= !empty($rowabsen->status_absen) ? '<span class="status-pill success">' . $rowabsen->status_absen . '</span>' : '-' ?>
                        <?php } ?>
                    </td>
                    <td><?= $rowabsen->keterangan; ?> </td>
                    <td hidden>
                        <a href="<?= site_url('karyawan/absen/delete/'.$rowabsen->id_absen) ?>" class="btn btn-danger" onclick="return confirm('Anda yakin hapus <?= $rowabsen->id_absen; ?>?');"><i class="fa fa-trash" aria-hidden="true"></i></a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#dataTable').DataTable({
            fixedColumns: { left: 0, right: 0 },
            dom: 'Bfrtip',
            paging: true,
            searching: true,
            bInfo: true,
            buttons: ['copy', { extend: 'excel', title: '<?= $title ?> | <?= $lembaga ?>' }, { extend: 'pdf', title: '<?= $title ?> | <?= $lembaga ?>' }, { extend: 'print', title: '<?= $title ?> | <?= $lembaga ?>' }, 'colvis']
        });
    });
</script>

<script src="https://unpkg.com/html5-qrcode"></script>
<script>
    // Minta izin lokasi otomatis saat halaman dimuat
    document.addEventListener("DOMContentLoaded", function() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    var latField = document.getElementById('latitude');
                    var lngField = document.getElementById('longitude');
                    if (latField) latField.value = position.coords.latitude;
                    if (lngField) lngField.value = position.coords.longitude;
                    console.log("Lokasi terdeteksi:", position.coords.latitude, position.coords.longitude);
                },
                function(error) {
                    console.warn("Izin lokasi belum diberikan atau gagal:", error.message);
                },
                { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
            );
        }
    });

    function animation(span) { span.className = 'turn'; setTimeout(function () { span.className = ''; }, 700); }
    function jam() { setInterval(function () { var waktu = new Date(); var jam = document.getElementById('jam'); var hours = waktu.getHours(); var minutes = waktu.getMinutes(); var seconds = waktu.getSeconds(); if (waktu.getHours() < 10) { hours = '0' + waktu.getHours(); } if (waktu.getMinutes() < 10) { minutes = '0' + waktu.getMinutes(); } if (waktu.getSeconds() < 10) { seconds = '0' + waktu.getSeconds(); } jam.innerHTML = '<span>' + hours + '</span>' + '<span>' + minutes + '</span>' + '<span>' + seconds + '</span>'; var spans = jam.getElementsByTagName('span'); animation(spans[2]); if (seconds == 0) animation(spans[1]); if (minutes == 0 && seconds == 0) animation(spans[0]); }, 1000); }
    jam();

    (function () {
        var html5QrCode = null;
        var previewContainer = document.getElementById('barcodeScannerPreview');
        var statusBox = document.getElementById('scanStatus');
        var startButton = document.getElementById('startCameraScan');
        var stopButton = document.getElementById('stopCameraScan');
        var barcodeInput = document.getElementById('barcode_code');
        var form = document.getElementById('formTambahAbsen');

        function updateStatus(message, isError) {
            if (!statusBox) return;
            statusBox.textContent = message;
            statusBox.className = 'form-text ' + (isError ? 'text-danger' : 'text-muted');
        }

        async function stopScanner() {
            if (html5QrCode) {
                try {
                    await html5QrCode.stop();
                    html5QrCode = null;
                } catch (err) {
                    console.error('Error stopping:', err);
                }
            }
            if (previewContainer) {
                previewContainer.style.display = 'none';
            }
            if (startButton) startButton.style.display = '';
            if (stopButton) stopButton.style.display = 'none';
        }

        if (startButton) {
            startButton.addEventListener('click', async function () {
                const checkinoutValue = document.getElementById('checkinout').value;
                if (!checkinoutValue) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Perhatian',
                        text: 'Pilih Check In/Out terlebih dahulu!',
                        confirmButtonText: 'OK'
                    });
                    return;
                }
                
                try {
                    previewContainer.style.display = 'block';
                    updateStatus('Membuka kamera dan memproses lokasi...', false);
                    
                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(
                            (position) => {
                                document.getElementById('latitude').value = position.coords.latitude;
                                document.getElementById('longitude').value = position.coords.longitude;
                            },
                            (error) => {
                                updateStatus('Gagal mendapatkan lokasi: ' + error.message, true);
                                stopScanner();
                            }
                        );
                    } else {
                        updateStatus('Geolocation tidak didukung browser ini', true);
                        stopScanner();
                        return;
                    }

                    html5QrCode = new Html5Qrcode("barcodeScannerPreview");
                    const config = { fps: 10, qrbox: { width: 250, height: 250 } };

                    await html5QrCode.start(
                        { facingMode: "user" }, 
                        config,
                        (decodedText) => {
                            if (barcodeInput) {
                                barcodeInput.value = decodedText.toUpperCase();
                            }
                            
                            updateStatus('Barcode terbaca!', false);
                            $('#tambahAbsen').modal('hide');
                            document.getElementById('loadingOverlay').style.display = 'flex';
                            
                            if (html5QrCode) {
                                try {
                                    html5QrCode.stop();
                                } catch(e) {}
                                html5QrCode = null;
                            }
                            previewContainer.style.display = 'none';
                            startButton.style.display = '';
                            stopButton.style.display = 'none';
                            
                            setTimeout(() => {
                                if (form) {
                                    const formData = new FormData(form);
                                    fetch(form.action, { method: 'POST', body: formData })
                                     .then(async (res) => {
                                         const data = await res.json();
                                         document.getElementById('loadingOverlay').style.display = 'none';
                                         if (res.ok && data.status === 'success') {
                                             const statusType = formData.get('checkinout') || '';
                                             Swal.fire({
                                                 icon: 'success',
                                                 title: 'Berhasil',
                                                 text: `Check ${statusType} berhasil! ${data.message}`,
                                                 confirmButtonText: 'OK'
                                             }).then(() => {
                                                 location.reload();
                                             });
                                         } else {
                                             const liveMessage = document.getElementById('liveMessage');
                                             liveMessage.style.display = 'block';
                                             liveMessage.innerHTML = `<div class="alert alert-danger">${data.message || 'Terjadi kesalahan pada sistem'}</div>`;
                                         }
                                     })
                                    .catch(err => {
                                        document.getElementById('loadingOverlay').style.display = 'none';
                                        console.error('Fetch error:', err);
                                        alert('Gagal memproses absensi.');
                                    });
                                }
                            }, 100);
                        }
                    );

                    startButton.style.display = 'none';
                    stopButton.style.display = '';
                    updateStatus('Memindai barcode dari kamera...', false);

                } catch (error) {
                    console.error('Error scanner:', error);
                    updateStatus('Gagal mengakses kamera: ' + error, true);
                    stopScanner();
                }
            });
        }

        if (stopButton) {
            stopButton.addEventListener('click', stopScanner);
        }

        if (form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                $('#tambahAbsen').modal('hide');
                document.getElementById('loadingOverlay').style.display = 'flex';
                
                const formData = new FormData(this);
                fetch(this.action, {
                    method: 'POST',
                    body: formData
                })
                .then(async (response) => {
                    const data = await response.json();
                    document.getElementById('loadingOverlay').style.display = 'none';
                    if (response.ok && data.status === 'success') {
                        const checkinout = document.getElementById('checkinout').value || '';
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: `Check ${checkinout} berhasil! ${data.message}`,
                            confirmButtonText: 'OK'
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        const liveMessage = document.getElementById('liveMessage');
                        liveMessage.style.display = 'block';
                        liveMessage.innerHTML = `<div class="alert alert-danger" role="alert">${data.message || 'Terjadi kesalahan'}</div>`;
                    }
                })
                .catch(error => {
                    document.getElementById('loadingOverlay').style.display = 'none';
                    console.error('Error:', error);
                    alert('Gagal memproses absensi.');
                });
            });
        }
    })();
</script>
