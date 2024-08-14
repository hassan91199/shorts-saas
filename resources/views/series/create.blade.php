<x-app-layout>
    <!-- Section start -->
    <div id="hero_header" class="hero-header section panel overflow-hidden">
        <div class="position-absolute top-0 start-0 end-0 min-h-screen overflow-hidden d-none lg:d-block" data-anime="targets: >*; scale: [0, 1]; opacity: [0, 1]; easing: spring(1, 80, 10, 0); duration: 450; delay: anime.stagger(100, {start: 750});">
            <div class="position-absolute top-0 start-0 rotate-45" style="top: 30% !important; left: 18% !important">
                <img class="w-32px text-gray-900 dark:text-white" src="../assets/images/template/star-1.svg" alt="star-1" data-uc-svg>
            </div>
            <div class="position-absolute top-0 end-0 rotate-45" style="top: 15% !important; right: 18% !important">
                <img class="w-24px text-gray-900 dark:text-white" src="../assets/images/template/star-2.svg" alt="star-2" data-uc-svg>
            </div>
        </div>
        <div class="section-outer panel pt-9 lg:pt-10 pb-6 sm:pb-8 lg:pb-9">
            <div class="container max-w-xl">
                <div class="section-inner panel mt-2 sm:mt-4 lg:mt-0" data-anime="targets: >*; translateY: [48, 0]; opacity: [0, 1]; easing: spring(1, 80, 10, 0); duration: 450; delay: anime.stagger(100, {start: 200});">
                    <div class="vstack items-center gap-2 lg:gap-4 mb-4 sm:mb-6 lg:mb-8 max-w-750px mx-auto text-center">
                        <h1 class="h2 sm:h1 lg:display-6 xl:display-5 m-0">{{ __('Create Series') }}</h1>
                        <p class="fs-6 sm:fs-5 text-dark dark:text-white text-opacity-70">{{ __('Schedule a series of Faceless Videos to post on auto-pilot.') }}</p>
                    </div>
                    <div class="panel rounded-3 overflow-hidden bg-secondary dark:bg-gray-800">
                        <div class="panel">
                            <div>
                                <form method="POST" action="{{ route('series.store') }}" class="vstack gap-3 p-3 sm:p-6 xl:p-8">
                                    @csrf

                                    <div id="set-destination-div" class="vstack gap-1">
                                        <h2 class="h3 m-0">{{ __('Step 1 - Destination') }}</h2>
                                        <p class="fs-6 text-dark dark:text-white text-opacity-70">{{ __('The account where your video series will be posted') }}</p>

                                        <select id="set-destination-select" name="destination" class="form-control bg-white dark:border-white dark:bg-opacity-10 dark:border-opacity-0 dark:text-white">
                                            <option value="" disabled selected>Select an option</option>
                                            <option value="email">Email Me Instead</option>
                                            <option value="tiktok">Link a Tik Tok Account +</option>
                                            <option value="youtube">Link a Youtube Account +</option>
                                        </select>
                                    </div>

                                    <div id="set-content-div" class="mt-2 d-none vstack gap-1">
                                        <h2 class="h3 m-0">{{ __('Step 2 - Content') }}</h2>
                                        <p class="fs-6 text-dark dark:text-white text-opacity-70">{{ __('What will your video series be about?') }}</p>

                                        <select id="set-content-select" name="content" class="form-control bg-white dark:border-white dark:bg-opacity-10 dark:border-opacity-0 dark:text-white">
                                            <option value="" disabled selected>Select an option</option>
                                            <option>Random AI Story</option>
                                            <option>Scary Stories</option>
                                            <option>Bedtime Stories</option>
                                            <option>Interesting History</option>
                                            <option>Urban Legends</option>
                                            <option>Motivational</option>
                                            <option>Fun Fact</option>
                                            <option>Long From Jokes</option>
                                            <option>Like Pro Tips</option>
                                            <option>ELJL5</option>
                                            <option>philogospec</option>
                                            <option>Product Marketing</option>
                                            <option>Custom Topic</option>
                                        </select>
                                    </div>

                                    <div id="create-video-div" class="mt-2 d-none vstack gap-1">
                                        <h2 class="h3 m-0">{{ __('Step 3 - Create') }}</h2>
                                        <p class="fs-6 text-dark dark:text-white text-opacity-70">{{ __('You will be able to preview your upcoming videos before posting') }}</p>
                                        <button class="btn btn-primary text-white mt-1 w-100" type="submit">{{ __('Create Series +') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Section end -->

    <x-slot name="script">
        <script>
            $(document).ready(function() {
                $('#set-destination-select').change(function() {
                    $('#set-content-div').removeClass('d-none');
                });

                $('#set-content-select').change(function() {
                    $('#create-video-div').removeClass('d-none');
                });
            });
        </script>
    </x-slot>
</x-app-layout>