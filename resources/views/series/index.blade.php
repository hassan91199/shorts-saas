<x-app-layout>
    <!-- Section start -->
    <div id="hero_header" class="hero-header section panel overflow-hidden">
        <div class="section-outer panel pt-9 lg:pt-10 pb-6 sm:pb-8 lg:pb-9">
            <div class="container max-w-xl">
                <div class="section-inner panel mt-2 sm:mt-4 lg:mt-0" data-anime="targets: >*; translateY: [48, 0]; opacity: [0, 1]; easing: spring(1, 80, 10, 0); duration: 450; delay: anime.stagger(100, {start: 200});">
                    <div class="panel rounded-3 overflow-hidden bg-secondary dark:bg-gray-800 p-5 vstack gap-3">
                        <h3 class="h4 m-0">{{ __("You don't have any series yet!") }}</h3>
                        <p class="fs-4 fw-medium text-opacity-70">{{ __("It looks like you haven't created any series so far. Why not start now and add some exciting content? Click the button below to create your first series and get started!") }}</p>
                        <a href="{{ route('series.create') }}" class="btn btn-primary">{{ __('Create Your First Series') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Section end -->

    <x-slot name="script">
        <script>
            //
        </script>
    </x-slot>
</x-app-layout>