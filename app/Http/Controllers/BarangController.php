<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use RealRashid\SweetAlert\Facades\Alert;

class BarangController extends Controller
{

    public function index()
    {
        $barang = Barang::all();
        return view('admin.barang.index',[
            'barang' => $barang
        ]);
    }


    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $tambah_barang          = new Barang;
        $tambah_barang->kd_brg  = $request->addkdbrg;
        $tambah_barang->nm_brg  = $request->addnmbrg;
        $tambah_barang->harga   = $request->addharga;
        $tambah_barang->stok    = $request->addstok;
        $tambah_barang->save();

        Alert::success('Pesan ','Data berhasil disimpan');
        return redirect('/barang');
    }


    public function show(string $id)
    {

    }


    public function edit(string $id)
    {
        $barang_edit = Barang::findOrFail($id);
        return view('admin.barang.edit',['barang'=>$barang_edit]);
    }


    public function update(Request $request, string $id)
    {
        $barang         =   Barang::findOrFail($id);
        $barang->kd_brg =   $request->get('addkdbrg');
        $barang->nm_brg =   $request->get('addnmbrg');
        $barang->harga  =   $request->get('addharga');
        $barang->stok   =   $request->get('addstok');
        $barang->save();

        return redirect()->route('barang.index');
    }


    public function destroy(string $id)
    {
        $barang = Barang::findOrFail($id);
        if($barang){
            $barang->delete();
            Alert::success('Success', 'Data Berhasil dihapus');
        }
        return redirect()->route('barang.index');
    }
}
