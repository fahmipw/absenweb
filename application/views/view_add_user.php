<script>
    function setUsername() {
        var namauser = document.getElementById('nama_lengkap').value;
        document.getElementById('username').value = namauser.replaceAll(" ", "_").toLowerCase();
    }

    // Fungsi untuk mengubah format nomor telepon menjadi +62
    function formatPhoneNumber() {
        var teleponInput = document.getElementById('telepon');
        var nomorhp = teleponInput.value.trim();
        
        // Bersihkan dari karakter yang tidak perlu
        nomorhp = nomorhp.replace(/[^\d]/g, '');

        // Cek apakah nomorhp diawali dengan 08 atau 8
        if (nomorhp.startsWith('08')) {
            nomorhp = '+62' + nomorhp.slice(1);
        }

        // Update nilai pada input telepon
        teleponInput.value = nomorhp;
    }

    // Tambahkan event listener untuk membatasi input hanya numerik
    document.addEventListener("DOMContentLoaded", function() {
        var teleponInput = document.getElementById('telepon');
        teleponInput.addEventListener('input', function() {
            this.value = this.value.replace(/\D/g, '');
        });
    });
</script>

<br />
<strong>Tambah Data User</strong><br />
<br />
<form id="form1" name="form1" method="post" action="<?php echo site_url('admin/user/save'); ?>" enctype="multipart/form-data">

    <div class="form-group">
        <label for="nik">ID Karyawan </label>
        <input type="text" name="nik" id="nik" class="form-control" required />
    </div>

    <div class="form-group">
        <label for="nama_lengkap">Nama Lengkap</label>
        <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control" required onkeyup="setUsername();" />
    </div>

    <div class="form-group">
        <label for="jkel">Jenis Kelamin</label>
        <select name="jkel" id="jkel" class="form-control" required>
            <option value="">Pilih Jenis Kelamin</option>
            <?php foreach ($arr_jkel as $item) : ?>
                <option value="<?= $item ?>"><?= $item ?></option>
            <?php endforeach ?>
        </select>
    </div>

    <div class="form-group">
        <label for="jabatan">Jabatan</label>
        <select name="jabatan" id="jabatan" class="form-control" required>
            <option value="">Pilih Jabatan</option>
            <?php foreach ($arr_jabatan as $item) : ?>
                <option value="<?= $item->nama_jabatan ?>"><?= $item->nama_jabatan ?></option>
            <?php endforeach ?>
        </select>
    </div>

    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" class="form-control" required readonly />
    </div>

    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" class="form-control" required />
    </div>

    <div class="form-group">
        <label for="level">Level</label>
        <select name="level" id="level" class="form-control" required>
            <option value="">Pilih Level</option>
            <?php foreach ($arr_level as $item) : ?>
                <option value="<?= $item ?>"><?= $item ?></option>
            <?php endforeach ?>
        </select>
    </div>

    <div class="form-group">
        <label for="alamat">Alamat </label>
        <textarea name="alamat" id="alamat" class="form-control" required></textarea>
    </div>

    <div class="form-group">
        <label for="telepon">Nomor Telepon </label>
        <input type="text" name="telepon" id="telepon" class="form-control" required onchange="formatPhoneNumber();" placeholder="Input menggunakan angka" />
    </div>

    <div class="form-group">
        <label for="email">Email </label>
        <input type="email" name="email" id="email" class="form-control" required />
    </div>

    <div class="form-group">
        <button type="submit" id="button" class="btn btn-primary"><i class="fas fa-save"></i> Save</button>
    </div>

</form>
<br />
<br />
