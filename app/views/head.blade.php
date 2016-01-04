<title>{{{ isset($page_title) ? $page_title . ' |' : '' }}} Assistance</title>

<meta http-equiv='content-type' content='text/html; charset=utf-8'>
<meta name='description' content='Assistance.net :: Assist others, Empower yourself'>
<meta name='author' content='Assistance.net'>
<meta name='X-CSRF-Token' content='{{ csrf_token() }}'>

<link rel='icon' href='{{ asset('media/a.png') }}'>
<link rel='shortcut icon' href='{{ asset('media/a.png') }}'>

{{ (@$notResponsive ? '' : "<meta name='viewport' content='width=device-width, initial-scale=1'>") }}

<script type='text/javascript' src='{{ asset('scripts/jquery.min.js') }}'></script>
<script type='text/javascript' src='{{ asset('scripts/popup.js') }}'></script>
<script type='text/javascript' src='{{ asset('scripts/widgets.js') }}'></script>
<script type='text/javascript'>document.write('<style type='text/css'>.show-js { display: initial; }</style>');</script>
@if (!Config::get('app.debug')) <script type='text/javascript' src='{{ asset('scripts/debug.js') }}'></script> @endif