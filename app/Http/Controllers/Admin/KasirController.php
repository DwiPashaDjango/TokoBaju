<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kasir;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class KasirController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Product::orderBy('id')->get();
        return view('admin.kasir', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_transaction()
    {
        $data = Kasir::with('produk')->orderBy('id', 'desc')->where('status', 'pending')->get();
        // $data->harga_produk = number_format($data->harga_produk);
        return response(['data' => $data]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'nm_pembeli' => 'required',
            'products_id' => 'required'
        ]);

        if ($validate->fails()) {
            return response(['errors' => $validate->errors()]);
        }

        $data = Kasir::create([
            'id' => Str::uuid(),
            'nm_pembeli' => $request->nm_pembeli,
            'products_id' => $request->products_id,
            'users_id' => auth()->guard('web')->user()->id
        ]);
        return response(['status' => 200, 'data' => $data]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function plusQty(Request $request, $id)
    {
        $data = Kasir::with('produk')->find($id);

        if ($data->produk->stock_produk < 1) {
            return response(['errors' => ''.$data->produk->nm_produk.' Out Of Stock Transaksi Gagal Di Lakukan ! ']);
        }

        $data->update([
            'qty' => $request->qty + 1
        ]);
        $data->grand_total = $data->qty * $data->produk->harga_produk;
        $data->produk->stock_produk = $data->produk->stock_produk - 1;
        $data->produk->save();
        $data->save();
        return response(['status' => 200, 'data' => $data]);
    }

    public function minusQty(Request $request, $id)
    {
        $data = Kasir::with('produk')->find($id);
        $data->update([
            'qty' => $request->qty - 1
        ]);
        $data->grand_total = $data->qty * $data->produk->harga_produk;
        $data->produk->stock_produk = $data->produk->stock_produk + 1;
        $data->produk->save();
        $data->save();
        return response(['status' => 200, 'data' => $data]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Kasir::find($id);
        $data->update([
            'status' => 'success'
        ]);
        return response(['status' => 200, 'data' => $data]);
    }

    public function printNota()
    {
        $data = Kasir::with('produk')->orderBy('id', 'desc')->where('status', 'pending')->get();
        return view('admin.print.print_nota', compact('data'));
    }
}
