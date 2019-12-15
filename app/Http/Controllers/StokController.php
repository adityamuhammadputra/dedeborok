<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Auth;

use App\TransaksiDetail;
use App\Transaksi;
use App\Barang;
use App\User;

class StokController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datas = Transaksi::with('details','user')->filtered()->paginate(7);
       
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

        foreach($request->barang_id as $key => $val){
            $detail = [
                'transaksi_id' => $transaksi->id,
                'barang_id' => $request->barang_id[$key],
                'total_harga' => $request->total_harga[$key],
                'value' => $request->value[$key],
                
            ];
            TransaksiDetail::create($detail);
        }

        toastr()->error('An error has occurred please try again later.');

        return redirect(url('stok'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //

        return 'x';
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        return 'x';
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
