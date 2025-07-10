<section>
    <header>
        <h2 class="text-lg font-medium" style="color: #2c2c2c;">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm" style="color: #5a5a5a;">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <x-input-label for="update_password_current_password" :value="__('Current Password')" />
            <x-text-input id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password" :value="__('New Password')" />
            <x-text-input id="update_password_password" name="password" type="password" class="mt-1 block w-full" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>

<style>
.mt-6 {
    margin-top: 1.5rem;
}
.space-y-6 > * + * {
    margin-top: 1.5rem;
}
.mt-1 {
    margin-top: 0.25rem;
}
.mt-2 {
    margin-top: 0.5rem;
}
.block {
    display: block;
}
.w-full {
    width: 100%;
}
input[type="password"] {
    background-color: #f8f5eb;
    border: 1px solid #d2b48c;
    border-radius: 0.375rem;
    padding: 0.5rem 0.75rem;
    color: #2c2c2c;
    width: 100%;
}
input[type="password"]:focus {
    outline: none;
    border-color: #d4af37;
    box-shadow: 0 0 0 2px rgba(212, 175, 55, 0.25);
}
.flex {
    display: flex;
}
.items-center {
    align-items: center;
}
.gap-4 {
    gap: 1rem;
}
button {
    background: linear-gradient(135deg, #d4af37 0%, #b8941f 100%);
    color: white;
    font-weight: 600;
    padding: 0.5rem 1rem;
    border-radius: 0.375rem;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
}
button:hover {
    background: linear-gradient(135deg, #b8941f 0%, #a37e1a 100%);
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(184, 148, 31, 0.3);
}
</style>
</section>
