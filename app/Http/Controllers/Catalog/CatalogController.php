<?php

namespace App\Http\Controllers\Catalog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class CatalogController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('catalog.index', compact('products'));
    }
}
