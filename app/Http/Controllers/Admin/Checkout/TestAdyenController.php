<?php

namespace App\Http\Controllers\Admin\Checkout;

use App\Http\Controllers\Controller;
use Database\Factories\PaymentApisResponseHistoryFactory;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\RedirectResponse;
use Adyen\Client;
use Adyen\AdyenException;

class TestAdyenController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function index(): Factory|View|Application
    {
        return view('admin.checkout.testAdyen');
    }

    /**
     * @return Application|Factory|View
     */
    public function process(Request $request): Factory|View|Application
    {
        if ($request->getMethod() == "POST") {
            var_dump($request->input('countries'));
            var_dump($request->input('payment_methods'));
            die;
        }
    }

    /**
     * @param Request $request
     * @return Application|ResponseFactory|Response
     */
    public function subscription(Request $request): Application|ResponseFactory|Response
    {
        if ($request->getMethod() == "POST") {
            try {
                $client = new Client();
                $client->setApplicationName('Test Application');
                $client->setEnvironment(\Adyen\Environment::TEST);
                $client->setXApiKey("AQElhmfuXNWTK0Qc+iSRhmsokOuMfI5MdedSRQDHo4p3kmBQNtLDfhDBXVsNvuR83LVYjEgiTGAH-nBcqxoUAk+HxWxosXyS7AC4GeaivP5prQOa+FYV/qRo=-fI<xYgxXMB(HEun7");

                $service = new \Adyen\Service\Checkout($client);

                $reference = rand(2, 4);

                $params = [
                    "amount" => [
                        "currency" => "USD",
                        "value" => 0
                    ],
                    "reference" => $reference,
                    "paymentMethod" => [
                        "type" => "scheme",
                        "encryptedCardNumber" => "test_4111111111111111",
                        "encryptedExpiryMonth" => "test_03",
                        "encryptedExpiryYear" => "test_2030",
                        "encryptedSecurityCode" => "test_737",
                        "holderName" => "Test Test"
                    ],
                    "storePaymentMethod" => true,
                    "shopperInteraction" => "Ecommerce",
                    "recurringProcessingModel" => "Subscription",
                    "merchantAccount" => "AtopWowTeaECOM",
                    "shopperReference" => "680",
                    "returnUrl" => route("home")
                ];
                $result = $service->payments($params);

                $shopperReference = $result['additionalData']['recurring.shopperReference'];
                $recurringDetailReference = $result['additionalData']['recurring.recurringDetailReference'];
                $recurringProcessingModel = $result['additionalData']['recurringProcessingModel'];
                $storedPaymentMethodId = $result['additionalData']['recurring.recurringDetailReference'];

                var_dump($result['additionalData']['recurring.shopperReference']);
                var_dump($result['additionalData']['recurring.recurringDetailReference']);
                var_dump($result['pspReference']);

                echo "<pre>";
                print_r($result);

                $service = new \Adyen\Service\Checkout($client);

                $params = [
                    "amount" => [
                        "currency" => "USD",
                        "value" => 2000
                    ],
                    "reference" => $reference + 1,
                    "paymentMethod" => [
                        "type" => "scheme",
                        "storedPaymentMethodId" => $storedPaymentMethodId
                    ],
                    "returnUrl" => route("home"),
                    "shopperInteraction" => "ContAuth",
                    "recurringProcessingModel" => "Subscription",
                    "merchantAccount" => "AtopWowTeaECOM",
                    "shopperReference" => "680"
                ];

                $result = $service->payments($params);
            } catch (AdyenException $exception) {
                var_dump($exception->getCode());
                var_dump($exception->getFile());
                var_dump($exception->getLine());
                dd($exception->getMessage());
            }
        }
        return response(null,204);
    }
}
