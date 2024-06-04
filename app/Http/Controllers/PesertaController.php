<?php

namespace App\Http\Controllers;

use App\Exports\PesertaAdminExport;
use App\Exports\PesertaExport;
use App\Models\Kategori;
use App\Models\Peserta;
use App\Models\Status;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;

class PesertaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $peserta = Peserta::orderBy('updated_at', 'DESC')->get();
        $kategori = Kategori::orderBy('name', 'DESC')->get();
        $status = Status::orderBy('name', 'DESC')->get();
        return view('peserta.index', compact('peserta', 'kategori', 'status'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap'      => 'required',
            'tempat_lahir'      => 'required',
            'tanggal_lahir'     => 'required',
            'jenis_kelamin'     => 'required',
            'ukuran_kaos'       => 'required',
            'no_hp'             => 'required',
            'kategori_id'       => 'required',
            'agama'             => 'required',
            'golongan_darah'    => 'required',
        ], [
            'nama_lengkap.required'     => 'Nama Lengkap harus diisi!',
            'tempat_lahir.required'     => 'Tempat Lahir harus diisi!',
            'tanggal_lahir.required'    => 'Tanggal Lahir harus diisi!',
            'jenis_kelamin.required'    => 'Jenis Kelamin harus diisi!',
            'ukuran_kaos.required'      => 'Ukuran Kaos harus diisi!',
            'no_hp.required'            => 'No HP harus diisi!',
            'kategori_id.required'      => 'Kategori harus diisi!',
            'agama.required'            => 'Agama harus diisi!',
            'golongan_darah.required'   => 'Golongan Darah harus diisi!',
        ]);

        $status = Status::where('name', 'Terkirim')->first();
        Peserta::create(array_merge($request->all(), [
            'status_id' => $status->id,
            'user_id'   => Auth::user()->id,
        ]));
        Alert::success('Success!', 'Data Created Successfully');
        return back();
    }

    public function show(Peserta $peserta)
    {
        return $peserta;
    }

    public function update(Request $request, $id)
    {
        $peserta = Peserta::findOrFail($id);
        $peserta->update(array_merge($request->all(), [
            'user_id' => Auth::user()->id,
        ]));
        Alert::success('Success!', 'Data Updated Successfully');
        return back();
    }

    public function destroy($id)
    {
        $peserta = Peserta::find($id);
        $peserta->delete();
        Alert::success('Success!', 'Data Deleted Successfully');
        return back();
    }

    public function uploadFoto(Request $request, $id)
    {
        $peserta = Peserta::findOrFail($id);
        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            'foto.required' => 'Foto Tidak Boleh Kosong!',
            'foto.image'    => 'Foto Harus Berupa Gambar!',
            'foto.mimes'    => 'Foto Harus Format jpeg, png, jpg, gif, dan svg',
            'foto.max'      => 'Ukuran Foto Maximal 2 MB!',
        ]);
        $foto = $request->file('foto');
        $nama_foto = time() . '-' . $foto->getClientOriginalName();
        $foto->storeAs('public/img/peserta/foto', $nama_foto);
        $peserta->update(array_merge($request->all(), [
            'foto' => $nama_foto,
        ]));
        Alert::success('Success!', 'Foto Berhasil Diupload');
        return back();
    }

    public function uploadKta(Request $request, $id)
    {
        $peserta = Peserta::findOrFail($id);
        $request->validate([
            'KTA' => 'required|image|mimes:jpeg,png,jpg,gif ,svg|max:2048',
        ], [
            'KTA.required' => 'KTA Tidak Boleh Kosong!',
            'KTA.image'    => 'KTA Harus Berupa Gambar!',
            'KTA.mimes'    => 'KTA Harus Format jpeg, png, jpg, gif, dan svg',
            'KTA.max'      => 'Ukuran KTA Maximal 2 MB!',
        ]);
        $kta = $request->file('KTA');
        $nama_kta = time() . '-' . $kta->getClientOriginalName();
        $kta->storeAs('public/img/peserta/kta', $nama_kta);
        $peserta->update(array_merge($request->all(), [
            'KTA' => $nama_kta,
        ]));
        Alert::success('Success!', 'KTA Berhasil Diupload');
        return back();
    }

    public function uploadAsuransi(Request $request, $id)
    {
        $peserta = Peserta::findOrFail($id);
        $request->validate([
            'asuransi_kesehatan' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            'asuransi_kesehatan.required' => 'Asuransi Kesehatan Tidak Boleh Kosong!',
            'asuransi_kesehatan.image'    => 'Asuransi Kesehatan Harus Berupa Gambar!',
            'asuransi_kesehatan.mimes'    => 'Asuransi Kesehatan Harus Format jpeg, png , jpg, gif, dan svg',
            'asuransi_kesehatan.max'      => 'Ukuran Asuransi Kesehatan Maximal 2 MB!',
        ]);
        $asuransi = $request->file('asuransi_kesehatan');
        $nama_asuransi = time() . '-' . $asuransi->getClientOriginalName();
        $asuransi->storeAs('public/img/peserta/asuransi-kesehatan', $nama_asuransi);
        $peserta->update(array_merge($request->all(), [
            'asuransi_kesehatan' => $nama_asuransi,
        ]));
        Alert::success('Success!', 'Asuransi Kesehatan Berhasil Diupload');
        return back();
    }

    public function uploadSertif(Request $request, $id)
    {
        $peserta = Peserta::findOrFail($id);
        $request->validate([
            'sertif_sfh' => 'required|image|mimes:jpeg,png,jpg,gif ,svg|max:2048',
        ], [
            'sertif_sfh.required' => 'Sertif SFH Tidak Boleh Kosong!',
            'sertif_sfh.image'    => 'Sertif SFH Harus Berupa Gambar!',
            'sertif_sfh.mimes'    => 'Sertif SFH Harus Format jpeg, png, jpg, gif, dan svg',
            'sertif_sfh.max'      => 'Ukuran Sertif SFH Maximal 2 MB!',
        ]);
        $sertif = $request->file('sertif_sfh');
        $nama_sertif = time() . '-' . $sertif->getClientOriginalName();
        $sertif->storeAs('public/img/peserta/sertif-sfh', $nama_sertif);
        $peserta->update(array_merge($request->all(), [
            'sertif_sfh' => $nama_sertif,
        ]));
        Alert::success('Success!', 'Sertif SFH Berhasil Diupload');
        return back();
    }

    public function verifikasi(Request $request, $id)
    {
        $peserta = Peserta::FindOrFail($id);
        $peserta->update($request->all());
        Alert::success('Success!', 'Data Verification Successfully');
        return back();
    }

    public function exportExcel()
    {
        return Excel::download(new PesertaExport(), 'Peserta.xlsx');
    }


    public function exportPDF()
    {
        $data = Peserta::with('kategori', 'user')->get();
        $pdf = Pdf::loadView('peserta.pdf', compact('data'))->setPaper('a4', 'portrait');
        return $pdf->download('Peserta.pdf');
    }
}
