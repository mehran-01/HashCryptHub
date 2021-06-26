@extends('layouts.app')

@section('content')


  <div class="container">
      <div class="row justify-content-center">
          <div class="card">
              <div class="card-header">Offers</div>
            
              <div>
                <a style="margin: 19px;" href="{{ route('offers.create')}}" class="btn btn-primary">New offer</a>
              </div>

              <div class="card-body">
                 <div class="container">
                    <table class="table table-striped">
                      <thead>
                          <tr>
                            <td>Offer Owner</td>
                            <td>Fiat Currency</td>
                            <td>Payment Method</td>
                            <td>Min Amount</td>
                            <td>Max Amount</td>
                            <td>BTN Offer</td>
                            <td>Final Fiat Offer</td>
                            <td colspan = 2>Actions</td>
                            <td>Status</td>
                          </tr>
                      </thead>
                      <tbody>
                          @foreach($offers as $offer)
                          <?php $user_name = App\User::where('id',$offer->owner_user_id)->value('name'); ?>
                          <tr>
                              <td>{{$user_name}}</td>
                              <td>{{$offer->fiat_currency}}</td>
                              <td>{{$offer->payment_method}}</td>
                              <td>{{$offer->min_amount}}</td>
                              <td>{{$offer->max_amount}}</td>
                              <td>{{$BTN*$offer->margin_percentage}}</td>
                              <td>{{$offer->final_offer }}</td>
                              <td>
                                  <a href="{{ route('offers.edit',$offer->id)}}" class="btn btn-primary">Edit</a>
                              </td>
                              <td>
                                  <form action="{{ route('offers.destroy', $offer->id)}}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger" type="submit">Delete</button>
                                  </form>
                              </td>
                              <td>  
                                
                                <?php //echo $offer->status; ?>

                                <script type="text/javascript">
                                  $( document ).ready(function() {
                                      
                                      $offerStatus = <?php echo json_encode( $offer->status ) ?>;

                                      if ($offerStatus == 1) {
                                        $('#offer-status-<?php echo $offer->id; ?>').bootstrapToggle('on');
                                      } else {
                                        $('#offer-status-<?php echo $offer->id; ?>').bootstrapToggle('off');
                                      }

                                      $("#offer-status-<?php echo $offer->id; ?>").change(function(){

                                            if($(this).prop("checked") == true){
                                               $.ajax({
                                                    url: '/offers/'+{{ $offer->id }}+'/status/1',
                                                    type: 'get',
                                                    success: alert("Offer Enabled!")
                                                }); 

                                            } else {
                                                $.ajax({
                                                    url: '/offers/'+{{ $offer->id }}+'/status/0',
                                                    type: 'get',
                                                    success: alert("Offer Disabled!")

                                                }); 
                                            }
                                      });

                                  });

                                  $.ajaxSetup({
                                      headers: {
                                          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                      }
                                  });


                                </script>

                                <input type="checkbox" data-toggle="toggle" id="offer-status-<?php echo $offer->id; ?>" data-on="Enabled" data-off="Disabled" data-onstyle="success" data-offstyle="warning">

                              </td>
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

@endsection