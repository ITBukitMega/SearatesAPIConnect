<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Import Shipments | BM Logistics</title>
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

        .file-drop-zone {
            transition: all 0.3s ease;
            border: 2px dashed #d1d5db;
        }

        .file-drop-zone:hover {
            border-color: #8b5cf6;
            background-color: #faf5ff;
        }

        .file-drop-zone.drag-over {
            border-color: #7c3aed;
            background-color: #f3e8ff;
            transform: scale(1.02);
        }

        /* Advanced Background Effects */
        .bg-pattern {
            background-image: 
                radial-gradient(circle at 25% 25%, rgba(99, 102, 241, 0.05) 0%, transparent 50%),
                radial-gradient(circle at 75% 75%, rgba(168, 85, 247, 0.05) 0%, transparent 50%),
                radial-gradient(circle at 50% 50%, rgba(236, 72, 153, 0.05) 0%, transparent 50%);
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
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center space-y-6">
                    <!-- Brand -->
                    <div class="inline-flex items-center space-x-3 bg-white/80 backdrop-blur-sm rounded-full px-6 py-3 border border-gray-200 shadow-lg">
                        <div class="w-8 h-8 bg-gradient-to-r from-emerald-600 to-teal-600 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                            </svg>
                        </div>
                        <span class="text-gray-700 font-semibold">Import Data</span>
                    </div>

                    <!-- Title -->
                    <h1 class="text-4xl sm:text-5xl font-bold text-gray-900 tracking-tight">
                        Import Shipments
                    </h1>

                    <p class="max-w-2xl mx-auto text-lg text-gray-600">
                        Upload your Excel or CSV files to import shipment data into the tracking system
                    </p>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 pb-20">

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
                            <h4 class="font-semibold text-lg text-green-800">Import Successful!</h4>
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
                            <h4 class="font-semibold text-lg text-red-800">Import Failed</h4>
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

            <!-- Upload Card -->
            <div class="bg-white rounded-3xl border border-gray-200 shadow-xl overflow-hidden animate-fade-in">
                <div class="p-8 sm:p-12">
                    <form action="{{ route('import.excel') }}" method="POST" enctype="multipart/form-data" id="importForm">
                        @csrf

                        <!-- File Drop Zone -->
                        <div class="mb-8">
                            <div id="dropZone" class="file-drop-zone relative bg-gray-50 rounded-2xl p-12 text-center cursor-pointer">
                                <input type="file" id="fileInput" name="file" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                    accept=".xlsx,.xls,.csv" required>

                                <div id="uploadContent" class="space-y-6">
                                    <!-- Upload Icon -->
                                    <div class="mx-auto w-20 h-20 bg-gradient-to-r from-emerald-500 to-teal-500 rounded-full flex items-center justify-center shadow-lg animate-pulse-soft">
                                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                        </svg>
                                    </div>

                                    <!-- Instructions -->
                                    <div>
                                        <h3 class="text-2xl font-bold text-gray-900 mb-3">
                                            Drop your files here or <span class="text-emerald-600">browse</span>
                                        </h3>
                                        <p class="text-gray-600 text-lg">
                                            Upload Excel (.xlsx, .xls) or CSV files with your shipment data
                                        </p>
                                    </div>

                                    <!-- File Info -->
                                    <div class="flex items-center justify-center space-x-8 text-sm text-gray-500">
                                        <div class="flex items-center space-x-2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            <span>Max 10MB</span>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span>Excel & CSV</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Selected File Display -->
                                <div id="fileSelected" class="hidden space-y-4">
                                    <div class="mx-auto w-20 h-20 bg-green-100 rounded-full flex items-center justify-center">
                                        <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-bold text-gray-900" id="fileName"></h3>
                                        <p class="text-gray-600" id="fileSize"></p>
                                    </div>
                                    <button type="button" onclick="resetFile()" class="text-emerald-600 hover:text-emerald-700 font-medium transition-colors">
                                        Choose different file
                                    </button>
                                </div>

                                <!-- Loading State -->
                                <div id="uploadingState" class="hidden space-y-4">
                                    <div class="mx-auto w-20 h-20 bg-emerald-100 rounded-full flex items-center justify-center">
                                        <div class="w-10 h-10 border-4 border-emerald-200 border-t-emerald-600 rounded-full animate-spin"></div>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-bold text-gray-900">Processing...</h3>
                                        <p class="text-gray-600">Please wait while we import your data</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-center">
                            <button type="submit" id="submitBtn"
                                class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 disabled:from-gray-400 disabled:to-gray-500 text-white font-semibold text-lg rounded-2xl transition-all duration-200 transform hover:scale-105 disabled:scale-100 disabled:cursor-not-allowed shadow-lg">
                                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>
                                <span id="submitText">Import Shipments</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Download Template Card -->
            <div class="mt-8 bg-gradient-to-r from-green-50 to-blue-50 rounded-3xl border border-gray-200 shadow-lg overflow-hidden">
                <div class="p-8 text-center">
                    <div class="flex items-center justify-center space-x-4 mb-6">
                        <div class="w-12 h-12 bg-gradient-to-r from-green-600 to-blue-600 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900">Need a Template?</h2>
                    </div>

                    <p class="text-gray-600 text-lg mb-6">
                        Download our Excel template with the correct format and sample data
                    </p>

                    <a href="{{ route('download.template') }}"
                        class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-600 to-blue-600 hover:from-green-700 hover:to-blue-700 text-white font-semibold rounded-xl transition-all duration-200 transform hover:scale-105 shadow-lg">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Download Excel Template
                    </a>
                </div>
            </div>

        </main>
    </div>

    <script>
        // File handling
        const dropZone = document.getElementById('dropZone');
        const fileInput = document.getElementById('fileInput');
        const uploadContent = document.getElementById('uploadContent');
        const fileSelected = document.getElementById('fileSelected');
        const uploadingState = document.getElementById('uploadingState');
        const submitBtn = document.getElementById('submitBtn');
        const submitText = document.getElementById('submitText');

        // Drag and drop handlers
        dropZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropZone.classList.add('drag-over');
        });

        dropZone.addEventListener('dragleave', (e) => {
            e.preventDefault();
            dropZone.classList.remove('drag-over');
        });

        dropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropZone.classList.remove('drag-over');

            const files = e.dataTransfer.files;
            if (files.length > 0) {
                const file = files[0];
                if (isValidFile(file)) {
                    fileInput.files = files;
                    displaySelectedFile(file);
                } else {
                    showError('Please select a valid Excel or CSV file (max 10MB)');
                }
            }
        });

        // File input change handler
        fileInput.addEventListener('change', (e) => {
            const file = e.target.files[0];
            if (file && isValidFile(file)) {
                displaySelectedFile(file);
            } else if (file) {
                showError('Please select a valid Excel or CSV file (max 10MB)');
                resetFile();
            }
        });

        // Validate file
        function isValidFile(file) {
            const allowedTypes = [
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', // .xlsx
                'application/vnd.ms-excel', // .xls
                'text/csv', // .csv
                'application/csv'
            ];

            const maxSize = 10 * 1024 * 1024; // 10MB

            return allowedTypes.includes(file.type) && file.size <= maxSize;
        }

        // Display selected file
        function displaySelectedFile(file) {
            const fileName = document.getElementById('fileName');
            const fileSize = document.getElementById('fileSize');

            fileName.textContent = file.name;
            fileSize.textContent = formatFileSize(file.size);

            uploadContent.classList.add('hidden');
            fileSelected.classList.remove('hidden');
            uploadingState.classList.add('hidden');

            submitBtn.disabled = false;
        }

        // Reset file selection
        function resetFile() {
            fileInput.value = '';
            uploadContent.classList.remove('hidden');
            fileSelected.classList.add('hidden');
            uploadingState.classList.add('hidden');
            submitBtn.disabled = true;
        }

        // Format file size
        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }

        // Show error message
        function showError(message) {
            // SweetAlert for error messages
            Swal.fire({
                icon: 'error',
                title: 'File Error',
                text: message,
                confirmButtonText: 'OK',
                confirmButtonColor: '#059669'
            });
        }

        // Form submission
        document.getElementById('importForm').addEventListener('submit', function(e) {
            if (!fileInput.files.length) {
                e.preventDefault();
                showError('Please select a file to import');
                return;
            }

            // Show uploading state
            uploadContent.classList.add('hidden');
            fileSelected.classList.add('hidden');
            uploadingState.classList.remove('hidden');

            // Disable submit button
            submitBtn.disabled = true;
            submitText.textContent = 'Importing...';
        });

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            submitBtn.disabled = true;

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

        // SweetAlert notifications (converted from original)
        @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session("success") }}',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            toast: true,
            position: 'top-end'
        });
        @endif

        @if($errors -> any())
        Swal.fire({
            icon: 'error',
            title: 'Gagal Import!',
            html: '@foreach($errors->all() as $error) {{ $error }}<br> @endforeach',
            confirmButtonText: 'OK',
            confirmButtonColor: '#ef4444'
        });
        @endif
    </script>
</body>

</html>