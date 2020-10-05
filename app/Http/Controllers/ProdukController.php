<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($id = null)
    {
        if (empty($id)) {
            $produk = Produk::all();
        } else {
            $produk = Produk::find($id);
        }
        return response()->json($produk);
    }

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

    public function update(Request $request, $id)
    {
        $data = $request->all();

        $this->validate($request, [
            'nama'      => 'string',
            'harga'     => 'integer',
            'warna'     => 'string',
            'kondisi'   => 'in:baru,lama',
            'deskripsi' => 'string'

        ]);

        $produk = Produk::find($id);

        $produk->fill($data);
        $produk->save();

        return response()->json($data);
    }

    public function destroy($id)
    {
        $produk = Produk::find($id);

        if (!$produk) {
            return response()->json(['message' => 'Produk Not Found !']);
        }

        $produk->delete();

        return response()->json(['message' => 'Produk deleted !']);
    }
}
