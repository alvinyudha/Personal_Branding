<?php

$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_bootcamp";

// koneksi database
$conn = mysqli_connect($host, $user, $pass, $db);

// cek koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
