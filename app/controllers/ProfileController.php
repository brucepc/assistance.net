<?php

use Models\Profile;
use Models\Experience;

class ProfileController extends BaseController
{
	public $profile;

	public function ShowMe()
	{
		// return $this->ShowProfile(Auth::id());
		return Redirect::action('ProfileController@ShowProfile', [ Auth::id() ]);
	}
	public function ShowWhoAmI()
	{
		return View::make('pages.profile.whoami', [ 'profile' => Auth::user()->profile ]);
	}

	//used by both ShowProfile and ShowEditProfile
	protected function BuildProfile($EditingWhat = null, $EditingWhich = null)
	{
		$isMe = (Auth::check() && intval(Auth::id()) === $this->profile->user->id);
		if (!$isMe)
			$EditingWhat = null;

		$services = [];
		foreach ($this->profile->services()->take(5)->get() as $svc)
			$services[$svc->name] = '';
		$requests = [];
		foreach ($this->profile->requests()->take(5)->get() as $req)
			$requests[$req->name] = URL::action('RequestController@ShowRequest', [ $req->id ]);

		$titleInfo = [ 
		'title_title' => $this->profile->name,
		'title_image_subtitle' => ($this->profile->max_rating === 0 ? trans('profile/profile.no_rating') : sprintf('%d / %d', $this->profile->rating, $this->profile->max_rating)),
		'title_image' => ''
		];

		$servicesList = [
			'theme' => 'service',
			'title' => Lang::choice('shared.classes.service', 0),
			'list' => $services,
			'max' => '4',
			'more' => '',
			'right_top' => sprintf('%d %s', 0, trans('profile/profile.title.active_suffix')),
			'right_bottom' => sprintf('%d %s', 0, trans('profile/profile.title.completed_suffix')),
			'none' => trans('profile/profile.title.' . ($isMe ? 'my_' : '') . 'no_services') 
		];
		$requestsList = [
			'theme' => 'request',
			'title' => Lang::choice('shared.classes.request', 0),
			'list' => $requests,
			'max' => '4',
			'more' => '',
			'right_top' => sprintf('%d %s', 0, trans('profile/profile.title.active_suffix')),
			'right_bottom' => sprintf('%d %s', 0, trans('profile/profile.title.completed_suffix')),
			'none' => trans('profile/profile.title.' . ($isMe ? 'my_' : '') . 'no_requests') 
		];

		return View::make('pages.profile.profile',
		[
			'profile' => $this->profile,
			'edit' => $EditingWhat,
			'edit_which' => $EditingWhich,
			'is_me' => $isMe,
			'page_title' => $this->profile->name,
			'title_info' => $titleInfo,
			'services_list' => $servicesList,
			'requests_list' => $requestsList,
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
	public function ShowProfile($Id = null)
	{
		if (!$Id && !Auth::check())
			App::abort(404, Lang::get('profile/profile.no_user'));

		$this->profile = Profile::find($Id ?: Auth::id());
		if (!$this->profile)
			App::abort(404, Lang::get('profile/profile.no_user'));

		return $this->BuildProfile();
	}
	public function ShowEditProfile($What, $Id = null)
	{
		if (!$What)
			$this->ShowMe();

		$this->profile = Profile::find(Auth::id());
		if (!$this->profile)
			App::abort(404, Lang::get('profile/profile.no_user'));
		
		return $this->BuildProfile($What, $Id);
	}

	public function ShowNew()
	{
		return View::make('pages.profile.new');
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

	//profile editing

	public function DoEditProfile($What, $Action = null, $Id = null)
	{
		$this->profile = Auth::user()->profile;

		if ($What == 'about')
		{
			$this->profile->about = Input::get('about');
			$this->profile->save();
		}
		else if ($What == 'experience')
		{
			if ($Action == 'new' || $Action == 'edit')
			{
				$validator = Validator::make(
					Input::all(),
					[
						'name' => 'required',
						// 'link' => 'url',
						'start_date' => 'date',
						'end_date' => 'date',
						'description' => 'required'
					]
				);

				if ($validator->fails())
				{
					// dd($validator);
					return Redirect::action('ProfileController@ShowEditProfile', [ $What ])->withErrors($validator);
				}
				if ($Action == 'new')
					$exp = new Experience(Input::except([ 'start_date', 'end_date' ]));
				else
				{
					$exp = Experience::find($Id);
					$exp->fill(Input::except([ 'start_date', 'end_date' ]));
				}
				$exp->start_date = strtotime(Input::get('start_date'));
				$exp->end_date = strtotime(Input::get('end_date'));
				$this->profile->experiences()->save($exp);
			}

			//can continue adding/editing experiences
			return Redirect::action('ProfileController@ShowEditProfile', [ $What ]);
		}

		return Redirect::action('ProfileController@ShowProfile', [ $this->profile->id ]);
	}
	public function DoEditProfileDelete($What, $Id = null)
	{
		$this->profile = Auth::user()->profile;
		$isGood = false;

		if ($What == 'experience')
		{
			$exp = Experience::find($Id);
			if (isset($exp) && $exp->user_id == Auth::id())
			{
				$exp->delete();
				$isGood = true;
			}
		}

		if (Request::ajax())
			return ($isGood ? 200 : 400);

		return Redirect::action('ProfileController@ShowEditProfile', [ $What ]);
	}
}