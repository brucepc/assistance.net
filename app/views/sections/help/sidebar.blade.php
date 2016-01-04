<div id='sidebar'>
    <div class='row'>
        <h2><a href='{{ route('help') }}'>{{ trans('help/sidebar.title') }}</a></h2><hr>
        <ul id='categories-list' class='icon-list'>
            <li><i class='fico-person color-profile'></i><a href='{{ route('help', [ 'profile' ]) }}'>{{ trans('help/sidebar.categories.profile') }}</a></li>
            <li><i class='fico-service color-service'></i><a href='{{ route('help', [ 'services' ]) }}'>{{ trans('help/sidebar.categories.services') }}</a></li>
            <li><i class='fico-request color-request'></i><a href='{{ route('help', [ 'requests' ]) }}'>{{ trans('help/sidebar.categories.requests') }}</a></li>
            <li><i class='fa fa-comments stroke-18'></i><a href='{{ route('help', [ 'reviews' ]) }}'>{{ trans('help/sidebar.categories.reviews') }}</a></li>
            <li><i class='fico-message color-indeterminate'></i><a href='{{ route('help', [ 'messaging' ]) }}'>{{ trans('help/sidebar.categories.messaging') }}</a></li>
            <li><i class='fa fa-money stroke-13'></i><a href='{{ route('help', [ 'payment' ]) }}'>{{ trans('help/sidebar.categories.payment') }}</a></li>
            <li><i class='fico-feedback color-error'></i><a href='{{ route('help', [ 'feedback' ]) }}'>{{ trans('help/sidebar.categories.feedback') }}</a></li>
        </ul>
    </div>
    @if (trim($__env->yieldContent('sidebar'))) <div class='small-vspace'></div> @endif
    @yield('sidebar')
</div>