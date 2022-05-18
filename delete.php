<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check that the dokter kd_dokter exists
if (isset($_GET['kd_dokter'])) {
    // Select the record that is going to be deleted
    $stmt = $pdo->prepare('SELECT * FROM dokter WHERE kd_dokter = ?');
    $stmt->execute([$_GET['kd_dokter']]);
    $dokter = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$dokter) {
        exit('Dokter doesn\'t exist with that kd_dokter!');
    }
    // Make sure the user confirms beore deletion
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            // User clicked the "Yes" button, delete record
            $stmt = $pdo->prepare('DELETE FROM dokter WHERE kd_dokter = ?');
            $stmt->execute([$_GET['kd_dokter']]);
            $msg = header('Location: read.php');
        } else {
            // User clicked the "No" button, redirect them back to the read page
            header('Location: read.php');
            exit;
        }
    }
} else {
    exit('No kd_dokter specified!');
}
?>


<?=template_header('Delete')?>

<div class="content delete">
	<h2>Delete Dokter #<?=$dokter['kd_dokter']?></h2>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php else: ?>
	<p>Anda yakin ingin menghapus dokter <?=$dokter['nama_dokter']?>?</p>
    <div class="yesno">
        <a onclick="myFunction()" href="delete.php?kd_dokter=<?=$dokter['kd_dokter']?>&confirm=yes">Yes</a>
        <a href="delete.php?kd_dokter=<?=$dokter['kd_dokter']?>&confirm=no">No</a>
    </div>
    <?php endif; ?>
</div>
<script>
function myFunction() {
  alert("Data berhasil dihapus!");
}
</script>

<?=template_footer()?>