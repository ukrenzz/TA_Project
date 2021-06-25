<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('layouts.partials.ecommerce.meta_tag')
    <title>@yield('title')</title>

    {{-- Style build in --}}
    @include('layouts.partials.ecommerce.build_in_css')

    {{-- User defined style --}}
    @yield('user_defined_style')

</head>

<body>

	<div id="page">

    {{-- Style build in --}}
    @include('layouts.partials.ecommerce.header')

  	@yield('content')

  	@include('layouts.partials.ecommerce.footer')
	</div>
	<!-- page -->

  {{-- Back to top button --}}
	<div id="toTop"></div>

	@include('layouts.partials.ecommerce.build_in_script')

  @yield('user_defined_script')

</body>
</html>
