<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Imports\ItemsImport;
use App\Jobs\ExportQrJob;
use App\Models\Item;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class ItemsTable extends Component
{
    use WithFileUploads;
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $fileImport;
    public $item;
    public $itemIdBeingDeleted = null;
    public $iteration = 0;
    public $orderBy = 'tahunBeli';
    public $orderDirection = 'desc';
    public $perPage = 25;
    public $search = '';
    public $selectedRows = [];
    public $selectPageRows = false;
    public $showDeleteModal = false;
    public $showUpdateModal = false;
    public $state = [];

    public $kode, $nama, $nomorRegister, $merek, $tipe, $tahunBeli, $kategori, $warna, $nomorRangka, $nomorMesin,
        $nomorPolisi, $nomorBpkb, $kondisi, $harga, $hargaDetail, $keterangan, $foto, $photo_url;

    public $totalAsset, $totalBarang, $totalBaik, $totalRusakRingan, $totalRusakBerat;

    public function calculateTotal()
    {
        $this->totalAsset = Item::sum('harga');
        $this->totalBarang = Item::count();
        $this->totalBaik = Item::where('kondisi', 'Baik')->count();
        $this->totalRusakRingan = Item::where('kondisi', 'Rusak Ringan')->count();
        $this->totalRusakBerat = Item::where('kondisi', 'Rusak Berat')->count();
    }

    // Sorting
    public function orderBy($field)
    {
        if ($this->orderBy === $field) {
            $this->orderDirection = $this->swapOrderDirection();
        } else {
            $this->orderDirection = 'asc';
        }

        $this->orderBy = $field;
    }

    public function swapOrderDirection()
    {
        return $this->orderDirection === 'asc' ? 'desc' : 'asc';
    }
    // End Sorting

    // Validation
    protected $rules = [
        'kode' => ['required', 'min:3', 'max:50', 'not_regex:/\s/'],
        'nama' => ['required', 'min:3', 'max:50'],
        'nomorRegister' => ['required', 'min:2', 'max:50'],
        'merek' => ['required', 'min:3', 'max:50'],
        'tipe' => ['required', 'min:3', 'max:50'],
        'tahunBeli' => ['required', 'numeric', 'min:1900', 'max:2030'],
        'kategori' => ['required'],
        'warna' => ['nullable', 'max:50'],
        'nomorRangka' => ['nullable', 'max:50'],
        'nomorMesin' => ['nullable', 'max:50'],
        'nomorPolisi' => ['nullable', 'max:50'],
        'nomorBpkb' => ['nullable', 'max:50'],
        'kondisi' => ['required'],
        'harga' => ['required', 'numeric', 'min:1'],
        'keterangan' => ['required', 'min:3', 'max:50'],
        'foto' => ['nullable','image', 'max:2048'],
        'fileImport' => ['required', 'file', 'max:2048', 'mimes:xlsx'],
    ];
    
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
    // End Validation

    // Searching
    public function getItemsProperty()
    {
        return Item::search($this->search)
                ->orderBy($this->orderBy, $this->orderDirection)
                ->paginate($this->perPage);
    }

    public function updatingPerPage(): void
    {
        $this->gotoPage(1);
    }

    public function updatingSearch(): void
    {
        $this->gotoPage(1);
    }
    // End Searching

    // Select All
    public function updatedSelectPageRows($value)
    {
        if ($value) {
            $this->selectedRows = $this->items->pluck('id')->map(function ($id) {
                return (string) $id;
            });
        } else {
            $this->reset(['selectedRows', 'selectPageRows']);
        }
    }

    // Delete Selected
    public function confirmDeleteSelectedRows()
    {
        $this->showDeleteModal = false;

        $this->dispatchBrowserEvent('show-delete-modal');
    }

    public function deleteSelectedRows()
    {
        $selectedItems = Item::whereIn('id', $this->selectedRows)->get();

        Item::whereIn('id', $this->selectedRows)->delete();

        foreach ($selectedItems as $item) {
            if ($item->photo!=null) {
                Storage::disk('photos')->delete($item->photo);
            }
        }

        ExportQrJob::dispatch()->delay(now()->addSeconds(10));

        $this->reset(['selectedRows', 'selectPageRows']);
        $this->gotoPage(1);
        $this->dispatchBrowserEvent('hide-delete-modal');
        session()->flash('successMessage', 'Data barang yang dipilih berhasil dihapus!<br>Kode QR diproses secara otomatis setelah 10 detik');
    }
    // End Delete Selected

    // CRUD
    public function confirmItemCreate()
    {
        $this->fileImport = null;
        $this->iteration++;
        $this->reset();
        $this->resetValidation();
        
        $this->showUpdateModal = false;
        
        $this->dispatchBrowserEvent('show-form');
    }

    public function createItem()
    {
        if ($this->kategori != 'Kendaraan') {
            $validatedData = $this->validate([
                'kode' => ['required', 'min:3', 'max:50', 'not_regex:/\s/'],
                'nama' => ['required', 'min:3', 'max:50'],
                'nomorRegister' => ['required', 'min:2', 'max:50'],
                'merek' => ['required', 'min:3', 'max:50'],
                'tipe' => ['required', 'min:3', 'max:50'],
                'tahunBeli' => ['required', 'numeric', 'min:1900', 'max:2030'],
                'kategori' => ['required'],
                'warna' => ['nullable', 'max:50'],
                'nomorRangka' => ['nullable', 'max:50'],
                'nomorMesin' => ['nullable', 'max:50'],
                'nomorPolisi' => ['nullable', 'max:50'],
                'nomorBpkb' => ['nullable', 'max:50'],
                'kondisi' => ['required'],
                'harga' => ['required', 'numeric', 'min:1'],
                'keterangan' => ['required', 'min:3', 'max:50'],
                'foto' => ['nullable','image', 'max:2048'],
            ]);
        } else {
            $validatedData = $this->validate([
                'kode' => ['required', 'min:3', 'max:50', 'not_regex:/\s/'],
                'nama' => ['required', 'min:3', 'max:50'],
                'nomorRegister' => ['required', 'min:2', 'max:50'],
                'merek' => ['required', 'min:3', 'max:50'],
                'tipe' => ['required', 'min:3', 'max:50'],
                'tahunBeli' => ['required', 'numeric', 'min:1900', 'max:2030'],
                'kategori' => ['required'],
                'warna' => ['required', 'max:50'],
                'nomorRangka' => ['required', 'max:50'],
                'nomorMesin' => ['required', 'max:50'],
                'nomorPolisi' => ['required', 'max:50'],
                'nomorBpkb' => ['required', 'max:50'],
                'kondisi' => ['required'],
                'harga' => ['required', 'numeric', 'min:1'],
                'keterangan' => ['required', 'min:3', 'max:50'],
                'foto' => ['nullable', 'image', 'max:2048'],
            ]);
        }

        if ($this->foto) {
            $validatedData['photo'] = $this->foto->store('/', 'photos');
        }

        Item::create($validatedData);

        $this->foto=null;
        $this->iteration++;

        ExportQrJob::dispatch()->delay(now()->addSeconds(10));
        
        $this->dispatchBrowserEvent('hide-form');
        session()->flash('successMessage', 'Data barang berhasil ditambahkan!<br>Kode QR diproses secara otomatis setelah 10 detik');
    }
    
    public function readItem(Item $item)
    {
        $this->kode = $item->kode;
        $this->nama = $item->nama;
        $this->nomorRegister = $item->nomorRegister;
        $this->merek = $item->merek;
        $this->tipe = $item->tipe;
        $this->tahunBeli = $item->tahunBeli;
        $this->kategori = $item->kategori;
        $this->warna = $item->warna;
        $this->nomorRangka = $item->nomorRangka;
        $this->nomorMesin = $item->nomorMesin;
        $this->nomorPolisi = $item->nomorPolisi;
        $this->nomorBpkb = $item->nomorBpkb;
        $this->kondisi = $item->kondisi;
        $this->hargaDetail = $item->harga;
        $this->keterangan = $item->keterangan;
        $this->foto = $item->foto;
        $this->photo_url = $item->photo_url;

        $this->dispatchBrowserEvent('show-offcanvas');
    }
    
    public function confirmItemUpdate(Item $item)
    {
        $this->showUpdateModal = true;

        $this->item = $item;

        $this->kode = $item->kode;
        $this->nama = $item->nama;
        $this->nomorRegister = $item->nomorRegister;
        $this->merek = $item->merek;
        $this->tipe = $item->tipe;
        $this->tahunBeli = $item->tahunBeli;
        $this->kategori = $item->kategori;
        $this->warna = $item->warna;
        $this->nomorRangka = $item->nomorRangka;
        $this->nomorMesin = $item->nomorMesin;
        $this->nomorPolisi = $item->nomorPolisi;
        $this->nomorBpkb = $item->nomorBpkb;
        $this->kondisi = $item->kondisi;
        $this->harga = $item->harga;
        $this->keterangan = $item->keterangan;
        $this->foto = $item->foto;
        
        $this->state = $item->toArray();

        $this->resetValidation();
        $this->dispatchBrowserEvent('show-form');
    }

    public function updateItem()
    {
        if ($this->kategori != 'Kendaraan') {
            $validatedData = $this->validate([
                'kode' => ['required', 'min:3', 'max:50', 'not_regex:/\s/'],
                'nama' => ['required', 'min:3', 'max:50'],
                'nomorRegister' => ['required', 'min:2', 'max:50'],
                'merek' => ['required', 'min:3', 'max:50'],
                'tipe' => ['required', 'min:3', 'max:50'],
                'tahunBeli' => ['required', 'numeric', 'min:1900', 'max:2030'],
                'kategori' => ['required'],
                'warna' => ['nullable', 'max:50'],
                'nomorRangka' => ['nullable', 'max:50'],
                'nomorMesin' => ['nullable', 'max:50'],
                'nomorPolisi' => ['nullable', 'max:50'],
                'nomorBpkb' => ['nullable', 'max:50'],
                'kondisi' => ['required'],
                'harga' => ['required', 'numeric', 'min:1'],
                'keterangan' => ['required', 'min:3', 'max:50'],
                'foto' => ['nullable','image', 'max:2048'],
            ]);
        } else {
            $validatedData = $this->validate([
                'kode' => ['required', 'min:3', 'max:50', 'not_regex:/\s/'],
                'nama' => ['required', 'min:3', 'max:50'],
                'nomorRegister' => ['required', 'min:2', 'max:50'],
                'merek' => ['required', 'min:3', 'max:50'],
                'tipe' => ['required', 'min:3', 'max:50'],
                'tahunBeli' => ['required', 'numeric', 'min:1900', 'max:2030'],
                'kategori' => ['required'],
                'warna' => ['required', 'max:50'],
                'nomorRangka' => ['required', 'max:50'],
                'nomorMesin' => ['required', 'max:50'],
                'nomorPolisi' => ['required', 'max:50'],
                'nomorBpkb' => ['required', 'max:50'],
                'kondisi' => ['required'],
                'harga' => ['required', 'numeric', 'min:1'],
                'keterangan' => ['required', 'min:3', 'max:50'],
                'foto' => ['nullable','image', 'max:2048'],
            ]);
        }

        if ($this->foto && $this->item->photo!=null) {
            Storage::disk('photos')->delete($this->item->photo);
            $validatedData['photo'] = $this->foto->store('/', 'photos');
        } else if ($this->foto) {
            $validatedData['photo'] = $this->foto->store('/', 'photos');
        }
            
        $this->item->update($validatedData);

        $this->foto=null;
        $this->iteration++;

        ExportQrJob::dispatch()->delay(now()->addSeconds(10));
        
        $this->dispatchBrowserEvent('hide-form');
        session()->flash('successMessage', 'Data barang berhasil diubah!<br>Kode QR diproses secara otomatis setelah 10 detik');
    }
    
    public function confirmItemDelete($id)
    {
        $this->itemIdBeingDeleted = $id;
        $this->showDeleteModal = true;

        $this->dispatchBrowserEvent('show-delete-modal');
    }
    
    public function deleteItem()
    {
        $item = Item::findOrFail($this->itemIdBeingDeleted);
        $item->delete();

        if ($item->photo!=null) {
            Storage::disk('photos')->delete($item->photo);
        }
        
        ExportQrJob::dispatch()->delay(now()->addSeconds(10));
        
        $this->dispatchBrowserEvent('hide-delete-modal');
        session()->flash('successMessage', 'Data barang berhasil dihapus!<br>Kode QR diproses secara otomatis setelah 10 detik');
    } 
    // End CRUD

    // Import
    public function confirmImport()
    {
        $this->fileImport = null;
        $this->iteration++;
        $this->resetValidation();
        $this->dispatchBrowserEvent('show-import-modal');
    }

    public function importItems()
    {
        $this->validateOnly('fileImport');

        $fileName = $this->fileImport->getClientOriginalName();
        $path = $this->fileImport->storeAs('import', $fileName, 'local');

        try {
            Excel::import(new ItemsImport, $path);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('hide-import-modal');
            session()->flash('errorMessage', 'Pastikan isian Excel yang diupload sesuai format!');
            return;
        }

        $this->fileImport = null;
        $this->iteration++;

        ExportQrJob::dispatch()->delay(now()->addSeconds(10));

        $this->dispatchBrowserEvent('hide-import-modal');
        session()->flash('successMessage', 'Import Berhasil!<br>Kode QR diproses secara otomatis setelah 10 detik');
    }
    // End Import

    public function render()
    {
        $items = $this->items;
        $this->calculateTotal();

        return view('livewire.items-table', [
            'items' => $items,
        ]);
    }
}
