<?php

namespace App\Http\Controllers\CRS;

use App\Models\CRS\Kit;
use App\Models\CRS\Platform;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PlatformController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $platforms=Platform::latest()->get();
        //return $platforms;
        return view('admin.managePlatforms',compact('platforms'));
        
    }

    public function get_kits($id)
    {   
        $kits=Kit::select(['id','kit_name'])->where('platform_id', $id)->get();
        return response()->json([$kits]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'platform_name' =>'required', 'string', 'max:255',
            
           ]);
    
            Platform::create($request->all());
    
            return redirect()->back()->with('success', 'Platform Successfully Added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function update(Request $request,Platform $platform)
    {
        $request->validate([
            'platform_name' =>'required', 'string', 'max:255',
            
           ]);
    
           $platform->update($request->all());
    
            return redirect()->back()->with('success', 'Platform Successfully Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
