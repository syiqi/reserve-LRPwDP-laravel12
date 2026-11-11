<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Http\Requests\PerishableFormRequest;
use App\Http\Requests\PerishableUpdateFormRequest;
use App\Models\Perishable;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class PerishableController extends Controller
{
    /**
     * Display a listing of the perishables.
     */
    public function dashboard(Request $request)
    {
        $user = Auth::user();
        if($user->role !== 'seller'){
            abort(403, 'Unauthorized'); 
        }
        $perishableIds = Perishable::where('sellerID',$user->id)->pluck('id');
        $totalPerishable = Perishable::where('sellerID', $user->id)
                            ->count();
        $activePerishable = Perishable::where('sellerID', $user->id)
                            ->where('status',1)
                            ->count();
        $soldToday = Reservation::whereIn('perishableID', $perishableIds)
                    ->whereDate('created_at',now())        
                    ->where('status','success')
                    ->SUM('reserveQuantity');
        $totalSold = Reservation::whereIn('perishableID', $perishableIds)       
                    ->where('status','success')
                    ->SUM('reserveQuantity');

        $revenueToday = Reservation::whereIn('perishableID', $perishableIds)
                        ->whereDate('created_at',now())        
                        ->where('status','success')
                        ->selectRaw('SUM(reserveQuantity * reservePrice) as revenue')
                        ->value('revenue');
        $totalRevenue = Reservation::whereIn('perishableID', $perishableIds)
                        ->where('status', 'success')
                        ->selectRaw('SUM(reserveQuantity * reservePrice) as revenue')
                        ->value('revenue');


        $today = Carbon::today();
        $expiringList = Perishable::where('sellerID', $user->id)
            ->where(function ($q) use ($today) {

                // 3-day expiry group
                $q->orWhere(function ($q) use ($today) {
                    $q->whereIn('type', ['preparedMeals', 'bakedGoods', 'desserts'])
                    ->whereBetween('expiryDate', [$today, $today->copy()->addDays(3)]);
                });

                // 5-day expiry group
                $q->orWhere(function ($q) use ($today) {
                    $q->whereIn('type', ['dairyProducts', 'MS'])
                    ->whereBetween('expiryDate', [$today, $today->copy()->addDays(5)]);
                });

                // 14-day expiry group
                $q->orWhere(function ($q) use ($today) {
                    $q->whereIn('type', ['beverages', 'SJC', 'snacks'])
                    ->whereBetween('expiryDate', [$today, $today->copy()->addDays(14)]);
                });

                // 30-day expiry group
                $q->orWhere(function ($q) use ($today) {
                    $q->where('type', 'frozenFoods')
                    ->whereBetween('expiryDate', [$today, $today->copy()->addDays(30)]);
                });

                // 60-day expiry group
                $q->orWhere(function ($q) use ($today) {
                    $q->whereIn('type', ['cannedFoods', 'dryGoods', 'SS', 'herbs'])
                    ->whereBetween('expiryDate', [$today, $today->copy()->addDays(60)]);
                });

                // Default: 7 days
                $q->orWhere(function ($q) use ($today) {
                    $q->whereNotIn('type', [
                        'preparedMeals','bakedGoods','desserts',
                        'dairyProducts','MS',
                        'beverages','SJC','snacks',
                        'frozenFoods',
                        'cannedFoods','dryGoods','SS','herbs'
                    ])
                    ->whereBetween('expiryDate', [$today, $today->copy()->addDays(7)]);
                });

            })
            ->orderBy('expiryDate')
            ->get();

        $reservedList = Reservation::whereIn('perishableID', $perishableIds)
                        ->where('status', 'reserved')
                        ->get();
        

        return view('dashboard', compact('totalPerishable', 'activePerishable','soldToday', 'totalSold', 'revenueToday','totalRevenue','expiringList','reservedList'));
    }
    public function index(Request $request)
    {
        $user = Auth::user();
        if($user->role !== 'seller'){
            abort(403, 'Unauthorized'); 
        }
        //$perishables = Perishable::where('sellerID', $user->id)->get();
        $listed = Perishable::where('sellerID', $user->id)->where('status', 1)->get();
        $unlisted = Perishable::where('sellerID', $user->id)->where('status', 0)->get();
        

        return view('perishables.index', compact('listed', 'unlisted'));
    }
    public function indexHome(Request $request)
    {
        $query = Perishable::where('status', 1);

        /*
        |--------------------------------------------------------------------------
        | SEARCH FILTER (Correctly grouped!)
        |--------------------------------------------------------------------------
        */
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%");
            });
        }

        /*
        |--------------------------------------------------------------------------
        | CATEGORY FILTER (Must match exactly)
        |--------------------------------------------------------------------------
        */
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        /*
        |--------------------------------------------------------------------------
        | HALAL
        |--------------------------------------------------------------------------
        */
        if ($request->boolean('halal')) {
            $query->where('halal', true);
        }

        /*
        |--------------------------------------------------------------------------
        | RUNNING LOW
        |--------------------------------------------------------------------------
        */
        if ($request->boolean('low')) {
            $query->where('quantity', '<', 10);
        }

        /*
        |--------------------------------------------------------------------------
        | NEAR EXPIRY (grouped properly)
        |--------------------------------------------------------------------------
        */
        if ($request->boolean('near_expiry')) {

            $today = now()->startOfDay();

            $query->where(function ($q) use ($today) {

                // 3 days
                $q->orWhere(function ($q) use ($today) {
                    $q->whereIn('type', ['preparedMeals', 'bakedGoods', 'desserts'])
                    ->whereBetween('expiryDate', [$today, $today->copy()->addDays(3)]);
                });

                // 5 days
                $q->orWhere(function ($q) use ($today) {
                    $q->whereIn('type', ['dairyProducts', 'MS'])
                    ->whereBetween('expiryDate', [$today, $today->copy()->addDays(5)]);
                });

                // 14 days
                $q->orWhere(function ($q) use ($today) {
                    $q->whereIn('type', ['beverages', 'SJC', 'snacks'])
                    ->whereBetween('expiryDate', [$today, $today->copy()->addDays(14)]);
                });

                // 30 days
                $q->orWhere(function ($q) use ($today) {
                    $q->where('type', 'frozenFoods')
                    ->whereBetween('expiryDate', [$today, $today->copy()->addDays(30)]);
                });

                // 60 days
                $q->orWhere(function ($q) use ($today) {
                    $q->whereIn('type', ['cannedFoods', 'dryGoods', 'SS', 'herbs'])
                    ->whereBetween('expiryDate', [$today, $today->copy()->addDays(60)]);
                });

                // Default
                $q->orWhere(function ($q) use ($today) {
                    $q->whereNotIn('type', [
                        'preparedMeals','bakedGoods','desserts',
                        'dairyProducts','MS',
                        'beverages','SJC','snacks',
                        'frozenFoods',
                        'cannedFoods','dryGoods','SS','herbs'
                    ])
                    ->whereBetween('expiryDate', [$today, $today->copy()->addDays(7)]);
                });

            });
        }

        /*
        |--------------------------------------------------------------------------
        | PRICE RANGE
        |--------------------------------------------------------------------------
        */
        if ($request->filled('min_price')) {
            $query->where('priceCurrent', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('priceCurrent', '<=', $request->max_price);
        }

        /*
        |--------------------------------------------------------------------------
        | FINAL
        |--------------------------------------------------------------------------
        */
        $perishables = $query->orderBy('created_at', 'desc')->paginate(8);

        return view('home', compact('perishables'));
    }

    /**
     * Get dynamic price from ML API
     */
    public function getDynamicPrice(Request $request)
    {
        $response = Http::post('http://127.0.0.1:5000/predict-price', [
            'Price' => $request->price,
            'OriginalPrice' => $request->original_price,
            'ExpiryDays' => $request->expiry_days,
            'Quantity' => $request->quantity,
            'WeatherCode' => $request->weather_code,
            'Weekday' => $request->weekday,
            'IsHoliday' => $request->is_holiday,
        ]);

        return response()->json([
            'new_price' => $response->json()['new_price'] ?? null,
        ]);
    }

    /**
     * Show create form
     */
    public function create()
    {
        return view('perishables.create');
    }

    /**
     * Store a new perishable
     */
    public function store(PerishableFormRequest $request)
    {
        $data = $request->validated();

        // Handle image upload
        if ($request->hasFile('imagePath')) {
            $data['imagePath'] = $request->file('imagePath')->store('perishables', 'public');
        }

        Perishable::create($data);

        return redirect()
            ->route('perishables.index')
            ->with('success', 'Perishable listed successfully.');
    }

    /**
     * Display a perishable
     */
    public function show($id)
    {
        $user = Auth::user();
        if($user->role !== 'seller'){
            abort(403, 'Unauthorized'); 
        }
        $perishable = Perishable::with('user')->findOrFail($id);
        return view('perishables.show', compact('perishable'));
    }

    /**
     * Edit form
     */

    /**
     * Update perishable
     */
    public function update(PerishableUpdateFormRequest $request, Perishable $perishable)
    {
        $data = $request->validated();
        if (!$request->hasFile('imagePath')) {
                unset($data['imagePath']);
            }
        // Handle new image upload
        if ($request->hasFile('imagePath')) {
            // Delete old image if exists
            
            if ($perishable->imagePath && Storage::disk('public')->exists($perishable->imagePath)) {
                Storage::disk('public')->delete($perishable->imagePath);
            }

            $data['imagePath'] = $request->file('imagePath')->store('perishables', 'public');
        }

        $perishable->update($data);

        return redirect()
            ->route('perishables.show', $perishable['id'])
            ->with('success', 'Perishable updated successfully!');
    }
    public function unlist(Perishable $perishable)
    {
        if($perishable['status']==1){
            $perishable['status']=0;
        }
        elseif($perishable['status']==0){
            $perishable['status']=1;
        }
        $perishable->save();

        return redirect()
            ->route('perishables.index', $perishable)
            ->with('success', 'Perishable unlisted successfully!');
    }
    /**
     * Remove image only
     */
    public function removeImage(Perishable $perishable)
    {
        if ($perishable->imagePath && Storage::disk('public')->exists($perishable->imagePath)) {
            Storage::disk('public')->delete($perishable->imagePath);
            $perishable->update(['imagePath' => null]);
        }

        return redirect()
            ->back()
            ->with('success', 'Image removed successfully.');
    }
    

    /**
     * Delete perishable
     */
    public function destroy(Perishable $perishable)
    {
        if ($perishable->imagePath && Storage::disk('public')->exists($perishable->imagePath)) {
            Storage::disk('public')->delete($perishable->imagePath);
        }

        $perishable->delete();

        return redirect()
            ->route('perishables.index')
            ->with('success', 'Perishable deleted successfully.');
    }
}
