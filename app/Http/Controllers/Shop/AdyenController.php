<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;


class AdyenController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function webhook(Request $request)
    {

        Log::info($request->all());
        Log::info($request->getContent());
        $notification = json_decode($request->getContent(), true);
        var_dump($notification);
        return response()->json(["[accepted]", 200]);
    }

}
