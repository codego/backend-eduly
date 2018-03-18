<?php

namespace App\Http\Controllers;

use App\correlative;
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
    public function store($id, Request $request)
    {
        DB::table('subjects')->whereIn('id_subject', $id)->delete();
        var_dump($request->correlatives);
        dd();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\correlative  $correlative
     * @return \Illuminate\Http\Response
     */
    public function show(correlative $correlative)
    {
        //
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
