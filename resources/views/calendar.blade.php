<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendar | BM Logistics</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- FullCalendar CSS -->
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css' rel='stylesheet' />
    <!-- FullCalendar JS -->
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Animation Library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    
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
                        'pulse-slow': 'pulse 3s infinite',
                        'bounce-slow': 'bounce 2s infinite',
                        'float': 'float 3s ease-in-out infinite',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0', transform: 'translateY(10px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' }
                        },
                        slideUp: {
                            '0%': { transform: 'translateY(100%)' },
                            '100%': { transform: 'translateY(0)' }
                        },
                        float: {
                            '0%, 100%': { transform: 'translateY(0px)' },
                            '50%': { transform: 'translateY(-10px)' }
                        }
                    }
                }
            }
        }
    </script>
    
    <style>
        /* BM Calendar Styling with Glassmorphism */
        .fc {
            font-family: Inter, system-ui, sans-serif;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 2rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
        }
        
        .fc-toolbar {
            background: linear-gradient(135deg, 
                rgba(99, 102, 241, 0.9) 0%, 
                rgba(168, 85, 247, 0.9) 50%, 
                rgba(236, 72, 153, 0.9) 100%);
            padding: 2rem;
            border-radius: 2rem 2rem 0 0;
            margin-bottom: 0 !important;
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .fc-toolbar-title {
            font-size: 2.25rem !important;
            font-weight: 900 !important;
            color: white !important;
            text-shadow: 0 4px 8px rgba(0,0,0,0.3);
            letter-spacing: -0.025em;
        }
        
        .fc-button {
            background: rgba(255, 255, 255, 0.15) !important;
            border: 2px solid rgba(255, 255, 255, 0.2) !important;
            font-weight: 700 !important;
            border-radius: 1rem !important;
            padding: 0.75rem 1.5rem !important;
            margin: 0 0.5rem !important;
            transition: all 0.4s ease !important;
            backdrop-filter: blur(10px) !important;
            font-size: 0.875rem !important;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        
        .fc-button:hover {
            background: rgba(255, 255, 255, 0.25) !important;
            border-color: rgba(255, 255, 255, 0.4) !important;
            transform: translateY(-3px) scale(1.05) !important;
            box-shadow: 0 8px 25px rgba(0,0,0,0.25) !important;
        }
        
        .fc-button:disabled {
            background: rgba(255, 255, 255, 0.08) !important;
            border-color: rgba(255, 255, 255, 0.08) !important;
            opacity: 0.4 !important;
        }
        
        .fc-button-active {
            background: rgba(255, 255, 255, 0.3) !important;
            border-color: rgba(255, 255, 255, 0.5) !important;
            box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.1) !important;
        }
        
        .fc-daygrid-day-number {
            color: #1f2937 !important;
            font-weight: 700 !important;
            font-size: 0.875rem !important;
            padding: 0.75rem !important;
            transition: all 0.3s ease !important;
        }
        
        .fc-col-header-cell {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%) !important;
            font-weight: 800 !important;
            color: #475569 !important;
            text-transform: uppercase !important;
            font-size: 0.75rem !important;
            letter-spacing: 0.1em !important;
            padding: 1.25rem 0.75rem !important;
            border-bottom: 3px solid #e2e8f0 !important;
            position: relative;
        }
        
        .fc-col-header-cell::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 30%;
            height: 3px;
            background: linear-gradient(90deg, #6366f1, #a855f7);
            border-radius: 3px;
        }
        
        .fc-daygrid-day {
            border: 1px solid rgba(241, 245, 249, 0.8) !important;
            transition: all 0.3s ease !important;
            position: relative;
        }
        
        .fc-daygrid-day:hover {
            background: linear-gradient(135deg, #fefbff 0%, #faf5ff 100%) !important;
            border-color: rgba(168, 85, 247, 0.2) !important;
            transform: scale(1.02);
        }
        
        .fc-day-today {
            background: linear-gradient(135deg, 
                rgba(79, 70, 229, 0.08) 0%, 
                rgba(168, 85, 247, 0.08) 100%) !important;
            border: 2px solid rgba(79, 70, 229, 0.3) !important;
            position: relative;
        }
        
        .fc-day-today::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, 
                rgba(79, 70, 229, 0.05), 
                rgba(168, 85, 247, 0.05));
            border-radius: inherit;
            animation: pulse 2s infinite;
        }
        
        .fc-day-today .fc-daygrid-day-number {
            background: linear-gradient(135deg, #4f46e5, #a855f7) !important;
            color: white !important;
            border-radius: 50% !important;
            width: 2.5rem !important;
            height: 2.5rem !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            margin: 0.5rem !important;
            font-weight: 900 !important;
            box-shadow: 0 4px 15px rgba(79, 70, 229, 0.4);
            position: relative;
            z-index: 10;
        }
        
        /* Modern Event Styling with Gradients */
        .fc-event {
            border: none !important;
            border-radius: 0.875rem !important;
            font-weight: 700 !important;
            font-size: 0.75rem !important;
            padding: 0.5rem 0.75rem !important;
            margin: 0.25rem !important;
            cursor: pointer !important;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1) !important;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1) !important;
            position: relative !important;
            overflow: hidden !important;
            text-transform: uppercase;
            letter-spacing: 0.025em;
        }
        
        .fc-event::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, 
                transparent, 
                rgba(255, 255, 255, 0.3), 
                transparent);
            transition: left 0.5s ease;
        }
        
        .fc-event:hover::before {
            left: 100%;
        }
        
        .fc-event:hover {
            transform: translateY(-2px) scale(1.05) !important;
            box-shadow: 0 8px 30px rgba(0,0,0,0.2) !important;
            z-index: 1000 !important;
        }
        
        .departure-event {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 50%, #b91c1c 100%) !important;
        }
        
        .arrival-event {
            background: linear-gradient(135deg, #10b981 0%, #059669 50%, #047857 100%) !important;
        }
        
        /* Loading Animation with Modern Design */
        .loading-spinner {
            width: 50px;
            height: 50px;
            border: 4px solid rgba(99, 102, 241, 0.1);
            border-top: 4px solid #6366f1;
            border-radius: 50%;
            animation: spin 1.2s cubic-bezier(0.4, 0, 0.2, 1) infinite;
            position: relative;
        }
        
        .loading-spinner::after {
            content: '';
            position: absolute;
            top: 2px;
            left: 2px;
            right: 2px;
            bottom: 2px;
            border: 3px solid transparent;
            border-top: 3px solid #a855f7;
            border-radius: 50%;
            animation: spin 0.8s cubic-bezier(0.4, 0, 0.2, 1) infinite reverse;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        /* Modern Filter Buttons */
        .filter-btn {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 1rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            position: relative;
            overflow: hidden;
            backdrop-filter: blur(10px);
        }
        
        .filter-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, 
                transparent, 
                rgba(255, 255, 255, 0.2), 
                transparent);
            transition: left 0.5s ease;
        }
        
        .filter-btn:hover::before {
            left: 100%;
        }
        
        .filter-btn.active {
            background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
            color: white;
            box-shadow: 0 8px 25px rgba(99, 102, 241, 0.4);
            transform: translateY(-2px);
        }
        
        .filter-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        }
        
        /* Floating Action Button */
        .fab {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            width: 4rem;
            height: 4rem;
            background: linear-gradient(135deg, #6366f1, #a855f7);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 25px rgba(99, 102, 241, 0.4);
            transition: all 0.3s ease;
            z-index: 1000;
            animation: float 3s ease-in-out infinite;
        }
        
        .fab:hover {
            transform: scale(1.1);
            box-shadow: 0 12px 35px rgba(99, 102, 241, 0.6);
        }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: rgba(0,0,0,0.05);
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #6366f1, #a855f7);
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #4f46e5, #9333ea);
        }
        
        /* Advanced Background Effects */
        .bg-pattern {
            background-image: 
                radial-gradient(circle at 25% 25%, rgba(99, 102, 241, 0.05) 0%, transparent 50%),
                radial-gradient(circle at 75% 75%, rgba(168, 85, 247, 0.05) 0%, transparent 50%),
                radial-gradient(circle at 50% 50%, rgba(236, 72, 153, 0.05) 0%, transparent 50%);
        }
        
        /* Pulse Effect for Important Elements */
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
</head>

