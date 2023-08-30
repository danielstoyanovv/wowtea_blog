<?php

namespace App\Http\Controllers\Admin\Checkout;

use App\Http\Controllers\Controller;
use Database\Factories\PaymentApisResponseHistoryFactory;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Illuminate\Http\RedirectResponse;

class TestPaypalController extends Controller
{
    const REDIRECT_ACTION = 'admin_test_paypal_page';

    /**
     * @return Application|Factory|View
     */
    public function index(): Factory|View|Application
    {
        return view('admin.checkout.testPaypal');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws \Throwable
     */
    public function payment(Request $request): RedirectResponse
    {
        if($request->getMethod() == "POST") {
            try {
                $provider = new PayPalClient;
                $provider->setApiCredentials(config('paypal'));
                $paypalToken = $provider->getAccessToken();

                $createOrderParams = [
                    "intent" => "CAPTURE",
                    "application_context" => [
                        "return_url" => route('admin_test_paypal_success'),
                        "cancel_url" => route('admin_test_paypal_cancel'),
                    ],
                    "purchase_units" => [
                        0 => [
                            "amount" => [
                                "currency_code" => "USD",
                                "value" => $request->input('price')
                            ]
                        ]
                    ]
                ];
                $response = $provider->createOrder($createOrderParams);
                PaymentApisResponseHistoryFactory::new([
                    'content' => json_encode($createOrderParams, true),
                    'response' => json_encode($response, true),
                    'method' => 'createOrder',
                    'provider' => 'Paypal',
                    'provider_config' => json_encode(config('paypal'), true)
                ])->create();
                if (isset($response['id']) && $response['id'] != null) {
                    // redirect to approve href
                    foreach ($response['links'] as $links) {
                        if ($links['rel'] == 'approve') {
                            return redirect()->away($links['href']);
                        }
                    }
                    return redirect()
                        ->route(self::REDIRECT_ACTION)
                        ->with('message', __('Something went wrong.'));
                } else {
                    return redirect()
                        ->route(self::REDIRECT_ACTION)
                        ->with('message', $response['message'] ?? __('Something went wrong.'));
                }
            } catch (\Exception $exception) {
                Log::error($exception->getMessage());
            }
        }

        return redirect()
            ->route(self::REDIRECT_ACTION);
    }

    /**
     * success transaction.
     * @param Request $request
     * @return RedirectResponse
     */
    public function successTransaction(Request $request): RedirectResponse
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);
        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            return redirect()
                ->route(self::REDIRECT_ACTION)
                ->with('message', __('Transaction complete.'));
        } else {
            return redirect()
                ->route(self::REDIRECT_ACTION)
                ->with('message', $response['message'] ?? __('Something went wrong.'));
        }
    }

    /**
     * cancel transaction.
     * @param Request $request
     * @return RedirectResponse
     */
    public function cancelTransaction(Request $request): RedirectResponse
    {
        return redirect()
            ->route(self::REDIRECT_ACTION)
            ->with('message', $response['message'] ?? __('You have canceled the transaction.'));
    }
}
