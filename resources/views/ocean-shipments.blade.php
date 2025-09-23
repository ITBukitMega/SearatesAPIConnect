<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ocean Shipments | BM Logistics</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
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

        /* Table hover effects */
        .table-row {
            transition: all 0.2s ease;
        }

        .table-row:hover {
            background-color: rgba(99, 102, 241, 0.02);
            transform: translateY(-1px);
        }

        /* Clickable booking number styling */
        .booking-link {
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .booking-link:hover {
            color: #4f46e5;
            font-weight: 600;
            text-decoration: underline;
            text-decoration-color: #4f46e5;
        }

        /* Search input styling */
        .search-input {
            transition: all 0.3s ease;
        }

        .search-input:focus {
            transform: scale(1.02);
            box-shadow: 0 10px 25px rgba(99, 102, 241, 0.1);
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
        <header class="pt-8 pb-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center space-y-6">
                    <!-- Brand -->
                    <div class="inline-flex items-center space-x-3 bg-white/80 backdrop-blur-sm rounded-full px-6 py-3 border border-gray-200 shadow-lg">
                        <div class="w-8 h-8 bg-gradient-to-r from-purple-600 to-pink-600 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                        <span class="text-gray-700 font-semibold">Ocean Shipments</span>
                    </div>

                    <!-- Title -->
                    <h1 class="text-4xl sm:text-5xl font-bold text-gray-900 tracking-tight">
                        Ocean Shipments Management
                    </h1>

                    <p class="max-w-2xl mx-auto text-lg text-gray-600">
                        View and manage all your ocean shipments in one place
                    </p>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-20">

            <!-- Search Section -->
            <!-- <div class="mb-8">
                <div class="bg-white rounded-3xl border border-gray-200 shadow-xl p-8">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">Search Shipments</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Booking Number</label>
                            <input type="text" id="searchBooking" placeholder="Enter booking number" 
                                   class="search-input w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Shipper</label>
                            <input type="text" id="searchShipper" placeholder="Enter shipper name" 
                                   class="search-input w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Consignee</label>
                            <input type="text" id="searchConsignee" placeholder="Enter consignee name" 
                                   class="search-input w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Ocean Line</label>
                            <input type="text" id="searchOceanLine" placeholder="Enter ocean line" 
                                   class="search-input w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">MBL Number</label>
                            <input type="text" id="searchMBL" placeholder="Enter MBL number" 
                                   class="search-input w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">HBL Number</label>
                            <input type="text" id="searchHBL" placeholder="Enter HBL number" 
                                   class="search-input w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        </div>
                    </div>

                    <div class="flex justify-between items-center mt-6">
                        <div class="flex space-x-3">
                            <button onclick="searchShipments()" 
                                    class="px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white font-semibold rounded-xl transition-all duration-200 transform hover:scale-105 flex items-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                <span>Search</span>
                            </button>
                            <button onclick="resetSearch()" 
                                    class="px-6 py-3 bg-gray-500 hover:bg-gray-600 text-white font-semibold rounded-xl transition-all duration-200 transform hover:scale-105 flex items-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                                <span>Reset</span>
                            </button>
                        </div>
                        <div id="searchCounter" class="text-sm text-gray-600 font-medium">
                            Total: <span id="totalCount">{{ $oceanShipments->count() ?? 0 }}</span> shipments
                        </div>
                    </div>
                </div>
            </div> -->

            <!-- Loading State -->
            <div id="loading" class="hidden mb-8 animate-fade-in">
                <div class="bg-white rounded-3xl border border-gray-200 p-12 text-center shadow-xl">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-purple-500 to-pink-600 rounded-full mb-6 animate-bounce-gentle">
                        <svg class="w-8 h-8 text-white animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Searching Shipments...</h3>
                    <p class="text-gray-600">Please wait while we search through your shipments</p>
                </div>
            </div>

            <!-- Shipments Table -->
            <div class="bg-white rounded-3xl border border-gray-200 shadow-xl overflow-hidden">
                <div class="px-8 py-6 border-b border-gray-200 bg-gradient-to-r from-purple-600 to-pink-600">
                    <h3 class="text-2xl font-bold text-white flex items-center space-x-3">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <span>Ocean Shipments</span>
                    </h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Booking Number</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Ocean Line</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">MBL/HBL</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Shipper</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Shipment Reference</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Consignee</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ETD/ETA</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody id="shipmentsTableBody" class="bg-white divide-y divide-gray-200">
                            @if(isset($oceanShipments) && $oceanShipments->count() > 0)
                                @foreach($oceanShipments as $shipment)
                                <tr class="table-row">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="booking-link text-purple-600 font-bold text-lg" 
                                              onclick="goToTracking('{{ $shipment->booking_number }}')">
                                            {{ $shipment->booking_number ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $shipment->ocean_line ?? 'N/A' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            <div>MBL: {{ $shipment->mbl_number ?? 'N/A' }}</div>
                                            <div class="text-gray-500">HBL: {{ $shipment->hbl_number ?? 'N/A' }}</div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900 max-w-xs truncate" title="{{ $shipment->shipper ?? 'N/A' }}">
                                            {{ $shipment->shipper ?? 'N/A' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900 max-w-xs truncate" title="{{ $shipment->shipment_reference ?? 'N/A' }}">
                                            {{ $shipment->shipment_reference ?? 'N/A' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900 max-w-xs truncate" title="{{ $shipment->consignee ?? 'N/A' }}">
                                            {{ $shipment->consignee ?? 'N/A' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            <div>ETD: {{ $shipment->promised_etd ? \Carbon\Carbon::parse($shipment->promised_etd)->format('d M Y') : 'N/A' }}</div>
                                            <div class="text-gray-500">ETA: {{ $shipment->promised_eta ? \Carbon\Carbon::parse($shipment->promised_eta)->format('d M Y') : 'N/A' }}</div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Active
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center">
                                        <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                                            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                            </svg>
                                        </div>
                                        <h3 class="text-xl font-semibold text-gray-900 mb-2">No Ocean Shipments Found</h3>
                                        <p class="text-gray-500">No shipments are available at the moment.</p>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- No Results Message -->
            <div id="noResults" class="hidden bg-white rounded-3xl border border-gray-200 shadow-xl p-12 text-center">
                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">No Results Found</h3>
                <p class="text-gray-500">No shipments match your search criteria. Try adjusting your search terms.</p>
            </div>

        </main>
    </div>

    <script>
        let allShipments = @json($oceanShipments ?? []);

        // Format date function
        function formatDate(dateString) {
            if (!dateString) return 'N/A';
            try {
                const date = new Date(dateString);
                return date.toLocaleDateString('en-US', {
                    day: '2-digit',
                    month: 'short',
                    year: 'numeric'
                });
            } catch (error) {
                return 'N/A';
            }
        }

        // Go to tracking page with booking number
        function goToTracking(bookingNumber) {
            if (!bookingNumber) return;
            
            // Show loading notification
            showNotification(`Redirecting to tracking for ${bookingNumber}...`, 'info');
            
            // Redirect to dashboard-db with booking number parameter
            window.location.href = `{{ route('dashboard-db') }}?bl_number=${encodeURIComponent(bookingNumber)}`;
        }

        // Show loading
        function showLoading() {
            document.getElementById('loading').classList.remove('hidden');
        }

        // Hide loading
        function hideLoading() {
            document.getElementById('loading').classList.add('hidden');
        }

        // Update table with shipments data
        function updateTable(shipments) {
            const tbody = document.getElementById('shipmentsTableBody');
            const noResults = document.getElementById('noResults');
            const totalCount = document.getElementById('totalCount');
            
            totalCount.textContent = shipments.length;
            
            if (shipments.length === 0) {
                tbody.innerHTML = '';
                noResults.classList.remove('hidden');
                return;
            }
            
            noResults.classList.add('hidden');
            
            let html = '';
            shipments.forEach(shipment => {
                const etd = formatDate(shipment.promised_etd);
                const eta = formatDate(shipment.promised_eta);
                
                html += `
                    <tr class="table-row">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="booking-link text-purple-600 font-bold text-lg" 
                                  onclick="goToTracking('${shipment.booking_number || ''}')">
                                ${shipment.booking_number || 'N/A'}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">${shipment.ocean_line || 'N/A'}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                <div>MBL: ${shipment.mbl_number || 'N/A'}</div>
                                <div class="text-gray-500">HBL: ${shipment.hbl_number || 'N/A'}</div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900 max-w-xs truncate" title="${shipment.shipper || 'N/A'}">
                                ${shipment.shipper || 'N/A'}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900 max-w-xs truncate" title="${shipment.shipment_reference || 'N/A'}">
                                ${shipment.shipment_reference || 'N/A'}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900 max-w-xs truncate" title="${shipment.consignee || 'N/A'}">
                                ${shipment.consignee || 'N/A'}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                <div>ETD: ${etd}</div>
                                <div class="text-gray-500">ETA: ${eta}</div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Active
                            </span>
                        </td>
                    </tr>
                `;
            });
            
            tbody.innerHTML = html;
        }

        // Search shipments
        async function searchShipments() {
            const searchData = {
                booking_number: document.getElementById('searchBooking').value.trim(),
                shipper: document.getElementById('searchShipper').value.trim(),
                consignee: document.getElementById('searchConsignee').value.trim(),
                ocean_line: document.getElementById('searchOceanLine').value.trim(),
                mbl_number: document.getElementById('searchMBL').value.trim(),
                hbl_number: document.getElementById('searchHBL').value.trim()
            };

            // If all fields are empty, show all shipments
            if (Object.values(searchData).every(value => value === '')) {
                updateTable(allShipments);
                return;
            }

            showLoading();

            try {
                const response = await fetch('{{ route("ocean-shipments.search") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(searchData)
                });

                const result = await response.json();

                if (response.ok && result.status === 'success') {
                    updateTable(result.data);
                    showNotification(`Found ${result.count} shipment(s)`, 'success');
                } else {
                    showNotification('Search failed. Please try again.', 'error');
                    updateTable([]);
                }
            } catch (error) {
                console.error('Search error:', error);
                showNotification('Network error occurred. Please try again.', 'error');
                updateTable([]);
            } finally {
                hideLoading();
            }
        }

        // Reset search
        function resetSearch() {
            document.getElementById('searchBooking').value = '';
            document.getElementById('searchShipper').value = '';
            document.getElementById('searchConsignee').value = '';
            document.getElementById('searchOceanLine').value = '';
            document.getElementById('searchMBL').value = '';
            document.getElementById('searchHBL').value = '';
            
            updateTable(allShipments);
            showNotification('Search reset successfully', 'info');
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

        // Event listeners for search
        document.addEventListener('DOMContentLoaded', function() {
            // Add enter key search functionality to all search inputs
            const searchInputs = [
                'searchBooking', 'searchShipper', 'searchConsignee', 
                'searchOceanLine', 'searchMBL', 'searchHBL'
            ];
            
            searchInputs.forEach(inputId => {
                const input = document.getElementById(inputId);
                if (input) {
                    input.addEventListener('keypress', function(e) {
                        if (e.key === 'Enter') {
                            e.preventDefault();
                            searchShipments();
                        }
                    });
                }
            });
        });
    </script>
</body>

</html>