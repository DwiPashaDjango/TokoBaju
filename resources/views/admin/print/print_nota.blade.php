<!DOCTYPE html>
<html>
<head>
    <title>Struk Pembayaran</title>
    <style>
        /* Style untuk thermal printer */
        @media print {
            body {
                font-family: Arial, sans-serif;
                font-size: 12px;
                line-height: 1.2;
                margin: 0;
            }
            table {
                border-collapse: collapse;
                width: 100%;
            }
            td {
                padding: 4px;
                vertical-align: top;
            }
            .center {
                text-align: center;
            }
            .right {
                text-align: right;
            }
        }
    </style>
</head>
<body onload="item()">
    @if ($data->count() > 0)
        <table>
            <tr>
                <td colspan="5" class="center">
                    <h3>Toko XYZ</h3>
                    <p>Jl. Raya XYZ No. 123</p>
                    <p>Telp. 0123456789</p>
                </td>
            </tr>
            <tr>
                <td colspan="5"><hr></td>
            </tr>
            <tr>
                <td>Tanggal</td>
                <td>:</td>
                <td class="right" colspan="3">{{\Carbon\Carbon::now()->format('d M Y')}}</td>
            </tr>
            <tr>
                <td>No. Transaksi</td>
                <td>:</td>
                <td class="right" colspan="3">{{$data[0]->kd_transaksi}}</td>
            </tr>
            <tr>
                <td colspan="5"><hr></td>
            </tr>
            @foreach ($data as $item)
                <tr>
                    <td colspan="2">Produk</td>
                    <td class="center">Qty</td>
                    <td class="right">Harga</td>
                </tr>
                <tr>
                    <td colspan="5"><hr></td>
                </tr>
                <tr>
                    <td colspan="2">{{$item->produk->nm_produk}}</td>
                    <td colspan="1" class="center">{{$item->qty}}</td>
                    <td class="right">Rp {{number_format($item->produk->harga_produk)}}</td>
                </tr>
                <tr>
                    <td colspan="5"><hr></td>
                </tr>
            @endforeach
            <tr>
                <td colspan="3">Subtotal</td>
                <td class="right">Rp {{number_format($data->sum('grand_total'))}}</td>
            </tr>
            @if ($data[0]->qty > 10)
                <tr>
                    @php
                        $hit = $data->sum('grand_total');
                        $dis = $hit * 0.1 / 100;
                    @endphp
                    <td colspan="3">Diskon</td>
                    <td class="right">Rp {{number_format($dis)}}</td>
                </tr>
                <tr>
                    <td colspan="3">Total</td>
                    <td class="right">Rp {{number_format($data->sum('grand_total') - $dis)}}</td>
                </tr>
            @elseif($data[0]->qty > 20)
                <tr>
                    @php
                        $hit = $data->sum('grand_total');
                        $dis = $hit * 0.2 / 100;
                    @endphp
                    <td colspan="3">Diskon</td>
                    <td class="right">Rp {{number_format($dis)}}</td>
                </tr>
                <tr>
                    <td colspan="3">Total</td>
                    <td class="right">Rp {{number_format($data->sum('grand_total') - $dis)}}</td>
                </tr>
            @else
                <tr>
                    <td colspan="3">Total</td>
                    <td class="right">Rp {{number_format($data->sum('grand_total'))}}</td>
                </tr>
            @endif
            <tr>
                <td colspan="5"><hr></td>
            </tr>
            <tr>
                <td colspan="5" class="center">
                    <p>Terima kasih telah berbelanja di Toko XYZ</p>
                    <p>Semoga belanja Anda menyenangkan</p>
                </td>
            </tr>
        </table>
    @else
        <table>
            <tr>
                <td colspan="5" class="center">
                    <h3>Toko XYZ</h3>
                    <p>Jl. Raya XYZ No. 123</p>
                    <p>Telp. 0123456789</p>
                </td>
            </tr>
            <tr>
                <td colspan="5"><hr></td>
            </tr>
            <tr>
                <td colspan="2">Produk</td>
                <td class="center">Qty</td>
                <td class="right">Harga</td>
            </tr>
            <tr>
                <td colspan="5"><hr></td>
            </tr>
            <tr>
                <td colspan="5" style="text-align: center">Tidak Ada Transaksi</td>
            </tr>
            <tr>
                <td colspan="5"><hr></td>
            </tr>
        </table>
    @endif
</body>
</html>