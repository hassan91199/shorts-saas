<x-app-layout>
    <!-- Section start -->
    <h2 class="h3 mt-5">{{ __('Profile Information') }}</h2>
    <div class="panel rounded-3 overflow-hidden bg-secondary dark:bg-gray-800 p-3">
        <form method="post" action="{{ route('profile.update') }}" class="vstack gap-1">
            @csrf
            @method('patch')

            <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}"
                class="form-control form-control-sm w-full fs-6 bg-white dark:border-white dark:border-gray-700"
                placeholder="Type your name here">
            <x-input-error :messages="$errors->get('name')" />

            <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}"
                class="form-control form-control-sm w-full fs-6 bg-white dark:border-white dark:border-gray-700"
                placeholder="Type your new email here">
            <x-input-error :messages="$errors->get('email')" />
            <p class="fs-7 fw-light">{{ __('Note: This will be your login email. Make sure to remember it!') }}</p>

            <div class="text-end mt-1">
                @if (session('status') === 'profile-updated')
                <span id="saved-message" class="fs-6 text-primary">{{ __('Saved!') }}</span>
                @endif

                <button type="submit" class="btn btn-sm btn-primary">Save</button>
            </div>
        </form>
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
                <label class="fs-5 fw-medium form-label" for="set-account-select">{{ __('Account') }} <i class="unicon-information" data-uc-tooltip="Select where you want the videos in your series to be uploaded or sent"></i></label>
                <select id="set-account-select" class="form-select form-control-sm rounded dark:bg-gray-100 dark:bg-opacity-5 dark:text-white dark:border-gray-800" name="" aria-label="" required>
                    <option value="" disabled selected>{{__('Select account')}}</option>
                    <!-- <option value="email">{{__('Email Me Instead')}}</option> -->
                </select>
            </div>

            <div id="" class="form-group vstack gap-1">
                <label class="fs-5 fw-medium form-label" for="description-footer-textarea">{{ __('Description Footer') }} <i class="unicon-information" data-uc-tooltip="This text will be added to the end of the description of every video uploaded to this account."></i></label>
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
            document.addEventListener("DOMContentLoaded", function() {
                setTimeout(function() {
                    document.getElementById('saved-message').style.display = 'none';
                }, 3000);
            });
        </script>
    </x-slot>
</x-app-layout>