<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User\Contacts;
use App\Models\User\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

	public function getRoles()
	{
		$user = auth()->user();
		$roles = [];
		foreach ($user->roles as $role) {
			array_push($roles, $role->name);
		}
		return response()->json($roles);
	}

	/**
	 * addContact
	 *
	 * @param  mixed $request
	 * @return void
	 */
	public function addContact(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'first_name' => ['required', 'string', 'max:50'],
			'last_name' => ['required', 'string', 'max:50'],
			'ci' => ['required', 'string', 'max:11', 'min:11'],
			'address' => ['required', 'string']
		]);
		if ($validator->fails()) {
			$this->API_RESPONSE['ERRORS'] = $validator->errors();
		} else {
			$validator = $validator->validate();
			$validator['user_id'] = auth()->user()->id;
			$contact = new Contacts($validator);
			if ($contact->save()) {
				$this->API_RESPONSE['DATA'] = $contact;
				$this->API_RESPONSE['STATUS'] = true;
			} else {
				$this->API_RESPONSE['ERRORS'] = $contact->errors;
			}
		}
		return response()->json($this->API_RESPONSE);
	}

	/**
	 * getContacts
	 *
	 * @param  mixed $request
	 * @return void
	 */
	public function getContacts(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'user_id' => ['required', 'integer']
		]);
		if ($validator->fails()) {
			$this->API_RESPONSE['ERRORS'] = $validator->errors();
		} else {
			$validator = $validator->validate();
			$user = User::query()->find($validator['user_id']);
			if ($user === null) {
				$this->API_RESPONSE['ERRORS'] = ['No user'];
			} else {
				$this->API_RESPONSE['DATA'] = $user->contacts;
				$this->API_RESPONSE['STATUS'] = true;
			}
		}
		return response()->json($this->API_RESPONSE);
	}

	/**
	 * getContactsByAuth
	 *
	 * @return void
	 */
	public function getContactsByAuth()
	{
		$user = auth()->user();
		$this->API_RESPONSE['DATA'] = $user->contacts;
		$this->API_RESPONSE['STATUS'] = true;
		return response()->json($this->API_RESPONSE);
	}
}
