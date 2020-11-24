<?php

namespace App\Http\Controllers;

use App\eyb_level;
use App\eyb_users;
use App\Institute;
use App\InstituteStudent;
use App\InstituteStudentList;
use App\InstituteType;
use App\StudentBatch;
use App\Section;
use App\Semester;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use DB;
use Validator;
use Session;
class InstituteController extends Controller
{
    public function institute_batch(Request $request)
    {
        if($request->level != '')
        {
            $batches = StudentBatch::where('level_id',$request->level)->get();
        }
        $html = '<option>Select Batch</option>';
        if(count($batches) > 0)
        {
            foreach($batches as $batch)
            {
                $html .= '<option value="'.$batch->id.'">'.$batch->batch_name.'</option>';
            }
        }

        echo json_encode($html);
    }
    public function Institute(Request $request)
    {
        if ($request->isMethod('post')) {

            $validatedData = $request->validate([
                'email' => 'required|email',
                'password' => 'required|string|max:20|regex:/(^([a-zA-Z0-9]+)(\d+)?$)/u',
            ]);

            $email = $request->email;
            $pass = $request->password;
            $user = Institute::where('admin_email',$email)->where('password',$pass)->first();

            if (!empty($user))
            {
                if ($user['status'] == 1)
                {
                    $rand = md5(rand()).md5($email);
                    Session::put('institute_log',$rand);
                    $user->institute_log = $rand;
                    $user->update();
                    return redirect('/dashboard');
                }else{
                    return redirect()->back()->with(['error' =>'Your account not activated.Please contact to admin.']);
                }
            }else{

                return redirect()->back()->with(['error'=>'Invalid email and password!']);
            }

        }
        return view('admin.institute.login');
    }
    public function manageInstitute()
    {
        $institutes = DB::table('institutes')
                        ->leftJoin('institute_types', 'institutes.type', '=', 'institute_types.id')
                        ->select('institutes.*','institute_types.name')
                        ->get();
        return view('admin.institute.institute',['institutes'=>$institutes]);
    }
    public function editInstitute(Request $request,$id)
    {
         $admin_id  = admin_id();
         $institute = Institute::where('id',$id)->first();
         $admin_email = $institute->admin_email;
         $user = eyb_users::where('email',$admin_email)->first();
         $in_id = $user->id;
         
          if ($request->isMethod('post')) {

            $validatedData = $request->validate([
                'institute_name'    => 'required|string',
                'principal_name'    => 'required|string',
                'principal_phone'   => 'required',
                'admin_email'       => 'unique:eyb_users,email',
                'admin_phone'       => 'required',
                'address'           => 'required',
                'type'              => 'required',
            ]);
           
            $institute->institute_name  = $request->institute_name;
            $institute->principal_name  = $request->principal_name;
            if($request->principal_email)
            {
                $institute->principal_email = $request->principal_email;
            }
            $institute->principal_phone = $request->principal_phone;
            if($request->admin_email)
            {
                $institute->admin_email     = $request->admin_email;
            }
            $institute->admin_phone     = $request->admin_phone;
            $institute->address         = $request->address;
            $institute->type            = $request->type;
            $institute->status          = $request->status;
            $institute->user_id         = $admin_id;
            if ($institute->update())
            {
                $data = array();
                $data['user_type']      = $request->type;
                $data['student_grade']  = 0;
                $data['name']           = $request->institute_name;
                if($request->admin_email)
                {
                  $data['email']          = $request->admin_email;  
                }
                
                if($request->password)
                {
                   $data['password']       = Hash::make($request->password); 
                }
                
                $data['district_id']    = 0;
                $data['status']         = $request->status;
                $id = DB::table('eyb_users')->where('id',$in_id)->update($data);
                return redirect()->back()->with('success','Institute Update Successfully!');
            }else{
                return redirect()->back()->with('error','Institute update Failed!');
            }

        }
        $institute_type = InstituteType::all();
        
        return view('admin.institute.edit-institute',['institute_types'=>$institute_type,'institute'=>$institute]);
    }
    public function addInstitute(Request $request)
    {
        $admin_id  = admin_id();
        if ($request->isMethod('post')) {

            $validatedData = $request->validate([
                'institute_name'    => 'required|string',
                'principal_name'    => 'required|string',
                'principal_email'   => 'required|email',
                'principal_phone'   => 'required',
                'admin_email'       => 'required|email|unique:eyb_users,email',
                'admin_phone'       => 'required',
                'address'           => 'required',
                'password'          => 'required',
                'type'              => 'required',
            ]);
            $institute = new Institute();
            $institute->institute_name  = $request->institute_name;
            $institute->principal_name  = $request->principal_name;
            $institute->principal_email = $request->principal_email;
            $institute->principal_phone = $request->principal_phone;
            $institute->admin_email     = $request->admin_email;
            $institute->admin_phone     = $request->admin_phone;
            $institute->address         = $request->address;
            $institute->type            = $request->type;
            $institute->status          = $request->status;
            $institute->user_id         = $admin_id;
            if ($institute->save())
            {
                $data = array();
                $data['user_type']      = $request->type;
                $data['student_grade']  = 0;
                $data['name']           = $request->institute_name;
                $data['email']          = $request->admin_email;
                $data['password']       = Hash::make($request->password);
                $data['district_id']    = 0;
                $data['status']         = $request->status;
                $id = DB::table('eyb_users')->insertGetId($data);
                return redirect()->back()->with('success','Institute Added Successfully!');
            }else{
                return redirect()->back()->with('error','Institute Added Failed!');
            }

        }

        $institute_type = InstituteType::all();
        return view('admin.institute.add-institute',['institute_types'=>$institute_type]);
    }
    public function Undergraduate()
    {
        $data = array();
        $data['name']           = '';
        $data['institute_id']      = '';
        $data['level']          = '';
        $data['section']        = '';
        $data['roll_number']    = '';
        $institutes = eyb_users::where('user_type',4)->get();
        $data['institutes']     = $institutes;
        return view('front-end.institutes.undergraduate',$data);
    }
    public function institute_level(Request $request, $id)
    {
        $type = $request->type;
        $level_id = $request->level;
        
        $levels = DB::table('eyb_level')->where('user_id',$id)->get();


        $html = '<option value="">Please select level</option>';
        
        if($type == 1)
            {

               foreach ($levels as $level)
                {
                    $checked = '';
                    if($level_id == $level->id)
                    {
                        $checked = 'selected';
                    }
                    $html .= '<option '.$checked.'  value="'.$level->id.'">'.$level->level_name.'</option>';
                }

            }else{
            foreach ($levels as $level)
                {
                    $html .= '<option value="'.$level->id.'">'.$level->level_name.'</option>';
                }
            }
        

        echo $html;
    }
    public function institute_section(Request $request,$id)
    {
        $type = $request->type;
        $section_id = $request->section;

        $sections = Section::where('level_id',$id)->get();
        $html = '<option value="">Please select section</option>';
         if($type == 1)
            {
                foreach ($sections as $section)
                    {
                        $checked = '';
                        if($section_id == $section->id)
                        {
                            $checked = 'selected';
                        }
                        $html .= '<option '.$checked.' value="'.$section->id.'">'.$section->name.'</option>';
                    }

            }else
            {
                 foreach ($sections as $section)
                    {
                        $html .= '<option value="'.$section->id.'">'.$section->name.'</option>';
                    }
            }
       
        echo $html;
    }

