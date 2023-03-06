<header>

    <h3>
        <label for="nav-toggle">
            <span class="las la-bars">=</span>
        </label>
    </h3>

    {{--
    <div class="search-wrapper">
        <span class="las la-search"></span>
        <input type="search" name="" id="">
    </div> --}}

    @if (Auth::user()->privilege_id == 1)

    <div class="user-wrapper">
        {{-- <img src="" width="40px" height="40px" alt=""> --}}
        <a href="{{ route('manager.index') }}">
            <div>
                <h4 class="text-warning">م مدحت</h4>
                {{-- <small>Super Admin</small> --}}
            </div>
        </a>
    </div>
    @endif
    <div class="user-wrapper">
        @if (Auth::user()->name)
        <span class="ml-3"><a href="{{ route('users.show', ['user'=>Auth::user()->id]) }}" class="text-warning">{{ Auth::user()->aname.' '.Auth::user()->last_name }}</a></span>
        @if (Auth::user()->privilege_id != 0 )
        <span class="dark">("{{ Auth::user()->privilege->name}}")</span>
        @else
        <span class="dark">("{{ __('مستخدم') }}")</span>
        @endif
        @endif
    </div>
</header>
