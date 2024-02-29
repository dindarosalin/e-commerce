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

                        @hasanyrole('Super Admin|Admin')
                            <li class="nav-item list-unstyled">
                                <a class="nav-link" href="{{ route('roles.index') }}">roles</a>
                            </li>
                        @else
                            <li class="nav-item list-unstyled">
                                <a class="nav-link" href="">Menu 1</a>
                            </li>
                            <li class="nav-item list-unstyled">
                                <a class="nav-link" href="">Menu 2</a>
                            </li>
                        @endhasanyrole
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