    public function institute_semester(Request $request,$id)
    {
        $type = $request->type;
        $semester_id = $request->semester;

        $semesters = Semester::where('level_id',$id)->get();
        $html = '<option value="">Please select semester</option>';
         if($type == 1)
            {
                foreach ($semesters as $semester)
                    {
                        $checked = '';
                        if($semester_id == $semester->id)
                        {
                            $checked = 'selected';
                        }
                        $html .= '<option '.$checked.' value="'.$semester->id.'">'.$semester->semester_name.'</option>';
                    }

            }else
            {
                 foreach ($semesters as $semester)
                    {
                        $html .= '<option value="'.$semester->id.'">'.$semester->semester_name.'</option>';
                    }
            }
       
        echo $html;
    }
    public function institute_register(Request $request)
    {
        
        if ($request->isMethod('post')) {

        $validator = Validator::make($request->all(), 
            [
                'name'                  => 'required|string|max:100|regex:/^[\pL\s\-]+$/u',
                'institute_id'          => 'required|numeric',
                'level'                 => 'required|numeric',
                'section'               => 'required|numeric',
                // 'roll_number'           => 'required|numeric',
            ]
        );
          
            if ($validator->passes()) {
                $institute = eyb_users::where('id',$request->institute_id)->first();
                $user_type = $institute['user_type'];
                $ex = InstituteStudent::where('user_id',user_id())->where('institute_id',$request->institute_id)->first();
                if($ex != false)
                {
                    return redirect()->back()->with('error','You have already registered!');
                }
                $student = new InstituteStudent();
                
                if ($user_type == 4)
                {
                    $student->name              = $request->name;
                    $student->user_id           = user_id();
                    $student->institute_id      = $request->institute_id;
                    $student->institute_type    = 4;
                    $student->level             = $request->level;
                    $student->roll_no           = $request->roll_number;
                    $student->section           = $request->section;
                    $student->semester          = 0;
                    if ($student->save())
                    {

                        return redirect()->route('student_institute')->with('success','Registered successfully.when your institute accept you application then you have to access your academic progress.');
                    }else{
                        return redirect()->back()->with('error','SomeThing mistake!');
                    }
                }
                return redirect()->back()->with('error','SomeThing mistake!');

            }else
            {
                $data = array();
                $data['name']           = $request->name;
                $data['institute_id']   = $request->institute_id;
                $data['level']          = $request->level;
                $data['section']        = $request->section;
                $data['semester']       = '';
                $data['roll_number']    = $request->roll_number;
                $schools = eyb_users::where('user_type',4)->get();
                $universities = eyb_users::where('user_type',2)->get();
                $others = eyb_users::where('user_type',5)->get();
                $data['schools']        = $schools;
                $data['universities']   = $universities;
                $data['others']         = $others;
                $data['selected']       = 'school';
                 //return redirect()->back()->with($data)->withErrors($validator);
            
                return view('front-end.institutes.registration',$data)->withErrors($validator);
                //->withErrors($validator->errors());
            }
            
        }
    }

