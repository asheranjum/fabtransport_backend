<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::group(['prefix' => 'v1', 'as' => 'api.v1.', 'namespace' => '\App\\Http\\Controllers\\Api\\V1\\'], function () {

    Route::post('deliveries', ['uses' => 'BookingController@DeliveryForm', 'as' => 'DeliveryForm']);
    Route::post('flat-pack-assembly', ['uses' => 'BookingController@FlatPackAssemblyForm', 'as' => 'FlatPackAssemblyForm']);
    Route::post('house-moving', ['uses' => 'BookingController@HouseMovingForm', 'as' => 'HouseMovingForm']);
    Route::post('handyman-services', ['uses' => 'BookingController@HandymanServicesForm', 'as' => 'HandymanServicesForm']);
    Route::post('fab-construction', ['uses' => 'BookingController@FabConstructionForm', 'as' => 'FabConstructionForm']);
    Route::post('service-call', ['uses' => 'BookingController@ServiceCallForm', 'as' => 'ServiceCallForm']);
    Route::post('contact-us', ['uses' => 'ContactController@ContactForm', 'as' => 'ContactForm']);
    Route::post('get-quote', ['uses' => 'QuoteController@GetQuoteForm', 'as' => 'GetQuoteForm']);

    Route::get('new-submissions', 'ContactController@checkNewSubmissions');
    // Route::post('/dependent-dropdown', ['uses' => 'DependentDropdownController@index', 'as' => 'dropdown']);
    // Route::get('all-products', ['uses' => 'ProductsController@index', 'as' => 'allProducts']);
    // Route::get('tags-products', ['uses' => 'ProductsController@TagsProducts', 'as' => 'TagsProducts']);
    Route::get('product-reviews', ['uses' => 'ProductsController@HomeReviews', 'as' => 'HomeReviews']);
    // Route::get('single-product/{slug}', ['uses' => 'ProductsController@getProductDetail', 'as' => 'getProductDetail']);
    // Route::get('get-sub-category-products/{slug}', ['uses' => '\App\Http\Controllers\CategoryController@getSubCategoryProduct', 'as' => 'getSubCategoryProduct']);
    // Route::get('product-categories', ['uses' => '\App\Http\Controllers\CategoryController@getCategories', 'as' => 'getCategories']);
    // Route::get('get-category-products/{slug}', ['uses' => '\App\Http\Controllers\CategoryController@getCategoryProduct', 'as' => 'getCategoryProduct']);
    Route::get('all-category-products', ['uses' => '\App\Http\Controllers\CategoryController@getProductsWithCategories', 'as' => 'getProductsWithCategories']);
    Route::post('shipping_cost', ['uses' => 'OrderController@getShippingRates', 'as' => 'getShippingRates']);
    // Route::post('get-shipping-rates', ['uses' => 'OrderController@getShippingRates', 'as' => 'getShippingRates']);


    // Route::get('get-payment-methods', ['uses' => 'OrderController@getPaymentMethod', 'as' => 'getPaymentMethod']);
    // Route::get('get-shipping-methods', ['uses' => 'OrderController@getShippingMethod', 'as' => 'getShippingMethod']);
    // Route::post('make-order', ['uses' => 'OrderController@getOrder', 'as' => 'getOrder']);
    // Route::post('stripe-payment', ['uses' => 'OrderController@StripPayment', 'as' => 'StripPayment']);
    // Route::post('make-payment', ['uses' => 'OrderController@MakePayment', 'as' => 'MakePayment']);
    // // Route::post('/product-categories', ['uses' => 'DependentDropdownController@index', 'as' => 'productCategory']);
    // Route::get('getOrderDetails/{ordercode}', ['uses' => 'OrderController@getOrderDetails', 'as' => 'getOrderDetails']);
    // Route::get('get-order-status', ['uses' => 'OrderController@getOrderStatus', 'as' => 'getOrderStatus']);
    // Route::post('/register', [RegistrationController::class, 'store']);
    // Route::post('update-order', ['uses' => 'OrderController@updateORder', 'as' => 'updateORder']);
    // Route::get('get-product-attributes/{category_id}', ['uses' => 'ProductsController@getProductAttributes', 'as' => 'getProductAttributes']);

    // Route::post('search-products', ['uses' => 'ProductsController@searchByCategory', 'as' => 'searchByCategory']);

    // Route::get('slider', ['uses' => '\App\Http\Controllers\CategoryController@slider', 'as' => 'getCategories']);


  Route::post('product-booking', ['uses' => 'BookingController@ProductBooking', 'as' => 'ProductBooking']);
  Route::post('product-mistake', ['uses' => 'BookingController@ProductMistake', 'as' => 'ProductMistake']);
  Route::post('missing-product', ['uses' => 'BookingController@MissingProduct', 'as' => 'MissingProduct']);

  Route::get('/booked-dates/{product_id}', ['uses' => 'BookingController@getBookedDates', 'as' => 'getBookedDates']);

    Route::get('get-my-orders/', ['uses' => 'AuthController@getMyOrders', 'as' => 'getMyOrders']);

    Route::post('register', ['uses' => 'AuthController@register', 'as' => 'register']);
    Route::post('login', 'AuthController@login');
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@getUserData');
        Route::get('get-furniture-prodcuts', ['uses' => 'ProductsController@getFurnitureItems', 'as' => 'getFurnitureItems']);
        Route::get('get-bedding-prodcuts', ['uses' => 'ProductsController@getBeddingItems', 'as' => 'getBeddingItems']);
        
        Route::get('get-category-products/{slug}', ['uses' => '\App\Http\Controllers\CategoryController@getCategoryProduct', 'as' => 'getCategoryProduct']);
        Route::get('product-categories', ['uses' => '\App\Http\Controllers\CategoryController@getCategories', 'as' => 'getCategories']);
        Route::get('get-sub-category-products/{slug}', ['uses' => '\App\Http\Controllers\CategoryController@getSubCategoryProduct', 'as' => 'getSubCategoryProduct']);
        Route::post('update-profile', 'AuthController@updateProfile');
        Route::post('update-shipping-method', 'AuthController@updateShippingMethod');
        Route::get('get-shipping-method', 'AuthController@getShippingMethod');
        Route::get('get-my-orders/', ['uses' => 'AuthController@getMyOrders', 'as' => 'getMyOrders']);
        Route::post('change-passowrd/', ['uses' => 'AuthController@changePassowrd', 'as' => 'changePassowrd']);


      
        
    });
});
 
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::post('register', 'API\AuthController@register');
// Route::post('login', 'API\AuthController@login');
// Route::middleware('auth:sanctum')->group(function () {
//     Route::post('logout', 'API\AuthController@logout');
//     Route::get('user', 'API\AuthController@user');
// });

