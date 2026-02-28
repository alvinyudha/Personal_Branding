<?php

include "koneksi.php";

// ambil data dari form
$product_name = $_POST['product_name'];
$price = $_POST['price'];
$description = $_POST['description'];
$categories_id = $_POST['categories_id'];

// query insert
$query = "INSERT INTO products (product_name, price, description, categories_id)
          VALUES ('$product_name', '$price', '$description', '$categories_id')";


// jalankan query
if (mysqli_query($conn, $query)) {
    echo "Data produk berhasil disimpan";
} else {
    echo "Gagal menyimpan data";
}
// $query = "SELECT products.*, categories.categories_name
//           FROM products
//           JOIN categories ON products.categories_id = categories.id";

// $data = mysqli_query($conn, $query);
// echo "<h1>Form data receive</h1>";
// echo "<p>nama: $nama_produk</p>";
// echo "<p>kategori: $kategori_id</p>";
// echo  "<p>harga: $harga</p>";
// echo "<p>deskripsi: . nl2br($deskripsi).</p>";