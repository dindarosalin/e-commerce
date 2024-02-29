<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function index()
    {
        try {
            $products = auth()->user()->products;
            return view('product.index', compact('products'));
        } catch (\Throwable $th) {
            return back()->with('status', $th->getMessage());
        }
    }

    public function create()
    {
        try {
            return view('product.form',[
                'title' => 'Add new Product',
                'action' => route('products.store'),
                'method' => 'POST',
                'product' => new Product(),
                'button' => 'Create',
                'medias' => []
            ]);
        } catch (\Throwable $th) {
            return back()->with('status', $th->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {

            $user = auth()->user();

           $product = Product::create([
                'user_id' => $user->id,
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
            ]);

            $old_photos = $product->getMedia('products');

            if($request->photos_old){
                if(count($request->get('photos_old')) != count($old_photos)){
                    foreach ($old_photos as $value) {
                        if(array_search($value->id,$request->get('photos_old')) === false){
                            $product->deleteMedia($value->id);
                        }
                    }
                }
            }
            // New photos
            if($request->photos_new) {
                foreach ($request->input('photos_new', []) as $file) {
                    $path = storage_path('tmp/uploads/'.$file);

                    if (!file_exists($path)) {
                        continue;
                    }

                    $product->addMedia($path)
                    ->toMediaCollection('products');
                    
                    File::delete($path);
                }
            }

            return to_route('products.index')->with('status', 'Product created successfully!');
        } catch (\Throwable $th) {
            return back()->with('status', $th->getMessage());
        }
    }

    public function edit(Request $request, $id)
    {
        try {
            $product = Product::findOrFail($id);
            $medias  = $product->getMedia('products');

            return view('product.form',[
                'title' => 'Edit Product',
                'action' => route('products.update',$id),
                'method' => 'PUT',
                'product' => $product,
                'button' => 'Update',
                'medias' => $medias
            ]);
        } catch (\Throwable $th) {
            return back()->with('status', $th->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $product = Product::findOrFail($id);

            $product->update([
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
            ]);

            $old_photos = $product->getMedia('products');

            if($request->photos_old){
                if(count($request->get('photos_old')) != count($old_photos)){
                    foreach ($old_photos as $value) {
                        if(array_search($value->id,$request->get('photos_old')) === false){
                            $product->deleteMedia($value->id);
                        }
                    }
                }
            }
            // New photos
            if($request->photos_new) {
                foreach ($request->input('photos_new', []) as $file) {
                    $path = storage_path('tmp/uploads/'.$file);

                    if (!file_exists($path)) {
                        continue;
                    }

                    $product->addMedia($path)
                    ->toMediaCollection('products');
                    File::delete($path);
                }
            }

            return to_route('products.index')->with('status', 'Product updated successfully!');
        } catch (\Throwable $th) {
            return back()->with('status', $th->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);
            
            $product->clearMediaCollection('products');
            
            $product->delete();

            return Redirect::route('products.index')->with('status', 'Product deleted successfully!');
        } catch (\Throwable $th) {
            return back()->with('status', $th->getMessage());
        }
    }
}
