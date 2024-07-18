<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Peserta;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if (view()->exists($request->path())) {
            return view($request->path());
        }

        return abort(404);
    }

    public function root()
    {
        if (auth()->user()->role_id == 1 || auth()->user()->role_id == 4) {
            $grandTotalPeserta = Peserta::count();
            $kategoriCount = Kategori::withCount('peserta')
            ->get();
        } elseif (auth()->user()->role_id == 2) {
            $grandTotalPeserta = Peserta::where('villages_id', auth()->user()->villages_id)->count();
            $kategoriCount = Kategori::withCount(['peserta' => function ($query) {
                $query->where('villages_id', auth()->user()->villages_id);
            }])
            ->where('name', '!=', 'Pinkonran')
            ->where('name', '!=', 'Staff Kontingen')
            ->where('name', '!=', 'Petugas Pameran')
            ->get();
        } elseif (auth()->user()->role_id == 3) {
            $grandTotalPeserta = Peserta::where('regency_id', auth()->user()->regency_id)->count();
            $kategoriCount = Kategori::withCount(['peserta' => function ($query) {
                $query->where('regency_id', auth()->user()->regency_id);
            }])->get();
        }

        return view('index', compact([
            'grandTotalPeserta',
            'kategoriCount',
        ]));
    }

    /* Language Translation */
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
            'name' => ['required', 'string', 'max:255'],
            'fullname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email'],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:10240'],
        ]);

        $user = User::where('id', auth()->user()->id)->first();
        $user->name = $request->get('name');
        $user->fullname = $request->get('fullname');
        $user->email = $request->get('email');

        if ($request->file('avatar')) {
            $image = $request->file('avatar');
            $image->storeAs('public/img/user', $image->hashName());
            Storage::delete('public/img/user/'.$user->avatar);

            $user->update(array_merge($request->all(), [
                'avatar' => $image->hashName(),
            ]));
        } else {
            $user->update($request->all());
        }

        Alert::sucess('Success!', 'User Profile Updated successfully!');

        return back();

        // $user->update();
        // if ($user) {
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

        if (!Hash::check($request->get('current_password'), auth()->user()->password)) {
            return response()->json([
                'isSuccess' => false,
                'Message' => 'Your Current password does not matches with the password you provided. Please try again.',
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
                    'Message' => 'Password updated successfully!',
                ], 200); // Status code here
            } else {
                Session::flash('message', 'Something went wrong!');
                Session::flash('alert-class', 'alert-danger');

                return response()->json([
                    'isSuccess' => true,
                    'Message' => 'Something went wrong!',
                ], 200); // Status code here
            }
        }
    }
}
