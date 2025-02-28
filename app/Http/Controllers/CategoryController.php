<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
class CategoryController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax){
            $query = Category::query();

            return datatables()->of($query)
            ->addIndexColumn()
            ->toJson();
        }

        return view('category.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('category.create');
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
            'name' => 'required|max:20',
        ]);

        Category::create($validated);

        return redirect(route('category.index'))->with([
            "success"=>"succesfull create category!"
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
        return view('category.edit', [
            'category'=>Category::find($id)
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
            'name' => 'required|max:20',
        ]);

        $category = Category::find($id);

        $category->update($validated);

        return redirect(route('category.index'))->with([
            "success"=>"succesfull update category!"
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
        Category::find($id)->delete();

        return redirect(route('category.index'))->with([
            "success"=>"succesfull delete category!"
        ]);
    }
}
