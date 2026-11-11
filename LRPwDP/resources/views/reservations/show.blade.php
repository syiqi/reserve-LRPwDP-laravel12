<x-app-layout>
<x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 light:text-gray-200 leading-tight">
                {{ __('Reservation Proof') }}
            </h2>
        </x-slot>
    <x-authentication-card>

        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <a href="@if(Auth::user()->role==='customer'){{'/reservations'}}@else{{'indexSeller'}}@endif" ><x-secondary-button>Back</x-secondary-button></a>
        <div class="flex space-x-2 mt-4" x-show="!photoPreview">
            @if ($reservation->perishable->imagePath)
                <img src="{{ asset('storage/' . $reservation->perishable->imagePath) }}" alt="{{ $reservation->perishable->name }}" class="rounded-md w-32 h-32 object-cover border">
            @else
                <div class="w-32 h-32 flex items-center justify-center border rounded-md bg-gray-100 text-gray-400">
                    No Image
                </div>
            @endif
            <div>
                <h3 class="text-sm font-medium text-gray-700">Name</h3>
                <p class="text-gray-900">{{ $reservation->reserveName }}</p>
            <div class="flex space-x-2">
                <div>
                <h3 class="text-sm font-medium text-gray-700">Price</h3>
                <p class="text-gray-900">RM{{ number_format(($reservation->reservePrice / $reservation->reserveQuantity),2)}}</p>
                </div>
                <span class="mt-6">*</span>
                <div>
                <h3 class="text-sm font-medium text-gray-700">Quantity</h3>
                <p class="text-gray-900">{{$reservation->reserveQuantity}}</p>
                </div>
                <span class="mt-5">=</span>
                <div>
                <h3 class="text-sm font-medium text-gray-700">Total Amount</h3>
                <p class="text-gray-900">RM{{ number_format($reservation->reservePrice,2)}}</p>
                </div>
            </div>
            <div class="flex space-x-8 justify-end">
                <div class="flex space-x-2 items-center">
                <h3 class="text-sm font-medium text-gray-700">Status:</h3>
                <span class="px-3 py-1 text-sm bg-yellow-100 text-yellow-700 rounded-full">{{ $reservation->status }}</span>
                 </div> 
                
                    @auth
                        @if(auth()->user()->role === 'seller' && $reservation->status!=='success')
                            <form action="{{ route('reservations.success', $reservation->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn-primary">Fully Paid</button>
                            </form>
                        @elseif(auth()->user()->role === 'customer' && $reservation->status==='reserved')
                        <form action="{{ route('reservations.cancel', $reservation->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to cancel this reservation?');">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn-primary">Cancel</button>
                            </form>
                        @endif
                    @endauth

                
            </div>
                </div>
        </div>
        <div class="receipt">

            <div class="border-y-2 my-4 py-4">
                <h3 class="text-sm font-medium text-gray-700">Description</h3>
                <p class="text-gray-900">{{ $reservation->perishable->description ?? 'Not available' }}</p>
            </div>
            <div class="grid grid-cols-2 divide-x-2 divide-dashed">
            <div>
                <h3 class="text-sm font-medium text-gray-700">Reserved By</h3>
                <p class="text-gray-900">{{ $reservation->user->name ?? 'Unknown' }}</p>
            
                <h3 class="text-sm font-medium text-gray-700 mt-2">Reserved At</h3>
                <p class="text-gray-900">{{\Carbon\Carbon::parse($reservation->created_at)->toFormattedDateString()}}</p>
            
                <h3 class="text-sm font-medium text-gray-700 mt-2">Pickup Time</h3>
                <p class="text-gray-900">{{ \Carbon\Carbon::parse($reservation->pickupTime)->format('g:i A') }}</p>
            
            </div>
            <div class="pl-4">
                <h3 class="text-sm font-medium text-gray-700">Sold By</h3>
                <p class="text-gray-900">{{ $reservation->perishable->user->name ?? 'Unknown' }}</p>
            @php
                $fullAddress = $reservation->perishable->user->address .  ', '."\n" . $reservation->perishable->user->postcode . ' ' . $reservation->perishable->user->city . ', '."\n" . $reservation->perishable->user->state . ', '."\n" . $reservation->perishable->user->country;
                $mapsUrl = 'https://www.google.com/maps/search/?api=1&query=' . urlencode(str_replace("\n", ', ', $fullAddress));
            @endphp

            
                <h3 class="text-sm font-medium text-gray-700 mt-2">Address/Pickup Location</h3>
                <address class="text-gray-900">
                    <a href="{{ $mapsUrl }}" target="_blank" class="hover:underline text-blue-600">
                        {{ $fullAddress ?? 'Not Available' }}
                    </a>
                </address>
            </div>

        </div>
        </div>
    </x-authentication-card>
</x-app-layout>