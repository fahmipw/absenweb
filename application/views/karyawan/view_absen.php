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

<!-- Button trigger tambahAbsen -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahAbsen">
    <i class="fas fa-fingerprint"></i> Absen Sekarang
</button>

<!-- tambahAbsen -->
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
									<div id="unit">
										<!-- <span>Jam</span>
										<span>Menit</span>
										<span>Detik</span> -->
									</div>
								</div>
								<hr>
							</div>
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <label for="username">Nama Karyawan</label>
                                        <input type="text" class="form-control" name="username" required value="<?= $this->session->userdata('username');
										?>" readonly>
                                    </div>
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
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <label for="keterangan">Keterangan</label>
                                        <textarea class="form-control" name="keterangan" required></textarea>
                                    </div>
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
                <th>Waktu Absen</th>
                <th>Check In/Out</th>
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
                    <td><?= $rowabsen->waktu; ?> </td>
                    <td><?= $rowabsen->checkinout; ?> </td>
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
