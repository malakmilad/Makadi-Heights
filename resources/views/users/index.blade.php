<x-app-layout>
    <div class="page">
        @if (session('status'))
            <div class="alert alert-success fade show" role="alert">
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="header custom-header">
            <div class="pull-left">
                <h2>Users</h2>
                <span class="count">{{ $count }} entries found</span>
            </div>
            @can('payments.create')
                <a class="btn pull-right" href="{{ route('users.create') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-plus-lg mr-2" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                            d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z" />
                    </svg>
                    Create New User Account
                </a>
            @endcan
        </div>
        <br>
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th style="width: 90px">
                            ID
                        </th>
                        <th style="width: 150px">
                            Username
                        </th>
                        <th>
                            Email
                        </th>
                        <th style="width: 150px">
                            Role(s)
                        </th>
                        <th style="width: 150px">
                            Manager
                        </th>
                        <th style="width: 100px">

                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr class="go-to" location="{{ route('users.show', $user->id) }}">
                            <th class="go-to-location">
                                {{ $user->id }}
                            </th>
                            <td class="go-to-location">
                                {{ $user->name }}
                            </td>
                            <td class="go-to-location">
                                {{ $user->email }}
                            </td>
                            <td class="go-to-location">
                                @foreach ($user->getRoleNames() as $item)
                                    {{ $item == 'makadi-admin' ? 'Sales Admin' : $item }}
                                @endforeach
                            </td>
                            <td>
                                @if ($user->parentUser)
                                    {{ $user->parentUser->name }}
                                @endif
                            </td>
                            <td class="flex align-items-center">
                                <a href="{{ route('users.show', $user->id) }}" style="margin-right: 1rem"
                                    class="button">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-eyeglasses" viewBox="0 0 16 16">
                                        <path
                                            d="M4 6a2 2 0 1 1 0 4 2 2 0 0 1 0-4zm2.625.547a3 3 0 0 0-5.584.953H.5a.5.5 0 0 0 0 1h.541A3 3 0 0 0 7 8a1 1 0 0 1 2 0 3 3 0 0 0 5.959.5h.541a.5.5 0 0 0 0-1h-.541a3 3 0 0 0-5.584-.953A1.993 1.993 0 0 0 8 6c-.532 0-1.016.208-1.375.547zM14 8a2 2 0 1 1-4 0 2 2 0 0 1 4 0z" />
                                    </svg>
                                </a>
                                {{-- @if (!$user->hasRole('finance')) --}}
                                @can('users.create')
                                    <a href="{{ route('users.edit', $user->id) }}" style="margin-right: 1rem"
                                        class="button">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13"
                                            fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                            <path
                                                d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z" />
                                        </svg>
                                    </a>
                                @endcan
                                @can('users.create')
                                    @if (Auth::user()->id != $user->id)
                                        <button class="button text-danger" data-bs-toggle="modal"
                                            data-bs-target="#modal-{{ $user->id }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13"
                                                fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                                <path
                                                    d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z" />
                                            </svg>
                                        </button>
                                    @endif
                                @endcan
                                {{-- @endif --}}
                            </td>
                        </tr>
                        @can('users.create')
                            @include('components.modal', [
                                'id' => 'modal-' . $user->id . '',
                                'route' => route('users.delete', $user->id),
                                'message' => 'Are you sure you want to delete this entry?',
                            ])
                        @endcan
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
