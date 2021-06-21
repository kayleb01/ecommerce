<?php

namespace App\Http\Controllers;

use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    public function store(Request $request)
    {
        $file = $request->file('product_image');
        $file->store('media/product/'.now()->format('Y').'/'.now()->format('m'), 'public');

        $media = Media::create([
            'filename' => $file->hashName(),
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
            'user_id' => $request->user()->id
        ]);

        return response()->json([
            'media' => $media,
            'message' => 'File uploaded']);

    }

    public function destroy(Media $media)
    {
        Storage::disk('public')
            ->delete('media/product/'.now()->format('Y').'/'.now()->format('m').'/' . $media->filename);

        $media->delete();
        return response()->json([
            'message' => 'deleted'
        ]);

    }
}
