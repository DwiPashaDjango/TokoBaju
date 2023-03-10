<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    public function __construct()
    {
        return $this->middleware('admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $data = Product::with('kategori')->orderBy('terjual_produk', 'desc')->get();
            return DataTables::of($data)
            ->addColumn('kategori', function($row) {
                $ktr = $row->kategori->nm_kategori;
                return $ktr;
            })
            ->addColumn('harga_produk', function($row) {
                $hrg = number_format($row->harga_produk);
                return $hrg;
            })
            ->addColumn('terjual_produk', function($row) {
                if ($row->terjual_produk > 0) {
                    $stc = $row->terjual_produk;
                } else {
                    $stc = '<span class="badge badge-warning">Belum Ada Yang Terjual</span>';
                }
                return $stc;
            })
            ->addColumn('action', function($row) {
                $btn = '<div class="dropdown">
                            <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Pilih
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="/admin/product/'.$row->id.'">Edit</a>
                                <a class="dropdown-item delete" data-id="'.$row->id.'" href="javascript:void(0)">Hapus</a>
                            </div>
                        </div>';
                return $btn;
            })
            ->rawColumns(['kategori', 'harga_produk', 'terjual_produk', 'action'])
            ->make(true);
        }
        return view('admin.product');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = Category::all();
        return view('admin.product_add', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nm_produk' => 'required',
            'categoris_id' => 'required',
            'stock_produk' => 'required',
            'harga_produk' => 'required',
        ]);

        $save = Product::create([
            'id' => Str::uuid(),
            'nm_produk' => $request->nm_produk,
            'categoris_id' => $request->categoris_id,
            'stock_produk' => $request->stock_produk,
            'harga_produk' => $request->harga_produk,
        ]);
        $newId = $save->id;
        return redirect('/admin/product/add/'.$newId.'/image')->with(['message' => 'Silahkan Isi Foto Produk Baru .']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Product::with('kategori')->find($id);
        return view('admin.product_add_lanjutan', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cat = Category::all();
        $data = Product::with('kategori')->find($id);
        return view('admin.product_edit', compact('data', 'cat'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_product_lanjutan(Request $request, $id)
    {
        $request->validate([
            'image_produk' => 'required|mimes:jpeg,jpg,png,',
            'isi_produk' => 'required',
        ]);

        $data = Product::find($id);

        $file = $request->file('image_produk');
        $path = time() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('public/produk/', $path);

        $data->update([
            'image_produk' => $path,
            'isi_produk' => $request->isi_produk
        ]);
        return redirect()->intended('/admin/product')->with(['message' => 'Berhasil Menyimpan Data Produk Baru']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nm_produk' => 'required',
            'categoris_id' => 'required',
            'stock_produk' => 'required',
            'harga_produk' => 'required',
            'image_produk' => 'required|mimes:jpeg,jpg,png,',
            'isi_produk' => 'required', 
        ]);

        $data = Product::find($id);

        $oldImagePath = 'storage/produk/'.$data->image_produk;
        if ($request->file('image_produk')) {
            unlink($oldImagePath);
        }

        $file = $request->file('image_produk');
        $path = time() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('public/produk/', $path);
        $data->update([
            'nm_produk' => $request->nm_produk,
            'categoris_id' => $request->categoris_id,
            'stock_produk' => $request->stock_produk,
            'harga_produk' => $request->harga_produk,
            'image_produk' => $path,
            'isi_produk' => $request->isi_produk
        ]); 
        return redirect()->intended('/admin/product')->with(['message' => 'Berhasil Mengubah Data Produk']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Product::find($id);
        $oldImagePath = 'storage/produk/'.$data->image_produk;
        if (File::exists($oldImagePath)) {
            unlink($oldImagePath);
        }
        $data->delete();
        return response()->json(['message' => 'Berhasil Menghapus Data Produk.']);
    }
}
