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
                <h2>Payments</h2>
                <span class="count">{{ $count }} entries found</span>
            </div>
            <div class="pull-right">
                @can('payments.create')
                    <a class="btn pull-right btn-payment1" href="{{ route('units.search.page') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-plus-lg mr-2" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z" />
                        </svg>
                        Create New Payment
                    </a>
                @endcan
                {{-- @can('payments.export')
                    <a class="btn pull-right mr-2 btn-payment2" href="{{ route('payments.export') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-file-earmark-arrow-down mr-3" viewBox="0 0 16 16">
                            <path
                                d="M8.5 6.5a.5.5 0 0 0-1 0v3.793L6.354 9.146a.5.5 0 1 0-.708.708l2 2a.5.5 0 0 0 .708 0l2-2a.5.5 0 0 0-.708-.708L8.5 10.293V6.5z" />
                            <path
                                d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z" />
                        </svg>
                        Export All
                    </a>
                @endcan --}}
            </div>
            {{--  <a class="btn pull-right mr-2" href="{{ route('payments.expired') }}">
                Expired Payment
            </a>  --}}
            <div class="clear-both"></div>

        </div>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            @can('payments.export')
                <button class="nav-link" id="nav-export-tab" data-bs-toggle="tab" data-bs-target="#nav-export"
                    type="button" role="tab" aria-controls="nav-export" aria-selected="true"><svg
                        xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-filetype-csv" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                            d="M14 4.5V14a2 2 0 0 1-2 2h-1v-1h1a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5L14 4.5ZM3.517 14.841a1.13 1.13 0 0 0 .401.823c.13.108.289.192.478.252.19.061.411.091.665.091.338 0 .624-.053.859-.158.236-.105.416-.252.539-.44.125-.189.187-.408.187-.656 0-.224-.045-.41-.134-.56a1.001 1.001 0 0 0-.375-.357 2.027 2.027 0 0 0-.566-.21l-.621-.144a.97.97 0 0 1-.404-.176.37.37 0 0 1-.144-.299c0-.156.062-.284.185-.384.125-.101.296-.152.512-.152.143 0 .266.023.37.068a.624.624 0 0 1 .246.181.56.56 0 0 1 .12.258h.75a1.092 1.092 0 0 0-.2-.566 1.21 1.21 0 0 0-.5-.41 1.813 1.813 0 0 0-.78-.152c-.293 0-.551.05-.776.15-.225.099-.4.24-.527.421-.127.182-.19.395-.19.639 0 .201.04.376.122.524.082.149.2.27.352.367.152.095.332.167.539.213l.618.144c.207.049.361.113.463.193a.387.387 0 0 1 .152.326.505.505 0 0 1-.085.29.559.559 0 0 1-.255.193c-.111.047-.249.07-.413.07-.117 0-.223-.013-.32-.04a.838.838 0 0 1-.248-.115.578.578 0 0 1-.255-.384h-.765ZM.806 13.693c0-.248.034-.46.102-.633a.868.868 0 0 1 .302-.399.814.814 0 0 1 .475-.137c.15 0 .283.032.398.097a.7.7 0 0 1 .272.26.85.85 0 0 1 .12.381h.765v-.072a1.33 1.33 0 0 0-.466-.964 1.441 1.441 0 0 0-.489-.272 1.838 1.838 0 0 0-.606-.097c-.356 0-.66.074-.911.223-.25.148-.44.359-.572.632-.13.274-.196.6-.196.979v.498c0 .379.064.704.193.976.131.271.322.48.572.626.25.145.554.217.914.217.293 0 .554-.055.785-.164.23-.11.414-.26.55-.454a1.27 1.27 0 0 0 .226-.674v-.076h-.764a.799.799 0 0 1-.118.363.7.7 0 0 1-.272.25.874.874 0 0 1-.401.087.845.845 0 0 1-.478-.132.833.833 0 0 1-.299-.392 1.699 1.699 0 0 1-.102-.627v-.495Zm8.239 2.238h-.953l-1.338-3.999h.917l.896 3.138h.038l.888-3.138h.879l-1.327 4Z" />
                    </svg> &nbsp; Export</button>
            @endcan
            <button class="nav-link" id="nav-filters-tab" data-bs-toggle="tab" data-bs-target="#nav-filters"
                type="button" role="tab" aria-controls="nav-profile" aria-selected="false">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                    class="bi bi-filter" viewBox="0 0 16 16">
                    <path
                        d="M6 10.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5z" />
                </svg> Filters</button>
        </div>
        <div class="tab-content" id="nav-tabContent">
            @can('payments.export')
                <div class="tab-pane fade" id="nav-export" role="tabpanel" aria-labelledby="nav-export-tab">
                    <form action="{{ route('payments.export') }}" method="GET" class="row g-3">
                        @csrf
                        <div class="col-md-3">
                            <label for="Date from" class="form-label">Date From</label>
                            <input type="date" name="date_from" class="form-control mb-0">
                        </div>
                        <div class="col-md-3">
                            <label for="Date To" class="form-label">Date to</label>
                            <input type="date" name="date_to" class="form-control mb-0">
                        </div>
                        <div class="col-4">
                            <div class="flex flex-column align-items-start justify-content-end h-100">
                                <button type="submit" class="search-btn p-2">
                                    Export
                                </button>
                            </div>

                        </div>
                    </form>
                </div>
            @endcan
            <div class="tab-pane fade" id="nav-filters" role="tabpanel" aria-labelledby="nav-filters-tab">
                <form action="{{ route('payments-search') }}" method="GET" role="search">
                    <div class="row">
                        <div class="col-8 col-md-7 mb-3">
                            <div class="form-group">
                                <input class="form-control" placeholder="Order number"
                                    value="{{ !is_null(request()->get('id')) ? request()->get('id') : '' }}"
                                    name='id' type="text">
                            </div>
                        </div>
                        <div class="col-8 col-md-7">
                            <div class="form-group">
                                <input class="form-control" placeholder="Unit Unique Reference"
                                    value="{{ !is_null(request()->get('unit_unique_reference')) ? request()->get('unit_unique_reference') : '' }}"
                                    name='unit_unique_reference' type="text">
                            </div>
                        </div>
                        {{-- <div class="col-md-2">
                            <div class="form-group">
                                <input class="form-control" placeholder="Phone number"
                                    value="{{ !is_null(request()->get('mobile')) ? request()->get('mobile') : '' }}"
                                    name='mobile' type="text">
                                &nbsp;
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <input class="form-control" placeholder="Email"
                                    value="{{ !is_null(request()->get('email')) ? request()->get('email') : '' }}"
                                    name='email' type="text">
                                &nbsp;
                            </div>
                        </div> --}}
                        {{-- <div class="col-md-2">
                            <div class="form-group">
                                <input class="form-control" placeholder="Personal ID"
                                    value="{{ !is_null(request()->get('personal_id')) ? request()->get('personal_id') : '' }}"
                                    name='personal_id' type="text">
                                &nbsp;
                            </div>
                        </div> --}}
                        <div class="col-4   ">
                            <div class="flex">
                                <button type="submit" class="search-btn">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                        <path
                                            d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                                    </svg>
                                </button>
                                &nbsp;
                                <a href="{{ route('payments') }}" class="search-btn">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-arrow-counterclockwise" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                            d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2v1z" />
                                        <path
                                            d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466z" />
                                    </svg>
                                </a>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="table-wrapper table-wrapper--payment ">
            <table>
                <thead>
                    <tr>
                        <th>
                            ID
                        </th>
                        <th>
                            First name
                        </th>
                        <th>
                            Unit Reference
                        </th>
                        <th>
                            Total Unit Price
                        </th>
                        <th>
                            Total Paid
                        </th>
                        <th>
                            Status
                        </th>
                        <th>
                            Created By
                        </th>
                        <th>

                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($payments as $payment)
                        <tr class="go-to" location="{{ route('payments.show', $payment) }}">
                            <th class="go-to-location">
                                {{ $payment->id }}
                            </th>
                            <td class="go-to-location">
                                {{ $payment->first_name }}
                            </td>
                            <td class="go-to-location">
                                {{ $payment->unit_unique_reference }}
                            </td>
                            <td class="go-to-location">
                                {{ number_format($payment->total_unit_price, 0) }}
                            </td>
                            <td class="go-to-location">
                                {{number_format($payment->getRemainingUnitAmount()['total_paid'], 0)}}
                            </td>
                            <td class="go-to-location">
                                {{ $payment->getStatus() }}
                            </td>
                            <td>
                                {{ $payment->user->name }}
                            </td>
                            <td class="flex align-items-center">
                                <a href="{{ route('payments.show', $payment) }}" style="margin-right: 1rem"
                                    class="button">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-eyeglasses" viewBox="0 0 16 16">
                                        <path
                                            d="M4 6a2 2 0 1 1 0 4 2 2 0 0 1 0-4zm2.625.547a3 3 0 0 0-5.584.953H.5a.5.5 0 0 0 0 1h.541A3 3 0 0 0 7 8a1 1 0 0 1 2 0 3 3 0 0 0 5.959.5h.541a.5.5 0 0 0 0-1h-.541a3 3 0 0 0-5.584-.953A1.993 1.993 0 0 0 8 6c-.532 0-1.016.208-1.375.547zM14 8a2 2 0 1 1-4 0 2 2 0 0 1 4 0z" />
                                    </svg>
                                </a>
                                @can('payments.edit')
                                    @if ($payment->status != 2)
                                        <a href="{{ route('payments.edit', $payment) }}" style="margin-right: 1rem"
                                            class="button">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                <path
                                                    d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                                <path fill-rule="evenodd"
                                                    d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                                            </svg>
                                        </a>
                                    @endif
                                @endcan
                                @can('payments.delete')
                                    @if ($payment->status != 2)
                                        <button class="button text-danger" data-bs-toggle="modal"
                                            data-bs-target="#modal-{{ $payment->id }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                                                <path
                                                    d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z" />
                                            </svg>
                                        </button>
                                    @endif
                                @endcan

                            </td>
                        </tr>
                        @can('payments.delete')
                            @include('components.modal', [
                                'id' => 'modal-' . $payment->id . '',
                                'route' => route('payments.delete', $payment->id),
                                'message' => 'Are you sure you want to delete this entry?',
                            ])
                        @endcan
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="pagination-laravel mt-5">
            {{ $payments->links() }}
        </div>
    </div>
</x-app-layout>
