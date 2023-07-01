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
                    User {{ $user->name }}
                </h2>
            </div>
            <div class="pull-right flex btn-payment1 desktop" href="{{ route('payments.create') }}">
                <button disabled id="save-button" type="submit" form="user-form" class="flex btn btn-success"
                    href="">
                    Save
                </button>
            </div>
            <div class="clear-both"></div>
        </div>
        <div class="row mt-5">
            <div class="col-12 col-md-9">
                <div class="card">
                    <form id="user-form" method="POST" action="{{ route('users.update', $user->id) }}" class="row g-3">
                        @csrf
                        @method('put')
                        <div class="col-md-6">
                            <label for="name" class="form-label">{{ __('Name') }}</label>
                            <input id="name" class="block mt-1 w-full form-control" type="text" name="name"
                                value="{{ old('name', $user->name) }}" autofocus />
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">{{ __('Email') }}</label>
                            <input id="email" class="block mt-1 w-full form-control" type="email" name="email"
                                value="{{ old('email', $user->email) }}" />
                            @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="password" class="form-label">{{ __('Password') }}</label>
                            <input id="password" class="block mt-1 w-full form-control" type="password" name="password"
                                autocomplete="new-password" />
                            @error('password')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
                            <input id="password_confirmation" class="block mt-1 w-full form-control" type="password"
                                name="password_confirmation" />
                            @error('password_confirmation')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        @if (Auth::user()->hasRole('makadi-admin') ||
                                Auth::user()->hasRole('super admin') ||
                                Auth::user()->hasRole('makadi-super-admin'))

                            <div class="col-md-6">
                                <label for="role" class="form-label">Role</label>
                                <select name="role" id="role" class="form-control">
                                    <option value="">Choose role..</option>
                                    @foreach ($roles as $role)
                                        <option {{ $user->getRoleNames()[0] == $role ? 'selected' : '' }}
                                            value="{{ $role }}">
                                            {{ $role == 'makadi-admin' ? 'Sales Admin' : $role }}</option>
                                    @endforeach
                                </select>
                                @error('role')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6" id="manager"
                                style="{{ $user->hasRole('sales') ? 'display:block;' : 'display:none' }}">
                                <label for="manager" class="form-label">Manager</label>
                                <select name="manager" class="form-control">
                                    <option value="">Choose manager..</option>
                                    @foreach ($managers as $manager)
                                        <option {{ $user->manager_id == $manager->id ? 'selected' : '' }}
                                            value="{{ $manager->id }}">{{ $manager->name }}</option>
                                    @endforeach
                                </select>
                                @error('manager')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        @elseif(Auth::user()->hasRole('manager'))
                            <input type="hidden" name="role" value="{{ $roles[0] }}">
                            <input type="hidden" name="manager" value="{{ Auth::user()->id }}">
                        @endif
                    </form>
                </div>
            </div>
            <div class="w-100 mobile" href="{{ route('payments.create') }}">
                <button disabled id="save-button-mobile" type="submit" form="user-form"
                    class="flex btn btn-success w-100" href="">
                    Save
                </button>
            </div>
            <div class="col-12 col-md-3">
                <div class="card delete-card ">
                    <button class="transparent-btn text-danger flex" type="button" data-bs-toggle="modal"
                        data-bs-target="#modal-{{ $user->id }}">
                        <svg style="margin-right: 1rem" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                            fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                            <path
                                d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z" />
                        </svg>
                        Delete this entry
                    </button>
                </div>
            </div>
        </div>
        @include('components.modal', [
            'id' => 'modal-' . $user->id . '',
            'route' => route('users.delete', $user->id),
            'message' => 'Are you sure you want to delete this entry?',
        ])
    </div>
    @push('scripts')
        <script src="{{ asset('js/create-users.js') }}" defer></script>
    @endpush
</x-app-layout>
