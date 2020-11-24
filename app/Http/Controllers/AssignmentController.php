<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Validator;
use App\Assignment;
use App\Semester;
use App\Section;
use App\eyb_subject;
use App\eyb_users;
use App\InstituteStudent;
use App\std_assignment_ans;
use Session;
class AssignmentController extends Controller
{
    public function manageAssignment()
    {
    	$admin_id = admin_id();
        $data = array();
        $data['levels']         = $this->level();
        $data['question_types'] = $this->QuestionType();

    	return view('admin.assignments.assignments',$data);
    }
    public function level()
    {
        $admin_id = admin_id();
        if(session('super_status'))
        {
            $admin_id = 1;
        }
        $levels = DB::table('eyb_level')->where('user_id',$admin_id)->get();
        return $levels;
    }
    public function Subject()
    {
        $admin_id = admin_id();
        if(session('super_status'))
        {
            $admin_id = 1;
        }
        $subjects = DB::table('eyb_subjects')->where('user_id',$admin_id)->get();
        return $subjects;
    }public function ModuleType()
    {
        $module_types = DB::table('eyb_module_types')->get();
        return $module_types;
    }
    public function QuestionType()
    {
        $question_types = DB::table('eyb_question_types')->where('status',1)->get();
        return $question_types;
    }
    public function get_user()
    {
        // $get_session = session('user_id');
        // $user = DB::table('eyb_users')
        //         ->where('id',$get_session)
        //         ->first();
        // $user_id = $user->id;
        return session('user_id');
    }
    public function addAssignment(Request $request)
    {
    	$admin_id = admin_id();
        if(session('super_status'))
        {
            $admin_id = 1;
        }
        $data = array();
        $data['levels']         = $this->level();
        $data['question_types'] = $this->QuestionType();

    	return view('admin.assignments.add-assignment',$data);
    }
    public function saveAssignment(Request $request)
    {

    	if (admin_type() == 2)
        {
            $validator = Validator::make($request->all(), [

                'student_grade'       => 'required|numeric',
                'subjects'            => 'required|numeric',
                'section'             => 'required|numeric',
                'semester'            => 'required|numeric',
                'title'        		  => 'required|string|max:100',
                'exam_start'      	  => 'required|date',
                'exam_end'      	  => 'required|numeric',
                'assignment'      	  => 'required|file',

            ]);
        }elseif(admin_type() == 5)
        {
            $validator = Validator::make($request->all(), [

                'student_grade'       => 'required|numeric',
                'subjects'            => 'required|numeric',
                'title'        		  => 'required|string|max:100',
                'exam_start'      	  => 'required|date',
                'exam_end'      	  => 'required|numeric',
                'assignment'      	  => 'required|file',

            ]);
        }elseif(admin_type() == 4)
        {
            $validator = Validator::make($request->all(), [

                'student_grade'       => 'required|numeric',
                'subjects'            => 'required|numeric',
                'section'             => 'required|numeric',
                'title'        		  => 'required|string|max:100',
                'exam_start'      	  => 'required|date',
                'exam_end'      	  => 'required|numeric',
                'assignment'      	  => 'required|file',

            ]);
        }elseif(admin_type() == 1)
        {
            $validator = Validator::make($request->all(), [

                'student_grade'       => 'required|numeric',
                'subjects'            => 'required|numeric',
                'title'               => 'required|string|max:100',
                'exam_start'          => 'required|date',
                'exam_end'            => 'required|numeric',
                'assignment'          => 'required|file',

            ]);
        }
        if ($validator->passes()) {
            $user_id    = admin_id();
            if(session('super_status'))
            {
                $user_id = 1;
            }
            $user_type  = admin_type();

            $exam_start = strtotime($request->exam_start);
            $exam_end = $exam_start+($request->exam_end*60);
            
            $image 		= $request->file('assignment');
            $rand = rand(10000,999999);
            $imageName 	= time().'_'.$rand.'.'.$image->getClientOriginalExtension();
            $file 		= 'assets/assignmant/'.time().'_'.$rand.'.'.$image->getClientOriginalExtension();
            $image->move('public/assets/assignmant',$imageName);
            
        	$assignmet = new Assignment();
        	$assignmet->user_id 		= $user_id;
        	$assignmet->user_type 		= $user_type;
        	$assignmet->student_grade 	= $request->student_grade;
        	$assignmet->semester 		= isset($request->semester) ? $request->semester : 0;
        	$assignmet->section 		= isset($request->section) ? $request->section : 0;
        	$assignmet->subjects 		= $request->subjects;
        	$assignmet->title 			= $request->title;
        	$assignmet->exam_date 		= date('Y-m-d',strtotime($request->exam_start));
        	$assignmet->exam_start 		= $exam_start;
        	$assignmet->exam_end 		= $exam_end;
        	$assignmet->assignment 		= $file;
        	$assignmet->status 			= 1;
        	$assignmet->save();
        	$assignmet_id = Assignment::orderBy('id','DESC')->first();
        	
			return response()->json(['success'=>$assignmet_id->id]);
        }else{

        	return response()->json(['error'=>$validator->errors()->all()]);
        }
    }
    public function searchAssignment(Request $request)
    {
    	if (admin_type() == 2)
        {
            $required = array();

            $validator = Validator::make($request->all(), [

                'student_grade'       => 'required|numeric',
                'subjects'            => 'required|numeric',
                'section'             => 'numeric',
                'semester'            => 'numeric',
                // 'exam_date'           => 'date',

            ]);
        }elseif(admin_type() == 5)
        {
            $validator = Validator::make($request->all(), [

                'student_grade'       => 'required|numeric',
                'subjects'            => 'required|numeric',
                // 'exam_date'           => 'date',

            ]);
        }elseif(admin_type() == 4)
        {
            $validator = Validator::make($request->all(), [

                'student_grade'       => 'required|numeric',
                'subjects'            => 'required|numeric',
                'section'             => 'numeric',
                // 'exam_date'           => 'date',

            ]);
        }elseif(admin_type() == 1)
        {
            $validator = Validator::make($request->all(), [

                'student_grade'       => 'required|numeric',
                'subjects'            => 'required|numeric',

            ]);
        }

         if ($validator->passes()) {

            $condition = array();
            
            if ($request->student_grade > 0 )
            {
                $condition['student_grade'] = $request->student_grade;
            }
            if ($request->subjects > 0 )
            {
                $condition['subjects'] = $request->subjects;
            }
            if ($request->semester > 0 )
            {
                $condition['semester'] = $request->semester;
            }
            if ($request->section > 0 )
            {
                $condition['section'] = $request->section;

            }
            if ($request->exam_date != '' )
            {
                $condition['exam_date'] = date('Y-m-d',strtotime($request->exam_date));

            }
            $user_id    = admin_id();
            if(session('super_status'))
            {
                $user_id = 1;
            }
            $user_type  = admin_type();
            $condition['assignments.user_id'] = $user_id;

            $assignments = DB::table('assignments')
                        ->leftJoin('eyb_subjects', 'assignments.subjects', '=', 'eyb_subjects.id')
                        ->leftJoin('sections', 'assignments.section', '=', 'sections.id')
                        ->leftJoin('semesters', 'assignments.semester', '=', 'semesters.id')
                        ->leftJoin('eyb_level', 'assignments.student_grade', '=', 'eyb_level.id')
                        ->select('assignments.id','assignments.title','eyb_subjects.subject_name','sections.name','semesters.semester_name','eyb_level.level_name')
                        ->where($condition)
                        ->orderBy('id','DESC')
                        ->get();

            $count = count($assignments);
            if ($count > 0)
            {
                $html = '';
                foreach($assignments as $assignment)
                {
                    $html .= '<tr>';
                    $html .= '<td>'.$assignment->title.'</td>';
                    $html .= '<td>'.$assignment->level_name.'</td>';
                    $html .= '<td>'.$assignment->subject_name.'</td>';
                    if(admin_type() == 2 || admin_type() == 1) {
                        $html .= '<td>' . $assignment->semester_name . '</td>';
                    }
                    if(admin_type() != 5) {
                        $html .= '<td>' . $assignment->name . '</td>';
                    }
                    $html .= '<td ><a class="btn btn-primary" href="'.route('edit_assignment',$assignment->id).'">Edit</a><a style="margin-left: 10px;" class="btn btn-success" href="'.route('assignment_view',$assignment->id).'">View</a></td>';
                    $html .= '</tr>';
                }
                return response()->json(['success'=>$html]);
            }else
            {
                return response()->json(['success'=>'No data found!']);
            }
        }else{
            return response()->json(['error'=>$validator->errors()->all()]);
        }
    }
    public function editAssignment(Request $request,$id)
    {
    	$user_id    = admin_id();
        if(session('super_status'))
        {
            $user_id = 1;
        }
        $user_type  = admin_type();
        $assignment = Assignment::where('user_id',$user_id)->where('user_type',$user_type)->where('id',$id)->first();

        $admin_id = admin_id();
        if(session('super_status'))
        {
            $admin_id = 1;
        }
        $data = array();
        $data['levels']         = $this->level();
        $data['question_types'] = $this->QuestionType();
        $data['semesters']      = Semester::where('user_id',$user_id)->where('level_id',$assignment->student_grade)->get();
        $data['sections']       = Section::where('user_id',$user_id)->where('level_id',$assignment->student_grade)->get();
        $data['subjects']       = eyb_subject::where('user_id',$user_id)->where('level_id',$assignment->student_grade)->where('status',1)->get();
        $data['assignment'] 	= $assignment;

        if ($request->isMethod('post')) {
            if (admin_type() == 2)
            {
                $validator = Validator::make($request->all(), [

                    'student_grade'       => 'required|numeric',
                    'subjects'            => 'required|numeric',
                    'section'             => 'required|numeric',
                    'semester'            => 'required|numeric',
                    'title'               => 'required|string|max:100',
                    'exam_start'          => 'required|date',
                    'exam_end'            => 'required|numeric',

                ]);
            }elseif(admin_type() == 5)
            {
                $validator = Validator::make($request->all(), [

                    'student_grade'       => 'required|numeric',
                    'subjects'            => 'required|numeric',
                    'title'               => 'required|string|max:100',
                    'exam_start'          => 'required|date',
                    'exam_end'            => 'required|numeric',

                ]);
            }elseif(admin_type() == 4)
            {
                $validator = Validator::make($request->all(), [

                    'student_grade'       => 'required|numeric',
                    'subjects'            => 'required|numeric',
                    'section'             => 'required|numeric',
                    'title'               => 'required|string|max:100',
                    'exam_start'          => 'required|date',
                    'exam_end'            => 'required|numeric',

                ]);
            }elseif(admin_type() == 1)
            {
                $validator = Validator::make($request->all(), [

                    'student_grade'       => 'required|numeric',
                    'subjects'            => 'required|numeric',
                    'title'               => 'required|string|max:100',
                    'exam_start'          => 'required|date',
                    'exam_end'            => 'required|numeric',

                ]);
            }
            if ($validator->passes()) {
                $user_id    = admin_id();
                if(session('super_status'))
                {
                    $user_id = 1;
                }
                $user_type  = admin_type();

                $exam_start = strtotime($request->exam_start);
                $exam_end = $exam_start+($request->exam_end*60);
                
                if($request->file('assignment'))
                {
                    $image      = $request->file('assignment');
                    $rand = rand(10000,999999);
                    $imageName  = time().'_'.$rand.'.'.$image->getClientOriginalExtension();
                    $file       = 'assets/assignmant/'.time().'_'.$rand.'.'.$image->getClientOriginalExtension();
                    $image->move('public/assets/assignmant',$imageName);
                    $path = base_path().'/'.$assignment->assignment;
                    if (file_exists($path)) {
                            unlink($path);
                        }
                    $assignment->assignment      = $file;
                }
                
                $assignment->user_id         = $user_id;
                $assignment->user_type       = $user_type;
                $assignment->student_grade   = $request->student_grade;
                $assignment->semester        = isset($request->semester) ? $request->semester : 0;
                $assignment->section         = isset($request->section) ? $request->section : 0;
                $assignment->subjects        = $request->subjects;
                $assignment->title           = $request->title;
                $assignment->exam_date       = date('Y-m-d',strtotime($request->exam_start));
                $assignment->exam_start      = $exam_start;
                $assignment->exam_end        = $exam_end;
                $assignment->status          = 1;
                $assignment->update();
                
                return response()->json(['success'=>$id]);
            }else{

                return response()->json(['error'=>$validator->errors()->all()]);
            }
        }
        // echo '<pre>';
        // print_r($data);
        // die;
    	return view('admin.assignments.edit-assignment',$data);
    }
    // student part
    public function search_student_assignment(Request $request)
    {
        $validator = Validator::make($request->all(), [

                'subject'         => 'required|numeric',
            ]);

        if ($validator->passes()) {
            $subject = eyb_subject::where('id',$request->subject)->first();
            $ins_id = $subject->user_id;
            $institute = eyb_users::where('id',$ins_id)->first();
            $std_id     = $this->get_user();
            $inst_info  = InstituteStudent::where('user_id',$std_id)->first();
            $std_info   = eyb_users::where('id',$std_id)->first();
            $std_ass_ans = DB::table('std_assignment_ans')
                                ->select('assignment_id')
                                ->where('student_id',$std_id)
                                ->get();
            $json  = json_encode($std_ass_ans);
            $array = json_decode($json, true);
            $data = array();
            $assignments_query = DB::table('assignments')
                            ->leftJoin('std_assignment_ans', 'assignments.id', '=', 'std_assignment_ans.assignment_id')
                            ->leftJoin('eyb_subjects', 'assignments.subjects', '=', 'eyb_subjects.id')
                            ->select('assignments.*','eyb_subjects.subject_name')
                            ->where('assignments.subjects',$request->subject)
                            ->where('assignments.exam_start','<=',time())
                            ->where('assignments.exam_end','>=',time())
                            ->where('assignments.exam_date','like','%'.date('Y-m-d').'%');
                            
            if($institute->user_type == 1)
            {
               $assignments_query->where('assignments.user_id',1);
               $assignments_query->where('assignments.student_grade',$subject->level_id);
            }else{
                if ($inst_info->semester != 0) {
                    $assignments_query->where('assignments.semester',$inst_info->semester);
                }
                if ($inst_info->section != 0) {
                    $assignments_query->where('assignments.section',$inst_info->section);
                }
            }
            if (!empty($std_ass_ans)) {
                $assignments_query->whereNotIn('assignments.id', array_column($array, 'assignment_id'));
            }
            $assignments_query->orderBy('assignments.id', 'asc');
            $result = $assignments_query->get();
            $html = '';
            $html .= '<thead>';
            $html .= '<tr>';
            $html .= '<th scope="col">SL</th>';
            $html .= '<th scope="col">Assignment Name</th>';
            $html .= '<th scope="col">Subject</th>';
            $html .= '<th scope="col">Start - End</th>';
            $html .= '<th scope="col">Action</th>';
            $html .= '</tr>';
            $html .= '</thead>';
            $html .= '<tbody>';
           
            if(count($result) > 0)
            {
                $i = 1;
                foreach($result  as $module)
                {
                   $html .= '<tr>';
                   $html .= '<td>'.$i.'</td>';
                   $html .= '<td>'.$module->title.'</td>';
                   $html .= '<td>'.$module->subject_name.'</td>';
                   $html .= '<td>'.date('d-M-Y H:i',$module->exam_start).'-'.date('d-M-Y H:i',$module->exam_end).'</td>';
                   $html .= '<td><a href="'.route('assignment_exam',$module->id).'">Start</a></td>';
                   $html .= '</tr>';
                   $i++;
                }
            }else{

                $html .= '<tr><td colspan="7">No data found!</td></tr>';
            }  
            $html .= '</tbody>';          
                  
            return response()->json(['success'=>$html]);
        }else{

            return response()->json(['error'=>$validator->errors()->all()]);
        }
    }
    public function tutorAssignment_old()
    {
        $std_id     = $this->get_user();
        $std_info   = eyb_users::where('id',$std_id)->first();
        $inst_info  = InstituteStudent::where('user_id',$std_id)->first();
        $std_ass_ans = DB::table('std_assignment_ans')
                            ->select('assignment_id')
                            ->where('student_id',$std_id)
                            ->get();
        $json  = json_encode($std_ass_ans);
        $array = json_decode($json, true);
        $data = array();
        //DB::enableQueryLog();
        $assignments_query = DB::table('assignments')
                            ->leftJoin('std_assignment_ans', 'assignments.id', '=', 'std_assignment_ans.assignment_id')
                            ->leftJoin('eyb_subjects', 'assignments.subjects', '=', 'eyb_subjects.id')
                            ->select('assignments.*','eyb_subjects.subject_name')
                            ->where('assignments.user_id',$inst_info['institute_id'])
                            ->where('assignments.exam_start','<=',time())
                            ->where('assignments.exam_end','>=',time())
                            ->where('assignments.exam_date','like','%'.date('Y-m-d').'%')
                            ->where('assignments.student_grade',$inst_info['level']);
                            if ($inst_info->semester != 0) {
                              $assignments_query->where('assignments.semester',$inst_info->semester);
                            }
                            if ($inst_info->section != 0) {
                              $assignments_query->where('assignments.section',$inst_info->section);
                            }
            if (!empty($std_ass_ans)) {
                $assignments_query->whereNotIn('assignments.id', array_column($array, 'assignment_id'));
            }
        $assignments_query->orderBy('assignments.id', 'asc');
        $result = $assignments_query->get();
       // $query = DB::getQueryLog();
         $data['assignments'] = $result;
        return view('front-end.assignments.tutor-assignments',$data);
                           
    }
    public function tutorAssignment()
    {
        $user_id        = $this->get_user();
        $instraction_type = array();
        $instraction_type[0]['id']   = 1;
        $instraction_type[0]['name'] = 'রংধনু পাঠশালা';
        if(!empty(haveInstituteStudent()))
        {
            $Institute = eyb_users::where('id',haveInstituteStudent()->institute_id)->first();
            $instraction_type[1]['id']   = 2;
            $instraction_type[1]['name'] = ucwords(strtolower($Institute->name));
        }
        
        $student_info               = $this->student_info();
        $data = array();
        $data['student_info']       = $student_info;
        $data['instraction_types']   = $instraction_type;
        return view('front-end.assignments.tutor-assignments',$data);
                           
    }
    public function student_info()
    {
        $user_id = $this->get_user();
        $user_info = DB::table('eyb_users')
            ->where('id',$user_id)
            ->first();
        return $user_info;
    }

