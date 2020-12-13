<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Mail\Auth\RegisterMail;
use App\Mail\Auth\ResetPassword;
use App\Models\User\EmailVerificationCode;
use App\Models\User\User;
use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;

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
				$this->sendConfirmationEmail($user);
			} else {
				$this->API_RESPONSE['ERRORS'] = $user->errors;
			}
		}
		return response()->json($this->API_RESPONSE);
	}

	/**
	 * verifyEmail
	 *
	 * @param Request $request
	 * @return JsonResponse
	 */
	public function verifyEmail(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'email' => ['required', 'email'],
			'code' => ['required', 'string']
		]);
		if ($validator->fails()) {
			$this->API_RESPONSE['ERRORS'] = $validator->errors();
		} else {
			$validator = $validator->validate();
			$user = User::query()->where('email', $validator['email']);

			if (!$user->exists()) {
				$this->API_RESPONSE['ERRORS'] = ['No users'];
			} else {
				$user = $user->first();
				if (Hash::check($validator['code'], $user->emailVerificationCode->hash_code)) {
					$user->email_verified_at = Carbon::now()->toDateTimeString();
					if ($user->save()) {
						// $this->API_RESPONSE['DATA']['api_token'] = $user->createToken('token-name')->plainTextToken;
						$this->API_RESPONSE['STATUS'] = true;
					} else {
						$this->API_RESPONSE['ERRORS'] = ['Save database error'];
					}
				} else {
					$user->emailVerificationCode->tries++;
					if ($user->emailVerificationCode->tries > 10) {
						$newNumber = Factory::create()->randomNumber(6);
						$user->emailVerificationCode->hash_code = Hash::make($newNumber);
						$this->API_RESPONSE['DATA']['verification_code'] = $newNumber;
					}
					if ($user->emailVerificationCode->save()) {
						$this->API_RESPONSE['STAUS'] = true;
					}
				}
			}
		}
		return redirect("https://alibuya.net")->with($this->API_RESPONSE);
	}

	/**
	 * sendResetPasswordEmail
	 *
	 * @param  mixed $request
	 * @return void
	 */
	public function sendResetPasswordEmail(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'email' => ['required', 'email']
		]);
		if ($validator->fails()) {
			$this->API_RESPONSE['ERRORS'] = $validator->errors();
		} else {
			$validator = $validator->validate();
			$user = User::query()->where('email', $validator['email']);
			if ($user->exists()) {
				$user = $user->first();
				$token = Factory::create()->password;
				DB::table('password_resets')->insert([
					'email' => $validator['email'],
					'token' => Hash::make($token)
				]);
				Mail::to($user)->send(new ResetPassword($user, $token));
			} else {
				$this->API_RESPONSE['ERRORS'] = ['No User'];
			}
		}
		return response()->json($this->API_RESPONSE);
	}

	/**
	 * resetPassword
	 *
	 * @param  mixed $request
	 * @return void
	 */
	public function resetPassword(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'email' => ['required', 'email'],
			'token' => ['required', 'string'],
			'password' => ['required', 'string', 'min:6', 'confirmed']
		]);
		if ($validator->fails()) {
			$this->API_RESPONSE['ERRORS'] = $validator->errors();
		} else {
			$validator = $validator->validate();
			$passwordResetDB = DB::table('password_resets')->where('email', $validator['email']);
			if ($passwordResetDB->exists()) {
				$passwordResetDB = $passwordResetDB->first();
				if (Hash::check($validator['token'], $passwordResetDB['token'])) {
					$user = User::query()->where('email', $validator['email']);
					if ($user->exists()) {
						$user = $user->first();
						$user->password = Hash::make($validator['password']);
						if ($user->save()) {
							$this->API_RESPONSE['DATA'] = [
								'profile' => $user,
								'api_token' => $user->createToken('token-name')->plainTextToken,
							];
							$this->API_RESPONSE['STATUS'] = true;
						} else {
							$this->API_RESPONSE['ERRORS'] = $user->errors;
						}
					} else {
						$this->API_RESPONSE['ERRORS'] = ['No Users'];
					}
				} else {
					$this->API_RESPONSE['ERRORS'] = ['Wrong hash'];
				}
			} else {
				$this->API_RESPONSE['ERRORS'] = ['No Email'];
			}
		}
		return response()->json($this->API_RESPONSE);
	}

	/**
	 * resendEmailConfirmation
	 *
	 * @param  mixed $request
	 * @return void
	 */
	public function resendEmailConfirmation(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'email' => ['required', 'email']
		]);
		if ($validator->fails()) {
			$this->API_RESPONSE['ERRORS'] = $validator->errors();
		} else {
			$validator = $validator->validate();
			$user = User::query()->where('email', $validator['email']);
			//? Check if email exists
			if ($user->exists()) {
				$user = $user->first();
				if (!$user->email_verified_at) {
					$this->sendConfirmationEmail($user);
				}
			}
			//! Catch email exists Error
			else {
				$this->API_RESPONSE['ERRORS'] = ['No email'];
			}
		}
		return response()->json($this->API_RESPONSE);
	}

	/**
	 * sendConfirmationEmail
	 *
	 * @param  mixed $user
	 * @return void
	 */
	private function sendConfirmationEmail(User $user)
	{
		$confirmCode = Factory::create()->password();
		if (EmailVerificationCode::query()->where('user_id', $user->id)->exists()) {
			EmailVerificationCode::query()->where('user_id', $user->id)->update([
				'hash_code' => Hash::make($confirmCode)
			]);
		} else {
			EmailVerificationCode::query()->insert([
				'user_id' => $user->id,
				'hash_code' => Hash::make($confirmCode)
			]);
		}
		$confirmUrl = action([AuthController::class, 'verifyEmail'], ['email' => $user->email, 'code' => $confirmCode]);
		Mail::to($user)->send(new RegisterMail($user, $confirmUrl));
	}
}
