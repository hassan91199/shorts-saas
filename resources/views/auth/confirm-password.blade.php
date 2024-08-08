<x-auth-layout>
    <div class="panel vstack gap-3 w-100 sm:w-350px mx-auto text-center" data-anime="targets: >*; translateY: [24, 0]; opacity: [0, 1]; easing: easeInOutExpo; duration: 750; delay: anime.stagger(100);">
        <h1 class="h4 sm:h2">{{ __('Confirm Password') }}</h1>
        <p class="mt-2 sm:m-0">{{ __('This is a secure area of the application. Please confirm your password before continuing.') }}</p>
        <form method="POST" action="{{ route('password.confirm') }}" class="vstack gap-2">
            @csrf

            <!-- Password -->
            <input class="form-control h-48px w-full bg-white dark:bg-opacity-0 dark:text-white dark:border-gray-300 dark:border-opacity-30" type="password" name="password" placeholder="{{ __('Password') }}" required>
            <x-input-error :messages="$errors->get('password')" />

            <button class="btn btn-primary btn-md text-white mt-2" type="submit">{{ __('Confirm') }}</button>
        </form>
    </div>
</x-auth-layout>