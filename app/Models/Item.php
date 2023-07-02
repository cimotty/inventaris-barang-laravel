<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Item extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public static function search($search)
    {
        return empty($search) ? static::query()
            : static::query()->where('kode', 'like', '%'.$search.'%')
                ->orWhere('nama', 'like', '%'.$search.'%')
                ->orWhere('nomorRegister', 'like', '%'.$search.'%')
                ->orWhere('kategori', 'like', '%'.$search.'%')
                ->orWhere('tahunBeli', 'like', '%'.$search.'%')
                ->orWhere('kondisi', 'like', '%'.$search.'%')
                ->orWhere('harga', 'like', '%'.$search.'%');
    }

    protected $appends = ['photo_url'];

    public function getPhotoUrlAttribute()
    {
        if ($this->photo && Storage::disk('photos')->exists($this->photo)) {
            return Storage::disk('photos')->url($this->photo);
        }

        return asset('img/no-image.jpg');
    }
}
