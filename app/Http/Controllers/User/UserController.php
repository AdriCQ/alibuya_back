<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
}
