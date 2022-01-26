<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        return response()->json($categories, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories',
        ]);

        $category = new Category;
        $category->name = $request->name;
        $category->description = $request->description;
        $category->save();

        return response()->json([
            'msj'   => 'Categoria Guardada',
            'data'  => $category
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::find($id);
        
        if ( $category ) {
            return response()->json($category, 200);
        }

        return response()->json([
            'msg'   => 'Categoria no encontrada'
        ], 404);
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
        $category = Category::find($id);

        if ( $category ) {
            $request->validate([
                'name' => "required|unique:categories,name,$id",
            ]);

            $category->name = $request->name;
            $category->description = $request->description;
            $category->save();

            return response()->json([
                'msj'   => 'Categoria Modificada', 
                'data'  => $category
            ], 200);
        }

        return response()->json([
            'msj'   => 'Categoria no encontrada'
        ], 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);

        if ( $category ) {
            $category->delete();            

            return response()->json([
                'msj'   => 'Categoria Eliminada'
            ], 200);
        }

        return response()->json([
            'msj' => 'Categoria no encontrada'
        ], 404);
    }
}