use Illuminate\Database\Eloquent\Factories\Factory;

Route::get('add-dummy', function () {

    $faker = \Faker\Factory::create('en_US');

    // return  $faker->company;

    for ($i = 0; $i < 20; $i++) {
        DB::table('products')->insert([
           
        'name' => $faker->company,
        'short_desc' => '</p>'.$faker->sentence.'</p>',
        'long_desc' => '<p style="text-align: center;">Designed with accomplishment in mind, this coffee table is definitely an ideal selection for all modern sofas. Its upgraded features, such as the highest quality tempered glass, make this a must-have. If you want to make a statement, this is your coffee table. most suitable for modern-day living.</p>',
        'regular_price' => $faker->randomNumber(3),
        'images' => '[
            "products/June2023/sofa%202.jpg"
        ]',
        'sale_price' => $faker->randomNumber(3),
        'SKU' => $faker->randomNumber(4),
        'status' => 'PUBLISHED',
        'category_id' => 7,
        'sub_category_id' => 7,
        'stock_status' => 'inStock',
        
        ]);

    }

    return 0;
});
// Route::get('send-mail', function () {
   
//     $details = [
//         'first_name' => 'Khan',
//         'title' => 'Thank You For Your Order!',
//         'body' => 'Thanks for your order. It’s on-hold until we confirm that payment has been received. In the meantime, here’s a reminder of what you ordered:',
//         'order_id' => '000',
//         'created_date' => '10/07/2023',
//         'itemsCount' =>  '2',
//         'products' =>  '333',
//         'status' =>  '43',
//         'total' =>  '333',
//         'delivery_name' =>  'Test Name',
//         'delivery_company' =>  'asher_designs',
//         'delivery_address_1' =>  'Sec 9 Block D',
//         'delivery_address_2' =>  'Karachi Victoria 75760',
//         'delivery_contact_no' =>  '03082826308',
//         'delivery_email' =>  'asheranjum50@gmail.com',
//         'expected_delivery' =>  '10/07/2023',
//     ];
   
//     \Mail::to('asheranjum50@gmail.com')->send(new \App\Mail\OrderConfirmMail($details));
   
//     dd("Email is Sent.");
// });