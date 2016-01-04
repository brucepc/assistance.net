<?php

class BillingController extends BaseController
{
	public $profile;

	public function ShowMe()
	{
		return Redirect::action('ProfileController@ShowProfile', [ Auth::id() ]);
	}
	public function ShowProfile($Id)
	{
		$this->profile = Profile::find($Id);
		if (!$this->profile)
			App::abort(404, 'That user does not exist');

		return View::make('pages.profile.profile',
			[
				'profile' => $this->profile,
				'page_title' => $this->profile->name,
				'services_list' => [ 'Test link' => '' ],
				'requests_list' => [],
				'skills' => [ 
					'test' => 5,
					'foo' => 6,
					'btest' => 5,
					'bfoo' => 6,
					'ctest' => 5,
					'cfoo' => 6,
					'dtest' => 5,
					'dfoo' => 6,
					]
			]);
	}

	public function ShowNew()
	{
		return View::make('pages.profile.new',
			[
				'page_title' => 'Create Account'
			]);
	}

	public function DoNew()
	{
		$validator = Validator::make(
			Input::all(),
			[
				'email' => 'required|email|unique:users',
				'password' => 'required|confirmed',
				'password_confirmation' => 'required',
				'name' => 'required'
			]
		);

		if ($validator->fails())
		{
			// if (Request::ajax())
			// 	return Response::make($validator->errors(), 406);

			return Redirect::action('ProfileController@ShowNew')->withErrors($validator)->withInput(Input::except('password', 'password_confirm'));
		}
		else
		{
			$user = new User;
			$user->email = Input::get('email');
			$user->password = Hash::make(Input::get('password'));
			$user->save();

			$profile = new Profile;
			$profile->user_id = $user->id;
			$profile->name = Input::get('name');
			$profile->save();

			Auth::login($user);
			return Redirect::action('ProfileController@ShowProfile', [ $user->id ]);
		}
	}
}
