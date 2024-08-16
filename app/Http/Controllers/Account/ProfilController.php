<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Http\Helper\ApiHelper;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ProfilController extends Controller
{
    public function index()
    {
        try {

            DB::beginTransaction();

            $data = [];

            $client = new Client([
                "timeout" => 10
            ]);

            $profil = $client->get(ApiHelper::apiUrl("/organization/account/admin/" . session("data")["username"] . '/show'));
            $responseProfil = json_decode($profil->getBody(), true);

            $currentPaket = $client->get(ApiHelper::apiUrl("/organization/paket/" . session("data")["member_account_code"] . "/current_paket"));
            $responderCurrentPaket = json_decode($currentPaket->getBody(), true);



            DB::commit();

            if ($responseProfil["statusCode"] == 200 && $responderCurrentPaket["statusCode"] == 200) {

                $data["detail"] = $responseProfil["data"];

                $data["currentPaket"] = $responderCurrentPaket["data"];

                return view("pages.account.profil.index", $data);
            } else {
                return redirect()->route("pages.dashboard")->with("error", $responseProfil["message"]);
            }
        } catch (\Exception $e) {

            DB::rollBack();

            return redirect()->route("pages.dashboard")->with("error", $e->getMessage());
        }
    }

    public function update(Request $request, $member_account_code)
    {
        try {

            DB::beginTransaction();

            $data = [
                "nama" => $request->nama,
                "email" => $request->email,
                "nama_pic" => $request->nama_pic,
                "phone_number_pic" => $request->phone_number_pic,
                "alamat_organisasi" => $request->alamat_organisasi
            ];

            $response = Http::put(ApiHelper::apiUrl("/organization/account/admin/" . $member_account_code . "/update_profile"), $data);

            DB::commit();

            $responseBody = $response->json();

            if ($responseBody["statusCode"] == 200) {
                return back()->with("success", "Data Berhasil di Simpan");
            } else {
                return back()->with("error", $responseBody["message"]);
            }
        } catch (\Exception $e) {

            DB::rollBack();

            return redirect()->route("pages.dashboard");
        }
    }

    public function changePassword(Request $request, $username)
    {
        try {

            if ($request->confirm_password != $request->new_password) {
                return back()->with("error", "Konfirmasi Password Tidak Sesuai");
            }

            DB::beginTransaction();

            $data = [
                "old_password" => $request->old_password,
                "new_password" => $request->new_password
            ];

            $response = Http::patch(ApiHelper::apiUrl("/organization/account/admin/" . $username . "/change_password"), $data);

            DB::commit();

            $responseBody = $response->json();

            if ($responseBody["statusCode"] == 200) {
                return back()->with("success", $responseBody["message"]);
            } else {
                return back()->with("error", $responseBody["message"]);
            }
        } catch (\Exception $e) {

            DB::rollBack();

            return redirect()->route("pages.dashboard")->with("error", $e->getMessage());
        }
    }

    public function upgradePaket(Request $request, $member_account_code)
    {
        try {

            DB::beginTransaction();

            $client = new Client([
                "timeout" => 10
            ]);

            // $data = [
            //     "idMasterPaket" => "",
            //     "amount" => 200000,
            //     "limit_user" => 15,
            //     "limit_contact" => 30,
            //     "end_date" => 30
            // ];

            $data = [
                "paketOrganization" => [
                    "id_master_paket_organization" => $request->id_master_paket_organization
                ]
            ];

            $response = $client->put(
                ApiHelper::apiUrl("/organization/account/admin/" . $member_account_code . "/upgrade_paket/internal"),
                [
                    'json' => $data,
                    'headers' => [
                        'Content-Type' => 'application/json'
                    ]
                ]
            );

            $responseProfil = json_decode($response->getBody(), true);

            DB::commit();

            if ($responseProfil["statusCode"] == 201) {

                session(["paymentUrl" => $responseProfil["paymentUrl"]["url"]]);
                $encrypt = Crypt::encryptString($responseProfil["external_id"]);

                session(["external_id" => $responseProfil["external_id"]]);
                session(["encrypt" => $encrypt]);

                return redirect()->route("pages.payment.checkout.index");
            } else {
                return back()->back()->with("error", "Terjadi Kesalahan");
            }
        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with("error", $e->getMessage());
        }
    }
}
