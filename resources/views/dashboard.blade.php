<x-app-layout>
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot> --}}

    {{-- <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    You're logged in!
                </div>
            </div>
        </div>
    </div> --}}
    {{-- <div class="container mx-auto">
        <div class="row">
            <div class="col-md-3">
                hey
            </div>
            <div class="col-md-9">
                hey
            </div>
        </div>
    </div> --}}
    <div class="py-12 dashboard">
        {{-- <h2>
            Hello, {{ Auth::user()->name }}
        </h2> --}}
        <div class="whats-new">
            <h1>What's new</h1>
            <h4>
                - System now supports responsiveness (mobile version).
            </h4>
            <h4>
                - Added the feature of downloading receipts for all the paid payments.
            </h4>
            <h4>
                - Expired payments gets deleted automatically.
            </h4>
            <h4>
                - Now, payments are connected with each other.
            </h4>
            <p>
                All payments for the same unit are now listed on a single page.
            </p>
            <video controls playsinline muted>
                <source src="{{ asset('screen-recordings/related-payments.mov') }}" type="video/mp4">
                Your browser does not support the video tag.
            </video>

            <br>
            <hr>
            <br>

            <h4>- Now, you can export your payments within a date range.</h4>
            <img src="{{ asset('screen-recordings/export-by-date.png') }}" alt="" srcset="">

            <br>
            <hr>
            <br>

            <h4>- Also, you can filter the payments by unit unique reference.</h4>
            <img src="{{ asset('screen-recordings/filter-payments.png') }}" alt="" srcset="">

            <br>
            <hr>
            <br>

            <h2>Unit Unique Reference</h2>
            <h4>
                - Before creating a new payment; search for the unit unique reference first
            </h4>
            <p>
                If there are other pending payments for the searched unit unique reference, you can go check the payment
                until it's expired and deleted., if there are no payments for the searched unit unique reference, you
                will be redirected to the create payment page.
            </p>

            <p>
                <b>Hint:</b> you cannot add another payment for the same uniit unique reference until the pending
                payment expires.
            </p>

            <video controls playsinline muted>
                <source src="{{ asset('screen-recordings/create-payment.mov') }}" type="video/mp4">
                Your browser does not support the video tag.
            </video>

            <br>
            <hr>
            <br>

            <h4>
                - Adding a new payment for the same unit is much easier.
            </h4>
            <p>
                For adding a new payment for the same unit, press on add new payment button and enter the new payment
                amount only without having to enter all unit and client details again.
            </p>
            <video controls playsinline muted>
                <source src="{{ asset('screen-recordings/adding-payment.mov') }}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>
        {{-- @if (isset($_COOKIE['whats_new']))
            yes cookie
        @else
            No Cookie
        @endif
        <form action="{{ route('cookie.unset') }}" method="GET">
            @csrf
            <button type="submit" class="btn btn-primary">UNSET</button>
        </form> --}}
    </div>
</x-app-layout>
