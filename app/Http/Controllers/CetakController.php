<?php

namespace App\Http\Controllers;

use App\Models\transaksi;
use Illuminate\View\View;
use App\Models\detil_transaksi;
use Illuminate\Http\Request;

class CetakController extends Controller
{
    //

    public function receipt():View
    {
        $id=session()->get('id');

        $transaksi=Transaksi::find($id);
        // dd($order)
        $detil_transaksi=detil_transaksi::where('transaki_id',$id)->get();
        return view('penjualan.receipt')->with([
            'dataTransaksi'=>$transaksi,
            'datadetil_transkasi'=>$detil_transaksi
        ]);
    }
}
