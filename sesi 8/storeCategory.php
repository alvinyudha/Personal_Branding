<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Form Kategori</title>

    <?php
    include "koneksi.php";

    $kategori = mysqli_query($conn, "SELECT * FROM categories");


    if (isset($_POST['simpan'])) {
        // ambil data dari form
        $categories_name = $_POST['categories_name'];
        // query insert
        $query = "INSERT INTO categories (categories_name)
          VALUES ('$categories_name')";
        // jalankan query
        if (mysqli_query($conn, $query)) {
            echo "<script>
            alert('Data berhasil disimpan');
            window.location='products.php';
            </script>";
        } else {
            echo "Gagal menyimpan data";
        }
    }

    ?>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />

</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header text-center bg-primary text-white">
                        <h4>Tambah Kategori</h4>
                    </div>

                    <div class="card-body">
                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label">Nama Kategori</label>
                                <input type="text" name="categories_name" class="form-control"
                                    placeholder="Masukkan nama kategori" required />
                            </div>

                            <button type="submit" name="simpan" class="btn btn-primary">
                                Simpan Kategori
                            </button>
                            <a href="products.php" class="btn btn-secondary">
                                Kembali
                            </a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>