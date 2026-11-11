<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            <div>
                <x-label for="name" value="{{ __('Name') }}" />
                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            </div>

            <div class="mt-4">
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-label for="terms">
                        <div class="flex items-center">
                            <x-checkbox name="terms" id="terms" required />

                            <div class="ms-2">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Terms of Service').'</a>',
                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Privacy Policy').'</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-label>
                </div>
            @endif
            <div class="flex items-center space-x-4">
                <x-label for="role" value="{{ __('Register as:') }}" />
                <select id="role" name="role" class=" input-primary mt-1" required>
                    <option value="customer">Customer</option>
                    <option value="seller">Seller</option>
                </select>
            </div>

            <div class="mt-4">
                <x-label for="phone" value="{{ __('Phone Number') }}" />
                <x-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" />
            </div>

            {{-- Seller-only section --}}
            <div id="seller-fields" class="mt-4 hidden">
                <x-label for="address" value="{{ __('Address') }}" />
                <x-input id="address" class="block mt-1 w-full" type="text" name="address" />

                <x-label for="city" value="{{ __('City') }}" class="mt-4" />
                <x-input id="city" class="block mt-1 w-full" type="text" name="city" />

                <x-label for="postcode" value="{{ __('Post Code') }}" class="mt-4" />
                <x-input id="postcode" class="block mt-1 w-full" type="text" name="postcode" />

                <x-label for="state" value="{{ __('State') }}" class="mt-4" />
                <x-input id="state" class="block mt-1 w-full" type="text" name="state" />

                <x-label for="country" value="{{ __('Country') }}" class="mt-4" />
                <x-input id="country" class="block mt-1 w-full" type="text" name="country" value="Malaysia"/>

                <x-label for="description" value="{{ __('Description') }}" class="mt-4" />
                <textarea id="description" name="description" class="input-primary block mt-1 w-full h-24"></textarea>
            </div>

            <script>
                const roleSelect = document.getElementById('role');
                const sellerFields = document.getElementById('seller-fields');

                roleSelect.addEventListener('change', () => {
                    if (roleSelect.value === 'seller') {
                        sellerFields.classList.remove('hidden');
                    } else {
                        sellerFields.classList.add('hidden');
                    }
                });
            </script>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-button class="ms-4">
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
