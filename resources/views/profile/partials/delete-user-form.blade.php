<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium" style="color: #2c2c2c;">
            {{ __('Delete Account') }}
        </h2>

        <p class="mt-1 text-sm" style="color: #5a5a5a;">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >{{ __('Delete Account') }}</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Are you sure you want to delete your account?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4"
                    placeholder="{{ __('Password') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    {{ __('Delete Account') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>

<style>
.space-y-6 > * + * {
    margin-top: 1.5rem;
}
.mt-1 {
    margin-top: 0.25rem;
}
.mt-2 {
    margin-top: 0.5rem;
}
.mt-6 {
    margin-top: 1.5rem;
}
.text-lg {
    font-size: 1.125rem;
    line-height: 1.75rem;
}
.font-medium {
    font-weight: 500;
}
.text-sm {
    font-size: 0.875rem;
    line-height: 1.25rem;
}
.p-6 {
    padding: 1.5rem;
}
.flex {
    display: flex;
}
.justify-end {
    justify-content: flex-end;
}
.ms-3 {
    margin-left: 0.75rem;
}
.sr-only {
    position: absolute;
    width: 1px;
    height: 1px;
    padding: 0;
    margin: -1px;
    overflow: hidden;
    clip: rect(0, 0, 0, 0);
    white-space: nowrap;
    border-width: 0;
}
.block {
    display: block;
}
.w-3\/4 {
    width: 75%;
}
input[type="password"] {
    background-color: #f8f5eb;
    border: 1px solid #d2b48c;
    border-radius: 0.375rem;
    padding: 0.5rem 0.75rem;
    color: #2c2c2c;
}
input[type="password"]:focus {
    outline: none;
    border-color: #d4af37;
    box-shadow: 0 0 0 2px rgba(212, 175, 55, 0.25);
}
button {
    padding: 0.5rem 1rem;
    border-radius: 0.375rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
}
button:hover {
    transform: translateY(-1px);
}
x-danger-button {
    background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
    color: white;
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 0.375rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
}
x-danger-button:hover {
    background: linear-gradient(135deg, #c82333 0%, #bd2130 100%);
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(220, 53, 69, 0.3);
}
x-secondary-button {
    background-color: #f8f5eb;
    color: #2c2c2c;
    border: 1px solid #d2b48c;
    padding: 0.5rem 1rem;
    border-radius: 0.375rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
}
x-secondary-button:hover {
    background-color: #e6ddd4;
    transform: translateY(-1px);
}
</style>
</section>
