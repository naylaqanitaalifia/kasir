<?php
session_start();

if (!isset($_SESSION["kasir"]) || empty($_SESSION["kasir"])) {
    header("Location: index.php");
    exit;
}

// Set zona waktu
date_default_timezone_set('Asia/Jakarta');

// Ambil data barang dari variabel session
$dataBarang = isset($_SESSION["kasir"]) ? $_SESSION["kasir"] : array();

// Ambil nominal uang dari variabel session 
$nominalUang = isset($_SESSION["nominal"]) ? $_SESSION["nominal"] : 0;

// Hitung total belanja dari variabel session
$totalBelanja = 0;
foreach ($dataBarang as $barang) {
  $totalBelanja += $barang["harga"] * $barang["jumlah"];
}

// Hitung kembalian 
$kembalian = $nominalUang - $totalBelanja;

// Ambil tanggal saat ini
$tanggal = date("d/m/Y");

// Ambil jam saat ini;
$jam = date("H:i:s");

$_SESSION["bayar_berhasil"] = true;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Struk Pembayaran</title>
    
    <!-- Icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- CSS -->
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container card mt-5 col-md-4 d-flex flex-col">
        <div class="row">
            <div class="card card-light">
                <div class="text-center text-dark">
                    <h3 class="fw-bold mt-5">KASIRKU</h3>
                    <p class="text-title mb-1">Jl. Gempol Kulon Kel. Citarum, Kec. Bandung, Kota Bandung, Jawa Barat 40115</p>
                </div>
                <div class="card-body">
                    <hr>
                    <div class="row mb-3">
                        <div class="col-6">
                            <p class="mb-1"><?= $tanggal; ?></p>
                        </div>
                        <div class="col-6 text-end">
                            <p class="mb-1"><?= $jam; ?></p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-6">
                            <?php foreach ($dataBarang as $barang): ?> 
                                <div class="mb-1"><?= $barang["nama"] ?></div>
                            <?php endforeach; ?>
                        </div>
                        <div class="col-6 text-end">
                            <?php foreach ($dataBarang as $barang): ?>
                                <div class='mb-1 row'>
                                    <div class='col'><?= $barang['jumlah'] ?></div>
                                    <div class='col'><?= number_format($barang['harga'], 0, ',', '.') ?></div>
                                    <div class='col'><?= number_format($barang['harga'] * $barang['jumlah'], 0, ',', '.') ?></div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-6">
                            <p class="mb-1">Total</p>
                        </div>
                        <div class="col-6 text-end">
                            <p class="mb-1"><?= number_format($totalBelanja, 0, ',', '.') ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <p class="mb-1">Tunai</p>
                        </div>
                        <div class="col-6 text-end">
                            <p class="mb-1"><?= number_format($nominalUang, 0, ',', '.') ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <p class="mb-1">Kembali</p>
                        </div>
                        <div class="col-6 text-end">
                            <p class="mb-1"><?= number_format($kembalian, 0, ',', '.') ?></p>
                        </div>
                    </div>
                </div>
                <div class="text-muted text-center mb-5">
                    TERIMA KASIH ATAS KUNJUNGAN ANDA
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>