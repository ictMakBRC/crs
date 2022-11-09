<?php

namespace App\Http\Controllers\CRS;

use App\Models\CRS\Swabber;
use App\Models\CRS\Facility;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SwabberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        if(Auth::user()->hasRole(['DataClerkSite'])){
            $swabbers = Swabber::where(['facility_id'=>Auth::user()->facility_id])->latest()->get();
            return view('crs.manageSwabbers',compact('swabbers'));

        }else{
            $swabbers = Swabber::with('facility','facility.parent')->latest()->get();
            $facilities = Facility::with('parent')->orderBy('facility_name','asc')->get();
            return view('crs.manageSwabbers',compact('swabbers','facilities'));
        }
        
        
    }
    public function get_swabbers($id)
    {   
        $swabbers= Swabber::select(['id','full_name'])->where(['facility_id'=>$id,'status'=>'Active'])->get();
        return response()->json([$swabbers]);
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
            'full_name' =>'required', 'string', 'max:255',
           
            'status' => 'required','string'
           ]);
    
            Swabber::create($request->all());
    
            return redirect()->back()->with('success', 'Swabber Successfully Created !!');
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
    public function update(Request $request,Swabber $swabber)
    {
        $request->validate([
            'full_name' =>'required', 'string', 'max:255',
            'status' => 'required','string'
            ]);
    
            $swabber->update($request->all());
    
            return redirect()->back()->with('success', 'Swabber Successfully Updated !!');
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
