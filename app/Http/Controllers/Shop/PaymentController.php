<?php

namespace App\Http\Controllers\Shop;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Adyen\Client;
use Adyen\Service\Checkout;
class PaymentController extends Controller
{
    public function componentsCheckout()
    {
        $client = new \Adyen\Client();
        $client->setApplicationName('Test Application');
        $client->setEnvironment(\Adyen\Environment::TEST);
        $client->setXApiKey('AQElhmfuXNWTK0Qc+iSRhmsokOuMfI5MdedSRQDHo4p3kmBQNtLDfhDBXVsNvuR83LVYjEgiTGAH-nBcqxoUAk+HxWxosXyS7AC4GeaivP5prQOa+FYV/qRo=-fI<xYgxXMB(HEun7');


        $checkout = new Checkout($client);

        $paymentMethodsResponse = $checkout->paymentMethods([
            'countryCode' => 'US',
            'merchantAccount' => 'AtopWowTeaECOM'
        ]);

        return view('components-checkout', compact('paymentMethodsResponse'));

    }

    public function pay2()
    {
        $client = new \Adyen\Client();
        $client->setEnvironment(\Adyen\Environment::TEST);
        $client->setXApiKey("AQElhmfuXNWTK0Qc+iSRhmsokOuMfI5MdedSRQDHo4p3kmBQNtLDfhDBXVsNvuR83LVYjEgiTGAH-nBcqxoUAk+HxWxosXyS7AC4GeaivP5prQOa+FYV/qRo=-fI<xYgxXMB(HEun7");
        $service = new \Adyen\Service\Checkout($client);

        $params = array(
            "paymentMethod" => array(
                "type" => "scheme",
                "encryptedCardNumber" => "test_4111111111111111",
                "encryptedExpiryMonth" => "test_03",
                "encryptedExpiryYear" => "test_2030",
                "encryptedSecurityCode" => "test_737"
            ),
            "amount" => array(
                "currency" => "EUR",
                "value" => 1000
            ),
            "reference" => "123",
            "returnUrl" => route("pay.success"),
            "merchantAccount" => "AtopWowTeaECOM"
        );
        $result = $service->payments($params);



    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Mollie\Api\Exceptions\ApiException
     */
    public function pay()
    {
        try {
            $client = new \Adyen\Client();
            $client->setApplicationName('Test Application');
            $client->setEnvironment(\Adyen\Environment::TEST);
            $client->setXApiKey('AQElhmfuXNWTK0Qc+iSRhmsokOuMfI5MdedSRQDHo4p3kmBQNtLDfhDBXVsNvuR83LVYjEgiTGAH-nBcqxoUAk+HxWxosXyS7AC4GeaivP5prQOa+FYV/qRo=-fI<xYgxXMB(HEun7');
            $service = new \Adyen\Service\Checkout($client);
            $params = array(
                'amount' => array(
                    'currency' => 'EUR',
                    'value' => 1000
                ),
          //      'sdkVersion' => '13.0.5',
                //'token' => 'CRED4224T223225S5J8XTRRFG64JG3',
           //     'channel' => 'Web',
                'countryCode' => 'NL',
                'merchantAccount' => 'AtopWowTeaECOM',
                'reference' => time(),
                'returnUrl' => route("pay.success")
            );
            $result = $service->sessions($params);

            var_dump($result);
            die;
            echo $result['id'];
            echo "<br >";
            echo $result['sessionData'];

        } catch (\Exception $exception) {
            dd($exception->getMessage());
        }

    }

    public function paySuccess(Request $request)
    {
        // Handle successful payment here (e.g., mark order as paid)
        return 'Payment successful!';
    }

    public function testCheckout()
    {
        return view('test-checkout');
    }
}

