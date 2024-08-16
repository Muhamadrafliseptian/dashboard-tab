<?php

namespace App\Http\Controllers\Pengaturan;

use App\Http\Controllers\Controller;
use App\Http\Helper\ApiHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class RoleController extends Controller
{
    public function index()
    {
        try {

            DB::beginTransaction();

            $data = [];

            $akses = Http::get(ApiHelper::apiUrl("/organization/role/all"));

            if ($akses->successful()) {

                $response = $akses->json();

                if ($response["statusCode"] == 200) {
                    $data["role"] = $response["data"];
                } else {
                    return redirect()->route("pages.dashboard")->with("error", "Terjadi Kesalahan");
                }

            } else {
                return redirect()->route("pages.dashboard")->with("error", "Terjadi Kesalahan");
            }

            DB::commit();

            return view("pages.pengaturan.akses-role.index", $data);

        } catch (\Exception $e) {

            DB::rollBack();

            return redirect()->route("pages.dashboard")->with("error", $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {

            DB::beginTransaction();

            $data =[
                "role_name" => $request->role_name,
                "level_role" => $request->level_role
            ];

            $response = Http::post(ApiHelper::apiUrl("/organization/role/create"), $data);

            DB::commit();

            $responseBody = $response->json();

            if ($responseBody["statusCode"] == 201) {
                return back()->with("success", $responseBody["message"]);
            } else {
                return back()->with("error", $responseBody["message"]);
            }
        } catch (\Exception $e) {

            DB::rollBack();

            return redirect()->route("pages.dashboard")->with("error", $e->getMessage());
        }
    }

    public function edit($id)
    {
        try {

            DB::beginTransaction();

            $data = [];

            $akses = Http::get(ApiHelper::apiUrl("/organization/role/all"));

            if ($akses->successful()) {

                $response = $akses->json();

                if ($response["statusCode"] == 200) {
                    $data["role"] = $response["data"];
                } else {
                    return redirect()->route("pages.dashboard")->with("error", "Terjadi Kesalahan");
                }

            } else {
                return redirect()->route("pages.dashboard")->with("error", "Terjadi Kesalahan");
            }

            DB::commit();

            return view("pages.pengaturan.akses-role.index", $data);

        } catch (\Exception $e) {

            DB::rollBack();

            return redirect()->route("pages.dashboard")->with("error", $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {

            DB::beginTransaction();

            $akses = Http::delete(ApiHelper::apiUrl("/organization/role/" . $id . "/delete"));

            DB::commit();

            $response = $akses->json();

            if ($response["statusCode"] == 200) {
                return back()->with("success", $response["message"]);
            } else {
                return back()->with("error", $response["message"]);
            }

        } catch (\Exception $e) {

            DB::rollBack();

            return redirect()->route("pages.dashboard")->with("error", $e->getMessage());
        }
    }
}
