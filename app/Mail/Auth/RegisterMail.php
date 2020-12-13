<?php

namespace App\Mail\Auth;

use App\Models\User\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegisterMail extends Mailable implements ShouldQueue
{
	use Queueable, SerializesModels;

	protected $confirmation_url;
	protected User $user;

	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */
	public function __construct(User $user, string $url)
	{
		$this->confirmation_url = $url;
		$this->user = $user;
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build()
	{
		// TODO: Modify sender email
		return $this->from('support@alibuya.net')->subject('Email Confirmation')->markdown('emails.auth.confirm_email')->with([
			'confirmation_url' => $this->confirmation_url,
			'user' => $this->user
		]);
	}
}
