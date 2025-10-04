@php $currentStep = $currentStep ?? 1; @endphp
<div>
    <div class="step-indicator">
        <div class="step {{ $currentStep >= 1 ? 'active' : '' }} {{ $currentStep > 1 ? 'completed' : '' }}"></div>
        <div class="step {{ $currentStep >= 2 ? 'active' : '' }} {{ $currentStep > 2 ? 'completed' : '' }}"></div>
        <div class="step {{ $currentStep >= 3 ? 'active' : '' }} {{ $currentStep > 3 ? 'completed' : '' }}"></div>
        <div class="step {{ $currentStep >= 4 ? 'active' : '' }} {{ $currentStep > 4 ? 'completed' : '' }}"></div>
        <div class="step {{ $currentStep >= 5 ? 'active' : '' }} {{ $currentStep > 5 ? 'completed' : '' }}"></div>
    </div>

    <form wire:submit.prevent="register">
        @if ($currentStep == 1)
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-gray-800 text-center mb-2">¿Cómo te llamas?</h2>
                <p class="text-gray-600 text-center mb-6">Ingresa tu información personal</p>

                <div class="input-group-inline">
                    <div class="input-group">
                        <label for="nombre">Primer Nombre</label>
                        <input type="text" id="nombre" wire:model="nombre" required>
                        @error('nombre')
                            <div class="error-text">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="input-group">
                        <label for="segundo_nombre">Segundo Nombre</label>
                        <input type="text" id="segundo_nombre" wire:model="segundo_nombre">
                        @error('segundo_nombre')
                            <div class="error-text">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="input-group-inline">
                    <div class="input-group">
                        <label for="apellido">Primer Apellido *</label>
                        <input type="text" id="apellido" wire:model="apellido" required>
                        @error('apellido')
                            <div class="error-text">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="input-group">
                        <label for="segundo_apellido">Segundo Apellido</label>
                        <input type="text" id="segundo_apellido" wire:model="segundo_apellido">
                        @error('segundo_apellido')
                            <div class="error-text">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        @endif

        @if ($currentStep == 2)
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-gray-800 text-center mb-2">Información Personal</h2>
                <p class="text-gray-600 text-center mb-6">Completa tus datos personales</p>

                <div class="input-group-inline">
                    <div class="input-group" style="flex: 0 0 100px;">
                        <label for="nacionalidad">Nacionalidad *</label>
                        <select id="nacionalidad" wire:model="nacionalidad" required>
                            <option value="">Seleccionar</option>
                            <option value="V">V</option>
                            <option value="E">E</option>
                            <option value="J">J</option>
                        </select>
                        @error('nacionalidad')
                            <div class="error-text">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="input-group">
                        <label for="cedula">Cédula de Identidad *</label>
                        <input type="number" id="cedula" wire:model="cedula" required>
                        @error('cedula')
                            <div class="error-text">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="input-group-inline">
                    <div class="input-group" style="flex: 0 0 120px;">
                        <label for="prefijo_telefono">Prefijo *</label>
                        <select id="prefijo_telefono" wire:model="prefijo_telefono" required>
                            <option value="" selected disabled>Prefijo</option>
                            <option value="0412">0412</option>
                            <option value="0422">0422</option>
                            <option value="0414">0414</option>
                            <option value="0424">0424</option>
                            <option value="0416">0416</option>
                            <option value="0426">0416</option>
                        </select>
                        @error('prefijo_telefono')
                            <div class="error-text">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="input-group">
                        <label for="telefono">Número de Teléfono *</label>
                        <input type="text" id="telefono" wire:model="telefono" placeholder="XXX-XXXX" maxlength="8"
                            pattern="\d{3}-\d{4}"
                            oninput="this.value = this.value.replace(/\D/g, '').replace(/(\d{3})(\d{4})/, '$1-$2')"
                            required>
                        @error('telefono')
                            <div class="error-text">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="input-group">
                    <label for="email">Correo Electrónico *</label>
                    <input type="email" id="email" wire:model="email" required>
                    @error('email')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div class="input-group-inline">
                    <div class="input-group">
                        <label for="fecha_nacimiento">Fecha de Nacimiento *</label>
                        <input type="date" id="fecha_nacimiento" wire:model="nacimiento" required>
                        @error('nacimiento')
                            <div class="error-text">{{ $message }}</div>
                        @enderror
                        @if ($ageError)
                            <div class="error-text">{{ $ageError }}</div>
                        @endif
                    </div>
                    <div class="input-group">
                        <label for="genero">Género *</label>
                        <select id="genero" wire:model="genero" required>
                            <option value="" selected disabled>Seleccionar</option>
                            <option value="masculino">Masculino</option>
                            <option value="femenino">Femenino</option>
                            <option value="no_binario">No Binario</option>
                            <option value="no_decir">No Decir</option>
                        </select>
                        @error('genero')
                            <div class="error-text">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        @endif

        @if ($currentStep == 3)
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-gray-800 text-center mb-2">Ubicación y Seguridad</h2>
                <p class="text-gray-600 text-center mb-6">Completa tu dirección y contraseña</p>

                <div class="input-group">
                    <label for="direccion">Dirección Completa *</label>
                    <input type="text" id="direccion" wire:model="direccion"
                        placeholder="Ingresa tu dirección completa" required>
                    @error('direccion')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div class="input-group-inline">
                    <div class="input-group">
                        <label for="password">Contraseña *</label>
                        <div class="relative">
                            <input type="password" id="password" wire:model="password" class="pr-12" required>
                            <button type="button" id="togglePassword1" class="password-toggle">
                                <svg id="eyeIcon1" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <div class="error-text">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="input-group">
                        <label for="password_confirmation">Confirmar Contraseña *</label>
                        <div class="relative">
                            <input type="password" id="password_confirmation" wire:model="password_confirmation"
                                class="pr-12" required>
                            <button type="button" id="togglePassword2" class="password-toggle">
                                <svg id="eyeIcon2" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>
                        @error('password_confirmation')
                            <div class="error-text">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mt-4">
                    <h4 class="font-semibold text-blue-800 mb-2">Requisitos de la contraseña:</h4>
                    <ul class="text-sm text-blue-700 space-y-1">
                        <li>• Mínimo 8 caracteres</li>
                        <li>• Al menos una letra mayúscula</li>
                        <li>• Al menos un carácter especial (!@#$%^&*())</li>
                    </ul>
                </div>
            </div>
        @endif

        @if ($currentStep == 4)
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-gray-800 text-center mb-2">Preguntas de Seguridad</h2>
                <p class="text-gray-600 text-center mb-6">Selecciona 3 preguntas de seguridad para proteger tu cuenta</p>

                @for ($i = 0; $i < 3; $i++)
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 mb-4">
                        <h4 class="font-semibold text-gray-800 mb-3">Pregunta {{ $i + 1 }}</h4>
                        
                        <div class="input-group">
                            <label for="question_{{ $i }}">Selecciona una pregunta</label>
                            <select class="hover:" id="question_{{ $i }}" wire:model="selectedQuestions.{{ $i }}" required>
                                <option value="">Selecciona una pregunta...</option>
                                @foreach ($securityQuestions as $question)
                                    <option value="{{ $question->id }}">{{ $question->question_text }}</option>
                                @endforeach
                            </select>
                            @error("selectedQuestions.{$i}")
                                <div class="error-text">{{ $message }}</div>
                            @enderror
                        </div>

                        @if ($selectedQuestions[$i])
                            <div class="input-group">
                                <label for="answer_{{ $i }}">Tu respuesta</label>
                                <input type="text" id="answer_{{ $i }}" wire:model="securityAnswers.{{ $i }}" 
                                       placeholder="Escribe tu respuesta..." required>
                                @error("securityAnswers.{$i}")
                                    <div class="error-text">{{ $message }}</div>
                                @enderror
                            </div>
                        @endif
                    </div>
                @endfor

                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mt-4">
                    <h4 class="font-semibold text-yellow-800 mb-2">⚠️ Importante:</h4>
                    <p class="text-sm text-yellow-700">Recuerda bien tus respuestas, las necesitarás para recuperar tu contraseña en el futuro.</p>
                </div>
            </div>
        @endif

        @if ($currentStep == 5)
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-gray-800 text-center mb-2">Verificación</h2>
                <p class="text-gray-600 text-center mb-6">Completa la verificación para finalizar</p>

                <div class="captcha-container">
                    <div class="captcha-question">{{ $captchaQuestion }}</div>
                    <input type="number" wire:model="captchaAnswer" class="captcha-input" placeholder="?" required>
                </div>
                @error('captchaAnswer')
                    <div class="error-text text-center">{{ $message }}</div>
                @enderror

                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mt-4">
                    <h3 class="font-semibold text-blue-800 mb-2">Resumen de tu información:</h3>
                    <p class="text-sm text-blue-700"><strong>Nombre:</strong> {{ $nombre }}
                        {{ $segundo_nombre }} {{ $apellido }} {{ $segundo_apellido }}</p>
                    <p class="text-sm text-blue-700"><strong>Cédula:</strong> {{ $nacionalidad }}-{{ $cedula }}
                    </p>
                    <p class="text-sm text-blue-700"><strong>Teléfono:</strong>
                        {{ $prefijo_telefono }}-{{ $telefono }}</p>
                    <p class="text-sm text-blue-700"><strong>Email:</strong> {{ $email }}</p>
                </div>
            </div>
        @endif

        <div class="flex justify-between items-center mt-8">
            @if ($currentStep > 1)
                <button type="button" wire:click="previousStep"
                    class="px-6 py-4 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition-all duration-200 flex items-center gap-2 group">
                    <svg class="w-4 h-4 transform transition-transform group-hover:translate-x-[-2px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                        </path>
                    </svg>
                    Anterior
                </button>
            @else
                <div></div>
            @endif

            @if ($currentStep < 5)
                <button type="button" wire:click="nextStep"
                    class="px-6 py-4 bg-gradient-to-r from-sky-500 to-blue-600 text-white font-bold rounded-lg hover:from-sky-600 hover:to-blue-700 transition-all duration-300 flex items-center gap-2 group">
                    Siguiente
                    <svg class="w-4 h-4 transform transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                        </path>
                    </svg>
                </button>
            @else
                <button type="submit" wire:loading.attr="disabled"
                    class="px-6 py-4 bg-gradient-to-r from-green-500 to-green-600 text-white font-bold rounded-lg hover:from-green-600 hover:to-green-700 transition-all duration-300 flex items-center gap-2 disabled:opacity-50">
                    <span wire:loading.remove>Registrarse</span>
                    <span wire:loading>Procesando...</span>
                    <svg wire:loading.remove class="w-4 h-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                        </path>
                    </svg>
                </button>
            @endif
        </div>
    </form>
</div>

<script>
    document.addEventListener('livewire:init', () => {
        Livewire.hook('element.updated', () => {
            initToggles();
            initInputs();
        });

        const initToggles = () => {
            setupToggle('password', 'togglePassword1', 'eyeIcon1');
            setupToggle('password_confirmation', 'togglePassword2', 'eyeIcon2');
        };

        const setupToggle = (inputId, toggleId, iconId) => {
            const input = document.getElementById(inputId);
            const toggle = document.getElementById(toggleId);
            const icon = document.getElementById(iconId);

            if (toggle && icon && input) {
                // Remove existing listeners by cloning the element
                const newToggle = toggle.cloneNode(true);
                toggle.parentNode.replaceChild(newToggle, toggle);

                newToggle.addEventListener('click', (e) => {
                    e.preventDefault();
                    const currentType = input.getAttribute('type');
                    const isPassword = currentType === 'password';
                    
                    input.setAttribute('type', isPassword ? 'text' : 'password');
                    
                    const newIcon = document.getElementById(iconId);
                    if (isPassword) {
                        newIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>`;
                    } else {
                        newIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>`;
                    }
                });
            }
        };

        const initInputs = () => {
            const phoneInput = document.getElementById('telefono');
            if (phoneInput) {
                const newPhoneInput = phoneInput.cloneNode(true);
                phoneInput.parentNode.replaceChild(newPhoneInput, phoneInput);
                
                newPhoneInput.addEventListener('input', (e) => {
                    let value = e.target.value.replace(/\D/g, '');
                    if (value.length > 3) {
                        value = value.substring(0, 3) + '-' + value.substring(3, 7);
                    }
                    e.target.value = value;
                });
            }

            const cedulaInput = document.getElementById('cedula');
            if (cedulaInput) {
                const newCedulaInput = cedulaInput.cloneNode(true);
                cedulaInput.parentNode.replaceChild(newCedulaInput, cedulaInput);
                
                newCedulaInput.addEventListener('input', (e) => {
                    e.target.value = e.target.value.replace(/\D/g, '').substring(0, 8);
                });
            }

            const birthInput = document.getElementById('fecha_nacimiento');
            if (birthInput) {
                const newBirthInput = birthInput.cloneNode(true);
                birthInput.parentNode.replaceChild(newBirthInput, birthInput);
                
                newBirthInput.addEventListener('change', function() {
                    const birthDate = new Date(this.value);
                    const today = new Date();
                    const age = today.getFullYear() - birthDate.getFullYear();
                    const monthDiff = today.getMonth() - birthDate.getMonth();
                    
                    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                        age--;
                    }
                    
                    if (age < 18) {
                        alert('Debes ser mayor de 18 años para registrarte.');
                        this.value = '';
                    }
                });
            }

            const passwordInput = document.getElementById('password');
            if (passwordInput) {
                const newPasswordInput = passwordInput.cloneNode(true);
                passwordInput.parentNode.replaceChild(newPasswordInput, passwordInput);
                
                newPasswordInput.addEventListener('input', function() {
                    const password = this.value;
                    const hasUpperCase = /[A-Z]/.test(password);
                    const hasSpecialChar = /[!@#$%^&*()]/.test(password);
                    const hasMinLength = password.length >= 8;
                    
                    if (hasUpperCase && hasSpecialChar && hasMinLength) {
                        this.style.borderColor = '#10b981';
                    } else {
                        this.style.borderColor = '#e2e8f0';
                    }
                });
            }
        };

        initToggles();
        initInputs();
    });
</script>