<body class="h-full bg-pattern font-sans">
    <!-- Floating particles background -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute w-2 h-2 bg-blue-400 rounded-full opacity-20 animate-float" style="top: 20%; left: 10%; animation-delay: 0s;"></div>
        <div class="absolute w-3 h-3 bg-purple-400 rounded-full opacity-20 animate-float" style="top: 60%; left: 80%; animation-delay: 1s;"></div>
        <div class="absolute w-1 h-1 bg-pink-400 rounded-full opacity-30 animate-float" style="top: 80%; left: 20%; animation-delay: 2s;"></div>
        <div class="absolute w-2 h-2 bg-indigo-400 rounded-full opacity-25 animate-float" style="top: 40%; left: 90%; animation-delay: 3s;"></div>
    </div>

    <!-- Include Sidebar Component -->
    @include('components.sidebar')

    <!-- Main Content -->
    <div class="lg:pl-64 min-h-screen">
        <!-- Spacer for user greeting -->
        <div class="h-20"></div>
        
        <!-- Header -->
        <header class="pt-12 pb-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center space-y-12 animate-fade-in">
                    <!-- Brand Badge -->
                    <div class="inline-flex items-center space-x-4 bg-white/80 backdrop-blur-xl rounded-full px-8 py-4 border border-white/30 shadow-2xl">
                        <div class="w-10 h-10 bg-gradient-to-r from-blue-600 to-purple-600 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <span class="text-gray-700 font-bold text-lg">BM Calendar</span>
                    </div>

                    <!-- Main Title -->
                    <div class="space-y-6">
                        <h1 class="text-5xl sm:text-6xl font-black text-gray-900 tracking-tight leading-tight">
                            Shipment <span class="bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 bg-clip-text text-transparent">Calendar</span>
                        </h1>
                        <p class="max-w-3xl mx-auto text-xl text-gray-600 leading-relaxed">
                            Advanced scheduling system for tracking shipment arrivals, departures, and logistics operations with real-time updates
                        </p>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-24">
            <!-- Advanced Control Panel -->
            <div class="bg-white/85 backdrop-blur-xl rounded-3xl border border-white/20 shadow-2xl p-8 mb-12">
                <div class="flex flex-col space-y-6">
                    <!-- Control Header -->
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                        <div class="space-y-2">
                            <h3 class="text-2xl font-black text-gray-900">Control Panel</h3>
                            <p class="text-gray-600 font-medium">Filter and manage your calendar view</p>
                        </div>
                        
                        <!-- Filter Controls -->
                        <div class="flex flex-wrap gap-4">
                            <button onclick="filterEvents('all')" class="filter-btn active px-6 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 border-2 border-transparent" id="filter-all">
                                <span class="flex items-center space-x-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                                    </svg>
                                    <span>All Events</span>
                                </span>
                            </button>
                            <button onclick="filterEvents('departures')" class="filter-btn px-6 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 border-2 border-transparent" id="filter-departures">
                                <span class="flex items-center space-x-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                    </svg>
                                    <span>Departures</span>
                                </span>
                            </button>
                            <button onclick="filterEvents('arrivals')" class="filter-btn px-6 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 border-2 border-transparent" id="filter-arrivals">
                                <span class="flex items-center space-x-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8l-4 4m0 0l4 4m0-4h18"/>
                                    </svg>
                                    <span>Arrivals</span>
                                </span>
                            </button>
                            <button onclick="refreshCalendar()" class="px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-xl hover:from-blue-700 hover:to-purple-700 transition-all duration-300 border-2 border-transparent font-bold">
                                <span class="flex items-center space-x-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                    </svg>
                                    <span>Refresh</span>
                                </span>
                            </button>
                        </div>
                    </div>

                    <!-- Month/Year Navigation -->
                    <div class="border-t border-gray-200 pt-6">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                            <div class="space-y-2">
                                <h4 class="text-lg font-bold text-gray-900">Quick Navigation</h4>
                                <p class="text-sm text-gray-600">Jump to specific month and year</p>
                            </div>
                            
                            <div class="flex flex-wrap items-center gap-3">
                                <!-- Month Selector -->
                                <div class="relative">
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Month</label>
                                    <select id="monthSelector" class="appearance-none bg-white/80 backdrop-blur-sm border-2 border-gray-200 rounded-xl px-4 py-3 pr-10 text-gray-700 font-semibold focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-300">
                                        <option value="0">January</option>
                                        <option value="1">February</option>
                                        <option value="2">March</option>
                                        <option value="3">April</option>
                                        <option value="4">May</option>
                                        <option value="5">June</option>
                                        <option value="6">July</option>
                                        <option value="7">August</option>
                                        <option value="8">September</option>
                                        <option value="9">October</option>
                                        <option value="10">November</option>
                                        <option value="11">December</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none mt-6">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </div>
                                </div>

                                <!-- Year Selector -->
                                <div class="relative">
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Year</label>
                                    <select id="yearSelector" class="appearance-none bg-white/80 backdrop-blur-sm border-2 border-gray-200 rounded-xl px-4 py-3 pr-10 text-gray-700 font-semibold focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-300">
                                        <!-- Years will be populated by JavaScript -->
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none mt-6">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </div>
                                </div>

                                <!-- Go Button -->
                                <div class="flex flex-col">
                                    <div class="h-6"></div> <!-- Spacer for alignment -->
                                    <button onclick="navigateToMonthYear()" class="px-6 py-3 bg-gradient-to-r from-emerald-600 to-teal-600 text-white rounded-xl hover:from-emerald-700 hover:to-teal-700 transition-all duration-300 font-bold shadow-lg hover:shadow-xl transform hover:scale-105">
                                        <span class="flex items-center space-x-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                            </svg>
                                            <span>Go</span>
                                        </span>
                                    </button>
                                </div>

                                <!-- Quick Jump Buttons -->
                                <div class="flex flex-col">
                                    <div class="h-6"></div> <!-- Spacer for alignment -->
                                    <button onclick="goToToday()" class="px-6 py-3 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 transition-all duration-300 font-bold shadow-lg hover:shadow-xl transform hover:scale-105">
                                        <span class="flex items-center space-x-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                                            </svg>
                                            <span>Today</span>
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Premium Calendar Container -->
            <div class="bg-white/95 backdrop-blur-xl rounded-3xl border border-white/30 shadow-2xl overflow-hidden">
                <!-- Loading State with Advanced Animation -->
                <div id="calendarLoading" class="hidden p-16 text-center">
                    <div class="space-y-6">
                        <div class="loading-spinner mx-auto"></div>
                        <div class="space-y-2">
                            <p class="text-xl font-bold text-gray-700">Loading Calendar Data</p>
                            <p class="text-gray-500">Please wait while we fetch your shipment information...</p>
                        </div>
                    </div>
                </div>
                
                <!-- Calendar Container -->
                <div id='calendar' class="animate-fade-in"></div>
            </div>
        </main>
    </div>

    <!-- Floating Action Button -->
    <button onclick="refreshCalendar()" class="fab">
        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
        </svg>
    </button>

    <script>
        // Global variables
        let calendar;
        let currentFilter = 'all';
        let allEvents = [];

        // Month/Year Navigation Functions
        function initializeMonthYearSelectors() {
            const currentDate = new Date();
            const monthSelector = document.getElementById('monthSelector');
            const yearSelector = document.getElementById('yearSelector');
            
            // Populate years (current year ± 5 years)
            const currentYear = currentDate.getFullYear();
            for (let year = currentYear - 5; year <= currentYear + 5; year++) {
                const option = document.createElement('option');
                option.value = year;
                option.textContent = year;
                if (year === currentYear) {
                    option.selected = true;
                }
                yearSelector.appendChild(option);
            }
            
            // Set current month
            monthSelector.value = currentDate.getMonth();
            
            // Update selectors when calendar changes
            updateSelectorFromCalendar();
        }

        function updateSelectorFromCalendar() {
            if (!calendar) return;
            
            const currentDate = calendar.getDate();
            const monthSelector = document.getElementById('monthSelector');
            const yearSelector = document.getElementById('yearSelector');
            
            if (monthSelector && yearSelector) {
                monthSelector.value = currentDate.getMonth();
                yearSelector.value = currentDate.getFullYear();
            }
        }

        function navigateToMonthYear() {
            const monthSelector = document.getElementById('monthSelector');
            const yearSelector = document.getElementById('yearSelector');
            
            const selectedMonth = parseInt(monthSelector.value);
            const selectedYear = parseInt(yearSelector.value);
            
            // Create date for first day of selected month
            const targetDate = new Date(selectedYear, selectedMonth, 1);
            
            // Navigate calendar
            calendar.gotoDate(targetDate);
            
            // Show notification
            const monthName = new Date(selectedYear, selectedMonth, 1).toLocaleDateString('en-US', { month: 'long' });
            showNotification(`Navigated to ${monthName} ${selectedYear}`, 'info');
            
            // Add visual feedback
            const goButton = event.target.closest('button');
            goButton.style.transform = 'scale(0.95)';
            setTimeout(() => {
                goButton.style.transform = 'scale(1)';
            }, 150);
        }

        function goToToday() {
            calendar.today();
            updateSelectorFromCalendar();
            showNotification('Jumped to today!', 'info');
        }
        
        function filterEvents(type) {
            currentFilter = type;
            
            // Update button states with smooth transitions
            document.querySelectorAll('.filter-btn').forEach(btn => {
                btn.classList.remove('active');
                btn.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    btn.style.transform = 'scale(1)';
                }, 100);
            });
            
            const activeBtn = document.getElementById('filter-' + type);
            activeBtn.classList.add('active');
            activeBtn.style.transform = 'scale(1.05)';
            setTimeout(() => {
                activeBtn.style.transform = 'scale(1)';
            }, 200);
            
            // Filter and display events with loading effect
            showMiniLoading(true);
            setTimeout(() => {
                let filteredEvents = allEvents;
                if (type === 'departures') {
                    filteredEvents = allEvents.filter(event => event.extendedProps.type === 'departure');
                } else if (type === 'arrivals') {
                    filteredEvents = allEvents.filter(event => event.extendedProps.type === 'arrival');
                }
                
                calendar.removeAllEvents();
                calendar.addEventSource(filteredEvents);
                showMiniLoading(false);
            }, 300);
        }

        // Enhanced refresh with better UX
        function refreshCalendar() {
            showLoading(true);
            
            // Add visual feedback
            const fab = document.querySelector('.fab');
            fab.style.transform = 'scale(0.9) rotate(360deg)';
            setTimeout(() => {
                fab.style.transform = 'scale(1) rotate(0deg)';
            }, 600);
            
            calendar.refetchEvents();
            
            // Show success notification
            setTimeout(() => {
                showNotification('Calendar refreshed successfully!', 'success');
            }, 800);
        }

        // Mini loading for filter operations
        function showMiniLoading(show) {
            const calendarEl = document.getElementById('calendar');
            if (show) {
                calendarEl.style.opacity = '0.6';
                calendarEl.style.filter = 'blur(1px)';
            } else {
                calendarEl.style.opacity = '1';
                calendarEl.style.filter = 'blur(0px)';
            }
        }

        // Enhanced loading with better animations
        function showLoading(show) {
            const loadingEl = document.getElementById('calendarLoading');
            const calendarEl = document.getElementById('calendar');
            
            if (show) {
                loadingEl.classList.remove('hidden');
                loadingEl.classList.add('animate-fade-in');
                calendarEl.style.opacity = '0.3';
                calendarEl.style.filter = 'blur(2px)';
            } else {
                setTimeout(() => {
                    loadingEl.classList.add('hidden');
                    loadingEl.classList.remove('animate-fade-in');
                    calendarEl.style.opacity = '1';
                    calendarEl.style.filter = 'blur(0px)';
                }, 500);
            }
        }

        // Enhanced event details function with clickable BL Numbers
