@extends('layouts.master')
@section('judul-table', 'Dashboard')

@section('content')

        <div class="row">
            <!-- Column -->
            <div class="col-md-6 col-lg-3 col-xlg-3">
                <div class="card card-hover">
                    <div class="box bg-cyan text-center">
                        <h1 class="font-light text-white"><i class=" fas fa-dolly-flatbed"></i></h1>
                        <h6 class="text-white">Total Barang Masuk</h6>
                    </div>
                </div>
            </div>
            <!-- Column -->
            <div class="col-md-6 col-lg-3 col-xlg-3">
                <div class="card card-hover">
                    <div class="box bg-success text-center">
                        <h1 class="font-light text-white"><i class=" fas fa-shopping-cart"></i></h1>
                        <h6 class="text-white">Total Barang Keluar</h6>
                    </div>
                </div>
            </div>
             <!-- Column -->
             <div class="col-md-6 col-lg-3 col-xlg-3">
                <div class="card card-hover">
                    <div class="box bg-primary text-center">
                        <h1 class="font-light text-white"><i class=" fas fa-edit"></i></h1>
                        <h6 class="text-white">Total Stok Barang</h6>
                    </div>
                </div>
            </div>
            <!-- Column -->
            <div class="col-md-6 col-lg-3 col-xlg-3">
                <div class="card card-hover">
                    <div class="box bg-danger text-center">
                        <h1 class="font-light text-white"><i class="fas fa-users"></i></h1>
                        <h6 class="text-white">Total Agen</h6>
                    </div>
                </div>
            </div>
            <!-- Column -->

        </div>

        <div class="row">
                <!-- column -->
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Request Barang</h4>
                        </div>
                        <div class="comment-widgets scrollable">
                            <!-- Comment Row -->
                            <div class="d-flex flex-row comment-row m-t-0">
                                <div class="p-2"><img src="../../matrix/assets/images/users/3.jpg" alt="user" width="60" class="rounded-circle"></div>
                                <div class="comment-text w-100">
                                    <h6 class="font-medium">Muhammad Adit (AGEN 2)</h6>
                                    <span class="m-b-15 d-block">Sari Roti 2 DUS </span>
                                    <span class="m-b-15 d-block">Aqua Botol 2 DUS </span>
                                    <span class="m-b-15 d-block">Beras 1 KARUNG </span>
                                    <div class="comment-footer">
                                        <span class="text-muted float-right">12 Desember 2019</span>
                                        <button type="button" class="btn btn-success btn-sm">Proses</button>
                                        <button type="button" class="btn btn-danger btn-sm">Tolak</button>
                                    </div>
                                </div>
                            </div>
                            <!-- Comment Row -->
                            <div class="d-flex flex-row comment-row">
                                <div class="p-2"><img src="../../matrix/assets/images/users/4.jpg" alt="user" width="60" class="rounded-circle"></div>
                                <div class="comment-text active w-100">
                                    <h6 class="font-medium">Hanifah (AGEN 1)</h6>
                                    <span class="m-b-15 d-block">Kacang Garuda 3 DUS </span>
                                    <div class="comment-footer">
                                        <span class="text-muted float-right">11 Desember 2019</span>
                                        <button type="button" class="btn btn-success btn-sm">Proses</button>
                                        <button type="button" class="btn btn-danger btn-sm">Tolak</button>
                                    </div>
                                </div>
                            </div>
                            <!-- Comment Row -->
                            <div class="d-flex flex-row comment-row">
                                <div class="p-2"><img src="../../matrix/assets/images/users/5.jpg" alt="user" width="60" class="rounded-circle"></div>
                                <div class="comment-text w-100">
                                    <h6 class="font-medium">Bos Poncol Tukang Sabu (AGEN 3)</h6>
                                    <span class="m-b-15 d-block">Lem Aibon 80 DUS </span>
                                    <span class="m-b-15 d-block">Baso Sabu 20 KARUNG </span>
                                    <div class="comment-footer">
                                        <span class="text-muted float-right">10 Desember 2019</span>
                                        <button type="button" class="btn btn-success btn-sm">Proses</button>
                                        <button type="button" class="btn btn-danger btn-sm">Tolak</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


        </div>

@endsection

@push('scripts')

@endpush
