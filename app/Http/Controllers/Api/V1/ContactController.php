<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Contact;

use App\Helpers\ApiHelper;
use Illuminate\Support\Str;
use DB;
use Validator;
use Illuminate\Pagination\Paginator;

class ContactController extends Controller
{

	public function ContactForm(Request $request)
	{

		// dd($request->all());
		$validator = Validator::make($request->all(), [

            'name' => 'required',
			'email' => 'required',
			'message' => 'required',

			// 'email' => 'required|email|unique:users',
			// 'password' => 'required|min:6',
			// 'c_password' => 'required|same:password',

		]);


		if ($validator->fails()) {
			$result = ApiHelper::validation_error('Validation Error', $validator->errors()->all());
			return response()->json($result, 422);
		}

		$PostData = new Contact();

		$PostData->name = $request->name;
		$PostData->email = $request->email;
		$PostData->message = $request->message;
	
		$PostData->save();


		$result = ApiHelper::success('Success', $PostData);
		return response()->json($result, 200);

	}

}
