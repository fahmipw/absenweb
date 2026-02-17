<br />
<strong><?= $title ?></strong><br />
<br />
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
                    <a class="btn btn-warning" href="<?php echo site_url('admin/user/edit/' . urlencode($rowlogin->username)); ?>"><i class="fas fa-pen"></i></a>
                    <a onclick="return confirm('Hapus data?');" class="btn btn-danger" href="<?php echo site_url('admin/user/delete/' . urlencode($rowlogin->username)); ?>"><i class="fas fa-trash"></i></a>
                </td>
                <td><?php echo $no++; ?></td>
                <td><?php echo $rowlogin->username; ?></td>
                <td><?php echo $rowlogin->password; ?></td>
                <td><?php echo $rowlogin->level; ?></td>
                <td><?php echo $rowlogin->nik; ?></td>
                <td><?php echo $rowlogin->nama_lengkap; ?></td>
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
