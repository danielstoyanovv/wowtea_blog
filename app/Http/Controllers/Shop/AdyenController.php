<?php

namespace App\Http\Controllers\Shop;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Adyen\Client;
use Adyen\Service\Checkout;

class AdyenController extends Controller
{

    public function showCheckout()
    {
        try {
            $client = new \Adyen\Client();
            $client->setApplicationName('Test Application');
            $client->setEnvironment(\Adyen\Environment::TEST);
            $client->setXApiKey('AQElhmfuXNWTK0Qc+iSRhmsokOuMfI5MdedSRQDHo4p3kmBQNtLDfhDBXVsNvuR83LVYjEgiTGAH-nBcqxoUAk+HxWxosXyS7AC4GeaivP5prQOa+FYV/qRo=-fI<xYgxXMB(HEun7');


            $checkout = new Checkout($client);

            $paymentMethodsResponse = $checkout->paymentMethods([
                'countryCode' => 'US',
                'merchantAccount' => 'AtopWowTeaECOM'
            ]);
        } catch (\Exception $exception) {
            dd($exception->getMessage());
        }


        return view('test-checkout', compact('paymentMethodsResponse'));
    }

    public function makePayment(Request $request)
    {
        $client = new Client();
        $client->setXApiKey(config('adyen.apiKey'));

        $checkout = new Checkout($client);

        $paymentData = $request->input('paymentData');
        // Other payment-related parameters...

        $paymentResponse = $checkout->payments([
            'paymentData' => $paymentData,
            // Other payment-related parameters...
        ]);

        // Handle payment response and redirect or display success/failure to user...
    }

}

