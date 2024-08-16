<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Http\Helper\ApiHelper;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ResponderController extends Controller
{
    public function indexByAdmin($member_account_code)
    {
        try {

            DB::beginTransaction();

            $data = [];

            $client = new Client([
                "timeout" => 10
            ]);

            $response = $client->get(ApiHelper::apiUrl("/organization/account/responder/" . $member_account_code . "/admin"));
            $detailAdmin = $client->get(ApiHelper::apiUrl("/organization/account/admin/" . session("data")["username"] . "/show"));

            $responseBody = json_decode($response->getBody(), true);
            $responseAdmin = json_decode($detailAdmin->getBody(), true);

            DB::commit();

            if ($responseBody["statusCode"] == 200) {

                $data["responder"] = $responseBody["data"];
                $data["detailMembership"] = $responseAdmin["data"]["detailMembership"];

                return view("pages.account.responder.index", $data);
            } else {
                return redirect()->route("pages.dashboard")->with("error", "Terjadi Kesalahan");
            }

        } catch (\Exception $e) {

            DB::rollBack();

            return redirect()->route("pages.dashboard")->with("error", $e->getMessage());
        }
    }

    public function store(Request $request, $member_account_code)
    {
        try {

            DB::beginTransaction();

            $data = [
                "nama" => $request->nama,
                "country_code" => $request->country_code,
                "phone_number" => $request->phone_number,
                "email" => $request->email,
                "unique_responder_id" => $request->unique_responder_id
            ];

            $response = Http::post(ApiHelper::apiUrl("/organization/account/admin/" . $member_account_code . "/create_responder"), $data);

            DB::commit();

            $responseBody = $response->json();

            if ($responseBody["statusCode"] == 201) {
                return back()->with("success", $responseBody["message"]);
            } else {
                return back()->with("error", $responseBody["message"]);
            }

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with("error", $e->getMessage());
        }
    }

    public function show($username, $org, $id_req_contact)
    {
        try {
            DB::beginTransaction();

            $data = [];

            $client = new Client([
                "timeout" => 10
            ]);


            if ($org == "partner") {
                $response = $client->get(ApiHelper::apiUrl("/request_contact/" . $id_req_contact . "/detail"));
            } else {
                $response = $client->get(ApiHelper::apiUrl("/organization/account/responder/" . $username . "/show"));
            }

            $responseBody = json_decode($response->getBody(), true);

            DB::commit();

            if ($responseBody["statusCode"] == 200) {
                $data["detail"] = $responseBody["data"];
                $data["org"] = $org;

                return view("pages.account.responder.detail", $data);
            } else {
                return redirect()->route("pages.dashboard")->with("error", "Terjadi Kesalahan");
            }


        } catch (\Exception $e) {

            DB::rollBack();

            return redirect()->route("pages.dashboard")->with("error", $e->getMessage());
        }
    }

    public function destroy($idUser, $org)
    {
        try {

            DB::beginTransaction();

            $client = new Client([
                "timeout" => 10
            ]);

            if ($org == "self") {
                $response = $client->delete(ApiHelper::apiUrl("/organization/account/responder/" . $idUser . "/delete/admin"));
            } else if ($org == "partner") {
                $response = $client->delete(ApiHelper::apiUrl("/request_contact/delete/" . $idUser . "/request"));
            }

            $responseBody = json_decode($response->getBody(), true);

            DB::commit();

            if ($responseBody["statusCode"] == 200) {
                return back()->with("success", "Data Berhasil di Hapus");
            } else {
                return back()->with("error", $responseBody["message"]);
            }

        } catch (\Exception $e) {

            DB::rollBack();

            return redirect()->route("pages.dashboard")->with("error", $e->getMessage());
        }
    }

    public function changeStatus(Request $request, $idUser)
    {
        try {

            DB::beginTransaction();


            $data = [];

            $client = new Client([
                "timeout" => 10
            ]);

            if ($request->tipe == "self") {
                $responseData = $client->put(
                    ApiHelper::apiUrl("/organization/account/responder/" . $idUser . "/put/account_status"),
                    [
                        'headers' => [
                            'Content-Type' => 'application/json'
                        ]
                    ]
                );
            } else if ($request->tipe == "partner") {
                $responseData = $client->put(
                    ApiHelper::apiUrl("/request_contact/". $idUser ."/put/status_responder"),
                    [
                        'headers' => [
                            'Content-Type' => 'application/json'
                        ]
                    ]
                );
            }

            $response = json_decode($responseData->getBody(), true);

            DB::commit();

            return response()->json([
                "status" => true,
                "message" => "Data Berhasil di Simpan",
                "data" => $response
            ]);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ]);
        }
    }

    public function updateStatus($username)
    {
        try {

            DB::beginTransaction();

            $response = Http::put(ApiHelper::apiUrl("/organization/account/responder/" . $username . "/put/account_status"));

            DB::commit();

            $responseBody = $response->json();

            if ($responseBody["statusCode"] == 200) {

                return response()->json([
                    "status" => true,
                    "message" => $responseBody["message"]
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
