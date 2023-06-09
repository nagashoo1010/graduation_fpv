<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('パイロットプロフィール') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("プロフィールとメールアドレスを更新します。") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('pilot.profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')


        <div class="sm:w-1/2 md:w-1/2 lg:w-2/5">
            <img class="rounded-full overflow-hidden w-300 h-300" src=" {{ asset('storage/' . $user->user_image) }}">
        </div>


        <div>
            <label for="user_icon">{{ __('ユーザー画像') }}</label>
            <input type="file" name="user_icon" id="user_icon">
        </div>


        <div>
            <x-input-label for=" name" :value="__('お名前')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('メールアドレス')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            <x-input-label class="mt-4" for="age" :value="__('年齢')" />
            <x-text-input id="age" name="age" type="number" class="mt-1 block w-full" :value="old('age', $user->age)" required autocomplete="age" />

            <x-input-label class="mt-4" for="work_area" :value="__('活動拠点')" />
            <p class="text-white pt-2">{{ $user->work_area}}</p>
            <x-select-input id="work_area" name="work_area" class="mt-1 block w-full" :value="old('work_area', $user->work_area)" required autocomplete="work_area" />

            <x-input-label class="mt-4" for="message_pr" :value="__('PR Message')" />
            <textarea name="message_pr" id="message_pr" cols="70" rows="10" placeholder="PRしたいことなどご自由にご記載ください(500文字以内)" class='border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm'>{{ old('message_pr', $user->message_pr ?? '') }}</textarea>

            <x-input-label class="mt-4" for="achievement" :value="__('実績')" />
            <textarea name="achievement" id="achievement" cols="70" rows="10" placeholder="今までの活動や実績をご記載ください(500文字以内)" class='border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm'>{{ old('achievement', $user->achievement ?? '') }}</textarea>


            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <div>
                <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                    {{ __('Your email address is unverified.') }}

                    <button form="send-verification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                        {{ __('Click here to re-send the verification email.') }}
                    </button>
                </p>

                @if (session('status') === 'verification-link-sent')
                <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                    {{ __('A new verification link has been sent to your email address.') }}
                </p>
                @endif
            </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('保存') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600 dark:text-gray-400">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>