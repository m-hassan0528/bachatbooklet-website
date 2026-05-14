<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('layouts.user.head')

<body class="antialiased">
    @include('layouts.user.header')

    @yield('content')

    @include('layouts.user.footer')
</body>

</html>