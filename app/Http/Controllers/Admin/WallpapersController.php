<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Wallpapers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class WallpapersController extends Controller
{
    public function __construct(){
        $this->middleware(['auth', 'admin'])->except(['storage']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $wallpapers = Wallpapers::all();

        return view('admin.wallpapers.index', compact('wallpapers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.wallpapers.create');
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
            'texture_url' => 'required'
        ]);

        DB::beginTransaction();

        try {
            $wallpaper = Wallpapers::create([
                'texture_url' => $request['texture_url'],
                'created_by' => auth()->id(),
                'sign_date' => date('Y-m-d h:i:s')
            ]);

            Wallpapers::upload_texture_image($wallpaper->id);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

            throw $e;
        }  

        return redirect()->route('wallpapers.index')->with('flash', 'Successfully added wallpaper.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storage(Request $request)
    {
        $this->validate(request(), [
            'texture_url' => 'required'
        ]);

        DB::beginTransaction();

        try {
            $wallpaper = Wallpapers::create([
                'texture_url' => $request['texture_url'],
                'created_by' => auth()->id(),
                'sign_date' => date('Y-m-d h:i:s')
            ]);

            Wallpapers::upload_texture_image($wallpaper->id);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

            throw $e;
        }  

        return redirect()->route('home')->with('flash', 'Successfully added wallpaper.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $wallpaper = Wallpapers::where('id', $id)->first();

        return view('admin.wallpapers.edit', compact('wallpaper'));
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
        $wallpaper = Wallpapers::where('id', $id)->first();

        if (@$wallpaper) {
            if (@$request->texture_url) {
                $wallpaper->texture_url = $request->texture_url;
            }

            $wallpaper->update();
        }

        if (@$request->texture_url) {
            Wallpapers::upload_texture_image($wallpaper->id);
        }

        return redirect()->route('wallpapers.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $file = Wallpapers::delete_file($id);
        if ($file) {
            $record = Wallpapers::where('id', $id)->delete();
        }
        
        return redirect()->route('wallpapers.index');
    }
}
