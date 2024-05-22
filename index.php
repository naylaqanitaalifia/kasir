<?php 
session_start();

if (!isset($_SESSION["kasir"])) {
  $_SESSION["kasir"] = array();
}

if (isset($_SESSION["bayar_berhasil"])) {
  header("Location: delete.php");
  exit;
}

if (isset($_POST["tambah_barang"])) {
  $data = array(
    "nama" => $_POST["nama"],
    "harga" => $_POST["harga"],
    "jumlah" => $_POST["jumlah"]
  );

  $barang_exist = false;
  foreach ($_SESSION["kasir"] as $key => $item) {
    if ($item["nama"] === $_POST["nama"]) {
      $barang_exist = true;
      $_SESSION["kasir"][$key]["jumlah"] += $_POST["jumlah"];
      break;
    }
  }

  if (!$barang_exist) {
    array_push($_SESSION["kasir"], $data);
  }

  $_SESSION["nominal"] = $_POST["nominal"];
  
  header("Location: index.php");
  exit;
}

if (isset($_GET["hapus"])) {
  $index = $_GET["hapus"];
  unset($_SESSION["kasir"][$index]);
  header("Location: index.php");
  $_SESSION["kasir"] = array_values($_SESSION["kasir"]);
  exit;
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
      <h1 class="text-center fw bold">Masukkan Data Barang</h1>
      <form action="" method="post">
        <div class="row mb-3">
          <div class="col">
            <div class="form-group">
              <label for="nama" class="form-label">Nama Barang</label>
              <input type="text" class="form-control" name="nama" id="nama" placeholder="Masukkan nama barang" required>
            </div>
          </div>

          <div class="col">
            <div class="form-group">
              <label for="harga" class="form-label">Harga Barang</label>
              <input type="number" class="form-control" name="harga" id="harga" placeholder="Masukkan harga barang" required>
            </div>
          </div>

          <div class="col">
            <div class="form-group">
              <label for="jumlah" class="form-label">Jumlah Barang</label>
              <input type="number" class="form-control" name="jumlah" id="jumlah" placeholder="Masukkan jumlah barang" required>
            </div>
          </div>

          <div class="row mt-2">
            <div class="form-group">
              <button type="submit" class="btn btn-success mt-2 mb-2" name="tambah_barang" value="tambah_barang"><i class="bi bi-plus"></i> Tambah</button>
              <?php 
              if (isset($_SESSION["kasir"]) && $_SESSION["kasir"]) {
                echo "<a href='checkout.php' class='btn btn-primary mt-2 mb-2' name='bayar'><i class='bi bi-wallet2'></i> Bayar</a>";
              }
              ?>
            </div>
          </div>
        </div>
      </form>

      <?php 
      echo "<table class='table-container table-bordered text-center'>
              <thead class='table-light'>
                <tr>
                  <th scope='col'>No</th>
                  <th scope='col'>Nama Barang</th>
                  <th scope='col'>Harga Barang</th>
                  <th scope='col'>Jumlah Barang</th>
                  <th scope='col'>Opsi</th>
                </tr>
              </thead>
              <tbody>";

      if (isset($_SESSION["kasir"]) && !empty($_SESSION["kasir"])) {
        foreach ($_SESSION["kasir"] as $index => $value) {
          echo "<tr>
                  <td>" . ($index +1) . "</td>
                  <td>" . $value["nama"] . "</td>
                  <td>" . number_format($value["harga"], '0', ',', '.') . "</td>
                  <td>" . $value["jumlah"] . "</td>
                  <td class=''>
                    <a href='?hapus=" . $index . "' class='btn btn-danger mt-2 mb-2'><i class='bi bi-trash'></i> Hapus</a>
                  </td>
                </tr>";
        }
      } else {
        echo "<tr>
                <td colspan='5' class='text-danger p-2'>Tidak ada data!</td>
              </tr>";
      }
      
      echo "</tbody></table>";
      ?>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>