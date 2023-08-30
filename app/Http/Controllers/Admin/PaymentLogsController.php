<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentHistory;
use App\Models\PaymentApisResponseHistory;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class PaymentLogsController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function paymentsHistory(): Factory|View|Application
    {
        return view('admin.paymentLogs.paymentsHistory', ['data' => PaymentHistory::paginate(10)]);
    }

    public function paymentsApisResponseHistory(): Factory|View|Application
    {
        return view('admin.paymentLogs.paymentsApisResponseHistory', ['data' => PaymentApisResponseHistory::paginate(10)]);
    }

    public function paymentApisResponseHistoryDetails(PaymentApisResponseHistory $paymentApisResponseHistory): Factory|View|Application
    {
        return view('admin.paymentLogs.paymentApisResponseHistoryDetails', [
            'data' => $paymentApisResponseHistory
        ]);
    }


}
