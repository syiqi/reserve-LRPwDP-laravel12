<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">

                    <h1 class="text-2xl font-semibold text-gray-900">
                        Seller Dashboard
                    </h1>

                    <p class="mt-2 text-gray-600">
                        Overview of your inventory, revenue, and expiring perishables.
                    </p>

                    <!-- Stats Grid -->
                    <div class="mt-8 grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">

                        <!-- Total Products -->
                        <a href="{{ route('perishables.index') }}"><div class="p-6 bg-blue-50 border border-blue-200 rounded-lg">
                            <h2 class="text-sm text-blue-600 font-medium">Total Perishable</h2>
                            <p class="mt-2 text-3xl font-bold text-blue-900">{{ $totalPerishable ?? 0 }}</p>
                        </div></a>

                        <a href="{{ route('perishables.index') }}"><div class="p-6 bg-blue-50 border border-blue-200 rounded-lg">
                            <h2 class="text-sm text-blue-600 font-medium">Active Perishable</h2>
                            <p class="mt-2 text-3xl font-bold text-blue-900">{{ $activePerishable ?? 0 }}</p>
                        </div></a>

                        <!-- Sold Today -->
                        <a href="{{ route('reservations.indexSeller') }}"><div class="p-6 bg-green-50 border border-green-200 rounded-lg">
                            <h2 class="text-sm text-green-600 font-medium">Sold Today</h2>
                            <p class="mt-2 text-3xl font-bold text-green-900">{{ $soldToday ?? 0 }}</p>
                        </div></a>

                        <a href="{{ route('reservations.indexSeller') }}"><div class="p-6 bg-green-50 border border-green-200 rounded-lg">
                            <h2 class="text-sm text-green-600 font-medium">Total Sold</h2>
                            <p class="mt-2 text-3xl font-bold text-green-900">{{ $totalSold ?? 0 }}</p>
                        </div></a>

                        <!-- Revenue -->
                        <a href="{{ route('reservations.indexSeller') }}"><div class="p-6 bg-yellow-50 border border-yellow-200 rounded-lg">
                            <h2 class="text-sm text-yellow-600 font-medium">Revenue Today</h2>
                            <p class="mt-2 text-3xl font-bold text-yellow-900">RM{{ number_format($revenueToday, 2) ?? 0.00 }}</p>
                        </div></a>
                        <!-- Revenue -->
                        <a href="{{ route('reservations.indexSeller') }}"><div class="p-6 bg-yellow-50 border border-yellow-200 rounded-lg">
                            <h2 class="text-sm text-yellow-600 font-medium">Total Revenue</h2>
                            <p class="mt-2 text-3xl font-bold text-yellow-900">RM{{ number_format($totalRevenue, 2) ?? 0.00 }}</p>
                        </div></a>
                    </div>

                    <div class="mt-10">
                        <button 
                            onclick="document.getElementById('perishables').classList.toggle('hidden')"
                            class="w-full flex justify-between items-center bg-gray-100 p-4 rounded-lg border text-xl font-semibold text-gray-800">
                            Expiring Perishables
                            <span>▼</span>
                        </button>
                        <div id="perishables" class="mt-2 bg-white border rounded-lg divide-y hidden">
                            @forelse($expiringList as $expiring)
                            <div class="p-4 flex justify-between items-center">
                                <div>
                                    <p class="font-medium text-gray-900">{{ $expiring->name }} ({{ $expiring->measurement }})</p>
                                    <p class="text-sm text-gray-500">Expires in {{  \Carbon\Carbon::parse($expiring->expiryDate)->diffForHumans() }}</p>
                                </div>
                                <span class="px-3 py-1 text-sm bg-red-100 text-red-700 rounded-full">Urgent</span>
                            </div>
                        @empty

                        <p class="m-6">Not Available</p>
                        @endforelse
                        </div>
                        
                        
                    </div>

                    
                    <div class="mt-10">
                        <button 
                            onclick="document.getElementById('perishablesR').classList.toggle('hidden')"
                            class="w-full flex justify-between items-center bg-gray-100 p-4 rounded-lg border text-xl font-semibold text-gray-800">
                            Reserved Perishables
                            <span>▼</span>
                        </button>

                        <div id="perishablesR" class="mt-2 bg-white border rounded-lg divide-y hidden">
                            @forelse($reservedList as $reserved)
                            <div class="p-4 flex justify-between items-center">
                                <div>
                                    <p class="font-medium text-gray-900">{{ $reserved->perishable->name }} ({{ $reserved->perishable->measurement }})</p>
                                    <p class="text-sm text-gray-500">Reserved on {{  \Carbon\Carbon::parse($reserved->created_at)->toDayDateTimeString() }}</p>
                                </div>
                                <span class="px-3 py-1 text-sm bg-red-100 text-red-700 rounded-full">Pickup Time: {{  \Carbon\Carbon::parse($reserved->pickupTime)->format('g:i A') }}</span>
                            </div>
                        @empty
                        <p class="m-6">Not Available</p>
                        @endforelse
                        </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
