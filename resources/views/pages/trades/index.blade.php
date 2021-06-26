@extends('layouts.app')

@section('content')


  <div class="container">
      <div class="row justify-content-center">
          <div class="card">
              <div class="card-header">Trades</div>

              <div class="card-body">
                 <div class="container">
                    <table class="table table-striped">
                      <thead>
                          <tr>
                            <td>Trade ID</td>
                            <td>Trade Partner</td>
                            <td>Fiat Currency</td>
                            <td>Amount in Fiat</td>
                            <td>Amount in BTC</td>
                            <td>Payment Method</td>
                            <td>Started At</td>
                            <td>Status</td>
                            <td colspan = 2>Actions</td>
                          </tr>
                      </thead>
                      <tbody>

                          @foreach($offers as $offer)
                              <?php
                                $new_offer_by_id = $offer->traded_by_user_id;
                                $trade_by_user_name = App\User::where('id',$new_offer_by_id)->value('name');
                              ?>

                            <tr data-id="{{$offer->id}}">
                                <td>{{$offer->id}}</td>
                                <td>{{$trade_by_user_name}}</td>
                                <td>{{$offer->fiat_currency}}</td>
                                <td>{{$offer->trade_offer }}</td>
                                <?php
                                  $amount_in_BTC = $offer->trade_offer/$converted_currency[$offer->fiat_currency];
                                  $amount_in_BTC = number_format((float)$amount_in_BTC, 8, '.', '')
                                ?>
                                <td id="amount_in_BTC">{{$amount_in_BTC}}</td>
                                <td>{{$offer->payment_method}}</td>
                                <td>{{$offer->updated_at}}</td>
                                <td>{{$offer->trade_status}}</td>
                                <?php
                                  if ($offer->trade_status == "Pending" && $offer->traded_by_user_id != Auth::user()->id) {
                                ?>
                                  <td><button class="btn btn-success" id="sell_trade_offer" type="submit">Sell</button>
                                  </td>
                                  <td><button class="btn btn-danger" id="cancel_trade_offer" type="submit">Cancel</button>
                                  </td>
                                <?php
                                  }  else {
                                ?>
                                  <td></td>
                                  <td></td>
                                <?php    
                                  }
                                ?>
                            </tr>
                          @endforeach
                      </tbody>
                    </table>

                    <div class="col-sm-12">
                      @if(session()->get('success'))
                        <div class="alert alert-success">
                          {{ session()->get('success') }}  
                        </div>
                      @endif
                    </div>

                  </div>
              </div>
          </div>
      </div>
  </div>


  <script type="text/javascript">
    
    $( "table" ).on( "click", '#cancel_trade_offer', function() {

        $trid = $(this).closest('tr'); // table row ID 
        $offer_id=$trid.attr("data-id");


        $.ajax({
          type : 'get',
          url : '/trade/'+$offer_id+'/cancel',
          data: {
            "_token": "{{ csrf_token() }}",
            "offer_id": $offer_id,
          },
          success: function(){
            alert('Your trade has been cancelled!');
            window.location.reload();
          },
          error: function(){
            alert('Something went wrong!');
            window.location.reload();
            }
        });




    });

    $( "table" ).on( "click", '#sell_trade_offer', function() {

        $trid = $(this).closest('tr'); // table row ID 
        $offer_id=$trid.attr("data-id");
        $amount_in_BTC=$trid.find("td[id='amount_in_BTC']").text();


        $.ajax({
          type : 'post',
          url : '/trade/'+$offer_id+'/sell',
          data: {
            "_token": "{{ csrf_token() }}",
            "offer_id": $offer_id,
            "amount_in_BTC": $amount_in_BTC
          },
          success: function(){
            alert('Your BTC has been transferred!');
            window.location.reload();
          },
          error: function(){
            alert('Something went wrong!');
            window.location.reload();
            }
        });




    });

  </script>
@endsection