<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Data Produk</title>
    <!-- Bootstrap 5 CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .table-container {
            background-color: white;
            border-radius: 5px;
            padding: 20px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .btn-action {
            margin: 2px;
        }
    </style>
</head>

<body>
    <div class="container mt-5 mb-5">
        <!-- Alert Messages -->
        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Berhasil!</strong> {{ $message }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if ($message = Session::get('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> {{ $message }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <h3 class="text-center mb-5">📦 Data Produk</h3>

        <!-- Add Buttons -->
        <div class="mb-4">
            <button class="btn btn-primary btn-action" data-toggle="modal" data-target="#createProductModal">
                <i class="fas fa-plus"></i> Tambah Produk
            </button>
            <button class="btn btn-warning btn-action text-white" data-toggle="modal"
                data-target="#createCategoryModal">
                <i class="fas fa-plus"></i> Tambah Kategori
            </button>
            <a href="{{ route('categories.index') }}" class="btn btn-success">
                Kelola Kategori
            </a>
        </div>

        <div class="table-container">
            <!-- Filter & Search Form -->
            <form method="GET" class="mb-4" id="filterForm">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <input type="text" name="search" class="form-control" placeholder="Cari nama produk..."
                            value="{{ request('search') }}" onchange="document.getElementById('filterForm').submit()">
                    </div>

                    <div class="col-md-4 mb-3">
                        <select name="category" class="form-control"
                            onchange="document.getElementById('filterForm').submit()">
                            <option value="">-- Semua Kategori --</option>
                            @forelse ($allCategories ?? [] as $cat)
                                <option value="{{ $cat->id }}"
                                    {{ request('category') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->categories_name }}
                                </option>
                            @empty
                            @endforelse
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <select name="sort_price" class="form-control"
                            onchange="document.getElementById('filterForm').submit()">
                            <option value="">-- Urutkan Harga --</option>
                            <option value="asc" {{ request('sort_price') == 'asc' ? 'selected' : '' }}>
                                Harga: Termurah
                            </option>
                            <option value="desc" {{ request('sort_price') == 'desc' ? 'selected' : '' }}>
                                Harga: Termahal
                            </option>
                        </select>
                    </div>
                </div>
            </form>

            <!-- Products Table -->
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th width="5%">No</th>
                            <th width="20%">Nama Produk</th>
                            <th width="15%">Kategori</th>
                            <th width="12%">Harga</th>
                            <th width="10%">Stok</th>
                            <th width="25%">Deskripsi</th>
                            <th width="13%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $key => $product)
                            <tr>
                                <td>{{ $key + 1 + ($products->currentPage() - 1) * $products->perPage() }}</td>
                                <td><strong>{{ $product->product_name }}</strong></td>
                                <td>
                                    <span class="badge badge-info">
                                        {{ $product->category->categories_name ?? 'N/A' }}
                                    </span>
                                </td>
                                <td>
                                    <strong>Rp {{ number_format($product->price, 0, ',', '.') }}</strong>
                                </td>
                                <td>
                                    <span class="badge {{ $product->stok > 0 ? 'badge-success' : 'badge-danger' }}">
                                        {{ $product->stok }} pcs
                                    </span>
                                </td>
                                <td>
                                    <small>{{ strlen($product->description ?? '') > 30 ? substr($product->description, 0, 30) . '...' : $product->description ?? '-' }}</small>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-warning btn-action" data-toggle="modal"
                                        data-target="#editModal{{ $product->id }}">
                                        Edit
                                    </button>
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                                        style="display:inline;"
                                        onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger btn-action">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    <i class="fas fa-inbox"></i> Tidak ada produk yang ditemukan
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="d-flex justify-content-center">

                    {{ $products->links('pagination::bootstrap-5') }}

                </div>
            </div>
        </div>
    </div>

    <!-- Modal Create Product -->
    <div class="modal fade" id="createProductModal" tabindex="-1" role="dialog"
        aria-labelledby="createProductModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createProductModalLabel">Tambah Produk Baru</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="createProductForm" action="{{ route('products.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="create_product_name">Nama Produk</label>
                            <input type="text" class="form-control" id="create_product_name" name="product_name"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="create_category_id">Kategori</label>
                            <select class="form-control" id="create_category_id" name="category_id" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach ($allCategories ?? [] as $category)
                                    <option value="{{ $category->id }}">{{ $category->categories_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="create_price">Harga (Rp)</label>
                            <input type="number" class="form-control" id="create_price" name="price"
                                min="0" required>
                        </div>
                        <div class="form-group">
                            <label for="create_stok">Stok</label>
                            <input type="number" class="form-control" id="create_stok" name="stok"
                                min="0" required>
                        </div>
                        <div class="form-group">
                            <label for="create_description">Deskripsi</label>
                            <textarea class="form-control" id="create_description" name="description" rows="3"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" form="createProductForm" class="btn btn-primary">Simpan Produk</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Product (Per Item) -->
    @foreach ($products as $product)
        <div class="modal fade" id="editModal{{ $product->id }}" tabindex="-1" role="dialog"
            aria-labelledby="editModalLabel{{ $product->id }}" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel{{ $product->id }}">Edit Produk</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="editProductForm{{ $product->id }}"
                            action="{{ route('products.update', $product->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="edit_product_name{{ $product->id }}">Nama Produk</label>
                                <input type="text" class="form-control" id="edit_product_name{{ $product->id }}"
                                    name="product_name" value="{{ $product->product_name }}" required>
                            </div>
                            <div class="form-group">
                                <label for="edit_category_id{{ $product->id }}">Kategori</label>
                                <select class="form-control" id="edit_category_id{{ $product->id }}"
                                    name="category_id" required>
                                    @foreach ($allCategories ?? [] as $category)
                                        <option value="{{ $category->id }}"
                                            {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                            {{ $category->categories_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="edit_price{{ $product->id }}">Harga (Rp)</label>
                                <input type="number" class="form-control" id="edit_price{{ $product->id }}"
                                    name="price" value="{{ $product->price }}" min="0" required>
                            </div>
                            <div class="form-group">
                                <label for="edit_stok{{ $product->id }}">Stok</label>
                                <input type="number" class="form-control" id="edit_stok{{ $product->id }}"
                                    name="stok" value="{{ $product->stok }}" min="0" required>
                            </div>
                            <div class="form-group">
                                <label for="edit_description{{ $product->id }}">Deskripsi</label>
                                <textarea class="form-control" id="edit_description{{ $product->id }}" name="description" rows="3">{{ $product->description }}</textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" form="editProductForm{{ $product->id }}"
                            class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Modal Create Category -->
    <div class="modal fade" id="createCategoryModal" tabindex="-1" role="dialog"
        aria-labelledby="createCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createCategoryModalLabel">Tambah Kategori Baru</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="createCategoryForm" action="{{ route('categories.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="create_category_name">Nama Kategori</label>
                            <input type="text" class="form-control" id="create_category_name"
                                name="categories_name" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" form="createCategoryForm" class="btn btn-primary">Simpan Kategori</button>
                </div>
            </div>
        </div>
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
