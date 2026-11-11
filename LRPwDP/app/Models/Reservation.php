<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
       use HasFactory;

    protected $guarded = [];
    //explain the relations of model, look at ERD Diagram for more info
    protected $fillable = [
        'perishableID',
        'customerID',
        'reserveName',
        'reserveQuantity',
        'reservePrice',
        'pickupTime',
        'status',
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customerID');
    }

        public function perishable(): BelongsTo
    {
        return $this->belongsTo(Perishable::class, 'perishableID');
    }
}
