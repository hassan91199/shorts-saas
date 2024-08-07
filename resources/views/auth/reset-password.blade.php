<x-auth-layout>
    <div class="panel vstack gap-3 w-100 sm:w-350px mx-auto text-center" data-anime="targets: >*; translateY: [24, 0]; opacity: [0, 1]; easing: easeInOutExpo; duration: 750; delay: anime.stagger(100);">
        <h1 class="h4 sm:h2">{{ __('Reset Password') }}</h1>
        <form method="POST" action="{{ route('password.store') }}" class="vstack gap-2">
            @csrf

            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email Address -->
            <input class="form-control h-48px w-full bg-white dark:bg-opacity-0 dark:text-white dark:border-gray-300 dark:border-opacity-30" type="email" name="email" value="{{ old('email', $request->email) }}" placeholder="{{ __('Email') }}" required>

            <!-- Password -->
            <input class="form-control h-48px w-full bg-white dark:bg-opacity-0 dark:text-white dark:border-gray-300 dark:border-opacity-30" type="password" name="password" placeholder="{{ __('New Password') }}" required>

            <!-- Confirm Password -->
            <input class="form-control h-48px w-full bg-white dark:bg-opacity-0 dark:text-white dark:border-gray-300 dark:border-opacity-30" type="password" name="password_confirmation" placeholder="{{ __('Confirm Password') }}" required>

            <button class="btn btn-primary btn-md text-white mt-2" type="submit">{{ __('Reset Password') }}</button>
        </form>
    </div>
</x-auth-layout>