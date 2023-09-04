<?php

namespace App\Http\Controllers\Shop;

use Adyen\Client;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Adyen\Service\Recurring;
use Adyen\AdyenException;
use Database\Factories\WebhookResponseHistoryFactory;


class AdyenController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function webhook(Request $request)
    {
        try {
            $notification = json_decode($request->getContent(), true);
            WebhookResponseHistoryFactory::new([
                'response' => json_encode($notification, true),
                'eventCode' => $notification["notificationItems"][0]["NotificationRequestItem"]["eventCode"],
                'provider' => 'Adyen',
            ])->create();
            if ($notification["notificationItems"][0]["NotificationRequestItem"]["eventCode"] === "RECURRING_CONTRACT") {
                $shopperReference = $notification["notificationItems"][0]["NotificationRequestItem"]["additionalData"]["shopperReference"];
                $storedPaymentMethodId = $notification["notificationItems"][0]["NotificationRequestItem"]["additionalData"]['recurring.recurringDetailReference'];
                $recurringDetailReference = $notification["notificationItems"][0]["NotificationRequestItem"]["additionalData"]['recurring.recurringDetailReference'];
                $recurringProcessingModel = "Subscription";
                $merchantReference = $notification["notificationItems"][0]["NotificationRequestItem"]["merchantReference"];
                $client = new Client();
                $client->setApplicationName('Test Application');
                $client->setEnvironment(\Adyen\Environment::TEST);
                $client->setXApiKey("AQElhmfuXNWTK0Qc+iSRhmsokOuMfI5MdedSRQDHo4p3kmBQNtLDfhDBXVsNvuR83LVYjEgiTGAH-nBcqxoUAk+HxWxosXyS7AC4GeaivP5prQOa+FYV/qRo=-fI<xYgxXMB(HEun7");

                var_dump($shopperReference);
                var_dump($storedPaymentMethodId);
                var_dump($recurringDetailReference);
                var_dump($merchantReference);
                var_dump($recurringProcessingModel);

                $recurring = new Recurring($client);

                $paymentData = [
                    'permit' => true,
                    "shopperReference" => $shopperReference,
                    "shopperInteraction" => "Ecommerce",

                    'merchantAccount' => "AtopWowTeaECOM",
                    "reference" => $merchantReference,
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
                        "frequency" => "daily"
                    ]
                ];
                $response = $recurring->listRecurringDetails($paymentData);
            }
        } catch (AdyenException $exception) {
            var_dump($exception->getCode());
            var_dump($exception->getFile());
            var_dump($exception->getLine());
            dd($exception->getMessage());
        }

        return response()->json(["[accepted]", 200]);
    }

}
