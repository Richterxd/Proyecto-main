<div>
    <div class="step-indicator">
        <div class="step {{ $step >= 1 ? 'active' : '' }} {{ $step > 1 ? 'completed' : '' }}"></div>
        <div class="step {{ $step >= 2 ? 'active' : '' }} {{ $step > 2 ? 'completed' : '' }}"></div>
        <div class="step {{ $step >= 3 ? 'active' : '' }} {{ $step > 3 ? 'completed' : '' }}"></div>
    </div>

    @if ($step == 1)
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-gray-800 mb-2">Recuperar Contraseña</h2>
            <p class="text-gray-600">Ingresa tu cédula para comenzar el proceso de recuperación</p>
        </div>

        <form wire:submit.prevent="findUser">
            <div class="input-group">
                <label for="cedula">Cédula de Identidad</label>
                <input type="text" id="cedula" wire:model="cedula" placeholder="Ingresa tu cédula" 
                       inputmode="numeric" required>
                @error('cedula')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" 
                class="w-full py-4 px-6 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-bold rounded-xl shadow-lg hover:from-blue-600 hover:to-blue-700 hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                Continuar
            </button>
        </form>

    @elseif ($step == 2)
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-gray-800 mb-2">Preguntas de Seguridad</h2>
            <p class="text-gray-600">Responde las siguientes preguntas para verificar tu identidad</p>
        </div>

        <form wire:submit.prevent="verifyAnswers">
            @foreach ($securityQuestions as $index => $securityAnswer)
                <div class="security-question-card">
                    <div class="question-number">{{ $index + 1 }}</div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3">
                        {{ $securityAnswer->securityQuestion->question_text }}
                    </label>
                    <input type="text" 
                           wire:model="userAnswers.{{ $index }}" 
                           placeholder="Tu respuesta..."
                           class="w-full p-3 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:outline-none transition-colors"
                           required>
                    @error("userAnswers.{$index}")
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>
            @endforeach

            @error('general')
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl mb-4">
                    {{ $message }}
                </div>
            @enderror

            <div class="flex gap-4">
                <button type="button" wire:click="goBack"
                    class="flex-1 py-3 px-4 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition-all duration-200">
                    Volver
                </button>
                <button type="submit" 
                    class="flex-1 py-3 px-4 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-bold rounded-lg hover:from-blue-600 hover:to-blue-700 transition-all duration-300">
                    Verificar Respuestas
                </button>
            </div>
        </form>

    @elseif ($step == 3)
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h2 class="text-3xl font-bold text-gray-800 mb-2">Nueva Contraseña</h2>
            <p class="text-gray-600">Crea una nueva contraseña segura para tu cuenta</p>
        </div>

        <form wire:submit.prevent="resetPassword">
            <div class="input-group">
                <label for="newPassword">Nueva Contraseña</label>
                <div class="relative">
                    <input type="password" id="newPassword" wire:model="newPassword" 
                           placeholder="Mínimo 8 caracteres, 1 mayúscula y 1 carácter especial" 
                           class="pr-12" required>
                    <button type="button" id="toggleNewPassword" class="password-toggle">
                        <svg id="eyeIconNew" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>
                @error('newPassword')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <div class="input-group">
                <label for="confirmPassword">Confirmar Nueva Contraseña</label>
                <div class="relative">
                    <input type="password" id="confirmPassword" wire:model="confirmPassword" 
                           placeholder="Confirma tu nueva contraseña" 
                           class="pr-12" required>
                    <button type="button" id="toggleConfirmPassword" class="password-toggle">
                        <svg id="eyeIconConfirm" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>
                @error('confirmPassword')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                <h4 class="font-semibold text-blue-800 mb-2">Requisitos de la contraseña:</h4>
                <ul class="text-sm text-blue-700 space-y-1">
                    <li>• Mínimo 8 caracteres</li>
                    <li>• Al menos una letra mayúscula</li>
                    <li>• Al menos un carácter especial (!@#$%^&*())</li>
                </ul>
            </div>

            <div class="flex gap-4">
                <button type="button" wire:click="goBack"
                    class="flex-1 py-3 px-4 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition-all duration-200">
                    Volver
                </button>
                <button type="submit" 
                    class="flex-1 py-3 px-4 bg-gradient-to-r from-green-500 to-green-600 text-white font-bold rounded-lg hover:from-green-600 hover:to-green-700 transition-all duration-300">
                    Actualizar Contraseña
                </button>
            </div>
        </form>
    @endif
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Password toggle functionality
        function setupPasswordToggle(inputId, toggleId, iconId) {
            const input = document.getElementById(inputId);
            const toggle = document.getElementById(toggleId);
            const icon = document.getElementById(iconId);
            
            if (input && toggle && icon) {
                toggle.addEventListener('click', function() {
                    const isPassword = input.type === 'password';
                    input.type = isPassword ? 'text' : 'password';
                    
                    if (isPassword) {
                        icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>`;
                    } else {
                        icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>`;
                    }
                });
            }
        }
        
        setupPasswordToggle('newPassword', 'toggleNewPassword', 'eyeIconNew');
        setupPasswordToggle('confirmPassword', 'toggleConfirmPassword', 'eyeIconConfirm');
        
        // Cedula input formatting
        const cedulaInput = document.getElementById('cedula');
        if (cedulaInput) {
            cedulaInput.addEventListener('input', function(e) {
                e.target.value = e.target.value.replace(/\D/g, '').substring(0, 8);
            });
        }
    });
</script>