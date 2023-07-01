<x-app-layout>
    <div class="page">
        @if (session('status'))
            <div class="alert alert-success fade show" role="alert">
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger fade show" role="alert">
                Please fill in the mandatory fields
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="header" id="buttons-to-top">
            <div class="pull-left mb-2">
                <h2>
                    Rate {{ $rate->currency }}
                </h2>
            </div>
            <div class="pull-right flex desktop">
                <button disabled id="save-button" type="submit" form="rates-form" class="flex btn btn-success" href="">
                    Save
                </button>
            </div>
            <div class="clear-both"></div>
        </div>
        <div class="row mt-5">
            <div class="col-12 col-md-9">
                <div class="card">
                    <form id="rates-form" method="POST" action="{{ route('rates.update', $rate->id) }}"
                        class="row g-3">
                        @csrf
                        @method('put')
                        <div class="col-md-6">
                            <label for="inputFirstName" class="form-label">Currency</label>
                            <h2>{{$rate->currency}}</h2>
                        </div>
                        <div class="col-md-6">
                            <label for="rateRate" class="form-label">Rate (EGP)</label>
                            <input type="number" value="{{ old('rate', $rate->rate) }}" name="rate"
                                class="form-control" id="rateRate" step="0.01" min="0">
                            @error('last_name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="card">
                    <h3>Information</h3>
                    <div class="update-by">
                        <span>Last Update</span>
                        <span>{{ \Carbon\Carbon::parse($rate->updated_at)->diffForHumans() }}</span>
                    </div>

                    {{-- <div class="update-by">
                      <span>By</span>
                      <span>{{$payment->user->name}}</span>
                  </div> --}}
                </div>
            </div>
            <div class="w-100 mobile">
                <button disabled id="save-button-mobile" type="submit" form="rates-form" class="flex btn btn-success w-100" href="">
                    Save
                </button>
            </div>
        </div>
    </div>
    @push('scripts')
        <script src="{{ asset('js/edit-payment.js') }}" defer></script>
    @endpush
</x-app-layout>
