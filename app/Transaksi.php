<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $appends = ['plucks'];
    protected $guarded = [''];
    protected $primaryKey = 'id';

    public function scopeFiltered($query)
    {
        $query->when(request('q'), function ($query) {
            $param = '%' . request('q') . '%';
            $query->whereHas('user', function($q) use($param){
                $q->where('nama_agen', 'like', $param);
            })->orWhereHas('details', function($q) use($param){
                $q->where('total_harga', 'like', $param)
                    ->orWhereHas('barang', function($q2) use($param){
                        $q2->where('nama', 'like', $param);
                    });
            });
        });

        $query->when(request('s'), function ($query) {
            $query->where('status', request('s'));
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function details()
    {
        return $this->hasMany(TransaksiDetail::class)->with('barang');
    }

    public function getPlucksAttribute()
    {
        return str_limit($this->details->pluck('barang')->pluck('nama')->implode(', '),30);
    }
}
