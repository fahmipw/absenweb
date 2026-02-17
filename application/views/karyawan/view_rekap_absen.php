<style>
	.jam-digital {
	width: 100%;
	}
	#jam span {
	float: left;
	text-align: center;
	font-size: 35px;
	color: white;
	margin: 0 2.5%;
	padding: 10px;
	width: 15%;
	border-radius: 10px;
	box-sizing: border-box;
	}
	#jam span:nth-child(1) {
	background: #a70c0c;
	}
	#jam span:nth-child(2) {
	background: #f6ab29;
	}
	#jam span:nth-child(3) {
	background: #298f19;
	}
	#jam::after {
	content: "";
	display: block;
	clear: both;
	}
	#unit span {
	float: left;
	width: 20%;
	margin-top: 30px;
	text-align: center;
	text-transform: uppercase;
	letter-spacing: 2px;
	font-size: 18px;
	text-shadow: 1px 1px 1px rgba(10, 10, 10, 0.7)
	}
	span.turn {
	animation: turn 0.7s ease;
	}
	@keyframes turn {
	0% {transform: rotateX(0deg)}
	100% {transform: rotateX(360deg)}
	}
	@media screen and (max-width: 980px){
	#jam span {
		float: left;
		text-align: center;
		font-size: 50px;
		margin: 0 1.5%;
		padding: 20px;
		width: 20%;
	}
	h1 {
		margin: 20px 5%;
	}
	.jam-digital {
		width: 100%;
		margin: 10% 20%;
	}
	#unit span {
		width: 23%;
	}
	}
</style>

<br />
<strong><?= $title ?></strong><br />
<hr />
<?= $this->session->flashdata('message'); ?>
<?php
for ($d = 1; $d <= 31; $d++) {
    $time = mktime(12, 0, 0, $bulan, $d, $tahun);
    if (date('m', $time) == $bulan) {
        $list[] = date('Y-m-d', $time);
    }
} ?>
<form action="" method="get">
	<div class="row">
		<div class="col-md-6" hidden>
			<div class="form-group">
				<label for="username">Nama Karyawan</label>
				<select name="username" id="username" class="form-control selectpicker" data-live-search="true">
					<option value="">Semua Karyawan</option>
					<?php foreach ($tabellogin as $rowkaryawan) { ?>
						<option value="<?= $rowkaryawan->username; ?>" <?= $rowkaryawan->username == $username ? "selected" : "" ?>><?= $rowkaryawan->nik . ' - ' . $rowkaryawan->nama_lengkap; ?></option>
					<?php } ?>
				</select>
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
				<label for="bulan">Bulan</label>
				<select name="bulan" id="bulan" class="form-control">
					<option value="">Pilih Bulan</option>
					<?php for ($i = 1; $i <= 12; $i++) { ?>
						<option value="<?= $i; ?>" <?= $i == $bulan ? "selected" : "" ?>><?= bulan($i); ?></option>
					<?php } ?>
				</select>
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
				<label for="tahun">Tahun</label>
				<input type="number" class="form-control" name="tahun" id="tahun" step="1" max="<?= date('Y'); ?>" value="<?= $tahun == "" ? date('Y') : $tahun; ?>">
			</div>
		</div>
	</div>
	<button class="btn btn-primary" type="submit"><i class="fa fa-search" aria-hidden="true"></i> Filter</button>
</form>

