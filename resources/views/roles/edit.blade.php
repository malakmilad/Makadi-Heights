<x-app-layout>
    <div class="page">
        @if (session('status'))
            <div class="alert alert-success fade show" role="alert">
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="header" id="buttons-to-top">
            <div class="pull-left mb-2">
                <h2>
                    Role ({{ $role->name }})
                </h2>
            </div>
            <div class="pull-right flex desktop">
                <button disabled id="save-button" type="submit" form="role-form" class="flex btn btn-success"
                    href="">
                    Save
                </button>
            </div>
            <div class="clear-both"></div>
        </div>
        <div class="row mt-5">
            <div class="col-12 col-md-9">
                <form id="role-form" method="POST" action="{{ route('roles.update', $role->id) }}" class="row g-3">
                    @csrf
                    @method('put')
                    <div class="card">
                        <div class="col-md-12">
                            <label for="name" class="form-label">{{ __('Name') }}</label>
                            <input id="name" disabled class="block mt-1 w-full form-control" type="text" name="name"
                                value="{{ old('name', $role->name) }}" autofocus />
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="card mt-3 permissions">
                        <div class="col-md-12">
                            <div class="accordion roles" id="accordionPanelsStayOpenExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true"
                                            aria-controls="panelsStayOpen-collapseOne">
                                            <span>

                                                Payments
                                            </span>
                                            <div class="pull-right">
                                                <input type="checkbox" class="select-all"
                                                    target="panelsStayOpen-collapseOne" id="select-all-payments">
                                                <label for="select-all-payments">Select all</label>
                                            </div>
                                        </button>
                                    </h2>
                                    <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse"
                                        aria-labelledby="panelsStayOpen-headingOne">
                                        <div class="accordion-body">
                                            @foreach ($payment_permissions as $permission)
                                                <div class="permissions-wrapper">
                                                    <input type="checkbox" name="permission[{{ $permission->name }}]"
                                                        value="{{ $permission->name }}"
                                                        id="permission-{{ $permission->id }}"
                                                        {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}>
                                                    <label
                                                        for="permission-{{ $permission->id }}">{{ str_replace('payments.', '', $permission->name) }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="true"
                                            aria-controls="panelsStayOpen-collapseTwo">
                                            FAQs
                                            <div class="pull-right">
                                                <input type="checkbox" class="select-all"
                                                    target="panelsStayOpen-collapseTwo" id="select-all-faqs">
                                                <label for="select-all-faqs">Select all</label>
                                            </div>
                                        </button>
                                    </h2>
                                    <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse"
                                        aria-labelledby="panelsStayOpen-headingTwo">
                                        <div class="accordion-body">
                                            @foreach ($faqs_permissions as $permission)
                                                <div class="permissions-wrapper">
                                                    <input type="checkbox" name="permission[{{ $permission->name }}]"
                                                        value="{{ $permission->name }}"
                                                        id="permission-{{ $permission->id }}"
                                                        {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}>
                                                    <label
                                                        for="permission-{{ $permission->id }}">{{ str_replace('faqs.', '', $permission->name) }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="true"
                                            aria-controls="panelsStayOpen-collapseThree">
                                            Users
                                            <div class="pull-right">
                                                <input type="checkbox" class="select-all"
                                                    target="panelsStayOpen-collapseThree" id="select-all-users">
                                                <label for="select-all-users">Select all</label>
                                            </div>
                                        </button>
                                    </h2>
                                    <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse"
                                        aria-labelledby="panelsStayOpen-headingThree">
                                        <div class="accordion-body">
                                            @foreach ($users_permissions as $permission)
                                                <div class="permissions-wrapper">
                                                    <input type="checkbox" name="permission[{{ $permission->name }}]"
                                                        value="{{ $permission->name }}"
                                                        id="permission-{{ $permission->id }}"
                                                        {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}>
                                                    <label
                                                        for="permission-{{ $permission->id }}">{{ str_replace('users.', '', $permission->name) }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#panelsStayOpen-collapseFour" aria-expanded="true"
                                            aria-controls="panelsStayOpen-collapseFour">
                                            Rates
                                            <div class="pull-right">
                                                <input type="checkbox" class="select-all"
                                                    target="panelsStayOpen-collapseFour" id="select-all-rates">
                                                <label for="select-all-rates">Select all</label>
                                            </div>
                                        </button>
                                    </h2>
                                    <div id="panelsStayOpen-collapseFour" class="accordion-collapse collapse"
                                        aria-labelledby="panelsStayOpen-headingThree">
                                        <div class="accordion-body">
                                            @foreach ($rates_permissions as $permission)
                                                <div class="permissions-wrapper">
                                                    <input type="checkbox" name="permission[{{ $permission->name }}]"
                                                        value="{{ $permission->name }}"
                                                        id="permission-{{ $permission->id }}"
                                                        {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}>
                                                    <label
                                                        for="permission-{{ $permission->id }}">{{ str_replace('rates.', '', $permission->name) }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="mobile w-100">
                <button disabled id="save-button-mobile" type="submit" form="role-form"
                    class="flex btn btn-success w-100" href="">
                    Save
                </button>
            </div>
            <div class="col-12 col-md-3">
                <div class="card delete-card ">
                    <button class="transparent-btn text-danger flex" type="button" data-bs-toggle="modal"
                        data-bs-target="#modal-{{ $role->id }}">
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
            'id' => 'modal-' . $role->id . '',
            'route' => route('roles.delete', $role->id),
            'message' => 'Are you sure you want to delete this entry?',
        ])
    </div>
</x-app-layout>
