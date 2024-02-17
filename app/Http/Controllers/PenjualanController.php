<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Produk;
use App\Models\Pelanggan;
use App\Models\Penjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\DataTables\PenjualanDataTable;
use Illuminate\Support\Facades\Session;

class PenjualanController extends Controller
{
    public function index(PenjualanDataTable $table)
    {
        Session::forget('data-penjualan');
        return $table->render('Penjualan.index');
    }
    public function create()
    {
        // * get data untuk select pelanggan dan produk
        $produk = Produk::get()->pluck('NamaProduk', 'id');
        $pelanggan = Pelanggan::get()->pluck('NamaPelanggan', 'id');
        $sessiondata = Session::get('data-penjualan');
        return view('penjualan.add',compact('sessiondata','produk','pelanggan'));
    }
    public function update()
    {
        $sessiondata = Session::get('data-penjualan');
    }
    public function delete()
    {
    }
    public function processCreate(Request $request)
    {
        // * get data 'keranjang' (detail penjualan)
        $item = Session::get('data-penjualan');
        try {
        DB::beginTransaction();
        // * buat parent
        $sales = Penjualan::create([
            'TanggalPenjualan'=>Carbon::now()->format('Y-m-d'),
            'TotalHarga'=>$request->TotalHarga,
            'pelanggan_id'=>$request->pelanggan_id,
        ]);
        foreach($item as $k=>$v){
            // * ubah stok
            $itm = Produk::find($k);
            $itm->Stok = ($itm->Stok-$v[0]);
            $itm->save();
            //*buat child
            $sales->detail()->create([
                'produk_id'=>$k,
                'JumlahProduk'=>$v[0],
                'Subtotal'=>($v[0]*$itm->Harga),
            ]);
        }
        DB::commit();
        Session::forget('data-penjualan');
        return redirect()->route('sales.add')->with(['msg' => 'Berhasil Menambah Penjualan', 'type' => 'success']);
        } catch (\Exception $e) {
        DB::rollBack();
        report($e);
        dd($e);
        return redirect()->route('sales.add')->with(['msg' => 'Gagal Menambah Penjualan', 'type' => 'danger']);
        }
    }
    public function processUpdate(Request $request)
    {
    }
    public function addSalesItem(Request $request)
    {
        // * get data 'keranjang' dari sesion
        $data = collect(Session::get('data-penjualan'));
        //* V1 Gunakan Jika Tidak menentukan quantity di view
        // // * cek apakah produk sudah ada di'keranjang'
        // if($data->has($request->id)){
        //     // * tambah quantity produk ke 'keranjang' kalau di 'keranjang' ada
        //     // * format array [produkid=>[qty,harga]]
        //     $data=$data->put($request->id,[$data[$request->id][0]+1,$data[$request->id][1]]);
        // }else{
        //     // * get data produk untuk mengambil harga
        //     $prd = Produk::find($request->id);
        //     // * tambah produk ke 'keranjang' kalau di 'keranjang' tidak ada
        //     $data=$data->put($request->id,[1,$prd->Harga]);
        // }
        // ***************************************************
        // * V2 Versi Simpel sekali
            // * get data produk untuk mengambil harga
            $prd = Produk::find($request->id);
            // * tambah produk ke 'keranjang' kalau di 'keranjang' tidak ada
            // * syntax ($request->qt??1) digunakan untuk memberi default quantity 1 ke jumlah produk
            $data=$data->put($request->id,[($request->qty??1),$prd->Harga]);
        // ************************
        Session::put('data-penjualan',$data->toArray());
        return redirect()->route('sales.add');
    }
    public function deleteSalesItem($id)
    {
        // * get data 'keranjang' dari sesion
        $data = collect(Session::get('data-penjualan'));
        // * hapus data produk di 'keranjang' dari sesion
        $data = $data->forget($id);
        Session::put('data-penjualan',$data->toArray());
        return redirect()->route('sales.add');
    }
    public function changeQtySalesItem(Request $request)
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
