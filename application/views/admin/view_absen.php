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
	.status-pill { display: inline-block; padding: 4px 8px; border-radius: 999px; font-size: 12px; }
	.status-pill.success { background: #e8f5e9; color: #2e7d32; }
	.status-pill.warning { background: #fff3e0; color: #ef6c00; }
	#barcodeScannerPreview { width: 100%; max-height: 240px; background: #000; border-radius: 8px; overflow: hidden; display: none; margin-bottom: 10px; }
	#barcodeScannerPreview video { width: 100%; height: auto; display: block; }
</style>
<br />
<strong><?= $title ?></strong><br />
<hr />
<?php if($this->session->flashdata('message')): ?>
    <?= $this->session->flashdata('message'); ?>
    <?php $this->session->unset_userdata('message'); ?>
<?php endif; ?>

<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahAbsen">
    <i class="fas fa-fingerprint"></i> Absen Sekarang
</button>

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
                <form method="POST" action="<?= site_url('admin/absen/save') ?>" id="formTambahAbsen">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="jam-digital"><div id="jam"></div></div>
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
                                    <textarea class="form-control" name="keterangan" required></textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="barcode_code">Kode Barcode</label>
                                    <input type="text" class="form-control" name="barcode_code" id="barcode_code" placeholder="Scan atau masukkan kode barcode harian" autocomplete="off" required>
                                    <div id="barcodeScannerPreview" class="mt-2"></div>
                                    <div class="d-flex flex-wrap gap-2 mt-2">
                                        <button type="button" class="btn btn-outline-primary btn-sm" id="startCameraScan"><i class="fas fa-camera"></i> Pakai Kamera</button>
                                        <button type="button" class="btn btn-outline-secondary btn-sm" id="stopCameraScan" style="display:none;"><i class="fas fa-stop"></i> Stop Kamera</button>
                                    </div>
                                    <small id="scanStatus" class="form-text text-muted">Klik tombol di atas untuk memulai pemindaian barcode dari kamera.</small>
                                    <small class="form-text text-muted">Gunakan kode barcode yang ditampilkan pada monitor admin.</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" form="formTambahAbsen"><i class="fas fa-fingerprint"></i> Submit</button>
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
                <th>Barcode</th>
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
                    <td><?= !empty($rowabsen->barcode_code) ? $rowabsen->barcode_code : '-' ?></td>
                    <td><?= !empty($rowabsen->status_absen) ? '<span class="status-pill success">' . $rowabsen->status_absen . '</span>' : '-' ?></td>
                    <td><?= $rowabsen->keterangan; ?> </td>
                    <td hidden>
                        <a onclick="Swal.fire({title: 'Anda yakin hapus <?= $rowabsen->id_absen; ?>?', text: 'Data tidak bisa dikembalikan!', icon: 'warning', showCancelButton: true, confirmButtonColor: '#ffc107', cancelButtonColor: '#d33', confirmButtonText: 'Ya, hapus!', buttonsStyling: true, customClass: {confirmButton: 'text-white', cancelButton: 'text-white'}}).then((result) => { if (result.isConfirmed) { Swal.fire('Terhapus!', 'Data berhasil dihapus.', 'success'); setTimeout(() => { window.location.href = '<?= site_url('admin/absen/delete/'.$rowabsen->id_absen) ?>'; }, 1000); } })" class="btn btn-danger"><i class="fa fa-trash text-white" aria-hidden="true"></i></a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#dataTable').DataTable({ fixedColumns: { left: 0, right: 0 }, dom: 'Bfrtip', paging: true, searching: true, bInfo: true, buttons: ['copy', { extend: 'excel', title: '<?= $title ?> | <?= $lembaga ?>' }, { extend: 'pdf', title: '<?= $title ?> | <?= $lembaga ?>' }, { extend: 'print', title: '<?= $title ?> | <?= $lembaga ?>' }, 'colvis'] });
    });
</script>

