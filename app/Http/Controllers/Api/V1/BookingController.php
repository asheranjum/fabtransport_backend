<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\FlatPackAssembly;
use App\Delivery;
use App\HouseMoving;
use App\HandymanServices;
use App\FabConstruction;
use App\ServiceCall;

use PDF;
use App\Helpers\ApiHelper;
use Illuminate\Support\Str;
use DB;
use Validator;
use Illuminate\Pagination\Paginator;

class BookingController extends Controller
{


// .......For FLat Pack Assembly ..........//

	public function FlatPackAssemblyForm(Request $request)
	{

		// return($request->all());
		$validator = Validator::make($request->all(), [

			'items_need' => 'required',
			'need_assembling' => 'required',
			'additional_services' => 'required',
			'furniture_assembled' => 'required',
			'address' => 'required',
			'name' => 'required',
			'email' => 'required',
			'phone' => 'required',
			'city' => 'required',
			'postal_code' => 'required',

			'different_name' => 'required',
			'different_email' => 'required',
			'different_address' => 'required',

		]);


		if ($validator->fails()) {
			$result = ApiHelper::validation_error('Validation Error', $validator->errors()->all());
			return response()->json($result, 422);
		}

		$PostData = new FlatPackAssembly();

		$PostData->items_need = $request->items_need;
		$PostData->need_assembling = $request->need_assembling;
		$PostData->additional_services = $request->additional_services;
		$PostData->furniture_assembled = $request->furniture_assembled;
		$PostData->address = $request->address;
		$PostData->name = $request->name;
		$PostData->email = $request->email;
		$PostData->phone = $request->phone;
		$PostData->city = $request->city;
		$PostData->postal_code = $request->postal_code;

		$PostData->different_name = $request->different_name;
		$PostData->different_email = $request->different_email;
		$PostData->different_address = $request->different_address;
		
		$PostData->save();

		// Generate PDFs
		$pdf = Pdf::loadView('email.flatpackassemblyformMail', compact('PostData')); // create a Blade view `emails.quote` for the PDF content

		// Send email with the PDF attachment
		\Mail::to(env('ADMIN_EMAIL'))->send(new \App\Mail\FormsAttachmentsMail($PostData, $pdf,'Flat Pack Assembly Form','email.flatpackassemblyformMail'));


		$result = ApiHelper::success('Success', $PostData);
		return response()->json($result, 200);

	}

	//.........For Delivery ...............//

	public function DeliveryForm(Request $request)
	{

		$validator = Validator::make($request->all(), [

			'pick_up_location' => 'required',
			'delivery_location' => 'required',
			'delivery_to' => 'required',
			'the_delivery_requires' => 'required',
			'pick_up_name' => 'required',
			'pick_up_email' => 'required',
			'pick_up_phone' => 'required',
			'pick_up_city' => 'required',
			'pick_up_postal_code' => 'required',
			'pick_up_address' => 'required',
			'delivery_name' => 'required',
			'delivery_email' => 'required',
			'delivery_phone' => 'required',
			'delivery_city' => 'required',
			'delivery_postal_code' => 'required',
			'delivery_address' => 'required',
			'date' => 'required',

			'different_name' => 'required',
			'different_email' => 'required',
			'different_address' => 'required',
			
		]);


		if ($validator->fails()) {
			$result = ApiHelper::validation_error('Validation Error', $validator->errors()->all());
			return response()->json($result, 422);
		}

		$PostData = new Delivery();

		$PostData->pick_up_location = $request->pick_up_location;
		$PostData->delivery_location = $request->delivery_location;
		$PostData->delivery_to = $request->delivery_to;
		$PostData->the_delivery_requires = $request->the_delivery_requires;
		$PostData->pick_up_name = $request->pick_up_name;
		$PostData->pick_up_email = $request->pick_up_email;
		$PostData->pick_up_phone = $request->pick_up_phone;
		$PostData->pick_up_city = $request->pick_up_city;
		$PostData->pick_up_postal_code = $request->pick_up_postal_code;
		$PostData->pick_up_address = $request->pick_up_address;
		$PostData->delivery_name = $request->delivery_name;
		$PostData->delivery_email = $request->delivery_email;
		$PostData->delivery_phone = $request->delivery_phone;
		$PostData->delivery_city = $request->delivery_city;
		$PostData->delivery_postal_code = $request->delivery_postal_code;
		$PostData->delivery_address = $request->delivery_address;
		$PostData->date = $request->date;

		$PostData->different_name = $request->different_name;
		$PostData->different_email = $request->different_email;
		$PostData->different_address = $request->different_address;

		$PostData->save();

		// Generate PDFs
		$pdf = Pdf::loadView('email.deliveryformMail', compact('PostData')); // create a Blade view `emails.quote` for the PDF content

		// Send email with the PDF attachment
		\Mail::to(env('ADMIN_EMAIL'))->send(new \App\Mail\FormsAttachmentsMail($PostData, $pdf,'Delivery Form','email.deliveryformMail'));


				
		$result = ApiHelper::success('Success', $PostData);
		return response()->json($result, 200);

	}

   //.........For House Moving...............//

