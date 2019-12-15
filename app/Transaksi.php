<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $appends = ['plucks'];
    protected $guarded = [''];

    public function scopeFiltered($query)
    {
        $query->when(request('q'), function ($query) {
            $param = '%' . request('q') . '%';
            $query->whereHas('user', function($q) use($param){
                $q->where('nama_agen', 'like', $param)
                    ->orWhere('alamat', 'like', $param);
            })->orWhereHas('details', function($q) use($param){
                $q->where('value', 'like', $param)
                    ->orWhere('harga', 'like', $param);
            });
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
