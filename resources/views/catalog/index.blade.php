@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">{{ __('Product Catalog') }}</div>
                    <div class="card-body">
                        <div class="row">
                            @forelse ($products as $product)
                                <div class="col-md-4 mb-4">
                                    <div class="card">
                                        <img src="{{ $product->cover_url }}" class="card-img-top" alt="{{ $product->name }}">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $product->name }}</h5>
                                            <p class="card-text">{{ $product->description }}</p>
                                            <p class="card-text"><strong>Price: ${{ $product->price }}</strong></p>
                                            <a href="{{ route('catalog.show', $product->id) }}" class="btn btn-primary">View Details</a>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-md-12">
                                    <p>No products available</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
