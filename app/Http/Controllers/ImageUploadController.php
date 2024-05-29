<?php

namespace App\Http\Controllers;

use App\Models\DokumentasiKegiatan;
use App\Models\ImageUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ImageUploadController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create($id)
    {
        $dokumentasi = DokumentasiKegiatan::find($id);
        return view('dokumentasiKegiatan.addphotos', compact('dokumentasi'));
    }

    public function store(Request $request, $id)
    {
        $dokumentasi = DokumentasiKegiatan::find($id);
        $image = $request->file('file');
        $fileInfo = $image->getClientOriginalName();
        $filename = pathinfo($fileInfo, PATHINFO_FILENAME);
        $extension = pathinfo($fileInfo, PATHINFO_EXTENSION);
        $file_name = $filename . '-' . time() . '.' . $extension;
        $image->move(public_path('uploads/gallery'), $file_name);

        $imageUpload = new ImageUpload();
        $imageUpload->dokumentasi_id = $dokumentasi->id;
        $imageUpload->user_id = Auth::user()->id;
        $imageUpload->original_filename = $fileInfo;
        $imageUpload->filename = $file_name;
        $imageUpload->save();
        return response()->json(['success' => $file_name]);
    }

    public function getImages()
    {
        $images = ImageUpload::all()->toArray();
        foreach ($images as $image) {
            $tableImages[] = $image['filename'];
        }
        $storeFolder = public_path('uploads/gallery');
        $file_path = public_path('uploads/gallery/');
        $files = scandir($storeFolder);
        foreach ($files as $file) {
            if ($file != '.' && $file != '..' && in_array($file, $tableImages)) {
                $obj['name'] = $file;
                $file_path = public_path('uploads/gallery/') . $file;
                $obj['size'] = filesize($file_path);
                $obj['path'] = url('public/uploads/gallery/' . $file);
                $data[] = $obj;
            }
        }
        //dd($data);
        return response()->json($data);
    }

    public function destroy(Request $request)
    {
        $filename =  $request->get('filename');
        ImageUpload::where('filename', $filename)->delete();
        $path = public_path('uploads/gallery/') . $filename;
        if (file_exists($path)) {
            unlink($path);
        }
        return response()->json(['success' => $filename]);
    }
}
