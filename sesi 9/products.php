<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Form Produk</title>
    <!-- Bootstrap 5 CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
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
    $kategori = mysqli_query($conn, "SELECT * FROM categories");
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
</head>

<body>
    <div class="container mt-5">

        <h3 class="text-lg-center mb-5">Data Produk</h3>

        <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#storeProductmodal">
            Tambah Produk
        </a>
        <a href="" class="btn btn-warning mb-3 text-white" data-toggle="modal" data-target="#storeCategorymodal">
            Tambah Kategori
        </a>
        <!-- Filter & Search -->
        <form method="get" class="row mb-4" id="filterForm">
            <div class="col-md-4 mb-2">
                <input type="text" id="searchInput" name="search" value="<?= htmlspecialchars($search) ?>"
                    class="form-control" placeholder="Cari produk..." onchange="this.form.submit()" />
            </div>

            <div class="col-md-4 mb-2">
                <select id="categoryFilter" name="category" class="form-control" onchange="this.form.submit()">
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
                <select id="priceSort" name="priceSort" class="form-control" onchange="this.form.submit()">
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
                <th>Action</th>
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
                        <a href="" class="btn btn-warning btn-sm" data-toggle="modal"
                            data-target="#updateModal<?= $d['id'] ?>">
                            Edit
                        </a>
                        <a href="products.php?hapus=<?= $d['id'] ?>" class="btn btn-danger btn-sm"
                            onclick="return confirm('Yakin ingin menghapus produk ini?')">
                            Hapus
                        </a>
                    </td>
                </tr>

                <!-- Modal update Products-->
                <div class="modal fade" id="updateModal<?= $d['id'] ?>" tabindex="-1"
                    aria-labelledby="updateModal<?= $d['id'] ?>Label" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Update Produk</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="updateProducts.php" method="POST" id="formUpdate<?= $d['id'] ?>">
                                    <input type="hidden" name="id" value="<?= $d['id'] ?>">
                                    <div class="mb-3">
                                        <label for="product_name<?= $d['id'] ?>" class="form-label">Nama Produk</label>
                                        <input type="text" class="form-control" id="product_name<?= $d['id'] ?>"
                                            name="product_name" value="<?= htmlspecialchars($d['product_name']) ?>"
                                            required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="price<?= $d['id'] ?>" class="form-label">Harga</label>
                                        <input type="number" class="form-control" id="price<?= $d['id'] ?>" name="price"
                                            value="<?= htmlspecialchars($d['price']) ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="description<?= $d['id'] ?>" class="form-label">Deskripsi</label>
                                        <textarea class="form-control" id="description<?= $d['id'] ?>" name="description"
                                            required><?= htmlspecialchars($d['description']) ?></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="categories_id<?= $d['id'] ?>" class="form-label">Kategori</label>
                                        <select class="form-control" id="categories_id<?= $d['id'] ?>" name="categories_id"
                                            required>
                                            <?php mysqli_data_seek($categoryOptions, 0); ?>
                                            <?php while ($c = mysqli_fetch_assoc($categoryOptions)): ?>
                                                <option value="<?= $c['id'] ?>"
                                                    <?= $c['id'] == $d['categories_id'] ? 'selected' : '' ?>>
                                                    <?= $c['categories_name'] ?>
                                                </option>
                                            <?php endwhile; ?>
                                        </select>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Store Products -->
                <div class="modal fade" id="storeProductmodal" tabindex="-1" role="dialog"
                    aria-labelledby="storeProductmodalTitle" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="storeProductmodalTitle">Tambah Produk Baru</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="insertProducts.php" method="POST">
                                    <div class="mb-3">
                                        <label class="form-label">Nama Produk</label>
                                        <input type="text" name="product_name" class="form-control"
                                            placeholder="Masukkan nama produk" />
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Kategori Produk</label>
                                        <select name="categories_id" class="form-control">
                                            <option value="" disabled selected>-- Pilih Kategori Produk --</option>
                                            <?php while ($c = mysqli_fetch_assoc($kategori)) { ?>
                                                <option value="<?= $c['id'] ?>">
                                                    <?= $c['categories_name'] ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Harga</label>
                                        <input type="number" name="price" class="form-control"
                                            placeholder="Masukkan harga produk" />
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Deskripsi</label>
                                        <textarea name="description" class="form-control" rows="3"
                                            placeholder="Masukkan deskripsi produk"></textarea>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Kembali</button>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Store Categories -->
                <div class="modal fade" id="storeCategorymodal" tabindex="-1" role="dialog"
                    aria-labelledby="storeCategorymodalTitle" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="storeCategorymodalTitle">Tambah Kategori Baru</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="insertCategory.php" method="POST">
                                    <div class="mb-3">
                                        <label class="form-label">Nama Kategori</label>
                                        <input type="text" name="categories_name" class="form-control"
                                            placeholder="Masukkan nama kategori" />
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Kembali</button>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            <?php } ?>

        </table>



    </div>
    <!-- include Bootstrap JS (bundle includes Popper) -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
</body>