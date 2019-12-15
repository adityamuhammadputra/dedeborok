<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransaksiDetail extends Model
{
    protected $guarded = [''];
    
    public function transaksi()
    {
        return $this->belongsTo(TransaksiDetail::class);
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }


}
