<?php
include "koneksi.php";

$query = "SELECT products.*, categories.categories_name
          FROM products
          JOIN categories ON products.categories_id = categories.id";

$data = mysqli_query($conn, $query);
/* fungsi hapus */
if (isset($_GET['hapus'])) {

    $id = $_GET['hapus'];

    $query = "DELETE FROM products WHERE id='$id'";

    if (mysqli_query($conn, $query)) {
        echo "<script>
                alert('Data berhasil dihapus');
                window.location='products.php';
              </script>";
    } else {
        echo "Data gagal dihapus";
    }
}

$result = mysqli_query($conn, "SELECT * FROM products");
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-5">

    <h3>Data Produk</h3>

    <a href="storeProducts.php" class="btn btn-primary mb-3">
        Tambah Produk
    </a>
    <!-- Filter & Search -->
    <div class="row mb-4">
        <div class="col-md-4 mb-2">
            <input type="text" id="searchInput" class="form-control" placeholder="Cari produk..." />
        </div>

        <div class="col-md-4 mb-2">
            <select id="categoryFilter" class="form-select">
                <option value="">Semua Kategori</option>
            </select>
        </div>

        <div class="col-md-4 mb-2">
            <select id="priceSort" class="form-select">
                <option value="">Urutkan Harga</option>
                <option value="low">Harga Terendah</option>
                <option value="high">Harga Tertinggi</option>
            </select>
        </div>
    </div>
    <table class="table table-bordered">

        <tr>
            <th>No</th>
            <th>Nama Produk</th>
            <th>Kategori</th>
            <th>Harga</th>
            <th>Deskripsi</th>
            <th>Aksi</th>
        </tr>

        <?php
        $no = 1;
        while ($row = mysqli_fetch_assoc($data)) {
        ?>

            <tr>
                <td><?= $no++ ?></td>
                <td><?= $row['product_name'] ?></td>
                <td><?= $row['categories_name'] ?></td>
                <td><?= $row['price'] ?></td>
                <td><?= $row['description'] ?></td>

                <td>
                    <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">
                        Edit
                    </a>
                    <a href="products.php?hapus=<?= $row['id'] ?>" class="btn btn-danger btn-sm"
                        onclick="return confirm('Yakin ingin menghapus produk ini?')">
                        Hapus
                    </a>

                </td>

            </tr>

        <?php } ?>

    </table>

</div>