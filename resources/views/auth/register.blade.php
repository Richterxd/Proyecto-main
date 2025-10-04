<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" href="{{ asset('img/isotipo.png') }}">
    <title>CMBEY - Registro</title>
    @vite('resources/css/app.css')
    @livewireStyles
    <style>

        .full-screen-container {
            min-height: 100vh;
            width: 100vw;
            margin: 0;
            padding: 2rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .form-container {
            width: 100%;
            max-width: 28rem;
            margin: 0 auto;
        }

        .input-group {
            position: relative;
            margin-bottom: 1rem;
        }

        .input-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: #1e293b;
            font-weight: 600;
            font-size: 0.85rem;
        }

        .input-group input,
        .input-group select {
            width: 100%;
            padding: 0.75rem;
            background: rgba(255, 255, 255, 0.95);
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            color: #1e293b;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .input-group input:focus,
        .input-group select:focus {
            outline: none;
            border-color: #0369a1;
            background: rgba(255, 255, 255, 1);
            box-shadow: 0 0 15px rgba(3, 105, 161, 0.2), 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .input-group input:hover,
        .input-group select:hover {
            border-color: #94a3b8;
        }

        .input-group-inline {
            display: flex;
            gap: 0.5rem;
        }

        .input-group-inline .input-group {
            flex: 1;
        }

        .password-toggle {
            position: absolute;
            right: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #64748b;
            cursor: pointer;
            transition: color 0.2s ease;
        }

        .password-toggle:hover {
            color: #0369a1;
        }

        .step-indicator {
            display: flex;
            justify-content: center;
            margin-bottom: 2rem;
        }

        .step {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #e2e8f0;
            margin: 0 0.25rem;
            transition: all 0.3s ease;
        }

        .step.active {
            background: #0369a1;
            transform: scale(1.2);
        }

        .step.completed {
            background: #10b981;
        }

        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .modal-overlay.show {
            opacity: 1;
            visibility: visible;
        }

        .modal {
            background: white;
            border-radius: 16px;
            padding: 2rem;
            max-width: 400px;
            width: 90%;
            transform: scale(0.9);
            transition: transform 0.3s ease;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        }

        .modal-overlay.show .modal {
            transform: scale(1);
        }

        .captcha-container {
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #f0f9ff, #e0f2fe);
            border: 2px solid #0369a1;
            border-radius: 8px;
            padding: 1rem;
            margin: 1rem 0;
        }

        .captcha-question {
            font-weight: 600;
            color: #1e293b;
            margin-right: 1rem;
        }

        .captcha-input {
            width: 80px;
            padding: 0.5rem;
            border: 2px solid #0369a1;
            border-radius: 4px;
            text-align: center;
            font-weight: bold;
        }

        .error-text {
            color: #dc2626;
            font-size: 0.75rem;
            margin-top: 0.25rem;
        }

        .success-text {
            color: #059669;
            font-size: 0.75rem;
            margin-top: 0.25rem;
        }

        .form-container {
            max-height: 70vh;
            overflow-y: auto;
        }

        .indicator {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.6);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .indicator.active {
            background: rgba(255, 255, 255, 1);
            transform: scale(1.2);
        }
    </style>
</head>

<body class="font-roboto antialiased">
    <div class="full-screen-container bg-gradient-to-b from-blue-300 via-blue-500 to-blue-900">
        <div class="form-container">
            <div class="w-full bg-white rounded-2xl p-6 shadow-2xl">
                <div class="flex justify-between items-center mb-6">
                    <a href="{{ route('login') }}"
                        class="p-2 rounded-full text-gray-600 hover:bg-gray-100 hover:text-gray-800 transition-all duration-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </a>
                    <div class="flex justify-center">
                        <img src="{{ asset('img/logotipov2.png') }}" alt="Logotipo CMBEY"
                            class="w-auto h-16 object-contain">
                    </div>
                    <div class="w-10"></div>
                </div>
                @livewire('auth.register-form')
            </div>
        </div>
    </div>

    <div id="successModal" class="modal-overlay">
        <div class="modal">
            <div class="text-center">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">¡Registro Exitoso!</h3>
                <p class="text-gray-600 mb-6">Tu cuenta ha sido creada correctamente. Ahora puedes iniciar sesión.</p>
                <button onclick="window.location.href='{{ route('login') }}'"
                    class="w-full py-3 px-4 bg-gradient-to-r from-sky-500 to-blue-600 text-white font-bold rounded-lg hover:from-sky-600 hover:to-blue-700 transition-all duration-300">
                    Iniciar Sesión
                </button>
            </div>
        </div>
    </div>
    @livewireScripts
</body>

</html>