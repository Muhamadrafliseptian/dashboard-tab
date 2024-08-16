<?php

namespace App\Http\Controllers\Responder;

use App\Http\Controllers\Controller;
use App\Http\Helper\ApiHelper;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AkunController extends Controller
{
    public function index()
    {
        try {

            DB::beginTransaction();

            $data = [];

            $client = new Client([
                "timeout" => 10
            ]);

            $response = $client->post(ApiHelper::apiUrl("/organization/partner/" . session("data")["institution_id"]  . "/responder"));
            $responseBody = json_decode($response->getBody(), true);

            DB::commit();

            if ($responseBody["statusCode"] == 200) {
                $data["akun"] = $responseBody["data"];

                return view("pages.responder.akun.index", $data);
            } else {
                return redirect()->route("pages.dashboard")->with("error", $responseBody["message"]);
            }

        } catch (\Exception $e) {

            DB::rollBack();

            return redirect()->route("pages.dashboard")->with("error", $e->getMessage());
        }
    }
}
