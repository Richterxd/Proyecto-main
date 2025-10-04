<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" href="{{ asset('img/isotipo.png') }}">
    <title>CMBEY - Iniciar Sesión</title>
    @vite('resources/css/app.css')
    @livewireStyles
    <style>
        .full-screen-container {
            min-height: 100vh;
            height: 100vh;
            width: 100vw;
            margin: 0;
            padding: 0;
        }

        .divider-line {
            position: absolute;
            left: 50%;
            top: 0;
            bottom: 0;
            width: 2px;
            background: linear-gradient(to bottom, transparent, rgba(255, 255, 255, 0.3), transparent);
            transform: translateX(-50%);
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

        .input-group input {
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

        .input-group input:focus {
            outline: none;
            border-color: #0369a1;
            background: rgba(255, 255, 255, 1);
            box-shadow: 0 0 20px rgba(3, 105, 161, 0.2), 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .input-group input:hover {
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

        .carousel-container {
            position: relative;
            width: 100%;
            height: 70%;
            overflow: hidden;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        }

        .carousel-slide {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            transition: opacity 1.5s ease-in-out;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .carousel-slide.active {
            opacity: 1;
        }

        .carousel-slide img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .carousel-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(transparent, rgba(0, 0, 0, 0.7));
            padding: 2rem;
            color: white;
        }

        .carousel-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        .carousel-author {
            font-size: 1rem;
            opacity: 0.9;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
        }

        .carousel-indicators {
            position: absolute;
            bottom: 1rem;
            right: 1rem;
            display: flex;
            gap: 0.5rem;
            z-index: 10;
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

        .left-panel {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 4rem;
        }

        .right-panel {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 4rem;
        }
    </style>
</head>

<body class="font-roboto antialiased    ">
    <div
        class="full-screen-container bg-gradient-to-b from-blue-300 via-blue-500 to-blue-900 flex items-center justify-center relative">
        <div class="divider-line"></div>
        <div class="w-full h-full flex flex-col lg:flex-row">
            <div class="w-full lg:w-1/2 left-panel">
                <div class="w-full max-w-md bg-white rounded-2xl p-6 sm:p-8 shadow-2xl"
                    style="height: 70vh; display: flex; flex-direction: column; justify-content: center;">
                    <div class="flex justify-center w-full mb-8">
                        <img src="{{ asset('img/logotipov2.png') }}" alt="Logotipo CMBEY"
                            class="w-auto h-20 sm:h-24 lg:h-28 object-contain">
                    </div>
                    @livewire('auth.login-form')
                </div>
            </div>
            <div class="hidden lg:flex w-1/2 right-panel">
                <div class="carousel-container">
                    <div class="carousel-slide active">
                        <img src="{{ asset('/img/1.jpg') }}" alt="Plaza Bolívar de Chivacoa">
                        <div class="carousel-overlay">
                            <div class="carousel-title">Plaza Bolívar de Chivacoa</div>
                            <div class="carousel-author">Imágen por Kuara Tours - Julio 2023</div>
                        </div>
                    </div>
                    <div class="carousel-slide">
                        <img src="{{ asset('img/2.jpg') }}" alt="Entrada a la Ciudad de Chivacoa">
                        <div class="carousel-overlay">
                            <div class="carousel-title">Entrada a la Ciudad de Chivacoa</div>
                            <div class="carousel-author">Imágen por Brenda Celis - Julio 2024</div>
                        </div>
                    </div>
                    <div class="carousel-slide">
                        <img src="{{ asset('/img/3.jpg') }}" alt="Consejo Municipal de Bruzual del Estado Yaracuy">
                        <div class="carousel-overlay">
                            <div class="carousel-title">Consejo Municipal de Bruzual del Estado Yaracuy</div>
                            <div class="carousel-author">Imágen por Erick Graterol - Junio 2024</div>
                        </div>
                    </div>
                    <div class="carousel-slide">
                        <img src="{{ asset('/img/4.jpg') }}" alt="Parque Recreacional Doña Pastora Loyo">
                        <div class="carousel-overlay">
                            <div class="carousel-title">Parque Recreacional Doña Pastora Loyo</div>
                            <div class="carousel-author">Imágen por Neymar Aguilar Merlo - Junio 2024</div>
                        </div>
                    </div>
                    <div class="carousel-slide">
                        <img src="{{ asset('/img/5.jpg') }}" alt="Parroquia San José De Chivacoa">
                        <div class="carousel-overlay">
                            <div class="carousel-title">Parroquia San José De Chivacoa</div>
                            <div class="carousel-author">Imágen por Kuara Tours - Julio 2023</div>
                        </div>
                    </div>
                    <div class="carousel-indicators">
                        <div class="indicator active" data-slide="0"></div>
                        <div class="indicator" data-slide="1"></div>
                        <div class="indicator" data-slide="2"></div>
                        <div class="indicator" data-slide="3"></div>
                        <div class="indicator" data-slide="4"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @livewireScripts
    <script>

        document.addEventListener('DOMContentLoaded', function() {
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            if (togglePassword && passwordInput && eyeIcon) {
                togglePassword.addEventListener('click', function(e) {
                    e.preventDefault();
                    const currentType = passwordInput.getAttribute('type');
                    const isPassword = currentType === 'password';
                    passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
                    if (isPassword) {
                        eyeIcon.innerHTML =
                            `<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-eye-off"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10.585 10.587a2 2 0 0 0 2.829 2.828" /><path d="M16.681 16.673a8.717 8.717 0 0 1 -4.681 1.327c-3.6 0 -6.6 -2 -9 -6c1.272 -2.12 2.712 -3.678 4.32 -4.674m2.86 -1.146a9.055 9.055 0 0 1 1.82 -.18c3.6 0 6.6 2 9 6c-.666 1.11 -1.379 2.067 -2.138 2.87" /><path d="M3 3l18 18" /></svg>`;
                    } else {
                        eyeIcon.innerHTML =
                            `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>`;
                    }
                });
            }
            const slides = document.querySelectorAll('.carousel-slide');
            const indicators = document.querySelectorAll('.indicator');
            let currentSlide = 0;
            let carouselInterval;

            function showSlide(index) {
                if (index >= slides.length) {
                    index = 0;
                } else if (index < 0) {
                    index = slides.length - 1;
                }
                slides.forEach(slide => slide.classList.remove('active'));
                indicators.forEach(indicator => indicator.classList.remove('active'));
                if (slides[index]) {
                    slides[index].classList.add('active');
                    indicators[index].classList.add('active');
                    currentSlide = index;
                }
            }

            function nextSlide() {
                const next = (currentSlide + 1);
                showSlide(next);
            }

            function startCarousel() {
                carouselInterval = setInterval(nextSlide, 5000);
            }

            function stopCarousel() {
                if (carouselInterval) {
                    clearInterval(carouselInterval);
                }
            }
            indicators.forEach((indicator, index) => {
                indicator.addEventListener('click', () => {
                    stopCarousel();
                    showSlide(index);
                    startCarousel();
                });
            });
            if (slides.length > 0) {
                showSlide(currentSlide);
                startCarousel();
            }
        });


    </script>
</body>

</html>