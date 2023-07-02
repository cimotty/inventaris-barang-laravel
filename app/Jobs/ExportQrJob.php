<?php

namespace App\Jobs;

use App\Models\Item;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Generator;

class ExportQrJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct()
    {
        //
    }

    public function handle(): void
    {
        $items = Item::all();
        $qr = new Generator();
        $qrcodes = [];

        foreach ($items as $item) {
            $qrcode = base64_encode($qr->encoding('UTF-8')->format('png')->size(80)->generate("http:192.168.1.12:8000/items/$item->id"));
            $qrcodes[] = $qrcode;
        }

        $qrpdf = PDF::loadview('items.export-qr', [
            'items' => $items,
            'qrcodes' => $qrcodes,
        ]);

        $folderPath = 'export';
        $fileName = 'qrcode.pdf';
        $filePath = $folderPath . '/' . $fileName;
        
        Storage::disk('public')->makeDirectory($folderPath);
        $qrpdf->save(Storage::disk('public')->path($filePath));
    }
}
