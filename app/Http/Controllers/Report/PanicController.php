<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Http\Helper\ApiHelper;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PanicController extends Controller
{
    public function index()
    {
        try {

            DB::beginTransaction();

            $client = new Client([
                "timeout" => 10
            ]);

            $data = [];

            $resPanic = $client->get(ApiHelper::apiUrl("/organization/panic_report/" . session("data")["member_account_code"] . '/show_organization'));
            $responsePanic = json_decode($resPanic->getBody(), true);

            DB::commit();


            if ($responsePanic["statusCode"] == 200) {
                $data["panicReport"] = $responsePanic["data"];
            }

            return view("pages.report.panic.index", $data);
        } catch (\Exception $e) {

            DB::rollBack();

            return redirect()->route("pages.dashboard")->with("error", $e->getMessage());
        }
    }

    public function show($id_panic)
    {
        try {

            DB::beginTransaction();

            $client = new Client([
                "timeout" => 10
            ]);

            $data = [];

            $resPanic = $client->get(ApiHelper::apiUrl("/organization/panic_report/" . $id_panic . "/show"));
            $responsePanic = json_decode($resPanic->getBody(), true);

            DB::commit();

            if ($responsePanic["statusCode"] == 200) {

                $data["detail"] = $responsePanic["data"];

                return view("pages.report.panic.detail", $data);
            } else {
                return redirect()->route("pages.dashboard")->with("error", $responsePanic["message"]);
            }
        } catch (\Exception $e) {

            DB::rollBack();

            return redirect()->route("pages.dashboard")->with("error", $e->getMessage());
        }
    }
}
