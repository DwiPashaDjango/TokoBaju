<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    public function index()
    {
        $product = Product::with('kategori')->orderBy('id', 'desc')->get();
        return view('user.home', compact('product'));
    }

    public function show($id)
    {
        $product = Product::with('kategori')->find($id);
        $product->image_produk = asset('storage/produk/' . $product->image_produk);
        $product->harga_produk = number_format($product->harga_produk);
        return response(['data' => $product]);
    }

    public function carts(Request $request)
    {
        if ($request->qty_carts == 0) {
            return response(['errors' => 'Masukan Jumlah Produk Yang Ingin DI Beli.']);
        } elseif($request->qty_carts == 'Pilih') {
            return response(['errors' => 'Pilih Size Baju Yang Pas.']);
        }

        $cart = Cart::create([
            'id' => Str::uuid(),
            'products_id' => $request->products_id,
            'customers_id' => Auth::guard('costumer')->user()->id,
            'ukuran' => $request->ukuran,
            'qty_carts' => $request->qty_carts,
        ]);
        $cart->grand_total_carts = $cart->qty_carts * $cart->produk->harga_produk;
        $cart->save();

        return response(['data' => $cart]);
    }

    public function get_carts()
    {
        $carts = Cart::with('produk')->orderBy('id', 'desc')->where('customers_id', Auth::guard('costumer')->user()->id)->paginate(2);
        $carts[0]->produk->harga_produk = number_format($carts[0]->produk->harga_produk);
        return response(['data' => $carts]);
    }

    public function countCart()
    {
        $carts = Cart::where('customers_id', Auth::guard('costumer')->user()->id)->count();
        return response(['data' => $carts]);
    }
}
