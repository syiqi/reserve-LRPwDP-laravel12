<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Perishable extends Model
{
    use HasFactory;

    protected $guarded = [];
    //explain the relations of model, look at ERD Diagram for more info

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sellerID');
    }
}