    public function module_time_set($module)
    {

        $exam_time_second = $module->exam_end - $module->exam_start;
        if(session()->has('ass_module_id'))
        {
            $se_m_id = session('ass_module_id');
            if($se_m_id != $module->id)
            {
                session()->forget('ass_end_time');
                session()->forget('ass_start_time');
                session()->forget('ass_module_id');

                if($exam_time_second != 0)
                {
                    //$exam_time = $exam_time_second/60;
                    Session::put('ass_end_time',$module->exam_end);
                    Session::put('ass_start_time',$module->exam_start);
                    Session::put('ass_module_id',$module->id);
                }
            }else{
               // session()->forget('exam_end_time');
               // session()->forget('exam_start_time');
               // session()->forget('exam_module_id');
            }
        }else{

            if($exam_time_second != 0)
            {
                //$exam_time = $exam_time_second/60;
                Session::put('ass_end_time',$module->exam_end);
                Session::put('ass_start_time',$module->exam_start);
                Session::put('ass_module_id',$module->id);
            }
        }
    }
    public function assignmentExam($id)
    {
        $std_id     = $this->get_user();
        $std_info   = eyb_users::where('id',$std_id)->first();
        $inst_info  = InstituteStudent::where('user_id',$std_id)->first();
        $std_ass_ans = DB::table('std_assignment_ans')
                            ->select('assignment_id')
                            ->where('student_id',$std_id)
                            ->get();
        $json  = json_encode($std_ass_ans);
        $array = json_decode($json, true);
        $assignments_query = DB::table('assignments')
                            ->leftJoin('std_assignment_ans', 'assignments.id', '=', 'std_assignment_ans.assignment_id')
                            ->leftJoin('eyb_subjects', 'assignments.subjects', '=', 'eyb_subjects.id')
                            ->select('assignments.*','eyb_subjects.subject_name')
                            ->where('assignments.exam_start','<=',time())
                            ->where('assignments.exam_end','>=',time())
                            ->where('assignments.exam_date','like','%'.date('Y-m-d').'%')
                            ->where('assignments.id',$id);
            if (!empty($std_ass_ans)) {
                $assignments_query->whereNotIn('assignments.id', array_column($array, 'assignment_id'));
            }
        $assignments_query->orderBy('assignments.id', 'asc');
        $result = $assignments_query->first();
        $this->module_time_set($result);
        if (!empty($result)) {
           $data['assignment'] = $result;
            return view('front-end.assignments.assignment-exam',$data);
        }else
        {
            return redirect()->back()->with(['error'=>'Not valid!']);
        }
        
    }
    public function assignmentSubmit(Request $request)
    {
        if ($request->isMethod('post')) {

            $validatedData = $request->validate([
                'ass_id' => 'required|numeric',
                'answer' => 'required',
            ]);
            $allowedfileExtension=['jpeg','jpg','png'];
            $files = $request->file('answer');
            foreach($files as $file){

                $filename   = $file->getClientOriginalName();
                $extension  = $file->getClientOriginalExtension();
                $check      = in_array($extension,$allowedfileExtension);
                if($check)
                {

                }else
                {
                    return redirect()->back()->with(['error'=>'images format only jpeg ,jpg,png']);
                }
            }

            // $valid = $this->checkValid($request->ass_id);
            $valid = true;
            if($valid == true)
            {
                $answer = array();
                 $files = $request->file('answer');
                foreach($files as $file){

                    $rand = rand(10000,999999);
                    $imageName  = time().'_'.$rand.'.'.$file->getClientOriginalExtension();
                    $file_name       = 'assets/assignmants/answer/'.time().'_'.$rand.'.'.$file->getClientOriginalExtension();
                    $file->move('public/assets/assignmants/answer',$imageName);
                    $answer[] = $file_name;
                   
                }
                 if(count($answer) == 0)
                 {
                    return redirect()->back()->with(['error'=>'Uploaded failed.Try again']);
                 }
                $std_id     = $this->get_user();
                $std_info   = eyb_users::where('id',$std_id)->first();
                $inst_info  = InstituteStudent::where('user_id',$std_id)->first();

                $assignmentInfo = Assignment::where('id',$request->ass_id)->first();
                $assignment = new std_assignment_ans();
                $assignment->student_id      = $std_id; 
                $assignment->level_id        = $assignmentInfo->student_grade; 
                $assignment->assignment_id   = $request->ass_id;
                $assignment->assignment_time = ($assignmentInfo->exam_end-$assignmentInfo->exam_start)/60;
                $assignment->ans_time        = (time()-$assignmentInfo->exam_start)/60;
                $assignment->submitted_time  = time();
                $assignment->module_mark     = 0;
                $assignment->student_answer  = json_encode($answer);
                $assignment->save();

                return redirect()->route('tutor_assignment')->with(['success'=>'Successfully submitted your assgnment asnwer']);
            }
             return redirect()->route('tutor_assignment')->with(['error'=>'Not valid!']);
        }
        return redirect()->route('tutor_assignment')->with(['error'=>'Not valid!']);
    }

