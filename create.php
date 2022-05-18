<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if POST data is not empty
if (!empty($_POST)) {
    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, we must check if the POST variables exist if not we can default them to blank
    $kd_dokter = isset($_POST['kd_dokter']) && !empty($_POST['kd_dokter']) && $_POST['kd_dokter'] != 'auto' ? $_POST['kd_dokter'] : NULL;
    // Check if POST variable "name" exists, if not default the value to blank, basically the same for all variables
    $nama_dokter = isset($_POST['nama_dokter']) ? $_POST['nama_dokter'] : '';
    $alamat = isset($_POST['alamat']) ? $_POST['alamat'] : '';
    $no_telepon = isset($_POST['no_telepon']) ? $_POST['no_telepon'] : '';
    $resep_dokter = isset($_POST['resep_dokter']) ? $_POST['resep_dokter'] : '';
    $jenis_dokter = isset($_POST['jenis_dokter']) ? $_POST['jenis_dokter'] : '';

    // Insert new record into the contacts table
    $stmt = $pdo->prepare('INSERT INTO dokter VALUES (?, ?, ?, ?, ?, ?)');
    $stmt->execute([$kd_dokter, $nama_dokter, $alamat, $no_telepon, $resep_dokter, $jenis_dokter]);
    // Output message
    $msg = header('Location: read.php');
}
?>


<?=template_header('Create')?>

<div class="content update">
	<h2>Create Contact</h2>
    <form action="create.php" method="post">
        <label for="kd_dokter">KODE DOKTER</label>
        <label for="nama_dokter">Nama</label>
        <input type="text" name="kd_dokter" value="auto" id="kd_dokter">
        <input type="text" name="nama_dokter" id="nama_dokter">
        <label for="alamat">Alamat</label>
        <label for="no_telepon">No. Telp</label>
        <input type="text" name="alamat" id="alamat">
        <input type="number" name="no_telepon" id="no_telepon">
        <label for="resep_dokter">Resep Dokter</label>
        <label for="jenis_dokter">Jenis Dokter</label>
        <input type="text" name="resep_dokter" id="resep_dokter">
        <input type="text" name="jenis_dokter" id="jenis_dokter">

        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>