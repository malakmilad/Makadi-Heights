<x-app-layout>
    <div class="page">
        @if (session('status'))
            <div class="alert alert-success fade show" role="alert">
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="header">
            <div class="pull-left">
                <h2>Unit {{ $payment->unit_unique_reference }} | {{ $payment->first_name . ' ' . $payment->last_name }}
                </h2>
            </div>
            <div>
                @can('payments.edit')
                    @if ($payment->status != 2)
                        <div class="pull-right btn-payment2 flex" href="{{ route('payments.create') }}">
                            <form action="{{ route('payments.send', $payment->id) }}" method="post">
                                @csrf
                                <button class="flex btn ">
                                    <svg style="margin-right: 1rem" xmlns="http://www.w3.org/2000/svg" width="16"
                                        height="16" fill="currentColor" class="bi bi-send" viewBox="0 0 16 16">
                                        <path
                                            d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576 6.636 10.07Zm6.787-8.201L1.591 6.602l4.339 2.76 7.494-7.493Z" />
                                    </svg>
                                    Send Payment Link
                                </button>
                            </form>
                        </div>
                    @else
                        <a class="btn pull-right mr-2 btn-payment2" href="{{ route('pdf', $payment->id) }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-file-earmark-arrow-down mr-3" viewBox="0 0 16 16">
                                <path
                                    d="M8.5 6.5a.5.5 0 0 0-1 0v3.793L6.354 9.146a.5.5 0 1 0-.708.708l2 2a.5.5 0 0 0 .708 0l2-2a.5.5 0 0 0-.708-.708L8.5 10.293V6.5z">
                                </path>
                                <path
                                    d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z">
                                </path>
                            </svg>
                            Latest Payment Receipt
                        </a>
                    @endif
                @endcan
                @can('payments.create')
                    <div class="pull-right mr-2 btn-payment2"
                        @if ($payment->status != 2) data-bs-toggle='tooltip' data-bs-placement='bottom' title='Customer must initiate the current pending payment before creating a new payment”' @endif>
                        {{-- <a class="btn {{ $payment->status != 2 ? 'disabled' : '' }}"
                            href="{{ route('payments.create', [
                                'first_name' => $payment->first_name,
                                'last_name' => $payment->last_name,
                                'mobile' => $payment->mobile,
                                'email' => $payment->email,
                                'personal_id' => $payment->personal_id,
                                'unit_unique_reference' => $payment->unit_unique_reference,
                                'total_unit_price' => $payment->total_unit_price,
                                'valid_hours' => $payment->valid_hours,
                                'zone' => $payment->zone,
                                'building_type' => $payment->building_type,
                                'city' => $payment->city,
                                'country' => $payment->country,
                                'building_type_id' => $payment->building_type_id,
                                'building_type' => $payment->building_type,
                                'currency_id' => $payment->currency_id,
                                'address_line_1' => $payment->address_line_1,
                                'address_line_2' => $payment->address_line_2,
                                // 'city'=> $payment->city,
                            ]) }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-plus-lg mr-2" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z" />
                            </svg>
                            Add a New Payment
                        </a> --}}
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item desktop" role="presentation">
                                <a class="nav-link btn {{ $payment->status != 2 ? 'disabled' : '' }} {{ request()->get('add_payments') && $payment->status == 2 ? 'active' : '' }}"
                                    id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab"
                                    aria-controls="home" aria-selected="true">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-plus-lg mr-2" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                            d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z" />
                                    </svg>
                                    Add a New Payment</a>
                            </li>
                            <li class="nav-item mobile" role="presentation">
                                <a class="nav-link btn {{ $payment->status != 2 ? 'disabled' : '' }} {{ request()->get('add_payments') && $payment->status == 2 ? 'active' : '' }}"
                                    id="mobile-add-payment-tab" data-bs-toggle="tab" data-bs-target="#mobile-add-payment"
                                    type="button" role="tab" aria-controls="mobile-add-payment" aria-selected="true">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-plus-lg mr-2" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                            d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z" />
                                    </svg>
                                    Add a New Payment</a>
                            </li>
                        </ul>
                    </div>
                @endcan
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-12 col-md-9 order-mobile-2">
                {{-- @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif --}}
                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="tab-pane {{ request()->get('add_payments') && $payment->status == 2 ? 'active' : '' }}"
                        id="home" role="tabpanel" aria-labelledby="home-tab">
                        <form action="{{ route('payments.store') }}" method="POST">
                            @csrf

                            <input type="hidden" name="first_name" value="{{ $payment->first_name }}">
                            <input type="hidden" name="last_name" value="{{ $payment->last_name }}">
                            <input type="hidden" name="mobile" value="{{ $payment->mobile }}">
                            <input type="hidden" name="email" value="{{ $payment->email }}">
                            <input type="hidden" name="personal_id" value="{{ $payment->personal_id }}">
                            <input type="hidden" name="unit_unique_reference"
                                value="{{ $payment->unit_unique_reference }}">
                            <input type="hidden" name="unit" value="{{ $payment->unit }}">
                            <input type="hidden" name="payment_link" value="{{ $payment->payment_link }}">
                            <input type="hidden" name="total_unit_price" value="{{ $payment->total_unit_price }}">
                            <input type="hidden" name="down_payment" value="{{ $payment->down_payment }}">
                            <input type="hidden" name="valid_hours" value="{{ $payment->valid_hours }}">
                            <input type="hidden" name="zone" value="{{ $payment->zone }}">
                            <input type="hidden" name="building_type" value="{{ $payment->building_type }}">
                            <input type="hidden" name="address_line_1" value="{{ $payment->address_line_1 }}">
                            <input type="hidden" name="address_line_2" value="{{ $payment->address_line_2 }}">
                            <input type="hidden" name="city" value="{{ $payment->city }}">
                            <input type="hidden" name="country" value="{{ $payment->country }}">
                            <input type="hidden" name="hashed" value="{{ $payment->hashed }}">
                            <input type="hidden" name="user_id" value="{{ $payment->user_id }}">
                            <input type="hidden" name="unit_id" value="{{ $payment->unit_id }}">
                            <input type="hidden" name="building_type_id" value="{{ $payment->building_type_id }}">

                            <label for="downPayment" class="form-label"> <b>
                                    Payment Amount
                                </b></label>
                            <div class="input-group">
                                <input type="number" name="down_payment" class="form-control" id="downPayment">
                                <div class="input-group-text">EGP</div>
                            </div>
                            <button class="btn btn-success my-3" id="save-button" disabled type="submit">
                                Add Payment
                            </button>
                            @error('down_payment')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </form>
                    </div>
                </div>
                <div class="card">
                    <h3 class="card-header">
                        Customer Information
                    </h3>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="label-field">
                                    <strong>
                                        First Name:
                                    </strong>
                                    <span>
                                        {{ $payment->first_name }}
                                    </span>
                                </div>
                                <div class="label-field">
                                    <strong>
                                        Last Name:
                                    </strong>
                                    <span>
                                        {{ $payment->last_name }}
                                    </span>
                                </div>
                                <div class="label-field">
                                    <strong>
                                        City:
                                    </strong>
                                    <span>
                                        {{ $payment->city }}
                                    </span>
                                </div>
                                <div class="label-field">
                                    <strong>
                                        Country:
                                    </strong>
                                    <span>
                                        {{ $payment->country }}
                                    </span>
                                </div>
                                {{-- </div> --}}
                            </div>
                            <div class="col-md-2"></div>
                            <div class="col-md-5">
                                <div class="label-field">
                                    <strong>
                                        Personal ID:
                                    </strong>
                                    <span>
                                        {{ $payment->personal_id }}
                                    </span>
                                </div>
                                <div class="label-field">
                                    <strong>
                                        Address Line 1:
                                    </strong>
                                    <span>
                                        {{ $payment->address_line_1 }}
                                    </span>
                                </div>
                                <div class="label-field">
                                    <strong>
                                        Address Line 2:
                                    </strong>
                                    <span>
                                        {{ $payment->address_line_2 }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <h3 class="card-header mt-5">
                        Unit Information
                    </h3>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="label-field">
                                    <strong>
                                        Total Unit Price:
                                    </strong>
                                    <span>
                                        {{ number_format($payment->total_unit_price,0) }} EGP
                                    </span>
                                </div>
                                <div class="label-field">
                                    <strong>Unit Unique Reference: </strong>
                                    <span>
                                        {{ $payment->unit_unique_reference }}
                                    </span>
                                </div>
                                {{-- <div class="label-field">
                                    <strong>
                                        Unit:
                                    </strong>
                                    <span>
                                        {{ $payment->unit }}
                                    </span>
                                </div> --}}

                                <div class="label-field">
                                    <strong>
                                        Building Type:
                                    </strong>
                                    <span>
                                        {{ $payment->building_type }}
                                    </span>
                                </div>
                                <div class="label-field">
                                    <strong>
                                        Zone:
                                    </strong>
                                    <span>
                                        {{ $payment->zone }}
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-2"></div>
                            <div class="col-md-5">
                                <div class="label-field">
                                    <strong>
                                        Remaining Unit Amount:
                                    </strong>
                                    <span>
                                        {{ number_format($payment->getRemainingUnitAmount()['remaining_unit_amount'],0) }}
                                        EGP
                                    </span>
                                </div>
                                <div class="label-field">
                                    <strong>
                                        Total Paid:
                                    </strong>
                                    <span>
                                        {{ number_format($payment->getRemainingUnitAmount()['total_paid'],0) }} EGP
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if ($payment->status == 0)
                    <div class="card">
                        <h3 class="card-header mt-5">
                            Pending Payment Information ({{ $payment->id }})
                        </h3>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="label-field">
                                        <strong>Payment ID: </strong>
                                        <span>
                                            <b>
                                                {{ $payment->id }}
                                            </b>
                                        </span>
                                    </div>
                                    <div class="label-field">
                                        <strong>
                                            Payment Time:
                                        </strong>
                                        <span>
                                            {{ \Carbon\Carbon::parse($payment->updated_at)->format('h:i:s A') }}
                                        </span>
                                    </div>
                                    <div class="label-field">
                                        <strong>
                                            Valid Hours:
                                        </strong>
                                        <span>
                                            {{ $payment->valid_hours }}
                                        </span>
                                    </div>
                                    <div class="label-field">
                                        <strong>
                                            Payment Status:
                                        </strong>
                                        <span>
                                            {{ $payment->getStatus() }}
                                        </span>
                                    </div>
                                    @if (isset($payment->payment_link))
                                        <div class="label-field">
                                            <strong>
                                                Payment Link:
                                            </strong>
                                        </div>
                                        <span>
                                            {{ $payment->payment_link }}
                                        </span>
                                    @endif
                                </div>
                                <div class="col-md-2"></div>
                                <div class="col-md-5">
                                    @if ($payment->status == 2)
                                        <div class="label-field">
                                            <strong>
                                                Payment Date:
                                            </strong>
                                            <span>
                                                {{ \Carbon\Carbon::parse($payment->updated_at)->toFormattedDateString() }}
                                            </span>
                                        </div>
                                        <div class="label-field">
                                            <strong>
                                                Payment Time:
                                            </strong>
                                            <span>
                                                {{ \Carbon\Carbon::parse($payment->updated_at)->format('h:i:s A') }}
                                            </span>
                                        </div>
                                    @endif
                                    <div class="label-field">
                                        <strong>
                                            Payment Amount:
                                        </strong>
                                        <span>
                                            {{ number_format($payment->down_payment, 0) }} EGP
                                        </span>
                                    </div>
                                    @if ($payment->status == 2)
                                        <div class="label-field">
                                            <strong>
                                                Amount Paid:
                                            </strong>
                                            <span>
                                                {{ $payment->total_paid ? number_format($payment->total_paid, 0) : number_format($payment->down_payment / $payment->currency->rate, 0) }}
                                                {{ $payment->currency->currency }}
                                            </span>
                                        </div>
                                        @if ($payment->transaction_id)
                                            <div class="label-field">
                                                <strong>
                                                    Transaction ID:
                                                </strong>
                                                <span>
                                                    {{ $payment->transaction_id }}
                                                </span>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if (count($related_payments) > 0)
                    <div class="card">
                        <h3 class="card-header mt-5">
                            Past Payments
                        </h3>
                        <div class="card-body">
                            @if (count($related_payments) > 0)
                                @foreach ($related_payments as $related_payment)
                                    @if ($related_payment->status != 0)
                                        <div class="flex align-items-center justify-content-between mt-5">
                                            <h4>
                                                Payment ID: {{ $related_payment->id }}
                                            </h4>
                                            <a class="btn small-btn" href="{{ route('pdf', $related_payment->id) }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-file-earmark-arrow-down"
                                                    viewBox="0 0 16 16">
                                                    <path
                                                        d="M8.5 6.5a.5.5 0 0 0-1 0v3.793L6.354 9.146a.5.5 0 1 0-.708.708l2 2a.5.5 0 0 0 .708 0l2-2a.5.5 0 0 0-.708-.708L8.5 10.293V6.5z">
                                                    </path>
                                                    <path
                                                        d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z">
                                                    </path>
                                                </svg>
                                                &nbsp;
                                                Download Receipt 
                                            </a>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <div class="label-field">
                                                        <strong>
                                                            Valid Hours:
                                                        </strong>
                                                        <span>
                                                            {{ $related_payment->valid_hours }}
                                                        </span>
                                                    </div>
                                                    <div class="label-field">
                                                        <strong>
                                                            Payment Status:
                                                        </strong>
                                                        <span>
                                                            {{ $related_payment->getStatus() }}
                                                        </span>
                                                    </div>
                                                    <div class="label-field">
                                                        <strong>
                                                            Payment Amount:
                                                        </strong>
                                                        <span>
                                                            {{ number_format($related_payment->down_payment, 0) }} EGP
                                                        </span>
                                                    </div>
                                                    @if (isset($related_payment->payment_link))
                                                        <div class="label-field">
                                                            <strong>
                                                                Payment Link:
                                                            </strong>
                                                        </div>
                                                        <span>
                                                            {{ $related_payment->payment_link }}
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="col-md-2"></div>
                                                <div class="col-md-5">
                                                    <div class="label-field">
                                                        <strong>
                                                            Payment Date:
                                                        </strong>
                                                        <span>
                                                            {{ \Carbon\Carbon::parse($related_payment->updated_at)->toFormattedDateString() }}
                                                        </span>
                                                    </div>
                                                    <div class="label-field">
                                                        <strong>
                                                            Payment Time:
                                                        </strong>
                                                        <span>
                                                            {{ \Carbon\Carbon::parse($related_payment->updated_at)->format('h:i:s A') }}
                                                        </span>
                                                    </div>
                                                    @if ($related_payment->status == 2)
                                                        <div class="label-field">
                                                            <strong>
                                                                Amount Paid:
                                                            </strong>
                                                            <span>
                                                                {{ $related_payment->total_paid ? number_format($related_payment->total_paid, 0) : number_format($related_payment->down_payment / $related_payment->currency->rate, 0) }}
                                                                {{ $related_payment->currency->currency }}
                                                            </span>
                                                        </div>
                                                        @if ($related_payment->transaction_id)
                                                            <div class="label-field">
                                                                <strong>
                                                                    Transaction ID:
                                                                </strong>
                                                                <span>
                                                                    {{ $related_payment->transaction_id }}
                                                                </span>
                                                            </div>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                    @else
                                        No past payments available
                                    @endif
                                @endforeach
                            @else
                                No past payments available
                            @endif
                        </div>
                    </div>
                @endif

            </div>
            <div class="col-12 col-md-3 order-mobile-1">
                <div class="tab-content mobile">
                    <div class="tab-pane {{ request()->get('add_payments') && $payment->status == 2 ? 'active' : '' }}"
                        id="mobile-add-payment" role="tabpanel" aria-labelledby="mobile-add-payment-tab">
                        <form action="{{ route('payments.store') }}" method="POST">
                            @csrf

                            <input type="hidden" name="first_name" value="{{ $payment->first_name }}">
                            <input type="hidden" name="last_name" value="{{ $payment->last_name }}">
                            <input type="hidden" name="mobile" value="{{ $payment->mobile }}">
                            <input type="hidden" name="email" value="{{ $payment->email }}">
                            <input type="hidden" name="personal_id" value="{{ $payment->personal_id }}">
                            <input type="hidden" name="unit_unique_reference"
                                value="{{ $payment->unit_unique_reference }}">
                            <input type="hidden" name="unit" value="{{ $payment->unit }}">
                            <input type="hidden" name="payment_link" value="{{ $payment->payment_link }}">
                            <input type="hidden" name="total_unit_price" value="{{ $payment->total_unit_price }}">
                            <input type="hidden" name="down_payment" value="{{ $payment->down_payment }}">
                            <input type="hidden" name="valid_hours" value="{{ $payment->valid_hours }}">
                            <input type="hidden" name="zone" value="{{ $payment->zone }}">
                            <input type="hidden" name="building_type" value="{{ $payment->building_type }}">
                            <input type="hidden" name="address_line_1" value="{{ $payment->address_line_1 }}">
                            <input type="hidden" name="address_line_2" value="{{ $payment->address_line_2 }}">
                            <input type="hidden" name="city" value="{{ $payment->city }}">
                            <input type="hidden" name="country" value="{{ $payment->country }}">
                            <input type="hidden" name="hashed" value="{{ $payment->hashed }}">
                            <input type="hidden" name="user_id" value="{{ $payment->user_id }}">
                            <input type="hidden" name="unit_id" value="{{ $payment->unit_id }}">
                            <input type="hidden" name="building_type_id" value="{{ $payment->building_type_id }}">

                            <label for="downPayment" class="form-label"> <b>
                                    Payment Amount</b></label>
                            <div class="input-group">
                                <input type="number" name="down_payment" class="form-control" id="downPayment">
                                <div class="input-group-text">EGP</div>
                            </div>
                            <button class="btn btn-success my-3" id="save-button-mobile" disabled type="submit">
                                Add Payment
                            </button>
                            @error('down_payment')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </form>
                    </div>
                </div>
                <div class="card">
                    <div class="payment-status mb-5">
                        <h3>
                            Current Status
                        </h3>
                        @if ($payment->status == \App\Models\Payment::PENDING)
                            <div class="status bg-light">
                                PENDING
                            </div>
                        @elseif($payment->status == \App\Models\Payment::FAILED)
                            <div class="status bg-danger">
                                FAILED
                            </div>
                        @else
                            <div class="status text-success">
                                <img width="30px" src="{{ asset('icons/green-tick.svg') }}" alt=""
                                    srcset="">
                                PAID
                            </div>
                        @endif
                    </div>
                </div>
                <div class="card mt-3">
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
            </div>
        </div>
    </div>
</x-app-layout>