<hr>
<div class="table-responsive">
    <table class="table table-sm table-bordered table-striped nw" id="dataTable" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Hari</th>
                <th>ID Karyawan</th>
                <th>Nama Karyawan</th>
                <th>Absen Masuk</th>
                <th>Absen Pulang</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1;
            foreach ($tabellogin as $rowkaryawan) {
				if ($username == $rowkaryawan->username) {
                    $masuk = '';
                    $pulang = '';
                    $keterangan1masuk = '';
                    $keterangan1pulang = '';
                    foreach ($list as $tgl) {
                        $absensimasuk = explode('|', checkabsensi($rowkaryawan->username, $tgl, 'In'));
                        $absensipulang = explode('|', checkabsensi($rowkaryawan->username, $tgl, 'Out'));
                        $masuk = $absensimasuk[0];
                        $keterangan1masuk = $absensimasuk[1];
                        $pulang = $absensipulang[0];
                        $keterangan1pulang = $absensipulang[1]; ?>
                        <tr title="<?= $username; ?>">
                            <td><?= $no++; ?></td>
                            <td><?= $tgl; ?></td>
                            <td><?= hari(date('N', strtotime($tgl))); ?></td>
                            <td><?= $rowkaryawan->nik; ?></td>
                            <td><?= $rowkaryawan->nama_lengkap; ?></td>
							<td><?= $masuk == '' ? '-' : date("H:i", strtotime($masuk)); ?></td>
							<td><?= $pulang == '' ? '-' : date("H:i", strtotime($pulang)); ?></td>
							<td>
								<?= $keterangan1masuk == '' ? 'Tidak absen Check-In' : '' . ucwords($keterangan1masuk) . ''; ?><br>
								<?= $keterangan1pulang == '' ? 'Tidak absen Check-Out' : '' . ucwords($keterangan1pulang) . ''; ?>
							</td>
                        </tr>
            	<?php }
                }
				if ($username == '') {
                    $masuk = '';
                    $pulang = '';
                    $keterangan1masuk = '';
                    $keterangan1pulang = '';
                    foreach ($list as $tgl) {
                        $absensimasuk = explode('|', checkabsensi($rowkaryawan->username, $tgl, 'In'));
                        $absensipulang = explode('|', checkabsensi($rowkaryawan->username, $tgl, 'Out'));
                        $masuk = $absensimasuk[0];
                        $keterangan1masuk = $absensimasuk[1];
                        $pulang = $absensipulang[0];
                        $keterangan1pulang = $absensipulang[1]; ?>
                        <tr title="<?= $username; ?>">
                            <td><?= $no++; ?></td>
                            <td><?= $tgl; ?></td>
                            <td><?= hari(date('N', strtotime($tgl))); ?></td>
                            <td><?= $rowkaryawan->nik; ?></td>
                            <td><?= $rowkaryawan->nama_lengkap; ?></td>
							<td><?= $masuk == '' ? '-' : date("H:i", strtotime($masuk)); ?></td>
							<td><?= $pulang == '' ? '-' : date("H:i", strtotime($pulang)); ?></td>
							<td>
								<?= $keterangan1masuk == '' ? 'Tidak absen Check-In' : '' . ucwords($keterangan1masuk) . ''; ?><br>
								<?= $keterangan1pulang == '' ? 'Tidak absen Check-Out' : '' . ucwords($keterangan1pulang) . ''; ?>
							</td>
                        </tr>
            	<?php }
                }
			} ?>
        </tbody>
    </table>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#dataTable').DataTable({
            fixedColumns: {
                left: 0,
                right: 0
            },
            dom: 'Bfrtip',
            paging: true,
            searching: true,
            bInfo: true,
            buttons: [
                'copy',
                {
                    extend: 'excel',
                    title: '<?= $title ?> | <?= $lembaga ?>'
                },
                {
                    extend: 'pdf',
                    title: '<?= $title ?> | <?= $lembaga ?>'
                },
                {
                    extend: 'print',
                    title: '<?= $title ?> | <?= $lembaga ?>'
                }, 'colvis'
            ]
        });
    });
</script>

<script>
	function animation(span) {
		span.className = "turn";
		setTimeout(function () {
			span.className = ""
		}, 700);
	}
	function jam() {
		setInterval(function () {
			var waktu = new Date();
			var jam   = document.getElementById('jam');
			var hours = waktu.getHours();
			var minutes = waktu.getMinutes();
			var seconds = waktu.getSeconds();
			if (waktu.getHours() < 10) {
				hours = '0' + waktu.getHours();
			}
			if (waktu.getMinutes() < 10) {
				minutes = '0' + waktu.getMinutes();
			}
			if (waktu.getSeconds() < 10) {
				seconds = '0' + waktu.getSeconds();
			}
			jam.innerHTML  = '<span>' + hours + '</span>'
							+ '<span>' + minutes + '</span>'
							+ '<span>' + seconds +'</span>';
			var spans = jam.getElementsByTagName('span');
			animation(spans[2]);
			if (seconds == 0) animation(spans[1]);
			if (minutes == 0 && seconds == 0) animation(spans[0]);
		}, 1000);
	}
	jam();
</script>
