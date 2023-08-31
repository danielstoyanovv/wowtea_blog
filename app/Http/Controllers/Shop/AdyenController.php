<?php

namespace App\Http\Controllers\Shop;

use Adyen\Client;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Adyen\Service\Recurring;
use GuzzleHttp\Client as GuzzleHttp;


class AdyenController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function webhook(Request $request)
    {
     //   Log::info($request->all());
   //     Log::info($request->getContent());
        $notification = json_decode($request->getContent(), true);
        var_dump($notification["notificationItems"][0]["NotificationRequestItem"]["eventCode"]);
        if ($notification["notificationItems"][0]["NotificationRequestItem"]["eventCode"] === "RECURRING_CONTRACT") {
            $shopperReference = $notification["notificationItems"][0]["NotificationRequestItem"]["additionalData"]["shopperReference"];
            $storedPaymentMethodId = $notification["notificationItems"][0]["NotificationRequestItem"]["additionalData"]['recurring.recurringDetailReference'];
            $recurringDetailReference = $notification["notificationItems"][0]["NotificationRequestItem"]["additionalData"]['recurring.recurringDetailReference'];
            $recurringProcessingModel = "Subscription";
            $client = new Client();
            $client->setApplicationName('Test Application');
            $client->setEnvironment(\Adyen\Environment::TEST);
            $client->setXApiKey("AQElhmfuXNWTK0Qc+iSRhmsokOuMfI5MdedSRQDHo4p3kmBQNtLDfhDBXVsNvuR83LVYjEgiTGAH-nBcqxoUAk+HxWxosXyS7AC4GeaivP5prQOa+FYV/qRo=-fI<xYgxXMB(HEun7");

            $recurring = new Recurring($client);

            $paymentData = [
                'permit' => true,
                "shopperReference" => $shopperReference,
                "shopperInteraction" => "Ecommerce",

                'merchantAccount' => "AtopWowTeaECOM",
                "reference" => "100",
                "amount" => [
                    "currency" => "USD",
                    "value" => 2000
                ],
                "paymentMethod" => [
                    "type" => "scheme",
                    "storedPaymentMethodId" => $storedPaymentMethodId
                ],
                "recurring" => [
                    "contract" => "RECURRING",
                    "recurringDetailReference" => $recurringDetailReference,
                    "recurringProcessingModel" => $recurringProcessingModel,
//                    "frequency" => "daily"
                    "frequency" => "hourly"
                ]
            ];
            $response = $recurring->listRecurringDetails($paymentData);
//
            $client = new GuzzleHttp();
            $response = $client->post('https://pal-test.adyen.com/pal/servlet/Recurring/v68/scheduleAccountUpdater', [
                'headers' => [
                    'x-api-key' => "AQElhmfuXNWTK0Qc+iSRhmsokOuMfI5MdedSRQDHo4p3kmBQNtLDfhDBXVsNvuR83LVYjEgiTGAH-nBcqxoUAk+HxWxosXyS7AC4GeaivP5prQOa+FYV/qRo=-fI<xYgxXMB(HEun7",
                ],
                'json' => [
                    'merchantAccount' => 'AtopWowTeaECOM',
                    "reference" => session('adyen_next_payment_reference'),
                    "card" => [
                        "expiryMonth" => "03",
                        "expiryYear" => "2030",
                        "holderName" => "Adyen Test",
                        "number" => "4111111111111111"
                    ]
                ],
            ]);
        }
        return response()->json(["[accepted]", 200]);
    }

}
