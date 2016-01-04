<h2>Password Reset</h2>
<div>
	To reset your password, complete this form: <a href="{{ URL::to('login/reset', [ $token ]) }}">{{ URL::to('login/reset', [ $token ]) }}</a>.<br>
	This link will expire in {{ Config::get('auth.reminder.expire', 60) }} minutes.
</div>