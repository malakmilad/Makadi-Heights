<nav class="sidebar min-h-screen">
    <!-- Logo -->
    <div class="shrink-0 flex items-center">
        <a href="{{ route('dashboard') }}" class="logo w-100 h-20 d-flex align-items-center"
            style="padding: 1rem 2rem">
            <x-application-logo class="block h-10 w-auto fill-current text-gray-600" />
        </a>
    </div>
    <div class="menu-items py-5">
        <ul>
            <li class="header-title">Payments</li>
            <ul class="menu-links py-3">
                <li class="menu-link" href="{{ route('payments') }}">
                    <a href="{{ route('payments') }}" class="w-100 d-block">
                        <svg wid aria-hidden="true" focusable="false" data-prefix="fas" data-icon="circle"
                            class="svg-inline--fa fa-circle fa-w-16 sc-bGqPaL hNgqKA" role="img"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                            <path fill="currentColor"
                                d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8z"></path>
                        </svg>
                        Payments
                    </a>
                </li>
                @can('rates.edit')
                <li class="menu-link" href="{{ route('rates') }}">
                    <a href="{{ route('rates') }}" class="w-100 d-block">
                        <svg wid aria-hidden="true" focusable="false" data-prefix="fas" data-icon="circle"
                            class="svg-inline--fa fa-circle fa-w-16 sc-bGqPaL hNgqKA" role="img"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                            <path fill="currentColor"
                                d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8z"></path>
                        </svg>
                        Rates
                    </a>
                </li>
                @endcan
                @can('faqs.show')
                    <li class="menu-link" href="{{ route('faqs') }}">
                        <a href="{{ route('faqs') }}" class="w-100 d-block">
                            <svg wid aria-hidden="true" focusable="false" data-prefix="fas" data-icon="circle"
                                class="svg-inline--fa fa-circle fa-w-16 sc-bGqPaL hNgqKA" role="img"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                <path fill="currentColor"
                                    d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8z"></path>
                            </svg>
                            FAQs
                        </a>
                    </li>
                @endcan
            </ul>
            @can('users.create')
                <li class="header-title">Users & Accounts</li>
                <ul class="menu-links py-3">
                    <li class="menu-link" href="{{ route('users') }}">
                        <a href="{{ route('users') }}" class="w-100 d-block">
                            <svg wid aria-hidden="true" focusable="false" data-prefix="fas" data-icon="circle"
                                class="svg-inline--fa fa-circle fa-w-16 sc-bGqPaL hNgqKA" role="img"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                <path fill="currentColor"
                                    d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8z"></path>
                            </svg>
                            Users
                        </a>
                    </li>
                </ul>
            @endcan
            @can('roles')
                <li class="header-title">Roles & Permissions</li>
                <ul class="menu-links py-3">
                    <li class="menu-link" href="{{ route('roles') }}">
                        <a href="{{ route('roles') }}" class="w-100 d-block">
                            <svg wid aria-hidden="true" focusable="false" data-prefix="fas" data-icon="circle"
                                class="svg-inline--fa fa-circle fa-w-16 sc-bGqPaL hNgqKA" role="img"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                <path fill="currentColor"
                                    d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8z"></path>
                            </svg>
                            Roles
                        </a>
                    </li>
                </ul>
            @endcan
        </ul>
    </div>
</nav>
