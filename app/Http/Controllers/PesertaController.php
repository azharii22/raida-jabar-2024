<?php

namespace App\Http\Controllers;

use App\Exports\PesertaAdminExport;
use App\Exports\PesertaExport;
use App\Models\Kategori;
use App\Models\Peserta;
use App\Models\Regency;
use App\Models\Status;
use App\Models\UnsurKontingen;
use App\Models\User;
use App\Models\Villages;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class PesertaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function showRegencies()
    {
        return view('regencies');
    }

    public function showVillages($regency_id)
    {
        $notKontingen = Kategori::where('name', 'LIKE', 'Peserta')->first();
        $peserta    = Peserta::with('regency')
            ->where('villages_id', '!=', NULL)
            ->where('regency_id', $regency_id)
            ->where('kategori_id', $notKontingen->id)
            ->get();
        $regency    = Regency::find($regency_id);
        return view('peserta.detail', compact('regency_id', 'peserta', 'regency'));
    }

    public function showPeserta($villages_id)
    {
        $villages   = Villages::with('regency')->find($villages_id);
        $kategori   = Kategori::orderBy('name')->get();
        $status     = Status::orderBy('name')->get();
        $peserta    = Peserta::with('villages')->where('villages_id', $villages_id)->orderBy('nama_lengkap')->get();
        return view('peserta.detailVillages', compact('villages_id', 'kategori', 'peserta', 'status', 'villages'));
    }

    public function getRegencies(Request $request)
    {
        if ($request->ajax()) {
            $regencies = Regency::all();
            return DataTables::of($regencies)
                ->addIndexColumn()
                ->addColumn('jumlah_pendaftar', function ($row) {
                    $villages = $row->peserta->where('regency_id', $row->id)->where('villages_id', '!=', NULL)->count() ?? '';
                    $regency = $row->peserta->where('regency_id', $row->id)->where('villages_id', NULL)->count() ?? '';
                    return "$villages" . " Peserta " . "& " . "$regency" . " Unsur Kontingen Cabang";
                })
                ->addColumn('action', function ($row) {
                    return '<a href="' . route('data.showVillages', $row->id) . '" class="view-villages btn btn-success btn-sm" data-id="' . $row->id . '">Lihat <i class="bx bx-right-arrow-alt"></i></a>';
                })
                ->make(true);
        }
    }

    public function getVillages($regency_id, Request $request)
    {
        if ($request->ajax()) {
            $villages = Villages::select(['id', 'name'])->where('regency_id', $regency_id);
            return DataTables::of($villages)
                ->addIndexColumn()
                ->addColumn('jumlah_pendaftar', function ($row) {
                    $peserta = $row->peserta->where('villages_id', $row->id)->count() ?? '';
                    return "$peserta" . " Peserta ";
                })
                ->addColumn('action', function ($row) use ($regency_id) {
                    return '<a href="' . route('data.showPeserta', $row->id) . '" class="btn btn-primary btn-sm">View Peserta</a>';
                })
                ->make(true);
        }
    }

    public function getPeserta($villages_id, Request $request)
    {
        if ($request->ajax()) {
            $peserta = Peserta::with('user', 'kategori', 'status', 'regency', 'villages')
                ->where('villages_id', $villages_id)->get();
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
        if (auth()->user()->role_id == 1 || auth()->user()->role_id == 4) {
            // $regency = Regency::orderBy('name')->get();
            // $kategori = Kategori::orderBy('name', 'DESC')->get();
            // $peserta = Peserta::orderBy('updated_at', 'DESC')->get();
            // $unsurKontingen = UnsurKontingen::get();
            // $kategori = Kategori::orderBy('name', 'DESC')->get();
            // $status = Status::orderBy('name', 'DESC')->get();
            // return view('peserta.index', compact('peserta', 'kategori', 'status', 'regency', 'unsurKontingen'));
            return view('peserta.indexAdmin');
        } elseif (auth()->user()->role_id == 2) {
            $notKontingen = Kategori::where('name', 'LIKE', 'Peserta')->first();
            $peserta = Peserta::where('villages_id', auth()->user()->villages_id)->where('kategori_id', $notKontingen->id)->orderBy('nama_lengkap')->get();
            $kategori = Kategori::where('name', 'LIKE', 'Peserta')->get();
            $status = Status::orderBy('name', 'DESC')->get();
            return view('peserta.index', compact('peserta', 'kategori', 'status'));
        } elseif (auth()->user()->role_id == 3) {
            $notKontingen = Kategori::where('name', 'LIKE', 'Peserta')->first();
            $peserta = Peserta::with('villages')->where('regency_id', auth()->user()->regency_id)->where('kategori_id', $notKontingen->id)->orderBy('villages_id')->get();
            $kategori = Kategori::where('name', 'LIKE', 'Peserta')->get();
            $status = Status::orderBy('name', 'DESC')->get();
            return view('peserta.index', compact('peserta', 'kategori', 'status'));
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

    public function show(Peserta $peserta)
    {
        return $peserta;
    }

    public function update(Request $request, $id)
    {
        $peserta = Peserta::findOrFail($id);
        $peserta->update(array_merge($request->all(), [
            'user_id' => auth()->user()->id,
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
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
        ], [
            'foto.required' => 'Foto Tidak Boleh Kosong!',
            'foto.image'    => 'Foto Harus Berupa Gambar!',
            'foto.mimes'    => 'Foto Harus Format jpeg, png, jpg, gif, dan svg',
            'foto.max'      => 'Ukuran Foto Maximal 10 MB!',
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
        $date = Carbon::now()->format('d-m-Y');
        if (auth()->user()->role_id == 1 || auth()->user()->role_id == 4) {
            return Excel::download(new PesertaExport(), 'Peserta ' . config('settings.main.1_app_name') . ' ' . $date . '.xlsx');
        } elseif (auth()->user()->role_id == 2) {
            return Excel::download(new PesertaExport(), 'Peserta ' . config('settings.main.1_app_name') . ' Wilayah ' . auth()->user()->villages->name . ' ' . $date . '.xlsx');
        } elseif (auth()->user()->role_id == 3) {
            return Excel::download(new PesertaExport(), 'Peserta ' . config('settings.main.1_app_name') . ' Wilayah ' . auth()->user()->regency->name . ' ' . $date . '.xlsx');
        }
    }


    public function exportPDF()
    {
        $notKontingen = Kategori::where('name', 'LIKE', 'Peserta')->first();
        $date = Carbon::now()->format('d-m-Y');
        if (auth()->user()->role_id == 1 || auth()->user()->role_id == 4) {
            $peserta = Peserta::orderBy('nama_lengkap', 'DESC')->where('villages_id', '!=', NULL)->get();
            $pdf = Pdf::loadView('peserta.pdf', compact('peserta'))->setPaper('a3', 'landscape');
            return $pdf->download('Peserta ' . config('settings.main.1_app_name') . ' ' . $date . '.pdf');
        } elseif (auth()->user()->role_id == 2) {
            $peserta = Peserta::where('villages_id', auth()->user()->villages_id)->where('kategori_id', $notKontingen->id)->orderBy('nama_lengkap')->get();
            $pdf = Pdf::loadView('peserta.pdf', compact('peserta'))->setPaper('a3', 'landscape');
            return $pdf->download('Peserta ' . config('settings.main.1_app_name') . ' ' . $date . '.pdf');
        } elseif (auth()->user()->role_id == 3) {
            $peserta = Peserta::with('villages')->where('regency_id', auth()->user()->regency_id)->where('kategori_id', $notKontingen->id)->orderBy('villages_id')->get();
            $pdf = Pdf::loadView('peserta.pdf', compact('peserta'))->setPaper('a3', 'landscape');
            return $pdf->download('Peserta ' . config('settings.main.1_app_name') . ' ' . $date . '.pdf');
        }
    }

    public function detailRegency($id)
    {
        $villages = Villages::where('regency_id', $id)->get();
        $pesertaVillages = Villages::where('regency_id', $id)->first();
        $peserta = Peserta::where('villages_id', '!=', NULL)->get();
        return view('peserta.detail', compact('villages', 'peserta', 'pesertaVillages', 'id'));
    }

    public function detailVillages($id)
    {
        $regency = Villages::where('id', $id)->first();
        $pesertaVillages = Peserta::where('villages_id', $id)->first();
        $peserta = Peserta::where('villages_id', $id)->get();
        $kategori = Kategori::where('name', 'LIKE', 'Peserta')->get();
        $status = Status::orderBy('name', 'DESC')->get();
        return view('peserta.detailVillages', compact('peserta', 'kategori', 'status', 'pesertaVillages', 'regency'));
    }
}
