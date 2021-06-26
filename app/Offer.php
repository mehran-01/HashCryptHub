<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $fillable = [
        'fiat_currency',
        'payment_method',
        'min_amount',
        'max_amount',
        'margin_percentage',
        'final_offer',
        'status',
        'owner_user_id',
        'traded_by_user_id',
        'trade_offer',
        'trade_status',
        'btc'    
    ];
}
