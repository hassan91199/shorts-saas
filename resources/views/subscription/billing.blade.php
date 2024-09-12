<x-app-layout>

    <h2 class="h3 mt-5">{{ __('Current Plan') }}</h2>

    <!-- Section start -->
    <div class="row g-1">
        <div class="col-md-12 col-lg-9">
            <div class="panel rounded-3 overflow-hidden bg-secondary dark:bg-gray-800 p-3">
                <p class="fs-5 fw-medium">{{ __('Current Plan: ') }}<span class="fs-5 fw-normal">{{ __($currentPlan) }}</span></p>
                <p class="fs-5 fw-medium">{{ __('Max Series: ') }}<span class="fs-5 fw-normal">{{ __($maxSeries) }}</span></p>
                <p class="fs-5 fw-medium">{{ __('Frequency: ') }}<span class="fs-5 fw-normal">{{ __($frequency) }}</span></p>
                <p class="fs-5 fw-medium">{{ __('Subscription Status: ') }}<span class="fs-5 fw-normal">{{ __($subscriptionStatus) }}</span></p>
                <p class="fs-5 fw-medium">{{ __('Next Billing Date: ') }}<span class="fs-5 fw-normal">{{ __($nextBillingDate) }}</span></p>
                <p class="fs-5 fw-medium">{{ __('Price: ') }}<span class="fs-5 fw-normal">{{ __('$' . $price) }}</span></p>

                <form action="{{ route('unsubscribe') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary text-white mt-3" {{ !$isUserSubscribed ? 'disabled' : '' }}>{{ __('Cancel Plan') }}</button>
                </form>
            </div>
        </div>
        <div class="col-md-12 col-lg-3">
            <div class="panel rounded-3 overflow-hidden bg-secondary p-3 h-100">
                <p class="fs-5 fw-medium">{{ __('Manage Billing') }}</p>
                <div class="mt-1">
                    <!-- <a href="" class="text-primary text-none">
                        <i class="unicon-document"></i>
                        <span class="fs-5 fw-normal">{{ __('View Invoices') }}</span>
                    </a> -->
                    <!-- <br> -->
                    @if($isStripeCustomer)
                    <a href="{{ route('billing.portal') }}" class="text-primary text-none">
                        <i class="unicon-wallet"></i>
                        <span class="fs-5 fw-normal">{{ __('Billing Portal') }}</span>
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Section end -->

    <h2 class="h3 mt-5">{{ __('Change Plan') }}</h2>

    <!-- Section start -->
    <div class="panel rounded-3 overflow-hidden bg-secondary dark:bg-gray-800 p-3">
        <div class="vstack items-center gap-3 lg:gap-4 mb-3 text-center">
            <ul class="uc-switcher-nav nav-x gap-0 p-narrow border rounded-2 fs-7 fw-medium" data-uc-switcher="connect: .pricing-switcher;">
                <li><a href="#" class="text-none w-128px cstack p-1" onclick="updateBillingCycle('month')">Monthly</a></li>
                <li><a href="#" class="text-none w-128px cstack p-1" onclick="updateBillingCycle('year')">Yearly</a></li>
            </ul>
        </div>
        <div class="content panel">
            <div class="row child-cols-12 xl:child-cols-6 col-match justify-center g-1">
                <div>
                    <div class="tier panel vstack justify-between p-2 rounded-1-5 lg:rounded-2 bg-white text-gray-900 text-center">
                        <header class="tier-header vstack gap-2 items-center p-2 md:p-4">
                            <h5 class="h5 lg:h4 m-0 text-primary">Free</h5>
                            <div class="d-flex gap-narrow items-end mt-1">
                                <h3 class="h1 lg:display-6 price m-0 text-dark">$0</h3>
                                <span class="h6 lg:h3 m-0 pb-narrow text-dark">/ <span class="billing-cycle">mo</span></span>
                            </div>
                            <form action="{{ route('unsubscribe') }}" method="POST">
                                @csrf
                                <button id="free-subscribe-button" class="btn btn-md lg:btn-lg btn-secondary w-100 mt-2" type="submit">
                                    <span>Try Now!</span>
                                </button>
                            </form>
                        </header>
                        <div class="tier-body border rounded-1-5 p-2 md:p-4">
                            <ul class="nav-y gap-2 text-start">
                                <li class="hstack items-start gap-2">
                                    <i class="cstack w-24px h-24px bg-secondary text-primary rounded-circle unicon-checkmark fw-bold"></i>
                                    <span class="d-inline">Creates 1 video</span>
                                </li>
                                <li class="hstack items-start gap-2">
                                    <i class="cstack w-24px h-24px bg-secondary text-primary rounded-circle unicon-checkmark fw-bold"></i>
                                    <span class="d-inline"><span id="free-series-count">1</span> Series</span>
                                </li>
                                <li class="hstack items-start gap-2">
                                    <i class="cstack w-24px h-24px bg-secondary text-primary rounded-circle unicon-checkmark fw-bold"></i>
                                    <span class="d-inline">Edit & preview videos</span>
                                </li>
                                <li class="hstack items-start gap-2">
                                    <i class="cstack w-24px h-24px bg-secondary text-danger rounded-circle unicon-close fw-bold"></i>
                                    <span class="d-inline text-line-through">Auto-post to channel</span>
                                </li>
                                <li class="hstack items-start gap-2">
                                    <i class="cstack w-24px h-24px bg-secondary text-danger rounded-circle unicon-close fw-bold"></i>
                                    <span class="d-inline text-line-through">HD Video Resolution</span>
                                </li>
                                <li class="hstack items-start gap-2">
                                    <i class="cstack w-24px h-24px bg-secondary text-danger rounded-circle unicon-close fw-bold"></i>
                                    <span class="d-inline text-line-through">Background Music</span>
                                </li>
                                <li class="hstack items-start gap-2">
                                    <i class="cstack w-24px h-24px bg-secondary text-danger rounded-circle unicon-close fw-bold"></i>
                                    <span class="d-inline text-line-through">No Watermark</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="tier panel vstack justify-between p-2 rounded-1-5 lg:rounded-2 bg-white text-gray-900 text-center">
                        <header class="tier-header vstack gap-2 items-center p-2 md:p-4">
                            <h5 class="h5 lg:h4 m-0 text-primary">Starter</h5>
                            <div class="d-flex gap-narrow items-end mt-1">
                                <h3 class="h1 lg:display-6 price m-0 text-dark">$<span id="starter-price">19</span></h3>
                                <span class="h6 lg:h3 m-0 pb-narrow text-dark">/ <span class="billing-cycle">mo</span></span>
                            </div>
                            <form action="{{ route('subscribe') }}" method="POST">
                                @csrf
                                <input type="hidden" name="plan_name" value="starter">
                                <input id="starter-billing-cycle-input" type="hidden" name="billing_cycle" value="month">
                                <input id="starter-series-input" type="hidden" name="num_series" value="1">

                                <button id="starter-subscribe-button" class="btn btn-md lg:btn-lg btn-secondary w-100 mt-2" type="submit">
                                    <span>Try Now!</span>
                                </button>
                            </form>
                        </header>
                        <div class="tier-body border rounded-1-5 p-2 md:p-4">
                            <ul class="nav-y gap-2 text-start">
                                <li class="hstack items-start gap-2">
                                    <i class="cstack w-24px h-24px bg-secondary text-primary rounded-circle unicon-checkmark fw-bold"></i>
                                    <span class="d-inline">Posts 3 times a week</span>
                                </li>
                                <li class="hstack items-start gap-1">
                                    <i class="cstack w-24px h-24px bg-secondary text-primary rounded-circle unicon-checkmark fw-bold"></i>
                                    <span class="d-inline"><span id="starter-series-count">1</span> Series</span>

                                    <button id="starter-series-increment-button" class="btn btn-outline-primary rounded-circle h-1 w-1 p-0" onclick="updateSeriesCount('starter', 'increment')">
                                        <i class='unicon-add fs-5'></i>
                                    </button>

                                    <button id="starter-series-decrement-button" class="btn btn-outline-primary rounded-circle h-1 w-1 p-0" onclick="updateSeriesCount('starter', 'decrement')">
                                        <i class='unicon-subtract fs-5'></i>
                                    </button>
                                </li>
                                <li class="hstack items-start gap-2">
                                    <i class="cstack w-24px h-24px bg-secondary text-primary rounded-circle unicon-checkmark fw-bold"></i>
                                    <span class="d-inline">Edit & preview videos</span>
                                </li>
                                <li class="hstack items-start gap-2">
                                    <i class="cstack w-24px h-24px bg-secondary text-primary rounded-circle unicon-checkmark fw-bold"></i>
                                    <span class="d-inline">Auto-post to channel</span>
                                </li>
                                <li class="hstack items-start gap-2">
                                    <i class="cstack w-24px h-24px bg-secondary text-primary rounded-circle unicon-checkmark fw-bold"></i>
                                    <span class="d-inline">HD Video Resolution</span>
                                </li>
                                <li class="hstack items-start gap-2">
                                    <i class="cstack w-24px h-24px bg-secondary text-primary rounded-circle unicon-checkmark fw-bold"></i>
                                    <span class="d-inline">Background Music</span>
                                </li>
                                <li class="hstack items-start gap-2">
                                    <i class="cstack w-24px h-24px bg-secondary text-primary rounded-circle unicon-checkmark fw-bold"></i>
                                    <span class="d-inline">No Watermark</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="tier panel vstack justify-between p-2 rounded-1-5 lg:rounded-2 bg-white text-gray-900 text-center">
                        <header class="tier-header vstack gap-2 items-center p-2 md:p-4">
                            <h5 class="h5 lg:h4 m-0 text-primary">Daily</h5>
                            <div class="d-flex gap-narrow items-end mt-1">
                                <h3 class="h1 lg:display-6 price m-0 text-dark">$<span id="daily-price">39</span></h3>
                                <span class="h6 lg:h3 m-0 pb-narrow text-dark">/ <span class="billing-cycle">mo</span></span>
                            </div>
                            <form action="{{ route('subscribe') }}" method="POST">
                                @csrf
                                <input type="hidden" name="plan_name" value="daily">
                                <input id="daily-billing-cycle-input" type="hidden" name="billing_cycle" value="month">
                                <input id="daily-series-input" type="hidden" name="num_series" value="1">

                                <button id="daily-subscribe-button" class="btn btn-md lg:btn-lg btn-secondary w-100 mt-2" type="submit">
                                    <span>Try Now!</span>
                                </button>
                            </form>
                        </header>
                        <div class="tier-body border rounded-1-5 p-2 md:p-4">
                            <ul class="nav-y gap-2 text-start">
                                <li class="hstack items-start gap-2">
                                    <i class="cstack w-24px h-24px bg-secondary text-primary rounded-circle unicon-checkmark fw-bold"></i>
                                    <span class="d-inline">Posts once a day</span>
                                </li>
                                <li class="hstack items-start gap-1">
                                    <i class="cstack w-24px h-24px bg-secondary text-primary rounded-circle unicon-checkmark fw-bold"></i>
                                    <span class="d-inline"><span id="daily-series-count">1</span> Series</span>

                                    <button id="daily-series-increment-button" class="btn btn-outline-primary rounded-circle h-1 w-1 p-0" onclick="updateSeriesCount('daily', 'increment')">
                                        <i class='unicon-add fs-5'></i>
                                    </button>

                                    <button id="daily-series-decrement-button" class="btn btn-outline-primary rounded-circle h-1 w-1 p-0" onclick="updateSeriesCount('daily', 'decrement')">
                                        <i class='unicon-subtract fs-5'></i>
                                    </button>
                                </li>
                                <li class="hstack items-start gap-2">
                                    <i class="cstack w-24px h-24px bg-secondary text-primary rounded-circle unicon-checkmark fw-bold"></i>
                                    <span class="d-inline">Edit & preview videos</span>
                                </li>
                                <li class="hstack items-start gap-2">
                                    <i class="cstack w-24px h-24px bg-secondary text-primary rounded-circle unicon-checkmark fw-bold"></i>
                                    <span class="d-inline">Auto-post to channel</span>
                                </li>
                                <li class="hstack items-start gap-2">
                                    <i class="cstack w-24px h-24px bg-secondary text-primary rounded-circle unicon-checkmark fw-bold"></i>
                                    <span class="d-inline">HD Video Resolution</span>
                                </li>
                                <li class="hstack items-start gap-2">
                                    <i class="cstack w-24px h-24px bg-secondary text-primary rounded-circle unicon-checkmark fw-bold"></i>
                                    <span class="d-inline">Background Music</span>
                                </li>
                                <li class="hstack items-start gap-2">
                                    <i class="cstack w-24px h-24px bg-secondary text-primary rounded-circle unicon-checkmark fw-bold"></i>
                                    <span class="d-inline">No Watermark</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="tier panel vstack justify-between p-2 rounded-1-5 lg:rounded-2 bg-white text-gray-900 text-center">
                        <header class="tier-header vstack gap-2 items-center p-2 md:p-4">
                            <h5 class="h5 lg:h4 m-0 text-primary">Hardcore</h5>
                            <div class="d-flex gap-narrow items-end mt-1">
                                <h3 class="h1 lg:display-6 price m-0 text-dark">$<span id="hardcore-price">69</span></h3>
                                <span class="h6 lg:h3 m-0 pb-narrow text-dark">/ <span class="billing-cycle">mo</span></span>
                            </div>
                            <form action="{{ route('subscribe') }}" method="POST">
                                @csrf
                                <input type="hidden" name="plan_name" value="hardcore">
                                <input id="hardcore-billing-cycle-input" type="hidden" name="billing_cycle" value="month">
                                <input id="hardcore-series-input" type="hidden" name="num_series" value="1">

                                <button id="hardcore-subscribe-button" class="btn btn-md lg:btn-lg btn-secondary w-100 mt-2" type="submit">
                                    <span>Try Now!</span>
                                </button>
                            </form>
                        </header>
                        <div class="tier-body border rounded-1-5 p-2 md:p-4">
                            <ul class="nav-y gap-2 text-start">
                                <li class="hstack items-start gap-2">
                                    <i class="cstack w-24px h-24px bg-secondary text-primary rounded-circle unicon-checkmark fw-bold"></i>
                                    <span class="d-inline">Posts twice a day</span>
                                </li>
                                <li class="hstack items-start gap-1">
                                    <i class="cstack w-24px h-24px bg-secondary text-primary rounded-circle unicon-checkmark fw-bold"></i>
                                    <span class="d-inline"><span id="hardcore-series-count">1</span> Series</span>

                                    <button id="hardcore-series-increment-button" class="btn btn-outline-primary rounded-circle h-1 w-1 p-0" onclick="updateSeriesCount('hardcore', 'increment')">
                                        <i class='unicon-add fs-5'></i>
                                    </button>

                                    <button id="hardcore-series-decrement-button" class="btn btn-outline-primary rounded-circle h-1 w-1 p-0" onclick="updateSeriesCount('hardcore', 'decrement')">
                                        <i class='unicon-subtract fs-5'></i>
                                    </button>
                                </li>
                                <li class="hstack items-start gap-2">
                                    <i class="cstack w-24px h-24px bg-secondary text-primary rounded-circle unicon-checkmark fw-bold"></i>
                                    <span class="d-inline">Edit & preview videos</span>
                                </li>
                                <li class="hstack items-start gap-2">
                                    <i class="cstack w-24px h-24px bg-secondary text-primary rounded-circle unicon-checkmark fw-bold"></i>
                                    <span class="d-inline">Auto-post to channel</span>
                                </li>
                                <li class="hstack items-start gap-2">
                                    <i class="cstack w-24px h-24px bg-secondary text-primary rounded-circle unicon-checkmark fw-bold"></i>
                                    <span class="d-inline">HD Video Resolution</span>
                                </li>
                                <li class="hstack items-start gap-2">
                                    <i class="cstack w-24px h-24px bg-secondary text-primary rounded-circle unicon-checkmark fw-bold"></i>
                                    <span class="d-inline">Background Music</span>
                                </li>
                                <li class="hstack items-start gap-2">
                                    <i class="cstack w-24px h-24px bg-secondary text-primary rounded-circle unicon-checkmark fw-bold"></i>
                                    <span class="d-inline">No Watermark</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
                                <!-- <a href="#" class="btn btn-sm lg:btn-md btn-primary px-3 mt-2">
                                    <span>Still have a question?</span>
                                    <i class="icon icon-narrow unicon-arrow-right fw-bold rtl:rotate-180"></i>
                                </a> -->
                            </div>
                        </div>
                        <div class="lg:col-6">
                            <div class="panel">
                                <ul class="gap-2" data-uc-accordion="targets: > li; multiple: true">
                                    <h5 class="h5 text-uppercase">Series & Videos</h5>

                                    <li class="panel p-2 md:p-4 border rounded-1-5">
                                        <a class="uc-accordion-title fs-5 sm:fs-4 ltr:pe-4 rtl:ps-4" href="#">What is a Series?</a>
                                        <div class="uc-accordion-content">
                                            <p>A "Series" in AutoShorts.ai is a set of instructions that tells our AI how to create and post videos automatically. It includes your chosen topic, posting schedule, and target social media accounts, allowing the system to produce and share videos without your manual input.
                                                <br><br>
                                                For example, you could create a series called "Scary Stories" that automatically creates content and posts to TikTok and YouTube every day at 9PM EST.
                                                <br><br>
                                                Other important things to know:
                                                <br><br>
                                                - Each series can link to one TikTok and one YouTube channel.
                                                <br>
                                                - You can delete and create a new series to change your topic (up to 10 times per day).
                                            </p>
                                        </div>
                                    </li>
                                    <li class="panel p-2 md:p-4 border rounded-1-5">
                                        <a class="uc-accordion-title fs-5 sm:fs-4 ltr:pe-4 rtl:ps-4" href="#">Can I create videos in any niche?</a>
                                        <div class="uc-accordion-content">
                                            <p>You bet! You can create a series for nearly any topic or niche you want. Either choose from our preset list or use a custom prompt to describe your own.</p>
                                        </div>
                                    </li>
                                    <li class="panel p-2 md:p-4 border rounded-1-5">
                                        <a class="uc-accordion-title fs-5 sm:fs-4 ltr:pe-4 rtl:ps-4" href="#">What social media platforms do you support posting to?</a>
                                        <div class="uc-accordion-content">
                                            <p>We currently support posting to TikTok and YouTube. We are working on adding support for other platforms.</p>
                                        </div>
                                    </li>
                                    <li class="panel p-2 md:p-4 border rounded-1-5">
                                        <a class="uc-accordion-title fs-5 sm:fs-4 ltr:pe-4 rtl:ps-4" href="#">Are the videos unique?</a>
                                        <div class="uc-accordion-content">
                                            <p>Unlike other services that re-use the same video over and over, we create a new video for each series using generative AI. This means that each video is unique and will not be the same as any other video. Even if two videos have the same topic, the script and images will be completely different due to generative AI.</p>
                                        </div>
                                    </li>
                                    <li class="panel p-2 md:p-4 border rounded-1-5">
                                        <a class="uc-accordion-title fs-5 sm:fs-4 ltr:pe-4 rtl:ps-4" href="#">Can I edit the videos?</a>
                                        <div class="uc-accordion-content">
                                            <p>Yes, you can edit basic details such as your video's script, title, and background music at anytime before it is scheduled to post.</p>
                                        </div>
                                    </li>
                                    <li class="panel p-2 md:p-4 border rounded-1-5">
                                        <a class="uc-accordion-title fs-5 sm:fs-4 ltr:pe-4 rtl:ps-4" href="#">How do custom prompts work?</a>
                                        <div class="uc-accordion-content">
                                            <p>
                                                Let's say you enter a custom prompt for your series, such as: "Discuss an interesting fact about Genghis Khan". Each video that is created in your series will follow the prompt you gave, while also doing its best to avoid duplicating content from past videos in the same series. So, the first video might be a fact about Genghis Khan's military, the next may be about Genghis Khan's leadership, then his legal code, etc.
                                                <br><br>
                                                If you wanted each video in your series to be about something different but still follow the general category of war, then your prompt should be something like: "Please write about a highly interesting event that happened in history related to war." In this case, the first video may be about 300 from Troy, then about The Battle of Gettysburg, etc.
                                                <br><br>
                                                If you've ever used ChatGPT before, it's similar to if you gave it your instructions and asked it to write a video script related to that. Each time you ask it, it will come up with something different. The videos in the series behave similarly.
                                                <br><br>
                                                Still have questions? Check out our custom prompt guide.
                                            </p>
                                        </div>
                                    </li>
                                    <li class="panel p-2 md:p-4 border rounded-1-5">
                                        <a class="uc-accordion-title fs-5 sm:fs-4 ltr:pe-4 rtl:ps-4" href="#">How many videos can I create per day?</a>
                                        <div class="uc-accordion-content">
                                            <p>
                                                The number of videos created by each series can be seen on our <a href="#pricing">pricing page</a>. Remember, AutoShorts doesn't focus on individual video creation. Instead, you set up a Series that automatically generates videos on a schedule.
                                                <br><br>
                                                Features that render a new video such as making script edits, or changing your series do not count against your plan.
                                            </p>
                                        </div>
                                    </li>
                                    <li class="panel p-2 md:p-4 border rounded-1-5">
                                        <a class="uc-accordion-title fs-5 sm:fs-4 ltr:pe-4 rtl:ps-4" href="#">Can I replace an existing series with a new one?</a>
                                        <div class="uc-accordion-content">
                                            <p>Absolutely! You can delete any current series and start fresh with a new topic or settings anytime (up to 10 times per day). Note: With our free plan, you're able to create one series per account.</p>
                                        </div>
                                    </li>
                                    <li class="panel p-2 md:p-4 border rounded-1-5">
                                        <a class="uc-accordion-title fs-5 sm:fs-4 ltr:pe-4 rtl:ps-4" href="#">How do I create a video?</a>
                                        <div class="uc-accordion-content">
                                            <p>It's important to know that AutoShorts.ai wasn't designed for single video creation, but instead for creating a series of videos on a regular schedule. First you need to create a <a href="#">series</a>. Once you do, the first video in your series will be automatically be queued for creation.</p>
                                        </div>
                                    </li>
                                    <li class="panel p-2 md:p-4 border rounded-1-5">
                                        <a class="uc-accordion-title fs-5 sm:fs-4 ltr:pe-4 rtl:ps-4" href="#">Can I adust the video length?</a>
                                        <div class="uc-accordion-content">
                                            <p>When creating your series, you can choose between "30 to 60 seconds" or "60 to 90 seconds" length options. For more fine-tuned length control you can manually modify the length of your AI generated script, up to 1,600 characters max.</p>
                                        </div>
                                    </li>
                                    <li class="panel p-2 md:p-4 border rounded-1-5">
                                        <a class="uc-accordion-title fs-5 sm:fs-4 ltr:pe-4 rtl:ps-4" href="#">Do I own the videos?</a>
                                        <div class="uc-accordion-content">
                                            <p>Yes, the videos are yours to do with as you please. You can download them and use them on other platforms, or even sell them to clients.</p>
                                        </div>
                                    </li>
                                    <li class="panel p-2 md:p-4 border rounded-1-5">
                                        <a class="uc-accordion-title fs-5 sm:fs-4 ltr:pe-4 rtl:ps-4" href="#">Does the platform support multiple languages?</a>
                                        <div class="uc-accordion-content">
                                            <p>Yes, we currently support the following languages: English, Czech, Danish, Dutch, French, German, Greek, Hindi, Indonesian, Italian, Japanese, Korean, Polish, Portuguese, Russian, Spanish, Swedish, Turkish, and Ukrainian.</p>
                                        </div>
                                    </li>
                                    <li class="panel p-2 md:p-4 border rounded-1-5">
                                        <a class="uc-accordion-title fs-5 sm:fs-4 ltr:pe-4 rtl:ps-4" href="#">Are there any types of content that are not allowed?</a>
                                        <div class="uc-accordion-content">
                                            <p>We have a NSFW filter on our generative AI models, but we cannot guarantee that all content will be appropriate for all audiences. We are not responsible for any content that is created by our platform.</p>
                                        </div>
                                    </li>
                                    <li class="panel p-2 md:p-4 border rounded-1-5">
                                        <a class="uc-accordion-title fs-5 sm:fs-4 ltr:pe-4 rtl:ps-4" href="#">Can this make long form content?</a>
                                        <div class="uc-accordion-content">
                                            <p>Not at the moment. We focus on short form content, up to 90 seconds in length. We are working on a long form content feature, but it is not currently available.</p>
                                        </div>
                                    </li>

                                    <h5 class="h5 pt-3 text-uppercase">Billing</h5>

                                    <li class="panel p-2 md:p-4 border rounded-1-5">
                                        <a class="uc-accordion-title fs-5 sm:fs-4 ltr:pe-4 rtl:ps-4" href="#">Is there a free trial?</a>
                                        <div class="uc-accordion-content">
                                            <p>You bet your sweet bippy there is. Simply <a href="#">create an account</a> and you can create your first series for free to test a video. No credit card required.</p>
                                        </div>
                                    </li>
                                    <li class="panel p-2 md:p-4 border rounded-1-5">
                                        <a class="uc-accordion-title fs-5 sm:fs-4 ltr:pe-4 rtl:ps-4" href="#">Can I cancel at anytime?</a>
                                        <div class="uc-accordion-content">
                                            <p>Absolutely. We hate services that purposefully make it difficult to cancel. You can cancel at the click of a button from the dashboard's billing page.</p>
                                        </div>
                                    </li>
                                    <li class="panel p-2 md:p-4 border rounded-1-5">
                                        <a class="uc-accordion-title fs-5 sm:fs-4 ltr:pe-4 rtl:ps-4" href="#">How does the membership work?</a>
                                        <div class="uc-accordion-content">
                                            <p>Beyond the free plan, we offer different tiers of paid memberships. The paid plans remove the watermark and allow you to post more frequently.</p>
                                        </div>
                                    </li>
                                    <li class="panel p-2 md:p-4 border rounded-1-5">
                                        <a class="uc-accordion-title fs-5 sm:fs-4 ltr:pe-4 rtl:ps-4" href="#">Can I get a refund?</a>
                                        <div class="uc-accordion-content">
                                            <p>Unfortunately, we cannot offer refunds as costs incurred for creating AI videos and generating AI photos are extremely high. In turn, our upstream providers do not let us ask for refunds for the GPU processing time used to create your AI videos. This would make it a loss making endeavor for us. During sign up you agree to withhold your right to refund for this reason. You can cancel any time though and your subscription ends.</p>
                                        </div>
                                    </li>
                                    <li class="panel p-2 md:p-4 border rounded-1-5">
                                        <a class="uc-accordion-title fs-5 sm:fs-4 ltr:pe-4 rtl:ps-4" href="#">Can I upgrade or downgrade my subscription?</a>
                                        <div class="uc-accordion-content">
                                            <p>Yes, you can upgrade or downgrade your subscription at any time. Go to the <a href="#">billing tab</a> and select the plan you want to upgrade / downgrade to. If you move to a plan with less series than you currently have, the extra series will be automatically disabled.</p>
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

    <x-slot name="script">
        <script>
            let billingCycle = 'month';
            const plans = ['starter', 'daily', 'hardcore'];

            function updateBillingCycle(cycle) {
                billingCycle = cycle;

                const billingCycleElements = document.getElementsByClassName('billing-cycle');

                for (let i = 0; i < billingCycleElements.length; i++) {
                    billingCycleElements[i].innerText = cycle == 'month' ? 'mo' : 'yr';
                }

                plans.forEach(planName => {
                    const planPriceElement = document.getElementById(`${planName}-price`);

                    const planSeriesCountElement = document.getElementById(`${planName}-series-count`);
                    const planSeriesCount = Number(planSeriesCountElement.innerText);

                    planPriceElement.innerText = calculatePrice(planName, billingCycle, planSeriesCount);

                    const planBillingCycleInput = document.getElementById(`${planName}-billing-cycle-input`);
                    planBillingCycleInput.value = billingCycle;
                });

                handleSubscribeButtonDisable();
            }

            function handleSubscribeButtonDisable() {
                const isLoggedIn = Boolean("{{ $isUserLoggedIn }}");

                if (!isLoggedIn) return;

                const userSubscribedPlan = "{{ $userSubscribedPlan }}";
                const userSubscribedPlanBillingCycle = "{{ $userSubscribedPlanBillingCycle }}";
                const userSubscribedQuantity = "{{ $userSubscribedPlanQuantity }}";

                if (userSubscribedPlan != '' && userSubscribedPlanBillingCycle != '' && userSubscribedQuantity != '') {
                    const seriesCountElement = document.getElementById(`${userSubscribedPlan}-series-count`);
                    let seriesCount = Number(seriesCountElement.innerText);

                    const planButtonElement = document.getElementById(`${userSubscribedPlan}-subscribe-button`);

                    if (userSubscribedQuantity == seriesCount && userSubscribedPlanBillingCycle == billingCycle) {
                        planButtonElement.disabled = true;
                    } else {
                        planButtonElement.disabled = false;
                    }
                } else {
                    // the subscribed plan is free so disable the free button
                    const planButtonElement = document.getElementById(`free-subscribe-button`);
                    planButtonElement.disabled = true;
                }
            }

            function calculatePrice(planName, billingCycle, seriesCount) {
                const basePrices = {
                    'starter': {
                        'month': 19,
                        'year': 192,
                    },
                    'daily': {
                        'month': 39,
                        'year': 369,
                    },
                    'hardcore': {
                        'month': 69,
                        'year': 696,
                    }
                };

                return basePrices[planName][billingCycle] * seriesCount;
            }

            function updateSeriesCount(planName, operation) {
                const seriesCountElement = document.getElementById(`${planName}-series-count`);
                let seriesCount = Number(seriesCountElement.innerText);

                if (operation === 'increment' && seriesCount < 10) {
                    seriesCount++;
                } else if (operation === 'decrement' && seriesCount > 1) {
                    seriesCount--;
                }

                // Updating the series count on the user interface
                seriesCountElement.innerText = seriesCount;

                // Updaing the series count in the subcription form
                const seriesInputElement = document.getElementById(`${planName}-series-input`);
                seriesInputElement.value = seriesCount;

                // Updating the plan price according to the selected number of series
                const planPriceElement = document.getElementById(`${planName}-price`);
                planPriceElement.innerText = calculatePrice(planName, billingCycle, seriesCount);

                handleSubscribeButtonDisable();
            }

            document.addEventListener('DOMContentLoaded', function() {
                handleSubscribeButtonDisable();
            });
        </script>
    </x-slot>
</x-app-layout>