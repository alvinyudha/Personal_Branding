@extends('layouts.master')
@section('content')
    <div class="container mt-5">
        <br>
        <div class="row 4">
            <div class="col-12 mb-4">
                <h1 class="text-center">Welcome to Our Store</h1>
                <p class="text-center text-muted">Find the best products at unbeatable prices!</p>
            </div>
            @forelse ($products as $product)
                <div class="col-md-4 mb-4 d-flex justify-content-center ">
                    <div class="card" style="width: 18rem;">
                        <img class="card-img-top" src="{{ asset('storage/' . $product->image) }}"
                            alt="{{ $product->product_name }}" style="height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->product_name }}</h5>
                            <p class="card-text">{{ Str::limit($product->description, 100) }}</p>
                            <p class="card-text"><strong>Price:</strong> Rp
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
