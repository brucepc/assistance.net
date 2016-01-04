<div id='title'>
    @if (isset($title_image))
        <div id='title-image'>
            <div id='title-image-image' style='background-image: url("{{{ @$title_image }}}")'></div>
            <div id='title-image-subtitle'>{{{ @$title_image_subtitle }}}</div>
        </div>
    @endif
    <div id='title-bar' class='theme-{{{ $theme }}}'>
        <h2 id='title-title'>{{{ @$title_title }}}</h2>
        <h4 id='title-subtitle'>{{{ @$title_subtitle }}}</h4>
    </div>
    @if (trim($__env->yieldContent('title-lr')))
        <div id='title-lr'>
            @yield('title-lr')
        </div>
    @endif
</div>