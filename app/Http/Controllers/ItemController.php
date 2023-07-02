<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Barryvdh\DomPDF\Facade\Pdf;

class ItemController extends Controller
{
    public function index()
    {
        return view ('items.index');
    }

    public function show(Item $item)
    {
        return view ('items.show', [
            'item' => $item
        ]);
    }

    public function exportQR()
    {
        $fileName = 'qrcode.pdf';
        $folderPath = 'export';
        $filePath = $folderPath . '/' . $fileName;
        $file = Storage::disk('public')->path($filePath);
        $headers = ['Content-Type: application/pdf'];
        return Response::download($file, $fileName, $headers);
    }

    public function exportReport()
    {
        $items = Item::all();
        $totalItems = Item::count();
        $goodItems = Item::where('kondisi', 'Baik')->count();
        $ldItems = Item::where('kondisi', 'Rusak Ringan')->count();
        $hdItems = Item::where('kondisi', 'Rusak Berat')->count();
        $electronics = Item::where('kategori', 'Elektronik')->count();
        $furnitures = Item::where('kategori', 'Furniture')->count();
        $vehicles = Item::where('kategori', 'Kendaraan')->count();
        $totalAssets = Item::sum('harga');

        $report = PDF::loadview('items.export-report', [
            'items' => $items,
            'totalItems' => $totalItems,
            'goodItems' => $goodItems,
            'ldItems' => $ldItems,
            'hdItems' => $hdItems,
            'electronics' => $electronics,
            'furnitures' => $furnitures,
            'vehicles' => $vehicles,
            'totalAssets' => $totalAssets,
        ]);
        return $report->download('invoice.pdf');
    }
}
