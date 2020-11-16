<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
	/**
	 * 
	 */
	public function login(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'email' => ['required', 'email'],
			'password' => ['required', 'string', 'min:5']
		]);
		if ($validator->fails()) {
			$this->API_RESPONSE['ERRORS'] = $validator->errors();
		} else {
			$validated = $validator->validate();
			if (Auth::attempt(['email' => $validated['email'], 'password' => $validated['password']])) {
				// User is logged
				$user = Auth::user();
				$this->API_RESPONSE['STATUS'] = true;
				$this->API_RESPONSE['DATA'] = [
					'profile' => $user,
					'api_token' => $user->createToken('token-name')->plainTextToken,
				];
			} else {
				$this->API_RESPONSE['ERRORS'] = ['Credenciales incorrectas'];
			}
		}
		return response()->json($this->API_RESPONSE);
	}

	/**
	 * 
	 */
	public function register(Request $request)
	{
		// return response()->json($request);
		$validator = Validator::make($request->all(), [
			'first_name' => ['required', 'string'],
			'last_name' => ['required', 'string'],
			'email' => ['required', 'email', 'unique:users'],
			'password' => ['required', 'confirmed', 'string', 'min:5']
		]);
		if ($validator->fails()) {
			$this->API_RESPONSE['ERRORS'] = $validator->errors();
		} else {
			$validated = $validator->validate();
			$user = new User([
				'first_name' => $validated['first_name'],
				'last_name' => $validated['last_name'],
				'email' => $validated['email'],
				'password' => Hash::make($validated['password']),
			]);

			$user->assignRole('Guest');
			if ($user->save()) {
				unset($user['roles']);
				$this->API_RESPONSE['DATA'] = [
					'profile' => $user,
					'api_token' => $user->createToken('token-name')->plainTextToken,
				];
				$this->API_RESPONSE['STATUS'] = true;
			} else {
				$this->API_RESPONSE['ERRORS'] = $user->errors;
			}
		}
		return response()->json($this->API_RESPONSE);
	}

	/**
	 * 
	 */
	public function update(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'first_name' => ['required', 'string'],
			'last_name' => ['required', 'string'],
			'country' => ['required', 'string', 'max:4'],
			'state' => ['required', 'string'],
			'city' => ['required', 'string']
		]);
		if ($validator->fails()) {
			$this->API_RESPONSE['ERRORS'] = $validator->errors();
		} else {
			$validated = $validator->validate();
			$user = auth()->user();
			$user->first_name = $validated['first_name'];
			$user->last_name = $validated['last_name'];
			$user->country = $validated['country'];
			$user->state = $validated['state'];
			$user->city = $validated['city'];
			// TODO: End Update User
		}
	}
}
