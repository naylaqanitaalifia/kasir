<?php
session_start();

unset($_SESSION["kasir"]);
unset($_SESSION["nominal"]);
unset($_SESSION["bayar_berhasil"]);

header("Location: index.php");
exit;
?>