<script src="https://unpkg.com/jsqr@1.4.0/dist/jsQR.js"></script>
<script>
    function animation(span) { span.className = 'turn'; setTimeout(function () { span.className = ''; }, 700); }
    function jam() { setInterval(function () { var waktu = new Date(); var jam = document.getElementById('jam'); var hours = waktu.getHours(); var minutes = waktu.getMinutes(); var seconds = waktu.getSeconds(); if (waktu.getHours() < 10) { hours = '0' + waktu.getHours(); } if (waktu.getMinutes() < 10) { minutes = '0' + waktu.getMinutes(); } if (waktu.getSeconds() < 10) { seconds = '0' + waktu.getSeconds(); } jam.innerHTML = '<span>' + hours + '</span>' + '<span>' + minutes + '</span>' + '<span>' + seconds + '</span>'; var spans = jam.getElementsByTagName('span'); animation(spans[2]); if (seconds == 0) animation(spans[1]); if (minutes == 0 && seconds == 0) animation(spans[0]); }, 1000); }
    jam();

    (function () {
        var isScanning = false;
        var stream = null;
        var previewContainer = document.getElementById('barcodeScannerPreview');
        var statusBox = document.getElementById('scanStatus');
        var startButton = document.getElementById('startCameraScan');
        var stopButton = document.getElementById('stopCameraScan');
        var barcodeInput = document.getElementById('barcode_code');
        var form = document.getElementById('formTambahAbsen');
        var videoElement = null;
        var canvas = null;
        var context = null;

        function updateStatus(message, isError) {
            if (!statusBox) return;
            statusBox.textContent = message;
            statusBox.className = 'form-text ' + (isError ? 'text-danger' : 'text-muted');
        }

        function stopScanner() {
            isScanning = false;
            if (stream) {
                stream.getTracks().forEach(function (track) { track.stop(); });
                stream = null;
            }
            if (videoElement) {
                videoElement.pause();
                videoElement.srcObject = null;
            }
            if (previewContainer) {
                previewContainer.style.display = 'none';
                previewContainer.innerHTML = '';
            }
            if (startButton) startButton.style.display = '';
            if (stopButton) stopButton.style.display = 'none';
        }

        function scanFrame() {
            if (!isScanning || !videoElement || !canvas || !context) return;
            if (videoElement.readyState === videoElement.HAVE_CURRENT_DATA) {
                var width = videoElement.videoWidth;
                var height = videoElement.videoHeight;
                if (width && height) {
                    canvas.width = width;
                    canvas.height = height;
                    context.drawImage(videoElement, 0, 0, width, height);
                    var imageData = context.getImageData(0, 0, width, height);
                    var code = window.jsQR(imageData.data, width, height);
                    if (code) {
                        if (barcodeInput) {
                            barcodeInput.value = code.data.toUpperCase();
                        }
                        updateStatus('Barcode berhasil terbaca. Silakan lanjutkan atau kirim absensi.', false);
                        stopScanner();
                        if (form) {
                            setTimeout(function () {
                                form.submit();
                            }, 400);
                        }
                        return;
                    }
                }
            }
            if (isScanning) {
                requestAnimationFrame(scanFrame);
            }
        }

        if (startButton) {
            startButton.addEventListener('click', async function () {
                if (isScanning) return;
                if (!window.jsQR || !navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                    updateStatus('Browser ini belum mendukung pemindaian barcode lewat kamera. Silakan masukkan kode secara manual.', true);
                    return;
                }

                try {
                    previewContainer.style.display = 'block';
                    updateStatus('Membuka kamera...', false);

                    stream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' } });
                    videoElement = document.createElement('video');
                    videoElement.autoplay = true;
                    videoElement.playsInline = true;
                    videoElement.muted = true;
                    videoElement.srcObject = stream;
                    previewContainer.innerHTML = '';
                    previewContainer.appendChild(videoElement);
                    await videoElement.play();

                    canvas = document.createElement('canvas');
                    context = canvas.getContext('2d');

                    isScanning = true;
                    startButton.style.display = 'none';
                    stopButton.style.display = '';
                    updateStatus('Memindai barcode dari kamera...', false);
                    scanFrame();
                } catch (error) {
                    stopScanner();
                    updateStatus('Gagal mengakses kamera: ' + error.message, true);
                }
            });
        }

        if (stopButton) {
            stopButton.addEventListener('click', function () {
                stopScanner();
                updateStatus('Pemindaian kamera dihentikan. Anda tetap bisa memasukkan kode secara manual.', false);
            });
        }
    })();
</script>
