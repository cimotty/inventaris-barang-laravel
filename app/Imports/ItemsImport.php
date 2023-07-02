<?php

namespace App\Imports;

use App\Models\Item;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ItemsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function model(array $row)
    {
        return new Item([
            'kode' => $row['kode'],
            'nama' => $row['nama'],
            'nomorRegister' => str_pad($row['no_register'], 6, '0', STR_PAD_LEFT),
            'merek' => $row['merek'],
            'tipe' => $row['tipe'],
            'tahunBeli' => $row['tahun_beli'],
            'kategori' => $row['kategori'],
            'warna' => $row['warna'],
            'nomorRangka' => $row['no_rangka'],
            'nomorMesin' => $row['no_mesin'],
            'nomorPolisi' => $row['no_polisi'],
            'nomorBpkb' => $row['no_bpkb'],
            'kondisi' => $row['kondisi'],
            'harga' => $row['harga'],
            'keterangan' => $row['keterangan'],
        ]);
    }
}
