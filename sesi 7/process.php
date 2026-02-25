<?php

include "../koneksi.php";

// ambil data dari form
$nama_produk = $_POST['nama_produk'];
$harga = $_POST['harga'];
$deskripsi = $_POST['deskripsi'];

// // validasi sederhana
// if (empty($nama) || empty($harga) || empty($deskripsi)) {
//     echo "Data tidak boleh kosong!";
//     exit;
// }


// query insert
$query = "INSERT INTO products (nama_produk, harga, deskripsi)
          VALUES ('$nama_produk', '$harga', '$deskripsi')";

// jalankan query
if (mysqli_query($conn, $query)) {
    echo "Data produk berhasil disimpan";
} else {
    echo "Gagal menyimpan data";
}
echo "<h1>Form data receive</h1>";
echo "<p>nama: $nama_produk</p>";
echo  "<p>harga: $harga</p>";
echo "<p>deskripsi: . nl2br($deskripsi).</p>";
