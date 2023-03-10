<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckOutController extends Controller
{
    public function index()
    {
        $carts = Cart::with('produk')->where('customers_id', Auth::guard('costumer')->user()->id)->get();
        return view('user.checkout', compact('carts'));
    }

    public function get_carts_cekout()
    {
        $carts = Cart::with('produk')->where('customers_id', Auth::guard('costumer')->user()->id)->get();
        $carts[0]->produk->harga_produk = number_format($carts[0]->produk->harga_produk);
        $carts[0]->grand_total_carts = number_format($carts[0]->grand_total_carts);
        return response(['data' => $carts]);
    }

    public function get_sum_carts()
    {
        $carts = Cart::with('produk')->where('customers_id', Auth::guard('costumer')->user()->id)->get();
        if ($carts[0]->qty_carts >= 20) {
            $hit = $carts->sum('grand_total_carts');
            $dis = $hit * 0.2 / 100;
            $ongkir = 2000;
            $total = $hit - $dis;
            $data = [
                'jumlah_awal' => number_format($hit),
                'diskon' => number_format($dis),
                'jumlah_akhir' => number_format($total + $ongkir),
                'ongkir' => number_format($ongkir)
            ];
        } else {
            $total = $carts->sum('grand_total_carts');
            $dis = 0;
            $ongkir = 2000;
            $data = [
                'diskon' => number_format($dis),
                'jumlah_awal' => number_format($total),
                'jumlah_akhir' => number_format($total + $ongkir),
                'ongkir' => number_format($ongkir)
            ];
        }
        return response(['data' => $data]);
    }

    public function plus(Request $request, $id)
    {
        $cart = Cart::with('produk')->find($id);
        $cart->update([
            'qty_carts' => $request->qty_carts + 1,
        ]);
        $cart->grand_total_carts = $cart->qty_carts * $cart->produk->harga_produk;
        $cart->save();
        return response(['data' => $cart]);
    }

    public function minus(Request $request, $id)
    {
        $cart = Cart::with('produk')->find($id);
        $cart->update([
            'qty_carts' => $request->qty_carts - 1,
        ]);
        $cart->grand_total_carts = $cart->qty_carts * $cart->produk->harga_produk;
        $cart->save();
        return response(['data' => $cart]);
    }

    public function checkOut_pay($id)
    {
        $pay = Cart::with('customer', 'produk')->where('customers_id', $id)->get();
        return response(['data' => $pay]);
    }

    public function showCheckOutPay($id)
    {
        $checkPay = Cart::with('produk')->where('customers_id', $id)->get();
        return view('user.pay', compact('checkPay'));
    }
}
