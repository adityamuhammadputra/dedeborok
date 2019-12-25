@extends('layouts.master')
@section('judul', 'Agen')
@section('judul-table', 'Data Agen')

@section('page-tools')
    <a href="{{ route('stok.create') }}" class="btn btn-info btn-sm float-right"><i class="mdi mdi-plus"></i> Tambah</a>
@endsection
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
                <th>Nama Agen</th>
                <th width="350px">Alamat Agen</th>
                <th>Tanggal Daftar</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($datas as $key => $d)
            <tr>
                <td>{{ $datas->firstItem() + $key }}</td>
                <td>
                    <a target="_blank" href="../{{ $d->photo }}"><img src="../{{ $d->photo }}" alt="user" width="52" height="55" class="rounded-circle float-left"></a>
                    <div class="details">
                        {{ $d->nama_agen }}
                        <p>{{ $d->kontak }}</p>
                    </div>
                </td>
                <td>{{ $d->alamat }}</td>
                <td>{{ $d->created_at->diffForHumans() }}</td>
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
