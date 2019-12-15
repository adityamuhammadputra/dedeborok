@extends('layouts.master')
@section('judul', 'Barang')
@section('judul-table', 'Tambah Barang')

@section('page-tools')
    <a href="{{ route('stok.index') }}" class="btn btn-info btn-sm float-right"><i class="fas fa-reply"></i> Kembali</a>

@endsection

@section('content')
<form method="POST" action="{{ $data->action }}">
@csrf
@method($data->type)
    <div class="card">
        <div class="card-body">
            <div class="form-group row">
                <label class="col-md-3">Nomor Transaksi</label>
                <div class="col-md-3">
                    <input type="text" class="form-control" placeholder="{{datesOrder(\Carbon\Carbon::now())}}" disabled>
                </div>
            </div>  
            <div class="form-group row">
                <label class="col-md-3">Nama Agen</label>
                <div class="col-md-3">
                    <select class="select2 form-control custom-select agen" name="agen_id"  style="width: 100%; height:10px;" required>
                        <option value="">Pilih Tujuan Pengiriman</option>
                        @foreach ($data->agen as $val)
                            <option value="{{ $val->id }}" data-alamat="{{$val->alamat}}" data-kontak="{{$val->kontak}}">{{ $val->nama_agen }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3"></label>
                <div class="col-md-3"><code class="detials-toko"></code></div>
            </div>
        </div>
    </div>

    <div class="panel-body table-responsive">
        <table class="table table-striped table-borderless" style="width:100%" id="item_table">
            <thead>
                <tr>
                    <th width="12%">Nama Barang</th>
                    <th width="8%">Jumlah Barang</th>
                    <th width="8%">Kode Barang</th>
                    <th width="12%">Kategori </th>
                    <th width="9%">Harga / Satuan</th>
                    <th width="8%">Total Harga</th>
                    <th width="5%" >
                        <button type="button" name="add" class="btn btn-success add btn-sm float-right"><i class="fa fa-plus text-white"></i></button>
                    </th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        
        <button type="submit" class="btn btn-primary float-right"><i class="fa fa-check-circle"></i> <t class="tombol-simpan">Simpan</t></button>
        <button type="button" class="btn btn-default float-right" onclick="btnCancel()"><i class="fa fa-times-circle"></i> Batal</button>
    </div>
</form>

<select class="custom-select2" style="display:none;">
    @foreach ($data->barang as $val)
        <option data-kategori="{{ $val->kategori }}" data-satuan="{{ $val->satuan }}" data-harga="{{ $val->harga }}" value="{{ $val->id }}">{{ $val->nama }}</option>
    @endforeach
</select>
@endsection

@push('scripts')
<script>
    $('.agen').on('change', function(){
        var alamat = $(this).find(':selected').data('alamat')
        var kontak = $(this).find(':selected').data('kontak')
        $('.detials-toko').html(alamat + '<br>' + kontak)

    })

    $(document).on('click', '.add', function(){
        var select = $('.custom-select2').html()
        var html = '<tr>\
            <td><select class="form-control namas" placeholder="Nama Barang" style="width:100%px;" required>'+select+'</select></td>\
            <td><input type="number" name="value[]" class="form-control jumlah" placeholder="Jumlah" required /></td>\
            <td>\
                <input type="text" class="form-control barang_temp" placeholder="Kode Barang"  readonly/>\
                <input type="hidden" name="barang_id[]" class="form-control barang_id" placeholder="Kode Barang"  readonly/>\
            </td>\
            <td><input type="text" class="form-control kategori" placeholder="kategori Barang" readonly /></td>\
            <td><input type="text" class="form-control satuan" placeholder="Harga / Satuan Barang" readonly><input type="hidden" class="harga"></td>\
            <td><input type="text" name="total_harga[]" class="form-control total_harga" placeholder="Total Harga" readonly/></td>\
            <td><button type="button" name="remove" class="btn btn-danger remove btn-sm float-right"><i class="fa fa-minus"></i></button></td>\
        </tr>';
        $('#item_table').append(html);
        $('.namas').select2()
    });
    
    $(document).on('change', '.namas', function(){
        var kategori = $(this).find(':selected').data('kategori')
        var satuan = $(this).find(':selected').data('satuan')
        var harga = $(this).find(':selected').data('harga')
        var id = $(this).val()

        $(this).closest('tr').find('.kategori').val(kategori)
        $(this).closest('tr').find('.satuan').val(harga + ' / ' + satuan)
        $(this).closest('tr').find('.harga').val(harga)
        $(this).closest('tr').find('.barang_id').val(id)
        $(this).closest('tr').find('.barang_temp').val('BR-001'+id)
        
    });
    
    $(document).on('keyup', '.jumlah', function(){
        var harga = $(this).closest('tr').find('.harga').val()
        var jumlah = $(this).val()
        var total_harga = jumlah * harga;

        $(this).closest('tr').find('.total_harga').val(total_harga)
    });

    $(document).on('click', '.remove', function(){
        $(this).closest('tr').remove();
    });
</script>
@endpush
