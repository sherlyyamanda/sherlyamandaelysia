<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\produk;


class ProdukController extends Controller
{
    //
    public function index()
{
    $produk=Produk::all();
    return view('produk.index',[
        "title"=>"Produk",
        "data"=>$produk
    ]);
}
public function create():View
{
    return view('produk.create')->with([
        "title"=> "Tambah Data Produk",
    ]);
}
public function store(Request $request):RedirectResponse
{
    $request->validate([
        "nama"=>"required",
        "description"=>"nullable",
        "stock"=>"required",
        "harga"=>"required",
    ]);
    Produk::create($request->all());
    return redirect()->route('produk.index')->with('success','Data Berhasil Ditambahkan');
}
public function edit(Produk $produk):View
{
    return view('produk.edit',compact('produk'))->with([
        "title"=>"Ubah Data Produk",
        "data"=>Produk::all()
    ]);
}
public function update(Produk $produk,Request $request):RedirectResponse
{
    $request->validate([
        "nama"=>"required",
        "stock"=>"required",
        "harga"=>"required",
        "description"=>"nullable"
    ]);

    $produk->update($request->all());
    return redirect()->route('produk.index')->with('updated','Data Produk 
    Berhasil Diubah');
}
public function show():View
{
    $produk=Produk::all();
    return view('produk.show')->with([
        "title"=>"Tampil Data Produk",
        "data"=>$produk
    ]);

}
public function destroy($id):RedirectResponse
{
    Produk::where('id',$id)->delete();
    return redirect()->route('produk.index')->with('deleted','Data Produk Berhasil Dihapus');
}
}
