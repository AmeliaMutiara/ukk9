<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Pelanggan;
use App\Models\Penjualan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PenjualanController extends Controller
{
    public function index()
    {
        if (Auth::user()->level == 'admin') {
            $filter = Session::get('filter');
            $data = Penjualan::all()
            ->where('tglPenjualan', '>=', ($filter['start_date'] ?? date('Y-m-d')))
            ->where('tglPenjualan', '<=', ($filter['end_date'] ?? date('Y-m-d')));
            return view('Penjualan.index', compact('filter', 'data'));
        } else {
            Session::forget('data-penjualan');
            $data = Penjualan::all();
            return view('Penjualan.index', compact('data'));
        }
    }

    public function create()
    {
        $produk = Produk::get()->pluck('namaProduk', 'id');
        $pelanggan = Pelanggan::get()->pluck('namaPelanggan', 'id');
        $sessiondata = Session::get('data-penjualan');
        return view('Penjualan.add', compact('produk', 'pelanggan', 'sessiondata'));
    }

    public function processCreate(Request $request)
    {
        $item = Session::get('data-penjualan');
        try {
            DB::beginTransaction();

            $sales = Penjualan::create([
                'kodePenjualan' => $request->kodePenjualan,
                'tglPenjualan' => Carbon::now()->format('Y-m-d'),
                'totalHarga' => $request->totalHarga,
                'user_id' => $request->user_id,
                'pelanggan_id' => $request->pelanggan_id,
                'bayar' => $request->bayar
            ]);

            foreach ($item as $k => $v) {
                $itm = Produk::find($k);
                $itm->stok = ($itm->stok-$v[0]);
                $itm->save();

                $sales->detail()->create([
                    'kodePenjualan' => $request->kodePenjualan,
                    'produk_id' => $k,
                    'jmlProduk' => $v[0],
                    'subtotal' => ($v[0]*$itm->harga)
                ]);
            }

            DB::commit();
            return redirect()->route('sales.index')->with(['msg' => 'Berhasil Menambahkan Data Penjualan', 'type' => 'success']);
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            report($e);
            return redirect()->route('sales.add')->with(['msg' => 'Gagal Menambahkan Data Penjualan', 'type' => 'danger']);
        }
    }

    public function addSalesItem(Request $request)
    {
        $data = collect(Session::get('data-penjualan'));
        $prd = Produk::find($request->id);
        $data = $data->put($request->id, [($request->qty??1), $prd->harga]);
        Session::put('data-penjualan', $data->toArray());
        return redirect()->route('sales.add');
    }

    public function deleteSalesItem($id)
    {
        $data = collect(Session::get('data-penjualan'));
        $data = $data->forget($id);
        Session::put('data-penjualan', $data->toArray());
        return redirect()->route('sales.add');
    }

    public function detailSales($id)
    {
        $sessiondata = Session::get('data-penjualan');
        $produk = Produk::get()->pluck('namaProduk', 'id');
        $pelanggan = Pelanggan::get()->pluck('namaPelanggan', 'id');
        $penjualan = Penjualan::with('detail.produk','pelanggan')->find($id);
        return view('Penjualan.detail', compact('sessiondata', 'produk', 'pelanggan', 'penjualan'));
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();
            
            $pjl = Penjualan::with('detail')->find($id);

            foreach ($pjl->detail as $value) {
                $itm = Produk::find($value->produk_id);
                $itm->stok = ($itm->stok+$value->jmlProduk);
                $itm->save();
            }

            $pjl->delete();

            DB::commit();
            return redirect()->route('sales.index')->with(['msg' => 'Berhasil Menghapus Data Penjualan', 'type' => 'success']);
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            report($e);
            return redirect()->route('sales.index')->with(['msg' => 'Gagal Menghapus Data Penjualan', 'type' => 'danger']);
        }
    }

    public function printStruk($id)
    {
        $penjualan = Penjualan::with('detail.produk', 'pelanggan')->find($id);
        return view('Penjualan.printStruk', compact('penjualan'));
    }

    public function printSales()
    {
        $penjualan = Penjualan::with('detail.produk', 'pelanggan');
        return view('Penjualan.printSales', compact('penjualan'));
    }

    public function filter(Request $request)
    {
        $filter = Session::get('data-penjualan');
        $filter['start_date'] = $request->start_date;
        $filter['end_date'] = $request->end_date;
        Session::put('filter', $filter);
        return redirect()->route('sales.index');
    }

    public function resetFilter()
    {
        Session::forget('start_date');
        Session::forget('end_date');
        return redirect()->route('sales.index');
    }
}
