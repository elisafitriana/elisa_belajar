<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

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
            $query = User::query();

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
        return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:100',
            'email'=> 'required|email|unique:users,email',
            'password'=>'required',
            'role'=>'required'
        ]);

        User::create($validated);

        return redirect(route('user.index'))->with([
            "success"=>"succesfull create user!"
        ]);
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
        $validated = $request->validate([
            'name' => 'required|max:100',
            'email'=> 'required|email|unique:users,email,'.$id,
            'password'=>'nullable',
            'role'=>'required'
        ]);

        if($request->password){
            $validated['password'] = bcrypt($validated['password']);
        }else{
            unset($validated['password']);
        }

        $user = User::find($id);

        $user->update($validated);

        return redirect(route('user.index'))->with([
            "success"=>"succesfull update user!"
        ]);
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