function showEventDetails(event) {
    const eventType = event.extendedProps.type;
    const eventDate = event.start;
    const blNumbers = event.extendedProps.bl_numbers;
    const count = event.extendedProps.count;
    
    const iconColor = eventType === 'departure' ? '#ef4444' : '#10b981';
    const bgGradient = eventType === 'departure' 
        ? 'linear-gradient(135deg, #fef2f2, #fee2e2)' 
        : 'linear-gradient(135deg, #f0fdf4, #dcfce7)';
    
    // Split BL numbers and create clickable list
    const blNumbersList = blNumbers.split(', ').map(bl => {
        const trimmedBl = bl.trim();
        return `<div style="padding: 0.75rem; margin: 0.5rem 0; background: ${eventType === 'departure' ? '#fef2f2' : '#f0fdf4'}; border-radius: 0.5rem; font-family: monospace; font-size: 0.875rem; font-weight: 600; color: #374151; border-left: 4px solid ${iconColor}; cursor: pointer; transition: all 0.3s ease; position: relative;" 
                    class="bl-number-item" 
                    onclick="trackBlNumber('${trimmedBl}')"
                    onmouseover="this.style.transform='translateX(8px)'; this.style.boxShadow='0 4px 12px rgba(0,0,0,0.15)'"
                    onmouseout="this.style.transform='translateX(0)'; this.style.boxShadow='none'">
                <div style="display: flex; align-items: center; justify-content: between;">
                    <span style="flex: 1;">${trimmedBl}</span>
                    <svg style="width: 1rem; height: 1rem; color: ${iconColor}; margin-left: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-2M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                </div>
                <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent); transform: translateX(-100%); transition: transform 0.5s ease;" class="shine-effect"></div>
            </div>`;
    }).join('');
    
    Swal.fire({
        title: `<div style="background: ${bgGradient}; padding: 1rem; border-radius: 1rem; margin: -1rem -1rem 1rem -1rem;">
            <div style="display: flex; align-items: center; justify-content: center; gap: 0.75rem;">
                <div style="width: 3rem; height: 3rem; background: ${iconColor}; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                    <svg style="width: 1.5rem; height: 1.5rem; color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${eventType === 'departure' ? 'M17 8l4 4m0 0l-4 4m4-4H3' : 'M7 8l-4 4m0 0l4 4m0-4h18'}"/>
                    </svg>
                </div>
                <div>
                    <h3 style="font-size: 1.5rem; font-weight: 800; color: #1f2937; margin: 0;">${event.title}</h3>
                    <p style="color: #6b7280; margin: 0; font-weight: 600;">${eventType === 'departure' ? 'Departure' : 'Arrival'} Details</p>
                </div>
            </div>
        </div>`,
        html: `
            <div style="text-align: left; padding: 1rem;">
                <div style="display: grid; gap: 1.5rem;">
                    <div style="display: flex; align-items: center; gap: 1rem; padding: 1rem; background: #f8fafc; border-radius: 0.75rem;">
                        <div style="width: 2.5rem; height: 2.5rem; background: #3b82f6; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <svg style="width: 1.25rem; height: 1.25rem; color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <p style="font-weight: 700; color: #1f2937; margin: 0;">Schedule Date</p>
                            <p style="color: #6b7280; margin: 0;">${new Date(eventDate).toLocaleDateString('en-GB', { 
                                weekday: 'long', 
                                year: 'numeric',
                                month: 'long', 
                                day: 'numeric' 
                            })}</p>
                        </div>
                    </div>
                    
                    <div style="display: flex; align-items: center; gap: 1rem; padding: 1rem; background: #f8fafc; border-radius: 0.75rem;">
                        <div style="width: 2.5rem; height: 2.5rem; background: ${iconColor}; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <svg style="width: 1.25rem; height: 1.25rem; color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                        <div>
                            <p style="font-weight: 700; color: #1f2937; margin: 0;">Total Count</p>
                            <p style="color: #6b7280; margin: 0;">${count} shipment${count > 1 ? 's' : ''}</p>
                        </div>
                    </div>
                    
                    <div style="padding: 1rem; background: #f8fafc; border-radius: 0.75rem;">
                        <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
                            <div style="width: 2.5rem; height: 2.5rem; background: #8b5cf6; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                <svg style="width: 1.25rem; height: 1.25rem; color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <div>
                                <p style="font-weight: 700; color: #1f2937; margin: 0;">BL Numbers</p>
                                <p style="color: #6b7280; margin: 0; font-size: 0.875rem;">Click any BL Number to track container</p>
                            </div>
                        </div>
                        <div style="max-height: 300px; overflow-y: auto; background: white; border-radius: 0.5rem; padding: 1rem; border: 1px solid #e5e7eb;">
                            ${blNumbersList}
                        </div>
                        <div style="margin-top: 1rem; padding: 0.75rem; background: #fffbeb; border: 1px solid #f59e0b; border-radius: 0.5rem; display: flex; align-items: center; gap: 0.5rem;">
                            <svg style="width: 1.25rem; height: 1.25rem; color: #f59e0b;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span style="color: #92400e; font-size: 0.875rem; font-weight: 600;">Click any BL Number above to open container tracking</span>
                        </div>
                    </div>
                </div>
            </div>
        `,
        showConfirmButton: true,
        confirmButtonText: 'Close',
        confirmButtonColor: iconColor,
        width: '700px',
        padding: '0',
        background: 'rgba(255, 255, 255, 0.98)',
        backdrop: 'rgba(0, 0, 0, 0.4)',
        showClass: {
            popup: 'animate__animated animate__zoomIn animate__faster'
        },
        hideClass: {
            popup: 'animate__animated animate__zoomOut animate__faster'
        },
        customClass: {
            popup: 'rounded-2xl shadow-2xl border border-white/20',
            confirmButton: 'rounded-xl font-bold px-8 py-3 text-lg'
        },
        didOpen: () => {
            // Add hover effects to BL number items
            const blItems = document.querySelectorAll('.bl-number-item');
            blItems.forEach(item => {
                item.addEventListener('mouseenter', function() {
                    const shineEffect = this.querySelector('.shine-effect');
                    if (shineEffect) {
                        shineEffect.style.transform = 'translateX(100%)';
                    }
                });
                
                item.addEventListener('mouseleave', function() {
                    const shineEffect = this.querySelector('.shine-effect');
                    if (shineEffect) {
                        setTimeout(() => {
                            shineEffect.style.transform = 'translateX(-100%)';
                        }, 500);
                    }
                });
            });
        }
    });
}

