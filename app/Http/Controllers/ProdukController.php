<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ProdukController extends Controller
{
    public function index()
    {
        Session::forget('data-penjualan');
    }
    public function create()
    {
        $sesstiondata = Session::get('data-penjualan');
    }
    public function update()
    {
        $sesstiondata = Session::get('data-penjualan');
    }
    public function delete()
    {
    }
    public function processCreate(Request $request)
    {
    }
    public function processUpdate(Request $request)
    {
    }
    public function addSalesItem(Request $request)
    {
    }
    public function deleteSalesItem(Request $request)
    {
    }
    public function elemenAdd(Request $request)
    {
        $data = Session::get('data-penjualan');
        $data[$request->name] = $request->value;
        Session::put('data-penjualan', $data);
        return response(1);
    }
}
