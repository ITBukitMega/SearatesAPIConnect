<!-- resources/views/components/sidebar.blade.php -->
<div id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-white/95 backdrop-blur-xl border-r border-white/20 transform -translate-x-full lg:translate-x-0 transition-transform duration-500 ease-out shadow-2xl">
    <!-- Sidebar Header -->
    <div class="flex items-center justify-between h-20 px-6 border-b border-white/20 bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z" />
                </svg>
            </div>
            <span class="text-white font-black text-xl tracking-tight">BM Logistics</span>
        </div>
        <button onclick="toggleSidebar()" class="lg:hidden text-white hover:bg-white/10 rounded-lg p-2 transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <!-- Navigation Menu -->
    <nav class="flex-1 px-6 py-8">
        <ul class="space-y-4">
            <!-- Dashboard -->
            <li>
                <a href="{{ route('dashboard-db') }}"
                    class="nav-link flex items-center space-x-4 px-4 py-4 text-gray-700 rounded-xl hover:bg-blue-50 hover:text-blue-700 transition-all duration-300 group font-semibold {{ request()->routeIs('dashboard-db') ? 'text-white bg-gradient-to-r from-blue-600 to-purple-600 border-r-4 border-blue-600 shadow-lg' : '' }}">
                    <div class="w-6 h-6 {{ request()->routeIs('dashboard-db') ? 'text-white' : 'text-gray-400 group-hover:text-blue-600' }} transition-colors">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <span>Container Tracking</span>
                </a>
            </li>

            <!-- Calendar -->
            <li>
                <a href="{{ route('calendar') }}"
                    class="nav-link flex items-center space-x-4 px-4 py-4 text-gray-700 rounded-xl hover:bg-purple-50 hover:text-purple-700 transition-all duration-300 group font-semibold {{ request()->routeIs('calendar') ? 'text-white bg-gradient-to-r from-purple-600 to-pink-600 border-r-4 border-purple-600 shadow-lg' : '' }}">
                    <div class="w-6 h-6 {{ request()->routeIs('calendar') ? 'text-white' : 'text-gray-400 group-hover:text-purple-600' }} transition-colors">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <span>Calendar</span>
                </a>
            </li>

            <!-- Divider -->
            <li class="pt-6">
                <hr class="border-gray-200">
            </li>

            <!-- Shipment Section -->
            <li class="pt-6">
                <p class="px-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Shipments</p>
            </li>

            <!-- Import Data -->
            <li>
                <a href="{{ route('excel-import') }}"
                    class="nav-link flex items-center space-x-4 px-4 py-4 text-gray-700 rounded-xl hover:bg-emerald-50 hover:text-emerald-700 transition-all duration-300 group font-semibold {{ request()->routeIs('excel-import') ? 'text-white bg-gradient-to-r from-emerald-600 to-teal-600 border-r-4 border-emerald-600 shadow-lg' : '' }}">
                    <div class="w-6 h-6 {{ request()->routeIs('excel-import') ? 'text-white' : 'text-gray-400 group-hover:text-emerald-600' }} transition-colors">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                        </svg>
                    </div>
                    <span>Import Shipments</span>
                </a>
            </li>

            <li>
                <a href="#" class="nav-link flex items-center space-x-4 px-4 py-4 text-gray-400 rounded-xl cursor-not-allowed font-semibold">
                    <div class="w-6 h-6">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
                        </svg>
                    </div>
                    <span>Road Shipments</span>
                    <span class="ml-auto text-xs bg-gradient-to-r from-blue-100 to-purple-100 text-purple-600 px-3 py-1 rounded-full font-bold">Soon</span>
                </a>
            </li>
        </ul>
    </nav>

    

        <!-- Logout Button -->
        <button onclick="confirmLogout()" class="w-full flex items-center justify-center space-x-3 px-4 py-3 bg-gradient-to-r from-red-500 to-pink-500 hover:from-red-600 hover:to-pink-600 text-white rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg font-semibold group">
            <svg class="w-5 h-5 group-hover:animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
            </svg>
            <span>Logout</span>
        </button>
    </div>
</div>

