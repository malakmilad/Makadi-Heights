<x-app-layout>
    <div class="page">
        @if (session('status'))
            <div class="alert alert-success fade show" role="alert">
                {{ session('status') }}
                @if (session('url'))
                    <a class="go-to-payment" href="{{ session('url') }}">Go to Payment</a>
                @endif
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="header" id="buttons-to-top">
            <div class="pull-left mb-2">
                <h2>
                    Create a Payment
                </h2>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-12 col-md-9">
                <form class="" action="{{ route('units.search') }}" method="GET">
                    @csrf

                    <div class="flex">
                        <div>
                            <label for="searchUnitUniqueReference" class="form-label">Unit Unique Reference</label>
                            <input id="searchUnitUniqueReference" type="text"
                                value="{{ old('unit_unique_reference') }}" name="unit_unique_reference"
                                class="form-control">
                        </div>

                        <button type="submit" class="ml-3 search-btn-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-search" viewBox="0 0 16 16">
                                <path
                                    d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @push('scripts')
        <script src="{{ asset('js/edit-payment.js') }}" defer></script>
    @endpush
</x-app-layout>
