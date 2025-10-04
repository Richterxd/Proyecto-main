<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('img/isotipo.png') }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CMBEY - Recuperar Contraseña</title>
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
            max-width: 32rem;
            margin: 0 auto;
        }

        .input-group {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .input-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: #1e293b;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .input-group input,
        .input-group select {
            width: 100%;
            padding: 1rem;
            background: rgba(255, 255, 255, 0.95);
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            color: #1e293b;
            font-size: 1rem;
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .input-group input:focus,
        .input-group select:focus {
            outline: none;
            border-color: #0369a1;
            background: rgba(255, 255, 255, 1);
            box-shadow: 0 0 20px rgba(3, 105, 161, 0.2), 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .input-group input:hover,
        .input-group select:hover {
            border-color: #94a3b8;
        }

        .password-toggle {
            position: absolute;
            right: 1rem;
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
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background: #e2e8f0;
            margin: 0 0.5rem;
            transition: all 0.3s ease;
            position: relative;
        }

        .step.active {
            background: #0369a1;
            transform: scale(1.2);
        }

        .step.completed {
            background: #10b981;
        }

        .step::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 100%;
            width: 1rem;
            height: 2px;
            background: #e2e8f0;
            transform: translateY(-50%);
        }

        .step:last-child::after {
            display: none;
        }

        .error-text {
            color: #dc2626;
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }

        .success-text {
            color: #059669;
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }

        .security-question-card {
            background: #f8fafc;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
        }

        .security-question-card:hover {
            border-color: #94a3b8;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .question-number {
            background: #0369a1;
            color: white;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 0.9rem;
            margin-bottom: 0.75rem;
        }
    </style>
</head>

<body class="font-roboto antialiased">
    <div class="full-screen-container bg-gradient-to-br from-blue-400 via-blue-500 to-blue-700">
        <div class="form-container">
            <div class="w-full bg-white rounded-2xl p-8 shadow-2xl">
                <div class="flex justify-between items-center mb-8">
                    <a href="{{ route('login') }}"
                        class="p-2 rounded-full text-gray-600 hover:bg-gray-100 hover:text-gray-800 transition-all duration-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                            </path>
                        </svg>
                    </a>
                    <div class="flex justify-center">
                        <img src="{{ asset('img/logotipov2.png') }}" alt="Logotipo CMBEY"
                            class="w-auto h-16 object-contain">
                    </div>
                    <div class="w-10"></div>
                </div>
                {{ $slot }}
            </div>
        </div>
    </div>
    @livewireScripts
</body>

</html>