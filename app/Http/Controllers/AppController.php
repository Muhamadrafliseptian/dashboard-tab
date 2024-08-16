<?php

namespace App\Http\Controllers;

use App\Http\Helper\ApiHelper;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppController extends Controller
{
    public function templating()
    {
        return view("pages.layouts.main");
    }

    public function checkKomersil(Request $request)
    {
        try {

            DB::beginTransaction();

            $client = new Client([
                "timeout" => 10
            ]);

            $data = [
                "code" => $request->code,
                "add_on_user" => intval($request->add_on_user),
                "member_account_code" => $request->member_account_code
            ];

            if ($data["code"] === "01" || $data["code"] === "02" || $data["code"] === "03" || $data["code"] === "04") {
                $url = "/organization/payment/check_price_komersil";
                $code = [
                    "code" => $data["code"]
                ];
                $limit_user = [     
                    "limit_user" => intval($request->limit_user)
                ];
                $data = array_merge($data, $limit_user);

                $data = array_merge($data, $code);
            } else {
                $url = "/organization/payment/check_price_pendidikan";
                $limit_user = [     
                    "limit_user" => intval($request->limit_user)
                ];
                $data = array_merge($data, $limit_user);
            }

            $response = $client->post(
                ApiHelper::apiUrl($url),
                [
                    "json" => $data,
                    'headers' => [
                        'Content-Type' => 'application/json'
                    ]
                ]
            );


            $responseBody = json_decode($response->getBody(), true);

            DB::commit();

            if($data["code"] === "1" || $data["code"] === "2" || $data["code"] === "3"){
                return response()->json([
                    "status" => true,
                    "message" => "Data Berhasil di Tampilkan 1",
                    "data" => $responseBody["data"]
                ]);
            } else {
                return response()->json([
                    "status" => true,
                    "message" => "Data Berhasil di Tampilkan 2",
                    "data" => $responseBody["addOnUser"]
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

    public function checkPriceKomersil(Request $request)
    {
        try {

            DB::beginTransaction();

            $client = new Client([
                "timeout" => 10
            ]);

            $data = [
                "code" => $request->code,
                "limit_user" => intval($request->limit_user),
                "member_account_code" => $request->member_account_code,
                "durationDate" => intval($request->durationDate)
            ];

            $response = $client->post(
                ApiHelper::apiUrl("/organization/payment/check_price_komersil"),
                [
                    "json" => $data,
                    'headers' => [
                        'Content-Type' => 'application/json'
                    ]
                ]
            );

            $responseBody = json_decode($response->getBody(), true);

            DB::commit();

            return response()->json([
                "status" => true,
                "message" => "Data Berhasil di Tampilkan",
                "data" => $responseBody["extendsPaket"]
            ]);
        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                "status" => false,
                "mesage" => $e->getMessage()
            ]);
        }
    }

    public function checkPricePaket(Request $request)
    {
        try {

            DB::beginTransaction();

            $client = new Client([
                "timeout" => 10
            ]);

            if ($request->code === "1" || $request->code === "2" || $request->code === "3") {
                $apiUrl = "/organization/payment/check_price_pendidikan";

                $data = [
                    "code" => intval($request->code),
                    "member_account_code" => $request->member_account_code,
                    "limit_user" => intval($request->limituser)
                ];
            } else {
                $apiUrl = "/organization/payment/check_price_komersil";

                $data = [
                    "code" => $request->code,
                    "limit_user" => intval($request->limituser),
                    "member_account_code" => $request->member_account_code,
                    "durationDate" => intval($request->durationDate)
                ];
            }

            $response = $client->post(
                ApiHelper::apiUrl($apiUrl),
                [
                    "json" => $data,
                    'headers' => [
                        'Content-Type' => 'application/json'
                    ]
                ]
            );

            $responseBody = json_decode($response->getBody(), true);

            DB::commit();

            return response()->json([
                "status" => true,
                "message" => "Data Berhasil di Tampilkan",
                "data" => $request->code === "1" || $request->code === "2" || $request->code === "3" ? $responseBody["data"] : $responseBody["extendsPaket"]
            ]);
        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ]);
        }
    }

    public function dashboard()
    {
        try {

            DB::beginTransaction();

            $client = new Client([
                "timeout" => 10
            ]);

            $data = [];

            $responder = $client->get(ApiHelper::apiUrl("/organization/account/responder/" . session("data")["member_account_code"] . "/admin"));
            $user = $client->get(ApiHelper::apiUrl("/organization/account/user/" . session("data")["member_account_code"] . "/admin"));
            $internal = $client->get(ApiHelper::apiUrl("/organization/account/admin/" . session("data")["username"] . "/show"));
            $partner = $client->post(ApiHelper::apiUrl("/organization/partner/" . session("data")["institution_id"] . "/transaction/umum"));

            $internalBody = json_decode($internal->getBody(), true);

            if (session('data')['account_category'] == 'INTERNAL') {
                session(["internal" => $internalBody["data"]]);
            }

            $responderBody = json_decode($responder->getBody(), true);
            $userBody = json_decode($user->getBody(), true);
            $partnerBody = json_decode($partner->getBody(), true);

            DB::commit();

            if ($responderBody["statusCode"] == 200 && $userBody["statusCode"] == 200 && $internalBody["statusCode"] == 200) {

                $data["showDetail"] = $internalBody["data"];

                $data["totalResponder"] = $responderBody["total"];
                $data["totalUser"] = $userBody["total"];
                $data['totalResponderPartner'] = $internalBody["data"]['total_responder_partner'];
                $data['totalTransaksiPartnerUmum'] = $partnerBody["total"];

                return view("pages.dashboard", $data);
            } else {
                return response()->json([
                    "status" => false,
                    "message" => $responderBody["message"]
                ]);
            }
        } catch (\Exception $e) {

            DB::rollBack();

            return redirect()->route("pages.dashboard")->with("error", $e->getMessage());
        }
    }

    public function pembayaranInternal(Request $request)
    {
        try {

            DB::beginTransaction();

            $data = [
                "limit_user" => intval($request->limit_user),
                "amount" => $request->amount,
            ];

            $client = new Client([
                "timeout" => 10
            ]);

            $response = $client->post(
                ApiHelper::apiUrl("/organization/account/admin/" . $request->member_account_code . "/add_on_user/internal"),
                [
                    "json" => $data,
                    'headers' => [
                        'Content-Type' => 'application/json'
                    ]
                ]
            );

            $responseBody = json_decode($response->getBody(), true);

            DB::commit();

            session(["payment_url" => $responseBody["paymentUrl"]["url"]]);
            session(['external_id' => $responseBody["external_id"]]);

            return response()->json([
                "status" => true,
                "message" => $responseBody["message"]
            ]);
        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ]);
        }
    }
}
