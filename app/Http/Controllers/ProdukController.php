<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function create(Request $request)
    {
        $data = $request->all();

        $this->validate($request, [
            'nama'      => 'required|string',
            'harga'     => 'required|integer',
            'warna'     => 'required|string',
            'kondisi'   => 'required|in:baru,lama',
            'deskripsi' => 'string'

        ]);

        $produk = Produk::create($data);
        
        return response()->json($produk);
    }

    public function get(){
        echo "Lapar !";
    }
}
