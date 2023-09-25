<div class="bg-base-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="navbar flex items-center justify-between">
            <div class="flex-1">
                <a href="{{ route('dashboard') }}" class="btn btn-ghost normal-case text-xl">GabutAja</a>
            </div>
            <div class="flex-none gap-2">
                <div class="dropdown dropdown-end">
                    <label tabindex="100" class="btn btn-ghost btn-circle avatar">
                        <div class="w-10 rounded-full">
                            @auth
                                @php
                                    $userPhoto = !empty(Auth::user()->photo) ? Storage::url(Auth::user()->photo) : asset('assets/images/user.jpg');
                                @endphp
                                <img src="{{ $userPhoto }}" />
                            @else
                                <img src="{{ asset('assets/images/user.jpg') }}" />
                            @endauth
                        </div>
                    </label>
                    <ul tabindex="100"
                        class="mt-3 z-[1] p-2 shadow menu menu-sm dropdown-content bg-base-100 rounded-box w-52 hidden lg:block">
                        @auth
                            <li><a href="{{ route('profile.index', Auth::user()->username) }}"
                                    class="justify-between">Profile</a></li>
                            <li><a href="{{ route('post.create') }}">Manage post</a></li>
                            <li><a href="{{ route('logout') }}">Logout</a></li>
                        @endauth
                        @guest
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @endguest
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="bg-base-100 bottom-0 left-0 fixed w-full z-50 shadow-lg border md:hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="h-[50px] flex items-center justify-around">
                <a href="{{ route('dashboard') }}"><box-icon type='{{ \Request::is('/') ? 'solid' : '' }}'
                        name='home-circle'></box-icon></a>
                <a href=""><box-icon name='search'></box-icon></a>
                @auth
                    <a href="{{ route('profile.index', Auth::user()->username) }}"><box-icon
                            type='{{ \Request::is('profile*') ? 'solid' : '' }}' name='user'></box-icon></a>
                @else
                    <a href="{{ route('login') }}"><box-icon type='{{ \Request::is('profile*') ? 'solid' : '' }}'
                            name='user'></box-icon></a>
                @endauth
            </div>
        </div>
    </div>
</div>
