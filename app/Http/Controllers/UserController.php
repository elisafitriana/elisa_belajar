<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax){
            $query = User::select('users.*', 'units.nama_unit', 'units.kode_unit')
            ->leftJoin('units', 'users.id_unit', '=', 'units.id')
            ->get();

            return datatables()->of($query)
            ->addIndexColumn()
            ->toJson();
        }

        return view('user.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $units = Unit::all();

        return view('user.create',compact('units'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'name' => 'required|max:100',
            'email'=> 'required|email|unique:users,email',
            'password'=>'required',
            'id_unit'=>'required',
            'role'=>'required'
        ]);

        // Enkripsi password
        $validated['password'] = Hash::make($request->password);

        // Simpan user baru
        try {
            User::create($validated);

            return redirect(route('user.index'))->with([
                "success" => "Successfully created user!"
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors(['error' => 'Failed to create user: ' . $e->getMessage()]);
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('user.edit', [
            'user'=>User::find($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $validated = $request->validate([
            'name' => 'required|max:100',
            'email'=> 'required|email|unique:users,email,'.$id,
            'password'=>'nullable',
            'id_unit'=>'required',
            'role'=>'required'
        ]);

        // Ambil data user berdasarkan $id
        $user = User::find($id);

        if (!$user) {
            return redirect()->back()->withErrors(['error' => 'User not found']);
        }

        // Update data user
        try {
            // Periksa apakah password baru disediakan
            if ($request->password) {
                $validated['password'] = Hash::make($validated['password']);
            } else {
                unset($validated['password']); // Hapus password dari array validated jika tidak ada password baru
            }

            $user->update($validated);

            return redirect(route('user.index'))->with([
                "success" => "Successfully updated user!"
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors(['error' => 'Failed to update user: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();

        return redirect(route('user.index'))->with([
            "success"=>"succesfull delete user!"
        ]);
    }
}
