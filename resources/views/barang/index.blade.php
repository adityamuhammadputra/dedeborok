@extends('layouts.master')
@section('judul', 'Barang')
@section('judul-table', 'Data Barang')

@section('page-tools')
    <a href="{{ route('barang.create') }}" class="btn btn-info float-right"><i class="mdi mdi-plus"></i> Tambah Barang</a>
@endsection

@section('content')
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Nama Barang</th>
                <th>Kategori Barang</th>
                <th>Satuan</th>
                <th>Harga</th>
                <th>Stok Barang</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($datas as $d)
            <tr>
                <td>{{ $d->nama }}</td>
                <td>{{ $d->kategori }}</td>
                <td>{{ $d->satuan }}</td>
                <td>{{ $d->harga }}</td>
                <td>{{ $d->stok }}</td>
                <td>
                    aksi
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
