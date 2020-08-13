<script src="https://js.stripe.com/v3/"></script>
<script>
    var stripe = Stripe('{!!env("STRIPE_KEY")!!}');
    var clientSecret = "{!! $paymentIntent !!}"

    var elements = stripe.elements();
        var style = {
        base: {
            color: "#32325d",
        }
    };

    var card = elements.create("card", { style: style });
</script>
<form id="payment-form">
    <div id="card-element">
      <!-- Elements will create input elements here -->
    </div>
  
    <!-- We'll put the error messages in this element -->
    <div id="card-errors" role="alert"></div>
  
    <button id="submit">Pay</button>
</form>
<script>
    card.mount("#card-element");
    // cardElement.on('change', function(event) {
    //     var displayError = document.getElementById('card-errors');
    //     if (event.error) {
    //         displayError.textContent = event.error.message;
    //     } else {
    //         displayError.textContent = '';
    //     }
    // });
    var form = document.getElementById('payment-form');

    form.addEventListener('submit', function(ev) {
    ev.preventDefault();
    stripe.confirmCardPayment(clientSecret, {
        payment_method: {
        card: card,
        billing_details: {
            name: '{!! $partner->name !!}'
        }
        }
    }).then(function(result) {
        if (result.error) {
        // Show error to your customer (e.g., insufficient funds)
        console.log(result.error.message);
        } else {
        // The payment has been processed!
            console.log(result);
        if (result.paymentIntent.status === 'succeeded') {
            console.log(result);
            
            // Show a success message to your customer
            // There's a risk of the customer closing the window before callback
            // execution. Set up a webhook or plugin to listen for the
            // payment_intent.succeeded event that handles any business critical
            // post-payment actions.
        }
        }
    });
    });
</script>