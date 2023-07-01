<x-app-layout>
    <div class="page">
        @if ($errors->any())
            <div class="alert alert-danger fade show" role="alert">
                Please fill in the mandatory fields
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="header" id="buttons-to-top">
            <div class="pull-left mb-2">
                <h2>
                    Create a Payment
                </h2>
            </div>
            <div class="pull-right flex desktop" href="{{ route('payments.create') }}">
                <button type="submit" id="save-button" disabled form="payment-form" class="flex btn btn-success"
                    href="">
                    Save
                </button>
            </div>
            <div class="clear-both"></div>
        </div>
        <div class="row mt-5">
            <div class="col-12 col-md-9">
                <div class="card">
                    <form id="payment-form" method="POST" action="{{ route('payments.store') }}" class="row g-3">
                        @csrf
                        {{-- <input type="hidden" name="unit_id" id="inputUnitId" value=""> --}}
                        <input type="hidden" name="building_type_id" id="inputBuildingTypeId" value="">
                        <div class="col-md-6">
                            <label for="inputFirstName" class="form-label">First Name</label>
                            <input type="text"
                                value="{{ request()->get('first_name') ? request()->get('first_name') : old('first_name') }}"
                                name="first_name" class="form-control" id="inputFirstName"
                                {{ request()->get('first_name') ? ' readonly' : '' }}>
                            @error('first_name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="inputLastName" class="form-label">Last Name</label>
                            <input type="text"
                                value="{{ request()->get('last_name') ? request()->get('last_name') : old('last_name') }}"
                                name="last_name" class="form-control" id="inputLastName"
                                {{ request()->get('last_name') ? ' readonly' : '' }}>
                            @error('last_name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="inputPhoneNumber" class="form-label">Phone number</label>
                            <input type="text"
                                value="{{ request()->get('mobile') ? request()->get('mobile') : old('mobile') }}"
                                name="mobile" class="form-control" id="inputPhoneNumber"
                                {{ request()->get('mobile') ? ' readonly' : '' }}>
                            @error('mobile')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="inputEmail" class="form-label">Email</label>
                            <div class="input-group">
                                <div class="input-group-text">@</div>
                                <input type="email"
                                    value="{{ request()->get('email') ? request()->get('email') : old('email') }}"
                                    name="email" class="form-control" id="inputEmail"
                                    placeholder="johndoe@example.com" {{ request()->get('email') ? ' readonly' : '' }}>
                            </div>
                            @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="inputPersonalID" class="form-label">Personal ID</label>
                            <input type="text"
                                value="{{ request()->get('personal_id') ? request()->get('personal_id') : old('personal_id') }}"
                                {{ request()->get('personal_id') ? ' readonly' : '' }} name="personal_id"
                                class="form-control" id="inputPersonalID">
                            @error('personal_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="inputUniqueReference" class="form-label">Unit Unique Reference</label>
                            <input type="text"
                                value="{{ request()->get('unit_unique_reference') ? request()->get('unit_unique_reference') : old('unit_unique_reference') }}"
                                name="unit_unique_reference" class="form-control" id="inputUniqueReference"
                                {{ request()->get('unit_unique_reference') ? ' readonly' : '' }}>
                            @error('unit_unique_reference')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="totalPrice" class="form-label">Total Unit Price</label>
                            <input type="number"
                                value="{{ request()->get('total_unit_price') ? request()->get('total_unit_price') : old('total_unit_price') }}"
                                name="total_unit_price" class="form-control" id="totalPrice"
                                {{ request()->get('total_unit_price') ? ' readonly' : '' }}>
                            @error('total_unit_price')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="downPayment" class="form-label">Payment Amount</label>
                            <input type="number"
                                value="{{ request()->get('down_payment') ? request()->get('down_payment') : old('down_payment') }}"
                                name="down_payment" class="form-control" id="downPayment"
                                {{ request()->get('dowm_payment') ? ' readonly' : '' }}>
                            @error('down_payment')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="validHours" class="form-label">Valid Hours</label>
                            <input type="number" max="5" min="2"
                                value="{{ request()->get('valid_hours') ? request()->get('valid_hours') : old('valid_hours') }}"
                                name="valid_hours" class="form-control" id="validHours">
                            @error('valid_hours')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="inputAddress" class="form-label">Address</label>
                            <input type="text"
                                value="{{ request()->get('address_line_1') ? request()->get('address_line_1') : old('address_line_1') }}"name="address_line_1"
                                class="form-control" id="inputAddress" placeholder="1234 Main St"
                                {{ request()->get('address_line_1') ? ' readonly' : '' }}>
                            @error('address_line_1')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="inputAddress2" class="form-label">Address 2</label>
                            <input type="text"
                                value="{{ request()->get('address_line_2') ? request()->get('address_line_2') : old('address_line_2') }}"name="address_line_2"
                                class="form-control" id="inputAddress2" placeholder="Apartment, studio, or floor"
                                {{ request()->get('address_line_2') ? ' readonly' : '' }}>
                            @error('address_line_2')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="inputCity" class="form-label">City</label>
                            <input type="text"
                                value="{{ request()->get('city') ? request()->get('city') : old('city') }}"
                                name="city" class="form-control" id="inputCity"
                                {{ request()->get('city') ? ' readonly' : '' }}>
                            @error('city')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="inputState" class="form-label">Country</label>
                            <input type="text"
                                value="{{ request()->get('country') ? request()->get('country') : old('country') }}"
                                name="country" class="form-control" id="inputState"
                                {{ request()->get('country') ? ' readonly' : '' }}>
                            @error('country')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        @if (Auth::user()->hasRole('makadi-admin') ||
                                Auth::user()->hasRole('super admin') ||
                                Auth::user()->hasRole('makadi-super-admin'))
                            <div class="col-md-6">
                                <label for="behalf" class="form-label">On Behalf Of:</label>
                                <select name="user_id" id="behalf" class="form-select">
                                    <option value="" selected>Choose...</option>
                                    @foreach ($users as $user)
                                        <option {{ old('user_id') == $user->id ? 'selected' : '' }}
                                            value="{{ $user->id }}">{{ $user->email }} ,
                                            {{ $user->name }}</option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        @endif
                    </form>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div id="loader-select">
                    <div class="lds-ring">
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
                <div class="card">
                    <label for="inputZone" class="form-label">Zone</label>
                    <select form="payment-form" name="zone" id="inputZone" class="form-select"
                        zone-value="{{ request()->get('zone') ? request()->get('zone') : old('zone') }}"
                        {{ request()->get('zone') ? ' readonly' : '' }}>
                        <option value="">Choose...</option>
                    </select>
                    @error('zone')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <label for="inputBuildingType" class="form-label mt-4">Building Type</label>
                    <select disabled form="payment-form" id="inputBuildingType" name="building_type"
                        class="form-select"
                        building-type-value="{{ request()->get('building_type') ? request()->get('building_type') : old('building_type') }}"
                        {{ request()->get('building_type') ? ' readonly' : '' }}>
                        <option value="">Choose...</option>
                    </select>
                    @error('building_type')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="w-100 flex mobile" href="{{ route('payments.create') }}">
                <button type="submit" id="save-button-mobile" disabled form="payment-form"
                    class="flex btn btn-success w-100" href="">
                    Save
                </button>
            </div>
        </div>
    </div>
    @push('scripts')
        <script src="{{ asset('js/edit-payment.js') }}" defer></script>
    @endpush
</x-app-layout>
