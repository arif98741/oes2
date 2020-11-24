<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\eyb_level;
class LevelController extends Controller
{
    public function manage_level(Request $request)
    {
        //$method = $request->method();
        //$all = $request->all();
        //$get = $request->query();
        //$post = $request->post();
        $admin_id  = admin_id();
        if ($request->isMethod('post')) {
                $validatedData = $request->validate([
                    'level_name' => 'required|string|max:100',
                ]);
                $data = array();
                $data['level_name'] = $request->level_name;
                $data['user_id']    = $admin_id;
                $data['created_at'] = date('Y-m-d');
                DB::table('eyb_level')->insert($data);
                return redirect()->route('manage_level')->with('success','Successfully added level.');
        }

        $levels = DB::table('eyb_level')->where('user_id',$admin_id)->get();
        return view('admin.levels.manage-level',['levels'=>$levels]);
    }
    public function editLevel($id)
    {
        $admin_id   = admin_id();
        $level      = DB::table('eyb_level')->where('user_id',$admin_id)->where('id',$id)->first();
        return view('admin.levels.edit-level',['level'=>$level]);
    }
    public function updateLevel(Request $request,$id)
    {
        $admin_id       = admin_id();
        $validatedData  = $request->validate([
            'level_name' => 'required|string',
        ]);

        $data = array();
        $data['level_name'] = $request->level_name;
        DB::table('eyb_level')
            ->where('id', $id)
            ->update($data);
        return redirect()->back()->with('success','Level Updated Successfully!');

    }
    public function deleteLavel(Request $request)
    {
        $id = $request->id;
       
        if(DB::table('eyb_level')->where('id',$id)->delete())
        {
            echo 1;
        }else
        {
            echo 0;
        }
    }
}
