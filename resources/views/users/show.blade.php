<x-app-layout>
    <div class="page">
        <div class="header">
            <div class="pull-left">
                <h2>User ({{ $user->name }})</h2>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-12">
                <div class="card">
                    <h3 class="card-header mt-0">
                        Main Information
                    </h3>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="label-field">
                                    <strong>User ID: </strong>
                                </div>
                                <span>
                                    {{ $user->id }}
                                </span>
                                <div class="label-field">
                                    <strong>
                                        Username:
                                    </strong>
                                </div>
                                <span>
                                    {{ $user->name }}
                                </span>

                                <div class="label-field">
                                    <strong>
                                        User Email
                                    </strong>
                                </div>
                                <span>
                                    {{ $user->email }}
                                </span>

                                <div class="label-field">
                                    <strong>
                                        User Role
                                    </strong>
                                </div>
                                <span>
                                    @foreach ($user->getRoleNames() as $role)
                                        {{ $role == 'makadi-admin' ? "Sales Admin" : $role }}
                                    @endforeach
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
