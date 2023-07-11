<?php
namespace App\Http\Controllers\Shop;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Illuminate\Http\RedirectResponse;

class PayPalController extends Controller
{
    const REDIRECT_ACTION = 'shop-products';

    /**
     * process transaction.
     * @param Request $request
     * @return RedirectResponse
     */
    public function processTransaction(Request $request): RedirectResponse
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();
        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('successTransaction'),
                "cancel_url" => route('cancelTransaction'),
            ],
            "purchase_units" => [
                0 => [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => $request->input('price')
                    ]
                ]
            ]
        ]);
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
