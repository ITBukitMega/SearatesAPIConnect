<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | BM Logistics</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'sans': ['Inter', 'system-ui', 'sans-serif'],
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.8s ease-in-out',
                        'slide-up': 'slideUp 0.6s ease-out',
                        'float': 'float 6s ease-in-out infinite',
                        'pulse-glow': 'pulseGlow 3s ease-in-out infinite',
                        'rotate-slow': 'rotateSlow 20s linear infinite',
                    }
                }
            }
        }
    </script>
    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            25% { transform: translateY(-20px) rotate(1deg); }
            50% { transform: translateY(-10px) rotate(0deg); }
            75% { transform: translateY(-15px) rotate(-1deg); }
        }

        @keyframes pulseGlow {
            0%, 100% { 
                box-shadow: 0 0 20px rgba(99, 102, 241, 0.4), 0 0 40px rgba(168, 85, 247, 0.3);
            }
            50% { 
                box-shadow: 0 0 40px rgba(99, 102, 241, 0.6), 0 0 80px rgba(168, 85, 247, 0.5);
            }
        }

        @keyframes rotateSlow {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        /* Background Pattern */
        .bg-pattern {
            background-image: 
                radial-gradient(circle at 20% 30%, rgba(99, 102, 241, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(168, 85, 247, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 60% 80%, rgba(236, 72, 153, 0.1) 0%, transparent 50%),
                linear-gradient(135deg, rgba(99, 102, 241, 0.05) 0%, transparent 50%);
        }

        /* Glass Effect */
        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        /* Input Focus Effects */
        .input-field {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .input-field:focus {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(99, 102, 241, 0.15);
        }

        /* Button Hover Effects */
        .login-btn {
            position: relative;
            overflow: hidden;
        }

        .login-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s ease;
        }

        .login-btn:hover::before {
            left: 100%;
        }

        /* Floating Elements */
        .floating-shape {
            position: absolute;
            opacity: 0.1;
            pointer-events: none;
        }

        .shape-1 {
            top: 10%;
            left: 10%;
            width: 100px;
            height: 100px;
            background: linear-gradient(45deg, #6366f1, #a855f7);
            border-radius: 50%;
            animation: float 8s ease-in-out infinite;
        }

        .shape-2 {
            top: 20%;
            right: 15%;
            width: 60px;
            height: 60px;
            background: linear-gradient(45deg, #a855f7, #ec4899);
            border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
            animation: float 10s ease-in-out infinite reverse;
        }

        .shape-3 {
            bottom: 20%;
            left: 15%;
            width: 80px;
            height: 80px;
            background: linear-gradient(45deg, #ec4899, #6366f1);
            border-radius: 20px;
            animation: float 12s ease-in-out infinite;
            transform: rotate(45deg);
        }

        .shape-4 {
            bottom: 30%;
            right: 20%;
            width: 40px;
            height: 40px;
            background: linear-gradient(45deg, #6366f1, #ec4899);
            border-radius: 50% 10% 50% 10%;
            animation: float 7s ease-in-out infinite reverse;
        }
    </style>
</head>

<body class="h-full bg-gradient-to-br from-slate-50 via-blue-50 to-purple-50 bg-pattern font-sans">
    <!-- Floating Background Shapes -->
    <div class="floating-shape shape-1"></div>
    <div class="floating-shape shape-2"></div>
    <div class="floating-shape shape-3"></div>
    <div class="floating-shape shape-4"></div>

    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8 animate-fade-in">
            <!-- Header Section -->
            <div class="text-center space-y-6">
                <!-- Logo and Brand -->
                <div class="animate-pulse-glow inline-flex items-center justify-center w-20 h-20 bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 rounded-2xl shadow-2xl">
                    <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z" />
                    </svg>
                </div>

                <!-- Welcome Text -->
                <div class="space-y-3">
                    <h1 class="text-4xl font-black text-gray-900 tracking-tight">
                        Welcome Back!
                    </h1>
                    <h2 class="text-xl font-bold bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 bg-clip-text text-transparent">
                        BM Logistics System
                    </h2>
                    <p class="text-gray-600 font-medium">
                        Sign in to your account to access the container tracking system
                    </p>
                </div>
            </div>

            <!-- Login Form -->
            <div class="glass-effect rounded-3xl shadow-2xl p-8 animate-slide-up">
                <form action="{{ route('login.process') }}" method="POST" class="space-y-6" id="loginForm">
                    @csrf
                    
                    <!-- NIK Field -->
                    <div class="space-y-2">
                        <label for="EmpID" class="block text-sm font-bold text-gray-700 tracking-wide">
                            Employee ID (NIK)
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <input 
                                id="EmpID" 
                                type="text" 
                                name="EmpID" 
                                value="{{ old('EmpID') }}" 
                                required 
                                autocomplete="username"
                                placeholder="Enter your Employee ID"
                                class="input-field block w-full pl-12 pr-4 py-4 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white/80 backdrop-blur-sm font-medium text-lg"
                            />
                        </div>
                    </div>

                    <!-- Password Field -->
                    <div class="space-y-2">
                        <label for="Password" class="block text-sm font-bold text-gray-700 tracking-wide">
                            Password
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </div>
                            <input 
                                id="Password" 
                                type="password" 
                                name="Password" 
                                required 
                                autocomplete="current-password"
                                placeholder="Enter your password"
                                class="input-field block w-full pl-12 pr-12 py-4 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white/80 backdrop-blur-sm font-medium text-lg"
                            />
                            <button 
                                type="button" 
                                onclick="togglePassword()"
                                class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-gray-600 transition-colors"
                            >
                                <svg id="eyeIcon" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-4">
                        <button 
                            type="submit" 
                            class="login-btn group relative w-full flex justify-center items-center py-4 px-6 border border-transparent text-lg font-bold rounded-xl text-white bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 hover:from-blue-700 hover:via-purple-700 hover:to-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-300 transform hover:scale-105 shadow-xl"
                            id="submitBtn"
                        >
                            <svg class="w-6 h-6 mr-3 group-hover:animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                            </svg>
                            <span id="submitText">Sign In to Dashboard</span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Footer -->
            <div class="text-center space-y-4">
                <div class="flex items-center justify-center space-x-2 text-sm text-gray-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                    <span>Secure login system powered by BM Logistics</span>
                </div>
                <p class="text-xs text-gray-400">
                    © 2025 BukitMega Logistics. All rights reserved.
                </p>
            </div>
        </div>
    </div>

    <script>
        // Password toggle functionality
        function togglePassword() {
            const passwordField = document.getElementById('Password');
            const eyeIcon = document.getElementById('eyeIcon');
            
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"/>
                `;
            } else {
                passwordField.type = 'password';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                `;
            }
        }

        // Form submission handling
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const submitBtn = document.getElementById('submitBtn');
            const submitText = document.getElementById('submitText');
            
            // Disable button and show loading state
            submitBtn.disabled = true;
            submitBtn.classList.add('opacity-75', 'cursor-not-allowed');
            submitText.innerHTML = `
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Signing in...
            `;
        });

        // Enhanced keyboard navigation
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                const activeElement = document.activeElement;
                if (activeElement.id === 'EmpID') {
                    document.getElementById('Password').focus();
                    e.preventDefault();
                } else if (activeElement.id === 'Password') {
                    document.getElementById('loginForm').submit();
                }
            }
        });

        // Auto-focus on page load
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('EmpID').focus();
        });

        // SweetAlert notifications for messages
        @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '{{ session("success") }}',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            toast: true,
            position: 'top-end',
            background: 'rgba(255, 255, 255, 0.95)',
            backdrop: false
        });
        @endif

        @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Access Denied',
            text: '{{ session("error") }}',
            confirmButtonText: 'OK',
            confirmButtonColor: '#ef4444',
            background: 'rgba(255, 255, 255, 0.95)',
            customClass: {
                popup: 'rounded-2xl shadow-2xl border border-white/20'
            }
        });
        @endif

        @if(session('info'))
        Swal.fire({
            icon: 'info',
            title: 'Information',
            text: '{{ session("info") }}',
            confirmButtonText: 'OK',
            confirmButtonColor: '#3b82f6',
            background: 'rgba(255, 255, 255, 0.95)',
            customClass: {
                popup: 'rounded-2xl shadow-2xl border border-white/20'
            }
        });
        @endif

        @if($errors->has('login_error'))
        Swal.fire({
            icon: 'error',
            title: 'Login Failed',
            text: '{{ $errors->first("login_error") }}',
            confirmButtonText: 'Try Again',
            confirmButtonColor: '#ef4444',
            background: 'rgba(255, 255, 255, 0.95)',
            customClass: {
                popup: 'rounded-2xl shadow-2xl border border-white/20'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('EmpID').focus();
            }
        });
        @endif

        @if($errors->any() && !$errors->has('login_error'))
        Swal.fire({
            icon: 'error',
            title: 'Validation Error',
            html: '@foreach($errors->all() as $error) {{ $error }}<br> @endforeach',
            confirmButtonText: 'OK',
            confirmButtonColor: '#ef4444',
            background: 'rgba(255, 255, 255, 0.95)',
            customClass: {
                popup: 'rounded-2xl shadow-2xl border border-white/20'
            }
        });
        @endif
    </script>
</body>

</html>