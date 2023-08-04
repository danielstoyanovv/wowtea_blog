@extends('layouts.app')

@section('content')
    <script src="https://checkoutshopper-test.adyen.com/checkoutshopper/sdk/3.17.0/adyen.js"></script>
    <div id="card-container"></div>
<a href="https://test.adyen.link/PLD053A65133063EE7">PAY</a>
    <script>
        // const configuration = {
        //     locale: "en_US", // Set the locale for the component
        //     environment: "test", // Use "test" for testing, "live" for production
        //     originKey: "AQElhmfuXNWTK0Qc+iSRhmsokOuMfI5MdedSRQDHo4p3kmBQNtLDfhDBXVsNvuR83LVYjEgiTGAH-nBcqxoUAk+HxWxosXyS7AC4GeaivP5prQOa+FYV/qRo=-fI<xYgxXMB(HEun7'", // Replace with your origin key from Adyen
        //     paymentMethodsResponse: [], // Provide available payment methods from your server
        //     onSubmit: (state, component) => {
        //         fetch("/submit-payment", {
        //             method: "POST",
        //             headers: {
        //                 "Content-Type": "application/json",
        //             },
        //             body: JSON.stringify(state.data),
        //         })
        //             .then(response => response.json())
        //             .then(data => {
        //                 if (data.success) {
                            // console.log("Payment successful:", data.message);
                        // } else {
                            // console.error("Payment failed:", data.message);
                        // }
                    // })
                    // .catch(error => {
                    //     console.error("Error submitting payment:", error);
                    // });
            // },
        // };

        // Create the AdyenCheckout instance with the provided configuration
        // const checkout = new AdyenCheckout(configuration);

        // Create and mount the Card Component
//        const card = checkout.create("card").mount("#card-container");
    </script>
@endsection
