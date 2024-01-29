<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function sendResponse($response)
    {
        return response()->json($response, 200);
    }

    public function sendError($error, $code = 404)
    {
        $response = [
            'error' => $error,
        ];
        return response()->json($response, $code);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'phone' => 'required|unique:users,phone',
            'password' => 'required',
            'confirm_password' => 'required|same:password'
        ]);

        if($validator->fails()){
            return $this->sendError($validator->errors());
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);

        $user = new User();
        $user->name=$input['name'];
        $user->phone=$input['phone'];
        $user->password=$input['password'];
        $user->save();
        if($user){
            $success['token'] =  $user->createToken('token')->accessToken;
            $success['message'] = "Registration successful..";
            $success['user']=$user;
            return $this->sendResponse($success['message']);
        }
        else{
            $error = "Sorry! Registration is not successful.";
            return $this->sendError($error, 401);
        }
    }
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required',
            'password' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError($validator->errors());
        }
        if (User::where('phone', request()->phone)->first()!==''){
            $user = User::where('phone', request()->phone)->first();
            if (!Hash::check(request()->password, $user->password)) {
                $error = "Incorrect password.";
                return $this->sendError($error, 401);
            }
            $success['token'] =  $user->createToken('token')->accessToken;
            $success['user']=$user;
            return $this->sendResponse($success);
        }else{
            return response()->json(array('error' => 'Phone Number Not Found'));
        }
    }


}
