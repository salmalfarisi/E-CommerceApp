<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use Illuminate\Support\Facades\Auth as Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Hash;
use Session;

class UserController extends BaseController
{
	/*
		Registration Account Process
	*/
    public function register(Request $request)
	{
		$validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required',
            'repeat_password' => 'required|same:password',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
		
		$checkdata = DB::table('users')
						->where('name', 'like', "%".$request->name."%")
						->where('email', 'like', "%".$request->email."%")
						->count();
						
		if($checkdata == 0)
		{
			$password = Hash::make($request->password);
			$now = Carbon::now();
			DB::table('users')->insert([
				'name' => $request->name,
				'email' => $request->email,
				'password' => $password,
				'created_at' => $now,
			]);
			
			return $this->sendResponse(true, [], 'Account has been created');
		}
		else
		{
			return $this->sendError('Account has been created in database. Try Again', []);
		}
	}
	
	public function login(Request $request)
	{	
		$validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
		
		$array = ['email' => $request->email, 'password' => $request->password];
		
		if (Auth::attempt($array)) 
		{
			if(Auth::user()->is_active == false)
			{
				Auth::logout();
				return $this->sendError('Email or Password not found in database', []);
			}
			$now = Carbon::now()->addDays(1);
			$user = Auth::user(); 
			$token = $user->createToken($user->name);
			//untuk dapet tokennya => $data['token'] = $token->accessToken;
			$data['token'] = $token->token->id;			
			$data['id'] = $user->id;
			$data['name'] = $user->name;
			$data['email'] = $user->email;
			$data['is_admin'] = $user->is_admin;
			
			return $this->sendResponse(true, $data, 'Successfully login');
		}
		else
		{
			return $this->sendError('Email or Password not found in database', []);
		}
	}
	
	public function logout(Request $request)
	{
		$token = $request->bearerToken();
		$cekdata = DB::table('oauth_access_tokens')->where('id', $token)->delete();
		Session::flush();
		Auth::logout();
		return $this->sendResponse(true, [], 'Account successfully logout');
	}
	
	public function index()
	{
		$data = DB::table('users')->select('id', 'name', 'email')->where('is_admin', false)->where('is_active', true)->get();
		$array = [];
		foreach($data as $datas)
		{
			array_push($array, $datas);
		}
		return $this->sendResponse(true, $array, 'Index users data');
	}
	
	public function show($id)
	{
		$data = DB::table('users')->select('id', 'name', 'email')->where('id', $id)->where('is_active', true)->first();
		return $this->sendResponse(true, $data, 'User detail information');
	}
	
	public function destroy($id)
	{
		DB::table('users')->where('id', $id)->update(['is_active' => false]);
		DB::table('products')->where('user_id', $id)->update(['is_delete' => true]);
		return $this->sendResponse(true, $id, 'Users successfully deleted');
	}
}