	public function HouseMovingForm(Request $request)
	{

		$validator = Validator::make($request->all(), [
			
			'moving_from_location' => 'required',
			'moving_to_location' => 'required',
			'moving_from' => 'required',
			'moving_to' => 'required',
			'bedrooms' => 'required',
			'other_rooms' => 'required',
			'date' => 'required',
			'name' => 'required',
			'email' => 'required',
			'phone' => 'required',
			'city' => 'required',
			'address' => 'required',
			'postal_code' => 'required',
			
			'different_name' => 'required',
			'different_email' => 'required',
			'different_address' => 'required',
			
		]);


		if ($validator->fails()) {
			$result = ApiHelper::validation_error('Validation Error', $validator->errors()->all());
			return response()->json($result, 422);
		}

		$PostData = new HouseMoving();

		$PostData->moving_from_location = $request->moving_from_location;
		$PostData->moving_to_location = $request->moving_to_location;
		$PostData->moving_from = $request->moving_from;
		$PostData->moving_to = $request->moving_to;
		$PostData->bedrooms = $request->bedrooms;
		$PostData->other_rooms = $request->other_rooms;
		$PostData->specialty_item = $request->specialty_item;
		$PostData->date = $request->date;
		$PostData->name = $request->name;
		$PostData->email = $request->email;
		$PostData->phone = $request->phone;
		$PostData->city = $request->city;
		$PostData->postal_code = $request->postal_code;
		$PostData->address = $request->address;

		$PostData->different_name = $request->different_name;
		$PostData->different_email = $request->different_email;
		$PostData->different_address = $request->different_address;
		
		$PostData->save();
		
		// Generate PDFs
		$pdf = Pdf::loadView('email.housemovingformMail', compact('PostData')); // create a Blade view `emails.quote` for the PDF content

		// Send email with the PDF attachment
		\Mail::to(env('ADMIN_EMAIL'))->send(new \App\Mail\FormsAttachmentsMail($PostData, $pdf,'House Moving','email.housemovingformMail'));

		$result = ApiHelper::success('Success', $PostData);
		return response()->json($result, 200);

	}


   //.........For HandyMan Service...............//
 
   public function HandymanServicesForm(Request $request)
   {

	   // return($request->all());
	   $validator = Validator::make($request->all(), [

		'name'=> 'required',
		'email'=> 'required',
		'phone'=> 'required',
		'quote'=> 'required',
		'image'=> 'required',

	   ]);

	   if ($validator->fails()) {
		   $result = ApiHelper::validation_error('Validation Error', $validator->errors()->all());
		   return response()->json($result, 422);
	   }

	   $PostData = new HandymanServices();
	   
	   $PostData->name = $request->name;
	   $PostData->email = $request->email;
	   $PostData->phone = $request->phone;
	   $PostData->quote = $request->quote;
	   $PostData->image = $request->image;

	   $PostData->save();

	   // Generate PDFs
	   $pdf = Pdf::loadView('email.HandymanServicesformMail', compact('PostData')); // create a Blade view `emails.quote` for the PDF content

	   // Send email with the PDF attachment
	   \Mail::to(env('ADMIN_EMAIL'))->send(new \App\Mail\FormsAttachmentsMail($PostData, $pdf,'Handyman Services Form','email.handymanservicesformMail'));


	   $result = ApiHelper::success('Success', $PostData);
	   return response()->json($result, 200);

   }

    //.........Fab Construction...............//

   public function FabConstructionForm(Request $request)
   {

	   // return($request->all());
	   $validator = Validator::make($request->all(), [

		'services'=> 'required',
		'name'=> 'required',
		'email'=> 'required',
		'phone'=> 'required',
		'quote'=> 'required',
		'location'=> 'required',

	   ]);

	   if ($validator->fails()) {
		   $result = ApiHelper::validation_error('Validation Error', $validator->errors()->all());
		   return response()->json($result, 422);
	   }

	   $PostData = new FabConstruction();
	   
	   $PostData->services = $request->services;
	   $PostData->name = $request->name;
	   $PostData->email = $request->email;
	   $PostData->phone = $request->phone;
	   $PostData->quote = $request->quote;
	   $PostData->location = $request->location;

	   $PostData->save();

	   // Generate PDFs
	   $pdf = Pdf::loadView('email.FabConstructionformMail', compact('PostData')); // create a Blade view `emails.quote` for the PDF content

	   // Send email with the PDF attachment
	   \Mail::to(env('ADMIN_EMAIL'))->send(new \App\Mail\FormsAttachmentsMail($PostData, $pdf,'Fab Construction Form','email.fabconstructionformMail'));


	   $result = ApiHelper::success('Success', $PostData);
	   return response()->json($result, 200);

   }

    //.........For Service Call...............//

   public function ServiceCallForm(Request $request)
   {

	   // return($request->all());
	   $validator = Validator::make($request->all(), [

		'name'=> 'required',
		'location'=> 'required',
		'issue'=> 'required',
		'image'=> 'required',
		'image1'=> 'required',
		'image2'=> 'required',
		'image3'=> 'required',
		'image4'=> 'required',
		'pdf'=> 'required',

	   ]);

	   if ($validator->fails()) {
		   $result = ApiHelper::validation_error('Validation Error', $validator->errors()->all());
		   return response()->json($result, 422);
	   }

	   $PostData = new ServiceCall();
	   
	   $PostData->name = $request->name;
	   $PostData->location = $request->location;
	   $PostData->issue = $request->issue;
	   $PostData->image = $request->image;
	   $PostData->image1 = $request->image1;
	   $PostData->image2 = $request->image2;
	   $PostData->image3 = $request->image3;
	   $PostData->image4 = $request->image4;
	   $PostData->pdf = $request->pdf;

	   $PostData->save();

	   // Generate PDFs
	   $pdf = Pdf::loadView('email.ServiceCallFormformMail', compact('PostData')); // create a Blade view `emails.quote` for the PDF content

	   // Send email with the PDF attachment
	   \Mail::to(env('ADMIN_EMAIL'))->send(new \App\Mail\FormsAttachmentsMail($PostData, $pdf,'Service CallForm Form','email.servicecallFormformMail'));

	   $result = ApiHelper::success('Success', $PostData);
	   return response()->json($result, 200);

    } 

   }