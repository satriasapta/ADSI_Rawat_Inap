<?php
include 'functions.php';
// Connect to MySQL database
$pdo = pdo_connect_mysql();
// Get the page via GET request (URL param: page), if non exists default the page to 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
// Number of records to show on each page
$records_per_page = 5;


// Prepare the SQL statement and get records from our dokters table, LIMIT will determine the page
$stmt = $pdo->prepare('SELECT * FROM dokter ORDER BY kd_dokter LIMIT :current_page, :record_per_page');
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();
// Fetch the records so we can display them in our template.
$dokters = $stmt->fetchAll(PDO::FETCH_ASSOC);


// Get the total number of dokters, this is so we can determine whether there should be a next and previous button
$num_dokters = $pdo->query('SELECT COUNT(*) FROM dokter')->fetchColumn();
?>


<?=template_header('Read')?>

<div class="content read">
	<h2>Data Dokter</h2>
	<a href="create.php" class="create-dokter">Input Data Dokter</a>
	<table>
        <thead>
            <tr>
                <td>Kode Dokter</td>
                <td>Nama</td>
                <td>Alamat</td>
                <td>No. Telp</td>
                <td>Resep Dokter</td>
                <td>Jenis Dokter</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($dokters as $dokter): ?>
            <tr>
                <td><?=$dokter['kd_dokter']?></td>
                <td><?=$dokter['nama_dokter']?></td>
                <td><?=$dokter['alamat']?></td>
                <td><?=$dokter['no_telepon']?></td>
                <td><?=$dokter['resep_dokter']?></td>
                <td><?=$dokter['jenis_dokter']?></td>
                <td class="actions">
                    <a href="update.php?kd_dokter=<?=$dokter['kd_dokter']?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                    <a href="delete.php?kd_dokter=<?=$dokter['kd_dokter']?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
	<div class="pagination">
		<?php if ($page > 1): ?>
		<a href="read.php?page=<?=$page-1?>"> <i class="fas fa-angle-double-left fa-sm"></i></a>
		<?php endif; ?>
		<?php if ($page*$records_per_page < $num_dokters): ?>
		<a href="read.php?page=<?=$page+1?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
		<?php endif; ?>
	</div>
</div>

<?=template_footer()?>