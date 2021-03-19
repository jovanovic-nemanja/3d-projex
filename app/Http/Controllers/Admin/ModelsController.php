<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Models;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ModelsController extends Controller
{
    public function __construct(){
        $this->middleware(['auth', 'admin']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $models = Models::all();

        return view('admin.models.index', compact('models'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.models.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(request(), [
            'name' => 'required',
            'image' => 'required',
            'texture_image' => 'required',
            'model' => 'required',
            'price' => 'required',
            'type' => 'required'
        ]);

        DB::beginTransaction();

        try {
            if (@$request->texture_image) {
                $texture = Models::upload_model_texture_image($request->texture_image);
            }

            if (@$request->model) {
                $model = Models::upload_model_js($request->model);
            }

            $model = Models::create([
                'name' => $request['name'],
                'image' => $request['image'],
                'texture_image' => $texture,
                'model' => $model,
                'price' => $request['price'],
                'type' => $request['type'],
                'sign_date' => date('Y-m-d h:i:s'),
            ]);

            Models::upload_model_image($model->id);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

            throw $e;
        }  

        return redirect()->route('models.index')->with('flash', 'Successfully added model.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model = Models::where('id', $id)->first();

        return view('admin.models.edit', compact('model'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $this->validate(request(), [
            'name' => 'required',
            'price' => 'required',
            'type' => 'required'
        ]);

        $record = Models::where('id', $id)->first();

        if (@$record) {
            if (@$request->texture_image) {
                $texture = Models::upload_model_texture_image($request->texture_image);
            }

            if (@$request->model) {
                $model = Models::upload_model_js($request->model);
            }

            $record->name = $request->name;
            $record->price = $request->price;
            $record->type = $request->type;
            if (@$request->image) {
                $record->image = $request->image;
            }

            if (@$texture) {
                $record->texture_image = $texture;
            }

            if (@$model) {
                $record->model = $model;
            }

            $record->update();
        }

        if (@$request->image) {
            Models::upload_model_image($record->id);
        }

        return redirect()->route('models.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $file = Models::delete_file($id);
        if ($file) {
            $record = Models::where('id', $id)->delete();
        }
        
        return redirect()->route('models.index');
    }
}
