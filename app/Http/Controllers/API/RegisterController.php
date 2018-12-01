<?php
namespace App\Http\Controllers\API;


use Illuminate\Http\Request;

use App\Http\Controllers\API\BaseController as BaseController;

use App\User;

use Illuminate\Support\Facades\Auth;

use Validator;


class RegisterController extends BaseController

{

    /**

     * Register api

     *

     * @return \Illuminate\Http\Response

     */

    public function register(Request $request)

    {

        $validator = Validator::make($request->all(), [

            'name' => 'required',
            'email' => 'required|email|unique:users',

            'password' => 'required',

            'confirmpassword' => 'required|same:password',

        ]);


        if($validator->fails()){

            return $this->sendError('Validation Error.', $validator->errors());       

        }


        $input = $request->all();

        $input['password'] = bcrypt($input['password']);

        $user = User::create($input);

        $success['token'] =  $user->createToken('MyApp')->accessToken;

        $success['name'] =  $user->name;


        return $this->sendResponse($success, 'User register successfully.');

    }
    public function login(Request $request)

    {

        $validator = Validator::make($request->all(), [

            'name' => 'required',

            'password' => 'required',

        ]);


        if($validator->fails()){

            return $this->sendError('Validation Error.', $validator->errors());       

        }


        $input = $request->all();

        $input['password'] = ($input['password']);

        $user = Auth::attempt(['name' => $input['name'], 'password' => $input['password']]);

        $success['token'] =  Auth::user()->createToken('MyApp')->accessToken;

        $success['name'] =  Auth::user()->name;


        return json_encode(['access_token'=>Auth::user()->createToken('MyApp')->accessToken]);

    }
}