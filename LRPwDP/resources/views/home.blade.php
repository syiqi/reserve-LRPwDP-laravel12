<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Marketplace') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div>
            {{-- 🔍 Search & Filter Form --}}
            <form method="GET" action="{{ route('home') }}" class="mb-6 flex flex-wrap items-center gap-4 bg-white p-4 rounded shadow">
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Search. . ." 
                       class="w-full sm:w-1/3 border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">

                <select name="type" class="border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
                    <option value="">All Categories</option>
                    <option value="preparedMeals" {{ request('type') == 'preparedMeals' ? 'selected' : '' }}>Prepared Meals</option>
                    <option value="bakedGoods" {{ request('type') == 'bakedGoods' ? 'selected' : '' }}>Baked Goods</option>
                    <option value="desserts" {{ request('type') == 'desserts' ? 'selected' : '' }}>Desserts</option>
                    <option value="beverages" {{ request('type') == 'beverages' ? 'selected' : '' }}>Beverages</option>
                    <option value="SJC" {{ request('type') == 'SJC' ? 'selected' : '' }}>Sauces, Jams or Condiments</option>
                    <option value="frozenFoods" {{ request('type') == 'frozenFoods' ? 'selected' : '' }}>Frozen Foods</option>
                    <option value="cannedFoods" {{ request('type') == 'cannedFoods' ? 'selected' : '' }}>Canned Foods</option>
                    <option value="snacks" {{ request('type') == 'snacks' ? 'selected' : '' }}>Snacks</option>
                    <option value="dairyProducts" {{ request('type') == 'dairyProducts' ? 'selected' : '' }}>Dairy Products</option>
                    <option value="MS" {{ request('type') == 'MS' ? 'selected' : '' }}>Meats or Seafoods</option>
                    <option value="dryGoods" {{ request('type') == 'dryGoods' ? 'selected' : '' }}>Dry Goods</option>
                    <option value="SS" {{ request('type') == 'SS' ? 'selected' : '' }}>Spices or Seasonings</option>
                    <option value="herbs" {{ request('type') == 'herbs' ? 'selected' : '' }}>Herbs</option>
                </select>

                <span class="text-2xl">(</span>
                <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min Price" class="w-24 border-gray-300 rounded-md shadow-sm">
                <span class="text-2xl">~</span>
                <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max Price" class="w-24 border-gray-300 rounded-md shadow-sm">
                <span class="text-2xl">)</span>
                <div class="flex flex-grid gap-4">
                    
                    <label class="flex items-center gap-2">
                    <input type="checkbox" name="halal" value="1" {{ request('halal') ? 'checked' : ''}} class="rounded text-gray-600 focus:ring-green-500">
                    <span>Halal</span>
                    </label>


                    <label class="flex items-center gap-2">
                    <input type="checkbox" name="low" value="1" {{ request('low') ? 'checked' : ''}} class="rounded text-gray-600 focus:ring-green-500">
                    <span>Running Low</span>
                    </label>

                    <label class="flex items-center gap-2">
                    <input type="checkbox" name="near_expiry" value="1" {{ request('near_expiry') ? 'checked' : ''}} class="rounded text-gray-600 focus:ring-green-500">
                    <span>Near Expiry</span>
                    </label>
                    
                <div class="p-4">
                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">
                    Filter
                </button>
                <button type="reset" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                    <a href="{{ route('home') }}" 
                    class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                    Reset
                    </a>
                </button>
                </div>
                </div>
            </form>
            </div>

            {{-- 🧺 Perishables Grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse ($perishables as $perishable)
                    <a href="{{ route('reservations.createPerishableReservation', $perishable->id) }}" 
                       class="block bg-white overflow-hidden shadow rounded-lg hover:shadow-lg transition-shadow duration-200">
                        <img  src="{{ asset('storage/' . ($perishable->imagePath ?? '')) }}" 
                             alt="{{ $perishable->name }}" 
                             class="w-full h-48 object-cover">
                        <div class="p-4">
                            <div class="flex flex-grid justify-between items-center">
                            <h3 class="text-lg font-semibold text-gray-800">{{ $perishable->name ?? ''}} ({{ $perishable->measurement ?? '' }})</h3>
                            @if($perishable->halal===1)<span class="mx-2 px-3 py-1 text-sm bg-green-100 text-green-700 rounded-full font-bold">HALAL✅ </span> @else <span class="mx-2 px-3 py-1 text-sm bg-red-100 text-red-700 rounded-full font-bold">NON-HALAL </span> @endif 
                            </div>
                            <p class="text-sm text-gray-600">{{ Str::limit($perishable->description ?? '', 60) }}</p>
                            <div class="mt-2 flex justify-between items-center">
                                <div>
                                <span class="text-xs text-gray-500"><s>RM{{ number_format($perishable->priceOriginal, 2) }}</s></span><br>
                                <span class="text-green-600 font-bold">RM{{ number_format($perishable->priceCurrent, 2) }}</span><br>
                                <span class="text-xs text-gray-500 ">📍{{ $perishable->user->city ?? '' }}, {{ $perishable->user->state ?? '' }}</span>
                                </div>
                                <div>
                                <span class="text-xs text-gray-500">Expires: {{ \Carbon\Carbon::parse($perishable->expiryDate)->format('d/m/Y') }}
                                <br> ({{ \Carbon\Carbon::parse($perishable->expiryDate)->diffForHumans() }})</span>
                                <br> <span class="text-m text-gray-500 font-bold">{{ $perishable->quantity}} left</span>
                                </div>
                            </div>
                            <button class="mt-3 w-full bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded text-sm">
                                Reserve
                            </button>
                        </div>
                    </a>
                @empty
                    <p class="text-gray-500">No perishables found.</p>
                @endforelse
            </div>

            {{-- 📄 Pagination --}}
            <div class="mt-6">
                {{ $perishables->withQueryString()->links() }}
            </div>

        </div>
    </div>
</x-app-layout>