    public function University(Request $request)
    {
        $data = array();
        $data['name']           = '';
        $data['institute_id']   = '';
        $data['level']          = '';
        $data['section']        = '';
        $data['semester']        = '';
        $data['roll_number']    = '';
        $institutes = eyb_users::where('user_type',2)->get();
        $data['institutes']     = $institutes;
        return view('front-end.institutes.university',$data);
    }
    public function university_register(Request $request)
    {
        if ($request->isMethod('post')) {

        $validator = Validator::make($request->all(), 
            [
                'name'                  => 'required|string|max:100|regex:/^[\pL\s\-]+$/u',
                'institute_id'          => 'required|numeric',
                'level'                 => 'required|numeric',
                'section'               => 'required|numeric',
                'semester'              => 'required|numeric',
                // 'roll_number'           => 'required|numeric',
                // 'g-recaptcha-response'  => 'required',
            ]
        );
          
            if ($validator->passes()) {
                $institute = eyb_users::where('id',$request->institute_id)->first();
                $user_type = $institute['user_type'];
                $ex = InstituteStudent::where('user_id',user_id())->where('institute_id',$request->institute_id)->first();
                if($ex != false)
                {
                    return redirect()->back()->with('error','You have already registered!');
                }
                $student = new InstituteStudent();
                
                if ($user_type == 2)
                {
                    $student->name              = $request->name;
                    $student->user_id           = user_id();
                    $student->institute_id      = $request->institute_id;
                    $student->institute_type    = 2;
                    $student->level             = $request->level;
                    $student->roll_no           = $request->roll_number;
                    $student->section           = $request->section;
                    $student->semester          = $request->semester;
                    if ($student->save())
                    {
                        return redirect()->route('student_institute')->with('success','Registered successfully.when your institute accept you application then you have to access your academic progress.');
                    }else{
                        return redirect()->back()->with('error','SomeThing mistake!');
                    }
                }
                return redirect()->back()->with('error','SomeThing mistake!');

            }else
            {
                $data = array();
                $data['name']           = $request->name;
                $data['institute_id']   = $request->institute_id;
                $data['level']          = $request->level;
                $data['section']        = $request->section;
                $data['semester']       = $request->semester;
                $data['roll_number']    = $request->roll_number;
                $schools = eyb_users::where('user_type',4)->get();
                $universities = eyb_users::where('user_type',2)->get();
                $others = eyb_users::where('user_type',5)->get();
                $data['schools']        = $schools;
                $data['universities']   = $universities;
                $data['others']         = $others;
                $data['selected']       = 'university';
                return view('front-end.institutes.registration',$data)->withErrors($validator);
            }
            
        }
    }
    public function Others()
    {
        $data = array();
        $data['name']           = '';
        $data['institute_id']   = '';
        $data['level']          = '';
        $data['roll_number']    = '';
        $institutes = eyb_users::where('user_type',5)->get();
        $data['institutes']     = $institutes;
        return view('front-end.institutes.others',$data);
    }
    public function others_register(Request $request)
    {
        if ($request->isMethod('post')) {

        $validator = Validator::make($request->all(), 
            [
                'name'                  => 'required|string|max:100|regex:/^[\pL\s\-]+$/u',
                'institute_id'          => 'required|numeric',
                'level'                 => 'required|numeric',
                'batch'                 => 'required|numeric',
                // 'g-recaptcha-response'  => 'required',
            ]
        );
          
            if ($validator->passes()) {
                $institute = eyb_users::where('id',$request->institute_id)->first();
                $user_type = $institute['user_type'];
                $ex = InstituteStudent::where('user_id',user_id())->where('institute_id',$request->institute_id)->where('batch',$request->batch)->first();
                if($ex != false)
                {
                    return redirect()->back()->with('error','You have already registered!');
                }
                $student = new InstituteStudent();
                
                if ($user_type == 5)
                {
                    $student->name              = $request->name;
                    $student->user_id           = user_id();
                    $student->institute_id      = $request->institute_id;
                    $student->institute_type    = 5;
                    $student->level             = $request->level;
                    $student->roll_no           = $request->roll_number;
                    $student->section           = 0;
                    $student->semester          = 0;
                    $student->batch             = $request->batch;
                    if ($student->save())
                    {
                        return redirect()->route('student_institute')->with('success','Registered successfully.when your institute accept you application then you have to access your academic progress.');
                    }else{
                        return redirect()->back()->with('error','SomeThing mistake!');
                    }
                }
                return redirect()->back()->with('error','SomeThing mistake!');

            }else
            {
                $data = array();
                $data['name']           = $request->name;
                $data['institute_id']   = $request->institute_id;
                $data['level']          = $request->level;
                $data['section']        = $request->section;
                $data['semester']       = $request->semester;
                $data['roll_number']    = $request->roll_number;
                $schools = eyb_users::where('user_type',4)->get();
                $universities = eyb_users::where('user_type',2)->get();
                $others = eyb_users::where('user_type',5)->get();
                $data['schools']        = $schools;
                $data['universities']   = $universities;
                $data['others']         = $others;
                $data['selected']       = 'others';
                return view('front-end.institutes.registration',$data)->withErrors($validator);
            }
            
        }
    }
    public function institute_profile()
    {
        $data['institutes'] =  InstituteStudent::where('user_id',user_id())->orderBy('id','DESC')->get();
        $schools = eyb_users::where('user_type',4)->get();
        $universities = eyb_users::where('user_type',2)->get();
        $others = eyb_users::where('user_type',5)->get();
        $data['schools']        = $schools;
        $data['universities']   = $universities;
        $data['others']         = $others;
        
        return view('front-end.institutes.institute-profile',$data);
        
        $institute_info = eyb_users::select('name','user_type')->where('id',$info->institute_id)->first();
        if ($institute_info->user_type == 5) {

            $levels = DB::table('eyb_level')->where('user_id',$info->institute_id)->get();
            $data['batches'] = StudentBatch::where('user_id',$info->institute_id)->get();
           
        }elseif($institute_info->user_type == 2)
        {
            $levels = DB::table('eyb_level')->where('user_id',$info->institute_id)->get();
            $sections = Section::where('level_id',$info->level)->get();
            $semesters = Semester::where('level_id',$info->level)->get();
            $data['sections'] = $sections;
            $data['semesters'] = $semesters;
        }else
        {
            $levels = DB::table('eyb_level')->where('user_id',$info->institute_id)->get();
            $sections = Section::where('level_id',$info->level)->get();
            $data['sections'] = $sections;
        }
        $data['user_info']      = $info;
        $data['institute_info'] = $institute_info;
        $data['levels']         = $levels;
        // echo '<pre>';
        // print_r($data['institute_info']);
        // die;
        return view('front-end.institutes.student-profile',$data);
    }
    public function update_institute_profile(Request $request)
    {
        if ($request->isMethod('post')) {

            $validatedData = $request->validate(
                [
                'name'                  => 'required|max:100|regex:/^[\pL\s\-]+$/u',
                'institute_type'        => 'required|numeric',
                'level'                 => 'required|numeric',
                'section'               => 'numeric',
                'semester'              => 'numeric',
                ]
        );
            
            if($request->institute_type == 5)
            {

                $validatedData = $request->validate(
                    [
                    'batch'                 => 'required|numeric',
                    ]
                );
                $info =  InstituteStudent::where('user_id',user_id())->where('institute_id',$request->institute_id)->where('batch',$request->batch)->first();
                if($info != false)
                {
                    $info->name     = $request->name;
                    $info->level    = $request->level;
                    $info->batch    = $request->batch;
                    $info->status   = 0;
                    $info->roll_no  = $request->roll_number;
                    if ($info->update())
                    {
                        return redirect()->back()->with('success','Successfully Updated.');
                    }else{
                        return redirect()->back()->with('error','SomeThing mistake!');
                    }
                }
                return redirect()->back()->with('error','You have not registered');
            }
            if($request->institute_type == 2)
            {
                $info =  InstituteStudent::where('user_id',user_id())->where('institute_id',$request->institute_id)->first();
                if($info != false)
                {
                    $info->name         = $request->name;
                    $info->level        = $request->level;
                    $info->status   = 0;
                    $info->roll_no      = $request->roll_number;
                    if ($request->section != '') {
                        $info->section   = $request->section;
                    }
                    if ($request->semester != '') {
                        $info->semester  = $request->semester;
                    }
                    if ($info->update())
                        {
                            return redirect()->back()->with('success','Successfully Updated.');
                        }else{
                            return redirect()->back()->with('error','SomeThing mistake!');
                        }
                }
                return redirect()->back()->with('error','You have not registered');
            }
            if($request->institute_type == 4)
            {
                $info =  InstituteStudent::where('user_id',user_id())->where('institute_id',$request->institute_id)->first();
                if($info != false)
                {
                    $info->name         = $request->name;
                    $info->level        = $request->level;
                    $info->status       = 0;
                    $info->roll_no      = $request->roll_number;
                    if ($request->section != '') {
                        $info->section   = $request->section;
                    }
                    if ($info->update())
                    {
                        return redirect()->back()->with('success','Successfully Updated.');
                    }else{
                        return redirect()->back()->with('error','SomeThing mistake!');
                    }
                }
                return redirect()->back()->with('error','SomeThing mistake!');
            }
            return redirect()->back()->with('error','You have not registered');
            
        }
        
    }
    public function manageStudentList(Request $request)
    {
        $draw   = $request->draw;
        $start  = $request->start;
        $length = $request->length;
        $admin_id  = admin_id();
        $total_rows = InstituteStudent::where('institute_id',$admin_id)->count('id');
        if (isset($request->search['value']))
        {
            $users = DB::table('institute_students')
                        ->leftJoin('eyb_level', 'institute_students.level', '=', 'eyb_level.id')
                        ->leftJoin('sections', 'institute_students.section', '=', 'sections.id')
                        ->leftJoin('semesters', 'institute_students.semester', '=', 'semesters.id')
                        ->leftJoin('student_batches', 'institute_students.batch', '=', 'student_batches.id')
                        ->leftJoin('eyb_users', 'institute_students.user_id', '=', 'eyb_users.id')
                        ->where('institute_students.institute_id',$admin_id)
                        ->Where('institute_students.name','like', '%'.$request->search['value'].'%')
                        ->select('institute_students.*','semesters.semester_name as semester','sections.name as section','eyb_level.level_name as level','student_batches.batch_name','eyb_users.email')
                        ->skip($start)
                        ->take($length)
                        ->orderBy('institute_students.status', 'asc')
                        ->orderBy('institute_students.created_at', 'DESC')
                        ->get();
            $count_users = DB::table('institute_students')
                            ->where('institute_id',$admin_id)
                            ->Where('name','like', '%'.$request->search['value'].'%')
                            ->count();
            $total_rows = $count_users;
        }else
        {
           $users =  DB::table('institute_students')
                        ->leftJoin('eyb_level', 'institute_students.level', '=', 'eyb_level.id')
                        ->leftJoin('sections', 'institute_students.section', '=', 'sections.id')
                        ->leftJoin('semesters', 'institute_students.semester', '=', 'semesters.id')
                        ->leftJoin('student_batches', 'institute_students.batch', '=', 'student_batches.id')
                        ->leftJoin('eyb_users', 'institute_students.user_id', '=', 'eyb_users.id')
                        ->select('institute_students.*','semesters.semester_name as semester','sections.name as section','eyb_level.level_name as level','eyb_users.email','student_batches.batch_name')
                        ->where('institute_id',$admin_id)
                        ->skip($start)
                        ->take($length)
                        ->orderBy('institute_students.status', 'asc')
                        ->orderBy('institute_students.created_at', 'DESC')
                        ->get();
            
                            
        }
        
        $data = array();
        $data['draw'] = $draw;
        $data['recordsTotal'] = $total_rows;
        $data['recordsFiltered'] = $total_rows;
        $data['data'] = array();
        $i = 1;
        $o = 0;
        foreach($users as $key=>$user)
        {
            $status = '';
            $type = '';
            if($user->status == 0)
            {
                $status = '<a title="Make Active" href="'.route('active_student',$user->id).'" class="btn btn-danger"> Deactive </a>';
            }else{
                $status = '<a title="Make Deactive" href="'.route('deactive_student',$user->id).'" class="btn btn-success"> Active </a>';
            }
            $data['data'][$o][] = $i;
            $data['data'][$o][] = $user->name;
            $data['data'][$o][] = $user->email;
            $data['data'][$o][] = $user->level;
            if(admin_type() == 2)
            {
                $data['data'][$o][] = $user->semester;
            }
            if(admin_type() != 5)
            {
                $data['data'][$o][] = $user->section;
            }
            if(admin_type() == 5)
            {
                $data['data'][$o][] = $user->batch_name;
            }
            $data['data'][$o][] = $status;
            $i++;
            $o++;
        }
        echo json_encode($data);
    }
    public function manageStudent()
    {
         $admin_id  = admin_id();
         $institute_info = eyb_users::select('user_type')->where('id',$admin_id)->first();
         $students = DB::table('institute_students')
                        ->leftJoin('eyb_level', 'institute_students.level', '=', 'eyb_level.id')
                        ->leftJoin('sections', 'institute_students.section', '=', 'sections.id')
                        ->leftJoin('semesters', 'institute_students.semester', '=', 'semesters.id')
                        ->leftJoin('student_batches', 'institute_students.batch', '=', 'student_batches.id')
                        ->leftJoin('eyb_users', 'institute_students.institute_id', '=', 'eyb_users.id')
                        ->select('institute_students.*','semesters.semester_name as semester','sections.name as section','eyb_level.level_name as level','eyb_users.user_type','student_batches.batch_name')
                        ->where('institute_id',$admin_id)
                        ->orderBy('id','DESC')
                        ->paginate(10);
         return view('admin.students.students',['students'=>$students,'institute_info'=>$institute_info]);
    }
    public function deactiveStudent($id)
    {
        $admin_id  = admin_id();
        $info =  InstituteStudent::where('id',$id)->where('institute_id',$admin_id)->first();
        if (!empty($info)) {
           $info->status = 0;
            if ($info->update()){

                return redirect()->back()->with('success','Successfully Deactivated.');
            }else{
                return redirect()->back()->with('error','SomeThing mistake!');
            }
        }
        return redirect()->back()->with('error','SomeThing mistake!');
    }
     public function activeStudent($id)
    {
        $admin_id  = admin_id();
        $info =  InstituteStudent::where('id',$id)->where('institute_id',$admin_id)->first();
        if (!empty($info)) {
           $info->status = 1;
            if ($info->update()){

                return redirect()->back()->with('success','Successfully activated.');
            }else{
                return redirect()->back()->with('error','SomeThing mistake!');
            }
        }
        return redirect()->back()->with('error','SomeThing mistake!');
        
    }
    public function institute_registration()
    {
        $data = array();
        $data['name']           = '';
        $data['institute_id']   = '';
        $data['level']          = '';
        $data['section']        = '';
        $data['semester']       = '';
        $data['roll_number']    = '';
        $schools = eyb_users::where('user_type',4)->get();
        $universities = eyb_users::where('user_type',2)->get();
        $others = eyb_users::where('user_type',5)->get();
        $data['schools']        = $schools;
        $data['universities']   = $universities;
        $data['others']         = $others;
        $data['selected']       = 'school';
        return view('front-end.institutes.registration',$data);
    }
    public function remove_institute($id)
    {
        $info =  InstituteStudent::where('user_id',user_id())->where('id',$id)->first();
        if($info != false)
        {
            $institute_student_lists = new InstituteStudentList();
            $institute_student_lists->name = $info->name;
            $institute_student_lists->institute_id = $info->institute_id;
            $institute_student_lists->user_id = $info->user_id;
            $institute_student_lists->roll_no = $info->roll_no;
            $institute_student_lists->level = $info->level;
            $institute_student_lists->section = $info->section;
            $institute_student_lists->semester = $info->semester;
            $institute_student_lists->create_date = date('Y-m-d',strtotime($info->created_at));
            if ($institute_student_lists->save()) {
               
               $info->delete();
              return redirect()->back()->with('success','You have successfully deleted your registered institute');
            }else
            {
                return redirect()->back()->with('error','SomeThing mistake!');
            }
        }
        return redirect()->back()->with('error','SomeThing mistake!');
    }
}
