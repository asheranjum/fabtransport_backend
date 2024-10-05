<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\GetQuote;

use App\Helpers\ApiHelper;
use Illuminate\Support\Str;
use DB;
use Mail;
use Validator;
use Illuminate\Pagination\Paginator;
use App\Mail\GetQuoteMail;
use PDF;
class QuoteController extends Controller
{

	public function GetQuoteForm(Request $request)
	{

		// dd($request->all());
		$validator = Validator::make($request->all(), [

            'name' => 'required',
			'email' => 'required',
			'service' => 'required',
			'subject' => 'required',
			'quote' => 'required',
			
			// 'email' => 'required|email|unique:users',
			// 'password' => 'required|min:6',
			// 'c_password' => 'required|same:password',

		]);


		if ($validator->fails()) {
			$result = ApiHelper::validation_error('Validation Error', $validator->errors()->all());
			return response()->json($result, 422);
		}

		$postData = new GetQuote();

		$postData->name = $request->name;
		$postData->email = $request->email;
		$postData->service = $request->service;
		$postData->subject = $request->subject;
		$postData->quote = $request->quote;
	
		$postData->save();


		// Generate PDFs
		$pdf = Pdf::loadView('email.getQuoteMail', compact('postData')); // create a Blade view `emails.quote` for the PDF content

		// Send email with the PDF attachment
		\Mail::to($request->email)->send(new \App\Mail\GetQuoteMail($postData, $pdf));

		$result = ApiHelper::success('Success', []);
		return response()->json($result, 200);

	}

}
