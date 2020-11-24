<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Section;
class SectionController extends Controller
{
    public function manage_section(Request $request)
    {
        $admin_id  = admin_id();
        if ($request->isMethod('post')) {
            $validatedData = $request->validate([
                'level_id' => 'required|string|max:100',
                'name' => 'required|string|max:100',
            ]);
            $data = array();
            $data['name'] = $request->name;
            $data['level_id'] = $request->level_id;
            $data['user_id']    = $admin_id;
            $data['created_at'] = date('Y-m-d');
            $data['updated_at'] = date('Y-m-d');
            DB::table('sections')->insert($data);
            return redirect()->route('manage_section')->with('success','Successfully added Subject.');
        }
        $sections = DB::table('sections')
                        ->leftJoin('eyb_level', 'sections.level_id', '=', 'eyb_level.id')
                        ->select('sections.*','eyb_level.level_name')
                        ->where('sections.user_id',$admin_id)
                        ->get();
        $levels = DB::table('eyb_level')->where('user_id',$admin_id)->get();
        return view('admin.sections.manage-section',['sections'=>$sections,'levels'=>$levels]);
    }
    public function editSection($id)
    {
        $admin_id   = admin_id();
        $section    = DB::table('sections')->where('user_id',$admin_id)->where('id',$id)->first();
        $levels     = DB::table('eyb_level')->where('user_id',$admin_id)->get();
        return view('admin.sections.edit-section',['section'=>$section,'levels'=>$levels]);
    }

    public function updateSection(Request $request,$id)
    {
        $admin_id       = admin_id();

        $validatedData = $request->validate([
            'level_id' => 'required|string|max:100',
            'name'  => 'required|string|max:100',
        ]);
        $data = array();
        $data['name']   = $request->name;
        $data['level_id']       = $request->level_id;
        $data['user_id']        = $admin_id;
        $data['updated_at']     = date('Y-m-d');
        DB::table('sections')
            ->where('id', $id)
            ->update($data);
        return redirect()->back()->with('success','Subject Updated Successfully!');
    }
    public function deleteSection(Request $request)
    {
        $id = $request->id;
       
        if(Section::where('id',$id)->delete())
        {
            echo 1;
        }else
        {
            echo 0;
        }
    }
}
