<?php

namespace App\Http\Controllers;

use App\Models\transaksi;
use Illuminate\View\View;
use App\Models\detiltransaksi;
use Illuminate\Http\Request;

class CetakController extends Controller
{
    //

    public function receipt():View
    {
        $id=session()->get('id');

        $transaksi=Transaksi::find($id);
        // dd($order)
        $detiltransaksi=detiltransaksi::where('transaksi_id',$id)->get();
        return view('penjualan.receipt')->with([
            'dataTransaksi'=>$transaksi,
            'datadetiltransaksi'=>$detiltransaksi
        ]);
    }
}
