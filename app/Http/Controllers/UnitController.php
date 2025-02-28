<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Unit::all();
            return datatables()::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<a href="' . route('unit.edit', $row->id) . '" class="edit btn btn-info btn-sm">Edit</a>';
                    $btn .= '<form action="' . route('unit.destroy', $row->id) . '" method="POST" style="display:inline">
                                ' . csrf_field() . '
                                ' . method_field('DELETE') . '
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you sure to delete?\')">Delete</button>
                             </form>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('unit.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('unit.create');
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
            'nama_unit' => 'required|max:50',
            'kode_unit' => 'required|max:3',
            'deskripsi' => 'required',
        ]);

        Unit::create($validated);

        return redirect(route('unit.index'))->with([
            "success"=>"succesfull create unit!"
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
        return view('unit.edit', [
            'unit'=>Unit::find($id)
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
            'nama_unit' => 'required|max:50',
            'kode_unit' => 'required|max:3',
            'deskripsi' => 'required',
        ]);

        $unit = Unit::find($id);

        $unit->update($validated);

        return redirect(route('unit.index'))->with([
            "success"=>"succesfull update unit!"
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
        Unit::find($id)->delete();

        return redirect(route('unit.index'))->with([
            "success"=>"succesfull delete unit!"
        ]);
    }
}
