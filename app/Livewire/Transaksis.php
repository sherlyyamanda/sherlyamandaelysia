<?php

namespace App\Livewire;

use App\Models\transaksi;
use App\Models\detil_transaksi;
use App\Models\produk;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Livewire\Component;

class Transaksis extends Component
{
    public $total;
    public $transaksi_id;
    public $produk_id;
    public $qty=1;
    public $uang;
    public $kembali;

    public function render()
    {
        $transaksi=transaksi::select('*')->where('user_id','=',Auth::user()->id)->orderBy('id','desc')->first();

        $this->total=$transaksi->total;
        $this->kembali=$this->uang-$this->total;
        return view('livewire.transaksis')
        ->with("data",$transaksi)
        ->with("dataproduk",produk::where('stock','>','0')->get())
        ->with("datadetil_transaksi",detil_transaksi::where('transaksi_id','=',$transaksi->id)->get());
    }

    public function store()
    {
        $this->validate([
            'produk_id'=>'required'
        ]);
        $transaksi=Transaksis::select('*')->where('user_id','=',Auth::user()->id)->orderBy('id','desc')->first();
        $this->transaksi_id=$transaksi->id;
        $produk=produk::where('id','=',$this->produk_id)->get();
        $harga=$produk[0]->price;
        detil_transaksi::create([
            'transaksi_id'=>$this->transaksi_id,
            'produk_id'=>$this->produk_id,
            'qty'=>$this->qty,
            'price'=>$harga
        ]);

        $total=$transaksi->total;
        $total=$total+($harga*$this->qty);
        transaksis::where('id','=',$this->transaksi_id)->update([
            'total'=>$total
        ]);
        $this->transaksi_id=NULL;
        $this->qty=1;
    }

    public function delete($detil_transaksi_id)
    {
        $detil_transaksi=detil_transaksi::find($detil_transaksi_id);
        $detil_transaksi->delete();

        //update total
        $detil_transaksi=detil_transaksi::select('*')->where('transaksi_id','=',$this->transaksi_id)->get();
        $total=0;
        foreach($transaksi_detail as $od){
            $total+=$od->qty*$od->price;
        }

        try{
            Transaksis::where('id','=',$this->transaksi_id)->update([
                'total'=>$total
            ]);
        }catch(Exception $e){
            dd($e);
        }
    }

    public function receipt($id)
    {
        // update stok
        $detil_transaksi = detil_transaksi::select('*')->where('transaksi_id','=',$id)->get();
        // dd($detil_transaksi);
        foreach ($detil_transaksi as $od){
            $stocklama = produk::select('stock')->where('id','=',$od->produk_id)->sum('stock');
            $stock = $stocklama - $od->qty;
            try {
                produk::where('id','=',$od->produk_id)->update([
                    'stock'=> $stock
                ]);
            } catch (Exception $e) {
                dd($e);
            }
        }
return Redirect::route('cetakReceipt')->with(['id'=>$id]);
}
}
