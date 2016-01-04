<?php

//patterns
Route::pattern('id', '[0-9]+');

//default page
Route::get('/', [ 'as' => 'home', function()
{

	if (Auth::check())
		return Redirect::to('me');
	else
		return View::make('pages.landing');
}]);

//profiles
Route::group([ 'before' => 'auth' ], function()
{
	Route::get('whoami', [ 'as' => 'whoami', 'uses' => 'ProfileController@ShowWhoAmI' ]);
	Route::get('me', [ 'as' => 'me', 'uses' => 'ProfileController@ShowMe' ]);
	Route::get('profile', 'ProfileController@ShowMe');

	//all profile editing done through 'me' page
	Route::post('me/edit/{what}/{action?}/{id?}', 'ProfileController@DoEditProfile');
	Route::get('me/edit/{what}/delete/{id?}', 'ProfileController@DoEditProfileDelete'); //allow deletion by GET
	Route::delete('me/edit/{what}/{id?}', 'ProfileController@DoEditProfileDelete');
	Route::get('me/edit/{what}/{id?}', 'ProfileController@ShowEditProfile');
});
Route::get('profile/{id}', 'ProfileController@ShowProfile');
//Create new profile
Route::get('profile/new', [ 'before' => 'guest', 'uses' => 'ProfileController@ShowNew' ]);
Route::post('profile/new', [ 'before' => 'guest', 'uses' => 'ProfileController@DoNew' ]);

Route::get('landing', function() { return View::make('pages.landing'); });
Route::get('mobiletest', function() { return View::make('pages.mobiletest'); });

//Login/password management
Route::get('login', 'LoginController@ShowLogin');
Route::post('login', [ 'before' => 'csrf', 'uses' => 'LoginController@DoLogin' ]);
Route::get('login/forgot', 'LoginController@ShowForgot');
Route::post('login/forgot', [ 'before' => 'csrf', 'uses' => 'LoginController@DoForgot']);
Route::get('login/reset/{token}', 'LoginController@ShowReset');
Route::post('login/reset', [ 'before' => 'csrf', 'uses' => 'LoginController@DoReset']);
Route::get('logout', 'LoginController@ShowLogout');

//Requests
Route::group([ 'before' => 'auth' ], function()
{
	Route::get('request/new', 'RequestController@ShowCreate');
	Route::post('request/new', [ 'uses' => 'RequestController@DoCreate' ]);
});
Route::get('request/{id}', 'RequestController@ShowRequest');

//aliases for creation
Route::get('new/profile', 'ProfileController@ShowCreate');
Route::get('create/profile', 'ProfileController@ShowCreate');
Route::group([ 'before' => 'auth' ], function()
{
	Route::get('new/service', 'ServiceController@ShowCreate');
	Route::get('create/service', 'ServiceController@ShowCreate');
	Route::get('new/request', 'RequestController@ShowCreate');
	Route::get('create/request', 'RequestController@ShowCreate');
});

//Load documents from media/doc
Route::any('/doc/{doc}', function($Document)
{
	$doc = @file_get_contents(Request::server('DOCUMENT_ROOT') . '/media/doc/' . $Document . '.html');
	return $doc;
});
Route::get('/doc/{doc}', [ 'as' => 'doc', function($Document)
{
	$doc = @file_get_contents(Request::server('DOCUMENT_ROOT') . '/media/doc/' . $Document . '.html');
	if (Request::ajax())
	{
		return $doc;
	}
	else
	{
		$match = [];
		preg_match('/<title>(.*?)<\\/title>/i', $doc, $match);
		$title = $match[1];
		return View::make('pages.doc', [ 'theme' => 'profile', 'doc' => $doc, 'title' => $title, 'page_title' => $title ]);
	}
}]);

//Help page
Route::get('help/{page?}', [ 'as' => 'help', function($Page = '')
{

	switch (strtolower($Page))
	{
		case 'profile': return View::make('pages.help.profile');
		case 'services': return View::make('pages.help.services');
		case 'requests': return View::make('pages.help.requests');
		case 'reviews': return View::make('pages.help.reviews');
		case 'messaging': return View::make('pages.help.messaging');
		case 'payment': return View::make('pages.help.payment');
		case 'feedback': return View::make('pages.help.feedback');
		default: return View::make('pages.help.intro');
	}
}]);

//safe (external) link - (Will automatically convert local links to external links)
Route::get('extlink/{link}', [ 'as' => 'extlink', function($Link)
{
	$isExternal = preg_match('/^.*:\/\//', $Link);

	//assume HTTP
	if (!$isExternal)
		$Link = 'http://' . $Link;

	return View::make('pages.extlink', [ 'link' => $Link, 'theme' => 'warning' ]);
}])->where('link', '.*');