<?php

namespace App\Http\Controllers\Authorization;

use App\Http\Controllers\Controller;
use App\Http\Helper\ApiHelper;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class LoginController extends Controller
{
    public function login()
    {
        try {

            DB::beginTransaction();

            DB::commit();

            return view("pages.authorization.login");
        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with("error", $e->getMessage());
        }
    }

    public function postLogin(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        try {
            $data = [
                "username" => $request->username,
                "password" => $request->password
            ];

            $client = new Client([
                "timeout" => 10
            ]);

            $response = $client->post(ApiHelper::apiUrl("/organization/account/superadmin/auth/login"),
                [
                    'json' => $data,
                    'headers' => [
                        'Content-Type' => 'application/json'
                    ]
                ]
            );

            $responseBody = json_decode($response->getBody(), true);

            if ($responseBody["statusCode"] == 200) {

                session(["category_account" => $responseBody["data"]["account_category"]]);
                session(["data" => $responseBody["data"]]);
                session(['accessData' => $responseBody["accessData"]]);

                return redirect()->route('pages.dashboard')->with('success', 'Login successful!');
            } else {
                return back()->with("error", $responseBody["message"]);
            }
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function logout()
    {
        try {

            session()->forget("accessData");
            session()->flush();

            return redirect()->route("pages.login")->with("success", "Berhasil Logout");
        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with("error", $e->getMessage());
        }
    }
}
