<br />
<strong><?= $title ?></strong><br />
<br />
<?php if($this->session->flashdata('message')): ?>
    <?= $this->session->flashdata('message'); ?>
    <?php $this->session->set_flashdata('message', ''); ?>
<?php endif; ?>
<form id="form1" name="form1" method="post" action="<?php echo site_url('admin/home/update_password'); ?>">
    <table class="table">
        <tr>
            <td width="147">Username</td>
            <td width="180"><input type="text" name="username" id="username" value="<?php echo $this->session->userdata('username'); ?>" readonly class="form-control" required /></td>
        </tr>
        <tr>
            <td>Password Lama</td>
            <td><input type="password" name="lama" id="lama" class="form-control" required /></td>
        </tr>
        <tr>
            <td>Password Baru</td>
            <td><input type="password" name="baru" id="baru" class="form-control" required /></td>
        </tr>
        <tr>
            <td>Konfirmasi Password</td>
            <td><input type="password" name="konfirmasi" id="konfirmasi" required class="form-control" /></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td><input type="submit" name="button" id="button" value="Simpan" class="btn btn-primary" /></td>
        </tr>
    </table>
</form>
<br />
<br />