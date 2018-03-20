<?php

namespace App\Http\Controllers;

use App\subjects;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\CorrelativeService;

class SubjectController extends Controller
{
    protected $correlativeService;

    public function __construct(
        CorrelativeService $correlativeService
    )
    {
        $this->correlativeService = $correlativeService;
    }

    public function show($id)
    {
        $subject_detail = subjects::find($id);
        $correlatives_details = DB::table('correlatives')
            ->join('subjects', 'subjects.id', '=', 'correlatives.id_subject_dependence')
            ->select('subjects.name', 'subjects.id')
            ->get();
        $res = array('subject_detail'=>$subject_detail, 'correlatives:'=>$correlatives_details);

        return $res;
    }

    public function showAll(Request $request)
    {
        $sort = $request->input('_sort');
        $end = $request->input('_end');
        $start = $request->input('_start');
        $order = $request->input('_order');
        return response(DB::table('subjects')->orderBy($sort, $order)->offset($start)->limit($end)->get(), 200)
            ->header('X-Total-Count', \App\subjects::all()->count());
    }

    public function delete($id) {
        $student = subjects::find($id);
        $student->delete();
        return response()->json(array('success' => true), 200);
    }

    public function edit($id) {
        $subject = subjects::find($id);

        $subjectData = json_decode(request()->getContent(), true);

        $subject->name = $subjectData['name'];
        $subject->description = $subjectData['description'];
        $subject->year = $subjectData['year'];
        $subject->workload = $subjectData['workload'];
        $subject->code = $subjectData['code'];
        $subject->promotable = $subjectData['promotable'];

        $this->correlativeService->store($id, $subjectData['correlatives']);

        $subject->save();

        return response()->json(array('success' => true, 'id' => $subject->id), 200);

    }

    public function create(Request $request)
    {
        $subject = new subjects;
        $subjectData = json_decode(request()->getContent(), true);

        $subject->name = $subjectData['name'];
        $subject->description = $subjectData['description'];
        $subject->year = $subjectData['year'];
        $subject->workload = $subjectData['workload'];
        $subject->code = $subjectData['code'];
        $subject->promotable = $subjectData['promotable'];

        $subject->save();
        return $subject->id;
    }
}
