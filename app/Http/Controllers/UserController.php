<?php

namespace App\Http\Controllers;

use App\Models\Regency;
use App\Models\Region;
use App\Models\Role;
use App\Models\User;
use App\Models\Villages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function createDkd()
    {
        $role = Role::where('name', 'DKD')->first();
        return view('user.createDkd', compact('role'));
    }

    public function createDkc()
    {
        $role = Role::where('name', 'DKC')->first();
        $region = Regency::orderBy('name')->get();
        return view('user.createDkc', compact('region', 'role'));
    }

    public function createDkr()
    {
        $role = Role::where('name', 'DKR')->first();
        $regency = Regency::orderBy('name')->get();
        $villages = Villages::orderBy('regency_id')->get();
        return view('user.createDkr', compact('regency', 'role', 'villages'));
    }


    public function index()
    {
        // $user   = User::with('role', 'regency', 'villages')->orderBy('updated_at', 'DESC')->get();
        // $role   = Role::all();
        // $region = Villages::orderBy('regency_id')->get();
        // return view('user.index', compact('user', 'role', 'region'));
        return view('user.index');
    }

    public function getData()
    {
        $users = User::with('role', 'regency','villages')->orderBy('updated_at', 'DESC')->get();
        // $users = User::with('role', 'regency', 'villages')
        //     ->join('roles', 'roles.id', '=', 'users.role_id')
        //     ->join('regencies', 'regencies.id', '=', 'users.regency_id')
        //     ->select('users.*', 'roles.name as role_name', 'regencies.name as regency_name')
        //     ->orderBy('roles.name')
        //     ->orderBy('updated_at', 'DESC')
        //     ->get();
        return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('region_name', function ($row) {
                $villages = $row->villages->name ?? '';
                $regency = $row->regency->name ?? '';
                if ($row->role_id == 1 || $row->role_id == 4) {
                    return '';
                } elseif ($row->role_id == 3) {
                    return "$regency";
                } elseif ($row->role_id == 2) {
                    return "$villages, $regency";
                }
            })
            ->addColumn('action', function ($row) {
                $editBtn = '';
                $deleteBtn = '';

                if ($row->role_id == 1 || $row->role_id == 4) {
                    $editBtn = '<a href="' . route('editDkd', $row->id) . '" class="btn btn-warning btn-sm mr-2 waves-effect waves-light"><i class="bx bx-pencil"></i> Edit</a>';
                    $deleteBtn = '<button class="delete btn btn-danger btn-sm mr-2 waves-effect waves-light" data-id="' . $row->id . '"><i class="bx bx-trash"></i> Delete</button>';
                } elseif ($row->role_id == 3) {
                    $editBtn = '<a href="' . route('editDkc', $row->id) . '" class="btn btn-warning btn-sm mr-2 waves-effect waves-light"><i class="bx bx-pencil"></i> Edit</a>';
                    $deleteBtn = '<button class="delete btn btn-danger btn-sm mr-2 waves-effect waves-light" data-id="' . $row->id . '"><i class="bx bx-trash"></i> Delete</button>';
                } elseif ($row->role_id == 2) {
                    $editBtn = '<a href="' . route('editDkr', $row->id) . '" class="btn btn-warning btn-sm mr-2 waves-effect waves-light"><i class="bx bx-pencil"></i> Edit</a>';
                    $deleteBtn = '<button class="delete btn btn-danger btn-sm mr-2 waves-effect waves-light" data-id="' . $row->id . '"><i class="bx bx-trash"></i> Delete</button>';
                }

                return $editBtn . ' ' . $deleteBtn;
            })
            ->rawColumns(['avatar', 'action'])
            ->make(true);
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
            'avatar'    => 'nullable|mimes:png,jpg,jpeg|max:10240'
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
            'avatar.max'            => 'Ukuran gambar maksimal 10 MB'
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
        return redirect()->route('admin-user.index');
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return $user;
    }

    public function editDkd($id)
    {
        $user = User::find($id);
        $role = Role::where('name', 'DKD')->first();
        return view('user.editDkd', compact('user', 'role'));
    }

    public function editDkc($id)
    {
        $user = User::find($id);
        $role = Role::where('name', 'DKC')->first();
        $region = Regency::orderBy('name')->get();
        return view('user.editDkc', compact('user', 'region', 'role'));
    }

    public function editDkr($id)
    {
        $user = User::find($id)->load(['regency', 'villages']);
        $role = Role::where('name', 'DKR')->first();
        $regency = Regency::orderBy('name')->get();
        $villages = Villages::orderBy('regency_id')->get();
        return view('user.editDkr', compact('user', 'regency', 'role', 'villages'));
    }

    public function update(Request $request, $id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $this->validate($request, [
            'name'      => 'required|max:255',
            'email'     => ['required', 'email', Rule::unique('users')->ignore($id)],
            'avatar'    => 'nullable|mimes:png,jpg,jpeg|max:10240',
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
        return redirect()->route('admin-user.index');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if ($user) {
            $user->delete();
            Alert::success('Success!', 'Data Deleted Successfully');
            return response()->json(['success' => true]);
        }else{
            return response()->json(['success' => false, 'message' => 'Data not found']);
        }
    }
}
