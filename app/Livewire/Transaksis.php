<?php

namespace App\Livewire;

use Exception;
use App\Models\Transaksi;
use App\Models\Produk;
use Livewire\Component;
use App\Models\Detiltransaksi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class transaksis extends Component
{
    public $total;
    public $transaksi_id;
    public $produk_id;
    public $qty=1;
    public $uang;
    public $kembali;

    public function render()
    {
        $transaksi=Transaksi::select('*')->where('user_id','=',Auth::user()->id)->orderBy('id','desc')->first();

        $this->total=$transaksi->total;
        $this->kembali=$this->uang-$this->total;
        return view('livewire.transaksis')
        ->with("data",$transaksi)
        ->with("dataproduk",Produk::where('stock','>','0')->get())
        ->with("datadetiltransaksi",Detiltransaksi::where('transaksi_id','=',$transaksi->id)->get());
    }

    public function store()
    {
        $this->validate([
            
            'produk_id'=>'required'
        ]);
        $transaksi=Transaksi::select('*')->where('user_id','=',Auth::user()->id)->orderBy('id','desc')->first();
        $this->transaksi_id=$transaksi->id;
        $produk=Produk::where('id','=',$this->produk_id)->get();
        $price=$produk[0]->price;
        Detiltransaksi::created([
            'transaksi_id'=>$this->transaksi_id,
            'produk_id'=>$this->produk_id,
            'qty'=>$this->qty,
            'price'=>$price
        ]);
        
        
        $total=$transaksi->total;
        $total=$total+($price*$this->qty);
        Transaksi::where('id','=',$this->transaksi_id)->update([
            'total'=>$total
        ]);
        $this->produk_id=NULL;
        $this->qty=1;

    }

    public function delete($detiltransaksi_id)
    {
        $detiltransaksi=detiltransaksi::find($detiltransaksi_id);
        $detiltransaksi->delete();

        //update total
        $detiltransaksi=detiltransaksi::select('*')->where('transaksi_id','=',$this->transaksi_id)->get();
        $total=0;
        foreach($detiltransaksi as $od){
            $total+=$od->qty*$od->price;
        }
        
        try{
            transaksi::where('id','=',$this->transaksi_id)->update([
                'total'=>$total
            ]);
        }catch(Exception $e){
            dd($e);
        }
    }
    
    public function receipt($id)
    {
        $detiltransaksi = detiltransaksi::select('*')->where('transaksi_id','=', $id)->get();
        //dd ($detiltransaksi);
        foreach ($detiltransaksi as $od) {
            $stocklama = produk::select('stock')->where('id','=', $od->produk_id)->sum('stock');
            $stock = $stocklama - $od->qty;
            try {
                produk::where('id','=', $od->produk_id)->update([
                    'stock' => $stock
                ]);
            } catch (Exception $e) {
                dd($e);
            }
        }
        return Redirect::route('cetakReceipt')->with(['id' => $id]);

    }
}
