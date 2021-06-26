<?php

namespace App\Http\Controllers;

use \Auth;
use View;
use App\Offer;
use App\User;
use Illuminate\Http\Request;

class OfferController extends Controller
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

        $offers = Offer::where('owner_user_id',$current_user_id)->get();

        return view('pages.offers.index', compact('offers', 'BTN', 'converted_currency'));

    }


    public function create()
    {
        return view('pages.offers.create', compact('BTN', 'converted_currency'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'fiat_currency'=>'required',
            'payment_method'=>'required',
            'min_amount'=>'required|integer',
            'max_amount'=>'required|integer',
            'margin_percentage'=>'required|integer|between:1,100',
            'final_offer'=>'required',
        ]);

        $offer = new Offer([
            'fiat_currency' => $request->get('fiat_currency'),
            'payment_method' => $request->get('payment_method'),
            'min_amount' => $request->get('min_amount'),
            'max_amount' => $request->get('max_amount'),
            'margin_percentage' => $request->get('margin_percentage'),
            'final_offer' => number_format((float)$request->get('final_offer'), 2, '.', ''),
        ]);

        $offer->status = true;
        $offer->owner_user_id = Auth::user()->id;


        $offer->save();
        return redirect('/offers')->with('success', 'offer saved!');
    }


    public function edit($id)
    {
        $offer = Offer::find($id);
        return view('pages.offers.edit', compact('BTN', 'converted_currency', 'offer')); 
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'fiat_currency'=>'required',
            'payment_method'=>'required',
            'min_amount'=>'required',
            'max_amount'=>'required',
            'margin_percentage'=>'required',
            'final_offer'=>'required',
        ]);

        $offer = Offer::find($id);
        $offer->fiat_currency =  $request->get('fiat_currency');
        $offer->payment_method = $request->get('payment_method');
        $offer->min_amount = $request->get('min_amount');
        $offer->max_amount = $request->get('max_amount');
        $offer->margin_percentage = $request->get('margin_percentage');
        $offer->final_offer = $request->get('final_offer');
        $offer->save();

        return redirect('/offers')->with('success', 'Offer updated!');

    }


    public function destroy($id)
    {
        $offer = Offer::find($id);
        $offer->delete();

        return redirect('/offers')->with('success', 'Offer deleted!');
    }


    public function status($id, $status)
    {
        $offer = Offer::find($id);
        $offer->status = $status;

        $offer->save();

        return redirect('/offers')->with('success', 'Offer deleted!');
    }



    public function buy(Request $request, $offer_id, $trade_offer)
    {
        $request->validate([
            'trade_offer'=>'required',
        ]);

        $offer = Offer::find($offer_id);
        $offer->trade_offer =  number_format((float)$request->get('trade_offer'), 2, '.', '');
        $current_user_id = Auth::user()->id;
        $offer->traded_by_user_id = $current_user_id;
        $offer->trade_status = "Pending";
        $offer->save();

        return redirect('/')->with('success', 'Offer updated!');

    }

}
