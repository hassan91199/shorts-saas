<x-app-layout>
    <!-- Section start -->
    <div id="hero_header" class="hero-header section panel overflow-hidden">
        <!-- <div class="position-absolute top-0 start-0 end-0 min-h-screen overflow-hidden d-none lg:d-block" data-anime="targets: >*; scale: [0, 1]; opacity: [0, 1]; easing: spring(1, 80, 10, 0); duration: 450; delay: anime.stagger(100, {start: 750});">
            <div class="position-absolute top-0 start-0 rotate-45" style="top: 30% !important; left: 18% !important">
                <img class="w-32px text-gray-900 dark:text-white" src="../assets/images/template/star-1.svg" alt="star-1" data-uc-svg>
            </div>
            <div class="position-absolute top-0 end-0 rotate-45" style="top: 15% !important; right: 18% !important">
                <img class="w-24px text-gray-900 dark:text-white" src="../assets/images/template/star-2.svg" alt="star-2" data-uc-svg>
            </div>
        </div> -->
        <div class="section-outer panel pt-9 lg:pt-10 pb-6 sm:pb-8 lg:pb-9">
            <div class="container max-w-xl">
                <div class="section-inner panel mt-2 sm:mt-4 lg:mt-0" data-anime="targets: >*; translateY: [48, 0]; opacity: [0, 1]; easing: spring(1, 80, 10, 0); duration: 450; delay: anime.stagger(100, {start: 200});">
                    <div class="panel rounded-3 overflow-hidden bg-secondary dark:bg-gray-800">
                        <div class="panel">
                            <div class="p-3 sm:p-6 xl:p-8">
                                <div>
                                    <h2 class="h3 m-0">{{ __('Current Video') }}</h2>
                                    <p class="fs-6 text-dark dark:text-white text-opacity-70">{{ __('Edit the details of your current video') }}</p>
                                </div>

                                <hr class="w-100 m-0">

                                <div class="panel row mt-2">
                                    <div class="col-12 col-md-4">
                                        <video src="{{ asset('assets/videos/short-2.mp4') }}" class="bg-primary p-1 rounded" controls></video>
                                    </div>
                                    <div class="panel col-12 col-md-8">
                                        <form class="panel vstack gap-2 lg:gap-3" action="?">
                                            <div class="form-group">
                                                <label class="form-label ft-tertiary" for="video-title">Title</label>
                                                <input type="text" id="video-title" class="form-control dark:bg-gray-100 dark:bg-opacity-5 dark:text-white dark:border-gray-800" name="video_title" maxlength="100" required>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label ft-tertiary" for="video-caption">Caption</label>
                                                <input type="text" id="video-caption" class="form-control dark:bg-gray-100 dark:bg-opacity-5 dark:text-white dark:border-gray-800" name="video_caption" maxlength="200" required>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label ft-tertiary" for="video-script">Script</label>
                                                <textarea name="video_script" id="video-script" class="form-control dark:bg-gray-100 dark:bg-opacity-5 dark:text-white dark:border-gray-800" maxlength="1600" rows="10"></textarea>
                                            </div>
                                        </form>

                                        <p class="mt-1"><span class="fw-bold">Note:</span> Always verify AI generated scripts for accuracy.</p>
                                    </div>
                                </div>

                                <!-- <form method="POST" action="{{ route('series.store') }}" class="vstack gap-3 p-3 sm:p-6 xl:p-8">
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
                                </form> -->
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