    public function checkValid($id)
    {
        $std_id     = $this->get_user();
        $std_info   = eyb_users::where('id',$std_id)->first();
        $inst_info  = InstituteStudent::where('user_id',$std_id)->first();
        $std_ass_ans = DB::table('std_assignment_ans')
                            ->select('assignment_id')
                            ->where('student_id',$std_id)
                            ->get();
        $json  = json_encode($std_ass_ans);
        $array = json_decode($json, true);
        $assignments_query = DB::table('assignments')
                            ->leftJoin('std_assignment_ans', 'assignments.id', '=', 'std_assignment_ans.assignment_id')
                            ->leftJoin('eyb_subjects', 'assignments.subjects', '=', 'eyb_subjects.id')
                            ->select('assignments.*','eyb_subjects.subject_name')
                            ->where('assignments.user_id',$inst_info['institute_id'])
                            ->where('assignments.exam_start','<=',time())
                            ->where('assignments.exam_end','>=',time())
                            ->where('assignments.exam_date','like','%'.date('Y-m-d').'%')
                            ->where('assignments.student_grade',$inst_info['level'])
                            ->where('assignments.id',$id);
                            if ($inst_info->semester != 0) {
                              $assignments_query->where('assignments.semester',$inst_info->semester);
                            }
                            if ($inst_info->section != 0) {
                              $assignments_query->where('assignments.section',$inst_info->section);
                            }
            if (!empty($std_ass_ans)) {
                $assignments_query->whereNotIn('assignments.id', array_column($array, 'assignment_id'));
            }
        $assignments_query->orderBy('assignments.id', 'asc');
        $result = $assignments_query->first();
        if (!empty($result)) {
           return true;
        }else
        {
            return false;
        }
    } 

