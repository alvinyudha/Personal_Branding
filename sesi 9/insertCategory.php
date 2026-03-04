<?php

include "koneksi.php";

$categories_name = $_POST['categories_name'];

// query insert
$query = mysqli_query($conn, "INSERT INTO categories (categories_name) 
          VALUES ('$categories_name')");
// jalankan query
if ($query) {
    echo "<script>
            alert('Data berhasil disimpan');
            window.location='products.php';
            </script>";
} else {
    echo "Gagal menyimpan data";
}
