<x-app-layout>
    <style>
        .iti.iti--allow-dropdown {
            display: none
        }
    </style>
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
                    Payment {{ $payment->id }}
                </h2>
            </div>
            <div class="pull-right flex" href="{{ route('payments.create') }}">
                <form action="{{ route('payments.send', $payment->id) }}" method="post">
                    @csrf
                    <button class="flex btn mr-2">
                        <svg style="margin-right: 1rem" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                            fill="currentColor" class="bi bi-send" viewBox="0 0 16 16">
                            <path
                                d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576 6.636 10.07Zm6.787-8.201L1.591 6.602l4.339 2.76 7.494-7.493Z" />
                        </svg>
                        Send Payment Link
                    </button>
                </form>
                <button disabled id="save-button" type="submit" form="payment-form"
                    class="flex btn btn-success desktop" href="">
                    Save
                </button>
            </div>
            <div class="clear-both"></div>
        </div>
        <div class="row mt-5">
            <div class="col-12 col-md-9">
                <div class="card">
                    <form id="payment-form" method="POST" action="{{ route('payments.update', $payment->id) }}"
                        class="row g-3">
                        @csrf
                        @method('put')
                        {{-- <input type="hidden" name="unit_id" id="inputUnitId" value="{{ $payment->unit_id }}"> --}}
                        <input type="hidden" name="building_type_id" id="inputBuildingTypeId"
                            value="{{ $payment->building_type_id }}">
                        <div class="col-md-6">
                            <label for="inputFirstName" class="form-label">First Name</label>
                            <input type="text" {{ $has_past_payments_paid ? 'disabled' : '' }}
                                value="{{ old('first_name', $payment->first_name) }}" name="first_name"
                                class="form-control" id="inputFirstName">
                            @error('first_name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="inputLastName" class="form-label">Last Name</label>
                            <input type="text" {{ $has_past_payments_paid ? 'disabled' : '' }}
                                value="{{ old('last_name', $payment->last_name) }}" name="last_name"
                                class="form-control" id="inputLastName">
                            @error('last_name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <input style="display: none" {{ $has_past_payments_paid ? 'disabled' : '' }} type="hidden"
                            value="{{ old('mobile', $payment->mobile) }}" name="mobile" class="form-control"
                            id="inputPhoneNumber" placeholder="0100000000">
                        {{-- <div class="col-12 col-md-6">
                            <label for="inputPhoneNumber" class="form-label">Phone number</label>
                            <input type="text" value="{{ old('mobile', $payment->mobile) }}" name="mobile"
                                class="form-control" id="inputPhoneNumber" placeholder="0100000000">
                            @error('mobile')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="inputEmail" class="form-label">Email</label>
                            <div class="input-group">
                                <div class="input-group-text">@</div>
                                <input type="email" value="{{ old('email', $payment->email) }}" name="email"
                                    class="form-control" id="inputEmail" placeholder="johndoe@example.com">
                            </div>
                            @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div> --}}
                        <div class="col-md-6">
                            <label for="inputPersonalID" class="form-label">Personal ID</label>
                            <input type="text" {{ $has_past_payments_paid ? 'disabled' : '' }}
                                value="{{ old('personal_id', $payment->personal_id) }}" name="personal_id"
                                class="form-control" id="inputPersonalID">
                            @error('personal_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="inputUniqueReference" class="form-label">Unit Unique Reference</label>
                            <input type="text" {{ $has_past_payments_paid ? 'disabled' : '' }}
                                value="{{ old('unit_unique_reference', $payment->unit_unique_reference) }}"
                                name="unit_unique_reference" class="form-control" id="inputUniqueReference">
                            @error('unit_unique_reference')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="totalPrice" class="form-label">Total Unit Price</label>
                            <input {{ $has_past_payments_paid ? 'disabled' : '' }} type="number"
                                value="{{ old('total_unit_price', $payment->total_unit_price) }}"
                                name="total_unit_price" class="form-control" id="totalPrice">
                            @error('total_unit_price')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="downPayment" class="form-label">Payment Amount</label>
                            <input type="number" value="{{ old('down_payment', $payment->down_payment) }}"
                                name="down_payment" class="form-control" id="downPayment">
                            @error('down_payment')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="validHours" class="form-label">Valid Hours</label>
                            <input type="number" max="5" min="2"
                                value="{{ old('valid_hours', $payment->valid_hours) }}" name="valid_hours"
                                class="form-control" id="validHours">
                            @error('valid_hours')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="inputAddress" class="form-label">Address</label>
                            <input type="text" {{ $has_past_payments_paid ? 'disabled' : '' }}
                                value="{{ old('address_line_1', $payment->address_line_1) }}" name="address_line_1"
                                class="form-control" id="inputAddress" placeholder="1234 Main St">
                            @error('address_line_1')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="inputAddress2" class="form-label">Address 2</label>
                            <input type="text" {{ $has_past_payments_paid ? 'disabled' : '' }}
                                value="{{ old('address_line_2', $payment->address_line_2) }}" name="address_line_2"
                                class="form-control" id="inputAddress2" placeholder="Apartment, studio, or floor">
                            @error('address_line_2')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="inputCity" class="form-label">City</label>
                            <input type="text" {{ $has_past_payments_paid ? 'disabled' : '' }}
                                value="{{ old('city', $payment->city) }}" name="city" class="form-control"
                                id="inputCity">
                            @error('city')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="inputState" class="form-label">Country</label>
                            <input type="text" {{ $has_past_payments_paid ? 'disabled' : '' }}
                                value="{{ old('country', $payment->country) }}" name="country" class="form-control"
                                id="inputState">
                            @error('country')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        @if (Auth::user()->hasRole('makadi-admin') ||
                                Auth::user()->hasRole('super admin') ||
                                Auth::user()->hasRole('makadi-super-admin'))
                            <div class="col-md-6">
                                <label for="behalf" class="form-label">On Behalf Of:</label>
                                <select name="user_id" {{ $has_past_payments_paid ? 'disabled' : '' }} id="behalf"
                                    class="form-select">
                                    <option value="" selected>Choose...</option>
                                    @foreach ($users as $user)
                                        <option {{ $payment->user_id == $user->id ? 'selected' : '' }}
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
                <div class="card">
                    <h3>Information</h3>
                    <div class="update-by">
                        <span>Last Update</span>
                        <span>{{ \Carbon\Carbon::parse($payment->updated_at)->diffForHumans() }}</span>
                    </div>

                    <div class="update-by">
                        <span>By</span>
                        <span>{{ $payment->user->name }}</span>
                    </div>
                </div>
                <div class="card mt-5">
                    <div id="loader-select">
                        <div class="lds-ring">
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                        </div>
                    </div>
                    <label for="inputZone" class="form-label">Zone</label>
                    <select {{ $has_past_payments_paid ? 'cannot_be_changed' : '' }} form="payment-form"
                        name="zone" id="inputZone" class="form-select" zone-value="{{ $payment->zone }}">
                        <option value="">Choose...</option>
                    </select>
                    @error('zone')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <label for="inputBuildingType" class="form-label mt-4">Building Type</label>
                    <select {{ $has_past_payments_paid ? 'cannot_be_changed' : '' }} form="payment-form"
                        id="inputBuildingType" name="building_type" class="form-select"
                        building-type-value="{{ $payment->building_type }}">
                        <option value="">Choose...</option>
                    </select>
                    @error('building_type')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <button disabled id="save-button-mobile" type="submit" form="payment-form"
                        class="flex btn btn-success mobile w-100" href="">
                        Save
                    </button>
                </div>
                <div class="card delete-card mt-5">
                    <button class="transparent-btn text-danger flex" type="button" data-bs-toggle="modal"
                        data-bs-target="#modal-{{ $payment->id }}">
                        <svg style="margin-right: 1rem" xmlns="http://www.w3.org/2000/svg" width="16"
                            height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                            <path
                                d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z" />
                        </svg>
                        Delete this entry
                    </button>
                </div>
            </div>
        </div>
        @include('components.modal', [
            'id' => 'modal-' . $payment->id . '',
            'route' => route('payments.delete', $payment->id),
            'message' => 'Are you sure you want to delete this entry?',
        ])
    </div>
    @push('scripts')
        <script src="{{ asset('js/edit-payment.js') }}" defer></script>
    @endpush
</x-app-layout>
