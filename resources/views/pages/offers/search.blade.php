@extends('layouts.app')

@section('content')


  <div class="container">
    <div class="row justify-content-center">
      <div class="card">
        <div class="card-header">Search for an offer</div>
          <div class="card-body">
              <div class="container">

          
                <div class="form-group">
                  <label for="search" class="col-md-4 control-label">Search:</label>

                    <input type="text" class="form-controller" id="search" name="search"></input>

                    <select id="selected_search" name="selected_search">
                      <option value="final_offer">Final Offer</option>
                      <option value="fiat_currency">Fiat Currency</option>
                      <option value="payment_method">Payment Method</option>
                    </select>

                </div>
              </div>
            </div>
              <table class="table table-bordered table-hover">
                  <thead>
                      <tr>
                        <th>Offer Owner</th>
                        <th>Payment Method</th>
                        <th>Min Amount</th>
                        <th>Max Amount</th>
                        <th>Price per 1 BTC</th>
                        <th>New Offer</th>
                        <th>Buy</th>
                      </tr>
                    </thead>
                  <tbody>
                </tbody>
              </table>
            </div>
          
        
      </div>
  </div>

  <script type="text/javascript">

    $("#selected_search").change(function () {

        $search=$('#search').val();

        $selected_search = $(this).val();
        
        offerSearch($search, $selected_search);
    })



    $('#search').on('keyup',function(){

      $search=$(this).val();

      $selected_search=$('#selected_search').val();

      offerSearch($search, $selected_search);

    })


    function offerSearch($search, $selected_search){

        $.ajax({
          type : 'get',
          url : '/search',
          data:{
            'search':$search,
            'selected_search':$selected_search,
          },
          success:function(data){
            $('tbody').html(data);
          },
          error:function(data){
            alert("Something went wrong!");
          }
        });

    }



    $( "table" ).on( "click", '#buy_offer', function() {

        $trid = $(this).closest('tr'); // table row ID 
        $offer_id=$trid.attr("data-id");
        $trade_offer=$trid.find("input").val();
        if ($trade_offer) {

            $.ajax({
            type : 'post',
            url : '/offer/'+$offer_id+'/buy/'+$trade_offer,
            data: {
              "_token": "{{ csrf_token() }}",
              "offer_id": $offer_id,
              "trade_offer": $trade_offer
            },
            success: function(){
              alert('Your offer has been placed!');
              window.location.reload();
            },
            error: function(){
              alert('Something went wrong!');
              window.location.reload();
            }
          });

        } else {
          alert('Please enter a value for new offer!');
        }


    });







  </script>


@endsection