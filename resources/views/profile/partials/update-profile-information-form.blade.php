<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <!-- Nome -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)"
                required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <!-- Email -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)"
                required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
        </div>

        <!-- Tipo de Contrato -->
        <div>
            <x-input-label for="type_of_employee" :value="__('Tipo de Contrato')" />
            <select name="type_of_employee" id="type_of_employee"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option value="bolsista"
                    {{ old('type_of_employee', $user->type_of_employee) === 'bolsista' ? 'selected' : '' }}>Bolsista
                </option>
                <option value="CLT"
                    {{ old('type_of_employee', $user->type_of_employee) === 'CLT' ? 'selected' : '' }}>CLT</option>
                <option value="CLT mais bolsista"
                    {{ old('type_of_employee', $user->type_of_employee) === 'CLT mais bolsista' ? 'selected' : '' }}>CLT
                    mais Bolsa</option>
                <option value="estagio"
                    {{ old('type_of_employee', $user->type_of_employee) === 'estagio' ? 'selected' : '' }}>Estágio
                </option>
                <option value="estagio mais bolsista"
                    {{ old('type_of_employee', $user->type_of_employee) === 'estagio mais bolsista' ? 'selected' : '' }}>
                    Estágio mais Bolsa</option>
                <option value="consultoria"
                    {{ old('type_of_employee', $user->type_of_employee) === 'consultoria' ? 'selected' : '' }}>
                    Consultoria</option>
                <option value="outros"
                    {{ old('type_of_employee', $user->type_of_employee) === 'outros' ? 'selected' : '' }}>Outros
                </option>
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('type_of_employee')" />
        </div>


        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
