@extends('layouts.main')
@section('content')
    <div class="px-2 py-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card rounded-4">
                        <div class="card-body">
                            @auth
                                <p class="ms-1">
                                    <a href="/items"
                                        class="link-secondary link-opacity-75-hover link-underline-opacity-0 link-underline-opacity-0-hover"><i
                                            class="fa-solid fa-chevron-left me-1"></i>Kembali</a>
                                </p>
                            @endauth
                            <div class="d-flex justify-content-center mb-3">
                                <img src="{{ $item->photo_url }}" class="rounded-4 my-3" alt="Gambar Barang" id="showImg">
                            </div>
                            <div class="row text-center mx-1">
                                <div class="col-sm-4">
                                    <dl class="border rounded-3 pt-2">
                                        <dt class="mb-2">Kode</dt>
                                        <dd>{{ $item->kode }}</dd>
                                    </dl>
                                </div>
                                <div class="col-sm-4">
                                    <dl class="border rounded-3 pt-2">
                                        <dt class="mb-2">Nama</dt>
                                        <dd>{{ $item->nama }}</dd>
                                    </dl>
                                </div>
                                <div class="col-sm-4">
                                    <dl class="border rounded-3 pt-2">
                                        <dt class="mb-2">Nomor Register</dt>
                                        <dd>{{ $item->nomorRegister }}</dd>
                                    </dl>
                                </div>
                            </div>
                            <div class="row text-center mx-1">
                                <div class="col-sm-4">
                                    <dl class="border rounded-3 pt-2">
                                        <dt class="mb-2">Merek</dt>
                                        <dd>{{ $item->merek }}</dd>
                                    </dl>
                                </div>
                                <div class="col-sm-4">
                                    <dl class="border rounded-3 pt-2">
                                        <dt class="mb-2">Tipe</dt>
                                        <dd>{{ $item->tipe }}</dd>
                                    </dl>
                                </div>
                                <div class="col-sm-4">
                                    <dl class="border rounded-3 pt-2">
                                        <dt class="mb-2">Tahun Pembelian</dt>
                                        <dd>{{ $item->tahunBeli }}</dd>
                                    </dl>
                                </div>
                            </div>
                            <div class="row text-center mx-1">
                                <div class="col-sm-4">
                                    <dl class="border rounded-3 pt-2">
                                        <dt class="mb-2">Kondisi</dt>
                                        <dd>{{ $item->kondisi }}</dd>
                                    </dl>
                                </div>
                                <div class="col-sm-4">
                                    <dl class="border rounded-3 pt-2">
                                        <dt class="mb-2">Harga</dt>
                                        <dd>Rp {{ number_format($item->harga, 2, ',', '.') }}</dd>
                                    </dl>
                                </div>
                                <div class="col-sm-4">
                                    <dl class="border rounded-3 pt-2">
                                        <dt class="mb-2">Keterangan</dt>
                                        <dd>{{ $item->keterangan }}</dd>
                                    </dl>
                                </div>
                            </div>
                            <div class="row text-center mx-1">
                                <div class="col-sm-4">
                                    <dl class="border rounded-3 pt-2">
                                        <dt class="mb-2">Kategori</dt>
                                        <dd>{{ $item->kategori }}</dd>
                                    </dl>
                                </div>
                                <div class="col-sm-4" @if ($item->kategori != 'Kendaraan') hidden @endif>
                                    <dl class="border rounded-3 pt-2">
                                        <dt class="mb-2">Warna</dt>
                                        <dd>{{ $item->warna }}</dd>
                                    </dl>
                                </div>
                                <div class="col-sm-4" @if ($item->kategori != 'Kendaraan') hidden @endif>
                                    <dl class="border rounded-3 pt-2">
                                        <dt class="mb-2">Nomor Rangka</dt>
                                        <dd>{{ $item->nomorRangka }}</dd>
                                    </dl>
                                </div>
                            </div>
                            <div @if ($item->kategori != 'Kendaraan') hidden @endif>
                                <div class="row text-center mx-1">
                                    <div class="col-sm-4">
                                        <dl class="border rounded-3 pt-2">
                                            <dt class="mb-2">Nomor Mesin</dt>
                                            <dd>{{ $item->nomorMesin }}</dd>
                                        </dl>
                                    </div>
                                    <div class="col-sm-4">
                                        <dl class="border rounded-3 pt-2">
                                            <dt class="mb-2">Nomor Polisi</dt>
                                            <dd>{{ $item->nomorPolisi }}</dd>
                                        </dl>
                                    </div>
                                    <div class="col-sm-4">
                                        <dl class="border rounded-3 pt-2">
                                            <dt class="mb-2">Nomor BPKB</dt>
                                            <dd>{{ $item->nomorBpkb }}</dd>
                                        </dl>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
