<?php

namespace App\Http\Controllers;
use App\Models\Perishable;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
class ReservationController extends Controller
{
    public function createPerishableReservation($id)
    {
        $perishable = Perishable::findOrFail($id);
        $user = User::findorFail($perishable->sellerID);
        return view('reservations.createPerishableReservation', compact('perishable','user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'perishableID'=> 'required|exists:perishables,id',
        ]);

        $perishable = Perishable::findOrFail($request->perishableID);
        $validated = $request->validate([
            'reserveQuantity' => "required|integer|min:1|max:{$perishable->quantity}",
            'pickupTime' => "required|date_format:H:i",
         ]);

        $today = now()->toDateString();
        $pickupDateTime = Carbon::createFromFormat('Y-m-d H:i', "$today {$validated['pickupTime']}");

        // ⚠️ Check if the chosen time is in the past
        if ($pickupDateTime->lessThan(now())) {
            return back()
                ->withErrors(['pickupTime' => 'Pickup time must be later than the current time.'])
                ->withInput();
        }
         $reservePrice = ($perishable->priceCurrent*$validated['reserveQuantity']); 
         $reserveName = ($perishable->name . ' (' . $perishable->measurement . ')');
         Reservation::create([
            'perishableID' => $perishable->id,
            'customerID' => Auth::id(),
            'reserveName' => $reserveName,
            'reserveQuantity' => $validated['reserveQuantity'],
            'reservePrice' => $reservePrice,
            'pickupTime' => $pickupDateTime,
            'status' => 'reserved',
            
        ]);

        $perishable->decrement('quantity', $validated['reserveQuantity']);

        return redirect()
            ->route('reservations.index')
            ->with('success', 'Reservation successfully made.');
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        if($user->role !== 'customer'){
            abort(403, 'Unauthorized'); 
        }
        //$perishables = Perishable::where('sellerID', $user->id)->get();
        $reservations = Reservation::where('customerID', $user->id)->where('status', 'reserved')->get();
        $history = Reservation::where('customerID', $user->id)->whereIn('status',['successful','cancelled'])->get();
        
        return view('reservations.index', compact('reservations','history'));
    }

    public function indexSeller(Request $request)
    {
        $user = Auth::user();

        // Ensure only sellers can access
        if (!$user || $user->role !== 'seller') {
            abort(403, 'Unauthorized');
        }

        // Get all active reservations (status = reserved)
        $reservations = Reservation::with(['user', 'perishable'])
            ->whereHas('perishable', function ($query) use ($user) {
                $query->where('sellerID', $user->id);
            })
            ->where('status', 'reserved')
            ->get();

        // Get reservation history (successful or cancelled)
        $history = Reservation::with(['user', 'perishable'])
            ->whereHas('perishable', function ($query) use ($user) {
                $query->where('sellerID', $user->id);
            })
            ->where('status', 'success')
            ->get();

        // Return view with both collections
        return view('reservations.indexSeller', compact('reservations', 'history'));
    }

    public function cancel(Reservation $reservation)
    {
        $reservation['status']='cancelled';
        $reservation->save();
        
        $perishable = Perishable::findOrFail($reservation['perishableID']);
        $perishable->increment('quantity', $reservation['reserveQuantity']);
        
        return redirect()
            ->route('reservations.index', $reservation)
            ->with('success', 'Reservation cancelled');
    }

    public function success(Reservation $reservation)
    {
        $reservation['status']='success';
        $reservation->save();
        
        return redirect()
            ->route('reservations.indexSeller', $reservation)
            ->with('success', 'Reservation Success');
    }

        public function show($id)
    {
        $reservation = Reservation::findOrFail($id);
        return view('reservations.show', compact('reservation'));
    }

    
}