// Function to handle BL Number tracking
function trackBlNumber(blNumber) {
    // Show loading state
    Swal.fire({
        title: 'Redirecting...',
        html: `Opening container tracking for <strong>${blNumber}</strong>`,
        allowOutsideClick: false,
        allowEscapeKey: false,
        showConfirmButton: false,
        background: 'rgba(255, 255, 255, 0.98)',
        customClass: {
            popup: 'rounded-2xl shadow-2xl border border-white/20'
        },
        didOpen: () => {
            Swal.showLoading();
        }
    });

    // Create URL with BL number parameter
    const dashboardUrl = `${window.location.origin}/dashboard-db?bl_number=${encodeURIComponent(blNumber)}`;
    
    // Small delay for better UX
    setTimeout(() => {
        window.location.href = dashboardUrl;
    }, 800);
}

// Function to check for BL number in URL and auto-search
function checkForAutoSearch() {
    const urlParams = new URLSearchParams(window.location.search);
    const blNumber = urlParams.get('bl_number');
    
    if (blNumber) {
        // Fill the input field
        const blInput = document.getElementById('blNumber');
        if (blInput) {
            blInput.value = blNumber;
            
            // Show auto-search notification
            showNotification(`Auto-searching for BL: ${blNumber}`, 'info');
            
            // Auto-trigger search after a short delay
            setTimeout(() => {
                searchTracking();
                // Clean URL after search
                window.history.replaceState({}, document.title, window.location.pathname);
            }, 1000);
        }
    }
}

