<?php

namespace App\Http\Controllers;

use App\correlatives;
use Illuminate\Http\Request;

class CorrelativeController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store($id_subject, $id_subject_dependence)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\correlative  $correlative
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response(DB::table('correlatives')->where('id_subject', $id)->get(), 200)
            ->header('X-Total-Count', \App\subjects::all()->count());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\correlative  $correlative
     * @return \Illuminate\Http\Response
     */
    public function edit(correlative $correlative)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\correlative  $correlative
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, correlative $correlative)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\correlative  $correlative
     * @return \Illuminate\Http\Response
     */
    public function destroy(correlative $correlative)
    {
        //
    }
}
