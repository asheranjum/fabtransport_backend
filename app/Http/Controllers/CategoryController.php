<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\ApiHelper;
use DB;
use App\Product;
use App\Models\ProductCategory;
use App\ProductSubCategory;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
class CategoryController extends Controller
{
    //

    public function getCategories()
    {
        $role_id = Auth::user()->role_id;
        // $cats = ProductCategory::with('getSubCategory')->where('status','PUBLISHED')->where('role_id',$role_id)->where('parent_id',null)->orderBy('created_at', 'DESC')->get();
        $cats = ProductCategory::with('getSubCategory')->where('status','PUBLISHED')->where('role_id',$role_id)->orderBy('created_at', 'DESC')->get();
        
        $result = ApiHelper::success('All Categories Loaded', $cats);
		return response()->json($result, 200);

    }



        public function getCategoryProduct($slug, Request $request)
        {
            $role_id = Auth::user()->role_id;
                // Assuming you pass a 'search' parameter for the search functionality
            $search = $request->input('search', '');
        
                // $isParent = ProductCategory::where('status', 'PUBLISHED')->get();
                // dd($isParent);                           
                $category = ProductCategory::where('status', 'PUBLISHED')
                                           ->where('slug', $slug)
                                           ->where('role_id', $role_id)
                                           ->first();
                
                if ($category) {
                    // Apply search and pagination on the products of this category
                    $products = $category->category_products()
                                         ->where('name', 'LIKE', "%$search%") // Assuming 'product_name' is the field you want to search
                                         ->with('variations') // Eager load the variations
                                         ->orderBy('created_at', 'DESC')
                                         ->paginate(10); // 10 products per page

                    $result = ApiHelper::success('All Bedding Products', $products);
                    return response()->json($result, 200);
                } else {
                    $result = ApiHelper::success('Category Not Found', []);
                    return response()->json($result, 200);
                }
        
        }


    public function getSubCategoryProduct($slug, Request $request)
	{
            $role_id = Auth::user()->role_id;
                // Assuming you pass a 'search' parameter for the search functionality
            $search = $request->input('search', '');
            $parent_slug = $request->input('parent_slug', '');
            
                                       
            $parent_id = ProductCategory::where('status', 'PUBLISHED')->where('slug',$parent_slug)->first('parent_id');
            // dd($parent_id);
            $category = ProductCategory::where('status', 'PUBLISHED')->where('parent_id',$parent_id->parent_id)->first();
                                     
                
                if ($category) {
                    // Apply search and pagination on the products of this category
                    $products = $category->category_products()
                                         ->where('name', 'LIKE', "%$search%") // Assuming 'product_name' is the field you want to search
                                         ->with('variations') // Eager load the variations
                                         ->orderBy('created_at', 'DESC')
                                         ->paginate(10); // 10 products per page

                    $result = ApiHelper::success('All Bedding Products', $products);
                    return response()->json($result, 200);
                } else {
                    $result = ApiHelper::success('Category Not Found', []);
                    return response()->json($result, 200);
                }
	}
	

    
    public function getProductsWithCategories()
	{
		
		$products = ProductCategory::published()->with('category_products')->get();

		$result = ApiHelper::success('product-details', $products);
		return response()->json($result, 200);
	}
	
	    public function slider()
	{
		
		$slider = DB::table('sliders')->where('status','PUBLISHED')->get();

		$result = ApiHelper::success('product-details', $slider);
		return response()->json($result, 200);
	}
	
	

}
