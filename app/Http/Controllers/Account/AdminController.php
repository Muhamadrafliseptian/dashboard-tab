<?php

namespace App\Http\Controllers\Account;

use App\Http\Helper\ApiHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class AdminController extends Controller
{
    public function index()
    {
        try {

            DB::beginTransaction();

            $data = [];

            $masterPaket = Http::timeout(10)->get(ApiHelper::apiUrl("/organization/paket/all"));
            $accountAdmin = Http::timeout(10)->get(ApiHelper::apiUrl("/organization/account/admin/all"));

            if ($masterPaket->successful() && $accountAdmin->successful()) {
                $responseBody = $masterPaket->json();
                $responseBodyAccount = $accountAdmin->json();

                if ($responseBody["statusCode"] == 200 && $responseBodyAccount["statusCode"] == 200) {
                    $data["masterPaket"] = $responseBody["data"];
                    $data["accountAdmin"] = $responseBodyAccount["data"];
                } else {
                    return redirect()->route("pages.dashboard")->with("error", "Terjadi Kesalahan");
                }
            } else {
                return redirect()->route("pages.dashboard")->with("error", "Terjadi Kesalahan");
            }

            DB::commit();

            return view("pages.account.admin.index", $data);
        } catch (\Exception $e) {

            DB::rollBack();

            return redirect()->route("pages.dashboard")->with("error", $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {

            DB::beginTransaction();

            $data = [
                "nama" => $request->nama,
                "country_code" => $request->country_code,
                "phone_number" => $request->phone_number,
                "password" => $request->password,
                "paketOrganization" => [
                    "id_master_paket_organization" => $request->id_master_paket_organization
                ]
            ];

            $response = Http::timeout(10)->post(ApiHelper::apiUrl("/organization/account/admin/create"), $data);

            DB::commit();

            $responseBody = $response->json();

            if ($responseBody["statusCode"] == 201) {
                return back()->with("success", $responseBody["message"]);
            } else {
                return back()->with("error", $responseBody["message"]);
            }
        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with("error", $e->getMessage())->withInput();
        }
    }

    public function show($id)
    {
        try {

            DB::beginTransaction();

            $data = [];
            $member_account_code = "";
            $response = Http::timeout(10)->get(ApiHelper::apiUrl("/organization/account/admin/$id/show"));

            if ($response->successful()) {
                $responseBody = $response->json();

                if ($responseBody["statusCode"] == 200) {
                    $data["detail"] = $responseBody["data"];

                    $member_account_code = $data["detail"]["member_account_code"];
                } else {
                    return redirect()->route("pages.dashboard")->with("error", "Terjadi Kesalahan");
                }
            }

            $responseRemaining = Http::timeout(10)->get(ApiHelper::apiUrl("/organization/payment/" . $member_account_code . "/remaining_duration"));

            if ($responseRemaining->successful()) {
                $responseBodyRemaining = $responseRemaining->json();

                if ($responseBodyRemaining["statusCode"] == 200) {
                    $data["remaining"] = $responseBodyRemaining["data"]["detail"];
                } else {
                    return redirect()->route("pages.dashboard")->with("error", "Terjadi Kesalahan");
                }
            } else {
                return redirect()->route("pages.dashboard")->with("error", "Terjadi Kesalahan");
            }

            DB::commit();

            return view("pages.account.admin.detail", $data);
        } catch (\Exception $e) {

            DB::rollBack();

            return redirect()->route("pages.dashboard")->with("error", $e->getMessage());
        }
    }

    public function upgrade($id)
    {
        try {

            DB::beginTransaction();

            DB::commit();

            return view("pages.account.admin.upgrade");

        } catch (\Exception $e) {

            DB::rollBack();

            return redirect()->route("pages.dashboard")->with("error", $e->getMessage());
        }
    }
}
