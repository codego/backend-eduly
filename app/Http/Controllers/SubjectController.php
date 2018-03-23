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

    private function getIdCorrelatives($id_subject) {
        $result_correlatives = array();
        $correlatives = DB::table('correlatives')->where('correlatives.id_subject', '=', $id_subject)
            ->join('subjects', 'subjects.id', '=', 'correlatives.id_subject_dependence')
            ->select('subjects.id')
            ->get();

        foreach ($correlatives as $value) {
            $result_correlatives[] = $value->id;
        }
        return $result_correlatives;
    }

    public function show($id)
    {
        $subjectDetail = subjects::find($id);
        $result = [
            'name'=>$subjectDetail->name,
            'descripcion'=>$subjectDetail->description,
            'year'=>$subjectDetail->year,
            'workload'=>$subjectDetail->workload,
            'code'=>$subjectDetail->code,
            'promotable'=>$subjectDetail->promotable,
            'correlatives'=>$this->getIdCorrelatives($id)
        ];
        return response($result, 200);
    }

    public function getCorrelatives(Request $request) {
        $count = DB::table('correlatives')->where('correlatives.id_subject', '=', $request->input('subject_id'))
            ->count()
            ->get();
        return response(DB::table('correlatives')->where('correlatives.id_subject', '=', $request->input('subject_id'))
            ->join('subjects', 'subjects.id', '=', 'correlatives.id_subject_dependence')
            ->select('subjects.name', 'subjects.id')
            ->get(), 200)->header('X-Total-Count', $count);
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
