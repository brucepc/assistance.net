<footer>
	<div id='copyright'><a href=''>Assistance.net Inc &copy; {{ date('Y') }}</a></div><hr>
	<nav id='notices'>
		<a id='notices-link-pp' href='{{ route('doc', [ 'privacy' ]) }}'>{{ trans('shared.footer.privacy') }}</a>
		| <a id='notices-link-tos' href='{{ route('doc', [ 'tos' ]) }}'>{{ trans('shared.footer.terms') }}</a>
		| <a id='notices-link-news' href='http://assistancenews.wordpress.com/'>{{ trans('shared.footer.news') }}</a>
		| <a id='notices-link-contact' href=''>{{ trans('shared.footer.contact') }}</a>
	</nav>
</footer>
