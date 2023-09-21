<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\ApiHelper;
use Illuminate\Support\Str;
use App\Order;
use App\Customer;
use App\UserDetail;
use App\OrderDetail;
use App\OrderBilling;
use App\OrderShipping;
use App\PaymentMethod;
use App\OrderPayment;
use App\OrderStatus;
use App\ShippingService;
// use App\OrderShipping;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Validator;

class AuthController extends Controller
{
    //


    public function register(Request $request)
    {



        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            // 'c_password' => 'required|same:password',
        ]);


        if ($validator->fails()) {
            $result = ApiHelper::validation_error('Validation Error', $validator->errors()->all());
            return response()->json($result, 422);
        }

        $Emailtoken = Str::random(64);
        $user = Customer::create([
            'name' => $request->first_name . ' ' . $request->last_name,
            'email' => $request->email,
            'role_id' => '3',
            'password' => Hash::make($request->password),
            'verification_token' => $Emailtoken,

        ]);

        $userBasic = new  UserDetail();

        $userBasic->first_name = $request->first_name;
        $userBasic->last_name = $request->last_name;
        $userBasic->email = $request->email;
        $userBasic->phone = $request->phone;
        $userBasic->user_id = $user->id;
        $userBasic->save();


        $token = $user->createToken('authToken')->plainTextToken;

        $registeredUser['method'] = $request->signup_method;
        $registeredUser['user'] = $user;
        $registeredUser['access_token'] = $token;
        $registeredUser['user_basic'] = $userBasic;

        //   OtpVerification::where('phonenumber',$request->mobile_no)->delete();


        // $verificationUrl = URL::temporarySignedRoute(
        //     'verification.verify',
        //     now()->addMinutes(60),
        //     ['id' => $this->id]
        // );


        $details = [
            'first_name' =>  $request->first_name . ' ' . $request->last_name,
            'title' => 'Welcome - Confirm Your Email!!',
            'email' =>  $request->email,
            'link' =>  'https://indigofur.com/user-verification?token=' . $user->verification_token,
        ];


        \Mail::to($request->email)->send(new \App\Mail\RegisterAccount($details));

        $msg = 'User Created Successfully';

        $result = ApiHelper::success($msg, $registeredUser);
        return response()->json($result, 200);
    }


    public function login(Request $request)
    {

        // $loginData = Validator::make($request->all(), [
        //     'email' => ['required', 'email'],
        //     'password' => ['required']
        // ]);

        // if ($loginData->fails()) {
        //     $result = ApiHelper::validation_error('Validation Error', $loginData->errors());
        //     return response()->json($result, 422);
        // }


        // $user = Customer::where('email', $request->email)->first();

        // if (!$user || !Hash::check($request->password, $user->password)) {
        //     $result = ApiHelper::validation_error('Validation Error', ['Invalid Credentials']);
        //     // $result = ApiHelper::error('Invalid Credentials');
        //     return response()->json($result, 422);
        // }

        // $token = $user->createToken('authToken')->plainTextToken;

        // return response()->json(['token' => $token], 200);


        try {
            Auth::logout();
            $loginData = Validator::make($request->all(), [
                'email' => ['required', 'email'],
                'password' => ['required']
            ]);

            if ($loginData->fails()) {
                $result = ApiHelper::validation_error('Validation Error', $loginData->errors());
                return response()->json($result, 422);
            }


            $user = Customer::with('userDetails')->with('getRoleName')->where('email', $request->email)->first();

            $userData = $user->toArray();

            // if (!$user || !Hash::check($request->password, $user->password)) {
            //     $result = ApiHelper::validation_error('Validation Error', ['Invalid Credentials']);
            //     // $result = ApiHelper::error('Invalid Credentials');
            //     return response()->json($result, 422);
            // }
            
            unset($userData['role_id']);

            $userData['role'] = $userData['get_role_name']['name'];
            unset($userData['get_role_name']);
            
                     
            if (!auth()->attempt($request->only(['email', 'password'])) && !$user || !Hash::check($request->password, $user->password)) {
                $result = ApiHelper::validation_error('Validation Error', ['Invalid Credentials']);
                // $result = ApiHelper::error('Invalid Credentials');
                return response()->json($result, 422);
            }

            $accessToken = $user->createToken('authToken')->plainTextToken;

            $loginUser['user'] = $userData;

            $loginUser['access_token'] = $accessToken;

            $result = ApiHelper::success('Login Successfully', $loginUser);
            return response()->json($result, 200);
        } catch (Exception $e) {
            $result = ApiHelper::validation_error('Exception Error', $e);
            return response()->json($result, 400);
        }
    }

    /**
     * Log out the authenticated user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Get the authenticated user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserData(Request $request)
    {
        return 0;
    }


    public function getMyOrders()
    {

        $orders = Order::where('user_id', Auth::user()->id)->with('OrderPayments')->get();
        // return Auth::user()->id;

        $result = ApiHelper::success('User Orders', $orders);
        return response()->json($result, 200);
    }



    public function user(Request $request)
    {
        return response()->json(['user' => $request->user()], 200);
    }



    public function submitForgetPasswordForm(Request $request)
    {



        $loginData = Validator::make($request->all(), [
            'email' => ['required', 'email', 'exists:users']
        ]);

        if ($loginData->fails()) {
            $result = ApiHelper::validation_error('Validation Error', $loginData->errors());
            return response()->json($result, 422);
        }


        $emailExits =  DB::table('password_resets')->where('email', '=', $request->email)->exists();

        $TokenUpdate = '';
        // dd($emailExits);
        $token = Str::random(64);

        if ($emailExits) {

            $details = [
                'title' => 'Forget Password',
                'body' => 'You can reset password from bellow link:',
                'token' => $token
            ];


            \Mail::to($request->email)->send(new \App\Mail\ForgetPassword($details));
        } else {

            $TokenUpdate  = DB::table('password_resets')->insert([
                'email' => $request->email,
                'token' => $token,
            ]);

            $details = [
                'title' => 'Forget Password',
                'body' => 'You can reset password from bellow link:',
                'token' => $token
            ];


            \Mail::to($request->email)->send(new \App\Mail\ForgetPassword($details));
        }

        $result = ApiHelper::success('We have e-mailed your password reset link!', $TokenUpdate);
        return response()->json($result, 200);
    }
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function showResetPasswordForm($token)
    {
        return view('auth.forgetPasswordLink', ['token' => $token]);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function submitResetPasswordForm(Request $request)
    {
        // dd($request->all());



        $validationData = Validator::make($request->all(), [
            'email' => ['required', 'email', 'exists:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'password_confirmation' => ['required'],
        ]);

        if ($validationData->fails()) {
            $result = ApiHelper::validation_error('Validation Error', $validationData->errors());
            return response()->json($result, 422);
        }


        $updatePassword = DB::table('password_resets')
            ->where([
                'email' => $request->email,
                'token' => $request->token
            ])
            ->first();

        if (!$updatePassword) {
            $result = ApiHelper::error('Invalid token');
            return response()->json($result, 422);
        }

        $user = Customer::where('email', $request->email)
            ->update(['password' => Hash::make($request->password)]);

        DB::table('password_resets')->where(['email' => $request->email])->delete();

        if ($user) {

            $details = [
                'title' => 'Reset Password',
                'body' => 'Your password has been changed!',
            ];

            \Mail::to($request->email)->send(new \App\Mail\UpdatedPassword($details));

            $result = ApiHelper::success('Your password has been changed!', $user);
        } else {
            $result = ApiHelper::error('Update password failed');
        }


        return response()->json($result, 200);
    }


    public function changePassowrd(Request $request)
    {
        // dd($request->all());

        $currentPassword = $request->current_password;

        if (!Hash::check($currentPassword, Auth::user()->password)) {
            // Passwords do not match, return an error

            $result = ApiHelper::error('Current password is incorrect');
            return response()->json($result, 422);
        }


        $validationData = Validator::make($request->all(), [
            'current_password' => ['required'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'password_confirmation' => ['required'],
        ]);

        if ($validationData->fails()) {
            $result = ApiHelper::validation_error('Validation Error', $validationData->errors());
            return response()->json($result, 422);
        }

        $user = Customer::where('id', Auth::user()->id)
            ->update(['password' => Hash::make($request->password)]);

        $result = '';

        if ($user) {
            $result = ApiHelper::success('Password has been changed', $user);
        } else {

            $result = ApiHelper::success('Failed Change Password', $user);
        }


        return response()->json($result, 200);
    }

    public function updateProfile(Request $request)
    {
        // dd($request->all());

        $validationData = Validator::make($request->all(), [
            'first_name' => ['required'],
            'last_name' => ['required'],
            'phone' => ['required'],
            'country' => ['required'],
            'city' => ['required'],
            'address' => ['required'],
            'zip_code' => ['required'],
            'dob' => ['required'],
        ]);

        if ($validationData->fails()) {
            $result = ApiHelper::validation_error('Validation Error', $validationData->errors());
            return response()->json($result, 422);
        }


        $user = Customer::where('id', Auth::user()->id)
            ->update(
                [
                    'name' => $request->first_name . ' ' . $request->last_name
                ]
            );

        $UserDetail = UserDetail::where('user_id', Auth::user()->id)
            ->update(
                [
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'phone' => $request->phone,
                    'country' => $request->country,
                    'state' => $request->state,
                    'city' => $request->city,
                    'address' => $request->address,
                    'zip_code' => $request->zip_code,
                    'dob' => $request->dob,
                ]
            );

        $userData = Customer::where('id', Auth::user()->id)->with('userDetails')->get();


        $result = ApiHelper::success('User Data has been updated', $userData);

        return response()->json($result, 200);
    }

    public function updateShippingMethod(Request $request)
    {
        // dd($request->all());

        $validationData = Validator::make($request->all(), [
            'first_name' => ['required'],
            'last_name' => ['required'],
            'email' => ['required'],
            'phone' => ['required'],
            'country' => ['required'],
            'city' => ['required'],
            'address' => ['required'],
            'postal_code' => ['required'],
        ]);

        if ($validationData->fails()) {
            $result = ApiHelper::validation_error('Validation Error', $validationData->errors());
            return response()->json($result, 422);
        }

        $emailExits =  OrderShipping::where('user_id', '=', Auth::user()->id)->exists();

        // dd($emailExits);

        // $user = OrderShipping::where('id', Auth::user()->id)
        //     ->update(
        //         [
        //             'name' => $request->first_name . ' ' . $request->last_name
        //         ]
        //     );
        if ($emailExits) {

            $AddShippigData = OrderShipping::where('user_id', Auth::user()->id)
                ->update(
                    [
                        'first_name' => $request->first_name,
                        'last_name' => $request->last_name,
                        'email' => $request->email,
                        'phone' => $request->phone,
                        'country' => $request->country,
                        'state' => $request->state,
                        'city' => $request->city,
                        'address' => $request->address,
                        'postal_code' => $request->postal_code,
                        'company_name' => $request->company_name,
                    ]
                );

            //   $UpdateShippigData = OrderShipping::where('user_id', Auth::user()->id)->pluck('order_no')->first();

            $UpdateShippigData = OrderShipping::where('user_id', Auth::user()->id)
                ->select('*', 'order_no as order_no')
                ->get()
                ->map(function ($item) {
                    unset($item['order_no']);
                    return $item;
                });

            $result = ApiHelper::success('Shipping address has been updated', $UpdateShippigData);
            return response()->json($result, 200);
        } else {
            $AddShippigData = new OrderShipping();
            $AddShippigData->first_name = $request->first_name;
            $AddShippigData->last_name = $request->last_name;
            $AddShippigData->user_id = Auth::user()->id;
            $AddShippigData->email = $request->email;
            $AddShippigData->phone = $request->phone;
            $AddShippigData->country = $request->country;
            $AddShippigData->state = $request->state;
            $AddShippigData->city = $request->city;
            $AddShippigData->address = $request->address;
            $AddShippigData->postal_code = $request->postal_code;
            $AddShippigData->company_name = $request->company_name;
            $AddShippigData->save();

            $result = ApiHelper::success('Shipping address has been added', $AddShippigData);
            return response()->json($result, 200);
        }




        $result = '';

        return response()->json($result, 200);
    }

    public function getShippingMethod()
    {


        $UpdateShippigData = OrderShipping::where('user_id', Auth::user()->id)
            ->select('*', 'order_no as order_no')
            ->get()
            ->map(function ($item) {
                unset($item['order_no']);
                return $item;
            });

        $result = ApiHelper::success('Success', $UpdateShippigData);
        return response()->json($result, 200);
    }
}
