<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Helper\ApiHelper;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaketController extends Controller
{
    public function index()
    {
        try {

            DB::beginTransaction();

            $data = [];

            $client = new Client([
                "timeout" => 10
            ]);

            $internal = $client->get(ApiHelper::apiUrl("/organization/account/admin/" . session("data")["username"] . "/show"));
            $internalBody = json_decode($internal->getBody(), true);

            if ($internalBody["data"]["detailMembership"]["code"] == "001") {

                $currentPaket = $client->get(ApiHelper::apiUrl("/organization/paket/" . session("data")["member_account_code"] . "/current_paket"));
                $responderCurrentPaket = json_decode($currentPaket->getBody(), true);

                if ($responderCurrentPaket["statusCode"] == 200) {
                    $filteredData = array_filter($responderCurrentPaket["data"], function ($item) {
                        return $item['nama_paket'] !== 'Custom';
                    });

                    $data["code"] = $internalBody["data"]["detailMembership"]["code"];

                    $data["masterpaket"] = $filteredData;
                }
            } else {
                $currentPaket = $client->get(ApiHelper::apiUrl("/organization/paket/komersil/" . $internalBody["data"]["detailMembership"]["code"] . "/detail"));
                $responderCurrentPaket = json_decode($currentPaket->getBody(), true);

                if ($responderCurrentPaket["statusCode"] == 200) {
                    $data["code"] = $internalBody["data"]["detailMembership"]["code"];
                    $data["masterpaket"] = $responderCurrentPaket["data"];
                }
            }

            DB::commit();

            return view("pages.master.paket.index", $data);
        } catch (\Exception $e) {

            DB::rollBack();

            return redirect()->route("/pages/dashboard")->with("error", $e->getMessage());
        }
    }

    public function showData($id_detail, $code)
    {
        try {

            DB::beginTransaction();

            $data = [];

            $client = new Client([
                "timeout" => 10
            ]);

            $internal = $client->get(ApiHelper::apiUrl("/organization/paket/" . $id_detail . "/detail_paket_organization"));
            $internalBody = json_decode($internal->getBody(), true);

            $saatIni = $client->get(ApiHelper::apiUrl("/organization/account/admin/" . session("data")["username"] . "/show"));
            $saatIniBody = json_decode($saatIni->getBody(), true);

            $data["paketSaatIni"] = $internalBody["data"];
            
            $data["saatIni"] = $saatIniBody["data"];
            $data["code"] = $code;

            $data["detail"] = $id_detail;

            DB::commit();

            return view("pages.master.paket.detail", $data);
        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ]);
        }
    }

    public function store(Request $request)
    {
        try {

            DB::beginTransaction();

            $client = new Client([
                "timeout" => 10
            ]);

            $data = [
                "idMasterPaket" => intval($request->idMasterPaket),
                "amount" => intval($request->amount),
                "limit_user" => intval($request->limit_user),
                "limit_contact" => intval($request->limit_contact),
                "end_date" => intval($request->end_date)
            ];

            $response = $client->post(
                ApiHelper::apiUrl("/organization/account/admin/" . session("data")["member_account_code"] . "/extends_paket/internal"),
                [
                    "json" => $data,
                    'headers' => [
                        'Content-Type' => 'application/json'
                    ]
                ]
            );

            $responseBody = json_decode($response->getBody(), true);

            DB::commit();

            if ($responseBody["statusCode"] == 201) {
                session(["payment_url" => $responseBody["paymentUrl"]["url"]]);
                session(['external_id' => $responseBody["external_id"]]);

                return response()->json([
                    "status" => true,
                    "message" => "Data Berhasil di Simpan",
                    "data" => $responseBody
                ]);
            } else {
                return response()->json([
                    "status" => false,
                    "message" => $responseBody["message"]
                ]);
            }
        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ]);
        }
    }
}
