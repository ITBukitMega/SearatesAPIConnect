<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Container Tracking Dashboard | BM Logistics</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="">
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
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

        .glass-effect {
            backdrop-filter: blur(20px);
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .card-shadow {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        /* Advanced Background Effects */
        .bg-pattern {
            background-image:
                radial-gradient(circle at 25% 25%, rgba(99, 102, 241, 0.05) 0%, transparent 50%),
                radial-gradient(circle at 75% 75%, rgba(168, 85, 247, 0.05) 0%, transparent 50%),
                radial-gradient(circle at 50% 50%, rgba(236, 72, 153, 0.05) 0%, transparent 50%);
        }

        /* Map Styles */
        .map-container {
            height: 500px;
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .leaflet-control-attribution {
            font-size: 10px !important;
        }

        .custom-marker-icon {
            border-radius: 50%;
            border: 3px solid white;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
        }

        /* Custom Location Marker Styles */
        .custom-location-marker {
            background: transparent !important;
            border: none !important;
            box-shadow: none !important;
        }

        /* Ensure location labels are visible above map elements */
        .custom-location-marker .bg-green-500,
        .custom-location-marker .bg-blue-500,
        .custom-location-marker .bg-red-500 {
            z-index: 1000;
            position: relative;
            backdrop-filter: blur(4px);
        }

        /* Custom popup styling */
        .custom-popup .leaflet-popup-content-wrapper {
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
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
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center space-y-8">
                    <!-- Brand -->
                    <div class="inline-flex items-center space-x-3 bg-white/80 backdrop-blur-sm rounded-full px-6 py-3 border border-gray-200 shadow-lg">
                        <div class="w-8 h-8 bg-gradient-to-r from-blue-600 to-purple-600 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z" />
                            </svg>
                        </div>
                        <span class="text-gray-700 font-semibold">BM Logistics</span>
                    </div>

                    <!-- Title -->
                    <h1 class="text-4xl sm:text-5xl font-bold text-gray-900 tracking-tight">
                        BukitMega Container Tracking
                    </h1>

                    <p class="max-w-2xl mx-auto text-lg text-gray-600">
                        Track your shipments in real-time with our advanced container tracking system
                    </p>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-20">
            <!-- Search Section -->
            <div class="mb-12">
                <div class="max-w-2xl mx-auto">
                    <form id="searchForm" class="relative group">
                        <div class="relative bg-white rounded-2xl border border-gray-200 shadow-xl overflow-hidden transition-all duration-300 hover:shadow-2xl">
                            <div class="flex">
                                <div class="flex-1 relative">
                                    <div class="absolute inset-y-0 left-0 pl-6 flex items-center pointer-events-none">
                                        <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                    </div>
                                    <input
                                        type="text"
                                        id="blNumber"
                                        name="bl_number"
                                        placeholder="Enter BL Number (e.g., EGLV050500317973)"
                                        class="w-full pl-14 pr-4 py-5 text-lg font-medium text-gray-900 placeholder-gray-500 bg-transparent border-0 focus:ring-0 focus:outline-none"
                                        required>
                                </div>
                                <button
                                    type="submit"
                                    id="searchBtn"
                                    class="px-8 py-5 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 disabled:from-gray-400 disabled:to-gray-500 text-white font-semibold text-lg transition-all duration-200 transform hover:scale-105 disabled:scale-100 disabled:cursor-not-allowed flex items-center space-x-3">
                                    <span id="searchIcon">🔍</span>
                                    <span id="searchText">Track Shipment</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Loading State -->
            <div id="loading" class="hidden max-w-4xl mx-auto mb-12 animate-fade-in">
                <div class="bg-white rounded-3xl border border-gray-200 p-12 text-center shadow-xl">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full mb-6 animate-bounce-gentle">
                        <svg class="w-8 h-8 text-white animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Searching Database...</h3>
                    <p class="text-gray-600">Please wait while we fetch your tracking information from local database</p>
                </div>
            </div>

            <!-- Messages -->
            <div id="messageContainer" class="hidden max-w-4xl mx-auto mb-8 animate-slide-up">
                <div id="messageContent" class="rounded-2xl border p-6 shadow-lg">
                    <div class="flex items-start space-x-3">
                        <div id="messageIcon" class="flex-shrink-0 w-6 h-6"></div>
                        <div class="flex-1">
                            <h4 id="messageTitle" class="font-semibold text-lg"></h4>
                            <p id="messageText" class="mt-1"></p>
                        </div>
                        <button onclick="hideMessage()" class="ml-auto flex-shrink-0 opacity-50 hover:opacity-75 transition-opacity">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Tracking Results -->
            <div id="trackingResults" class="hidden space-y-8 animate-fade-in">
                <!-- Header Card -->
                <div class="bg-white rounded-3xl border border-gray-200 shadow-xl overflow-hidden">
                    <!-- BL Header -->
                    <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-8 py-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z" />
                                    </svg>
                                </div>
                                <div>
                                    <h2 id="blDisplay" class="text-2xl font-bold text-white"></h2>
                                    <div class="flex items-center space-x-4 mt-1">
                                        <span id="containerInfo" class="text-blue-100 text-sm font-medium"></span>
                                        <span class="text-blue-200">•</span>
                                        <span id="statusDisplay" class="bg-white/20 backdrop-blur-sm rounded-full px-3 py-1 text-white text-sm font-semibold"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="w-3 h-3 bg-green-400 rounded-full animate-pulse"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Route Overview -->
                    <div class="p-8">
                        <div id="routeOverview" class="flex items-center justify-between relative">
                            <!-- Will be populated dynamically -->
                        </div>
                    </div>

                    <!-- Navigation Tabs -->
                    <div class="border-t border-gray-200 bg-gray-50">
                        <nav class="flex">
                            <button onclick="switchTab('route')" data-tab="route" class="tab-btn flex-1 py-4 px-6 text-center font-semibold transition-all duration-200 border-b-2 border-blue-500 text-blue-600 bg-white">
                                Route
                            </button>
                            <button onclick="switchTab('map')" data-tab="map" class="tab-btn flex-1 py-4 px-6 text-center font-semibold transition-all duration-200 border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:bg-white/50">
                                Map
                            </button>
                            <button onclick="switchTab('vessel')" data-tab="vessel" class="tab-btn flex-1 py-4 px-6 text-center font-semibold transition-all duration-200 border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:bg-white/50">
                                Vessel
                            </button>
                            <button onclick="switchTab('containers')" data-tab="containers" class="tab-btn flex-1 py-4 px-6 text-center font-semibold transition-all duration-200 border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:bg-white/50">
                                Containers
                            </button>
                        </nav>
                    </div>
                </div>

                <!-- Tab Content -->
                <div class="bg-white rounded-3xl border border-gray-200 shadow-xl">
                    <div id="tabContent" class="p-8"></div>
                </div>
            </div>
        </main>
    </div>

    <script>
        let trackingData = null;
        let currentTab = 'route';
        let map = null;
        let routeLine = null;
        let markers = [];

        // Format date fungsi
        function formatDate(dateString) {
            if (!dateString) return 'N/A';
            try {
                const date = new Date(dateString);
                return date.toLocaleDateString('en-US', {
                    day: '2-digit',
                    month: 'short',
                    year: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                });
            } catch (error) {
                return dateString;
            }
        }

        // Format date konversi
        function formatDateShort(dateString) {
            if (!dateString) return 'N/A';
            try {
                const date = new Date(dateString);
                return date.toLocaleDateString('en-US', {
                    day: 'numeric',
                    month: 'short',
                    year: 'numeric'
                });
            } catch (error) {
                return dateString;
            }
        }

        // Get location by ID
        function getLocationById(id) {
            if (!trackingData?.locations) return {
                name: 'Unknown',
                country_code: ''
            };
            return trackingData.locations.find(loc => loc.id === id) || {
                name: 'Unknown',
                country_code: ''
            };
        }

        // Show message
        function showMessage(type, text) {
            const container = document.getElementById('messageContainer');
            const content = document.getElementById('messageContent');
            const icon = document.getElementById('messageIcon');
            const title = document.getElementById('messageTitle');
            const message = document.getElementById('messageText');

            const config = {
                error: {
                    classes: 'bg-red-50 border-red-200 text-red-800',
                    iconHtml: '<svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
                    title: 'Error'
                },
                success: {
                    classes: 'bg-green-50 border-green-200 text-green-800',
                    iconHtml: '<svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
                    title: 'Success'
                },
                info: {
                    classes: 'bg-blue-50 border-blue-200 text-blue-800',
                    iconHtml: '<svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
                    title: 'Information'
                }
            };

            content.className = `rounded-2xl border p-6 shadow-lg ${config[type].classes}`;
            icon.innerHTML = config[type].iconHtml;
            title.textContent = config[type].title;
            message.textContent = text;
            container.classList.remove('hidden');

            if (type === 'success' || type === 'info') {
                setTimeout(hideMessage, 5000);
            }
        }

        // Hide message
        function hideMessage() {
            document.getElementById('messageContainer').classList.add('hidden');
        }

        // Show/hide loading
        function showLoading() {
            document.getElementById('loading').classList.remove('hidden');
            document.getElementById('trackingResults').classList.add('hidden');
            document.getElementById('searchBtn').disabled = true;
            document.getElementById('searchIcon').textContent = '⏳';
            document.getElementById('searchText').textContent = 'Searching...';
            hideMessage();
        }

        function hideLoading() {
            document.getElementById('loading').classList.add('hidden');
            document.getElementById('searchBtn').disabled = false;
            document.getElementById('searchIcon').textContent = '🔍';
            document.getElementById('searchText').textContent = 'Track Shipment';
        }

        // Switch tabs
        function switchTab(tabName) {
            currentTab = tabName;

            // Update tab buttons
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.className = 'tab-btn flex-1 py-4 px-6 text-center font-semibold transition-all duration-200 border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:bg-white/50';
            });

            const activeBtn = document.querySelector(`[data-tab="${tabName}"]`);
            if (activeBtn) {
                activeBtn.className = 'tab-btn flex-1 py-4 px-6 text-center font-semibold transition-all duration-200 border-b-2 border-blue-500 text-blue-600 bg-white';
            }

            // Update content
            renderTabContent();

            // Initialize map if switching to map tab
            if (tabName === 'map') {
                setTimeout(initializeMap, 100);
            }
        }

        // Render route overview
        function renderRouteOverview() {
            const container = document.getElementById('routeOverview');

            if (trackingData?.route?.pol && trackingData?.route?.pod && trackingData?.locations?.length > 0) {
                const polLocation = getLocationById(trackingData.route.pol.location);
                const podLocation = getLocationById(trackingData.route.pod.location);

                // Simple POL logic
                const polDate = trackingData.route.pol.date ? formatDateShort(trackingData.route.pol.date) : 'N/A';

                // Simple POD logic - check actual date first, then predictive
                let podDate = 'N/A';
                let podLabel = 'ATA';

                if (trackingData.route.pod.date) {
                    // Use actual date
                    podDate = formatDateShort(trackingData.route.pod.date);
                    podLabel = 'ATA';
                } else if (trackingData.route.pod.predictive_eta) {
                    // Use predictive ETA
                    podDate = formatDateShort(trackingData.route.pod.predictive_eta);
                    podLabel = 'ETA (Predictive)';
                } else {
                    // No date available
                    podLabel = 'ETA';
                }

                container.innerHTML = `
                    <div class="w-full relative">
                        <!-- Route Line -->
                        <div class="absolute top-1/2 left-0 right-0 h-1 bg-gradient-to-r from-blue-500 to-purple-600 transform -translate-y-1/2 rounded-full"></div>
                        
                        <!-- Origin -->
                        <div class="flex justify-between items-center relative z-10">
                            <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-lg max-w-xs">
                                <div class="flex items-center space-x-3 mb-3">
                                    <div class="w-4 h-4 bg-blue-600 rounded-full"></div>
                                    <h3 class="font-bold text-gray-900">${polLocation.name}${polLocation.country_code ? ', ' + polLocation.country_code : ''}</h3>
                                </div>
                                <p class="text-sm text-gray-600 font-medium">ATD</p>
                                <p class="text-blue-600 font-bold">${polDate}</p>
                            </div>
                            
                            <!-- Destination -->
                            <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-lg max-w-xs">
                                <div class="flex items-center space-x-3 mb-3">
                                    <div class="w-4 h-4 bg-purple-600 rounded-full"></div>
                                    <h3 class="font-bold text-gray-900">${podLocation.name}${podLocation.country_code ? ', ' + podLocation.country_code : ''}</h3>
                                </div>
                                <p class="text-sm text-gray-600 font-medium">${podLabel}</p>
                                <p class="text-purple-600 font-bold">${podDate}</p>
                            </div>
                        </div>
                    </div>
                `;
            } else {
                container.innerHTML = `
                    <div class="text-center py-8 w-full">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <p class="text-gray-500">Route information not available</p>
                    </div>
                `;
            }
        }

        // Render tab content
        function renderTabContent() {
            const container = document.getElementById('tabContent');

            switch (currentTab) {
                case 'route':
                    renderRouteContent(container);
                    break;
                case 'map':
                    renderMapContent(container);
                    break;
                case 'vessel':
                    renderVesselContent(container);
                    break;
                case 'containers':
                    renderContainerContent(container);
                    break;
                case 'exceptions':
                    renderExceptionsContent(container);
                    break;
            }
        }

        function renderRouteContent(container) {
            if (!trackingData?.containers?.[0]?.events?.length) {
                container.innerHTML = `
                    <div class="text-center py-20">
                        <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">No Event Information</h3>
                        <p class="text-gray-500">No tracking events are available for this shipment.</p>
                    </div>
                `;
                return;
            }

            // Group events by location similar to searates.com
            const eventsByLocation = {};
            trackingData.containers[0].events.forEach(event => {
                const location = getLocationById(event.location);
                const locationName = `${location.name}${location.country_code ? ', ' + location.country_code : ''}`;

                if (!eventsByLocation[locationName]) {
                    eventsByLocation[locationName] = [];
                }
                eventsByLocation[locationName].push(event);
            });

            let html = '<div class="space-y-6">';

            Object.entries(eventsByLocation).forEach(([locationName, events], index) => {
                const isLast = index === Object.entries(eventsByLocation).length - 1;

                html += `
                    <div class="relative">
                        ${!isLast ? '<div class="absolute left-6 top-16 bottom-0 w-0.5 bg-gray-300"></div>' : ''}
                        <div class="flex items-start space-x-6">
                            <div class="flex-shrink-0 w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center shadow-lg z-10 relative">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-xl font-bold text-gray-900 mb-4">${locationName}</h3>
                                <div class="space-y-3">
                `;

                events.forEach((event, eventIndex) => {
                    html += `
                        <div class="flex items-center justify-between py-3 px-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors duration-200">
                            <div class="flex-1">
                                <p class="font-semibold text-gray-900">${event.description || 'Event'}</p>
                            </div>
                            <div class="text-right ml-4">
                                <p class="font-bold text-gray-900">${formatDate(event.date)}</p>
                            </div>
                        </div>
                    `;
                });

                html += `
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            });
            html += '</div>';

            container.innerHTML = html;
        }

        // Render Map Content
        function renderMapContent(container) {
            if (!trackingData?.locations?.length) {
                container.innerHTML = `
            <div class="text-center py-20">
                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 013.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-1.447-.894L15 4m0 13V4m-6 3l6-3"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">No Location Data</h3>
                <p class="text-gray-500">No location data is available to display on the map.</p>
            </div>
        `;
                return;
            }

            container.innerHTML = `
        <div class="space-y-6">
            <!-- Map Header -->
            <div class="flex items-center justify-between">
                <h3 class="text-2xl font-bold text-gray-900">Shipment Route Map</h3>
                <div class="flex items-center space-x-2 text-sm text-gray-600">
                    <div class="flex items-center space-x-1">
                        <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                        <span>Origin</span>
                    </div>
                    <div class="flex items-center space-x-1">
                        <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                        <span>Transit</span>
                    </div>
                    <div class="flex items-center space-x-1">
                        <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                        <span>Destination</span>
                    </div>
                </div>
            </div>
            
            <!-- Map Container -->
            <div id="mapContainer" class="map-container"></div>
            
            <!-- Route Summary -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6" id="routeSummary">
                <!-- Will be populated by JavaScript -->
            </div>
        </div>
    `;
        }

        // Initialize Map
        function initializeMap() {
            if (!trackingData?.locations?.length) return;

            // Destroy existing map if it exists
            if (map) {
                map.remove();
                map = null;
            }

            // Clear existing markers
            markers = [];

            // Get unique locations from events in chronological order (latest api_id to earliest)
            const routeLocations = getRouteLocations();

            if (routeLocations.length === 0) return;

            // Initialize map
            const mapContainer = document.getElementById('mapContainer');
            if (!mapContainer) return;

            // Calculate bounds
            const bounds = L.latLngBounds(routeLocations.map(loc => [loc.lat, loc.lng]));

            // Create map
            map = L.map(mapContainer, {
                center: bounds.getCenter(),
                zoom: 2,
                zoomControl: true,
                attributionControl: true
            });

            // Add OpenStreetMap tiles
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 18,
                attribution: '© <a href="https://openstreetmap.org">OpenStreetMap</a> contributors'
            }).addTo(map);

            // Add markers and route line
            addMarkersAndRoute(routeLocations);

            // Fit bounds with padding
            if (routeLocations.length > 1) {
                map.fitBounds(bounds, {
                    padding: [20, 20]
                });
            } else {
                map.setView([routeLocations[0].lat, routeLocations[0].lng], 8);
            }

            // Update route summary
            updateRouteSummary(routeLocations);
        }

        // Get route locations in order (from events)
        function getRouteLocations() {
            if (!trackingData?.containers?.[0]?.events?.length) return [];

            // Get unique location IDs from events in chronological order
            const eventLocationIds = [];
            const seenLocations = new Set();

            // Sort events by order_id to get chronological order
            const sortedEvents = [...trackingData.containers[0].events].sort((a, b) => a.order_id - b.order_id);

            sortedEvents.forEach(event => {
                if (!seenLocations.has(event.location)) {
                    eventLocationIds.push(event.location);
                    seenLocations.add(event.location);
                }
            });

            // Map to actual location objects
            const locations = [];
            eventLocationIds.forEach(locationId => {
                const location = trackingData.locations.find(loc => loc.id === locationId);
                if (location && location.lat && location.lng) {
                    locations.push(location);
                }
            });

            return locations;
        }

        // Add markers and route line
        // Add markers and route line
        function addMarkersAndRoute(locations) {
            if (locations.length === 0) return;

            // Create route line coordinates
            const routeCoordinates = locations.map(loc => [loc.lat, loc.lng]);

            // Add route line
            if (locations.length > 1) {
                routeLine = L.polyline(routeCoordinates, {
                    color: '#3b82f6',
                    weight: 3,
                    opacity: 0.8,
                    dashArray: '10, 5'
                }).addTo(map);
            }

            // Add markers with location labels
            locations.forEach((location, index) => {
                const isFirst = index === 0;
                const isLast = index === locations.length - 1;

                let markerColor, markerTitle, badgeColor;
                if (isFirst) {
                    markerColor = '#10b981'; // Green for origin
                    markerTitle = 'Origin';
                    badgeColor = 'bg-green-500';
                } else if (isLast) {
                    markerColor = '#ef4444'; // Red for destination
                    markerTitle = 'Destination';
                    badgeColor = 'bg-red-500';
                } else {
                    markerColor = '#3b82f6'; // Blue for transit
                    markerTitle = 'Transit';
                    badgeColor = 'bg-blue-500';
                }

                // Create marker with location name label
                const markerIcon = L.divIcon({
                    className: 'custom-location-marker',
                    html: `
                <div class="flex flex-col items-center">
                    <!-- Location Label -->
                    <div class="mb-1 px-3 py-1 ${badgeColor} text-white text-xs font-semibold rounded-full whitespace-nowrap shadow-lg">
                        ${location.name}
                    </div>
                    <!-- Marker Pin -->
                    <div style="
                        width: 20px; 
                        height: 20px; 
                        background-color: ${markerColor}; 
                        border: 2px solid white;
                        border-radius: 50%;
                        box-shadow: 0 2px 8px rgba(0,0,0,0.3);
                    "></div>
                    <!-- Connection Line -->
                    <div style="
                        width: 1px;
                        height: 8px;
                        background-color: ${markerColor};
                        margin-top: -2px;
                    "></div>
                </div>
            `,
                    iconSize: [150, 40], // Increased size to accommodate label
                    iconAnchor: [75, 40] // Adjust anchor point for the label
                });

                // buat marker
                const marker = L.marker([location.lat, location.lng], {
                        icon: markerIcon
                    })
                    .addTo(map)
                    .bindPopup(`
                <div class="text-center">
                    <div class="font-bold text-gray-900 text-lg">${location.name}</div>
                    <div class="text-sm text-gray-600">${location.country}${location.country_code ? ' (' + location.country_code + ')' : ''}</div>
                    ${location.locode ? `<div class="text-xs text-blue-600 mt-1">LOCODE: ${location.locode}</div>` : ''}
                    <div class="inline-block px-2 py-1 ${badgeColor} text-white text-xs font-semibold rounded-full mt-2">
                        ${markerTitle}
                    </div>
                </div>
            `, {
                        closeButton: false,
                        className: 'custom-popup'
                    });

                markers.push(marker);
            });
        }

        // Update route summary
        function updateRouteSummary(locations) {
            const summaryContainer = document.getElementById('routeSummary');
            if (!summaryContainer || locations.length === 0) return;

            let summaryHtml = '';

            locations.forEach((location, index) => {
                const isFirst = index === 0;
                const isLast = index === locations.length - 1;

                let badgeClass, badgeText;
                if (isFirst) {
                    badgeClass = 'bg-green-100 text-green-800';
                    badgeText = 'Origin';
                } else if (isLast) {
                    badgeClass = 'bg-red-100 text-red-800';
                    badgeText = 'Destination';
                } else {
                    badgeClass = 'bg-blue-100 text-blue-800';
                    badgeText = 'Transit';
                }

                summaryHtml += `
            <div class="bg-white rounded-xl border border-gray-200 p-4 shadow-sm hover:shadow-md transition-shadow duration-200">
                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${badgeClass}">
                            ${badgeText}
                        </span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-900 truncate">${location.name}</p>
                        <p class="text-xs text-gray-600">${location.country}${location.country_code ? ' (' + location.country_code + ')' : ''}</p>
                        ${location.locode ? `<p class="text-xs text-blue-600 mt-1">LOCODE: ${location.locode}</p>` : ''}
                    </div>
                </div>
            </div>
        `;
            });

            summaryContainer.innerHTML = summaryHtml;
        }

        //Simple Logic Vessel, cuma core logic (theme nya biru!!!!!)
        function renderVesselContent(container) {
            if (!trackingData?.vessels?.length) {
                container.innerHTML = `
                    <div class="text-center py-20">
                        <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">No Vessel Information</h3>
                        <p class="text-gray-500">No vessel data is available for this shipment.</p>
                    </div>
                `;
                return;
            }

            let html = '<div class="space-y-8">';

            // Get vessel info from events - STRICT vessel-event mapping
            const vesselEvents = {};
            if (trackingData.containers?.[0]?.events) {
                trackingData.containers[0].events.forEach(event => {
                    if (event.vessel && event.voyage) {
                        if (!vesselEvents[event.vessel]) {
                            vesselEvents[event.vessel] = {
                                voyages: new Set(),
                                events: []
                            };
                        }
                        vesselEvents[event.vessel].voyages.add(event.voyage);
                        vesselEvents[event.vessel].events.push(event);
                    }
                });
            }

            trackingData.vessels.forEach((vessel, index) => {
                const vesselEventData = vesselEvents[vessel.id] || {
                    voyages: new Set(),
                    events: []
                };
                const voyages = Array.from(vesselEventData.voyages);
                const events = vesselEventData.events;

                // Simple vessel logic - NO FALLBACK TO ROUTE DATA
                let loadingPort = 'N/A';
                let dischargePort = 'N/A';
                let atd = 'N/A';
                let ata = 'N/A';

                // STRICT: Only use events that specifically belong to this vessel
                if (events.length > 0) {
                    // Sort events by order_id to get chronological order
                    const sortedEvents = events.sort((a, b) => a.order_id - b.order_id);

                    // Get unique locations in order of occurrence for THIS SPECIFIC VESSEL
                    const vesselLocations = [];
                    sortedEvents.forEach(event => {
                        if (!vesselLocations.includes(event.location)) {
                            vesselLocations.push(event.location);
                        }
                    });

                    // ATD: Find departure event at first location for this vessel
                    if (vesselLocations.length > 0) {
                        const firstLocation = vesselLocations[0];
                        const eventsAtFirstLocation = sortedEvents.filter(e => e.location === firstLocation);
                        const departureEvent = eventsAtFirstLocation.reverse().find(e => ['LOAD', 'VDL', 'DEPA'].includes(e.event_code) || e.type === 'sea');

                        if (departureEvent) {
                            atd = formatDateShort(departureEvent.date);
                            const loadLocation = getLocationById(firstLocation);
                            loadingPort = `${loadLocation.name}${loadLocation.country_code ? ', ' + loadLocation.country_code : ''}`;
                        }
                    }

                    // ATA: Find arrival event at next location for this vessel
                    if (vesselLocations.length > 1) {
                        const nextLocation = vesselLocations[1];
                        const eventsAtNextLocation = sortedEvents.filter(e => e.location === nextLocation);
                        const arrivalEvent = eventsAtNextLocation.find(e => ['DISC', 'VAD', 'VAT', 'ARRI'].includes(e.event_code) || e.type === 'sea');

                        if (arrivalEvent) {
                            ata = formatDateShort(arrivalEvent.date);
                            const discLocation = getLocationById(nextLocation);
                            dischargePort = `${discLocation.name}${discLocation.country_code ? ', ' + discLocation.country_code : ''}`;
                        }
                    }
                }

                // NO FALLBACK TO ROUTE DATA - Keep N/A if no vessel-specific events found

                html += `
                    <div class="space-y-6">
                        <!-- Simple Vessel Header (BLUE THEME) -->
                        <div class="flex items-center space-x-4 p-6 bg-blue-50 rounded-2xl border border-blue-100">
                            <div class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-2xl font-bold text-blue-600">${vessel.name || 'Unknown'}</p>
                            </div>
                        </div>
                        
                        <!-- Simple Vessel Details Grid -->
                        <div class="grid grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <p class="text-sm font-medium text-gray-600">Voyage</p>
                                <p class="text-2xl font-bold text-gray-900">${voyages.length > 0 ? voyages[0] : 'N/A'}</p>
                            </div>
                            <div class="space-y-2">
                                <p class="text-sm font-medium text-gray-600">Loading</p>
                                <p class="text-2xl font-bold text-gray-900">${loadingPort}</p>
                            </div>
                            <div class="space-y-2">
                                <p class="text-sm font-medium text-gray-600">Discharge</p>
                                <p class="text-2xl font-bold text-gray-900">${dischargePort}</p>
                            </div>
                            <div class="space-y-2">
                                <p class="text-sm font-medium text-gray-600">ATD</p>
                                <p class="text-2xl font-bold text-gray-900">${atd}</p>
                            </div>
                            <div class="space-y-2">
                                <p class="text-sm font-medium text-gray-600">ATA</p>
                                <p class="text-2xl font-bold text-gray-900">${ata}</p>
                            </div>
                        </div>
                    </div>
                    
                    ${index < trackingData.vessels.length - 1 ? '<hr class="border-gray-200 my-8">' : ''}
                `;
            });

            html += '</div>';
            container.innerHTML = html;
        }

        function renderContainerContent(container) {
            if (!trackingData?.containers?.length) {
                container.innerHTML = `
                    <div class="text-center py-20">
                        <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">No Container Information</h3>
                        <p class="text-gray-500">No container data is available for this shipment.</p>
                    </div>
                `;
                return;
            }

            let html = '<div class="space-y-12">';

            trackingData.containers.forEach((containerData, containerIndex) => {
                html += `
                    <div class="space-y-8">
                        <!-- Container Header -->
                        <div class="flex items-center space-x-4 p-6 bg-gray-50 rounded-2xl">
                            <div class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-medium text-gray-700">Container</h3>
                                <p class="text-2xl font-bold text-blue-600">${containerData.number || 'Unknown'}</p>
                            </div>
                        </div>
                `;

                // Add container events timeline if available
                if (containerData.events && containerData.events.length > 0) {
                    // Group events by location
                    const eventsByLocation = {};
                    containerData.events.forEach(event => {
                        const location = getLocationById(event.location);
                        const locationName = `${location.name}${location.country_code ? ', ' + location.country_code : ''}`;

                        if (!eventsByLocation[locationName]) {
                            eventsByLocation[locationName] = [];
                        }
                        eventsByLocation[locationName].push(event);
                    });

                    html += `
                        <!-- Container Events Timeline -->
                        <div class="border-t border-gray-200 pt-8">
                            <h4 class="text-xl font-bold text-gray-900 mb-6">Container Events Timeline</h4>
                            <div class="space-y-6">
                    `;

                    Object.entries(eventsByLocation).forEach(([locationName, events], index) => {
                        const isLast = index === Object.entries(eventsByLocation).length - 1;

                        html += `
                            <div class="relative">
                                ${!isLast ? '<div class="absolute left-6 top-16 bottom-0 w-0.5 bg-gray-300"></div>' : ''}
                                <div class="flex items-start space-x-6">
                                    <div class="flex-shrink-0 w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center shadow-lg z-10 relative">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-xl font-bold text-gray-900 mb-4">${locationName}</h3>
                                        <div class="space-y-3">
                        `;

                        events.forEach((event, eventIndex) => {
                            html += `
                                <div class="flex items-center justify-between py-3 px-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors duration-200">
                                    <div class="flex-1">
                                        <p class="font-semibold text-gray-900">${event.description || 'Event'}</p>
                                    </div>
                                    <div class="text-right ml-4">
                                        <p class="font-bold text-gray-900">${formatDate(event.date)}</p>
                                    </div>
                                </div>
                            `;
                        });

                        html += `
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                    });

                    html += `
                            </div>
                        </div>
                    `;
                } else {
                    html += `
                        <div class="border-t border-gray-200 pt-8">
                            <div class="text-center py-12">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                    </svg>
                                </div>
                                <p class="text-gray-500">No events available for this container</p>
                            </div>
                        </div>
                    `;
                }

                html += `
                    </div>
                    ${containerIndex < trackingData.containers.length - 1 ? '<hr class="border-gray-200 my-12">' : ''}
                `;
            });

            html += '</div>';
            container.innerHTML = html;
        }

        function renderExceptionsContent(container) {
            container.innerHTML = `
                <div class="text-center py-20">
                    <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">No Exceptions Found</h3>
                    <p class="text-gray-500">Your shipment is proceeding without any reported exceptions or delays.</p>
                </div>
            `;
        }

        // Display tracking data
        function displayTrackingData(data) {
            trackingData = data;

            // Update header info
            document.getElementById('blDisplay').textContent = `BL ${data.metadata.number}`;

            // Count containers by size_type
            let containerCounts = {};
            if (data.containers && data.containers.length > 0) {
                data.containers.forEach(container => {
                    const sizeType = container.size_type || 'Unknown';
                    if (!containerCounts[sizeType]) {
                        containerCounts[sizeType] = 1;
                    } else {
                        containerCounts[sizeType]++;
                    }
                });
            }

            // Format teks info container
            const containerInfo = data.containers?.length > 0 ?
                (() => {
                    // Ambil size_type dari container pertama
                    const firstSizeType = data.containers[0].size_type || 'Container';
                    // Hitung jumlah container dengan tipe yang sama
                    const count = containerCounts[firstSizeType] || 1;

                    // Tampilin format "jumlah x tipe" untuk semua container
                    return `${count} x ${firstSizeType}`;
                })() :
                ''; // String kosong jika tidak ada container

            document.getElementById('containerInfo').textContent = containerInfo;
            document.getElementById('statusDisplay').textContent = data.metadata.status || 'Unknown';

            // Render route overview
            renderRouteOverview();

            // Show results and render first tab
            document.getElementById('trackingResults').classList.remove('hidden');
            currentTab = 'route';
            renderTabContent();

            // Clear existing map if any
            if (map) {
                map.remove();
                map = null;
                markers = [];
            }
        }

        // Search tracking
        async function searchTracking() {
            const blNumber = document.getElementById('blNumber').value.trim();

            if (!blNumber) {
                showMessage('error', 'Please enter a BL Number');
                return;
            }

            showLoading();

            try {
                const response = await fetch('{{ route("dashboard-db.search") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        bl_number: blNumber.toUpperCase()
                    })
                });

                const result = await response.json();

                if (response.ok && result.status === 'success') {
                    hideLoading();
                    displayTrackingData(result.data);
                    showMessage('success', `Tracking data loaded successfully from database for BL ${blNumber}!`);
                } else {
                    hideLoading();
                    showMessage('error', result.error || 'Failed to fetch tracking data from database');
                }
            } catch (error) {
                hideLoading();
                console.error('Error:', error);
                showMessage('error', 'Network error occurred. Please check your connection and try again.');
            }
        }

        // Event listeners
        document.getElementById('searchForm').addEventListener('submit', function(e) {
            e.preventDefault();
            searchTracking();
        });

        document.getElementById('blNumber').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                searchTracking();
            }
        });

        // Focus on input when page loads
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('blNumber').focus();

            // Check for auto-search parameter
            checkForAutoSearch();
        });


        // Function to check for BL number in URL and auto-search
        function checkForAutoSearch() {
            const urlParams = new URLSearchParams(window.location.search);
            const blNumber = urlParams.get('bl_number');

            if (blNumber) {
                // Fill the input field
                const blInput = document.getElementById('blNumber');
                if (blInput) {
                    blInput.value = blNumber.toUpperCase();

                    // Show auto-search notification
                    showMessage('info', `Auto-searching for BL: ${blNumber}`);

                    // Auto-trigger search after a short delay
                    setTimeout(() => {
                        searchTracking();
                        // Clean URL after search to remove parameter
                        const newUrl = window.location.protocol + "//" + window.location.host + window.location.pathname;
                        window.history.replaceState({}, document.title, newUrl);
                    }, 1000);
                }
            }
        }

        // Enhanced notification function
        function showNotification(message, type = 'info') {
            const colors = {
                success: 'from-green-500 to-emerald-600',
                error: 'from-red-500 to-rose-600',
                info: 'from-blue-500 to-indigo-600',
                warning: 'from-yellow-500 to-orange-600'
            };

            const notification = document.createElement('div');
            notification.className = `fixed top-6 right-6 z-50 p-4 rounded-xl text-white font-semibold shadow-2xl transform translate-x-full transition-transform duration-300 bg-gradient-to-r ${colors[type]}`;
            notification.innerHTML = `
                <div class="flex items-center space-x-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>${message}</span>
                </div>
            `;

            document.body.appendChild(notification);

            setTimeout(() => {
                notification.classList.remove('translate-x-full');
            }, 100);

            setTimeout(() => {
                notification.classList.add('translate-x-full');
                setTimeout(() => {
                    if (document.body.contains(notification)) {
                        document.body.removeChild(notification);
                    }
                }, 300);
            }, 4000);
        }
    </script>
</body>

</html>