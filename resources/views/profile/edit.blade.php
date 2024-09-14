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
        <form method="post" action="{{ route('password.update') }}" class="vstack gap-1">
            @csrf
            @method('put')

            <input type="password" name="current_password"
                class="form-control form-control-sm w-full fs-6 bg-white dark:border-white dark:border-gray-700"
                placeholder="{{ __('Current Password') }}">
            <x-input-error :messages="$errors->updatePassword->get('current_password')" />

            <input type="password" name="password"
                class="form-control form-control-sm w-full fs-6 bg-white dark:border-white dark:border-gray-700"
                placeholder="{{ __('New Password') }}">
            <x-input-error :messages="$errors->updatePassword->get('password')" />

            <input type="password" name="password_confirmation"
                class="form-control form-control-sm w-full fs-6 bg-white dark:border-white dark:border-gray-700"
                placeholder="{{ __('Confirm Password') }}">
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" />

            <div class="text-end mt-1">
                @if (session('status') === 'password-updated')
                <span id="saved-message" class="fs-6 text-primary">{{ __('Saved!') }}</span>
                @endif
                <button type="submit" class="btn btn-sm btn-primary">{{ __('Save') }}</button>
            </div>
        </form>
    </div>
    <!-- Section end -->

    <!-- Section start -->
    <h2 class="h3 mt-5">{{ __('Linked Accounts') }}</h2>
    <div class="panel rounded-3 overflow-hidden bg-secondary dark:bg-gray-800 p-3">
        <form method="post" action="{{ route('account.update') }}" class="vstack gap-1">
            @csrf
            @method('patch')

            <div id="" class="form-group vstack gap-1">
                <label class="fs-5 fw-medium form-label" for="set-account-select">{{ __('Account') }} <i class="unicon-information" data-uc-tooltip="Select where you want the videos in your series to be uploaded or sent"></i></label>
                <select id="set-account-select" class="form-select form-control-sm rounded dark:bg-gray-100 dark:bg-opacity-5 dark:text-white dark:border-gray-800" name="" aria-label="">
                    <option value="" disabled selected>{{__('Select account')}}</option>
                    <option value="youtube">{{__('Link a Youtube Account +')}}</option>
                    <option value="tiktok">{{__('Link a Tik Tok Account +')}}</option>
                </select>
            </div>

            <div id="" class="form-group vstack gap-1">
                <label class="fs-5 fw-medium form-label" for="description-footer-textarea">{{ __('Description Footer') }} <i class="unicon-information" data-uc-tooltip="This text will be added to the end of the description of every video uploaded to this account."></i></label>
                <textarea id="description-footer-textarea" class="form-control min-h-100px h-auto w-full bg-white dark:border-white dark:text-dark" name="description_footer" placeholder="Appears at the end of every video description / caption. 
                
Example: &quot;Subscribe to our channel for more videos!&quot;">{{ old('description_footer', $user->description_footer) }}</textarea>
            </div>


            <div class="d-flex justify-between align-items-center mt-1">
                <button type="submit" class="btn btn-sm btn-primary" disabled>Unlink Account</button>
                <button id="update-account-save-button" type="submit" class="btn btn-sm btn-primary" disabled>Save</button>
            </div>
        </form>
    </div>
    <!-- Section end -->

    <x-slot name="script">
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const savedMessageElement = document.getElementById('saved-message');
                setTimeout(function() {
                    if (savedMessageElement) {
                        savedMessageElement.style.display = 'none';
                    }
                }, 3000);

                document.getElementById('set-account-select').addEventListener('change', function() {
                    var selectedOption = this.options[this.selectedIndex];

                    if (selectedOption.value === 'youtube') {
                        window.location.href = "{{ route('youtube.auth') }}";
                    }

                    if (selectedOption.value === 'tiktok') {
                        window.location.href = "{{ route('tiktok.auth') }}";
                    }
                });

                document.getElementById('description-footer-textarea').addEventListener('input', function() {
                    document.getElementById('update-account-save-button').disabled = false;
                });
            });
        </script>
    </x-slot>
</x-app-layout>