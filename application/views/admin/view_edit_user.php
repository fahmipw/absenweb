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

    // Panggil formatPhoneNumber saat halaman dimuat (untuk memastikan nomor telepon sudah dalam format yang diinginkan)
    document.addEventListener('DOMContentLoaded', function() {
        formatPhoneNumber();

        // Tambahkan event listener untuk membatasi input hanya angka
        var teleponInput = document.getElementById('telepon');
        teleponInput.addEventListener('input', function() {
            this.value = this.value.replace(/[^\d]/g, ''); // Hapus karakter selain angka
        });
    });
</script>

<br />
<strong><?= $title ?></strong><br />
<br />
<?= $this->session->flashdata('message'); ?>
<form id="form1" name="form1" method="post" action="<?= site_url('admin/user/update/' . $rowuser->username); ?>" enctype="multipart/form-data">

    <div class="form-group">
        <label for="nik">ID Karyawan </label>
        <input type="text" name="nik" id="nik" class="form-control" required value="<?= $rowuser->nik ?>" />
    </div>
    
    <div class="form-group">
        <label for="nama_lengkap">Nama Lengkap</label>
        <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control" required value="<?= $rowuser->nama_lengkap ?>" onkeyup="setUsername();" />
    </div>

    <div class="form-group">
        <label for="jkel">Jenis Kelamin</label>
        <select name="jkel" id="jkel" class="form-control" required>
            <option value="">Pilih Jenis Kelamin</option>
            <?php foreach ($arr_jkel as $item) : ?>
                <option value="<?= $item ?>" <?= $rowuser->jkel == $item ? "selected" : "" ?>><?= $item ?></option>
            <?php endforeach ?>
        </select>
    </div>

    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" class="form-control" required readonly value="<?= $rowuser->username ?>" />
    </div>

    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" class="form-control" required value="<?= $rowuser->password ?>" />
    </div>

    <div class="form-group">
        <label for="level">Level</label>
        <select name="level" id="level" class="form-control" required>
            <option value="">Pilih Level</option>
            <?php foreach ($arr_level as $item) : ?>
                <option value="<?= $item ?>" <?= $rowuser->level == $item ? "selected" : "" ?>><?= $item ?></option>
            <?php endforeach ?>
        </select>
    </div>

    <div class="form-group">
        <label for="alamat">Alamat </label>
        <textarea name="alamat" id="alamat" class="form-control" required><?= $rowuser->alamat ?></textarea>
    </div>

    <div class="form-group">
    <label for="telepon">Nomor Telepon </label>
    <input type="text" name="telepon" id="telepon" class="form-control" required onchange="formatPhoneNumber();" placeholder="Input menggunakan angka" value="<?= $rowuser->telepon ?>" />
</div>


    <div class="form-group">
        <label for="email">Email </label>
        <input type="email" name="email" id="email" class="form-control" required value="<?= $rowuser->email ?>" />
    </div>

    <div class="form-group" hidden>
        <label for="ttd">TTD </label>
        <input type="file" name="ttd" id="ttd" class="form-control" />
        <img src="<?= asset_url(); ?>upload/ttd/<?= $rowuser->ttd ?>" alt="" width="200px">
    </div>

    <div class="form-group">
        <button type="submit" id="button" class="btn btn-primary"><i class="fas fa-save"></i> Save</button>
    </div>

</form>
<br />
<br />
