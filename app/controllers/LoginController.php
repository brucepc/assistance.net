<?php

class LoginController extends BaseController
{
	public function ShowLogin()
	{
		return View::make('pages.login.login');
	}
	public function DoLogin()
	{
		$validator = Validator::make(
			Input::all(),
			[
				'email' => 'required|email',
				'password' => 'required'
			]
		);

		if ($validator->fails())
		{
			if (Request::ajax())
				return Response::make($validator->errors(), 406);

			return Redirect::to('login')->withErrors($validator)->withInput(Input::except('password'));
		}
		else if (!Auth::attempt([ 'email' => Input::get('email'), 'password' => Input::get('password') ], Input::get('remember')))
		{
			if (Request::ajax())
				return Response::make(Lang::get('login/login.invalid_credentials'), 406);

			return Redirect::to('login')->withErrors(Lang::get('login/login.invalid_credentials'));
		}
		else
		{
			if (Request::ajax())
				return Response::make(Lang::get('login/login.logged_in'), 202);

			return Redirect::intended('me');
		}
	}
	public function ShowLogout()
	{
		Auth::logout();
		return View::make('pages.login.logout');
	}

	public function ShowForgot()
	{
		return View::make('pages.login.forgot');
	}
	public function DoForgot()
	{
		if (!strlen(Input::get('email')))
			return Redirect::action('LoginController@ShowForgot')->withErrors([ 'email' => Lang::get('login/forgot.email_missing') ]);

		$user = User::where('email', Input::get('email'))->first();
		$token = sha1(openssl_random_pseudo_bytes(64));

		$user->password_reset_token = $token;
		$user->password_reset_time = time();
		$user->save();

		Mail::send('emails.resetpass', [ 'token' => $token ], function($msg)
		{
			$msg->to(Input::get('email'))->subject(Lang::get('login/forgot.email_subject'));
		});

		Session::flash('messages', [ Lang::get('login/forgot.email_sent') ]);
		return Redirect::route('home');
	}
	public function ShowReset($Token)
	{
		$user = User::where('password_reset_token', $Token)->first();
		//bad request
		if (!$user)
			return Redirect::action('LoginController@ShowForgot')->withErrors([ 'reset' => Lang::get('login/reset.invalid_reset') ]);

		$created = strtotime($user->password_reset_time);

		//expired
		// if (time() - Config::get('reminder.expire') * 60 > $created)
		// 	return Redirect::action('LoginController@ShowForgot')->withErrors([ 'reset' => 'This reset attempt has expired, please try again' ]);

		return View::make('pages.login.reset', [ 'token' => $Token, 'email' => $user->email ]);
	}
	public function DoReset()
	{
		$user = User::where('password_reset_token', '=', Input::get('token'))->where('email', '=', Input::get('email'))->first();

		//bad request
		if (!$user)
			return Redirect::action('LoginController@ShowForgot')->withErrors([ 'reset' => Lang::get('login/reset.invalid_reset') ]);

		//password mismatch
		if (Input::get('password') != Input::get('password_confirm'))
			return View::make('pages.login.reset', [ 'token' => Input::get('token'), 'email' => Input::get('email') ])->withErrors([ 'password' => Lang::get('login/reset.password_mismatch') ]);

		$password = Hash::make(Input::get('password'));

		//clear the request
		$user->password = $password;
		$user->password_reset_token = null;
		$user->password_reset_time = 0;
		$user->save();

		Mail::send('emails.passreset', function($msg)
		{
			$msg->to(Input::get('email'))->subject(Lang::get('login/reset.password_changed'));
		});

		Session::flash('messages', [ Lang::get('login/reset.password_reset_message') ]);
		return Redirect::action('LoginController@ShowLogin');
	}
}
