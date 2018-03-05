<?php

namespace App\Http\Controllers;

use App\teachers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class TeachersController extends Controller
{

    public function __construct()
    {
        // $this->middleware('auth:api');
    }

    public function show($id)
    {
        //return new StudentsResource(Students::find($id));
        //return Students::where('id', $id)->get();
        //return response()->json(array('success' => true), 200);
        return teachers::find($id);

    }

    public function showAll(Request $request)
    {
        $sort = $request->input('_sort');
        $end = $request->input('_end');
        $start = $request->input('_start');
        $order = $request->input('_order');
        return response(DB::table('teachers')->orderBy($sort, $order)->offset($start)->limit($end)->get(), 200)
            ->header('X-Total-Count', \App\teachers::all()->count());
    }

    public function delete($id) {
        $student = teachers::find($id);
        $student->delete();
        return response()->json(array('success' => true), 200);
    }

    public function edit($id) {
        $teachers = teachers::find($id);

        $studentData = json_decode(request()->getContent(), true);

        $teachers->name = $studentData['name'];
        $teachers->lastname = $studentData['lastname'];
        $teachers->document = $studentData['document'];
        $teachers->gender = $studentData['gender'];
        $teachers->email = $studentData['email'];
        $teachers->status = $studentData['status'];
        $teachers->status = $studentData['phone'];
        $teachers->entry = date('Y-m-d H:i:s'); //$studentData['entry'];
        //$student->egress = $studentData['egress'];

        $teachers->save();
        return response()->json(array('success' => true, 'id' => $teachers->id), 200);


    }

    public function create(Request $request)
    {
        $teachers = new teachers;
        $studentData = json_decode(request()->getContent(), true);

        $teachers->name = $studentData['name'];
        $teachers->lastname = $studentData['lastname'];
        $teachers->document = $studentData['document'];
        $teachers->gender = $studentData['gender'];
        $teachers->email = $studentData['email'];
        $teachers->status = $studentData['status'];
        $teachers->status = $studentData['phone'];

        $teachers->save();
        return $teachers->id;
    }
}
