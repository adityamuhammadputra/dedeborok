@extends('layouts.master')
@section('judul', 'Stok')
@section('judul-table', 'Data Transaksi')

@section('page-tools')
    <a href="{{ route('stok.create') }}" class="btn btn-info btn-sm float-right"><i class="mdi mdi-plus"></i> Tambah</a>
@endsection

@section('content')
<style>
.details{
    margin-left: 66px;
    margin-top: 6px;
}
.details p{
    color: #b5b5b5;
    font-size: 12px;
}
</style>
    <table class="table table-hover">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Agen</th>
                <th width="300px">Alamat Agen</th>
                <th>Tanggal</th>
                <th>No. Transaksi</th>
                <th>Detail Barang</th>
                <th>Total Barang</th>
                <th>Total Harga</th>
                <th>Status</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($datas as $key => $d)
            <tr>
                <td>{{ $datas->firstItem() + $key }}</td>
                <td>
                    <a target="_blank" href="{{ $d->user->photo }}"><img src="{{ $d->user->photo }}" alt="user" width="52" height="55" class="rounded-circle float-left"></a>
                    <div class="details">
                        {{ $d->user->nama_agen }}
                        <p>{{ $d->user->kontak }}</p>
                    </div>
                </td>
                <td>{{ $d->user->alamat }}</td>
                <td>{{ datesOuput($d->created_at) }}</td>
                <td>{{ datesOrder($d->created_at) }}</td>
                <td>{{ $d->plucks }}</td>
                <td class="text-center"><b>{{ $d->details->count() }}</b></td>
                <td>@money($d->details->sum('total_harga'))</td>
                <td>{!! ($d->status == 1) ? '<span class="badge badge-pill badge-info">Request</span>' : '<span class="badge badge-pill badge-success">Selesai</span>' !!}</td>
                <td>
                    <a href="{{ url('barang', $d->id) }}/edit" class="btn btn-cyan btn-sm">Lihat</a>
                    <a href="{{ url('barang', $d->id) }}" class="btn btn-danger btn-sm">Hapus</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $datas->appends(['q' => $_GET['q'] ?? null]  )->links() }}

@endsection

@push('scripts')
<script>

</script>
@endpush
