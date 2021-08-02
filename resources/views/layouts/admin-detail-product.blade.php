<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('page_title') - Admin Dashboard Template</title>

    @include('layouts.partials.admin.build_in_style')

    @yield('extend_style')

</head>

<body>
    <div class="app">
        <div class="layout">
            @include('layouts.partials.admin.header')

            @include('layouts.partials.admin.sidebar')

            <!-- Page Container START -->
            <div class="page-container">

                <!-- Content Wrapper START -->
                <div class="main-content">

                  @yield('content')

                </div>
                <!-- Content Wrapper END -->

                @include('layouts.partials.admin.footer')
            </div>
            <!-- Page Container END -->


        </div>
    </div>

    @include('layouts.partials.admin.build_in_script')

    @yield('extend_script')

</body>

</html>
