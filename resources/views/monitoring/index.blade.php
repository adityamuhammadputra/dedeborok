@extends('layouts.master')
@section('judul', 'Monitoring')
@section('judul-table', 'Data Monitoring')


@section('page-filters')
<i></i>
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
                <th>Nama Barang</th>
                <th>Nama Agen</th>
                <th width="350px">Alamat Agen</th>
                <th>Stok</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($datas as $key => $d)
            <tr>
                <td>{{ $datas->firstItem() + $key }}</td>
                <td>{{ $d->barang->nama }}</td>
                <td>
                    <a target="_blank" href="{{ $d->user->photo }}"><img src="{{ $d->user->photo }}" alt="user" width="52" height="55" class="rounded-circle float-left"></a>
                    <div class="details">
                        {{ $d->user->nama_agen }}
                        <p>{{ $d->user->kontak }}</p>
                    </div>
                </td>
                <td>{{ $d->user->alamat }}</td>
                <td><span class="badge badge-pill badge-success"> {{ $d->qty_akhir }} </span></td>
                <td>
                    <a href="{{ url('master/agen', $d->id) }}/edit" class="btn btn-cyan btn-sm">Lihat</a>
                    <a id="deleteData" data-id="{{ $d->id }}" data-title="{{ $d->nama_agen }}" class="btn btn-danger btn-sm">Hapus</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $datas->appends(['q' => $_GET['q'] ?? null]  )->links() }}

@endsection

@push('scripts')
<script>
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
                            url: "{{ url('master/agen/') }}/" +id,
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
