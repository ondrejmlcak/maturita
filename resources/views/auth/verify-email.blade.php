<x-guest-layout>
    <div class="mb-4 text-sm text-black dark:text-black">
        {{ __('Děkujeme za registraci účtu! Ještě musíte potvrdit svůj email ve své emailové schránce, kam vám byl zaslán verifikační link!') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
            {{ __('Na emailovou adresu, kterou jste zadali při registraci, byl zaslán nový ověřovací odkaz.') }}
        </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div>
                <x-primary-button>
                    {{ __('Znovu odeslat odkaz') }}
                </x-primary-button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="underline text-sm text-black dark:text-black hover:text-black dark:hover:text-black rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white dark:focus:ring-offset-white">
                {{ __('Odhlásit se') }}
            </button>
        </form>
    </div>
</x-guest-layout>
