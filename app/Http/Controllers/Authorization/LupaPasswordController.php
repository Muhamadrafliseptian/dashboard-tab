<?php

namespace App\Http\Controllers\Authorization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LupaPasswordController extends Controller
{
    public function index()
    {
        try {

            DB::beginTransaction();

            DB::commit();

            return view("pages.authorization.lupa-password");

        } catch (\Exception $e) {

            DB::rollBack();

            return redirect()->to("/pages/login")->with("error", $e->getMessage());
        }
    }
}
