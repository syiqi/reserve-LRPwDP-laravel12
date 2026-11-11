<x-app-layout>

    <x-authentication-card>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 light:text-gray-200 leading-tight">
                {{ __('List new perishable') }}
            </h2>
        </x-slot>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>
        <a href="{{'\home'}}" ><x-secondary-button>Back</x-secondary-button></a>
        <div class="my-2" x-show="!photoPreview">
            @if ($perishable->imagePath)
                <img src="{{ asset('storage/' . $perishable->imagePath) }}" alt="{{ $perishable->name }}" class="rounded-md w-32 h-32 object-cover border">
            @else
                <div class="w-32 h-32 flex items-center justify-center border rounded-md bg-gray-100 text-gray-400">
                    No Image
                </div>
            @endif
        </div>
        <div class="space-y-4">
            <div class="flex flex-grid gap-4">
            <div>
                <h3 class="text-sm font-medium text-gray-700">Name</h3>
                <p class="text-gray-900">{{ $perishable->name }} ({{ $perishable->measurement }})</p>
            </div>
            <div>
                <h3 class="text-sm font-medium text-gray-700">Status</h3>
                @if($perishable->halal===1)<p class="text-gray-900"><span class="px-2 py-1 text-sm bg-green-100 text-green-700 rounded-full font-bold">HALAL✅ </span> </p>@else <p class="text-gray-900"><span class="px-2 py-1 text-sm bg-red-100 text-red-700 rounded-full font-bold">NON-HALAL </span> </p> @endif
            </div>
            </div>
            <div>
                <h3 class="text-sm font-medium text-gray-700">Description</h3>
                <p class="text-gray-900">{{ $perishable->description }}</p>
            </div>

            <div>
                <h3 class="text-sm font-medium text-gray-700">Expiration Date</h3>
                <p class="text-gray-900">{{ \Carbon\Carbon::parse($perishable->expiryDate)->format('d M Y') . ' (' . \Carbon\Carbon::parse($perishable->expiryDate)->diffForHumans() . ')'}}</p>
            </div>
            <div class="flex flex-grid gap-4">
                <div>
                    <h3 class="text-sm font-medium text-gray-700">Price</h3>
                    <span class="text-xs text-gray-500 mx-2"><s>RM{{number_format($perishable->priceOriginal,2) }}</s></span>
                    <p class="text-gray-900">RM{{ number_format($perishable->priceCurrent,2) }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-700">Quantity</h3>
                    <p class="text-gray-900 p-2 mt-2">{{ $perishable->quantity }} left</p>
                </div>
            </div>
            @if(auth()->user()->role==='customer')
            <form method="POST" action="{{ route('reservations.store') }}" class="border-y-2 py-2">
                @csrf
                <div class="flex flex-grid gap-4">
                <input type="hidden" name="perishableID" value="{{ $perishable->id }}">
                    <div class="mt-2 w-1/2">
                        <x-label for="reserveQuantity" value="{{ __('Reserve amount?') }}" />
                        <x-input id="reserveQuantity" class="block mt-1 w-full" type="number" name="reserveQuantity" min="1" max="{{ $perishable->quantity }}" required autofocus placeholder="1, 2, 3, ..."/>
                    </div>
                    <div class="mt-2 w-1/2">
                        <x-label for="pickupTime" value="{{ __('Pickup Time') }}" />
                        <x-input id="pickupTime" class="block mt-1 w-full" type="time" name="pickupTime" min="{{ now()->format('H:i') }}" max="23:00" required />
                        <small class="text-gray-500">Select a preferred pickup time.</small>
                    </div>
             </div>       
                <div class="flex items-center justify-end mt-4">
                    <x-button class="ms-4">
                        {{ __('Reserve') }}
                    </x-button>
                </div>
            
            </form>
            @endif
            <div>
                <h3 class="text-sm font-medium text-gray-700">Pickup at</h3>

            @php
                $fullAddress = $user->address .  ', '."\n" . $user->postcode . ' ' . $user->city . ', '."\n" . $user->state . ', '."\n" . $user->country;
                $mapsUrl = 'https://www.google.com/maps/search/?api=1&query=' . urlencode(str_replace("\n", ', ', $fullAddress));
            @endphp

            
                <h3 class="text-sm font-medium text-gray-700">Address</h3>
                <address class="text-gray-900">
                    <a href="{{ $mapsUrl }}" target="_blank" class="hover:underline text-blue-600">
                        {{ $fullAddress }}
                    </a>
                </address>
            </div>
        </div>


    </x-authentication-card>
</x-app-layout>