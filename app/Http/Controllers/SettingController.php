<?php

namespace App\Http\Controllers;

use App\DataTables\SettingDataTable;
use App\Http\Requests\CreateSettingRequest;
use App\Http\Requests\UpdateSettingRequest;
use App\Models\Setting;
use App\Repositories\SettingRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use RealRashid\SweetAlert\Facades\Alert;
use Response;
use Spatie\Permission\Guard;

class SettingController extends Controller
{
    /** @var  SettingRepository */
    private $settingRepository;

    public function __construct(SettingRepository $settingRepo)
    {
        $this->settingRepository = $settingRepo;
        $this->middleware('auth');
    }

    /**
     * Display a listing of the Setting.
     *
     * @param SettingDataTable $settingDataTable
     * @return Response
     */
    public function index()
    {
        $setting = Setting::orderBy('key', 'ASC')->get();
        // dd($setting);
        return view('settingApp.index', compact('setting'));
    }

    public function store(Request $request)
    {
        abort(404);
        $input = $request->all();

        $setting = $this->settingRepository->create($input);

        Alert::success('Succcess!', 'Data saved successfully.');

        return back();
    }

    /**
     * Display the specified Setting.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        abort(404);
        $setting = $this->settingRepository->find($id);

        if (empty($setting)) {
            Alert::error('Setting not found');

            return back();
        }

        return view('settings.show')->with('setting', $setting);
    }

    /**
     * Show the form for editing the specified Setting.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $setting = Setting::findOrFail($id);

        if (empty($setting)) {
            Alert::error('Setting not found');

            return back();
        }

        return view('settings.edit')->with('setting', $setting);
    }

    /**
     * Update the specified Setting in storage.
     *
     * @param  int              $id
     * @param UpdateSettingRequest $request
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $setting = Setting::findOrFail($id);

        if (empty($setting)) {
            Alert::error('Setting not found');

            return back();
        }

        $data = $request->all();
        if (Arr::exists($data, 'key'))
            Arr::forget($data, ['key']);
        $setting = $this->settingRepository->update($data, $id);

        Alert::success('Success!', 'Data updated successfully.');

        return back();
    }

    /**
     * Remove the specified Setting from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        // abort(404);
        $setting = Setting::findOrFail($id);

        if (empty($setting)) {
            Alert::error('Setting not found');

            return back();
        }

        $setting->delete();

        Alert::success('Success!', 'Data deleted successfully.');

        return back();
    }

    public function uploadFile(Request $request, $id)
    {
        $request->validate([
            'value'  => 'required|image|mimes:jpg,jpeg,png,svg,gif|max:10240',
        ], [
            'value.required' => 'File harus diisi!',
            'value.image'    => 'File harus Berupa Foto',
            'value.mimes'    => 'File harus berupa jpg, jpeg, png, svg, gif',
            'value.max'      => 'File tidak boleh lebih dari 10 MB',
        ]);
        $setting = setting::findOrFail($id);    
        $file   = $request->file('value');
        $filename = time() . '-' . $file->getClientOriginalName();
        $file->storeAs('public/setting/', $filename);
        $setting->update(array_merge($request->all(), [
            'value'     => $filename,
        ]));
        Alert::success('Success!', 'Data Updated Successfully');
        return back();
    }
}
