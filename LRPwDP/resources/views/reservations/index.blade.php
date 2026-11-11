<x-app-layout>
    <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Reservation List') }}
    </h2>
    </x-slot>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">        
                    <h3 class="text-3xl my-2">Reservation Made</h2>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th class="min-w-32">Image</th>
                                    <th>Name</th>
                                    <th>Quantity</th>
                                    <th>Payable<br>Amount</th>
                                    <th>Pickup Time</th>
                                    <th>Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                                <tbody>
                                    @forelse($reservations as $reservation)
                                    
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td><img src="{{ asset('storage/' . $reservation->perishable->imagePath) }}" alt="Perishable Image" width="150"></td>
                                        <td>{{$reservation->reserveName ?? 'Unavailable' }}</td>
                                        <td class="text-right">{{$reservation->reserveQuantity ?? 'Error' }}</td>
                                        <td>RM{{number_format($reservation->reservePrice,2) ?? 'Error' }}</td>
                                        <td>Today, {{\Carbon\Carbon::parse($reservation->pickupTime)->format('g:i A') ?? 'Not set' }}</td>
                                        <td>{{$reservation->status ?? 'Unknown' }}</td>
                                        <td><a href="{{ route('reservations.show', ['reservation' => $reservation['id']]) }}" class="btn btn-primary">Show</a>
                                        <span class="text-2xl"> | </span> 
                                            <form action="{{ route('reservations.cancel', ['reservation' => $reservation['id']]) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to cancel this reservation?');">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-warning">Cancel</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted">No reservation made today</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </thead>
                        </table>
                    </div>
                    <h3 class="text-3xl my-2">Reservation History</h2>
<div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th class="min-w-32">Image</th>
                                    <th>Name</th>
                                    <th>Quantity</th>
                                    <th>Amount Paid</th>
                                    <th>Pickup Time</th>
                                    <th>Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                                <tbody>
                                    @forelse($history as $reservation)
                                    
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td><img src="{{ asset('storage/' . $reservation->perishable->imagePath) }}" alt="Perishable Image" width="150"></td>
                                        <td>{{$reservation->reserveName ?? 'Unavailable' }}</td>
                                        <td>{{$reservation->reserveQuantity ?? 'Error' }}</td>
                                        <td>RM{{number_format($reservation->reservePrice,2)?? 'Error' }}</td>
                                        <td>{{\Carbon\Carbon::parse($reservation->pickupTime)->toDayDateTimeString() ?? 'Not set' }}</td>
                                        <td>{{$reservation->status ?? 'Unknown' }}</td>
                                        <td><a href="{{ route('reservations.show', ['reservation' => $reservation['id']]) }}" class="btn btn-primary">Show</a></td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted">No reservation ever made</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </thead>
                        </table>
                </div>
            </div>
        </div>
    </div>
</div>

    
</x-app-layout>