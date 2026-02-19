<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            프로필 정보
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            계정의 프로필 정보와 이메일 주소를 수정할 수 있습니다.
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" value="이름" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="nickname" value="닉네임 (선택)" />
            <x-text-input id="nickname" name="nickname" type="text" class="mt-1 block w-full" :value="old('nickname', $user->nickname)" maxlength="50" autocomplete="nickname" placeholder="게시판 등에 표시될 이름" />
            <x-input-error class="mt-2" :messages="$errors->get('nickname')" />
            <p class="mt-1 text-sm text-gray-500">비어 있으면 이름이 표시됩니다.</p>
        </div>

        <div>
            <x-input-label for="email" value="이메일" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        이메일 주소가 인증되지 않았습니다.

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            인증 메일을 다시 받으려면 여기를 클릭하세요.
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            인증 링크가 이메일로 전송되었습니다.
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>저장</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >저장되었습니다.</p>
            @endif
        </div>
    </form>
</section>
