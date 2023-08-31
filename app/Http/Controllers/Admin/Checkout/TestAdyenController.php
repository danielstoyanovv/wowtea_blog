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
}
