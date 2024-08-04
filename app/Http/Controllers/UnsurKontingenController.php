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
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class UnsurKontingenController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function showRegencies()
    {
        return view('unsurKontingen.index');
    }

    public function showPeserta($regency_id)
    {
        // $villages   = Villages::with('regency')->find($regency_id);
        $kategori   = Kategori::orderBy('name')->get();
        $status     = Status::orderBy('name')->get();
        $unsurKontingen    = Peserta::with('regency')->where('regency_id', $regency_id)->where('villages_id', NULL)->orderBy('nama_lengkap')->get();
        return view('unsurKontingen.detail', compact('regency_id', 'kategori', 'unsurKontingen', 'status'));
    }

    public function getRegencies(Request $request)
    {
        if ($request->ajax()) {
            $regencies = Regency::all();
            $kategoriNotPeserta = Kategori::whereNotIn('name', ['Peserta'])->pluck('id');
            return DataTables::of($regencies)
                ->addIndexColumn()
                ->addColumn('jumlah_pendaftar', function ($row) use($kategoriNotPeserta) {
                    $regency = $row->peserta->where('regency_id', $row->id)->where('villages_id', NULL)->whereIn('kategori_id', $kategoriNotPeserta)->count() ?? '';
                    return "$regency" . " Unsur Kontingen Cabang";
                })
                ->addColumn('action', function ($row) {
                    return '<a href="' . route('data.showKontingen', $row->id) . '" class="view-villages btn btn-success btn-sm" data-id="' . $row->id . '">Lihat <i class="bx bx-right-arrow-alt"></i></a>';
                })
                ->make(true);
        }
    }

    public function getPeserta($regency_id, Request $request)
    {
        if ($request->ajax()) {
            $kategoriNotPeserta = Kategori::whereNotIn('name', ['Peserta'])->pluck('id');
            $peserta = Peserta::with('user', 'kategori', 'status', 'regency', 'villages')
                ->where('regency_id', $regency_id)
                ->where('villages_id', NULL)
                ->whereIn('kategori_id', $kategoriNotPeserta)
                ->get();
            return DataTables::of($peserta)
                ->addIndexColumn()
                ->addColumn('wilayah_cabang', function ($row) {
                    $peserta = $row->regency->name ?? '';
                    return "$peserta";
                })
                ->addColumn('jenis_kelamin', function ($row) {
                    $cowo = $row->jenis_kelamin == 1;
                    if ($cowo) {
                        return 'Laki - Laki';
                    } else {
                        return 'Perempuan';
                    }
                })
                ->addColumn('kategori', function ($row) {
                    $peserta = $row->kategori->name ?? '';
                    return "$peserta";
                })
                ->addColumn('status', function ($row) {
                    $peserta = $row->status->name ?? '';
                    return "$peserta";
                })
                ->addColumn('berkas_peserta', function ($row) {
                    $buttons = '';
                    if ($row->foto) {
                        $buttons .= '<a class="btn btn-success waves-effect waves-light btn-sm mr-2" href="' . Storage::url('public/img/peserta/foto/' . $row->foto) . '" target="_blank"><i class="bx bx-check-circle"></i> Foto</a>';
                    } else {
                        $buttons .= '<button type="button" class="btn btn-warning waves-effect waves-light btn-sm mr-2" data-bs-toggle="modal" data-bs-target="#modal-foto-' . $row->id . '"><i class="bx bx-upload"></i> Foto</button>';
                    }
                    if ($row->KTA) {
                        $buttons .= '<a class="btn btn-success waves-effect waves-light btn-sm mr-2" href="' . Storage::url('public/img/peserta/kta/' . $row->KTA) . '" target="_blank"><i class="bx bx-check-circle"></i> KTA</a>';
                    } else {
                        $buttons .= '<button type="button" class="btn btn-warning waves-effect waves-light btn-sm mr-2" data-bs-toggle="modal" data-bs-target="#modal-kta-' . $row->id . '"><i class="bx bx-upload"></i> KTA</button>';
                    }
                    if ($row->asuransi_kesehatan) {
                        $buttons .= '<a class="btn btn-success waves-effect waves-light btn-sm mr-2" href="' . Storage::url('public/img/peserta/asuransi-kesehatan/' . $row->asuransi_kesehatan) . '" target="_blank"><i class="bx bx-check-circle"></i> Asuransi Kesehatan</a>';
                    } else {
                        $buttons .= '<button type="button" class="btn btn-warning waves-effect waves-light btn-sm mr-2" data-bs-toggle="modal" data-bs-target="#modal-asuransi-' . $row->id . '"><i class="bx bx-upload"></i> Asuransi Kesehatan</button>';
                    }
                    if ($row->sertif_sfh) {
                        $buttons .= '<a class="btn btn-success waves-effect waves-light btn-sm mr-2" href="' . Storage::url('public/img/peserta/sertif-sfh/' . $row->sertif_sfh) . '" target="_blank"><i class="bx bx-check-circle"></i> Sertif SFH</a>';
                    } else {
                        $buttons .= '<button type="button" class="btn btn-warning waves-effect waves-light btn-sm mr-2" data-bs-toggle="modal" data-bs-target="#modal-sertif-' . $row->id . '"><i class="bx bx-upload"></i> Sertif SFH</button>';
                    }
                    return $buttons;
                })
                ->addColumn('action', function ($row) {
                    $buttons = '';
                    if (auth()->user()->role_id == 1 || (auth()->user()->role_id == 4 && $row->status->name != 'Diterima')) {
                        $buttons .= '<button type="button" class="btn btn-info btn-sm mr-2 waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#modal-verifikasi-' . $row->id . '"><i class=" bx bx-check-circle"></i> Verifikasi</button> &nbsp';
                    }
                    $buttons    .= '<button type="button" class="btn btn-light waves-effect waves-light btn-sm mr-2" data-bs-toggle="modal" data-bs-target="#modal-detail-' . $row->id . '"><i class="bx bx-show"></i> Detail</button> &nbsp';
                    if (auth()->user()->role_id == 1 || auth()->user()->role_id == 4) {
                        $buttons .= '<button type="button" class="btn btn-warning waves-effect waves-light btn-sm mr-2" data-bs-toggle="modal" data-bs-target="#modal-edit-' . $row->id . '"><i class="bx bx-pencil"></i> Edit</button> &nbsp';
                        $buttons .= '<button type="button" class="btn btn-danger waves-effect waves-light btn-sm mr-2" data-bs-toggle="modal" data-bs-target="#modal-delete-' . $row->id . '"><i class="bx bx-trash"></i> Delete</button> &nbsp';
                    }
                    return $buttons;
                })
                ->make(true);
        }
    }

    public function index()
    {
        $kategori = Kategori::orderBy('updated_at', 'DESC')->where('name', '!=', 'Peserta')->get();
        $status = Status::orderBy('name', 'DESC')->get();
        if (auth()->user()->role_id == 1 || auth()->user()->role_id == 4) {
            // $regency = Regency::orderBy('name')->get();
            // $kategoriNotPeserta = Kategori::whereNotIn('name', ['Peserta'])->pluck('id');
            // $unsurKontingen = Peserta::where('villages_id', NULL)->whereIn('kategori_id', $kategoriNotPeserta)->orderBy('updated_at', 'DESC')->get();
            // return view('unsurKontingen.index', compact('unsurKontingen', 'kategori', 'status', 'regency'));
            return view('unsurKontingen.indexAdmin', compact('kategori'));
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
