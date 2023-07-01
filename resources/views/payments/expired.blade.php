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
                <h2>Expired Payment</h2>
                <span class="count">{{ $count }} entries found</span>
            </div>
            <div class="clear-both"></div>
        </div>

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
                        Last name
                    </th>
                    <th>
                        Total Unit Price
                    </th>
                    <th>
                        Payment Amount
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
                            {{ $payment->last_name }}
                        </td>
                        <td class="go-to-location">
                            {{ number_format($payment->total_unit_price, 0) }}
                        </td>
                        <td class="go-to-location">
                            {{ number_format($payment->down_payment, 0) }}
                        </td>
                        <td class="go-to-location">
                            {{ $payment->getStatus() }}
                        </td>
                        <td>
                            {{ $payment->user->name }}
                        </td>
                        <td class="flex align-items-center">
                                    <a href="{{ route('restore',$payment->id) }}" style="margin-right: 1rem"
                                        class="button">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-counterclockwise" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2v1z"></path>
                                            <path d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466z"></path>
                                        </svg>
                                    </a>
                                    <button class="button text-danger" data-bs-toggle="modal"
                                        data-bs-target="#modal-{{ $payment->id }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13"
                                            fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                            <path
                                                d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z" />
                                        </svg>
                                    </button>
                        </td>
                    </tr>
                    @can('payments.delete')
                        @include('components.modal', [
                            'id' => 'modal-' . $payment->id . '',
                            'route' => route('force', $payment->id),
                            'message' => 'Are you sure you want to delete this entry?',
                        ])
                    @endcan
                @endforeach
            </tbody>
        </table>
        <div class="pagination-laravel mt-5">
            {{ $payments->links() }}
        </div>
    </div>
</x-app-layout>
