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
    echo "<script>
            alert('Data berhasil disimpan');
            window.location='products.php';
            </script>";
} else {
    echo "Gagal menyimpan data";
}
