<?php

namespace App\Http\Controllers\Transaksi;

use App\Http\Controllers\Controller;
use App\Http\Helper\ApiHelper;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HistoryPaymentPartnerController extends Controller
{
    public function index()
    {
        try {

            DB::beginTransaction();

            $data = [];

            $client = new Client([
                "timeout" => 10
            ]);

            $resUmum = $client->post(ApiHelper::apiUrl("/organization/partner/" . session("data")["institution_id"] . "/transaction/umum"));
            $responseBodyUmum = json_decode($resUmum->getBody(), true);

            $resOrganisasi = $client->post(ApiHelper::apiUrl("/organization/partner/" . session("data")["institution_id"] . "/transaction"));
            $responseBodyOrganisasi = json_decode($resOrganisasi->getBody(), true);


            $transUmum = $client->post(ApiHelper::apiUrl("/organization/partner/" . session("data")["institution_id"] . "/transaction/organisasi/umum"));
            $responseBodyUmum = json_decode($transUmum->getBody(), true);


            $transOrg = $client->post(ApiHelper::apiUrl("/organization/partner/" . session("data")["institution_id"] . "/transaction/organisasi"));
            $responseBodyOrganisasi = json_decode($transOrg->getBody(), true);

            DB::commit();

            if ($responseBodyUmum["statusCode"] == 200 && $responseBodyOrganisasi["statusCode"] == 200) {
                $data["umum"] = $responseBodyUmum["data"];
                $data["organisasi"] = $responseBodyOrganisasi["data"];


                $data["trans_umum"] = $responseBodyUmum["data"];
                $data["trans_organisasi"] = $responseBodyOrganisasi["data"];
            }

            return view("pages.transaksi.history-payment-partner.index", $data);

        } catch (\Exception $e) {

            DB::rollBack();

            return redirect()->route("pages.dashboard")->with("error", $e->getMessage());
        }
    }
}
