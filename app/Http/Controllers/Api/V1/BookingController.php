<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\FlatPackAssembly;

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
		$PostData->pin_code = $request->pin_code;
		$PostData->address = $request->address;
		$PostData->bname = $request->bname;
		$PostData->bemail = $request->bemail;
		$PostData->baddress = $request->baddress;
		$PostData->save();


		$result = ApiHelper::success('Success', $PostData);
		return response()->json($result, 200);

	}
}
