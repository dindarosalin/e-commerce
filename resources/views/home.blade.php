@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        {{-- @hasanyrole('Super Admin|Admin')
                            <li class="nav-item list-unstyled">
                                <a class="nav-link" href="{{ route('roles.index') }}">Roles</a>
                            </li>
                        @endhasanyrole --}}

                        @hasanyrole('Seller')
                            <li class="nav-item list-unstyled">
                                <a class="nav-link" href="{{ route('products.index') }}">Menu Seller</a>
                            </li>
                        @else
                            <li class="nav-item list-unstyled">
                                <a class="nav-link" href="{{ route('catalog.index') }}">Katalog Produk</a>
                            </li>
                        @endhasanyrole
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
