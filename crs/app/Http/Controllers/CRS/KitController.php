<?php

namespace App\Http\Controllers\CRS;

use App\Models\CRS\Kit;
use App\Models\CRS\Platform;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class KitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $platforms=Platform::latest()->get();
        $kits=Kit::addSelect([
            'platform' => Platform::select('platform_name')->whereColumn('kits.platform_id', 'platforms.id'),
            ])->latest()->get();
        //return $facilities ;
        
        
        return view('admin.manageKits',compact('kits','platforms'));
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
            'kit_name' =>'required', 'string', 'max:255',
            'platform_id' =>'required', 'integer',
            
           ]);
    
            Kit::create($request->all());
    
            return redirect()->back()->with('success', 'Kit Successfully Added!');
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
    public function update(Request $request,Kit $kit)
    {
        $request->validate([
            'kit_name' =>'required', 'string', 'max:255',
            'platform_id' =>'required', 'integer',
            
           ]);
    
           $kit->update($request->all());
    
            return redirect()->back()->with('success', 'Kit Successfully Updated!');
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
