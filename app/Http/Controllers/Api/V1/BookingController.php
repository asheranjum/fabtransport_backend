<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\FlatPackAssembly;
use App\Delivery;
use App\HouseMoving;

use App\Helpers\ApiHelper;
use Illuminate\Support\Str;
use DB;
use Validator;
use Illuminate\Pagination\Paginator;

class BookingController extends Controller
{

	public function FlatPackAssemblyForm(Request $request)
	{

		// dd($request->all());
		$validator = Validator::make($request->all(), [
			'items_need' => 'required',
			'need_assembling' => 'required',
			'additional_services' => 'required',
			'furniture_assembled' => 'required',
			'name' => 'required',
			'email' => 'required',
			'city' => 'required',
			'postal' => 'required',
			'address' => 'required',
			'bname' => 'required',
			'bemail' => 'required',
			'baddress' => 'required',

			// 'email' => 'required|email|unique:users',
			// 'password' => 'required|min:6',
			// 'c_password' => 'required|same:password',

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
		$PostData->name = $request->name;
		$PostData->email = $request->email;
		$PostData->city = $request->city;
		$PostData->postal = $request->postal;
		$PostData->address = $request->address;
		$PostData->bname = $request->bname;
		$PostData->bemail = $request->bemail;
		$PostData->baddress = $request->baddress;
		$PostData->save();


		$result = ApiHelper::success('Success', $PostData);
		return response()->json($result, 200);

	}

	public function DeliveryForm(Request $request)
	{

		$validator = Validator::make($request->all(), [

			'items_need' => 'required',
			'delivery_location' => 'required',
			'deliveries_off_goods' => 'required',
			'the_delivery_requires' => 'required',
			'pick_up_name' => 'required',
			'pick_up_name' => 'required',
			'pick_up_email' => 'required',
			'pick_up_phone' => 'required',
			'pick_up_city' => 'required',
			'pick_up_postal' => 'required',
			'pick_up__address' => 'required',
			'delivery_name' => 'required',
			'delivery_email' => 'required',
			'delivery_phone' => 'required',
			'delivery_city' => 'required',
			'delivery_postal' => 'required',
			'delivery_address' => 'required',
			'date' => 'required',
			'bname' => 'required',
			'bemail' => 'required',
			'baddress' => 'required',
			
		]);


		if ($validator->fails()) {
			$result = ApiHelper::validation_error('Validation Error', $validator->errors()->all());
			return response()->json($result, 422);
		}

		$PostData = new Delivery();

		$PostData->pick_up_location = $request->pick_up_location;
		$PostData->delivery_location = $request->delivery_location;
		$PostData->deliveries_off_goods = $request->deliveries_off_goods;
		$PostData->the_delivery_requires = $request->the_delivery_requires;
		$PostData->pick_up_name = $request->pick_up_name;
		$PostData->pick_up_email = $request->pick_up_email;
		$PostData->pick_up_phone = $request->pick_up_phone;
		$PostData->pick_up_city = $request->pick_up_city;
		$PostData->pick_up_postal = $request->pick_up_postal;
		$PostData->pick_up__address = $request->pick_up__address;
		$PostData->delivery_name = $request->delivery_name;
		$PostData->delivery_email = $request->delivery_email;
		$PostData->delivery_phone = $request->delivery_phone;
		$PostData->delivery_city = $request->delivery_city;
		$PostData->delivery_postal = $request->delivery_postal;
		$PostData->delivery_address = $request->delivery_address;
		$PostData->date = $request->date;
		$PostData->bname = $request->bname;
		$PostData->bemail = $request->bemail;
		$PostData->baddress = $request->baddress;
		$PostData->save();


		$result = ApiHelper::success('Success', $PostData);
		return response()->json($result, 200);

	}

	public function HouseMovingForm(Request $request)
	{

		$validator = Validator::make($request->all(), [
			
			'moving_from_location' => 'required',
			'moving_to_location' => 'required',
			'moving_from' => 'required',
			'moving_to' => 'required',
			'bedrooms' => 'required',
			'other_rooms' => 'required',
			'special_item' => 'required',
			'date' => 'required',
			'name' => 'required',
			'email' => 'required',
			'phone' => 'required',
			'city' => 'required',
			'postal' => 'required',
			'address' => 'required',
			'bname' => 'required',
			'bemail' => 'required',
			'baddress' => 'required',
			
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
		$PostData->special_item	 = $request->special_item	;
		$PostData->date = $request->date;
		$PostData->name = $request->name;
		$PostData->email = $request->email;
		$PostData->phone = $request->phone	;
		$PostData->city = $request->city;
		$PostData->postal = $request->postal;
		$PostData->bname = $request->bname;
		$PostData->bemail = $request->bemail;
		$PostData->baddress = $request->baddress;
		
		$PostData->save();


		$result = ApiHelper::success('Success', $PostData);
		return response()->json($result, 200);

	}
}
