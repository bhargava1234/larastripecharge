@extends('layouts.app');
@section('main');

<div class="container">
    <div class="card">
        <div class="container-fliud">
            <div class="wrapper row">
                <div class="preview col-md-6">
                    
                    <div class="preview-pic tab-content">
                      <div class="tab-pane active" id="pic-1"><img src="https://dummyimage.com/450x500/dee2e6/6c757d.jpg" /></div>
                   
                    </div>
                   
                    
                </div>
                <div class="details col-md-6">
                    <h3 class="product-title">{{$product['name']}}</h3>
                    
                    <p class="product-description">{{$product['description']}}</p>
                    <h4 class="price">current price: <span>${{$product['price']}}</span></h4>

                    <form action="{{route('processPayment', [$product, $product['price']])}}" method="POST" id="subscribe-form">
                          
                            <label for="card-holder-name">Card Holder Name</label>
                            <input id="card-holder-name" type="text" value="{{$user->name}}" disabled>
                            @csrf
                            <div class="form-row">
                                <label for="card-element">Credit or debit card</label>
                                <div id="card-element" class="form-control">   </div>
                                <!-- Used to display form errors. -->
                                <div id="card-errors" role="alert"></div>
                            </div>
                            <div class="stripe-errors"></div>
                            @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    @foreach ($errors->all() as $error)
                                    {{ $error }}<br>
                                    @endforeach
                                </div>
                            @endif
                            <br>
                            <br>
                            <div class="form-group text-center">
                               <button type="button"  id="card-button" data-secret="{{ $intent->client_secret }}" class="btn btn-lg btn-success btn-block">Pay Now</button>
                            </div>
                    </form>

                    <script src="https://js.stripe.com/v3/"></script>
<script>
    var stripe = Stripe('{{ env('STRIPE_KEY') }}');
    var elements = stripe.elements();
    var style = {
        base: {
            color: '#32325d',
            fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
            fontSmoothing: 'antialiased',
            fontSize: '16px',
            '::placeholder': {
            color: '#aab7c4'
            }
        },
        invalid: {
            color: '#fa755a',
            iconColor: '#fa755a'
        }
    };

    var card = elements.create('card', {hidePostalCode: true, style: style});
    card.mount('#card-element');
    console.log(document.getElementById('card-element'));
    card.addEventListener('change', function(event) {
    var displayError = document.getElementById('card-errors');
        if (event.error) {
        displayError.textContent = event.error.message;
        } else {
        displayError.textContent = '';
    }
    });
    const cardHolderName = document.getElementById('card-holder-name');
    const cardButton = document.getElementById('card-button');
    const clientSecret = cardButton.dataset.secret;    cardButton.addEventListener('click', async (e) => {
    console.log("attempting");
    const { setupIntent, error } = await stripe.confirmCardSetup(
    clientSecret, {
            payment_method: {
            card: card,
            billing_details: { name: cardHolderName.value }
        }
    }
    );       
     if (error) {
        var errorElement = document.getElementById('card-errors');
        errorElement.textContent = error.message;
    }
    else {
       paymentMethodHandler(setupIntent.payment_method);
    }
    });
    function paymentMethodHandler(payment_method) {
        var form = document.getElementById('subscribe-form');
        var hiddenInput = document.createElement('input');
        hiddenInput.setAttribute('type', 'hidden');
        hiddenInput.setAttribute('name', 'payment_method');
        hiddenInput.setAttribute('value', payment_method);
        form.appendChild(hiddenInput);
        form.submit();
    }
</script>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection