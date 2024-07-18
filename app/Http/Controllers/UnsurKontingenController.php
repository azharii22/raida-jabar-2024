<?php

namespace App\Http\Controllers;

use App\Exports\UnsurKontingenAdminExport;
use App\Exports\UnsurKontingenExport;
use App\Models\Kategori;
use App\Models\Peserta;
use App\Models\Regency;
use App\Models\Status;
use App\Models\UnsurKontingen;
use App\Models\Villages;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;

class UnsurKontingenController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $kategori = Kategori::orderBy('updated_at', 'DESC')->where('name', '!=', 'Peserta')->get();
        $status = Status::orderBy('name', 'DESC')->get();
        if (auth()->user()->role_id == 1 || auth()->user()->role_id == 4) {
            $regency = Regency::orderBy('name')->get();
            $kategoriNotPeserta = Kategori::whereNotIn('name', ['Peserta'])->pluck('id');
            $unsurKontingen = Peserta::where('villages_id', NULL)->whereIn('kategori_id', $kategoriNotPeserta)->orderBy('updated_at', 'DESC')->get();
            return view('unsurKontingen.index', compact('unsurKontingen', 'kategori', 'status', 'regency'));
        } elseif (auth()->user()->role_id == 2) {
            $kategoriNotPeserta = Kategori::whereNotIn('name', ['Peserta'])->pluck('id');
            $unsurKontingen = Peserta::where('user_id', auth()->user()->id)->whereIn('kategori_id', $kategoriNotPeserta)->orderBy('updated_at', 'DESC')->get();
            return view('unsurKontingen.index', compact('unsurKontingen', 'kategori', 'status'));
        } elseif (auth()->user()->role_id == 3) {
            $kategoriNotPeserta = Kategori::whereNotIn('name', ['Peserta'])->pluck('id');
            $unsurKontingen = Peserta::where('regency_id', auth()->user()->regency_id)->whereIn('kategori_id', $kategoriNotPeserta)->orderBy('regency_id')->get();
            return view('unsurKontingen.index', compact('unsurKontingen', 'kategori', 'status'));
        }
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
            'user_id'   => auth()->user()->id,
        ]));
        Alert::success('Success!', 'Data Created Successfully');
        return back();
    }

    public function show(UnsurKontingen $unsurKontingen)
    {
        return $unsurKontingen;
    }

    public function update(Request $request, $id)
    {
        $unsurKontingen = Peserta::findOrFail($id);
        $unsurKontingen->update(array_merge($request->all(), [
            'user_id' => auth()->user()->id,
        ]));
        Alert::success('Success!', 'Data Updated Successfully');
        return back();
    }

    public function destroy($id)
    {
        $unsurKontingen = Peserta::find($id);
        $unsurKontingen->delete();
        Alert::success('Success!', 'Data Deleted Successfully');
        return back();
    }

    public function uploadFoto(Request $request, $id)
    {
        $unsurKontingen = Peserta::findOrFail($id);
        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
        ], [
            'foto.required' => 'Foto Tidak Boleh Kosong!',
            'foto.image'    => 'Foto Harus Berupa Gambar!',
            'foto.image'    => 'Foto Harus Format jpeg, png, jpg, gif, dan svg',
            'foto.max'      => 'Ukuran Foto Maximal 10 MB!',
        ]);
        $foto = $request->file('foto');
        $nama_foto = time() . '-' . $foto->getClientOriginalName();
        $foto->storeAs('public/img/peserta/foto', $nama_foto);
        $unsurKontingen->update(array_merge($request->all(), [
            'foto' => $nama_foto,
        ]));
        Alert::success('Success!', 'Foto Berhasil Diupload');
        return back();
    }

    public function uploadKta(Request $request, $id)
    {
        $unsurKontingen = Peserta::findOrFail($id);
        $request->validate([
            'KTA' => 'required|image|mimes:jpeg,png,jpg,gif ,svg|max:10240',
        ], [
            'KTA.required' => 'KTA Tidak Boleh Kosong!',
            'KTA.image'    => 'KTA Harus Berupa Gambar!',
            'KTA.mimes'    => 'KTA Harus Format jpeg, png, jpg, gif, dan svg',
            'KTA.max'      => 'Ukuran KTA Maximal 10 MB!',
        ]);
        $kta = $request->file('KTA');
        $nama_kta = time() . '-' . $kta->getClientOriginalName();
        $kta->storeAs('public/img/peserta/kta', $nama_kta);
        $unsurKontingen->update(array_merge($request->all(), [
            'KTA' => $nama_kta,
        ]));
        Alert::success('Success!', 'KTA Berhasil Diupload');
        return back();
    }

    public function uploadAsuransi(Request $request, $id)
    {
        $unsurKontingen = Peserta::findOrFail($id);
        $request->validate([
            'asuransi_kesehatan' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
        ], [
            'asuransi_kesehatan.required' => 'Asuransi Kesehatan Tidak Boleh Kosong!',
            'asuransi_kesehatan.image'    => 'Asuransi Kesehatan Harus Berupa Gambar!',
            'asuransi_kesehatan.mimes'    => 'Asuransi Kesehatan Harus Format jpeg, png , jpg, gif, dan svg',
            'asuransi_kesehatan.max'      => 'Ukuran Asuransi Kesehatan Maximal 10 MB!',
        ]);
        $asuransi = $request->file('asuransi_kesehatan');
        $nama_asuransi = time() . '-' . $asuransi->getClientOriginalName();
        $asuransi->storeAs('public/img/peserta/asuransi-kesehatan', $nama_asuransi);
        $unsurKontingen->update(array_merge($request->all(), [
            'asuransi_kesehatan' => $nama_asuransi,
        ]));
        Alert::success('Success!', 'Asuransi Kesehatan Berhasil Diupload');
        return back();
    }

    public function uploadSertif(Request $request, $id)
    {
        $unsurKontingen = Peserta::findOrFail($id);
        $request->validate([
            'sertif_sfh' => 'required|image|mimes:jpeg,png,jpg,gif ,svg|max:10240',
        ], [
            'sertif_sfh.required' => 'Sertif SFH Tidak Boleh Kosong!',
            'sertif_sfh.image'    => 'Sertif SFH Harus Berupa Gambar!',
            'sertif_sfh.mimes'    => 'Sertif SFH Harus Format jpeg, png, jpg, gif, dan svg',
            'sertif_sfh.max'      => 'Ukuran Sertif SFH Maximal 10 MB!',
        ]);
        $sertif = $request->file('sertif_sfh');
        $nama_sertif = time() . '-' . $sertif->getClientOriginalName();
        $sertif->storeAs('public/img/peserta/sertif-sfh', $nama_sertif);
        $unsurKontingen->update(array_merge($request->all(), [
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
        $date = Carbon::now()->format('d-m-Y');
        if (auth()->user()->role_id == 1 || auth()->user()->role_id == 4) {
            return Excel::download(new UnsurKontingenExport(), 'Unsur-Kontingen ' . config('settings.main.1_app_name') . ' ' . $date . '.xlsx');
        } elseif (auth()->user()->role_id == 2) {
            return Excel::download(new UnsurKontingenExport(), 'Unsur-Kontingen ' . config('settings.main.1_app_name') . ' Wilayah ' . auth()->user()->villages->name . ' ' . $date . '.xlsx');
        } elseif (auth()->user()->role_id == 3) {
            return Excel::download(new UnsurKontingenExport(), 'Unsur-Kontingen ' . config('settings.main.1_app_name') . ' Wilayah ' . auth()->user()->regency->name . ' ' . $date . '.xlsx');
        }
    }


    public function exportPDF()
    {
        $date = Carbon::now()->format('d-m-Y');
        $kategoriNotPeserta = Kategori::whereNotIn('name', ['Peserta'])->pluck('id');
        if (auth()->user()->role_id == 1 || auth()->user()->role_id == 4) {
            $data = Peserta::where('villages_id', NULL)->whereIn('kategori_id', $kategoriNotPeserta)->orderBy('updated_at', 'DESC')->get();
            $pdf = Pdf::loadView('unsurKontingen.pdf-admin', compact('data'))->setPaper('a3', 'landscape');
            return $pdf->download('Unsur-Kontingen ' . config('settings.main.1_app_name') . ' ' . $date . '.pdf');
        } elseif (auth()->user()->role_id == 2) {
            $data = Peserta::where('user_id', auth()->user()->id)->whereIn('kategori_id', $kategoriNotPeserta)->orderBy('updated_at', 'DESC')->get();
            $pdf = Pdf::loadView('unsurKontingen.pdf-admin', compact('data'))->setPaper('a3', 'landscape');
            return $pdf->download('Unsur-Kontingen ' . config('settings.main.1_app_name') . ' Wilayah ' . auth()->user()->villages->name . ' ' . $date . '.pdf');
        } elseif (auth()->user()->role_id == 3) {
            $data = Peserta::where('regency_id', auth()->user()->regency_id)->whereIn('kategori_id', $kategoriNotPeserta)->orderBy('regency_id')->get();
            $pdf = Pdf::loadView('unsurKontingen.pdf-admin', compact('data'))->setPaper('a3', 'landscape');
            return $pdf->download('Unsur-Kontingen ' . config('settings.main.1_app_name') . ' Wilayah ' . auth()->user()->regency->name . ' ' . $date . '.pdf');
        }
    }

    public function detailRegency($id)
    {
        $kategori = Kategori::orderBy('updated_at', 'DESC')->where('name', '!=', 'Peserta')->get();
        $status = Status::orderBy('name', 'DESC')->get();
        $villages = Villages::where('regency_id', $id)->get();
        $pesertaVillages = Villages::where('regency_id', $id)->first();
        $unsurKontingen = Peserta::where('villages_id', NULL)->get();
        return view('unsurKontingen.detail', compact('villages', 'unsurKontingen', 'pesertaVillages', 'id', 'kategori', 'status'));
    }
}
