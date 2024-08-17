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
                            </div>
                        </div>
                    </div>

                    <h2 class="h3 mt-5">{{ __('Past Videos') }}</h2>

                    <div class="panel rounded-3 overflow-hidden bg-secondary dark:bg-gray-800 p-1 sm:p-4 xl:p-6">
                        <div class="row">
                            <div class="col-11">
                                <p class="fs-4 fw-medium text-opacity-70">The Vanishing of Roanoke Colony</p>
                                <p class="fs-4 fw-normal text-opacity-70">What happened to the lost colony of Roanoke? A tale of mystery, survival, and unanswered questions awaits you! #Roanoke #HistoryMystery #LostColony #AmericanHistory #Exploration</p>
                                <p class="fs-4 fw-ultra-light text-opacity-70">Created on 8/16/2024</p>
                            </div>
                            <div class="col-1 d-flex justify-center items-center">
                                <i class="icon-2 unicon-download"></i>
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