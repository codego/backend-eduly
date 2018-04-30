<?php

namespace App\Http\Controllers;

use App\Career;
use Illuminate\Http\Request;

class CareerController extends Controller
{
    public function __construct()
    {
        $this->middleware(\App\Http\Middleware\CheckTenant::class);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sort = $request->input('_sort');
        $end = $request->input('_end');
        $start = $request->input('_start');
        $order = $request->input('_order');
        return response(DB::table('careers')->orderBy($sort, $order)->offset($start)->limit($end)->get(), 200)
            ->header('X-Total-Count', Career::all()->count());
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
        $career = new Career;

        $careerData = json_decode(request()->getContent(), true);

        $career->name = $careerData['name'];
        $career->description = $careerData['description'];

        $career->save();
        return response()->json(array('success' => true, 'id' => $career->id), 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Career  $career
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Career::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Career  $career
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $career = Career::find($id);

        $careerData = json_decode(request()->getContent(), true);

        $career->name = $careerData['name'];
        $career->description = $careerData['description'];

        $career->save();
        return response()->json(array('success' => true, 'id' => $career->id), 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Career  $career
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Career $career)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Career  $career
     * @return \Illuminate\Http\Response
     */
    public function destroy(Career $career)
    {
        $career = Career::find($id);
        $career->delete();
        return response()->json(array('success' => true), 200);
    }
}
