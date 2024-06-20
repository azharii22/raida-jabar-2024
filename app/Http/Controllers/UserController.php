<?php

namespace App\Http\Controllers;

use App\Models\Region;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user   = User::with('role', 'region')->orderBy('updated_at', 'DESC')->get();
        $role   = Role::all();
        $region = Region::orderBy('dkc_name', 'ASC')->get();
        return view('user.index', compact('user', 'role', 'region'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'      => 'required|max:255',
            'email'     => 'required|email|unique:users,email',
            'password' => [
                'required', 'string', 'confirmed', Password::min(8)
                    ->mixedCase()
                    ->letters()
                    ->numbers()
                    ->symbols()
            ],
            'avatar'    => 'nullable|mimes:png,jpg,jpeg|max:2048'
        ], [
            'name.required'         => 'Nama harus diisi',
            'name.max'              => 'Nama maksimal 255 karakter',
            'email.required'        => 'Email harus diisi',
            'email.email'           => 'Email harus berformat email',
            'email.unique'          => 'Email sudah terdaftar',
            'password.required'     => 'Password harus diisi',
            'password.confirmed'    => 'Password tidak sama',
            'password.min'          => 'Password minimal 8 karakter',
            'password.mixedCase'    => 'Password setidaknya harus terdiri dari satu huruf besar dan satu huruf kecil',
            'password.letters'      => 'Password setidaknya harus terdiri dari satu huruf',
            'password.numbers'      => 'Password setidaknya harus terdiri dari satu angka',
            'password.symbols'      => 'Password setidaknya harus terdiri dari satu simbol',
            'avatar.mimes'          => 'Format gambar harus png, jpg, atau jpeg',
            'avatar.max'            => 'Ukuran gambar maksimal 2 MB'
        ]);
        if (request()->has('avatar')) {
            $avatar = request()->file('avatar');
            $avatarName = time() . '.' . $avatar->getClientOriginalExtension();
            $avatarPath = public_path('/images/');
            $avatar->move($avatarPath, $avatarName);
            User::create(array_merge($request->all(), [
                'avatar'    => "/images/" . $avatarName,
                'password'  => Hash::make($request->password)
            ]));
        } else {
            User::create(array_merge($request->all(), [
                'password'  => Hash::make($request->password)
            ]));
        }
        Alert::success('Success!', 'Data Saved Successfully');
        return back();
    }

    public function show(User $user)
    {
        return $user;
    }

    public function update(Request $request, $id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $this->validate($request, [
            'name'      => 'required|max:255',
            'email'     => ['required', 'email', Rule::unique('users')->ignore($id)],
            'avatar'    => 'nullable|mimes:png,jpg,jpeg|max:2048',
        ]);
        if (request()->has('avatar')) {
            $avatar = request()->file('avatar');
            $avatarName = time() . '.' . $avatar->getClientOriginalExtension();
            $avatarPath = public_path('/images/');
            $avatar->move($avatarPath, $avatarName);
            $user->update(array_merge($request->all(), [
                'avatar'    => "/images/" . $avatarName,
            ]));
        } else {
            $user->update($request->all());
        }
        Alert::success('Success!', 'Data Updated Successfully');
        return back();
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        Alert::success('Success!', 'Data Deleted Successfully');
        return back();
    }
}
