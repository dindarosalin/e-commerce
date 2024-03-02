@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row justify-content-center">
            @if (session('success'))
                <p>{{ session('success') }}</p>
            @endif
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="nav-item list-unstyled d-flex justify-content-between">
                            <p class="nav-item list-unstyled">{{ __('Product Cart') }}</p>
                            <a class="nav-link" href="{{ route('catalog.index') }}">Katalog</a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                        @endif

                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Cover</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($cart as $key => $item)
                                <tr>
                                    <th scope="row">{{ ++$key }}</th>
                                    <td>
                                        <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="img-thumbnail" width="100">
                                    </td>
                                    <td>{{ $item['name'] }}</td>
                                    <td>{{ $item['quantity'] }}</td>
                                    <td>{{ $item['price'] }}</td>
                                    <td>
                                        <a href="" class="btn btn-primary m-1">Checkout</a>
                                        {{-- <a href="{{ route('remove-item', $item->id) }}" class="btn btn-danger m-1">Remove</a> --}}
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">No products found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
