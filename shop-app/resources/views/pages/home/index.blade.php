@extends('layouts.master')
@section('content')
    <div class="container mt-5">
        <br>
        <h1>Selamat Datang di Toko Online Kami!</h1>
        <p>Temukan berbagai produk menarik dengan harga terbaik hanya di sini.</p>
        <a href="{{ route('products.index') }}" class="btn btn-primary">Lihat Produk</a>

        <div class="row" id="product-list" style="margin-top: 30px;">
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <img class="card-img-top" />
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title product-name"></h5>
                        <p class="product-category text-muted small"></p>
                        <p class="card-text product-description"></p>
                        <h6 class="mt-auto text-primary fw-bold product-price"></h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
