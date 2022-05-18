<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if the dokter kd_dokter exists, for example update.php?kd_dokter=1 will get the dokter with the kd_dokter of 1
if (isset($_GET['kd_dokter'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, but instead we update a record and not insert
        $kd_dokter = isset($_POST['kd_dokter']) ? $_POST['kd_dokter'] : NULL;
        $nama_dokter = isset($_POST['nama_dokter']) ? $_POST['nama_dokter'] : '';
        $alamat = isset($_POST['alamat']) ? $_POST['alamat'] : '';
        $no_telepon = isset($_POST['no_telepon']) ? $_POST['no_telepon'] : '';
        $resep_dokter = isset($_POST['resep_dokter']) ? $_POST['resep_dokter'] : '';
        $jenis_dokter = isset($_POST['jenis_dokter']) ? $_POST['jenis_dokter'] : '';
        
        // Update the record
        $stmt = $pdo->prepare('UPDATE dokter SET kd_dokter = ?, nama_dokter = ?, alamat = ?, no_telepon = ?, resep_dokter = ?, jenis_dokter = ? WHERE kd_dokter = ?');
        $stmt->execute([$kd_dokter, $nama_dokter, $alamat, $no_telepon, $resep_dokter, $jenis_dokter, $_GET['kd_dokter']]);
        $msg = header('Location: read.php');
    }
    // Get the dokter from the dokters table
    $stmt = $pdo->prepare('SELECT * FROM dokter WHERE kd_dokter = ?');
    $stmt->execute([$_GET['kd_dokter']]);
    $dokter = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$dokter) {
        exit('dokter doesn\'t exist with that kd_dokter!');
    }
} else {
    exit('No kd_dokter specified!');
}
?>



<?=template_header('Read')?>

<div class="content update">
	<h2>Update dokter</h2>
    <form action="update.php?kd_dokter=<?=$dokter['kd_dokter']?>" method="post">
        <label for="kd_dokter">Kode Dokter</label>
        <label for="nama_dokter">Nama Dokter</label>
        <input type="text" name="kd_dokter" value="<?=$dokter['kd_dokter']?>" id="kd_dokter">
        <input type="text" name="nama_dokter" value="<?=$dokter['nama_dokter']?>" id="nama_dokter">
        <label for="alamat">Alamat</label>
        <label for="no_telepon">No. Telp</label>
        <input type="text" name="alamat" value="<?=$dokter['alamat']?>" id="alamat">
        <input type="text" name="no_telepon" value="<?=$dokter['no_telepon']?>" id="no_telepon">
        <label for="resep_dokter">Resep Dokter</label>
        <label for="jenis_dokter">Jenis Dokter</label>
        <input type="text" name="resep_dokter" value="<?=$dokter['resep_dokter']?>" id="title">
        <input type="text" name="jenis_dokter" value="<?=$dokter['jenis_dokter']?>" id="title">
        <input type="submit" value="Update" >
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>