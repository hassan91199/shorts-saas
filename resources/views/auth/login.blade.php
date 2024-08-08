<x-auth-layout>
    <div class="panel vstack gap-3 w-100 sm:w-350px mx-auto text-center" data-anime="targets: >*; translateY: [24, 0]; opacity: [0, 1]; easing: easeInOutExpo; duration: 750; delay: anime.stagger(100);">
        <h1 class="h4 sm:h2">{{ __('Sign in') }}</h1>

        <!-- Session Status -->
        <x-auth-session-status :status="session('status')" />

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

            <!-- Email Address -->
            <input class="form-control h-48px w-full bg-white dark:bg-opacity-0 dark:text-white dark:border-gray-300 dark:border-opacity-30" type="email" name="email" value="{{ old('email') }}" placeholder="{{ __('Email') }}" required>
            <x-input-error :messages="$errors->get('email')" />

            <!-- Password -->
            <input class="form-control h-48px w-full bg-white dark:bg-opacity-0 dark:text-white dark:border-gray-300 dark:border-opacity-30" type="password" name="password" placeholder="{{ __('Password') }}" required>
            <x-input-error :messages="$errors->get('password')" />

            <div class="hstack justify-between text-start">
                <div class="form-check text-start rtl:text-end">
                    <input id="uc_form_remember_me" class="form-check-input rounded bg-white dark:bg-opacity-0 dark:text-white dark:border-gray-300 dark:border-opacity-30" type="checkbox" name="remember">
                    <label for="uc_form_remember_me" class="hstack justify-between form-check-label fs-6">{{ __('Remember me?') }}</label>
                </div>
                <a href="{{ route('password.request') }}" class="uc-link">{{ __('Forgot password') }}</a>
            </div>
            <button class="btn btn-primary btn-md text-white mt-2" type="submit">{{ __('Log in') }}</button>
        </form>
        <p>{{ __('Have no account yet?') }} <a class="uc-link" href="{{ route('register') }}">{{ __('Sign up') }}</a></p>
    </div>
</x-auth-layout>