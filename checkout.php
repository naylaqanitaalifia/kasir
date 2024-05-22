<?php 
session_start();

if (!isset($_SESSION["kasir"])) {
  $_SESSION["kasir"] = array();
}

// Hitung total belanja dari variabel session
$totalBelanja = 0;
foreach ($_SESSION["kasir"] as $barang) {
  $totalBelanja += $barang["harga"] * $barang["jumlah"];
}
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Kasir</title>

  <!-- Icon -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

  <!-- CSS -->
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container card col-md-8 d-flex flex-column p-5 mt-5">
    <h1 class="text-center fw bold">Bayar Sekarang</h1>

    <?php 
    if (isset($_POST["tambah_barang"])) {
      // Periksa apakah tombol submit telah ditekan sebelum mengakses data $_POST["nominal"]
      if (isset($_POST["nominal"])) {
        $nominalUang = $_POST["nominal"];
    
        if ($nominalUang >= $totalBelanja) {
          $_SESSION["nominal"] = $nominalUang;

          header("Location: struck.php");
          exit;
        } else {
          echo "<div class='alert alert-danger alert-dismissible fade show mt-3' role='alert'>
                  Uang yang Anda masukkan kurang. Silahkan masukkan nominal uang yang mencukupi.
                  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
        }
      }
    }
    ?>

    <form action="" method="post">
      <div class="form-group">
        <label for="nominal" class="form-label">Nominal Uang</label>
        <input type="number" class="form-control" name="nominal" id="nominal" placeholder="Masukkan nominal uang" required>
      </div>
      
      <div class="mt-2">
        <b>Total yang harus Anda bayar Rp <?= number_format($totalBelanja, 0, ',', '.') ?></b>
      </div>

      <div class="form-group mt-2">
          <button type="submit" class="btn btn-primary me-2" name="tambah_barang" value="tambah_barang" target="_blank"><i class="bi bi-wallet2"></i> Bayar</button>
          <a href="index.php" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
      </div>
    </form>
  </div>
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>