<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login LMS - SD Islam Tompokersan Lumajang</title>

    {{-- AdminLTE CSS --}}
    <link rel="stylesheet" href="{{ asset('lte/dist/css/adminlte.min.css') }}">
    {{-- Font Awesome --}}
    <link rel="stylesheet" href="{{ asset('lte/plugins/fontawesome-free/css/all.min.css') }}">
    {{-- Google Font --}}
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #094B57 0%, #49E7B2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        /* Background decorative elements */
        body::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: 
                radial-gradient(circle at 20% 80%, rgba(73, 231, 178, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(9, 75, 87, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(255, 255, 255, 0.05) 0%, transparent 50%);
            animation: float 20s ease-in-out infinite;
            z-index: 1;
        }

        @keyframes float {
            0%, 100% { transform: translateX(0) translateY(0) rotate(0deg); }
            33% { transform: translateX(30px) translateY(-30px) rotate(120deg); }
            66% { transform: translateX(-20px) translateY(20px) rotate(240deg); }
        }

        .login-container {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 480px;
            padding: 1.5rem;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 24px;
            box-shadow: 
                0 25px 50px -12px rgba(9, 75, 87, 0.3),
                0 0 0 1px rgba(255, 255, 255, 0.1);
            padding: 2.5rem 2.5rem 2rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .login-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #094B57, #49E7B2);
            border-radius: 24px 24px 0 0;
        }

        .login-header {
            margin-bottom: 2rem;
        }

        .login-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: #094B57;
            margin-bottom: 0.4rem;
            line-height: 1.3;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .login-subtitle {
            font-size: 1.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, #094B57 0%, #49E7B2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.2rem;
            line-height: 1.2;
        }

        .school-location {
            font-size: 1.1rem;
            font-weight: 600;
            color: #094B57;
            margin-bottom: 1.5rem;
        }

        .logo-container {
            width: 100px;
            height: 100px;
            margin: 0 auto 1.5rem;
            position: relative;
            border-radius: 50%;
            background: linear-gradient(135deg, #094B57, #49E7B2);
            padding: 3px;
            box-shadow: 0 8px 25px rgba(9, 75, 87, 0.3);
        }

        .logo-inner {
            width: 100%;
            height: 100%;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .logo-inner img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
            border-radius: 50%;
        }

        .form-group {
            margin-bottom: 1.5rem;
            text-align: left;
            position: relative;
        }

        .form-control {
            width: 100%;
            padding: 1rem 1.25rem;
            border: 2px solid rgba(9, 75, 87, 0.1);
            border-radius: 12px;
            font-size: 1rem;
            font-family: 'Inter', sans-serif;
            background: rgba(255, 255, 255, 0.8);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            color: #094B57;
        }

        .password-input-wrapper {
            position: relative;
        }

        .password-input-wrapper .form-control {
            padding-right: 3rem;
        }

        .password-toggle {
            position: absolute;
            right: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: rgba(9, 75, 87, 0.6);
            cursor: pointer;
            padding: 0.4rem;
            border-radius: 6px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            font-size: 0.9rem;
        }

        .password-toggle:hover {
            background: rgba(9, 75, 87, 0.1);
            color: #094B57;
        }

        .form-control:focus {
            outline: none;
            border-color: #49E7B2;
            background: rgba(255, 255, 255, 0.95);
            box-shadow: 0 0 0 3px rgba(73, 231, 178, 0.1);
            transform: translateY(-1px);
        }

        .form-control::placeholder {
            color: rgba(9, 75, 87, 0.5);
            font-weight: 400;
        }

        .login-btn {
            width: 100%;
            padding: 1rem 2rem;
            background: linear-gradient(135deg, #094B57 0%, #49E7B2 100%);
            border: none;
            border-radius: 12px;
            color: white;
            font-size: 1rem;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 0.5rem;
        }

        .login-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .login-btn:hover::before {
            left: 100%;
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(9, 75, 87, 0.4);
        }

        .login-btn:active {
            transform: translateY(0);
        }

        .error-message {
            color: #e74c3c;
            font-size: 0.8rem;
            margin-top: 0.4rem;
            text-align: left;
            display: flex;
            align-items: center;
            gap: 0.3rem;
        }

        .forgot-password {
            margin-top: 1.2rem;
            padding-top: 1rem;
            border-top: 1px solid rgba(9, 75, 87, 0.1);
        }

        .forgot-password a {
            color: #094B57;
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .forgot-password a:hover {
            color: #49E7B2;
            text-decoration: underline;
        }

        /* Floating particles animation */
        .particle {
            position: absolute;
            width: 3px;
            height: 3px;
            background: rgba(255, 255, 255, 0.6);
            border-radius: 50%;
            animation: particleFloat 8s infinite ease-in-out;
        }

        .particle:nth-child(1) {
            top: 20%;
            left: 20%;
            animation-delay: 0s;
        }

        .particle:nth-child(2) {
            top: 60%;
            left: 80%;
            animation-delay: 2s;
        }

        .particle:nth-child(3) {
            top: 80%;
            left: 30%;
            animation-delay: 4s;
        }

        @keyframes particleFloat {
            0%, 100% {
                transform: translateY(0) scale(1);
                opacity: 0.6;
            }
            50% {
                transform: translateY(-25px) scale(1.1);
                opacity: 1;
            }
        }

        /* Loading animation */
        .btn-loading {
            position: relative;
            color: transparent !important;
        }

        .btn-loading::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            margin: -8px 0 0 -8px;
            width: 16px;
            height: 16px;
            border: 2px solid transparent;
            border-top: 2px solid white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Ripple effect */
        .login-btn {
            position: relative;
            overflow: hidden;
        }

        .ripple {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.4);
            transform: scale(0);
            animation: rippleAnimation 0.6s linear;
            top: 50%;
            left: 50%;
            margin-top: -20px;
            margin-left: -20px;
            width: 40px;
            height: 40px;
        }

        @keyframes rippleAnimation {
            to {
                transform: scale(3);
                opacity: 0;
            }
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .login-container {
                padding: 1rem;
                max-width: 400px;
            }

            .login-card {
                padding: 2rem 1.8rem 1.5rem;
            }

            .login-title {
                font-size: 1.1rem;
            }

            .login-subtitle {
                font-size: 1.3rem;
            }

            .school-location {
                font-size: 1rem;
            }

            .logo-container {
                width: 85px;
                height: 85px;
                margin-bottom: 1.2rem;
            }

            .form-group {
                margin-bottom: 1.2rem;
            }

            .form-control {
                padding: 0.9rem 1rem;
                font-size: 0.95rem;
            }

            .password-input-wrapper .form-control {
                padding-right: 2.8rem;
            }

            .password-toggle {
                width: 28px;
                height: 28px;
                font-size: 0.85rem;
            }
        }

        @media (max-width: 480px) {
            .login-container {
                max-width: 340px;
                padding: 0.8rem;
            }

            .login-card {
                padding: 1.8rem 1.5rem 1.3rem;
            }

            .login-header {
                margin-bottom: 1.5rem;
            }
        }

        /* Enhanced visual feedback */
        .form-group.focused .form-control {
            border-color: #49E7B2;
            box-shadow: 0 0 0 2px rgba(73, 231, 178, 0.1);
        }

        .form-group.has-error .form-control {
            border-color: #e74c3c;
            box-shadow: 0 0 0 2px rgba(231, 76, 60, 0.1);
        }

        /* Success animation */
        @keyframes success {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        .btn-success {
            animation: success 0.3s ease;
        }
    </style>
</head>

<body>
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>

    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <div class="login-title">LOGIN LMS</div>
                <div class="login-subtitle">SD ISLAM TOMPOKERSAN</div>
                <div class="school-location">LUMAJANG</div>

                <div class="logo-container">
                    <div class="logo-inner">
                        <img src="{{ asset('assets/logo_sdi.PNG') }}" 
                             alt="Logo SD Islam Tompokersan" 
                             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('login') }}" id="loginForm">
                @csrf

                <div class="form-group">
                    <input type="email" 
                           name="email" 
                           class="form-control" 
                           placeholder="Email atau Username" 
                           value="{{ old('email') }}" 
                           required 
                           autofocus>
                    @error('email')
                        <div class="error-message">
                            <i class="fas fa-exclamation-triangle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <div class="password-input-wrapper">
                        <input type="password" 
                               name="password" 
                               id="passwordInput"
                               class="form-control" 
                               placeholder="Password" 
                               required>
                        <button type="button" class="password-toggle" onclick="togglePassword()" title="Tampilkan/Sembunyikan Password">
                            <i class="fas fa-eye" id="toggleIcon"></i>
                        </button>
                    </div>
                    @error('password')
                        <div class="error-message">
                            <i class="fas fa-exclamation-triangle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <button type="submit" class="login-btn" id="loginButton">
                    <span>Masuk</span>
                </button>
            </form>

            <div class="forgot-password">
                <a href="#" onclick="alert('Silakan hubungi administrator untuk reset password.')">Lupa password?</a>
            </div>
        </div>
    </div>

    {{-- AdminLTE JS --}}
    <script src="{{ asset('lte/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('lte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('lte/dist/js/adminlte.min.js') }}"></script>

    <script>
        // Password visibility toggle
        function togglePassword() {
            const passwordInput = document.getElementById('passwordInput');
            const toggleIcon = document.getElementById('toggleIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.className = 'fas fa-eye-slash';
            } else {
                passwordInput.type = 'password';
                toggleIcon.className = 'fas fa-eye';
            }
        }

        $(document).ready(function() {
            // Form submission with loading state
            $('#loginForm').on('submit', function(e) {
                const button = $('#loginButton');
                const buttonText = button.find('span');
                
                button.addClass('btn-loading');
                button.prop('disabled', true);
                buttonText.text('Memproses...');
                
                // Reset if form has validation errors
                setTimeout(function() {
                    if ($('.error-message').length > 0) {
                        button.removeClass('btn-loading');
                        button.prop('disabled', false);
                        buttonText.text('Masuk');
                    }
                }, 100);
            });

            // Enhanced input focus effects
            $('.form-control').on('focus', function() {
                $(this).closest('.form-group').addClass('focused');
            }).on('blur', function() {
                $(this).closest('.form-group').removeClass('focused');
                
                // Add error class if has error
                if ($(this).siblings('.error-message').length > 0) {
                    $(this).closest('.form-group').addClass('has-error');
                }
            });

            // Auto-clear error messages and classes on input
            $('.form-control').on('input', function() {
                $(this).siblings('.error-message').fadeOut();
                $(this).closest('.form-group').removeClass('has-error');
            });

            // Keyboard shortcuts
            $(document).on('keydown', function(e) {
                // Alt + L to focus email input
                if (e.altKey && e.keyCode === 76) {
                    e.preventDefault();
                    $('input[name="email"]').focus();
                }
                
                // Ctrl + Enter to submit form
                if (e.ctrlKey && e.keyCode === 13) {
                    e.preventDefault();
                    $('#loginForm').submit();
                }
            });

            // Add ripple effect to button
            $('.login-btn').on('click', function(e) {
                if (!$(this).hasClass('btn-loading')) {
                    let ripple = $('<span class="ripple"></span>');
                    $(this).append(ripple);
                    
                    setTimeout(() => {
                        ripple.remove();
                    }, 600);
                }
            });

            // Initialize error states
            $('.error-message').each(function() {
                $(this).closest('.form-group').addClass('has-error');
            });

            // Auto-hide flash messages
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 5000);
        });

    </script>
</body>

</html>