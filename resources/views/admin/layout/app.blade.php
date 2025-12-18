<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <title>Admin | @yield('title')</title>

    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Chart.js untuk dashboard --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-neutral-100" x-data="{ sidebarOpen: false }">

    <div class="flex h-screen">

        {{-- 2. Sidebar Component --}}
        @include('admin.sidebar')

        {{-- 3. Main Content Area --}}
        <main class="flex-1 overflow-y-auto" id="app">
            <div class="px-4 md:px-8">
                @include('admin.topbar')
                <div class="my-4">
                    @yield('content')
                    @stack('scripts')
                </div>
            </div>
        </main>
        
    </div>
</html>
