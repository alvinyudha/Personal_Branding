<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Form Produk</title>

  <?php
  include "koneksi.php";

  $kategori = mysqli_query($conn, "SELECT * FROM categories");
  ?>
  <!-- Bootstrap 5 CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <!-- <script>
    function validasiForm() {
      let nama = document.forms["formProduk"]["nama_produk"].value;
      let harga = document.forms["formProduk"]["harga"].value;
      let deskripsi = document.forms["formProduk"]["deskripsi"].value;

      if (nama == "" || harga == "" || deskripsi == "") {
        alert("Semua field harus diisi!");
        return false;
      }

      return true;
    }
  </script> -->
</head>

<body>
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card shadow">
          <div class="card-header text-center bg-primary text-white">
            <h4>Tambah Produk</h4>
          </div>

          <div class="card-body">
            <form action="process.php" method="POST">
              <div class="mb-3">
                <label class="form-label">Nama Produk</label>
                <input type="text" name="product_name" class="form-control"
                  placeholder="Masukkan nama produk" />
              </div>
              <div class="mb-3">
                <label class="form-label">Kategori Produk</label>
                <select name="categories_id" class="form-select">
                  <option value="" disabled selected>-- Pilih Kategori Produk --</option>

                  <?php while ($k = mysqli_fetch_assoc($kategori)) { ?>

                    <option value="<?= $k['id'] ?>">
                      <?= $k['categories_name'] ?>
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

              <button type="submit" class="btn btn-primary w-100">
                Simpan Produk
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>