<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/intlTelInput.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js">
    </script>
    <script src="{{ asset('js/intlTelInput.min.js') }}"></script>
    @stack('scripts')

</head>

<body class="font-sans antialiased">
    <div id="loader">
        <div class="lds-ring">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
    <div class="min-h-screen bg-gray-100">

        <!-- Page Heading -->
        {{-- <header class="bg-white shadow">
                <div class="container-fluid py-6 sm:px-6 lg:px-8">
                    <div class="row">
                        <div class="col-12">
                            {{ $header }}
                        </div>
                    </div>
                </div>
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                </div>
            </header> --}}

        <!-- Page Content -->
        <main>
            <div class="container-fluid p-0 position-relative">
                <div class="menu-Mobile"> @include('layouts.sidebar')</div>
                <div class="row m-0">
                    <div class="col-2 p-0 menu-disktop">
                        @include('layouts.sidebar')
                    </div>
                    <div class="col-lg-10 col-md-12 p-0">
                        @include('layouts.navigation')
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="{{ asset('js/admin.js') }}"></script>
</body>

</html>
