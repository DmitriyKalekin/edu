@guest
<div class="row">
    <div class="dropdown">
        <button class="site-btn-info-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <strong>@lang('content.loginbtn')</strong>
            <i class="dropdown-toggle"></i>
        </button>
        <div class="dropdown-menu" style="background-color: #3B3444" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" style="background-color: #3B3444" href="{{ route('login') }}">As user</a>
                <a class="dropdown-item" style="background-color: #3B3444" href="{{ route('teacher.showLoginForm') }}">As teacher</a>
        </div>
    </div>
    <div class="dropdown">
        <button class="site-btn-danger-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <strong>@lang('content.regbtn')</strong>
            <i class="dropdown-toggle"></i>
        </button>
        <div class="dropdown-menu" style="background-color: #3B3444" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" style="background-color: #3B3444" href="{{ route('register') }}">As user</a>
                <a class="dropdown-item" style="background-color: #3B3444" href="{{ route('teacher.showRegisterForm') }}">As teacher</a>
        </div>
    </div>
</div>
    {{-- <a href="{{ route('login') }}"></a>
    <span>/</span>
    <a href="{{ route('register') }}">@lang('content.regbtn')</a> --}}

@else
<div class="dropdown">
    <button class="site-btn-danger-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
        <strong>{{ Auth::user()->name }}</strong>
        <i class="dropdown-toggle"></i>
    </button>
    <div class="dropdown-menu" style="background-color: #3B3444" aria-labelledby="dropdownMenuButton">
        @auth('web')
            <a class="dropdown-item" style="background-color: #3B3444"
               href="{{ route('users_profile', Auth::user()->id) }}"><strong>@lang('content.profile')</strong></a>
            <a class="dropdown-item" style="background-color: #3B3444" href="#">@lang('content.mycour')</a>
            <a class="dropdown-item" style="background-color: #3B3444" href="{{ route('user.invites')}}">@lang('content.messages')</a>
        @endauth

        @auth('teacher')
            <a class="dropdown-item" style="background-color: #3B3444"
               href="{{ route('teacher_profile', Auth::user()->id) }}"><strong>@lang('content.profile')</strong></a>
            <a class="dropdown-item" style="background-color: #3B3444"
               href="{{ route('course.create') }}">@lang('content.create course')</a>
            <a class="dropdown-item" style="background-color: #3B3444" href="#">@lang('content.messages')</a>
        @endauth

        @auth('admin')
            <a class="dropdown-item" style="background-color: #3B3444"
               href="{{ route('admin_profile', Auth::user()->id) }}"><strong>@lang('content.profile')</strong></a>
            <a class="dropdown-item" style="background-color: #3B3444" href="#">@lang('content.messages')</a>
        @endauth

        <a class="dropdown-item" style="background-color: #3B3444"
           href="{{ route('logout') }}">@lang('content.logoutbtn')</a>
    </div>
</div>
@endguest
