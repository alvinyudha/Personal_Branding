@extends('layouts.master')
@section('content')
    <div class="container mt-5">
        <br>
        <div class="row ">
            <div class="col-12 mb-4">
                <h1 class="text-center">Welcome to Our Store</h1>
                <p class="text-center text-muted">Find the best products at unbeatable prices!</p>
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
                                @forelse ($categories ?? [] as $cat)
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
            </div>

            @forelse ($products as $product)
                <div class="col-md-4 mb-4 d-flex justify-content-center ">
                    <div class="card" style="width: 18rem;">
                        @if ($product->image)
                            <img class="card-img-top" src="{{ asset('storage/' . $product->image) }}"
                                alt="{{ $product->product_name }}" style="height: 200px; object-fit: cover;">
                        @else
                            <img class="card-img-top" src="{{ asset('storage/images/defaultIMG.png') }}"
                                alt="{{ $product->product_name }}" style="height: 200px; object-fit: cover;">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->product_name }}</h5>
                            <p class="card-text">{{ Str::limit($product->description, 100) }}</p>
                            <p class="card-text"><strong>Harga :</strong> Rp
                                {{ number_format($product->price, 0, ',', '.') }}</p>
                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-primary">View Details</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <p class="text-center">No products available.</p>
                </div>
            @endforelse
        </div>
        <div class="d-flex justify-content-center mt-5">
            {{ $products->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endsection
