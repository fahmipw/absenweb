<br />
<strong><?= $title ?></strong><br />
<br />
<?php if($this->session->flashdata('user_message')): ?>
    <?= $this->session->flashdata('user_message'); ?>
    <?php $this->session->unset_userdata('user_message'); ?>
<?php endif; ?>
<a class="btn btn-primary" href="<?php echo site_url('admin/user/add'); ?>"><i class="fas fa-plus"></i> Tambah User</a>
<hr>
<div class="table-responsive">
    <table id="dataTable" width="100%" cellspacing="0" class="table table-bordered table-striped table-sm nw">
        <thead>
            <tr>
                <th></th>
                <th>No.</th>
                <th>Username</th>
                <th>Password</th>
                <th>Level</th>
                <th>ID Karyawan</th>
                <th>Nama</th>
                <th>Jabatan</th>
                <th>Jenis Kelamin</th>
                <th>Alamat</th>
                <th>Telepon</th>
                <th>Email</th>
            </tr>
        </thead>
        <?php
        $no = 1;
        foreach ($tabellogin as $rowlogin) {
        ?>
            <tr>
                <td>
                    <div class="d-flex">
                        <a class="btn btn-warning mr-1" href="<?php echo site_url('admin/user/edit/' . urlencode($rowlogin->username)); ?>"><i class="fas fa-pen"></i></a>
                        <a onclick="Swal.fire({title: 'Hapus data?', text: 'Data tidak bisa dikembalikan!', icon: 'warning', showCancelButton: true, confirmButtonColor: '#ffc107', cancelButtonColor: '#d33', confirmButtonText: 'Ya, hapus!', buttonsStyling: true, customClass: {confirmButton: 'text-white', cancelButton: 'text-white'}}).then((result) => { if (result.isConfirmed) { Swal.fire('Terhapus!', 'Data berhasil dihapus.', 'success'); setTimeout(() => { window.location.href = '<?php echo site_url('admin/user/delete/' . urlencode($rowlogin->username)); ?>'; }, 1000); } })" class="btn btn-danger"><i class="fas fa-trash text-white"></i></a>
                    </div>
                </td>
                <td><?php echo $no++; ?></td>
                <td><?php echo $rowlogin->username; ?></td>
                <td><?php echo $rowlogin->password; ?></td>
                <td><?php echo $rowlogin->level; ?></td>
                <td><?php echo $rowlogin->nik; ?></td>
                <td><?php echo $rowlogin->nama_lengkap; ?></td>
                <td><?php echo $rowlogin->jabatan; ?></td>
                <td><?php echo $rowlogin->jkel; ?></td>
                <td><?php echo $rowlogin->alamat; ?></td>
                <td><?php echo $rowlogin->telepon; ?></td>
                <td><?php echo $rowlogin->email; ?></td>
            </tr>
        <?php
        }
        ?>
    </table>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('#dataTable').DataTable({
            fixedColumns: true,
            dom: 'Bfrtip',
            paging: true,
            searching: true,
            bInfo: true,
            buttons: [
                'copy',
                {
                    extend: 'excel',
                    title: '<?= $title ?> | <?= $lembaga?>'
                },
                {
                    extend: 'pdf',
                    title: '<?= $title ?> | <?= $lembaga?>'
                },
                {
                    extend: 'print',
                    title: '<?= $title ?> | <?= $lembaga?>'
                }, 'colvis'
            ]
        });
    });
</script>
