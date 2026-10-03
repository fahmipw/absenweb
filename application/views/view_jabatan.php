<br />
<strong><?= $title ?></strong><br /><br />
<a class="btn btn-primary" href="<?= site_url('admin/jabatan/add'); ?>"><i class="fas fa-plus"></i> Tambah</a>
<hr>
<table class="table table-bordered">
    <thead>
        <tr><th>No.</th><th>Nama Jabatan</th><th>Aksi</th></tr>
    </thead>
    <tbody>
        <?php $no = 1; foreach ($jabatan as $row) : ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $row->nama_jabatan ?></td>
                <td>
                    <a class="btn btn-warning" href="<?= site_url('admin/jabatan/edit/'.$row->id) ?>"><i class="fas fa-pen"></i></a>
                    <a class="btn btn-danger" onclick="Swal.fire({title: 'Hapus?', icon: 'warning', showCancelButton: true, confirmButtonText: 'Ya'}).then((result) => { if (result.isConfirmed) window.location.href = '<?= site_url('admin/jabatan/delete/'.$row->id) ?>'; })"><i class="fas fa-trash text-white"></i></a>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>
