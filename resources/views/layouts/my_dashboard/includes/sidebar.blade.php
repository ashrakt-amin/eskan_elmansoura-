<input type="checkbox" name="" id="nav-toggle">
<div class="sidebar">
    <div class="sidebar-brand">
        <h3>
            <span class=" ">
                <img class="icon eskan-icon" src="{{ asset('my_dashboard\icons\Eskan-logo.png') }}" alt="">
            </span>
            <span class=" sidebar-li-text">
                {{-- @if (Auth::user()->name)
                <span class="ml-3"><a href="{{ route('users.show', ['user'=>Auth::user()->id]) }}" class="text-warning">{{ Auth::user()->last_name }}</a></span>
                @endif --}}
            </span>
        </h3>
    </div>

    <div class="sidebar-menu">
        <ul>
            <li>
                <a href="{{ route('index') }}" class=" {{ Request::is('index') ? 'active' : '' }} ">
                    <span class=" ">
                        <img class="icon" src="{{ asset('my_dashboard\icons\home.png') }}" alt="">
                    </span>
                    <span class=" sidebar-li-text">الرئيسية</span>
                </a>
            </li>
            <li>
                <a href="{{ route('main_projectsIndex') }}" class=" {{ Request::is('main_projectsIndex') ? 'active' : '' }} ">
                    <span class=" ">
                        <img class="icon" src="{{ asset('my_dashboard\icons\building.png') }}" alt="">
                    </span>
                    <span class=" sidebar-li-text">المشاريع</span>
                </a>
            </li>
            @if (Auth::user()->privilege_id == (1 || 2 || 3))
            <li>
                <a href="{{ route('customerIndex') }}" class="{{ Request::is('customerIndex') ? 'active' : '' }} ">
                    <span class=" ">
                        <img class="icon" src="{{ asset('my_dashboard\icons\customer.png') }}" alt="">
                    </span>
                    <span class=" sidebar-li-text">العملاء</span>
                </a>
            </li>
            @endif

            @if (Auth::user()->privilege_id == (1 || 2))
            <li>
                <a href="{{ route('paymentsIndex') }}" class="{{ Request::is('paymentsIndex') ? 'active' : '' }} ">
                    <span class=" ">
                        <img class="icon" src="{{ asset('my_dashboard\icons\bars.png') }}" alt="">
                    </span>
                    <span class=" sidebar-li-text">الحسابات</span>

                </a>
            </li>
            @endif

            {{-- @if (Auth::user()->privilege_id == 1) --}}
            <li>
                <a href="{{ url('/welcome') }}" class="{{ Request::is('welcome') ? 'active' : '' }} ">
                    <span class=" ">
                        <img class="icon" src="{{ asset('my_dashboard\icons\settings_icon.png') }}" alt="">
                    </span>
                    <span class=" sidebar-li-text">اعدادت</span>
                </a>
            </li>
            {{-- @endif --}}
            <li class="logout-li">
                <div>
                    <i class="ti-power-off"></i>
                    <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                        {{ __('خروج') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </li>


        </ul>

    </div>
</div>
