<?php

namespace App\Http\Controllers\Admin\Checkout;

use App\Http\Controllers\Controller;
use Database\Factories\PaymentApisResponseHistoryFactory;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
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
     * @return RedirectResponse
     */
    public function subscription(Request $request): RedirectResponse
    {
        if ($request->getMethod() == "POST") {
            try {
                $adyenClientConfig = [
                    "application_name" => "Test Application",
                    "environment" => \Adyen\Environment::TEST,
                    "x-api-key" => "AQElhmfuXNWTK0Qc+iSRhmsokOuMfI5MdedSRQDHo4p3kmBQNtLDfhDBXVsNvuR83LVYjEgiTGAH-nBcqxoUAk+HxWxosXyS7AC4GeaivP5prQOa+FYV/qRo=-fI<xYgxXMB(HEun7"
                ];

                $client = new Client();
                $client->setApplicationName($adyenClientConfig["application_name"]);
                $client->setEnvironment($adyenClientConfig["environment"]);
                $client->setXApiKey($adyenClientConfig["x-api-key"]);

                $service = new \Adyen\Service\Checkout($client);

                $params = [
                    "amount" => [
                        "currency" => "USD",
                        "value" => 0
                    ],
                    "reference" => uniqid(),
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

                PaymentApisResponseHistoryFactory::new([
                    'content' => json_encode($params, true),
                    'response' => json_encode($result, true),
                    'method' => 'subscription',
                    'provider' => 'Adyen',
                    'provider_config' => json_encode($adyenClientConfig, true)
                ])->create();

                $storedPaymentMethodId = $result['additionalData']['recurring.recurringDetailReference'];

                Log::info($result['additionalData']['recurring.shopperReference']);
                Log::info($result['additionalData']['recurring.recurringDetailReference']);
                Log::info($result['pspReference']);

                $service = new \Adyen\Service\Checkout($client);

                $nextPaymentReference = uniqid();

                $params = [
                    "amount" => [
                        "currency" => "USD",
                        "value" => 2000
                    ],
                    "reference" => $nextPaymentReference,
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

                PaymentApisResponseHistoryFactory::new([
                    'content' => json_encode($params, true),
                    'response' => json_encode($result, true),
                    'method' => 'subscription',
                    'provider' => 'Adyen',
                    'provider_config' => json_encode($adyenClientConfig, true)
                ])->create();

                session()->flash('message', __('Subscription was created'));
            } catch (AdyenException $exception) {
                Log::error($exception->getCode());
                Log::error($exception->getFile());
                Log::error($exception->getLine());
                Log::error($exception->getMessage());
            }
        }
        return redirect()->action([self::class, 'index']);
    }
}
