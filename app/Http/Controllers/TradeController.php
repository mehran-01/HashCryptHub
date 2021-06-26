<?php

namespace App\Http\Controllers;

use \Auth;
use View;
use App\Offer;
use App\User;
use Illuminate\Http\Request;

class TradeController extends Controller
{

    protected   $BTN;
    protected   $converted_currency;


    public function __construct()
    {
        $this->middleware('auth');

        //Added on 05/19/2019

        //Bitcoin market price
        $this->BTN = 3000;

        //Converts BTN to other Currencies
        $this->converted_currency = array(
            'EURO'=>7101.21,
            'USD'=>7933.41,
            'GBP'=>6235.47,
            'NGN'=>2865430.64
        );

        View::share('BTN', $this->BTN);
        View::share('converted_currency', $this->converted_currency);


    }


    public function index()
    {
        $current_user_id = Auth::user()->id;

        $offers = Offer::where('status', true)
        // ->where('owner_user_id',$current_user_id)
        ->whereNotNull('traded_by_user_id')
        // ->where('traded_by_user_id', '!=', $current_user_id)
        ->get();

        return view('pages.trades.index', compact('offers', 'BTN', 'converted_currency'));

    }


    public function cancel($id)
    {
        $offer = Offer::find($id);
        $offer->trade_status = "Cancelled";

        $offer->save();

        return redirect('/')->with('success', 'Offer Transferred!');
    }


    public function sell(Request $request, $offer_id)
    {
        $offer = Offer::find($offer_id);

        $traded_by_user_id = Offer::where('id',$offer_id)
        ->value('traded_by_user_id');


        $amount_in_BTC = $request->get('amount_in_BTC');

        $offer->trade_status = "Successful";
        $offer->owner_user_id = $traded_by_user_id;
        $offer->save();

        $traded_by_user = User::find($traded_by_user_id);
        $traded_by_user->btc += $amount_in_BTC; 
        $traded_by_user->save();

        return redirect('/')->with('success', 'Offer Transferred!');

    }

}
