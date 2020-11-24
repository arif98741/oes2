<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\eyb_subject;
class SubjectController extends Controller
{
    public function manage_subject(Request $request)
    {
        $admin_id  = admin_id();
        if ($request->isMethod('post')) {
            $validatedData = $request->validate([
                'level_id' => 'required|string|max:100',
                'subject' => 'required|string|max:100',
            ]);
            $data = array();
            $data['subject_name'] = $request->subject;
            $data['level_id'] = $request->level_id;
            $data['user_id']    = $admin_id;
            $data['created_at'] = date('Y-m-d');
            $data['updated_at'] = date('Y-m-d');
            DB::table('eyb_subjects')->insert($data);
            return redirect()->route('manage_subject')->with('success','Successfully added Subject.');
        }
        $subjects = DB::table('eyb_subjects')
                        ->leftJoin('eyb_level', 'eyb_subjects.level_id', '=', 'eyb_level.id')
                        ->select('eyb_subjects.*','eyb_level.level_name')
                        ->where('eyb_subjects.user_id',$admin_id)
                        ->where('eyb_subjects.status',1)
                        ->get();
        $levels = DB::table('eyb_level')->where('user_id',$admin_id)->get();
        return view('admin.subjects.manage-subject',['subjects'=>$subjects,'levels'=>$levels]);
    }
    public function editSubject($id)
    {
        $admin_id   = admin_id();
        $subject    = DB::table('eyb_subjects')->where('user_id',$admin_id)->where('id',$id)->first();
        $levels     = DB::table('eyb_level')->where('user_id',$admin_id)->get();
        return view('admin.subjects.edit-subject',['subject'=>$subject,'levels'=>$levels]);
    }
    public function updateSubject(Request $request,$id)
    {
        $admin_id       = admin_id();

        $validatedData = $request->validate([
            'level_id' => 'required|string|max:100',
            'subject'  => 'required|string|max:100',
        ]);
        $data = array();
        $data['subject_name']   = $request->subject;
        $data['level_id']       = $request->level_id;
        $data['user_id']        = $admin_id;
        $data['updated_at']     = date('Y-m-d');
        DB::table('eyb_subjects')
            ->where('id', $id)
            ->update($data);
        return redirect()->back()->with('success','Subject Updated Successfully!');
    }
    public function deleteSubject(Request $request)
    {
        $id = $request->id;
       
        if(eyb_subject::where('id',$id)->delete())
        {
            echo 1;
        }else
        {
            echo 0;
        }
    }
}
