<?php

namespace App\Http\Controllers;

use App\Exports\PembayaranExport;
use App\Models\Partisipan;
use App\Models\Pembayaran;
use App\Models\Role;
use App\Models\Status;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;

class PembayaranController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (Auth::user()->role_id == 1) {
            $pembayaran = Pembayaran::with('user')->orderBy('user_id', 'ASC')->get();
            $terdaftar  = Pembayaran::sum('jumlah_terdaftar');
            $nominal    = Pembayaran::sum('nominal');
            $status     = Status::orderBy('name', 'ASC')->get();
        } else {
            $pembayaran = Pembayaran::with('user')->where('user_id', auth()->user()->id)->orderBy('user_id', 'ASC')->get();
            $terdaftar  = Pembayaran::where('user_id', auth()->user()->id)->sum('jumlah_terdaftar');
            $nominal    = Pembayaran::where('user_id', auth()->user()->id)->sum('nominal');
            $status     = Status::orderBy('name', 'ASC')->get();
            // $partisipan = Partisipan::get();
        }
        return view('pembayaran.index', compact([
            // 'partisipan',
            'pembayaran',
            'terdaftar',
            'nominal',
            'status',
        ]));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jumlah_terdaftar' => 'required',
            'nominal' => 'required',
            'file' => 'required|mimes:png,jpg,jpeg|max:2048',
        ], [
            'jumlah_terdaftar.required' => 'Jumlah Terdaftar harus diisi',
            'nominal.required' => 'Nominal harus diisi',
            'file.required' => 'File harus diisi',
            'file.mimes' => 'Format gambar harus png, jpg, atau jpeg',
            'file.max' => 'File tidak boleh lebih dari 2 MB',

        ]);
        $status = Status::where('name', 'Terkirim')->first();
        $image = $request->file('file');
        $image->storeAs('public/pembayaran/', $image->hashName());
        Pembayaran::create(array_merge($request->all(), [
            'file'  => $image->hashName(),
            'tanggal_upload'    => Carbon::now()->format('Y-m-d H:i:s'),
            'user_id'           => Auth::user()->id,
            'status_id'           => $status->id
        ]));
        Alert::success('Success!', 'Data has been created');
        return back();
    }

    public function show(Pembayaran $pembayaran)
    {
        return $pembayaran;
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'jumlah_terdaftar'  => 'required',
            'nominal'           => 'required',
            'file'              => 'mimes:png,jpg,jpeg|max:2048',
        ], [
            'jumlah_terdaftar.required' => 'Jumlah Terdaftar harus diisi',
            'nominal.required' => 'Nominal harus diisi',
            'file.mimes' => 'Format gambar harus png, jpg, atau jpeg',
            'file.max' => 'File tidak boleh lebih dari 2 MB',
        ]);
        $pembayaran = Pembayaran::find($id);
        //check if image is uploaded
        if ($request->hasFile('file')) {

            $image = $request->file('file');
            $image->storeAs('public/pembayaran/', $image->hashName());
            Storage::delete('public/pembayaran/' . $pembayaran->file);
            $pembayaran->update(array_merge($request->all(), [
                'file'  => $image->hashName(),
                'tanggal_upload'    => Carbon::now()->format('Y-m-d H:i:s'),
                'user_id'           => Auth::user()->id
            ]));
        } else {
            $pembayaran->update($request->all());
        };
        Alert::success('Success!', 'Data has been updated');
        return back();
    }

    public function destroy($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        Storage::delete('public/pembayaran/' . $pembayaran->file);
        $pembayaran->delete();
        Alert::success('Success!', 'Data has been deleted');
        return redirect()->back();
    }

    public function verifikasiPembayaran(Request $request, $id)
    {
        $detail = Pembayaran::find($id);
        $detail->update($request->all());
        Alert::success('Success!', 'Status has been updated');
        return redirect()->back();
    }

    public function export()
    {
        return Excel::download(new PembayaranExport, 'Pembayaran.xlsx');
    }
}
