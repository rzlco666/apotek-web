<!DOCTYPE html>
<html lang="en" @if (Route::currentRouteName()=='layout_rtl') dir="rtl" @endif>

<head>
    @include('layouts.head')
    <!-- comman css-->
    @include('layouts.css')
</head>

@switch(Route::currentRouteName())
    @case('dashboard')
        <body>
        @break

    @case('box_layout')
        <body class="box-layout">
        @break

    @case('layout_rtl')
        <body class="rtl">
        @break

    @case('layout_dark')
        <body class="dark-only">
        @break

    @default
        <body>
@endswitch


    <!-- tap on top starts-->
    <div class="tap-top"><i data-feather="chevrons-up"></i></div>
    <!-- tap on tap ends-->

    <!-- Loader starts-->
    <div class="loader-wrapper">
        <div class="dot"></div>
        <div class="dot"></div>
        <div class="dot"></div>
        <div class="dot"> </div>
        <div class="dot"></div>
    </div>
    <!-- Loader ends-->

    <!-- page-wrapper Start-->
    <div class="page-wrapper compact-wrapper compact-sidebar" id="pageWrapper">

        <!-- Page Header Start-->
        @include('layouts.header')
        <!-- Page Header Ends-->

        <!-- Page Body Start-->
        <div class="page-body-wrapper">

            <!-- Page Sidebar Start-->
            @include('layouts.sidebar')
            <!-- Page Sidebar Ends-->


            <div class="page-body">
                @yield('main_content')
                <!-- Container-fluid Ends-->
            </div>

            <!-- footer start-->
            @include('layouts.footer')

        </div>
    </div>
    {{-- scripts --}}
    @include('layouts.script')
    {{--end scripts --}}

</body>
</html>
