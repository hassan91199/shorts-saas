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
                    <div class="row">
                        <div class="col-12 col-md-10 d-flex flex-wrap align-items-center gap-2 mb-3 mb-md-0">
                            @foreach($userSeries as $element)
                            @if($element->id === $series->id)
                            <a href="#" class="fs-6 text-white bg-primary rounded p-2 text-none">{{ __($element->title) }}</a>
                            @else
                            <a href="{{ route('series.show', ['series' => $element->id]) }}" class="fs-6 text-black rounded border border-black p-2 text-none">{{ __($element->title) }}</a>
                            @endif
                            @endforeach
                        </div>
                        <div class="col-12 col-md-2">
                            <button class="btn btn-danger text-white">{{ __('Delete') }}</button>
                        </div>
                    </div>
                    <div>
                        <hr class="w-100 m-0">
                    </div>

                    <div class="panel rounded-3 overflow-hidden bg-secondary dark:bg-gray-800 mt-5">
                        <div class="panel">
                            <div class="p-3 sm:p-6 xl:p-8">
                                <div>
                                    <h2 class="h3 m-0">{{ __('Current Video') }}</h2>
                                    <p class="fs-6 text-dark dark:text-white text-opacity-70">{{ __('Edit the details of your current video') }}</p>
                                </div>

                                <hr class="w-100 m-0">

                                <div class="panel row mt-2">
                                    <div class="col-12 col-md-4">

                                        @if(isset($currentVideo->video_url))
                                        <video src="{{ $currentVideo->video_url }}" class="bg-primary p-1 rounded" controls></video>
                                        <div class="d-flex align-items-center mt-2">
                                            <a href="{{ $currentVideo->video_url }}" class="text-none d-flex align-items-center" download>
                                                <i class="icon-2 unicon-download"></i>
                                                <span class="fs-6 text-dark dark:text-white text-opacity-70 ms-1">{{ __('Download Video') }}</span>
                                            </a>
                                        </div>
                                        @else
                                        <video src="" class="bg-primary p-1 rounded d-none"></video>
                                        <div class="text-black">
                                            <div class="spinner-border icon-1"></div>
                                            <span class="" role="status">Rendering Video - 10%</span>
                                        </div>
                                        <div class="d-flex align-items-center mt-2 d-none">
                                            <a href="" class="text-none d-flex align-items-center" download>
                                                <i class="icon-2 unicon-download"></i>
                                                <span class="fs-6 text-dark dark:text-white text-opacity-70 ms-1">{{ __('Download Video') }}</span>
                                            </a>
                                        </div>
                                        @endif

                                        <!-- <div class="d-flex align-items-center mt-2">
                                            <i class="icon-1 unicon-download"></i>
                                            <p class="fs-6 text-dark dark:text-white text-opacity-70 ms-1">{{ __('Download Video') }}</p>
                                        </div> -->

                                    </div>
                                    <div class="panel col-12 col-md-8">
                                        <form class="panel vstack gap-2 lg:gap-3" action="?">
                                            <div class="form-group">
                                                <label class="form-label ft-tertiary" for="video-title">Title</label>
                                                <input type="text" id="video-title" class="form-control dark:bg-gray-100 dark:bg-opacity-5 dark:text-white dark:border-gray-800" name="video_title" value="{{ $currentVideo->title }}" maxlength="100" required>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label ft-tertiary" for="video-caption">Caption</label>
                                                <input type="text" id="video-caption" class="form-control dark:bg-gray-100 dark:bg-opacity-5 dark:text-white dark:border-gray-800" name="video_caption" value="{{ $currentVideo->caption }}" maxlength="200" required>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label ft-tertiary" for="video-script">Script</label>
                                                <textarea name="video_script" id="video-script" class="form-control dark:bg-gray-100 dark:bg-opacity-5 dark:text-white dark:border-gray-800" maxlength="1600" rows="15">{{ $currentVideo->script }}</textarea>
                                            </div>
                                        </form>

                                        <p class="mt-1"><span class="fw-bold">Note:</span> Always verify AI generated scripts for accuracy.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h2 class="h3 mt-5">{{ __('Past Videos') }}</h2>

                    @if(isset($pastVideos) && $pastVideos->count() > 0)
                    @foreach($pastVideos as $pastVideo)
                    <div class="panel rounded-3 overflow-hidden bg-secondary dark:bg-gray-800 p-3">
                        <div class="row">
                            <div class="col-11">
                                <p class="fs-4 fw-medium text-opacity-70">{{ __($pastVideo->title) }}</p>
                                <p class="fs-5 fw-light text-opacity-70">{{ __($pastVideo->caption) }}</p>
                                <p class="fs-5 fw-ultra-light text-opacity-70">{{ __('Created on') }} {{ $pastVideo->created_at->format('n/j/Y') }}</p>
                            </div>
                            <div class="col-1 d-flex justify-content-center align-items-center">
                                <a href="{{ $pastVideo->video_url }}" download>
                                    <i class="icon-2 unicon-download"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @else
                    <div class="panel rounded-3 overflow-hidden bg-secondary dark:bg-gray-800 p-3 text-center">
                        <h3 class="h4 m-0">{{ __("Keep creating! Your past videos will be displayed here.") }}</h3>
                    </div>
                    @endif
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