<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div>
                <x-label for="name" value="{{ __('Your Full Name') }}" />
                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            </div>


            <div class="mt-2">
                <x-label for="nationality" value="{{ __('Pakistani National or AJK National / Refugee') }}" />
                <select id="nationality" name="nationality" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" required>
                    <option value="">None</option>
                    <option value="Pakistani_National" {{ old('nationality') == 'Pakistani_National' ? 'selected' : '' }}>Pakistani National</option>
                    <option value="AJK_National" {{ old('nationality') == 'AJK_National' ? 'selected' : '' }}>AJK National / Jammu & Kashmir Refugee</option>
                </select>
            </div>



            <div class="mt-2">
                <label class="block font-medium font-extrabold text-sm text-black" for="degree_level">
                    Do you have Relevant Educational Qualification as Mentioned in  <a class="underline text-sm text-blue-600 hover:text-red-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ url('https://bankajk.com/eligibility.php') }}" target="_blank">
                        {{ __('Eligibility Criteria') }}
                    </a>
                     and Degree in these field <span class="text-red-600">Economics, Business Administration, Accounting, Finance, Commerce, Computer Sciences & IT</span>
                </label>
                <select id="degree_level" name="degree_level" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" required>
                    <option value="">None</option>
                    <option value="Bachelor (16 Years) Degree">Yes, I have Bachelor (16 Years) Degree as mentioned in Eligibility Criteria</option>
                    <option value="Master (16 Years) Degree">Yes, I have Master (16 Years) Degree as mentioned in Eligibility Criteria</option>
                    <option value="Master/ MS (18 Years) Degree">Yes, I have Master/ MS (18 Years) Degree as mentioned in Eligibility Criteria</option>
                    <option value="M-Phil (18 Years) Degree">Yes, I have M-Phil (18 Years) Degree as mentioned in Eligibility Criteria</option>
                </select>
            </div>

            <div class="mt-2">
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            </div>

            <div class="mt-2">
                <x-label for="date_of_birth" class="font-bold" value="{{ __('Date Of Birth (Max 27 Years)') }}" />
                <x-input id="date_of_birth"  max="2006-03-01" min="1997-03-01"  class="block mt-1 w-full" type="date" name="date_of_birth" :value="old('date_of_birth')" required autocomplete="date_of_birth" />
            </div>




            <div class="mt-2">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            </div>

            <div class="mt-2">
                <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-label for="terms">
                        <div class="flex items-center">
                            <x-checkbox name="terms" id="terms" required />

                            <div class="ml-2">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Terms of Service').'</a>',
                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Privacy Policy').'</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-label>
                </div>
            @endif

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-button class="ml-4">
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
