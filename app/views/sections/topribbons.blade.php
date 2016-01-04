@foreach ($errors->page->all() as $err)
    <div class='top-ribbon theme-error text-pad'>{{ $err }}</div>
@endforeach
@foreach ($warnings as $warn)
    <div class='top-ribbon theme-warning text-pad'>{{ $warn }}</div>
@endforeach
@foreach ($messages as $msg)
    <div class='top-ribbon theme-indeterminate text-pad'>{{ $msg }}</div>
@endforeach
