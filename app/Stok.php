<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stok extends Model
{
    protected $guarded = [''];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    public function scopeFiltered($query)
    {
        $query->when(request('q'), function ($query) {
            $param = '%' . request('q') . '%';
            $query->whereHas('user', function($q) use($param){
                $q->where('nama_agen', 'like', $param);
            })->orWhereHas('barang', function($q) use($param){
                $q->where('nama', 'like', $param);
            });
        });
    }
}
