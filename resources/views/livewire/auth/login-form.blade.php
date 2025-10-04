<form wire:submit.prevent='login' class="w-full space-y-6">
    <div class="input-group">
        <label for="cedula">Usuario</label>
        <input class="" name="cedula" id="cedula" type="text" inputmode="numeric" wire:model="cedula" required>
        @error('cedula')
            <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
        @enderror
    </div>
    <div class="input-group">
        <label for="password">Contraseña</label>
        <div class="relative">
            <input class="pr-12" name="contraseña" id="password" type="password" wire:model="password" required>
            <button type="button" id="togglePassword" class="password-toggle">
                <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
            </button>
        </div>
        @error('password')
            <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
        @enderror
    </div>
    @if (session()->has('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl text-center backdrop-blur-sm"
            role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif
    <button type="submit"
        class="w-full py-4 px-6 bg-gradient-to-r from-sky-500 to-blue-600 text-white font-roboto-bold rounded-xl shadow-lg hover:from-sky-600 hover:to-blue-700 hover:shadow-xl transform hover:scale-105 transition-all duration-300 flex items-center justify-center gap-2 group">
        <span>Iniciar Sesión</span>
        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform duration-200" fill="none"
            stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
        </svg>
    </button>
    <div class="flex flex-col sm:flex-row justify-between items-center gap-4 pt-4">
        <a class="font-roboto text-slate-700 hover:text-slate-900 hover:underline flex items-center gap-2 transition-all duration-200 group"
            href="{{ route('password.recovery') }}">
            <svg class="w-4 h-4 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
            </svg>
            <span>¿Olvidó su contraseña?</span>
        </a>
        <a class="font-roboto text-slate-700 hover:text-slate-900 hover:underline flex items-center gap-2 transition-all duration-200 group"
            href="{{ route('registro') }}">
            <svg class="w-4 h-4 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z">
                </path>
            </svg>
            <span>Regístrate</span>

        </a>
    </div>
</form>
