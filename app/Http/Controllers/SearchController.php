<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\User;
use \Auth;
use Response;

class SearchController extends Controller
{

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


    }


    public function index(){

		return view('pages.offers.search');

	}


	public function search(Request $request){

		$current_user_id = Auth::user()->id;

		if($request->ajax()){
			$output="";
			$offers=DB::table('offers')
			->where($request->input('selected_search'),'LIKE','%'.$request->search."%")
			->where('status',true)
			// ->where('traded_by_user_id', '!=', $current_user_id)
			// ->orWhereNull('traded_by_user_id')
			->get();
				
				if($offers){
					foreach ($offers as $key => $offer) {

						$user_name = User::where('id',$offer->owner_user_id)->value('name');
						$user_id = User::where('id',$offer->owner_user_id)->value('id');

						$price_per_1_BTC_in_fiat = $this->converted_currency[$offer->fiat_currency];
						
						switch ($offer->fiat_currency) {
						    case "USD":
						        $currency_sign = "$";
						        break;
						    case "EURO":
						        $currency_sign = "€";
						        break;
						    case "GBP":
						        $currency_sign = "£";
						        break;
						    case "NGN":
						       $currency_sign = "₦";
						        break;
						    default:
						        $currency_sign = "$";
						}

						$output.='<tr data-id='.$offer->id.'>'.
							'<td>'.$user_name.'</td>'.
							'<td>'.$offer->payment_method.'</td>'.
							'<td>'.$currency_sign.' '.$offer->min_amount.'</td>'.
							'<td>'.$currency_sign.' '.$offer->max_amount.'</td>'.
							'<td>'.$currency_sign.' '.$price_per_1_BTC_in_fiat.'</td>';
							//Not showing buy button and new offer to the owner
							if ($current_user_id != $user_id) {
								$output.='<td>'.$currency_sign.' '.'<input type="text" class="form-controller" id="new_offer" name="new_offer" required></td>'.
								'<td><button class="btn btn-success" id="buy_offer" type="submit">Buy</button></td>';
							} else {
								$output.='<td></td>'.
								'<td></td>';
							}

						$output.='</tr>';
					}
					return Response($output);
			   	}
		}

	}


}


