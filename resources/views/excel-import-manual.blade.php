<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Ocean Shipments Manually | BM Logistics</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'sans': ['Inter', 'system-ui', 'sans-serif'],
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.5s ease-in-out',
                        'slide-up': 'slideUp 0.3s ease-out',
                        'bounce-gentle': 'bounceGentle 2s infinite',
                        'pulse-soft': 'pulseSoft 2s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                    }
                }
            }
        }
    </script>
    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes bounceGentle {

            0%,
            20%,
            50%,
            80%,
            100% {
                transform: translateY(0);
            }

            40% {
                transform: translateY(-4px);
            }

            60% {
                transform: translateY(-2px);
            }
        }

        @keyframes pulseSoft {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: .8;
            }
        }

        /* Advanced Background Effects */
        .bg-pattern {
            background-image: 
                radial-gradient(circle at 25% 25%, rgba(99, 102, 241, 0.05) 0%, transparent 50%),
                radial-gradient(circle at 75% 75%, rgba(168, 85, 247, 0.05) 0%, transparent 50%),
                radial-gradient(circle at 50% 50%, rgba(236, 72, 153, 0.05) 0%, transparent 50%);
        }

        /* Form styling */
        .form-group {
            transition: all 0.3s ease;
        }

        .form-group:hover {
            transform: translateY(-2px);
        }

        .form-input {
            transition: all 0.3s ease;
            border: 2px solid #e5e7eb;
        }

        .form-input:focus {
            border-color: #10b981;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
            transform: scale(1.02);
        }

        .form-input:hover {
            border-color: #d1d5db;
        }

        /* Grid responsive */
        @media (min-width: 768px) {
            .form-grid {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 1.5rem;
            }
        }
    </style>
</head>

