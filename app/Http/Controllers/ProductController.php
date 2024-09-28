<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\ProductVariation;
use Validator;

use TCG\Voyager\Http\Controllers\VoyagerBaseController;



class ProductController extends VoyagerBaseController
{
    //



    public function store(Request $request)
    {
        
    //     // Validate product data
    // $productData = $request->validate([
    //     // Add your product validation rules here
    //     'name' => 'required|string',
    //     // 'description' => 'required|string',
    //     // other fields as necessary
    // ]);

    // // Create the product
    // $product = Product::create($productData);

    // // Handle variations
    // if ($request->has('variations')) {
    //     foreach ($request->variations as $variationData) {
    //         $validatedData = Validator::make($variationData, [
    //             'name' => 'required|string',
    //             'price' => 'required|numeric',
    //         ])->validate();

    //         ProductVariation::create([
    //             'product_id' => $product->id,
    //             'name' => $validatedData['name'],
    //             'price' => $validatedData['price']
    //         ]);
    //     }
    // }
    
    // dd($product);

    //     // Return response or redirect
    //     // ...
    }

   

}
