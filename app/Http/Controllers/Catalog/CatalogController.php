<?php

namespace App\Http\Controllers\Catalog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Checkout;
use Yajra\DataTables\Facades\DataTables;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
    try {
        if ($request->ajax()) {
        $query = Product::with('user')->select('products.*');

        return DataTables::eloquent($query)
            ->addColumn('cover_url', function ($item) {
            return $item->cover_url;
            })
            ->addColumn('action', function ($item) {
            return '<div class="d-flex justify-content-end">
                        <a href="' . route('add-to-cart', $item->id) . '" class="btn btn-sm btn-warning me-2">🛒</a>
                        <a href="" class="btn btn-sm btn-success me-2">📤</a>
                        <a href="" class="btn btn-sm btn-primary me-2">👁‍🗨</a>
                    </div>';
            })
            ->rawColumns(['cover_url', 'action'])
            ->make(true);
        }

        return view('catalog.index');

    } catch (\Throwable $th) {
        return back()->with('error', $th->getMessage());
    }
    }



    // public function index()
    // {
    //     $products = Product::all();
    //     return view('catalog.index', compact('products'));
    // }

    public function show()
    {
        $cart = session()->get('cart', []);
        return view('catalog.cart', compact('cart'));
    }

    public function addToCart($id)
    {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);

        if(isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "id" => $product->id,
                "cover_url" => $product->cover_url,
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->price,
                "image" => $product->image
            ];
        }
        
        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }

    public function update(Request $request)
    {
        if($request->id && $request->quantity){
            $cart = session()->get('cart');
            $cart[$request->id]["quantity"] = $request->quantity;
            session()->put('cart', $cart);
            session()->flash('success', 'Cart updated successfully');
        }
    }

    public function remove(Request $request)
    {
        if($request->id) {
            $cart = session()->get('cart');
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            session()->flash('success', 'Product removed successfully');
        }
    }

    public function processCheckout(Request $request)
    {
        $request-validate([
            'user_id' => 'required',
            'product_id' => 'required',
            'pickup_id' => 'required',
            'drop_id' => 'required',
            'quantity' => 'required',
        ]);

        $user = auth()->user();

        $checkoutData = [
            'user_id' => $user->id,
            'product_id' => $request->product_id,
            'pickup_id' => $request->pickup_id,
            'drop_id' => $request->drop_id,
            'quantity' => $request->quantity,
        ];
    }
}