<body class="h-full bg-pattern font-sans">

    <!-- Include Sidebar Component -->
    @include('components.sidebar')

    <!-- Main Content -->
    <div class="lg:pl-64 min-h-screen">
        <!-- Spacer for user greeting -->
        <div class="h-20"></div>
        
        <!-- Header -->
        <header class="pt-8 pb-12">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center space-y-6">
                    <!-- Brand -->
                    <div class="inline-flex items-center space-x-3 bg-white/80 backdrop-blur-sm rounded-full px-6 py-3 border border-gray-200 shadow-lg">
                        <div class="w-8 h-8 bg-gradient-to-r from-emerald-600 to-teal-600 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </div>
                        <span class="text-gray-700 font-semibold">Manual Entry</span>
                    </div>

                    <!-- Title -->
                    <h1 class="text-4xl sm:text-5xl font-bold text-gray-900 tracking-tight">
                        Add Ocean Shipments Manually
                    </h1>

                    <p class="max-w-2xl mx-auto text-lg text-gray-600">
                        Enter shipment details manually into the tracking system
                    </p>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pb-20">

            <!-- Success/Error Messages -->
            @if(session('success'))
            <div class="mb-8 animate-slide-up">
                <div class="bg-green-50 border border-green-200 rounded-2xl p-6 shadow-lg">
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0">
                            <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-semibold text-lg text-green-800">Success!</h4>
                            <p class="mt-1 text-green-700">{{ session('success') }}</p>
                        </div>
                        <button onclick="this.parentElement.parentElement.parentElement.remove()" class="ml-auto flex-shrink-0 text-green-400 hover:text-green-600 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            @endif

            @if($errors->any())
            <div class="mb-8 animate-slide-up">
                <div class="bg-red-50 border border-red-200 rounded-2xl p-6 shadow-lg">
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0">
                            <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-semibold text-lg text-red-800">Please fix the following errors:</h4>
                            <div class="mt-2 text-red-700">
                                @foreach($errors->all() as $error)
                                <p class="mt-1">• {{ $error }}</p>
                                @endforeach
                            </div>
                        </div>
                        <button onclick="this.parentElement.parentElement.parentElement.remove()" class="ml-auto flex-shrink-0 text-red-400 hover:text-red-600 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            @endif

            <!-- Form Card -->
            <div class="bg-white rounded-3xl border border-gray-200 shadow-xl overflow-hidden animate-fade-in">
                <div class="p-8 sm:p-12">
                    <form action="{{ route('import-manual.store') }}" method="POST" id="manualForm">
                        @csrf

                        <!-- Form Grid -->
                        <div class="form-grid space-y-6 md:space-y-0">
                            <!-- Booking Number -->
                            <div class="form-group">
                                <label for="booking_number" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Booking Number
                                    <!-- <span class="text-red-500">*</span> -->
                                </label>
                                <input type="text" 
                                       id="booking_number" 
                                       name="booking_number" 
                                       class="form-input w-full px-4 py-3 rounded-xl bg-gray-50 focus:bg-white focus:outline-none"
                                       placeholder="Enter Booking Number"
                                       value="{{ old('booking_number') }}"
                                       required>
                            </div>

                            <!-- Ocean Line -->
                            <div class="form-group">
                                <label for="ocean_line" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Ocean Line
                                    <!-- <span class="text-red-500">*</span> -->
                                </label>
                                <input type="text" 
                                       id="ocean_line" 
                                       name="ocean_line" 
                                       class="form-input w-full px-4 py-3 rounded-xl bg-gray-50 focus:bg-white focus:outline-none"
                                       placeholder="Enter Ocean Line"
                                       value="{{ old('ocean_line') }}"
                                       required>
                            </div>

                            <!-- Shipment Reference -->
                            <div class="form-group">
                                <label for="shipment_reference" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Shipment Reference
                                </label>
                                <input type="text" 
                                       id="shipment_reference" 
                                       name="shipment_reference" 
                                       class="form-input w-full px-4 py-3 rounded-xl bg-gray-50 focus:bg-white focus:outline-none"
                                       placeholder="Enter Shipment Reference"
                                       value="{{ old('shipment_reference') }}">
                            </div>

                            <!-- Shipper -->
                            <div class="form-group">
                                <label for="shipper" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Shipper
                                </label>
                                <input type="text" 
                                       id="shipper" 
                                       name="shipper" 
                                       class="form-input w-full px-4 py-3 rounded-xl bg-gray-50 focus:bg-white focus:outline-none"
                                       placeholder="Enter Shipper"
                                       value="{{ old('shipper') }}">
                            </div>

                            <!-- Promised ETA -->
                            <div class="form-group">
                                <label for="promised_eta" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Promised ETA
                                </label>
                                <input type="date" 
                                       id="promised_eta" 
                                       name="promised_eta" 
                                       class="form-input w-full px-4 py-3 rounded-xl bg-gray-50 focus:bg-white focus:outline-none"
                                       value="{{ old('promised_eta') }}">
                            </div>

                            <!-- Promised ETD -->
                            <div class="form-group">
                                <label for="promised_etd" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Promised ETD
                                </label>
                                <input type="date" 
                                       id="promised_etd" 
                                       name="promised_etd" 
                                       class="form-input w-full px-4 py-3 rounded-xl bg-gray-50 focus:bg-white focus:outline-none"
                                       value="{{ old('promised_etd') }}">
                            </div>

                            <!-- PO Number -->
                            <div class="form-group">
                                <label for="po_number" class="block text-sm font-semibold text-gray-700 mb-2">
                                    PO Number
                                </label>
                                <input type="text" 
                                       id="po_number" 
                                       name="po_number" 
                                       class="form-input w-full px-4 py-3 rounded-xl bg-gray-50 focus:bg-white focus:outline-none"
                                       placeholder="Enter PO Number"
                                       value="{{ old('po_number') }}">
                            </div>

                            <!-- Product Number -->
                            <div class="form-group">
                                <label for="product_number" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Product Number
                                </label>
                                <input type="text" 
                                       id="product_number" 
                                       name="product_number" 
                                       class="form-input w-full px-4 py-3 rounded-xl bg-gray-50 focus:bg-white focus:outline-none"
                                       placeholder="Enter Product Number"
                                       value="{{ old('product_number') }}">
                            </div>
                        </div>

                        <!-- Full Width Fields -->
                        <div class="mt-6 space-y-6">
                            <!-- Product Description -->
                            <div class="form-group">
                                <label for="product_description" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Product Description
                                </label>
                                <textarea id="product_description" 
                                         name="product_description" 
                                         rows="3"
                                         class="form-input w-full px-4 py-3 rounded-xl bg-gray-50 focus:bg-white focus:outline-none resize-none"
                                         placeholder="Enter Product Description">{{ old('product_description') }}</textarea>
                            </div>

                            <!-- Quantity Section -->
                            <div class="form-grid">
                                <div class="form-group">
                                    <label for="product_quantity" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Product Quantity
                                    </label>
                                    <input type="number" 
                                           id="product_quantity" 
                                           name="product_quantity" 
                                           class="form-input w-full px-4 py-3 rounded-xl bg-gray-50 focus:bg-white focus:outline-none"
                                           placeholder="Enter Quantity"
                                           value="{{ old('product_quantity') }}"
                                           min="0"
                                           step="0.01">
                                </div>

                                <div class="form-group">
                                    <label for="quantity_uom" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Quantity UOM
                                    </label>
                                    <input type="text" 
                                           id="quantity_uom" 
                                           name="quantity_uom" 
                                           class="form-input w-full px-4 py-3 rounded-xl bg-gray-50 focus:bg-white focus:outline-none"
                                           placeholder="Enter Quantity UOM"
                                           value="{{ old('quantity_uom') }}">
                                </div>
                            </div>

                            <!-- Tags Section -->
                            <div class="form-grid">
                                <div class="form-group">
                                    <label for="shipment_tags" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Shipment Tags
                                    </label>
                                    <input type="text" 
                                           id="shipment_tags" 
                                           name="shipment_tags" 
                                           class="form-input w-full px-4 py-3 rounded-xl bg-gray-50 focus:bg-white focus:outline-none"
                                           placeholder="Enter Shipment Tags"
                                           value="{{ old('shipment_tags') }}">
                                </div>

                                <div class="form-group">
                                    <label for="visible_to" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Visible To
                                    </label>
                                    <input type="text" 
                                           id="visible_to" 
                                           name="visible_to" 
                                           class="form-input w-full px-4 py-3 rounded-xl bg-gray-50 focus:bg-white focus:outline-none"
                                           placeholder="Enter Visible To"
                                           value="{{ old('visible_to') }}">
                                </div>
                            </div>

                            <!-- Team Names -->
                            <div class="form-group">
                                <label for="team_names" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Team Names
                                </label>
                                <input type="text" 
                                       id="team_names" 
                                       name="team_names" 
                                       class="form-input w-full px-4 py-3 rounded-xl bg-gray-50 focus:bg-white focus:outline-none"
                                       placeholder="Enter Team Names"
                                       value="{{ old('team_names') }}">
                            </div>
                        </div>

                        <!-- Submit Section -->
                        <div class="mt-12 flex flex-col sm:flex-row gap-4 justify-center">
                            <button type="button" 
                                    onclick="resetForm()" 
                                    class="inline-flex items-center justify-center px-8 py-4 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold text-lg rounded-2xl transition-all duration-200 transform hover:scale-105 shadow-lg">
                                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                                Reset Form
                            </button>

                            <button type="submit" 
                                    id="submitBtn"
                                    class="inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-semibold text-lg rounded-2xl transition-all duration-200 transform hover:scale-105 shadow-lg">
                                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                <span id="submitText">Add Shipment</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </main>
    </div>

    <script>
        // Form functions
        function resetForm() {
            Swal.fire({
                title: 'Reset Form?',
                text: 'All entered data will be lost.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, reset',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('manualForm').reset();
                    // Focus on first input
                    document.getElementById('booking_number').focus();
                    
                    Swal.fire({
                        title: 'Form Reset!',
                        text: 'All fields have been cleared.',
                        icon: 'success',
                        timer: 1500,
                        showConfirmButton: false
                    });
                }
            });
        }

        // Form submission with loading state
        document.getElementById('manualForm').addEventListener('submit', function(e) {
            const submitBtn = document.getElementById('submitBtn');
            const submitText = document.getElementById('submitText');
            
            // Disable submit button and show loading
            submitBtn.disabled = true;
            submitText.textContent = 'Adding...';
            
            // Show loading animation
            submitBtn.querySelector('svg').classList.add('animate-spin');
        });

        // Auto-focus on first input
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('booking_number').focus();

            // Auto-hide alerts after 8 seconds
            setTimeout(() => {
                const alerts = document.querySelectorAll('.animate-slide-up');
                alerts.forEach(alert => {
                    alert.style.transition = 'all 0.5s ease-out';
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateY(-10px)';
                    setTimeout(() => alert.remove(), 500);
                });
            }, 8000);
        });

        // SweetAlert notifications
        @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '{{ session("success") }}',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            toast: true,
            position: 'top-end'
        });
        @endif

        @if($errors->any())
        Swal.fire({
            icon: 'error',
            title: 'Validation Error!',
            html: '@foreach($errors->all() as $error) {{ $error }}<br> @endforeach',
            confirmButtonText: 'OK',
            confirmButtonColor: '#ef4444'
        });
        @endif

        // Enhanced form interactions
        document.querySelectorAll('.form-input').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('scale-105');
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.classList.remove('scale-105');
            });
        });
    </script>
</body>

</html>