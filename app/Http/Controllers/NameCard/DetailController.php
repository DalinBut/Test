<?php

namespace App\Http\Controllers\NameCard;

use App\Models\Detail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $detail = Detail::all();
        $detail = DB::table('details')->select('firstName', 'lastName', 'gender', 'phone', 'email', 'dob', 'companyName', 'position', 'address')->get();
        return response()->json([
            'details' => $detail
        ]);
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
        if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('user')){
            $request->validate([
                'firstName' => 'required',
                'lastName' => 'required',
                'gender' => 'required',
                'phone' => 'required|min:9|max:10',
                'email' => 'required|email',
                'dob' => 'required',
                'companyName' => 'required',
                'position' => 'required',
                'address' => 'required',
            ]);
            $detail = Detail::create($request->all());
        }
        return response()->json([
            'message' => 'Detail created successfully',
            'details' => $detail
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Detail  $detail
     * @return \Illuminate\Http\Response
     */
    public function show(Detail $detail)
    {
        $detail->find($detail);
        return response()->json([
            'details' => $detail
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Detail  $detail
     * @return \Illuminate\Http\Response
     */
    public function edit(Detail $detail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Detail  $detail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Detail $detail)
    {
        if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('user')){
            $request->validate([
                'firstName' => 'required',
                'lastName' => 'required',
                'gender' => 'required',
                'phone' => 'required|min:9|max:10',
                'email' => 'required|email',
                'dob' => 'required',
                'companyName' => 'required',
                'position' => 'required',
                'address' => 'required',
            ]);
            $detail->update($request->all());
        }
        return response()->json([
            'message' => 'Detail updated successfully',
            'details' => $detail
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Detail  $detail
     * @return \Illuminate\Http\Response
     */
    public function destroy(Detail $detail)
    {
        if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('user')){
            $detail->delete();
            return ['Detail deleted successfully'];
        }
    }
}
