<x-auth-layout>
    <div class="panel vstack gap-3 w-100 sm:w-350px mx-auto text-center" data-anime="targets: >*; translateY: [24, 0]; opacity: [0, 1]; easing: easeInOutExpo; duration: 750; delay: anime.stagger(100);">
        <h1 class="h4 sm:h2">{{ __('Forgot Password') }}</h1>
        <form method="POST" action="{{ route('password.email') }}" class="vstack gap-2">
            @csrf
            <input class="form-control h-48px w-full bg-white dark:bg-opacity-0 dark:text-white dark:border-gray-300 dark:border-opacity-30" type="email" name="email" placeholder="Email" required>
            <!-- <div class="form-check text-start rtl:text-end">
                <input id="uc_form_not_robot" class="form-check-input rounded bg-white dark:bg-opacity-0 dark:text-white dark:border-gray-300 dark:border-opacity-30" type="checkbox" required>
                <label for="uc_form_not_robot" class="form-check-label fs-6"> <span>I'm not a robot</span>. </label>
            </div> -->
            <button class="btn btn-primary btn-md text-white mt-2" type="submit">{{ __('Email Password Reset Link') }}</button>
        </form>
        <p class="mt-2 sm:m-0">{{ __('Remember your password?') }} <a class="uc-link" href="{{ route('login') }}">{{ __('Sign in') }}</a></p>
    </div>
</x-auth-layout>