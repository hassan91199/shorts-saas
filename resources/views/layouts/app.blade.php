<x-lexend-guest-layout :show-menu-panel="false" :show-bottom-actions-sticky="false" :show-header="false" :show-footer="false">
    <header class="navbar sticky-top bg-primary flex-md-nowrap p-0 py-1 shadow">
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6 text-white panel text-none" href="{{ route('dashboard') }}" style="width: 140px">
            <img src="{{ asset('assets/images/common/logo-dark.svg') }}" alt="Lexend">
        </a>

        <ul class="navbar-nav flex-row d-none d-md-flex">
            <li class="nav-item text-nowrap">
                <a class="nav-link mx-2 fs-6 text-white" href="#">Affiliates</a>
            </li>
            <li class="nav-item text-nowrap">
                <!-- <a class="" href="#">Logout</a> -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a class="nav-link mx-2 fs-6 text-white" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </a>
                </form>
            </li>
        </ul>

        <ul class="navbar-nav flex-row d-md-none">
            <li class="nav-item text-nowrap">
                <button class="nav-link px-3 text-white" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation" data-uc-navbar-toggle-icon>
                </button>
            </li>
        </ul>
    </header>

    <div class="container-fluid">
        <div class="row">
            <div class="sidebar border border-right col-md-3 col-lg-2 p-0 bg-body-tertiary">
                <div class="offcanvas-md offcanvas-end bg-body-tertiary" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="sidebarMenuLabel">Lexend</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#sidebarMenu" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body d-md-flex flex-column p-0 pt-lg-3 overflow-y-auto">
                        <ul class="nav flex-column">
                            <!-- Series with Sub-items -->
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center gap-2 active" aria-current="page" data-bs-toggle="collapse" href="#seriesSubMenu" role="button" aria-expanded="false" aria-controls="seriesSubMenu">
                                    Series
                                </a>
                                <div class="collapse" id="seriesSubMenu">
                                    <ul class="nav flex-column ms-3">
                                        <li class="nav-item">
                                            <a class="nav-link d-flex align-items-center gap-2" href="{{ route('series.index') }}">
                                                View Series
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link d-flex align-items-center gap-2" href="{{ route('series.create') }}">
                                                Create Series
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>

                            <!-- Billing -->
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center gap-2" href="#">
                                    Billing
                                </a>
                            </li>

                            <!-- Account -->
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center gap-2" href="#">
                                    Account
                                </a>
                            </li>


                            <div class="d-md-none">

                                <hr class="w-100 m-0">

                                <!-- Affiliates -->
                                <li class="nav-item">
                                    <a class="nav-link d-flex align-items-center gap-2" href="#">
                                        Affiliates
                                    </a>
                                </li>

                                <!-- Logout -->
                                <li class="nav-item">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <a class="nav-link d-flex align-items-center gap-2" href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                                            {{ __('Log Out') }}
                                        </a>
                                    </form>
                                </li>
                            </div>
                        </ul>
                    </div>
                </div>
            </div>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                @if(isset($pageTitle))
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">{{ $pageTitle }}</h1>
                </div>
                @endif

                {{ $slot }}
            </main>
        </div>
    </div>


    @if(isset($script))
    <x-slot name="script">
        {{ $script }}
    </x-slot>
    @endif
</x-lexend-guest-layout>