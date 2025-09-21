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
        <ul class="space-y-2">
            <!-- Dashboard -->
            <li>
                <a href="#"
                    class="nav-link flex items-center space-x-4 px-4 py-3 text-gray-700 rounded-xl hover:bg-gray-50 hover:text-gray-800 transition-all duration-300 group font-semibold">
                    <div class="w-5 h-5 text-gray-400 group-hover:text-gray-600 transition-colors">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2 2v10z" />
                        </svg>
                    </div>
                    <span>Dashboard</span>
                </a>
            </li>

            <!-- Container Tracking -->
            <li>
                <a href="{{ route('dashboard-db') }}"
                    class="nav-link flex items-center space-x-4 px-4 py-3 text-gray-700 rounded-xl hover:bg-blue-50 hover:text-blue-700 transition-all duration-300 group font-semibold {{ request()->routeIs('dashboard-db') ? 'text-white bg-gradient-to-r from-blue-600 to-purple-600 shadow-lg' : '' }}">
                    <div class="w-5 h-5 {{ request()->routeIs('dashboard-db') ? 'text-white' : 'text-gray-400 group-hover:text-blue-600' }} transition-colors">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <span>Container Tracking</span>
                </a>
            </li>

            <!-- Add Shipments with Submenu -->
            <li>
                <button onclick="toggleSubmenu('add-shipments')"
                    class="nav-link w-full flex items-center space-x-4 px-4 py-3 text-gray-700 rounded-xl hover:bg-emerald-50 hover:text-emerald-700 transition-all duration-300 group font-semibold">
                    <div class="w-5 h-5 text-gray-400 group-hover:text-emerald-600 transition-colors">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                    </div>
                    <span class="flex-1 text-left">Add Shipments</span>
                    <div class="w-4 h-4 text-gray-400 transition-transform duration-200" id="add-shipments-arrow">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                </button>
                <!-- Submenu -->
                <ul id="add-shipments-submenu" class="ml-6 mt-2 space-y-1 hidden">
                    <li>
                        <a href="#"
                            class="nav-link flex items-center space-x-3 px-4 py-2 text-gray-600 rounded-lg hover:bg-emerald-50 hover:text-emerald-600 transition-all duration-200 font-medium text-sm">
                            <div class="w-4 h-4 text-gray-400">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </div>
                            <span>Add Ocean Shipments Manually</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('excel-import') }}"
                            class="nav-link flex items-center space-x-3 px-4 py-2 text-gray-600 rounded-lg hover:bg-emerald-50 hover:text-emerald-600 transition-all duration-200 font-medium text-sm {{ request()->routeIs('excel-import') ? 'text-emerald-600 bg-emerald-50' : '' }}">
                            <div class="w-4 h-4 text-gray-400">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>
                            </div>
                            <span>Import Ocean Shipments</span>
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Shipments with Submenu -->
            <li>
                <button onclick="toggleSubmenu('shipments')"
                    class="nav-link w-full flex items-center space-x-4 px-4 py-3 text-gray-700 rounded-xl hover:bg-purple-50 hover:text-purple-700 transition-all duration-300 group font-semibold">
                    <div class="w-5 h-5 text-gray-400 group-hover:text-purple-600 transition-colors">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                    <span class="flex-1 text-left">Shipments</span>
                    <div class="w-4 h-4 text-gray-400 transition-transform duration-200" id="shipments-arrow">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                </button>
                <!-- Submenu -->
                <ul id="shipments-submenu" class="ml-6 mt-2 space-y-1 hidden">
                    <li>
                        <a href="#"
                            class="nav-link flex items-center space-x-3 px-4 py-2 text-gray-600 rounded-lg hover:bg-purple-50 hover:text-purple-600 transition-all duration-200 font-medium text-sm">
                            <div class="w-4 h-4 text-gray-400">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                </svg>
                            </div>
                            <span>Ocean Shipments</span>
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            class="nav-link flex items-center space-x-3 px-4 py-2 text-gray-400 rounded-lg cursor-not-allowed font-medium text-sm">
                            <div class="w-4 h-4 text-gray-400">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
                                </svg>
                            </div>
                            <span>Road Shipments</span>
                            <span class="ml-auto text-xs bg-gradient-to-r from-purple-100 to-pink-100 text-purple-600 px-2 py-0.5 rounded-full font-bold">Soon</span>
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Calendar -->
            <li>
                <a href="{{ route('calendar') }}"
                    class="nav-link flex items-center space-x-4 px-4 py-3 text-gray-700 rounded-xl hover:bg-pink-50 hover:text-pink-700 transition-all duration-300 group font-semibold {{ request()->routeIs('calendar') ? 'text-white bg-gradient-to-r from-pink-600 to-rose-600 shadow-lg' : '' }}">
                    <div class="w-5 h-5 {{ request()->routeIs('calendar') ? 'text-white' : 'text-gray-400 group-hover:text-pink-600' }} transition-colors">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <span>Calendar</span>
                </a>
            </li>
        </ul>
    </nav>

    <div class="px-6 pb-6">
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

    // Toggle submenu function
    function toggleSubmenu(menuId) {
        const submenu = document.getElementById(`${menuId}-submenu`);
        const arrow = document.getElementById(`${menuId}-arrow`);
        
        if (submenu.classList.contains('hidden')) {
            // Show submenu
            submenu.classList.remove('hidden');
            arrow.style.transform = 'rotate(90deg)';
        } else {
            // Hide submenu
            submenu.classList.add('hidden');
            arrow.style.transform = 'rotate(0deg)';
        }
    }

    // Auto-expand submenu if current route matches
    document.addEventListener('DOMContentLoaded', function() {
        // Check if we're on excel-import page and expand Add Shipments menu
        if (window.location.href.includes('excel-import')) {
            toggleSubmenu('add-shipments');
        }
    });

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