@if (config('bcomponents.assets.include_css', true))
    <link rel="stylesheet" href="{{ asset('vendor/bcomponents/css/bcomponents.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/bcomponents/css/themes/' . config('bcomponents.theme.preset', 'default') . '.css') }}">
@endif

@if (config('bcomponents.assets.include_js', true))
    <script src="{{ asset('vendor/bcomponents/js/app.js') }}" defer></script>
@endif

