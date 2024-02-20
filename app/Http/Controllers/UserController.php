<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\DataTables\UserDataTable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function index(UserDataTable $table)
    {
        if (Auth::user()->level) {
            return $table->render('User.index');
        } else {
            return redirect()->route('user.update', Auth::id());
        }
    }
    public function create()
    {
        $level = [
            0=>'Petugas',
            1=>'Admin'
        ];
        return view('User.edit',compact('level'));
    }
    public function update($id=null)
    {
        $level = [
            0=>'Petugas',
            1=>'Admin'
        ];
        if(is_null($id)){
            $id=Auth::id();
        }elseif(!Auth::user()->level){
            $id = Auth::id();
        }
        $data = User::find($id);
        return view('User.edit',compact('data','level'));
    }
    public function processCreate(Request $request)
    {
    }
    public function processUpdate(Request $request)
    {
        try {
        DB::beginTransaction();
        $id=$request->id;
        if(!Auth::user()->level&&$request->id!=Auth::id()){
            $id = Auth::id();
        }
        $usr = User::find($id);
        if(is_null($request->password)){
            $usr->update($request->except('password','id'));
        }else{
            $usr->update($request->except('id'));
        }
        DB::commit();
        return redirect()->route('user.index')->with(['msg' => 'Berhasil Mengupdate System User', 'type' => 'success']);
        } catch (\Exception $e) {
        DB::rollBack();
        report($e);
        return redirect()->route('user.index')->with(['msg' => 'Gagal Mengupdate System User', 'type' => 'danger']);
        }
    }
    public function delete($id)
    {
        try {
            DB::beginTransaction();
            User::find($id)->delete();
            DB::commit();
            return redirect()->route('user.index')->with(['msg' => 'Berhasil Menghapus System User', 'type' => 'success']);
        } catch (\Exception $e) {
            DB::rollBack();
            report($e);
            return redirect()->route('user.index')->with(['msg' => 'Gagal Menghapus System User', 'type' => 'danger']);
        }
    }
    public function elemenAdd(Request $request)
    {
        $data = Session::get('data-penjualan');
        $data[$request->name] = $request->value;
        Session::put('data-penjualan', $data);
        return response(1);
    }
}
