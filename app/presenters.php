<?php

//Similar to view errors
View::share('theme', 'profile');
View::share('messages', Session::get('messages', []));
View::share('warnings', Session::get('warnings', []));

View::composer(['pages.*'], function($View) { $View->with(['mail_count' => 0]); }); //all pages receive the mail count

View::composer(['pages.error', 'pages.profile', 'pages.service', 'pages.request'], function($View) { $View->with(['theme' => substr(@$View->getName(), 6)]); }); //automatic theming