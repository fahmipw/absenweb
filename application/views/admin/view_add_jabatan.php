<br /><strong><?= $title ?></strong><br /><br />
<form method="post" action="<?= site_url('admin/jabatan/'.(isset($row) ? 'update/'.$row->id : 'save')) ?>">
    <div class="form-group">
        <label>Nama Jabatan</label>
        <input type="text" name="nama_jabatan" class="form-control" required value="<?= isset($row) ? $row->nama_jabatan : '' ?>">
    </div>
    <button type="submit" class="btn btn-primary">Save</button>
</form>
