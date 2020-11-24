<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Semester;
class SemesterController extends Controller
{
    public function manage_semester(Request $request)
    {
        $admin_id  = admin_id();
        if ($request->isMethod('post')) {
            $validatedData = $request->validate([
                'level_id' => 'required|string|max:100',
                'semester' => 'required|string|max:100',
            ]);
            $data = array();
            $data['semester_name'] = $request->semester;
            $data['level_id'] = $request->level_id;
            $data['user_id']    = $admin_id;
            $data['created_at'] = date('Y-m-d');
            $data['updated_at'] = date('Y-m-d');
            DB::table('semesters')->insert($data);
            return redirect()->route('manage_semester')->with('success','Successfully added Subject.');
        }
        $semesters = DB::table('semesters')
                        ->leftJoin('eyb_level', 'semesters.level_id', '=', 'eyb_level.id')
                        ->select('semesters.*','eyb_level.level_name')
                        ->where('semesters.user_id',$admin_id)
                        ->get();
        $levels = DB::table('eyb_level')->where('user_id',$admin_id)->get();
        return view('admin.semesters.manage-semester',['semesters'=>$semesters,'levels'=>$levels]);
    }
    public function editSemester($id)
    {
        $admin_id   = admin_id();
        $semester    = DB::table('semesters')->where('user_id',$admin_id)->where('id',$id)->first();
        $levels     = DB::table('eyb_level')->where('user_id',$admin_id)->get();
        return view('admin.semesters.edit-semester',['semester'=>$semester,'levels'=>$levels]);
    }
    public function updateSemester(Request $request,$id)
    {
        $admin_id       = admin_id();

        $validatedData = $request->validate([
            'level_id' => 'required|string|max:100',
            'semester'  => 'required|string|max:100',
        ]);
        $data = array();
        $data['semester_name']   = $request->semester;
        $data['level_id']       = $request->level_id;
        $data['user_id']        = $admin_id;
        $data['updated_at']     = date('Y-m-d');
        DB::table('semesters')
            ->where('id', $id)
            ->update($data);
        return redirect()->back()->with('success','Semester Updated Successfully!');
    }
    public function deleteSemester(Request $request)
    {
        $id = $request->id;
       
        if(Semester::where('id',$id)->delete())
        {
            echo 1;
        }else
        {
            echo 0;
        }
    }
}
