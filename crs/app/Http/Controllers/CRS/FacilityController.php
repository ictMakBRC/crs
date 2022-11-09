<?php

namespace App\Http\Controllers\CRS;

use App\Models\CRS\Facility;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FacilityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allfacilities=Facility::orderBy('facility_name','asc')->get();
        $facilities = Facility::with('parent')->latest()->get();
        return view('admin.manageFacilities',compact('facilities','allfacilities'));
        }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
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
            'facility_name' =>'required', 'string', 'max:255',
            'facility_type' => 'required','string'
           ]);
    
            Facility::create($request->all());
    
            return redirect()->back()->with('success', 'Facility Successfully Added!');
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
    public function update(Request $request,Facility $facility)
    {
        $request->validate([
            'facility_name' =>'required', 'string', 'max:255',
            'facility_type' => 'required','string'
           ]);
    
           $facility->update($request->all());
    
            return redirect()->back()->with('success', 'Facility Successfully Updated!');
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
