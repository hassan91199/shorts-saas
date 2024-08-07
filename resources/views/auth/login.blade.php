<x-lexend-guest-layout :show-menu-panel="false" :show-bottom-actions-sticky="false" :show-header="false" :show-footer="false">
    <!-- Section start -->
    <div id="sign-in" class="sign-in section panel overflow-hidden bg-secondary dark:bg-gray-900">
        <div class="section-outer panel">
            <div class="section-inner panel">
                <div class="panel overflow-hidden">
                    <div class="panel row child-cols-12 md:child-cols-6 g-0">
                        <div>
                            <div class="panel overflow-hidden min-h-300px h-100 lg:h-screen" data-anime="translateX: [-24, 0]; opacity: [0, 1]; easing: easeInOutExpo; duration: 750;">
                                <figure class="panel h-100 m-0 rounded">
                                    <canvas class="h-100 w-100"></canvas>
                                    <img class="media-cover image" src="../assets/images/common/login.webp" alt="Hero login image">
                                </figure>
                                <div class="position-cover text-white vstack justify-end p-4 lg:p-6 xl:py-8">
                                    <div class="position-cover bg-gradient-to-t from-black to-transparent opacity-50"></div>
                                    <div class="panel z-1">
                                        <div class="vstack gap-3" data-anime="targets: >*; translateY: [-24, 0]; opacity: [0, 1]; easing: easeInOutExpo; duration: 750; delay: anime.stagger(100, {start: 250});">
                                            <p class="fs-5 xl:fs-4 fw-medium">“With {{ config('app.name') }}, crafting engaging faceless shorts is fast and simple—transforming my workflow completely!”</p>
                                            <div class="vstack gap-0">
                                                <p class="fs-6 lg:fs-5 fw-medium">Alex Johnson</p>
                                                <span class="fs-7 opacity-80">Content Creator</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <a href="{{ route('home') }}" class="position-absolute top-0 ltr:start-0 rtl:end-0 text-none m-4 lg:m-6" data-anime="scale: [0.5, 1]; opacity: [0, 1]; easing: easeInOutExpo; duration: 750; delay: anime.stagger(100, {start: 150});">
                                    <img src="{{ asset('assets/images/common/logo-dark.svg') }}" alt="">
                                </a>
                            </div>
                        </div>
                        <div>
                            <div class="panel vstack justify-center h-100 overflow-hidden">
                                <div class="d-none lg:d-block" data-anime="onview: -100; targets: img; scale: [0.8, 1]; opacity: [0, 1]; easing: spring(1, 80, 10, 0); duration: 450; delay: 350;">
                                    <div class="position-absolute bottom-0 start-0 rotate-45" style="bottom: 15% !important; left: 18% !important">
                                        <img class="w-32px text-gray-900 dark:text-white" src="../assets/images/template/star-1.svg" alt="star-1" data-uc-svg>
                                    </div>
                                    <div class="position-absolute top-0 end-0 rotate-45" style="top: 15% !important; right: 18% !important">
                                        <img class="w-24px text-gray-900 dark:text-white" src="../assets/images/template/star-2.svg" alt="star-2" data-uc-svg>
                                    </div>
                                    <div class="position-absolute top-0 start-0 translate-middle-y -rotate-12" style="top: 15% !important; left: 10% !important">
                                        <img class="w-64px d-block dark:d-none" src="../assets/images/template/icon-internet.svg" alt="icon-internet">
                                        <img class="w-64px d-none dark:d-block" src="../assets/images/template/icon-internet-dark.svg" alt="icon-internet-dark">
                                    </div>
                                    <div class="position-absolute top-0 start-0 translate-middle-y ms-n3" style="top: 65% !important; left: 0% !important">
                                        <img class="w-64px d-block dark:d-none" src="../assets/images/template/icon-globe.svg" alt="icon-globe">
                                        <img class="w-64px d-none dark:d-block" src="../assets/images/template/icon-globe-dark.svg" alt="icon-globe-dark">
                                    </div>
                                    <div class="position-absolute top-0 end-0 translate-middle-y rotate-12" style="top: 80% !important; right: 12% !important">
                                        <img class="w-64px d-block dark:d-none" src="../assets/images/template/icon-diamond.svg" alt="icon-diamond">
                                        <img class="w-64px d-none dark:d-block" src="../assets/images/template/icon-diamond-dark.svg" alt="icon-diamond-dark">
                                    </div>
                                    <div class="position-absolute top-0 end-0 translate-middle-y -rotate-12 me-n2" style="top: 35% !important">
                                        <img class="w-64px d-block dark:d-none" src="../assets/images/template/icon-community.svg" alt="icon-community">
                                        <img class="w-64px d-none dark:d-block" src="../assets/images/template/icon-community-dark.svg" alt="icon-community-dark">
                                    </div>
                                </div>
                                <div class="panel py-4 px-2">
                                    <div class="panel vstack gap-3 w-100 sm:w-350px mx-auto text-center" data-anime="targets: >*; translateY: [24, 0]; opacity: [0, 1]; easing: easeInOutExpo; duration: 750; delay: anime.stagger(100);">
                                        <h1 class="h4 sm:h2">Sign in</h1>
                                        <!-- <div class="hstack gap-2">
                                            <a href="#github" class="hstack items-center justify-center flex-1 gap-1 h-48px text-none rounded bg-dark text-white dark:bg-white dark:text-dark">
                                                <i class="icon icon-1 unicon-logo-github"></i>
                                            </a>
                                            <a href="#facebook" class="hstack items-center justify-center flex-1 gap-1 h-48px text-none rounded bg-blue-600 text-white">
                                                <i class="icon icon-1 unicon-logo-facebook"></i>
                                            </a>
                                        </div>
                                        <div class="panel my-2">
                                            <hr class="m-0">
                                            <span class="position-absolute top-50 start-50 translate-middle p-1 fs-7 text-uppercase bg-secondary dark:bg-gray-900">Or</span>
                                        </div> -->
                                        <form method="POST" action="{{ route('login') }}" class="vstack gap-2">
                                            @csrf
                                            <input class="form-control h-48px w-full bg-white dark:bg-opacity-0 dark:text-white dark:border-gray-300 dark:border-opacity-30" type="email" name="email" placeholder="Email" required>
                                            <input class="form-control h-48px w-full bg-white dark:bg-opacity-0 dark:text-white dark:border-gray-300 dark:border-opacity-30" type="password" name="password" placeholder="Password" required>
                                            <div class="hstack justify-between text-start">
                                                <div class="form-check text-start rtl:text-end">
                                                    <input id="uc_form_remember_me" class="form-check-input rounded bg-white dark:bg-opacity-0 dark:text-white dark:border-gray-300 dark:border-opacity-30" type="checkbox" name="remember">
                                                    <label for="uc_form_remember_me" class="hstack justify-between form-check-label fs-6">Remember me?</label>
                                                </div>
                                                <a href="{{ route('password.request') }}" class="uc-link">Forgot password</a>
                                            </div>
                                            <button class="btn btn-primary btn-md text-white mt-2" type="submit">Log in</button>
                                        </form>
                                        <p>Have no account yet? <a class="uc-link" href="{{ route('register') }}">Sign up</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Section end -->
</x-lexend-guest-layout>