    public function assignmentView($id)
    {
        $admin_id   = admin_id();
        if(session('super_status'))
        {
            $admin_id = 1;
        }
        $user_type  = admin_type();
        $assignment = Assignment::where('user_id',$admin_id)->where('user_type',$user_type)->where('id',$id)->first();

        if (!empty($assignment)) {
           
            $assignments = DB::table('assignments')
                        ->leftJoin('std_assignment_ans', 'assignments.id', '=', 'std_assignment_ans.assignment_id')
                        ->leftJoin('institute_students', 'std_assignment_ans.student_id', '=', 'institute_students.user_id')
                        ->leftJoin('eyb_subjects', 'assignments.subjects', '=', 'eyb_subjects.id')
                        ->leftJoin('sections', 'assignments.section', '=', 'sections.id')
                        ->leftJoin('semesters', 'assignments.semester', '=', 'semesters.id')
                        ->leftJoin('eyb_level', 'assignments.student_grade', '=', 'eyb_level.id')
                        ->select('institute_students.roll_no','std_assignment_ans.id as ans_id','assignments.id','assignments.title','eyb_subjects.subject_name','sections.name','semesters.semester_name','eyb_level.level_name')
                        ->where('assignments.id',$id)
                        ->get();


         return view('admin.assignments.assignment-report',['assignments'=>$assignments]);  
        }
        return redirect()->back();
        
    }
    public function stdAnswerReport($ass_id,$ans_id)
    {

        $admin_id   = admin_id();
        if(session('super_status'))
        {
            $admin_id = 1;
        }
        $user_type  = admin_type();
        $assignment = Assignment::where('user_id',$admin_id)->where('user_type',$user_type)->where('id',$ass_id)->first();
        if(!empty($assignment))
        {

            $answer = std_assignment_ans::where('assignment_id',$ass_id)->where('id',$ans_id)->first();
            if(!empty($answer))
            {
                $assignments = DB::table('assignments')
                        ->leftJoin('eyb_subjects', 'assignments.subjects', '=', 'eyb_subjects.id')
                        ->leftJoin('sections', 'assignments.section', '=', 'sections.id')
                        ->leftJoin('semesters', 'assignments.semester', '=', 'semesters.id')
                        ->leftJoin('eyb_level', 'assignments.student_grade', '=', 'eyb_level.id')
                        ->select('assignments.id','assignments.title','eyb_subjects.subject_name','sections.name','semesters.semester_name','eyb_level.level_name')
                        ->where('assignments.id',$ass_id)
                        ->first();
                $std_info  = InstituteStudent::where('user_id',$answer->student_id)->first();

                $data['assignment'] = $assignments; 
                $data['asnwer']     = $answer; 
                $data['std_info']   = $std_info; 
                return view('admin.assignments.std-answer',$data);
               
                
                // echo '<pre>';
                // print_r($data);
                // die;
            }
            return redirect()->back();
        }
        return redirect()->back();
        
    }
}