// Enhanced notification function (if not already exists)
function showNotification(message, type = 'info') {
    const colors = {
        success: 'from-green-500 to-emerald-600',
        error: 'from-red-500 to-rose-600',
        info: 'from-blue-500 to-indigo-600',
        warning: 'from-yellow-500 to-orange-600'
    };
    
    const notification = document.createElement('div');
    notification.className = `fixed top-6 right-6 z-50 p-4 rounded-xl text-white font-semibold shadow-2xl transform translate-x-full transition-transform duration-300 bg-gradient-to-r ${colors[type]}`;
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.classList.remove('translate-x-full');
    }, 100);
    
    setTimeout(() => {
        notification.classList.add('translate-x-full');
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 300);
    }, 4000);
}

// Add to dashboard-db page initialization
document.addEventListener('DOMContentLoaded', function() {
    // Existing initialization code...
    
    // Check for auto-search parameter
    checkForAutoSearch();
});

        // Add notification system
        function showNotification(message, type = 'info') {
            const colors = {
                success: 'from-green-500 to-emerald-600',
                error: 'from-red-500 to-rose-600',
                info: 'from-blue-500 to-indigo-600',
                warning: 'from-yellow-500 to-orange-600'
            };
            
            const notification = document.createElement('div');
            notification.className = `fixed top-6 right-6 z-50 p-4 rounded-xl text-white font-semibold shadow-2xl transform translate-x-full transition-transform duration-300 bg-gradient-to-r ${colors[type]}`;
            notification.textContent = message;
            
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.classList.remove('translate-x-full');
            }, 100);
            
            setTimeout(() => {
                notification.classList.add('translate-x-full');
                setTimeout(() => {
                    document.body.removeChild(notification);
                }, 300);
            }, 3000);
        }

        // Inisialisassi FullCalendar untuk jalanin semua events
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            
            calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                height: 'auto',
                firstDay: 1, // Start week on Monday
                headerToolbar: {
                    left: 'prev,next',
                    center: 'title',
                    right: ''
                },
                events: function(fetchInfo, successCallback, failureCallback) {
                    showLoading(true);
                    
                    // Fetch events dari server dengan parameter tanggal
                    fetch('{{ route("calendar.events") }}?' + new URLSearchParams({
                        start: fetchInfo.startStr,
                        end: fetchInfo.endStr
                    }), {
                        method: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        allEvents = data;
                        
                        // Apply current filter
                        let filteredEvents = data;
                        if (currentFilter === 'departures') {
                            filteredEvents = data.filter(event => event.extendedProps.type === 'departure');
                        } else if (currentFilter === 'arrivals') {
                            filteredEvents = data.filter(event => event.extendedProps.type === 'arrival');
                        }
                        
                        successCallback(filteredEvents);
                        showLoading(false);
                        showNotification('Calendar data loaded successfully!', 'success');
                    })
                    .catch(error => {
                        console.error('Error fetching events:', error);
                        showLoading(false);
                        showNotification('Failed to load calendar data', 'error');
                        
                        Swal.fire({
                            icon: 'error',
                            title: 'Connection Error',
                            text: 'Failed to load calendar events. Please check your connection and try again.',
                            confirmButtonColor: '#ef4444',
                            background: 'rgba(255, 255, 255, 0.98)',
                            backdrop: 'rgba(0, 0, 0, 0.4)',
                            customClass: {
                                popup: 'rounded-2xl shadow-2xl border border-white/20'
                            }
                        });
                        
                        failureCallback(error);
                    });
                },
                eventClick: function(info) {
                    info.jsEvent.preventDefault();
                    showEventDetails(info.event);
                },
                dateClick: function(info) {
                    // Add subtle date click feedback
                    const dayEl = info.dayEl;
                    dayEl.style.transform = 'scale(0.98)';
                    setTimeout(() => {
                        dayEl.style.transform = 'scale(1)';
                    }, 150);
                    
                    console.log('Clicked on: ' + info.dateStr);
                },
                eventDidMount: function(info) {
                    // Add enhanced tooltips and interactions
                    info.el.setAttribute('title', `${info.event.title} - Click for detailed information`);
                    
                    // Add hover effects
                    info.el.addEventListener('mouseenter', function() {
                        this.style.transform = 'translateY(-2px) scale(1.05)';
                        this.style.zIndex = '1000';
                    });
                    
                    info.el.addEventListener('mouseleave', function() {
                        this.style.transform = 'translateY(0) scale(1)';
                        this.style.zIndex = 'auto';
                    });
                },
                loading: function(isLoading) {
                    showLoading(isLoading);
                },
                eventDisplay: 'block',
                dayMaxEvents: 4, // Show max 4 events per day
                moreLinkClick: 'popover', // Show popover when "more" link is clicked
                eventOrder: function(a, b) {
                    // Order: departures first, then arrivals
                    if (a.extendedProps.type === 'departure' && b.extendedProps.type === 'arrival') {
                        return -1;
                    } else if (a.extendedProps.type === 'arrival' && b.extendedProps.type === 'departure') {
                        return 1;
                    }
                    return 0;
                },
                datesSet: function(dateInfo) {
                    // Update selectors when view changes (month/week navigation)
                    setTimeout(() => {
                        updateSelectorFromCalendar(); // Update month/year selectors
                    }, 100);
                },
                eventMouseEnter: function(info) {
                    // Add glow effect on hover
                    info.el.style.boxShadow = '0 8px 30px rgba(0,0,0,0.2)';
                },
                eventMouseLeave: function(info) {
                    // Remove glow effect
                    info.el.style.boxShadow = '0 4px 15px rgba(0,0,0,0.1)';
                }
            });
            
            calendar.render();
            
            // Initialize month/year selectors
            initializeMonthYearSelectors();
            
            // Initial load with delay for smooth loading
            setTimeout(() => {
                showNotification('Welcome to your Shipment Calendar!', 'info');
            }, 1000);
            
            // Auto-refresh every 5 minutes with notification
            setInterval(() => {
                console.log('Auto-refreshing calendar...');
                calendar.refetchEvents();
                showNotification('Calendar auto-refreshed', 'info');
            }, 300000); // 5 minutes
            
            // Add keyboard shortcuts
            document.addEventListener('keydown', function(e) {
                if (e.ctrlKey || e.metaKey) {
                    switch(e.key) {
                        case 'r':
                            e.preventDefault();
                            refreshCalendar();
                            break;
                        case '1':
                            e.preventDefault();
                            filterEvents('all');
                            break;
                        case '2':
                            e.preventDefault();
                            filterEvents('departures');
                            break;
                        case '3':
                            e.preventDefault();
                            filterEvents('arrivals');
                            break;
                    }
                }
            });
        });

        // Add smooth scroll behavior
        document.documentElement.style.scrollBehavior = 'smooth';

        // Add intersection observer for animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-fade-in');
                }
            });
        }, observerOptions);

        // Add performance monitoring
        window.addEventListener('load', function() {
            const loadTime = performance.now();
            console.log(`Calendar loaded in ${Math.round(loadTime)}ms`);
            
            if (loadTime > 3000) {
                showNotification('Slow connection detected. Consider refreshing if issues persist.', 'warning');
            }
        });

        // Add error boundary for better error handling
        window.addEventListener('error', function(e) {
            console.error('Calendar error:', e.error);
            showNotification('An unexpected error occurred. Please refresh the page.', 'error');
        });

        // Add service worker detection
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.addEventListener('message', function(event) {
                if (event.data && event.data.type === 'CACHE_UPDATED') {
                    showNotification('New version available! Refresh to update.', 'info');
                }
            });
        }
    </script>
</body>

</html>