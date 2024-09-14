<x-app-layout>
    <!-- Section start -->
    <h2 class="h3 mt-5">{{ __('Update Email') }}</h2>
    <div class="panel rounded-3 overflow-hidden bg-secondary dark:bg-gray-800 p-3">
        <form class="vstack gap-1 d-flex flex-row">
            <input type="email"
                class="form-control form-control-sm w-full fs-6 bg-white dark:border-white dark:border-gray-700"
                placeholder="Type your new email here">
            <button type="submit" class="btn btn-sm btn-primary">Save</button>
        </form>
        <p class="fs-7 fw-light mt-2">{{ __('Note: This will be your login email. Make sure to remember it!') }}</p>
    </div>
    <!-- Section end -->


    <!-- Section start -->
    <h2 class="h3 mt-5">{{ __('Change Password') }}</h2>
    <div class="panel rounded-3 overflow-hidden bg-secondary dark:bg-gray-800 p-3">
        <form class="vstack gap-1">
            <input type="password"
                class="form-control form-control-sm w-full fs-6 bg-white dark:border-white dark:border-gray-700"
                placeholder="New Password">

            <input type="password"
                class="form-control form-control-sm w-full fs-6 bg-white dark:border-white dark:border-gray-700"
                placeholder="Confirm Password">

            <div class="text-end mt-1">
                <button type="submit" class="btn btn-sm btn-primary">Save</button>
            </div>
        </form>
    </div>
    <!-- Section end -->

    <!-- Section start -->
    <h2 class="h3 mt-5">{{ __('Linked Accounts') }}</h2>
    <div class="panel rounded-3 overflow-hidden bg-secondary dark:bg-gray-800 p-3">
        <form class="vstack gap-1">
            <div id="" class="form-group vstack gap-1">
                <label class="fs-5 fw-medium form-label" for="set-account-select">{{ __('Account') }} <i class="unicon-information" title="Select where you want the videos in your series to be uploaded or sent"></i></label>
                <select id="set-account-select" class="form-select form-control-sm rounded dark:bg-gray-100 dark:bg-opacity-5 dark:text-white dark:border-gray-800" name="" aria-label="" required>
                    <option value="" disabled selected>{{__('Select account')}}</option>
                    <!-- <option value="email">{{__('Email Me Instead')}}</option> -->
                </select>
            </div>

            <div id="" class="form-group vstack gap-1">
                <label class="fs-5 fw-medium form-label" for="description-footer-textarea">{{ __('Description Footer') }} <i class="unicon-information" title="This text will be added to the end of the description of every video uploaded to this account."></i></label>
                <textarea for="description-footer-textarea" class="form-control min-h-100px h-auto w-full bg-white dark:border-white dark:text-dark" placeholder="Appears at the end of every video description / caption. 
                
Example: &quot;Subscribe to our channel for more videos!&quot;"></textarea>
            </div>


            <div class="d-flex justify-between align-items-center mt-1">
                <button type="submit" class="btn btn-sm btn-primary" disabled>Unlink Account</button>
                <button type="submit" class="btn btn-sm btn-primary" disabled>Save</button>
            </div>
        </form>
    </div>
    <!-- Section end -->

    <x-slot name="script">
        <script>
            const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
            const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
        </script>
    </x-slot>
</x-app-layout>