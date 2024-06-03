<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Status;
use App\Models\UnsurKontingen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class UnsurKontingenController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $unsurKontingen = UnsurKontingen::orderBy('updated_at', 'DESC')->get();
        $kategori = Kategori::orderBy('updated_at', 'DESC')->get();
        return view('unsurKontingen.index', compact('unsurKontingen', 'kategori'));
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
        UnsurKontingen::create(array_merge($request->all(), [
            'status_id' => $status->id,
            'user_id'   => Auth::user()->id,
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
        $unsurKontingen = UnsurKontingen::findOrFail($id);
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $nama_foto = time() . '-' . $foto->getClientOriginalName();
            $foto->storeAs('public/img/unsur_kontingen', $nama_foto);
            $unsurKontingen->update(array_merge($request->all(), [
                'foto' => $nama_foto,
                'user_id' => Auth::user()->id,
            ]));
        } elseif ($request->hasFile('kta')) {
            $kta = $request->file('kta');
            $nama_kta = time() . '-' . $kta->getClientOriginalName();
            $kta->storeAs('public/img/unsur_kontingen', $nama_kta);
            $unsurKontingen->update(array_merge($request->all(), [
                'user_id' => Auth::user()->id,
                'kta' => $nama_kta,
            ]));
        } elseif ($request->hasFile('asuransi_kesehatan')) {
            $asuransi_kesehatan = $request->file('asuransi_kesehatan');
            $nama_asuransi_kesehatan = time() . '-' . $asuransi_kesehatan->getClientOriginalName();
            $asuransi_kesehatan->storeAs('public/img/unsur_kontingen', $nama_asuransi_kesehatan);
            $unsurKontingen->update(array_merge($request->all(), [
                'user_id' => Auth::user()->id,
                'asuransi_kesehatan' => $nama_asuransi_kesehatan,
            ]));
        } elseif ($request->hasFile('sertif_sfh')) {
            $sertif_sfh = $request->file('sertif_sfh');
            $nama_sertif_sfh = time() . '-' . $sertif_sfh->getClientOriginalName();
            $sertif_sfh->storeAs('public/img/unsur_kontingen', $nama_sertif_sfh);
            $unsurKontingen->update(array_merge($request->all(), [
                'user_id' => Auth::user()->id,
                'sertif_sfh' => $nama_sertif_sfh,
            ]));
        } else {
            $unsurKontingen->update(array_merge($request->all(), [
                'user_id' => Auth::user()->id,
            ]));
        }
        Alert::success('Success!', 'Data Updated Successfully');
        return back();
    }

    public function destroy($id)
    {
        $unsurKontingen = UnsurKontingen::find($id);
        $unsurKontingen->delete();
        Alert::success('Success!', 'Data Deleted Successfully');
        return back();
    }
}
