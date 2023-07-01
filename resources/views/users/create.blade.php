<x-app-layout>
    <div class="page">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
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
        <div class="header">
            <div class="pull-left">
                <h2>Create new User</h2>
            </div>
            <div class="pull-right btn-payment1 flex">
                <button type="submit" id="save-button" disabled form="user-form" class="flex btn btn-success"
                    href="">
                    Save
                </button>
            </div>
            <div class="clear-both"></div>
        </div>
        <!-- Validation Errors -->
        {{-- <x-auth-validation-errors class="mb-4" :errors="$errors" /> --}}
        <div class="row mt-5">
            <div class="col-12 col-md-9">
                <div class="card">
                    <form class="row g-3" id="user-form" method="POST" action="{{ route('users.store') }}">
                        @csrf
                        <div class="col-md-6">
                            <label for="name" class="form-label">{{ __('Name') }}</label>
                            <input id="name" class="block mt-1 w-full form-control" type="text" name="name"
                                value="{{ old('name') }}" autofocus />
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">{{ __('Email') }}</label>
                            <input id="email" class="block mt-1 w-full form-control" type="email" name="email"
                                value="{{ old('email') }}" />
                            @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="password" class="form-label">{{ __('Password') }}</label>
                            <div class="relative">
                                <input id="password" class="block mt-1 w-full form-control" type="password"
                                    name="password" autocomplete="new-password" />
                                <div class="show-password" data-show-password="password">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                        <path
                                            d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z" />
                                        <path
                                            d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z" />
                                    </svg>
                                </div>
                            </div>
                            @error('password')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
                            <div class="relative">
                                <input id="password_confirmation" class="block mt-1 w-full form-control" type="password"
                                    name="password_confirmation" />
                                <div class="show-password" data-show-password="password_confirmation">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                        <path
                                            d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z" />
                                        <path
                                            d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z" />
                                    </svg>
                                </div>
                            </div>
                            @error('password_confirmation')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        @if (Auth::user()->hasRole('manager'))
                            <input type="hidden" name="role" value="{{ $roles[0] }}">
                            <input type="hidden" name="manager" value="{{ Auth::user()->id }}">
                        @else
                            <div class="col-md-6">
                                <label for="role" class="form-label">Role</label>
                                <select name="role" id="role" class="form-control">
                                    <option value="">Choose role..</option>
                                    @foreach ($roles as $role)
                                        <option {{ old('role') == $role ? 'selected' : '' }}
                                            value="{{ $role }}">{{ $role == 'makadi-admin' ? "Sales Admin" : $role }}</option>
                                    @endforeach
                                </select>
                                @error('role')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6" id="manager"
                                style="{{ old('role') == 'sales' ? 'display:block;' : 'display:none' }}">
                                <label for="manager" class="form-label">Manager</label>
                                <select name="manager" class="form-control">
                                    <option value="">Choose manager..</option>
                                    @foreach ($managers as $manager)
                                        <option {{ old('manager') == $manager ? 'selected' : '' }}
                                            value="{{ $manager->id }}">{{ $manager->name }}</option>
                                    @endforeach
                                </select>
                                @error('manager')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script src="{{ asset('js/create-users.js') }}" defer></script>
    @endpush
</x-app-layout>
