<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\TransaksiDetail;
use App\Transaksi;
use App\Barang;
use App\Stok;
use App\User;
use Illuminate\Support\Facades\Auth as Auth;

class StokController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datas = Transaksi::orderBy('id', 'desc')->filtered()->paginate(7);

        return view('stok.index', compact('datas'));
    }

    public function create()
    {
        $data = (object)[
            'barang' => Barang::where('stok', '>', 0)->get(),
            'agen' => User::whereNull('status')->get(),
            'action' => url('stok'),
            'type' => 'POST'
        ];

        return view('stok.form', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = [
            'user_id' => $request->agen_id,
            'status' => (Auth::user()->id == 1) ? 2 : 1,
        ];
        $transaksi = Transaksi::create($input);

        $this->inputNew($request, $transaksi);

        toastr()->success('Transaksi '.$transaksi->user->nama_agen.' berhasil disimpan');
        return redirect(url('stok'));
    }

    function inputNew($request, $transaksi)
    {
        foreach($request->barang_id as $key => $val){
            $detail = [
                'transaksi_id' => $transaksi->id,
                'barang_id' => $request->barang_id[$key],
                'total_harga' => $request->total_harga[$key],
                'value' => $request->value[$key],
            ];
            TransaksiDetail::create($detail);

            if($transaksi->status == 2){
                $barang = Barang::find($request->barang_id[$key]);
                $barang->stok = $barang->stok - $request->value[$key];
                $barang->save();

                $cek_stok = Stok::where('barang_id', $request->barang_id[$key])
                                ->where('user_id', $request->agen_id)->first();
                if(!$cek_stok){
                    $input_stok = [
                        'user_id' => $request->agen_id,
                        'barang_id' => $request->barang_id[$key],
                        'qty_awal' => $request->value[$key],
                        'qty_akhir' => $request->value[$key],
                    ];
                    Stok::create($input_stok);

                }else{
                    $cek_stok->qty_awal = $cek_stok->qty_akhir;
                    $cek_stok->qty_akhir = $cek_stok->qty_awal + $request->value[$key];
                    $cek_stok->save();
                }
            }
        }
    }

    public function edit(Transaksi $transaksi, $id)
    {
        $transaksi = Transaksi::find($id);
        $data = (object)[
            'barang' => Barang::where('stok', '>', 0)->get(),
            'agen' => User::whereNull('status')->get(),
            'action' => url('stok', $transaksi->id),
            'type' => 'PATCH',
            'transaksi' => $transaksi
        ];

        return view('stok.form', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $transaksi = Transaksi::find($id);
        $transaksi->user_id = $request->agen_id;
        $transaksi->status = $request->s;
        $transaksi->save();

        foreach($request->id_old as $key => $val){
            $detail = TransaksiDetail::find($val);
            $detail->barang_id = $request->barang_id_old[$key];
            $detail->value = $request->value_old[$key];
            $detail->total_harga = $request->total_harga_old[$key];
            $detail->save();

            $cek_stok = Stok::where('barang_id', $request->barang_id_old[$key])
                    ->where('user_id', $request->agen_id)->first();

            if($cek_stok && $cek_stok->qty_akhir != $cek_stok->qty_awal + $request->value_old[$key]){
                $cek_stok->qty_akhir = $cek_stok->qty_awal + $request->value_old[$key];
                $cek_stok->save();
            }
        }

        if($request->barang_id ){
            $this->inputNew($request, $transaksi);
        }

        if($request->detail_deleted){
            $id_deleted = explode(',', $request->detail_deleted);
            $details = TransaksiDetail::whereIn('id', $id_deleted);
            foreach($details->get() as $detail){
                $cek_stok = Stok::where('barang_id', $detail->barang_id)
                ->where('user_id', $detail->transaksi->user_id)->first();
                if($cek_stok && $cek_stok->qty_akhir != $cek_stok->qty_awal + $detail->value){
                    $cek_stok->qty_akhir = $cek_stok->qty_akhir - $request->value_old[$key];
                    $cek_stok->save();
                }
            }
            $details->delete();
        }

        toastr()->success('Transaksi <b>'.$transaksi->user->nama_agen.'</b> berhasil dirubah');
        return redirect(url('stok'));
    }

    public function destroy($id)
    {
        $transaksi = Transaksi::find($id);
        $transaksi_detail = TransaksiDetail::where('transaksi_id', $transaksi->id);
        $transaksi->delete();
        $transaksi_detail->delete();

        return $transaksi;
    }
}
