<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Requests\SetComponentRequest;
use App\Models\Product;
use App\Models\Raw;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function showProduct($id) {
        if(Product::find($id) == null) {
            session()->flash('warning', 'Запрашиваемый Вами ресурс не существует!');
            return redirect()->route('index');
        }

        return view('product', ['product' => Product::find($id)]);
    }
    public function editProduct($id) {
        if(Product::find($id) == null) {
            session()->flash('warning', 'Запрашиваемый Вами ресурс не существует!');
            return redirect()->route('index');
        }

        return view('edit_product', ['product' => Product::find($id), 'raws'=>Raw::all()]);
    }

    public function updateProduct(UpdateProductRequest $request) {
        $product = Product::find($request->id);

        if(!is_null($request->file('image'))) {
            Storage::disk('public')->delete($product->picture);
            $path = $request->file('image')->store('/product_images', 'public');
            $product->picture = $path;
        }

        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->update();

        return redirect('/');
    }

    public function createProduct() {
        return view('product_add', ['raws' => Raw::all()]);
    }

    public function uploadProduct(ProductRequest $request) {

        $path = $request->file('image')->store('/product_images', 'public');

        $product = new Product();

        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->picture = $path;
        $product->price = $request->input('price');
        $product->save();

        return redirect('/new_product');
    }

    public function setComponent($productId, $rawId, SetComponentRequest $request) {
       $weight = $request->input('weight');
       $product = Product::find($productId);

       if($weight == 0) {
        if ($product->raws->contains($rawId)) {
            $product->raws()->detach($rawId);
        }
       }
       else {
        if($product->raws->contains($rawId)) {
            $pivotRow = $product->raws()->where('raw_id', $rawId)->first()->pivot;
            $pivotRow->weight_g = $weight;
            $pivotRow->update();
        }
        else {
            $product->raws()->attach($rawId);
            $pivotRow = $product->raws()->where('raw_id', $rawId)->first()->pivot;
            $pivotRow->weight_g = $weight;
            $pivotRow->update();
        }
       }

       return redirect()->route('product.edit', ['id' => $productId]);
    }
}
