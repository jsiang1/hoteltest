<div class="header-area ">
            <div id="sticky-header" class="main-header-area">
                <div class="container-fluid p-0">
                    <div class="row align-items-center no-gutters">
                        <div class="col-xl-5 col-lg-6">
                            <div class="main-menu  d-none d-lg-block">
                                <nav>
                                    <ul id="navigation">
                                        <li><a href="/index">home</a></li>
                                        <li><a href="/rooms">rooms</a></li>
                                        <li><a href="/review">Review</a></li>
                                        <li><a href="/reservations">Reservation</a></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-2">
                            <div class="logo-img">
                                <a href="/index">
                                    <img src="img/logo.png" alt="">
                                </a>
                            </div>
                        </div>
                        <div class="col-xl-5 col-lg-4 d-none d-lg-block">
                            <div class="book_room">
                                <div class="socail_links">
                                    <div class="book_btn d-none d-lg-block" style="padding-right: 50px">
                                        <a href="/reservations">Reserve A Room</a>
                                    </div>
                                </div>
                                @if (Route::has('login'))
                    @auth
                        <x-app-layout>

                        </x-app-layout>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-success">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-outline-success">Register</a>
                        @endif
                    @endauth
                
            @endif
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mobile_menu d-block d-lg-none"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>