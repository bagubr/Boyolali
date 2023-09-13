<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\Administrator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function index() {
        $admin = Administrator::get();
        return view('admin.index', compact('admin'));
    }

    public function create() {
        return view('admin.create');
    }

    public function post(Request $request){
        
        $data = $this->validate($request, [
            'name' => 'required|string',
            'username' => 'required|string|unique:administrators',
            'phone' => 'required|string',
            'role' => 'required|in:'.implode(',', array_keys(Administrator::role())),
            'password' => 'confirmed|required',
            'avatar' => 'file',
        ]);

        $data['jabatan'] = \App\Models\Administrator::role()[$data['role']];
        $data['avatar'] = $request->file('avatar')->store('avatar');
        $data['password'] = Hash::make($data['password']);
        $administrator = Administrator::create($data);

        return redirect()->route('admin')->with('success', 'Data berhasil di tambahkan');
    }

    public function detail($id) {
        $administrator = Administrator::findOrFail($id);
        return view('admin.detail', compact('administrator'));
    }
    
    public function update(Request $request, $id){
        $data = $this->validate($request, [
            'name' => 'required|string',
            'username' => 'required|string',
            'phone' => 'required|string',
            'role' => 'required|in:'.implode(',', array_keys(Administrator::role())),
            'password' => 'confirmed|sometimes',
            'avatar' => 'file|sometimes',
        ]);
        $administrator = Administrator::find($id);
        $data['jabatan'] = \App\Models\Administrator::role()[$data['role']];
        if(isset($request->avatar)){
            $data['avatar'] = $request->file('avatar')->store('avatar');
            if(Storage::exists($administrator->avatar)){
                Storage::delete($administrator->avatar);
            }
        }else{
            $data['avatar'] = $administrator->avatar;
        }
        if(isset($request->password)){
            $data['password'] = Hash::make($data['password']);
        }else{
            $data['password'] = $administrator->password;
        }
        $administrator->update($data);
        return redirect()->route('admin')->with('success', 'Data berhasil di ubah');
    }
    
    public function delete($id){
        $administrator = Administrator::findOrFail($id);
        if(Storage::exists($administrator->avatar)){
            Storage::delete($administrator->avatar);
        }
        $administrator->delete();
        return redirect()->route('admin')->with('success', 'Data berhasil di hapus');
    }
}
