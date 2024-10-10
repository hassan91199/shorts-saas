<x-app-layout>
    @if($seriesLimitReached)
    <!-- Section start -->
    <div id="hero_header" class="hero-header section panel overflow-hidden">
        <div class="section-outer panel pt-9 lg:pt-10 pb-6 sm:pb-8 lg:pb-9">
            <div class="container max-w-xl">
                <div class="section-inner panel mt-2 sm:mt-4 lg:mt-0" data-anime="targets: >*; translateY: [48, 0]; opacity: [0, 1]; easing: spring(1, 80, 10, 0); duration: 450; delay: anime.stagger(100, {start: 200});">
                    <div class="panel rounded-3 overflow-hidden bg-secondary dark:bg-gray-800 p-5 vstack gap-3">
                        <h3 class="h4 m-0">{{ __("You've reached the maximum series limit for your current plan!") }}</h3>
                        <p class="fs-4 fw-medium text-opacity-70">{{ __("To create more series, please upgrade your plan. Unlock more features and continue adding amazing content.") }}</p>
                        <a href="{{ route('home') . '/#pricing' }}" class="btn btn-primary">{{ __('Upgrade Your Plan') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Section end -->
    @else
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

                                    <div id="set-destination-div" class="form-group vstack gap-1">
                                        <h2 class="h3 m-0">{{ __('Step 1 - Destination') }}</h2>
                                        <label class="form-label ft-tertiary" for="set-destination-select">{{ __('The account where your video series will be posted') }}</label>
                                        <select class="form-select form-control-lg rounded dark:bg-gray-100 dark:bg-opacity-5 dark:text-white dark:border-gray-800" id="set-destination-select" name="destination" aria-label="set-destination-select" required>
                                            <option value="" disabled selected>{{__('Select an option')}}</option>
                                            <option value="email">{{__('Email Me Instead')}}</option>
                                            <option value="youtube" data-is-youtube-linked="{{ auth()->user() && auth()->user()->youtube_token ? 'true' : 'false' }}">{{__('Link a Youtube Account +')}}</option>
                                            <option value="tiktok" data-is-tiktok-linked="{{ auth()->user() && auth()->user()->tiktok_creds ? 'true' : 'false' }}">{{__('Link a Tik Tok Account +')}}</option>
                                        </select>
                                    </div>

                                    <div id="set-content-div" class="form-group vstack gap-1 mt-2 d-none">
                                        <h2 class="h3 m-0">{{ __('Step 2 - Content') }}</h2>
                                        <label class="form-label ft-tertiary" for="set-content-select">{{ __('What will your video series be about?') }}</label>

                                        <select class="form-select form-control-lg rounded dark:bg-gray-100 dark:bg-opacity-5 dark:text-white dark:border-gray-800" id="set-content-select" name="category" aria-label="set-content-select" required>
                                            <option value="" disabled selected>{{__('Select an option')}}</option>
                                            @foreach($seriesCategories as $seriesCategoryName => $seriesCategoryPrompt)
                                            <option value="{{ $seriesCategoryName }}">{{__(ucwords(str_replace('_', ' ', $seriesCategoryName)))}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div id="series-settings-div" class="form-group vstack gap-1 mt-2">
                                        <h2 class="h3 m-0">{{ __('Step 3 - Series Settings') }}</h2>
                                        <p for="create-video-btn">{{ __('Preferences for every video in your series') }}</p>
                                        <div class="d-flex gap-1 bg-white w-100 p-2 rounded overflow-auto flex-nowrap">
                                            @foreach($artStyles as $artStyle)
                                            <div class="position-relative d-flex justify-content-center align-items-center cursor-pointer rounded shadow transition-all duration-250 hover:-translate-y-1" style="min-width: 117px; min-height: 208px; cursor: pointer;" data-art-style="{{ $artStyle }}" onclick="selectArtStyle(this)">
                                                <img class="cursor-pointer shadow rounded" src="{{ asset("assets/images/$artStyle.png") }}" loading="lazy" width="117" height="208">
                                                <div class="position-absolute bottom-0 start-0 w-100 py-1 rounded-bottom text-white text-center text-uppercase fs-8 fw-medium" style="background-color: rgba(0, 0, 0, 0.8);">
                                                    {{ str_replace('_', ' ', $artStyle) }}
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div id="create-video-div" class="form-group vstack gap-1 mt-2 d-none">
                                        <h2 class="h3 m-0">{{ __('Step 4 - Create') }}</h2>
                                        <label class="form-label ft-tertiary" for="create-video-btn">{{ __('You will be able to preview your upcoming videos before posting') }}</label>
                                        <button id="create-video-btn" class="btn btn-primary text-white w-100" type="submit">{{ __('Create Series +') }}</button>
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
    @endif

    <x-slot name="script">
        <script>
            let selectedArtStyleElement = null; // Holds the currently selected art style element
            let selectedArtStyle = null; // Currently selected art style

            // Creating a checkmark icon for denoting the selected art style
            const checkIconElement = document.createElement("i");
            checkIconElement.className = 'position-absolute top-2 end-2 bg-white rounded-circle p-0 border border-1 unicon-checkmark-outline-filled fs-4 text-primary';

            function selectArtStyle(artStyleElement) {
                // If there is already a art style selected then first
                // remove the border and checkmark from that element
                if (selectedArtStyleElement) {
                    const artStyleImgElement = selectedArtStyleElement.getElementsByTagName("img")[0];
                    const artStyleNameElement = selectedArtStyleElement.getElementsByTagName("div")[0];

                    selectedArtStyleElement.classList.remove("border", "border-primary", "border-5");
                    artStyleImgElement.classList.add("rounded");
                    artStyleNameElement.classList.add("rounded");
                    selectedArtStyleElement.removeChild(checkIconElement);
                }

                selectedArtStyleElement = artStyleElement;
                selectedArtStyle = selectedArtStyleElement.dataset.artStyle;

                const artStyleImgElement = selectedArtStyleElement.getElementsByTagName("img")[0];
                const artStyleNameElement = selectedArtStyleElement.getElementsByTagName("div")[0];

                // Give the border and check mark icon to
                // the selected art style
                selectedArtStyleElement.classList.add("border", "border-primary", "border-5");
                artStyleImgElement.classList.remove("rounded");
                artStyleNameElement.classList.remove("rounded");
                selectedArtStyleElement.append(checkIconElement);
            }

            $(document).ready(function() {
                // Check if there is already an art style selected
                // i.e. from backend. If so make it look selected 
                // on front-end.
                if (selectedArtStyle) {
                    const element = document.querySelector(`[data-art-style="${selectedArtStyle}"]`);
                    selectArtStyle(element);
                }

                $('#set-destination-select').change(function() {

                    var selectedOption = $(this).find('option:selected');
                    var isYoutubeLinked = selectedOption.data('is-youtube-linked');
                    var isTikTokLinked = selectedOption.data('is-tiktok-linked');

                    if (selectedOption.val() === 'youtube' && !isYoutubeLinked) {
                        window.location.href = "{{ route('youtube.auth') }}";
                    } else if (selectedOption.val() === 'tiktok' && !isTikTokLinked) {
                        window.location.href = "{{ route('tiktok.auth') }}";
                    } else {
                        $('#set-content-div').removeClass('d-none');
                    }
                });

                $('#set-content-select').change(function() {
                    $('#create-video-div').removeClass('d-none');
                });
            });
        </script>
    </x-slot>
</x-app-layout>