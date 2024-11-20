<?php
session_start();
require_once('conf/conf.php');
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
date_default_timezone_set("Asia/Bangkok");
$tanggal= mktime(date("m"),date("d"),date("Y"));
$jam=date("H:i");
$setting = mysqli_fetch_array(bukaquery("SELECT nama_instansi, alamat_instansi, kabupaten, propinsi, kontak, email, logo FROM setting"));
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informasi Ketersediaan Kamar</title>
    <link rel="stylesheet" href="bad.css">
    <script src="main.js" defer></script>
</head>
<body>

<header class="header">
    <div class="logo">
        <img src="data:image/jpeg;base64,<?= base64_encode($setting['logo']) ?>" alt="Logo Rumah Sakit" class="logo-img">
    </div>
    <div class="header-content">
        <h1><?= $setting["nama_instansi"] ?></h1>
        <p><?= $setting["alamat_instansi"] ?>, <?= $setting["kabupaten"] ?>, <?= $setting["propinsi"] ?></p>
        <span class="date"><?= date("d-M-Y", $tanggal) . " " . $jam ?></span>
    </div>
</header>

<main>
    <section class="table-container">
        <!-- Pembungkus untuk efek scroll -->
        <div class="scroll-wrapper">
            <table class="availability-table">
                <thead>
                    <tr>
                        <th>NAMA KAMAR</th>
                        <th>JUMLAH BED</th>
                        <th>BED TERISI</th>
                        <th>BED KOSONG</th>
                    </tr>
                </thead>
                <tbody>
                    <?php  
                    $_sql = "SELECT * FROM bangsal WHERE status='1' AND kd_bangsal IN (SELECT kd_bangsal FROM kamar)";
                    $hasil = bukaquery($_sql);

                    while ($data = mysqli_fetch_array($hasil)) {
                        $total_bed = mysqli_fetch_array(bukaquery("SELECT COUNT(kd_bangsal) FROM kamar WHERE kamar.statusdata='1' AND kd_bangsal='".$data['kd_bangsal']."'"))[0];
                        $bed_terisi = mysqli_fetch_array(bukaquery("SELECT COUNT(kd_bangsal) FROM kamar WHERE kamar.statusdata='1' AND kd_bangsal='".$data['kd_bangsal']."' AND status='ISI'"))[0];
                        $bed_kosong = mysqli_fetch_array(bukaquery("SELECT COUNT(kd_bangsal) FROM kamar WHERE kamar.statusdata='1' AND kd_bangsal='".$data['kd_bangsal']."' AND status='KOSONG'"))[0];
                    ?>
                    <tr>
                        <td><?= $data['nm_bangsal'] ?></td>
                        <td><?= $total_bed ?></td>
                        <td><?= $bed_terisi ?></td>
                        <td><?= $bed_kosong ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </section>
</main>

</body>
</html>
