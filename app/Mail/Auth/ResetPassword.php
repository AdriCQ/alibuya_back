<?php

namespace App\Mail\Auth;

use App\Models\AppSettings;
use App\Models\User\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPassword extends Mailable
{
	use Queueable, SerializesModels;

	protected User $user;
	protected string $token;

	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */
	public function __construct(User $user, string $token)
	{
		$this->user = $user;
		$this->token = $token;
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build()
	{
		//http://localhost:8080/#/auth/reset-password
		$url = AppSettings::$CLIENT_URL . '/auth/reset-password?email=' . urlencode($this->user->email) . '&token=' . urlencode($this->token);
		return $this->from('support@alibuya.net')->subject('Password Reset')->markdown('emails.auth.reset_password')->with([
			'user' => $this->user,
			'reset_url' => $url
		]);
	}
}
