<?php

namespace App\Http\Controllers\Transaksi;

use App\Http\Controllers\Controller;
use App\Http\Helper\ApiHelper;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class HistoryPaymentController extends Controller
{
    public function index()
    {
        try {

            DB::beginTransaction();

            $data = [];

            $client = new Client([
                "timeout" => 10
            ]);

            $resHistoryPayment = $client->get(ApiHelper::apiUrl("/organization/payment/history/" . session("data")["member_account_code"]));
            $responseHistoryPayment = json_decode($resHistoryPayment->getBody(), true);

            DB::commit();

            if ($responseHistoryPayment["statusCode"] == 200) {

                $data["historyPayment"] = $responseHistoryPayment["data"];

                return view("pages.transaksi.history-payment.index", $data);
            } else {
                return redirect()->route("pages.dashboard")->with("error", $responseHistoryPayment["message"]);
            }

        } catch (\Exception $e) {

            DB::rollBack();

            return redirect()->route("pages.dashboard")->with("error", $e->getMessage());
        }
    }
}
