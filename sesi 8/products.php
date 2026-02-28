<?php
include "koneksi.php";

// --- filter / search parameters from query string ---
$search    = mysqli_real_escape_string($conn, $_GET['search'] ?? '');
$category  = mysqli_real_escape_string($conn, $_GET['category'] ?? '');
$priceSort = mysqli_real_escape_string($conn, $_GET['priceSort'] ?? '');

// build base query joining categories
$query = "SELECT products.*, categories.categories_name
          FROM products
          JOIN categories ON products.categories_id = categories.id";

$conditions = [];
if ($search !== '') {
    $conditions[] = "products.product_name LIKE '%$search%'";
}
if ($category !== '') {
    $conditions[] = "products.categories_id = '$category'";
}
if (count($conditions) > 0) {
    $query .= ' WHERE ' . implode(' AND ', $conditions);
}

if ($priceSort === 'low') {
    $query .= ' ORDER BY products.price ASC';
} elseif ($priceSort === 'high') {
    $query .= ' ORDER BY products.price DESC';
}

$data = mysqli_query($conn, $query);

// load categories for dropdown
$categoryOptions = mysqli_query($conn, "SELECT * FROM categories");

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

?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-5">

    <h3>Data Produk</h3>

    <a href="storeProducts.php" class="btn btn-primary mb-3">
        Tambah Produk
    </a>
    <a href="storeCategory.php" class="btn btn-warning mb-3 text-white">
        Tambah Kategori
    </a>
    <!-- Filter & Search -->
    <form method="get" class="row mb-4" id="filterForm">
        <div class="col-md-4 mb-2">
            <input type="text" id="searchInput" name="search" value="<?= htmlspecialchars($search) ?>"
                class="form-control" placeholder="Cari produk..." onchange="this.form.submit()" />
        </div>

        <div class="col-md-4 mb-2">
            <select id="categoryFilter" name="category" class="form-select" onchange="this.form.submit()">
                <option value="">Semua Kategori</option>
                <?php mysqli_data_seek($categoryOptions, 0); ?>
                <?php while ($c = mysqli_fetch_assoc($categoryOptions)): ?>
                    <option value="<?= $c['id'] ?>" <?= $c['id'] == $category ? 'selected' : '' ?>>
                        <?= $c['categories_name'] ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="col-md-4 mb-2">
            <select id="priceSort" name="priceSort" class="form-select" onchange="this.form.submit()">
                <option value="">Urutkan Harga</option>
                <option value="low" <?= $priceSort === 'low' ? 'selected' : '' ?>>Harga Terendah</option>
                <option value="high" <?= $priceSort === 'high' ? 'selected' : '' ?>>Harga Tertinggi</option>
            </select>
        </div>

    </form>

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
        while ($d = mysqli_fetch_assoc($data)) {
        ?>

            <tr>
                <td><?= $no++ ?></td>
                <td><?= $d['product_name'] ?></td>
                <td><?= $d['categories_name'] ?></td>
                <td><?= $d['price'] ?></td>
                <td><?= $d['description'] ?></td>

                <td>
                    <a href="edit.php?id=<?= $d['id'] ?>" class="btn btn-warning btn-sm">
                        Edit
                    </a>
                    <a href="products.php?hapus=<?= $d['id'] ?>" class="btn btn-danger btn-sm"
                        onclick="return confirm('Yakin ingin menghapus produk ini?')">
                        Hapus
                    </a>

                </td>

            </tr>

        <?php } ?>

    </table>

</div>