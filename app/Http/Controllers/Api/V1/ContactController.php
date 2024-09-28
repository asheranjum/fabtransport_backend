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
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

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
	
	
public function checkNewSubmissions(Request $request)
{
    // Retrieve the last check time from the session, or default to a time far in the past
    $lastCheck = $request->session()->get('last_check', Carbon::now()->subYear());

    // Retrieve only the new submissions since the last check
    $newSubmissions = Contact::where('created_at', '>', $lastCheck)
                             ->orderBy('created_at', 'desc')
                             ->get();

   

    // If you only want the latest record, you can do:
    $latestSubmission = $newSubmissions->first();


 // Update the last check time in the session
    $request->session()->put('last_check', Carbon::now());
    
    // Prepare the data to be returned
    $data = [
        'new' => $newSubmissions,         // All new submissions
        'latest' => $latestSubmission,    // Only the latest submission
        'lastCheck' => $lastCheck         // The time of the last check
    ];
    
    
      Log::debug('Last check: ' . $lastCheck);
    Log::debug('New submissions count: ' . $newSubmissions->count());
    Log::debug('Latest submission: ', ['submission' => $latestSubmission]);

    return response()->json($newSubmissions->count());
}





}
