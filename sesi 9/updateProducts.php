<?php

include "koneksi.php";

// ambil data dari form
$product_name = $_POST['product_name'];
$price = $_POST['price'];
$description = $_POST['description'];
$categories_id = $_POST['categories_id'];
$id = $_POST['id'] ?? null;
// query update
$query = "UPDATE products 
            SET product_name='$product_name', 
            price='$price',
            description='$description', 
            categories_id='$categories_id' 
            WHERE id='$id'";
// jalankan query
if (mysqli_query($conn, $query)) {
    echo "<script>
            alert('Data berhasil disimpan');
            window.location='products.php';
            </script>";
} else {
    echo "  <script>
            alert('Data gagal disimpan');
                </script>";
}
