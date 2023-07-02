<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="bg-white border rounded-4 px-4 py-4">
                <div class="row">
                    <div class="col-6">
                        <h5>Total Barang : {{ $totalBarang }} Barang (Rp
                            {{ number_format($totalAsset, 2, ',', '.') }})</h5>
                    </div>
                    <div class="col-6 d-flex justify-content-end">
                        <a href="/export-report" class="link-underline link-underline-opacity-0">
                            <div class="d-grid d-md-flex">
                                <button type="button"
                                    class="btn btn-sm btn-outline-dark fw-medium rounded-3 p-2 mb-2 mb-md-0 ms-0 ms-md-2">
                                    <span>Export Laporan</span>
                                </button>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="row d-flex justify-content-center mt-4 mb-1">
                    <div class="col-sm-3 border rounded-3 text-center mx-3 py-3">Total Barang
                        <strong>Kondisi Baik</strong> :
                        <strong>{{ $totalBaik }}</strong>
                    </div>
                    <div class="col-sm-3 border rounded-3 text-center mx-3 py-3">Total Barang
                        <strong>Kondisi Rusak Ringan</strong> :
                        <strong>{{ $totalRusakRingan }}</strong>
                    </div>
                    <div class="col-sm-3 border rounded-3 text-center mx-3 py-3">Total Barang
                        <strong>Kondisi Rusak Berat</strong> :
                        <strong>{{ $totalRusakBerat }}</strong>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-12">
            <div class="bg-white border rounded-4">

                {{-- Alert QR Info --}}
                <div class="mx-3 mt-4 mb-3">
                    @if (Queue::size() > 0)
                        <div class="alert alert-primary fade show" role="alert">
                            <i class="fa-solid fa-spinner fa-spin-pulse me-2"></i><strong>Mohon tunggu!</strong>
                            Kode QR sedang diproses, silahkan refresh halaman ini secara berkala.
                        </div>
                    @endif
                </div>

                {{-- Alert Error --}}
                <div class="mx-3 mt-4 mb-3">
                    @include('partials.alert-error')
                </div>

                <div class="row align-items-center mx-3 mt-4 mb-3">
                    <div class="col-md-3 mb-2 mb-md-0">
                        <div class="input-group input-group-sm">
                            <input wire:model.debounce.500ms="search"
                                class="form-control focus-ring focus-ring-light border rounded-3 p-2" type="text"
                                placeholder="Cari barang...">
                        </div>
                    </div>
                    <div class="col-md-1 mb-2 mb-md-0">
                        <select wire:model.lazy="perPage"
                            class="form-select form-select-sm focus-ring focus-ring-light border rounded-3 p-2">
                            <option value="25" class="">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                            <option value="250">250</option>
                            <option value="500">500</option>
                        </select>
                    </div>
                    <div class="dropdown-center d-grid col-md-1 mb-2 mb-md-0 me-md-5 me-lg-5 me-xl-4">
                        <button class="btn btn-sm btn-light border dropdown-toggle rounded-3 p-2" type="button"
                            data-bs-toggle="dropdown" aria-expanded="false"
                            @if (empty($selectedRows)) disabled @endif>
                            Aksi Massal
                        </button>
                        <ul class="dropdown-menu">
                            <li><a wire:click.prevent="confirmDeleteSelectedRows" class="dropdown-item"
                                    href="#">Hapus</a></li>
                        </ul>
                    </div>
                    <div class="d-grid d-md-flex justify-content-md-end col-md">
                        @if ($items->count() > 0 && Queue::size() === 0)
                            <a href="/export-qr" class="link-underline link-underline-opacity-0">
                                <div class="d-grid d-md-flex">
                                    <button type="button"
                                        class="btn btn-sm btn-outline-dark fw-medium rounded-3 p-2 mb-2 mb-md-0 ms-0 ms-md-2">
                                        <span>Export QR</span>
                                    </button>
                                </div>
                            </a>
                        @else
                            <div class="d-grid d-md-flex">
                                <button type="button" disabled
                                    class="btn btn-sm btn-outline-dark fw-medium rounded-3 p-2 mb-2 mb-md-0 ms-0 ms-md-2">
                                    <span>Export QR</span>
                                </button>
                            </div>
                        @endif
                        <button wire:click.prevent="confirmImport" type="button"
                            class="btn btn-sm btn-outline-dark fw-medium rounded-3 p-2 mb-2 mb-md-0 ms-0 ms-md-2">
                            <span>Import</span>
                        </button>
                        <button wire:click.prevent="confirmItemCreate" type="button"
                            class="btn btn-sm btn-success rounded-3 p-2 mb-2 mb-md-0 ms-0 ms-md-2">
                            <span>Tambah Barang</span>
                        </button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="bg-body-tertiary">
                            <tr>
                                <th scope="col" class="text-center ps-4">
                                    <div class="form-check">
                                        <input wire:model="selectPageRows"
                                            class="form-check-input focus-ring focus-ring-light" type="checkbox"
                                            value="" id="" style="cursor: pointer">
                                    </div>
                                </th>
                                <th scope="col" class="text-center">NO</th>
                                <th scope="col" class="text-center">
                                    <span
                                        @if ($items->count() > 0) wire:click="orderBy('kode')" style="cursor: pointer" @endif>KODE
                                        @if ($orderBy === 'kode' && $orderDirection === 'asc' && $items->count() > 0)
                                            <i class="fa-solid fa-arrow-down-1-9 fa-lg"></i>
                                        @elseif ($orderBy === 'kode' && $orderDirection === 'desc' && $items->count() > 0)
                                            <i class="fa-solid fa-arrow-down-9-1 fa-lg"></i>
                                        @endif
                                    </span>
                                </th>
                                <th scope="col" class="text-center">
                                    <span
                                        @if ($items->count() > 0) wire:click="orderBy('nama')" style="cursor: pointer" @endif>NAMA
                                        @if ($orderBy === 'nama' && $orderDirection === 'asc' && $items->count() > 0)
                                            <i class="fa-solid fa-arrow-down-a-z fa-lg"></i>
                                        @elseif ($orderBy === 'nama' && $orderDirection === 'desc' && $items->count() > 0)
                                            <i class="fa-solid fa-arrow-down-z-a fa-lg"></i>
                                        @endif
                                    </span>
                                </th>
                                <th scope="col" class="text-center">
                                    <span
                                        @if ($items->count() > 0) wire:click="orderBy('nomorRegister')" style="cursor: pointer" @endif>NOMOR
                                        REGISTER
                                        @if ($orderBy === 'nomorRegister' && $orderDirection === 'asc' && $items->count() > 0)
                                            <i class="fa-solid fa-arrow-down-1-9 fa-lg"></i>
                                        @elseif ($orderBy === 'nomorRegister' && $orderDirection === 'desc' && $items->count() > 0)
                                            <i class="fa-solid fa-arrow-down-9-1 fa-lg"></i>
                                        @endif
                                    </span>
                                </th>
                                <th scope="col" class="text-center">
                                    <span
                                        @if ($items->count() > 0) wire:click="orderBy('kategori')" style="cursor: pointer" @endif>KATEGORI
                                        @if ($orderBy === 'kategori' && $orderDirection === 'asc' && $items->count() > 0)
                                            <i class="fa-solid fa-arrow-down-a-z fa-lg"></i>
                                        @elseif ($orderBy === 'kategori' && $orderDirection === 'desc' && $items->count() > 0)
                                            <i class="fa-solid fa-arrow-down-z-a fa-lg"></i>
                                        @endif
                                    </span>
                                </th>
                                <th scope="col" class="text-center">
                                    <span
                                        @if ($items->count() > 0) wire:click="orderBy('tahunBeli')" style="cursor: pointer" @endif>TAHUN
                                        PEMBELIAN
                                        @if ($orderBy === 'tahunBeli' && $orderDirection === 'asc' && $items->count() > 0)
                                            <i class="fa-solid fa-arrow-down-1-9 fa-lg"></i>
                                        @elseif ($orderBy === 'tahunBeli' && $orderDirection === 'desc' && $items->count() > 0)
                                            <i class="fa-solid fa-arrow-down-9-1 fa-lg"></i>
                                        @endif
                                    </span>
                                </th>
                                <th scope="col" class="text-center">
                                    <span
                                        @if ($items->count() > 0) wire:click="orderBy('kondisi')" style="cursor: pointer" @endif>KONDISI
                                        @if ($orderBy === 'kondisi' && $orderDirection === 'asc' && $items->count() > 0)
                                            <i class="fa-solid fa-arrow-down-a-z fa-lg"></i>
                                        @elseif ($orderBy === 'kondisi' && $orderDirection === 'desc' && $items->count() > 0)
                                            <i class="fa-solid fa-arrow-down-z-a fa-lg"></i>
                                        @endif
                                    </span>
                                </th>
                                <th scope="col" class="text-center">
                                    <span
                                        @if ($items->count() > 0) wire:click="orderBy('harga')" style="cursor: pointer" @endif>HARGA
                                        @if ($orderBy === 'harga' && $orderDirection === 'asc' && $items->count() > 0)
                                            <i class="fa-solid fa-arrow-down-1-9 fa-lg"></i>
                                        @elseif ($orderBy === 'harga' && $orderDirection === 'desc' && $items->count() > 0)
                                            <i class="fa-solid fa-arrow-down-9-1 fa-lg"></i>
                                        @endif
                                    </span>
                                </th>
                                <th scope="col" class="text-center">AKSI</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($items as $index => $item)
                                <tr class="align-middle">
                                    <td class="text-center ps-4">
                                        <div class="form-check">
                                            <input wire:model="selectedRows"
                                                class="form-check-input focus-ring focus-ring-light" type="checkbox"
                                                value="{{ $item->id }}" id="{{ $item->id }}"
                                                style="cursor: pointer">
                                        </div>
                                    </td>
                                    <td class="text-center">{{ $items->firstItem() + $index }}
                                    </td>
                                    <td wire:click.prevent="readItem({{ $item }})" class="text-center"
                                        data-bs-toggle="tooltip" data-bs-title="Detail" style="cursor: pointer">
                                        {{ $item->kode }}
                                    </td>
                                    <td wire:click.prevent="readItem({{ $item }})" data-bs-toggle="tooltip"
                                        data-bs-title="Detail" style="cursor: pointer">
                                        {{ $item->nama }}
                                    </td>
                                    <td class="text-center">{{ $item->nomorRegister }}</td>
                                    <td class="text-center">{{ $item->kategori }}</td>
                                    <td class="text-center">{{ $item->tahunBeli }}</td>
                                    <td class="text-center">{{ $item->kondisi }}</td>
                                    <td class="text-end pe-3">Rp
                                        {{ number_format($item->harga, 2, ',', '.') }}</td>
                                    <td class="text-center">
                                        <a href="{{ "items/$item->id" }}" target="_blank"
                                            class="text-decoration-none" data-bs-toggle="tooltip"
                                            data-bs-title="Lihat">
                                            <button type="button"
                                                class="btn btn-sm btn-outline-secondary rounded-3 py-1 px-2 my-1">
                                                <i class="fa-solid fa-up-right-from-square"></i>
                                            </button>
                                        </a>
                                        <button wire:click.prevent="confirmItemUpdate({{ $item }})"
                                            data-bs-toggle="tooltip" data-bs-title="Ubah" type="button"
                                            class="btn btn-sm btn-outline-primary rounded-3 py-1 px-2 my-1 ms-1">
                                            <i class="fa-regular fa-pen-to-square"></i>
                                        </button>
                                        <button wire:click.prevent="confirmItemDelete({{ $item->id }})"
                                            data-bs-toggle="tooltip" data-bs-title="Hapus" type="button"
                                            class="btn btn-sm btn-outline-danger rounded-3 py-1 px-2 my-1 ms-1">
                                            <i class="fa-regular fa-trash-can"></i>
                                        </button>
                                    </td>
                                </tr>

                            @empty
                                <tr>
                                    <td colspan="10" class="text-center py-5">Data barang tidak ditemukan</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Paginate --}}
                {{ $items->links() }}
            </div>
        </div>
    </div>

    {{-- Create Update Modal --}}
    <div wire:ignore.self class="modal fade" id="form" data-bs-backdrop="static" tabindex="-1"
        aria-labelledby="form" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form action="" wire:submit.prevent="{{ $showUpdateModal ? 'updateItem' : 'createItem' }}">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">
                            @if ($showUpdateModal)
                                <span>Ubah Data Barang</span>
                            @else
                                <span>Tambah Data Barang</span>
                            @endif
                        </h1>
                        <button type="button" class="btn-close focus-ring focus-ring-light" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-4">
                            <div class="col-sm">
                                <label for="foto" class="form-label ms-1">Foto</label>
                                @if ($showUpdateModal)
                                    @if ($foto && in_array(strtolower($foto->getClientOriginalExtension()), ['jpg', 'jpeg', 'png', 'gif']))
                                        <img src="{{ $foto->temporaryUrl() }}" class="rounded mx-auto d-block mb-3"
                                            style="width: 150px; height: 150px; object-fit: cover;" alt="">
                                    @else
                                        <img src="{{ $state['photo_url'] ?? '' }}"
                                            class="rounded mx-auto d-block mb-3"
                                            style="width: 150px; height: 150px; object-fit: cover;" alt="">
                                    @endif
                                @else
                                    @if ($foto && in_array(strtolower($foto->getClientOriginalExtension()), ['jpg', 'jpeg', 'png', 'gif']))
                                        <img src="{{ $foto->temporaryUrl() }}" class="rounded mx-auto d-block mb-3"
                                            style="width: 150px; height: 150px; object-fit: cover;" alt="">
                                    @endif
                                @endif
                                <div class="input-group input-group-sm">
                                    <input wire:model="foto" name="foto" type="file"
                                        class="form-control focus-ring focus-ring-light border rounded-2 @error('foto') is-invalid @enderror"
                                        id="foto{{ $iteration }}">
                                    @error('foto')
                                        <div class="invalid-feedback ms-1">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-text ms-1" id="basic-addon4">
                                    <span class="text-danger">*</span>
                                    Maksimal ukuran foto : 2 MB
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 mb-4">
                                <label for="kode" class="form-label ms-1">Kode</label>
                                <div class="input-group input-group-sm">
                                    <input wire:model.lazy="kode" name="kode" type="text"
                                        class="form-control focus-ring focus-ring-light border rounded-2 @error('kode')) is-invalid @enderror"
                                        id="kode" placeholder="Kode">
                                    @error('kode')
                                        <div class="invalid-feedback ms-1">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6 mb-4">
                                <label for="nama" class="form-label ms-1">Nama</label>
                                <div class="input-group input-group-sm">
                                    <input wire:model.lazy="nama" name="nama" type="text"
                                        class="form-control focus-ring focus-ring-light border rounded-2 @error('nama') is-invalid @enderror"
                                        id="nama" placeholder="Nama">
                                    @error('nama')
                                        <div class="invalid-feedback ms-1">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 mb-4">
                                <label for="nomorRegister" class="form-label ms-1">Nomor Register</label>
                                <div class="input-group input-group-sm">
                                    <input wire:model.lazy="nomorRegister" name="nomorRegister" type="text"
                                        class="form-control focus-ring focus-ring-light border rounded-2 @error('nomorRegister') is-invalid @enderror"
                                        id="nomorRegister" placeholder="Nomor Register">
                                    @error('nomorRegister')
                                        <div class="invalid-feedback ms-1">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6 mb-4">
                                <label for="merek" class="form-label ms-1">Merek</label>
                                <div class="input-group input-group-sm">
                                    <input wire:model.lazy="merek" name="merek" type="text"
                                        class="form-control focus-ring focus-ring-light border rounded-2 @error('merek') is-invalid @enderror"
                                        id="merek" placeholder="Merek">
                                    @error('merek')
                                        <div class="invalid-feedback ms-1">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 mb-4">
                                <label for="tipe" class="form-label ms-1">Tipe</label>
                                <div class="input-group input-group-sm">
                                    <input wire:model.lazy="tipe" name="tipe" type="text"
                                        class="form-control focus-ring focus-ring-light border rounded-2 @error('tipe') is-invalid @enderror"
                                        id="tipe" placeholder="Tipe">
                                    @error('tipe')
                                        <div class="invalid-feedback ms-1">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6 mb-4">
                                <label for="tahunBeli" class="form-label ms-1">Tahun Pembelian</label>
                                <div class="input-group input-group-sm">
                                    <input wire:model.lazy="tahunBeli" id="tahunBeli" name="tahunBeli"
                                        type="number"
                                        class="form-control focus-ring focus-ring-light border rounded-2 @error('tahunBeli') is-invalid @enderror"
                                        id="tahunBeli" placeholder="Tahun Pembelian">
                                    @error('tahunBeli')
                                        <div class="invalid-feedback ms-1">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 mb-4">
                                <label for="kondisi" class="form-label ms-1">Kondisi</label>
                                <div class="input-group input-group-sm">
                                    <select wire:model.lazy="kondisi" name="kondisi"
                                        class="form-select focus-ring focus-ring-light border rounded-2 @error('kondisi') is-invalid @enderror">
                                        <option value="">Pilih</option>
                                        <option value="Baik">Baik</option>
                                        <option value="Rusak Ringan">Rusak Ringan</option>
                                        <option value="Rusak Berat">Rusak Berat</option>
                                    </select>
                                    @error('kondisi')
                                        <div class="invalid-feedback ms-1">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6 mb-4">
                                <label for="harga" class="form-label ms-1">Harga</label>
                                <div class="input-group input-group-sm">
                                    <input wire:model.lazy="harga" name="harga" type="number"
                                        class="form-control focus-ring focus-ring-light border rounded-2 @error('harga') is-invalid @enderror"
                                        id="harga" placeholder="Harga">
                                    @error('harga')
                                        <div class="invalid-feedback ms-1">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 mb-4">
                                <label for="keterangan" class="form-label ms-1">Keterangan</label>
                                <div class="input-group input-group-sm">
                                    <input wire:model.lazy="keterangan" name="keterangan" type="text"
                                        class="form-control focus-ring focus-ring-light border rounded-2 @error('keterangan') is-invalid @enderror"
                                        id="keterangan" placeholder="Keterangan">
                                    @error('keterangan')
                                        <div class="invalid-feedback ms-1">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6 mb-4">
                                <label for="kategori" class="form-label ms-1">Kategori</label>
                                <div class="input-group input-group-sm">
                                    <select wire:model.lazy="kategori" name="kategori"
                                        class="form-select focus-ring focus-ring-light border rounded-2 @error('kategori') is-invalid @enderror">
                                        <option value="">Pilih</option>
                                        <option value="Elektronik">Eletkronik</option>
                                        <option value="Furniture">Furniture</option>
                                        <option value="Kendaraan">Kendaraan</option>
                                    </select>
                                    @error('kategori')
                                        <div class="invalid-feedback ms-1">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div @if ($kategori != 'Kendaraan') hidden @endif>
                            <div class="row">
                                <div class="col-sm-6 mb-4">
                                    <label for="warna" class="form-label ms-1">Warna</label>
                                    <div class="input-group input-group-sm">
                                        <input wire:model.lazy="warna" name="warna" type="text"
                                            class="form-control focus-ring focus-ring-light border rounded-2 @error('warna') is-invalid @enderror"
                                            id="warna" placeholder="Warna">
                                        @error('warna')
                                            <div class="invalid-feedback ms-1">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-4">
                                    <label for="nomorRangka" class="form-label ms-1">Nomor Rangka</label>
                                    <div class="input-group input-group-sm">
                                        <input wire:model.lazy="nomorRangka" name="nomorRangka" type="text"
                                            class="form-control focus-ring focus-ring-light border rounded-2 @error('nomorRangka') is-invalid @enderror"
                                            id="nomorRangka" placeholder="Nomor Rangka">
                                        @error('nomorRangka')
                                            <div class="invalid-feedback ms-1">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 mb-4">
                                    <label for="nomorMesin" class="form-label ms-1">Nomor Mesin</label>
                                    <div class="input-group input-group-sm">
                                        <input wire:model.lazy="nomorMesin" name="nomorMesin" type="text"
                                            class="form-control focus-ring focus-ring-light border rounded-2 @error('nomorMesin') is-invalid @enderror"
                                            id="nomorMesin" placeholder="Nomor Mesin">
                                        @error('nomorMesin')
                                            <div class="invalid-feedback ms-1">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-4">
                                    <label for="nomorPolisi" class="form-label ms-1">Nomor Polisi</label>
                                    <div class="input-group input-group-sm">
                                        <input wire:model.lazy="nomorPolisi" name="nomorPolisi" type="text"
                                            class="form-control focus-ring focus-ring-light border rounded-2 @error('nomorPolisi') is-invalid @enderror"
                                            id="nomorPolisi" placeholder="Nomor Polisi">
                                        @error('nomorPolisi')
                                            <div class="invalid-feedback ms-1">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 mb-4">
                                    <label for="nomorBpkb" class="form-label ms-1">Nomor BPKB</label>
                                    <div class="input-group input-group-sm">
                                        <input wire:model.lazy="nomorBpkb" name="nomorBpkb" type="text"
                                            class="form-control focus-ring focus-ring-light border rounded-2 @error('nomorBpkb') is-invalid @enderror"
                                            id="nomorBpkb" placeholder="Nomor BPKB">
                                        @error('nomorBpkb')
                                            <div class="invalid-feedback ms-1">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-grid d-md-flex justify-content-md-end mb-2 mt-2">
                            <button type="submit" class="btn btn-success">
                                @if ($showUpdateModal)
                                    <span>Simpan perubahan</span>
                                @else
                                    <span>Simpan</span>
                                @endif
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Read Offcanvas --}}
    <div class="offcanvas offcanvas-start offcanvas-scrollable" tabindex="-1" id="readOffcanvas"
        aria-labelledby="offcanvasExampleLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasExampleLabel">Detail Barang</h5>
            <button type="button" class="btn-close focus-ring focus-ring-light" data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div class="d-flex justify-content-center mt-2 mb-4">
                <img src="{{ $photo_url }}" class="img-fluid rounded-4" alt="" id="offcanvasImg">
            </div>
            <div class="mx-3">
                <div class="row justify-content-between mb-3">
                    <div class="col-5 border pt-3 rounded-3">
                        <dl>
                            <dt class="mb-2">Kode</dt>
                            <dd>{{ $kode }}</dd>
                        </dl>
                    </div>
                    <div class="col-6 border pt-3 rounded-3">
                        <dl>
                            <dt class="mb-2">Nama</dt>
                            <dd>{{ $nama }}</dd>
                        </dl>
                    </div>
                </div>
                <div class="row justify-content-between mb-3">
                    <div class="col-5 border pt-3 rounded-3">
                        <dl>
                            <dt class="mb-2">Nomor Register</dt>
                            <dd>{{ $nomorRegister }}</dd>
                        </dl>
                    </div>
                    <div class="col-6 border pt-3 rounded-3">
                        <dl>
                            <dt class="mb-2">Merek</dt>
                            <dd>{{ $merek }}</dd>
                        </dl>
                    </div>
                </div>
                <div class="row justify-content-between mb-3">
                    <div class="col-5 border pt-3 rounded-3">
                        <dl>
                            <dt class="mb-2">Tipe</dt>
                            <dd>{{ $tipe }}</dd>
                        </dl>
                    </div>
                    <div class="col-6 border pt-3 rounded-3">
                        <dl>
                            <dt class="mb-2">Tahun Pembelian</dt>
                            <dd>{{ $tahunBeli }}</dd>
                        </dl>
                    </div>
                </div>
                <div class="row justify-content-between mb-3">
                    <div class="col-5 border pt-3 rounded-3">
                        <dl>
                            <dt class="mb-2">Kondisi</dt>
                            <dd>{{ $kondisi }}</dd>
                        </dl>
                    </div>
                    <div class="col-6 border pt-3 rounded-3">
                        <dl>
                            <dt class="mb-2">Harga</dt>
                            <dd>Rp {{ number_format($hargaDetail, 2, ',', '.') }}</dd>
                        </dl>
                    </div>
                </div>
                <div class="row justify-content-between mb-3">
                    <div class="col-5 border pt-3 rounded-3">
                        <dl>
                            <dt class="mb-2">Keterangan</dt>
                            <dd>{{ $keterangan }}</dd>
                        </dl>
                    </div>
                    <div class="col-6 border pt-3 rounded-3">
                        <dl>
                            <dt class="mb-2">Kategori</dt>
                            <dd>{{ $kategori }}</dd>
                        </dl>
                    </div>
                </div>
                <div @if ($kategori != 'Kendaraan') hidden @endif>
                    <div class="row justify-content-between mb-3">
                        <div class="col-5 border pt-3 rounded-3">
                            <dl>
                                <dt class="mb-2">Warna</dt>
                                <dd>{{ $warna }}</dd>
                            </dl>
                        </div>
                        <div class="col-6 border pt-3 rounded-3">
                            <dl>
                                <dt class="mb-2">Nomor Rangka</dt>
                                <dd>{{ $nomorRangka }}</dd>
                            </dl>
                        </div>
                    </div>
                    <div class="row justify-content-between mb-3">
                        <div class="col-5 border pt-3 rounded-3">
                            <dl>
                                <dt class="mb-2">Nomor Mesin</dt>
                                <dd>{{ $nomorMesin }}</dd>
                            </dl>
                        </div>
                        <div class="col-6 border pt-3 rounded-3">
                            <dl>
                                <dt class="mb-2">Nomor Polisi</dt>
                                <dd>{{ $nomorPolisi }}</dd>
                            </dl>
                        </div>
                    </div>
                    <div class="row justify-content-between mb-3">
                        <div class="col-5 border pt-3 rounded-3">
                            <dl>
                                <dt class="mb-2">Nomor BPKB</dt>
                                <dd>{{ $nomorBpkb }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Delete Modal --}}
    <div wire:ignore.self class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModal"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <button type="button" class="btn-close focus-ring focus-ring-light" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body text-center text-secondary">
                    <div class="row mx-2">
                        @if ($showDeleteModal)
                            <div class="col">
                                <i class="fa-solid fa-trash-can fs-1"></i>
                            </div>
                            <span class="mt-4 fs-6">Apakah anda yakin ingin menghapus ini?</span>
                        @else
                            <div class="col">
                                <i class="fa-solid fa-trash-can fs-1"></i>
                            </div>
                            <span class="mt-4 fs-6">Apakah anda yakin ingin menghapus data yang dipilih?</span>
                        @endif
                    </div>
                    <div class="d-grid d-md-flex justify-content-md-center mb-3 mt-4 mx-3">
                        @if ($showDeleteModal)
                            <button wire:click.prevent="deleteItem" type="button" class="btn btn-danger mb-2">
                                <span>Hapus</span>
                            </button>
                        @else
                            <button wire:click.prevent="deleteSelectedRows" type="button"
                                class="btn btn-danger mb-2">
                                <span>Hapus</span>
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Import Modal --}}
    <div wire:ignore.self class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModal"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">
                        <span>Import</span>
                    </h1>
                    <button type="button" class="btn-close focus-ring focus-ring-light" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form action="" wire:submit.prevent="importItems">
                    <div class="modal-body">
                        <div class="input-group input-group-sm mt-2">
                            <input wire:model="fileImport" name="fileImport" type="file"
                                class="form-control focus-ring focus-ring-light border rounded-2 @error('fileImport') is-invalid @enderror"
                                id="fileImport{{ $iteration }}">
                            @error('fileImport')
                                <div class="invalid-feedback ms-1">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-text ms-1 mt-2" id="basic-addon4">
                            Unduh <a class="link-body-emphasis link-underline link-underline-opacity-0"
                                href="docs/contoh-format-import.xlsx">contoh format excel</a>
                        </div>
                        <div class="d-grid d-md-flex justify-content-md-end mb-2 mt-3">
                            <button type="submit" class="btn btn-success">
                                <span>Import</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Alert Success --}}
    @include('partials.alert-success')

</div>
