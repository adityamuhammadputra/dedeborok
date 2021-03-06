@extends('layouts.master')
@section('judul', 'Stok')
@section('judul-table', 'Data Transaksi')

@section('page-tools')
    <a href="{{ route('stok.create') }}" class="btn btn-info btn-sm float-right"><i class="mdi mdi-plus"></i> Tambah</a>
@endsection
@section('page-filters')
<select name="s" class="form-control" id="status">
    <option selected value="">-- Pilih Status --</option>
    <option value="1" {{ (request('s') == 1) ? 'selected' : '' }}>Request</option>
    <option value="2" {{ (request('s') == 2) ? 'selected' : '' }}>Selesai</option>
</select>
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
                    <a href="{{ url('stok', $d->id) }}/edit" class="btn btn-cyan btn-sm">Lihat</a>
                    <a id="deleteData" data-id="{{ $d->id }}" data-title="{{ $d->user->nama_agen }}" class="btn btn-danger btn-sm">Hapus</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $datas->appends(['q' => $_GET['q'] ?? null, 's' => $_GET['s'] ?? null]  )->links() }}

@endsection

@push('scripts')
<script>
    $('#status').on('change', function(){
       $('#form-filters').trigger('submit');
    })

    $(document).on('click', '#deleteData', function(){
        var id  = $(this).data('id');
        var isicontent = 'Anda yakin akan menghapus '+ $(this).data('title');
        jconfirm.defaults.content = isicontent;
        jconfirm.defaults.type = 'red';
        $.confirm({
            buttons: {
                confirm: {
                    btnClass: 'btn-danger',
                    action: function(){
                        $.ajax({
                            url: "{{ url('stok') }}/" +id,
                            type: "DELETE",
                            success: function(data){
                                toastr["success"]( data + 'berhasil dihapus')
                            },
                            error: function(){
                                alert('reload, terjadi error');
                            }
                        })
                    }
                },

                batal: function () {
                },
            }
        });
    })

</script>
@endpush
