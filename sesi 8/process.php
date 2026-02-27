<?php

include "koneksi.php";

// ambil data dari form
$nama_produk = $_POST['nama_produk'];
$harga = $_POST['harga'];
$deskripsi = $_POST['deskripsi'];
$categries_name = $_POST['categries_name'];

// query insert
$query = "INSERT INTO products (nama_produk, harga, deskripsi, categories_name)
          VALUES ('$nama_produk', '$harga', '$deskripsi', '$categries_name')";


// jalankan query
if (mysqli_query($conn, $query)) {
    echo "Data produk berhasil disimpan";
} else {
    echo "Gagal menyimpan data";
}
