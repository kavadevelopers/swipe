<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Swipe Join Member</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="container" id="before"> 
            <div class="row">
                <div class="col-sm-12">
                    <div class="jumbotron text-center">
                        <h1>Pay to Continue</h1>
                    </div>
                </div>
            </div>
            
  
            <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-4">
                    <button class="btn btn-success btn-block" onclick="pay(50)">Pay now</button>
                </div>
                <div class="col-md-4"></div>
            </div>
        </div>

        <div class="container" id="after" style="display: none;">
            <div class="row">
                <div class="col-md-12"><pre id="token_response"></pre></div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="jumbotron text-center">
                        <h1>Payment Successfull Thankyou</h1>
                    </div>
                </div>
            </div>
        </div>
        


        <script src="https://checkout.stripe.com/checkout.js"></script>
        <script type="text/javascript">
            $(document).ready(function () {  
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
            });
  
            function pay(amount) {
                var handler = StripeCheckout.configure({
                    key: '<?= env("STRIPE_SECRET") ?>', // your publisher key id
                    locale: 'auto',
                    token: function (token) {
                        $('#before').hide();
                        $('#after').show();
                        // You can access the token ID with `token.id`.
                        // Get the token ID to your server-side code for use.
                        // console.log('Token Created!!');
                        // console.log(token);
                        // $('#token_response').html(JSON.stringify(token));
          
                        $.ajax({
                            url: '{{ route("stripe.post") }}',
                            method: 'post',
                            data: { tokenId: token.id, amount: amount ,uid:'<?= $uid ?>'},
                            success: (response) => {
                  
                                //console.log(response);
                  
                            },
                            error: (error) => {
                                // console.log(error);
                                // alert('There is an error in processing.')
                            }
                        });
                    }
                });
   
                handler.open({
                  name: 'Swipe',
                  description: 'Pay To Continue',
                  amount: amount * 1500
                });
            }
        </script>
</body>
</html>