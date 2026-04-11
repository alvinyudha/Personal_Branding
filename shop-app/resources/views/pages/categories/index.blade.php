@extends('layouts.master')
@section('content')
    <div class="container mt-5 mb-5">
        <br>
        <div class="d-flex justify-content-between align-items-center mb-5">
            <h3>📂 Daftar Kategori</h3>
            <button class="btn btn-primary" data-toggle="modal" data-target="#createCategoryModal">
                <i class="fas fa-plus"></i> Tambah Kategori
            </button>
        </div>
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
        <div class="table-container">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th width="10%">No</th>
                            <th width="50%">Nama Kategori</th>
                            <th width="15%">Jumlah Produk</th>
                            <th width="25%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($categories as $key => $category)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>
                                    <strong>{{ $category->categories_name }}</strong>
                                </td>
                                <td>
                                    <span class="badge badge-info">
                                        {{ $category->products_count }} produk
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-warning" data-toggle="modal"
                                        data-target="#editCategoryModal{{ $category->id }}">
                                        Edit
                                    </button>
                                    @if ($category->products_count == 0)
                                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST"
                                            style="display:inline;"
                                            onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                Hapus
                                            </button>
                                        </form>
                                    @else
                                        <button class="btn btn-sm btn-danger" disabled title="Kategori memiliki produk">
                                            Hapus
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">
                                    <i class="fas fa-inbox"></i> Tidak ada kategori
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-4">
            <a href="{{ route('products.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali ke Produk
            </a>
        </div>
    </div>

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
                            <input type="text" class="form-control" id="create_category_name" name="categories_name"
                                required>
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

    <!-- Modal Edit Category (Per Item) -->
    @foreach ($categories as $category)
        <div class="modal fade" id="editCategoryModal{{ $category->id }}" tabindex="-1" role="dialog"
            aria-labelledby="editCategoryModalLabel{{ $category->id }}" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editCategoryModalLabel{{ $category->id }}">Edit Kategori</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="editCategoryForm{{ $category->id }}"
                            action="{{ route('categories.update', $category->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="edit_category_name{{ $category->id }}">Nama Kategori</label>
                                <input type="text" class="form-control" id="edit_category_name{{ $category->id }}"
                                    name="categories_name" value="{{ $category->categories_name }}" required>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" form="editCategoryForm{{ $category->id }}" class="btn btn-primary">Simpan
                            Perubahan</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
