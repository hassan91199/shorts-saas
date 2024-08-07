<x-auth-layout>
    <div class="panel vstack gap-3 w-100 sm:w-350px mx-auto text-center" data-anime="targets: >*; translateY: [24, 0]; opacity: [0, 1]; easing: easeInOutExpo; duration: 750; delay: anime.stagger(100);">
        <h1 class="h4 sm:h2">{{ __('Verify Email') }}</h1>
        <p class="mt-2 sm:m-0">{{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}</p>

        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <button class="btn btn-primary btn-md text-white mt-2" type="submit">{{ __('Resend Verification Email') }}</button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button class="btn btn-slate btn-md text-underline" type="submit">{{ __('Log Out') }}</button>
        </form>
    </div>
</x-auth-layout>