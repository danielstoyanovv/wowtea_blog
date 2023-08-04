@extends('layouts.app')

@section('content')
    <div id="dropin-container"></div>
    <script src="https://checkoutshopper-test.adyen.com/checkoutshopper/sdk/3.17.0/adyen.js"></script>
    <script>

        const configuration = {
            locale: 'en-US',

            paymentMethodsResponse: {!! json_encode($paymentMethodsResponse) !!},
            onSubmit: (state, dropin) => {
                console.log(state);
                console.log(dropin);t
            },
            'clientKey': 'test_VDKU4GEMBFAZJLAOAJEVTPDGHI73FBSM',
            'mode': 'no-cors'

        };
        const checkout = new AdyenCheckout(configuration);

   //     const dropin = checkout.create('dropin').mount('#dropin-container');

        const dropin = checkout.create('dropin', {
            paymentMethodsConfiguration: {
                card: { // Include other payment methods as needed
                    showPayButton: true
                }
            }
        }).mount('#dropin-container');

        function setFocusOnSecuredFields(dropin) {
            // Example: Set focus on the card number field
            const cardNumberField = dropin.getComponent('securedFields.cardNumber');
            if (cardNumberField) {
                cardNumberField.setFocus();
            }
        }
    </script>
@endsection
