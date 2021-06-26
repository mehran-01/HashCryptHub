@extends('layouts.app')

@section('content')
  
  <div class="container">
      <div class="row justify-content-center">
          <div class="card">
              <div class="card-header">Add an offer</div>

              <div class="card-body">
                  <div class="container">

                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <br /> 
                    @endif
                    <form method="post" action="{{ route('offers.store') }}">
                        @csrf
                        <div class="form-group">    
                            <label for="fiat_currency">Fiat Currency:</label>
                            <select class="form-control" id="fiat_currency" name="fiat_currency">
                              <option value="USD">USD</option>
                              <option value="EURO">EURO</option>
                              <option value="GBP">GBP</option>
                              <option value="NGN">NGN</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="payment_method">Payment Method:</label>
                            <select class="form-control" id="payment_method" name="payment_method">
                              <option value="amazon gift card">Amazon gift card</option>
                              <option value="walmart gift card">Walmart gift card</option>
                              <option value="paypal">Paypal</option>
                              <option value="skrill">Skrill</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="min_amount">Min Amount:</label>
                            <div class="input-group mb-3">
                              <div class="input-group-prepend">
                                <span class="input-group-text" id="currency_sign_min_amount">$</span>
                              </div>
                              <input type="text" class="form-control" name="min_amount" id="min_amount" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="max_amount">Max Amount:</label>
                            <div class="input-group mb-3">
                              <div class="input-group-prepend">
                                <span class="input-group-text" id="currency_sign_max_amount">$</span>
                              </div>
                              <input type="text" class="form-control" name="max_amount" id="max_amount" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="margin_percentage">Margin Percentage:</label>
                            <div class="input-group mb-3">
                              <div class="input-group-prepend">
                                <span class="input-group-text">%</span>
                              </div>
                              <input type="text" class="form-control" name="margin_percentage" id="margin_percentage" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="final_offer">Final Offer:</label>
                            <div class="input-group mb-3">
                              <div class="input-group-prepend">
                                <span class="input-group-text" id="currency_sign_final_offer">$</span>
                              </div>
                              <input type="text" class="form-control" name="final_offer" id="final_offer"/>
                            </div>
                        </div>                         
                        <button type="submit" class="btn btn-primary-outline">Add offer</button>
                    </form>
                  </div>
              </div>
          </div>
      </div>
  </div>


  <script type="text/javascript">

    $("#fiat_currency").change(function () {;

        $selected_search = $(this).val();

        if ($selected_search == "EURO") {
          $("#currency_sign_min_amount").text("€");
          $("#currency_sign_max_amount").text("€");
          $("#currency_sign_final_offer").text("€");
        } else if($selected_search == "GBP"){
          $("#currency_sign_min_amount").text("£");
          $("#currency_sign_max_amount").text("£");
          $("#currency_sign_final_offer").text("£");
        } else if($selected_search == "NGN"){
          $("#currency_sign_min_amount").text("₦");
          $("#currency_sign_max_amount").text("₦");
          $("#currency_sign_final_offer").text("₦");
        } else {
          $("#currency_sign_min_amount").text("$");
          $("#currency_sign_max_amount").text("$");
          $("#currency_sign_final_offer").text("$");
        }
        
    })


    $('#margin_percentage').change(function() {

      $('#final_offer').val(calculateFinalValue());

    });


    $('#fiat_currency').change(function() {

      $('#final_offer').val(calculateFinalValue());

    });


    
    function calculateFinalValue(){

      $BTN = <?php echo json_encode($BTN) ?>;

      $converted_currency = <?php echo json_encode($converted_currency) ?>;

      $fiat_currency = $('#fiat_currency').val();

      $margin_percentage = $('#margin_percentage').val()/100;

      //Offer price = OFFER OWNER’S MARGIN (%) * BITCOIN CURRENT MARKET PRICE (USD) * RATE OF SELECTED CURRENCY.    
      $final_offer = $margin_percentage*$BTN*$converted_currency[$fiat_currency];

      return parseFloat($final_offer).toFixed(2);

    }

  </script>

@endsection
