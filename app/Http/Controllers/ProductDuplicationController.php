<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class ProductDuplicationController extends Controller
{
    //



    public function duplicate(Request $request, Product $product)
    {
        $newProduct = $product->replicate();
        $newProduct->name = 'Copy of ' . $product->name; // Modify any attributes as needed
        $newProduct->images = null;
        // $newProduct->created_at = \Carbon\Carbon::now()->toDateTimeString();
        // $newProduct->updated_at = \Carbon\Carbon::now()->toDateTimeString();
        $newProduct->save();

        // You may also need to duplicate any related data, such as images or tags, depending on your application's structure.

        return redirect()->route('voyager.products.index')->with('success', 'Product duplicated successfully.');
    }

}
