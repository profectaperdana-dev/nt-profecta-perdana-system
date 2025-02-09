<?php

namespace App\Http\Controllers;

use App\Models\MaterialModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = ' Product Material';
        $data = MaterialModel::latest()->get();

        return view('materials.index', compact('title', 'data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort(404);
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
            'nama_material' => 'required',
            // 'code_materials' => 'min:3|required|max:4',


        ]);
        try {
            DB::beginTransaction();
            // $checked = MaterialModel::where('code_materials', $request->get('code_materials'))->count();
            // if ($checked > 0) {
            //     return redirect('/product_materials')->with('error', 'You Have Entered Duplicate Code');
            // }
            $model = new MaterialModel();
            $model->nama_material = $request->get('nama_material');
            // $model->code_materials = $request->get('code_materials');
            $model->code_materials = '-';

            $model->created_by = Auth::user()->id;
            $model->save();

            DB::commit();
            return redirect('/product_materials')->with('success', 'Create data product material ' . $model->nama_material . ' is success');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect('/product_materials')->with('error', $e->getMessage() . '. Please call your Most Valuable IT Team.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort(404);
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
        if (!Gate::allows('level1') && !Gate::allows('level2')) {
            abort(403);
        }
        $request->validate([
            'editnama_material' => 'required',
            // 'editcode_material' => 'min:3|required|max:4',


        ]);

        try {
            DB::beginTransaction();
            $model = MaterialModel::find($id);
            $model->nama_material = $request->get('editnama_material');
            // $old = $model->code_materials;
            // $model->code_materials = '';
            // $model->save();
            // $checked = MaterialModel::where('code_materials', $request->get('editcode_material'))->count();
            // if ($checked > 0) {
            //     $model->code_materials = $old;
            //     $model->save();
            //     return redirect('/product_materials')->with('error', 'You Have Entered Duplicate Code');
            // }
            // $model->code_materials = $request->get('editcode_material');

            $model->created_by = Auth::user()->id;
            $model->save();

            DB::commit();
            return redirect('/product_materials')->with('info', 'Edit data product material ' . $model->nama_material . ' is success');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect('/product_materials')->with('error', $e->getMessage() . '. Please call your Most Valuable IT Team.');
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
        if (!Gate::allows('level1')) {
            abort(403);
        }
        try {
            DB::beginTransaction();
            $model = MaterialModel::find($id);
            $model->delete();

            DB::commit();
            return redirect('/product_materials')->with('error', 'Delete data product material ' . $model->nama_material . ' is success');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect('/product_materials')->with('error', $e->getMessage() . '. Please call your Most Valuable IT Team.');
        }
    }
}
