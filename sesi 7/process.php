<?php

include "../koneksi.php";

// ambil data dari form
$nama_produk = $_POST['nama_produk'];
$harga = $_POST['harga'];
$deskripsi = $_POST['deskripsi'];
$kategori_id = $_POST['kategori_id'];

// query insert
$query = "INSERT INTO products (nama_produk, harga, deskripsi, categories_id)
          VALUES ('$nama_produk', '$harga', '$deskripsi', '$kategori_id')";


// jalankan query
if (mysqli_query($conn, $query)) {
    echo "Data produk berhasil disimpan";
} else {
    echo "Gagal menyimpan data";
}
$query = "SELECT products.*, categories.categories_name
          FROM products
          JOIN categories ON products.categories_id = categories.id";

$data = mysqli_query($conn, $query);
echo "<h1>Form data receive</h1>";
echo "<p>nama: $nama_produk</p>";
echo "<p>kategori: $kategori_id</p>";
echo  "<p>harga: $harga</p>";
echo "<p>deskripsi: . nl2br($deskripsi).</p>";