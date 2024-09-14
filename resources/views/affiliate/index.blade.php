<x-app-layout>
    <div data-anime="onview: -200; translateY: [48, 0]; opacity: [0, 1]; easing: easeOutCubic; duration: 500; delay: 350;">
        <!-- Section start -->
        <h2 class="h3 mt-5">{{ __('Your Stats') }}</h2>
        <div id="affiliate_stats" class="stats section panel overflow-hidden">
            <div class="section-outer panel">
                <div class="container sm:max-w-lg xl:max-w-xl">
                    <div class="section-inner panel">
                        <div class="panel p-2 xl:p-4 rounded-1-5 lg:rounded-2 bg-secondary dark:bg-gray-800" data-anime="onview: -200; translateY: [48, 0]; opacity: [0, 1]; easing: easeOutCubic; duration: 500; delay: 350;">
                            <div class="row child-cols col-match items-center justify-center text-center gy-4 lg:gy-8" data-anime="onview: -200; targets: >*; translateY: [48, 0]; opacity: [0, 1]; easing: easeOutCubic; duration: 500; delay: anime.stagger(100, {start: 500});">
                                <div>
                                    <div class="fact-item panel vstack gap-1">
                                        <h5 class="h3 md:h2 lg:h1 xl:display-5 m-0 text-primary dark:text-secondary">1</h5>
                                        <p class="fw-medium">{{ __('Clicks') }}</p>
                                    </div>
                                </div>
                                <div>
                                    <div class="fact-item panel vstack gap-1">
                                        <h5 class="h3 md:h2 lg:h1 xl:display-5 m-0 text-primary dark:text-secondary">0</h5>
                                        <p class="fw-medium">{{ __('Sign Ups') }}</p>
                                    </div>
                                </div>
                                <div>
                                    <div class="fact-item panel vstack gap-1">
                                        <h5 class="h3 md:h2 lg:h1 xl:display-5 m-0 text-primary dark:text-secondary">0</h5>
                                        <p class="fw-medium">{{ __('Conversions') }}</p>
                                    </div>
                                </div>
                                <div>
                                    <div class="fact-item panel vstack gap-1">
                                        <h5 class="h3 md:h2 lg:h1 xl:display-5 m-0 text-primary dark:text-secondary">$0</h5>
                                        <p class="fw-medium">{{ __('Unpaid Commission') }}</p>
                                    </div>
                                </div>
                                <div>
                                    <div class="fact-item panel vstack gap-1">
                                        <h5 class="h3 md:h2 lg:h1 xl:display-5 m-0 text-primary dark:text-secondary">$0</h5>
                                        <p class="fw-medium">{{ __('Paid Commission') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Section end -->

        <!-- Section start -->
        <h2 class="h3 mt-5">{{ __('Your Affiliate URL') }}</h2>
        <div class="panel rounded-3 overflow-hidden bg-secondary dark:bg-gray-800 p-3">
            <input type="text" value="{{ config('app.url') }}/?ref=jjo"
                class="form-control form-control-sm w-full fs-6 bg-white dark:border-white dark:border-gray-700" readonly>
        </div>
        <!-- Section end -->

        <!-- Section start -->
        <h2 class="h3 mt-5">{{ __('PayPal Email') }}</h2>
        <div class="panel rounded-3 overflow-hidden bg-secondary dark:bg-gray-800 p-3">
            <form method="post" action="" class="vstack gap-1">
                @csrf
                @method('patch')

                <div class="d-flex flex-row gap-1">
                    <input id="paypal-email" name="paypal_email" type="email" value="{{ old('paypal_email', $user->paypal_email) }}"
                        class="form-control form-control-sm w-full fs-6 bg-white dark:border-white dark:border-gray-700"
                        placeholder="PayPal Email">
                    <div class="">
                        @if (session('status') === 'paypal-email-updated')
                        <span id="saved-message" class="fs-6 text-primary">{{ __('Updated!') }}</span>
                        @endif

                        <button type="submit" class="btn btn-sm btn-primary">{{ __('Update') }}</button>
                    </div>
                </div>
                <x-input-error :messages="$errors->get('paypal_email')" />
                <p class="fs-7 fw-light">{{ __('Note: This is where your commission payouts will be sent.   ') }}</p>

            </form>
        </div>
        <!-- Section end -->

        <!-- Section start -->
        <div id="faq" class="faq section panel">
            <div class="section-outer panel py-6 xl:py-10">
                <div class="container xl:max-w-xl">
                    <div class="section-inner panel" data-anime="onview: -100; targets: >*; translateY: [48, 0]; opacity: [0, 1]; easing: easeOutCubic; duration: 500; delay: anime.stagger(100, {start: 200});">
                        <div class="faq-inner panel row child-cols-12 lg:child-cols justify-between g-4">
                            <div class="lg:col-5">
                                <div class="panel vstack items-start gap-2" data-uc-sticky="end: .faq-inner; offset: 50vh - 50%; media: @l;">
                                    <h2 class="h3 lg:h2 m-0">Frequenlty Asked Questions</h2>
                                    <p class="fs-6 lg:fs-5">Curious about something? We've got the answers you need.</p>
                                </div>
                            </div>
                            <div class="lg:col-6">
                                <div class="panel">
                                    <ul class="gap-2" data-uc-accordion="targets: > li; multiple: true">
                                        <li class="panel p-2 md:p-4 border rounded-1-5">
                                            <a class="uc-accordion-title fs-5 sm:fs-4 ltr:pe-4 rtl:ps-4" href="#">{{ __('How does this work?') }}</a>
                                            <div class="uc-accordion-content">
                                                <p>The way it works is simple! We give you a unique affiliate URL to share. If someone registers an account and purchases a membership within 30 days after clicking the link, we'll give you a cut of the sale!</p>
                                            </div>
                                        </li>
                                        <li class="panel p-2 md:p-4 border rounded-1-5">
                                            <a class="uc-accordion-title fs-5 sm:fs-4 ltr:pe-4 rtl:ps-4" href="#">{{ __('What commissions do I get?') }}</a>
                                            <div class="uc-accordion-content">
                                                <p>{{ __('Our affiliate program offers a 30% recurring commission. Our recurring model means great passive income for you.') }}</p>
                                            </div>
                                        </li>
                                        <li class="panel p-2 md:p-4 border rounded-1-5">
                                            <a class="uc-accordion-title fs-5 sm:fs-4 ltr:pe-4 rtl:ps-4" href="#">{{ __('When are payouts sent out?') }}</a>
                                            <div class="uc-accordion-content">
                                                <p>{{ __('Payouts will be sent on the 1st of every month through PayPal.') }}</p>
                                            </div>
                                        </li>
                                        <li class="panel p-2 md:p-4 border rounded-1-5">
                                            <a class="uc-accordion-title fs-5 sm:fs-4 ltr:pe-4 rtl:ps-4" href="#">{{ __('Is there a minimum payout requirement?') }}</a>
                                            <div class="uc-accordion-content">
                                                <p>{{ __('Yes. You need to have a minimum "unpaid commissions" of $30 before receiving your payout in order to keep transaction fees low.') }}</p>
                                            </div>
                                        </li>
                                        <li class="panel p-2 md:p-4 border rounded-1-5">
                                            <a class="uc-accordion-title fs-5 sm:fs-4 ltr:pe-4 rtl:ps-4" href="#">{{ __('How does affiliate tracking work?') }}</a>
                                            <div class="uc-accordion-content">
                                                <p>The way the {{ config('app.name') }} affiliate tracking works is if someone clicks on your link, a 30 day cookie is attached in their browser. This tracks them so when they register an account they are locked-in to be attributed to you forever.</p>
                                            </div>
                                        </li>
                                        <li class="panel p-2 md:p-4 border rounded-1-5">
                                            <a class="uc-accordion-title fs-5 sm:fs-4 ltr:pe-4 rtl:ps-4" href="#">Can I run ads to promote {{ config('app.name') }}?</a>
                                            <div class="uc-accordion-content">
                                                <p>{{ __('In general, you can. However, we DO NOT allow promotion through Google Search ads, they will not count towards commission. You can run ads on other platforms such as Facebook, Instagram, TikTok, Reddit, YouTube, etc.') }}</p>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section end -->
    </div>


    <x-slot name="script">
        <script>
            // 
        </script>
    </x-slot>
</x-app-layout>