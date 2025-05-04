<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public  function productList(Request $request){
        return View('product.product-list', ['data' => Product::all()]);
    }
    public function createStore(Request $request)
    {
        $request->validate([
            'name' => ['required', 'max:255'],
            'description' => ['required', 'max:255'],
            'price' => ['required'],
        ]);
        $product = new Product();
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->price = $request->input('price');

        $product->save();

        return redirect()->route('home');
    }

    public function update($id){
        $product = new Product;
        return View('product.update', ['data' => $product->find($id)]);
    }

    public function updateStore($id, Request $request){

        $product = Product::find($id);

        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->price = $request->input('price');

        $product->save();

        return redirect()->route('products');
    }
}
