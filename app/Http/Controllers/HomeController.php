<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Peserta;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        if (view()->exists($request->path())) {
            return view($request->path());
        }
        return abort(404);
    }

    public function root()
    {
        $bindamping     = Kategori::where('name', 'LIKE', "%Bindamping%")->first();
        $peserta        = Kategori::where('name', 'LIKE', "%Peserta%")->first();
        $pinkoncab      = Kategori::where('name', 'LIKE', "%Pinkoncab%")->first();
        $pinkonran      = Kategori::where('name', 'LIKE', "%Pinkonran%")->first();
        $staffKontingen = Kategori::where('name', 'LIKE', "%Staff Kontingen%")->first();
        $tenagaMedis    = Kategori::where('name', 'LIKE', "%Tenaga Medis%")->first();
        if (auth()->user()->role_id == 1) {
            $userBindamping     = Peserta::where('kategori_id', $bindamping->id)->count();
            $userPeserta        = Peserta::where('kategori_id', $peserta->id)->count();
            $userPinkoncab      = Peserta::where('kategori_id', $pinkoncab->id)->count();
            $userPinkonran      = Peserta::where('kategori_id', $pinkonran->id)->count();
            $userStaffKontingen = Peserta::where('kategori_id', $staffKontingen->id)->count();
            $userTenagaMedis    = Peserta::where('kategori_id', $tenagaMedis->id)->count();
            return view('index', compact([
                'userBindamping',
                'userPeserta',
                'userPinkoncab',
                'userPinkonran',
                'userStaffKontingen',
                'userTenagaMedis',
            ]));
        } elseif (auth()->user()->role_id == 2) {
            $userBindamping     = Peserta::where('kategori_id', $bindamping->id)->where('villages_id', Auth::user()->villages_id)->count();
            $userPeserta        = Peserta::where('kategori_id', $peserta->id)->where('villages_id', Auth::user()->villages_id)->count();
            $userPinkoncab      = Peserta::where('kategori_id', $pinkoncab->id)->where('villages_id', Auth::user()->villages_id)->count();
            $userPinkonran      = Peserta::where('kategori_id', $pinkonran->id)->where('villages_id', Auth::user()->villages_id)->count();
            $userStaffKontingen = Peserta::where('kategori_id', $staffKontingen->id)->where('villages_id', Auth::user()->villages_id)->count();
            $userTenagaMedis    = Peserta::where('kategori_id', $tenagaMedis->id)->where('villages_id', Auth::user()->villages_id)->count();
            return view('index', compact([
                'userBindamping',
                'userPeserta',
                'userPinkoncab',
                'userPinkonran',
                'userStaffKontingen',
                'userTenagaMedis',
            ]));
        } elseif (auth()->user()->role_id == 3) {
            $userBindamping     = Peserta::where('kategori_id', $bindamping->id)->where('regency_id', Auth::user()->regency_id)->count();
            $userPeserta        = Peserta::where('kategori_id', $peserta->id)->where('regency_id', Auth::user()->regency_id)->count();
            $userPinkoncab      = Peserta::where('kategori_id', $pinkoncab->id)->where('regency_id', Auth::user()->regency_id)->count();
            $userPinkonran      = Peserta::where('kategori_id', $pinkonran->id)->where('regency_id', Auth::user()->regency_id)->count();
            $userStaffKontingen = Peserta::where('kategori_id', $staffKontingen->id)->where('regency_id', Auth::user()->regency_id)->count();
            $userTenagaMedis    = Peserta::where('kategori_id', $tenagaMedis->id)->where('regency_id', Auth::user()->regency_id)->count();
            return view('index', compact([
                'userBindamping',
                'userPeserta',
                'userPinkoncab',
                'userPinkonran',
                'userStaffKontingen',
                'userTenagaMedis',
            ]));
        }
    }

    /*Language Translation*/
    public function lang($locale)
    {
        if ($locale) {
            App::setLocale($locale);
            Session::put('lang', $locale);
            Session::save();
            return redirect()->back()->with('locale', $locale);
        } else {
            return redirect()->back();
        }
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name'      => ['required', 'string', 'max:255'],
            'fullname'  => ['required', 'string', 'max:255'],
            'email'     => ['required', 'string', 'email'],
            'avatar'    => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        $user = User::where('id', auth()->user()->id)->first();
        $user->name = $request->get('name');
        $user->fullname = $request->get('fullname');
        $user->email = $request->get('email');

        if ($request->file('avatar')) {
            $image = $request->file('avatar');
            $image->storeAs('public/img/user', $image->hashName());
            Storage::delete('public/img/user/' . $user->avatar);

            $user->update(array_merge($request->all(), [
                'avatar' => $image->hashName()
            ]));
        } else {
            $user->update($request->all());
        };
        return back();

        // $user->update();
        // if ($user) {
        //     Alert::sucess('Success!', 'User Profile Updated successfully!');
        //     return back();
        // } else {
        //     Alert::error('Failed!', 'Something went wrong!');
        //     return back();
        // }
    }

    public function updatePassword(Request $request, $id)
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if (!(Hash::check($request->get('current_password'), Auth::user()->password))) {
            return response()->json([
                'isSuccess' => false,
                'Message' => "Your Current password does not matches with the password you provided. Please try again."
            ], 200); // Status code
        } else {
            $user = User::find($id);
            $user->password = Hash::make($request->get('password'));
            $user->update();
            if ($user) {
                Session::flash('message', 'Password updated successfully!');
                Session::flash('alert-class', 'alert-success');
                return response()->json([
                    'isSuccess' => true,
                    'Message' => "Password updated successfully!"
                ], 200); // Status code here
            } else {
                Session::flash('message', 'Something went wrong!');
                Session::flash('alert-class', 'alert-danger');
                return response()->json([
                    'isSuccess' => true,
                    'Message' => "Something went wrong!"
                ], 200); // Status code here
            }
        }
    }
}