<!-- Mobile Sidebar Backdrop -->
<div id="sidebar-backdrop" class="fixed inset-0 z-40 bg-black/50 backdrop-blur-sm lg:hidden hidden transition-opacity duration-300" onclick="closeSidebar()"></div>

<!-- Mobile Sidebar Toggle Button -->
<button onclick="openSidebar()" class="fixed top-6 left-6 z-30 lg:hidden bg-white/90 backdrop-blur-xl rounded-xl shadow-xl p-4 border border-white/20 hover:bg-white transition-all duration-300 pulse-glow">
    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
    </svg>
</button>

<!-- User Greeting Header -->
<div class="lg:pl-64 fixed top-0 right-0 z-20 w-auto">
    <div class="flex items-center justify-end p-6">
        <div class="bg-white/90 backdrop-blur-xl rounded-2xl shadow-xl px-6 py-3 border border-white/20">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-gradient-to-r from-blue-600 to-purple-600 rounded-full flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-700">Hello,</p>
                    <p class="text-lg font-bold text-gray-900">
                        {{ Auth::user()->name ?? 'IT BukitMega' }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .nav-link {
        position: relative;
        overflow: hidden;
    }
    
    .nav-link::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, 
            transparent, 
            rgba(99, 102, 241, 0.1), 
            transparent);
        transition: left 0.5s ease;
    }
    
    .nav-link:hover::before {
        left: 100%;
    }

    .pulse-glow {
        animation: pulse-glow 2s ease-in-out infinite alternate;
    }
    
    @keyframes pulse-glow {
        from {
            box-shadow: 0 0 20px rgba(99, 102, 241, 0.4);
        }
        to {
            box-shadow: 0 0 30px rgba(168, 85, 247, 0.6);
        }
    }
</style>

<!-- SweetAlert2 for Logout Confirmation -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Sidebar functions with smooth animations
    function openSidebar() {
        const sidebar = document.getElementById('sidebar');
        const backdrop = document.getElementById('sidebar-backdrop');
        
        sidebar.classList.remove('-translate-x-full');
        backdrop.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
        
        // Add animation classes
        backdrop.classList.add('animate-fade-in');
        sidebar.classList.add('animate-slide-in-left');
    }

    function closeSidebar() {
        const sidebar = document.getElementById('sidebar');
        const backdrop = document.getElementById('sidebar-backdrop');
        
        sidebar.classList.add('-translate-x-full');
        backdrop.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
        
        // Remove animation classes
        backdrop.classList.remove('animate-fade-in');
        sidebar.classList.remove('animate-slide-in-left');
    }

    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        if (sidebar.classList.contains('-translate-x-full')) {
            openSidebar();
        } else {
            closeSidebar();
        }
    }

    // Enhanced logout confirmation
    function confirmLogout() {
        Swal.fire({
            title: 'Are you sure?',
            text: 'You will be logged out of the system.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Yes, logout',
            cancelButtonText: 'Cancel',
            background: 'rgba(255, 255, 255, 0.98)',
            backdrop: 'rgba(0, 0, 0, 0.4)',
            customClass: {
                popup: 'rounded-2xl shadow-2xl border border-white/20',
                confirmButton: 'rounded-xl font-bold px-8 py-3',
                cancelButton: 'rounded-xl font-bold px-8 py-3'
            },
            showClass: {
                popup: 'animate__animated animate__zoomIn animate__faster'
            },
            hideClass: {
                popup: 'animate__animated animate__zoomOut animate__faster'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading state
                Swal.fire({
                    title: 'Logging out...',
                    html: 'Please wait while we securely log you out.',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false,
                    background: 'rgba(255, 255, 255, 0.98)',
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Submit logout form
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route("logout") }}';
                
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                
                form.appendChild(csrfToken);
                document.body.appendChild(form);
                form.submit();
            }
        });
    }

    // Close sidebar when clicking on nav links (mobile)
    document.querySelectorAll('.nav-link').forEach(link => {
        link.addEventListener('click', () => {
            if (window.innerWidth < 1024) {
                closeSidebar();
            }
        });
    });

    // Auto-close sidebar on larger screens
    window.addEventListener('resize', () => {
        if (window.innerWidth >= 1024) {
            closeSidebar();
        }
    });
</script>