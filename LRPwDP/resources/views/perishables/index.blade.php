<x-app-layout>
    <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Listed Perishable') }}
    </h2>
    </x-slot>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                    <a href="{{ route('perishables.create') }}" class="btn btn-primary">Add New</a>
                    
                    <h3 class="text-3xl my-2">Active List</h2>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th class="min-w-32">Image</th>
                                    <th>Name</th>
                                    <th class="text-right">Quantity<br>Left</th>
                                    <th class="text-right">Current ~<br>Lowest Price</th>
                                    <th>Listed Date/<br> Last Updated</th>
                                    <th>Expiry Date</th>
                                    <th class="text-center">Action</th>
                                </tr>
                                <tbody>
                                    @forelse($listed as $perishable)
                                    
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td><img src="{{ asset('storage/' . $perishable->imagePath) }}" alt="Image" class="h-20 w-20 object-cover rounded"></td>
                                        <td>{{$perishable->name ?? 'Unavailable' }} ({{ $perishable->measurement ?? 'N/A'}})</td>
                                        <td class="text-right">{{$perishable->quantity ?? 'Error' }} out of {{{ $perishable->quantityOriginal ?? 'Error' }}}</td>
                                        <td><s class="mx-2 text-xs px-3 py-1 text-sm bg-gray-100 text-gray-700 rounded-full">RM{{number_format($perishable->priceOriginal,2) ?? 'Error' }}</s><br><span class="px-3 py-1 text-sm bg-green-100 text-green-700 rounded-full">RM{{number_format($perishable->priceCurrent,2) ?? 'Error' }}</span> ~ <span class="px-3 py-1 text-sm bg-red-100 text-red-700 rounded-full">RM{{number_format($perishable->priceLowerBound,2) ?? '0' }}</span></td>
                                        <td>{{\Carbon\Carbon::parse($perishable->created_at)->toDayDateTimeString() ?? 'Not Stated' }}<br>({{\Carbon\Carbon::parse($perishable->updated_at)->diffForHumans() ?? 'Unknown' }})</td>
                                        <td>{{\Carbon\Carbon::parse($perishable->expiryDate)->toDayDateTimeString() ?? 'Not Stated' }}<br>({{\Carbon\Carbon::parse($perishable->expiryDate)->diffForHumans() ?? 'Unknown' }})</td>
                                        <td>
                                            <a href="{{ route('perishables.show', ['perishable' => $perishable['id']]) }}" class="btn btn-primary">Edit</a>
                                            <span class="text-2xl"> | </span>
                                            <form action="{{ route('perishables.unlist', ['perishable' => $perishable['id']]) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to unlist this perishable?');">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-warning"><u>Unlist</u></button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="px-4 py-2 text-center text-gray-500">No perishables found.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </thead>
                        </table>
                    </div>

                    <h3 class="text-3xl my-2">Historical List</h2>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th class="min-w-32">Image</th>
                                    <th>Name</th>
                                    <th class="text-right">Quantity<br>Unsold</th>
                                    <th class="text-right">Last Set<br>Price</th>
                                    <th>Listed Date/<br> Last Updated</th>
                                    <th>Expiry Date</th>
                                    <th class="text-center">Action</th>
                                </tr>
                                <tbody>
                                    @forelse($unlisted as $perishable)
                                        <td>{{$loop->iteration}}</td>
                                        <td><img src="{{ asset('storage/' . $perishable->imagePath) }}" alt="Image" class="h-20 w-20 object-cover rounded"></td>
                                        <td>{{$perishable->name ?? 'Unavailable' }} ({{ $perishable->measurement ?? 'N/A'}})</td>
                                        <td class="text-right">{{$perishable->quantity ?? 'Error' }} out of {{{ $perishable->quantityOriginal ?? 'Error' }}}</td>
                                        <td><s class="mx-2 text-xs px-3 py-1 text-sm bg-gray-100 text-gray-700 rounded-full">RM{{number_format($perishable->priceOriginal,2) ?? 'Error' }}</s><br><span class="px-3 py-1 text-sm bg-red-100 text-red-700 rounded-full">RM{{number_format($perishable->priceCurrent,2) ?? 'Error' }}</span></td>
                                        <td>{{\Carbon\Carbon::parse($perishable->created_at)->toDayDateTimeString() ?? 'Not Stated' }}<br>({{\Carbon\Carbon::parse($perishable->updated_at)->diffForHumans() ?? 'Unknown' }})</td>
                                        <td>{{\Carbon\Carbon::parse($perishable->expiryDate)->toDayDateTimeString() ?? 'Not Stated' }}<br>({{\Carbon\Carbon::parse($perishable->expiryDate)->diffForHumans() ?? 'Unknown' }})</td>
                                        <td>
                                            <a href="{{ route('perishables.show', ['perishable' => $perishable['id']]) }}" class="btn btn-primary">Edit</a><span class="text-2xl"> | </span>
                                            <form action="{{ route('perishables.unlist', ['perishable' => $perishable['id']]) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to list this perishable?');">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-warning"><u>List</u></button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="px-4 py-2 text-center text-gray-500">No unlisted perishables found.</td>
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