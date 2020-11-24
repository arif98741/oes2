<?php

namespace App\Http\Controllers;

use App\eyb_subject;
use App\eyb_users;
use App\eyb_level;
use App\Section;
use App\Semester;
use Illuminate\Http\Request;
use DB;
use App\eyb_module;
use App\Institute;
use App\InstituteStudent;
use App\StudentBatch;
use Validator;
use Session;
class ModuleController extends Controller
{
    public function add_module()
    {
        $admin_id = admin_id();
        if(session('super_status'))
        {
            $admin_id = 1;
        }
        $data = array();
        $data['levels']         = $this->level();
        $data['module_types']   = $this->ModuleType();
        $data['question_types'] = $this->QuestionType();
        return view('admin.tutors.module.add-module',$data);
    }
    public function ManageModule()
    {
        $admin_id = admin_id();
        if(session('super_status'))
        {
            $admin_id = 1;
        }
        $data = array();
        $data['levels']         = $this->level();
        $data['module_types']   = $this->ModuleType();
        $data['question_types'] = $this->QuestionType();
        return view('admin.tutors.module.all-module',$data);
    }
    public function search_module(Request $request)
    {
        if (admin_type() == 2)
        {
            $required = array();

            $validator = Validator::make($request->all(), [

                'module_type'         => 'numeric',
                'student_grade'       => 'required|numeric',
                'subjects'            => 'required|numeric',
                'section'             => 'numeric',
                'semester'            => 'numeric',

            ]);
        }elseif(admin_type() == 5)
        {
            $validator = Validator::make($request->all(), [

                'module_type'         => 'numeric',
                'student_grade'       => 'required|numeric',
                'subjects'            => 'required|numeric',

            ]);
        }elseif(admin_type() == 4)
        {
            $validator = Validator::make($request->all(), [

                'module_type'         => 'numeric',
                'student_grade'       => 'required|numeric',
                'subjects'            => 'required|numeric',
                'section'             => 'numeric',

            ]);
        }elseif(admin_type() == 1)
        {
            $validator = Validator::make($request->all(), [

                'module_type'         => 'numeric',
                'student_grade'       => 'required|numeric',
                'subjects'            => 'required|numeric',

            ]);
        }

        if ($validator->passes()) {

            $condition = array();
            if ($request->module_type > 0 )
            {
                $condition['eyb_modules.module_type'] = $request->module_type;
            }
            if ($request->student_grade > 0 )
            {
                $condition['student_grade'] = $request->student_grade;
            }
            if ($request->subjects > 0 )
            {
                $condition['subject'] = $request->subjects;
            }
            if ($request->semester > 0 )
            {
                $condition['semester'] = $request->semester;
            }
            if ($request->section > 0 )
            {
                $condition['section'] = $request->section;

            }
            $user_id    = admin_id();
            if(session('super_status'))
            {
                $user_id = 1;
            }
            $user_type  = admin_type();
            $condition['eyb_modules.user_id'] = $user_id;

            $modules = DB::table('eyb_modules')
                        ->leftJoin('eyb_subjects', 'eyb_modules.subject', '=', 'eyb_subjects.id')
                        ->leftJoin('eyb_module_types', 'eyb_modules.module_type', '=', 'eyb_module_types.id')
                        ->leftJoin('sections', 'eyb_modules.section', '=', 'sections.id')
                        ->leftJoin('semesters', 'eyb_modules.semester', '=', 'semesters.id')
                        ->leftJoin('eyb_level', 'eyb_modules.student_grade', '=', 'eyb_level.id')
                        ->select('eyb_modules.id','eyb_modules.module_name','eyb_subjects.subject_name','eyb_module_types.module_type','sections.name','semesters.semester_name','eyb_level.level_name')
                        ->where($condition)
                        ->orderBy('id','DESC')
                        ->get();

            $count = count($modules);
            if ($count > 0)
            {
                $html = '';
                foreach($modules as $module)
                {
                    $html .= '<tr>';
                    $html .= '<td>'.$module->module_name.'</td>';
                    $html .= '<td>'.$module->module_type.'</td>';
                    $html .= '<td>'.$module->level_name.'</td>';
                    $html .= '<td>'.$module->subject_name.'</td>';
                    if(admin_type() == 2 || admin_type() == 1) {
                        $html .= '<td>' . $module->semester_name . '</td>';
                    }
                    if(admin_type() != 5) {
                        $html .= '<td>' . $module->name . '</td>';
                    }
                    $html .= '<td ><a class="btn btn-primary" href="'.route('edit_module',$module->id).'">Edit</a></td>';
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
    public function edit_module($id)
    {
        $admin_id = admin_id();
        if(session('super_status'))
        {
            $admin_id = 1;
        }
        $data = array();
        $data['levels']         = $this->level();
        $data['module_types']   = $this->ModuleType();
        $data['question_types'] = $this->QuestionType();
        $data['module']         = eyb_module::where('id',$id)->first();
        $data['semesters']      = Semester::where('level_id',$data['module']['student_grade'])->where('user_id',$admin_id)->get();
        $data['sections']       = Section::where('level_id',$data['module']['student_grade'])->where('user_id',$admin_id)->get();
        $data['subjects']       = eyb_subject::where('level_id',$data['module']['student_grade'])->where('user_id',$admin_id)->where('status',1)->get();
        $data['batches']       = StudentBatch::where('level_id',$data['module']['student_grade'])->where('user_id',$admin_id)->where('start_date','<=',date('Y-m-d'))->where('end_date','>=',date('Y-m-d'))->get();
        $questions = DB::table('eyb_questions')
                        ->where('student_grade',$data['module']['student_grade'])
                        ->where('subject',$data['module']['subject'])
                        ->where('user_id',$admin_id)
                        ->orderBy('id','ASC')
                        ->get();
        $question_types = DB::table('eyb_question_types')->where('status',1)->get();
        $q_types = array();
        foreach($question_types as $type)
            {
                $q_types[$type->id] = $type->type;
            }
        $data['questions'] = $questions;
        $data['q_types'] = $q_types;
        return view('admin.tutors.module.edit-module',$data);
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
        //         ->where('log',$get_session)
        //         ->first();
        // $user_id = $user->id;
        return session('user_id');
    }
    public function create_module()
    {
        $data = array();
        $admin_id = 1;
        
        $user_info = $this->student_info();
        $subjects = DB::table('eyb_subjects')->where('user_id',$admin_id)->where('level_id',$user_info->student_grade)->where('status',1)->get();
        $module_types = DB::table('eyb_module_types')->get();
        $data['subjects'] = $subjects;
        $data['module_types'] = $module_types;
        return view('front-end.module.create-module',$data);
    }
    public function GetStudentModuleQuestion($order)
    {
        $question_id = array();
        $questions = DB::table('eyb_questions')
            ->offset($order['start'])
            ->limit($order['limit'])
            ->select('id')
            ->where('subject',$order['subject'])
            ->orderBy('id', 'asc')
            ->get();
//            ->toSql();
        foreach ($questions as $key=>$question)
        {
            $question_id[$key] = $question->id;
        }
        return json_encode($question_id);
    }
    public function store_module(Request $request)
    {
        $rules = [
            'subject' => 'required|numeric',
            'max' => 'required|numeric|max:20|min:5',
            'module_type' => 'required|numeric',
        ];
        $customMessages = [
            'subject.required' => 'Please Provide Subject',
            'max.required' => 'Please Provide Maximum Question Number',
            'module_type.required' => 'Please Provide Module Type',
        ];
        $validator = $this->validate($request, $rules, $customMessages);

        $user_id = $this->get_user();
        $today_module = DB::table('eyb_modules')
                            ->select(DB::raw('count(id) as count'))
                            ->where('created_at','like','%'.date('Y-m-d').'%')
                            ->where('user_id',$user_id)
                            ->get();
        if ($today_module[0]->count >= 3) {
            return redirect()->back()->with('success_message', 'You have already created 5 modules today.Please Finished all modules and try again tomorrow.');
        }

        
        $subject_id = $request->subject;
        $count = DB::table('eyb_questions')
                    ->select(DB::raw('count(id) as count'))
                    ->where('subject',$subject_id)
                    ->get();
        $count = $count[0]->count;
        $smax  = $count-10;

        $rules = [
            'start' => 'required|numeric|max:'.$smax.'|min:1',
        ];
        $customMessages = [
            'start.required' => 'Please Provide Start Question Number!',
        ];
        $validator      = $this->validate($request, $rules, $customMessages);
        $user_id        = $this->get_user();
        $user           = DB::table('eyb_users')->where('id',$user_id)->get();
        $user_name      = $user[0]->name;
        $module_type    = DB::table('eyb_module_types')->where('id',$request->module_type)->get();
        $module_name    = $module_type[0]->module_type;
        $order = array();
        $order['start']     = $request->start;
        $order['limit']     = $request->max;
        $order['subject']   = $request->subject;
        $question_id        = $this->GetStudentModuleQuestion($order);
        
        $module = array();
        $module['module_name']      = $module_name.'-'.date('d-m-Y-h:i:sa');
        $module['creator_name']     = $user_name;
        $module['subject']          = $request->subject;
        $module['student_grade']    = $user[0]->student_grade;
        $module['module_type']      = $request->module_type;
        $module['user_id']          = $user_id;
        $module['user_type']        = $user[0]->user_type;
        $module['question_order']   = $question_id;
        $module['created_at']       = date("Y-m-d h:i:s");
        $module['updated_at']       = date("Y-m-d h:i:s");

        DB::table('eyb_modules')->insert($module);
        return redirect()->back()->with('success_message','You have successfully created a question paper!');
    }
    public function module()
    {
        $user_info = $this->student_info();
        $data = array();
        $module_types           = DB::table('eyb_module_types')->get();
        $levels                 = DB::table('eyb_level')->where('type',1)->get();
        $data['levels']         = $levels;
        $data['module_types']   = $module_types;
        $data['subjects'] = DB::table('eyb_subjects')->where('level_id',$user_info->student_grade)->where('status',1)->get();
        return view('front-end.module.module',$data);
    }
    public function get_module(Request $request)
    {
        $user_id = $this->get_user();
        if ($request->type != '')
        {
            $modules = DB::table('eyb_modules')
                            ->leftJoin('eyb_module_types', 'eyb_modules.module_type', '=', 'eyb_module_types.id')
                            ->leftJoin('eyb_subjects', 'eyb_modules.subject', '=', 'eyb_subjects.id')
                            ->select('eyb_modules.id','eyb_modules.question_order','eyb_modules.subject','eyb_modules.module_name','eyb_modules.module_name','eyb_subjects.subject_name','eyb_module_types.module_type')
                            ->where('eyb_modules.module_type', '=', $request->type)
                            ->where('eyb_modules.user_id', '=', $user_id)
                            ->where('eyb_modules.status', '=', 0)
                            ->get();
          $html =   $this->table_format_module($modules);
          echo $html;
        }

    }
    public function print($data)
    {
        echo '<pre>';
        print_r($data);
        die;

    }
    public function table_format_module($data)
    {
        $html = '';
        if (!empty($data))
        {
            $i = 1;
            foreach ($data as $value)
            {
                $order = json_decode($value->question_order);
                $url = route('student_exam',[$value->id,$order[0],1]);
                $html .='<tr>';
                $html .='<td><a href="'.$url.'">'.$i.'</a></td>';
                $html .='<td><a href="'.$url.'">'.$value->module_name.'</a></td>';
                $html .='<td><a href="'.$url.'">'.$value->subject_name.'</a></td>';
                $html .='<td><a href="'.$url.'">'.$value->module_type.'</a></td>';
                $html .='</tr>';
                $i++;
            }
        }
        if ($html == '')
        {
            $html .= '<tr><td></td><td></td><td></td><td>No Data Found</td></tr>';
        }
        return $html;
    }
    public function student_score()
    {
        $user_id        = $this->get_user();
        $module_answers = DB::table('eyb_student_answers')
                            ->leftJoin('eyb_modules', 'eyb_student_answers.module_id', '=', 'eyb_modules.id')
                            ->leftJoin('eyb_module_types', 'eyb_student_answers.module_type', '=', 'eyb_module_types.id')
                            ->select('eyb_modules.module_name','eyb_module_types.module_type','eyb_student_answers.module_mark','eyb_student_answers.student_mark','eyb_student_answers.student_answer','eyb_student_answers.id')
                            ->where('eyb_student_answers.student_id',$user_id)
                            ->where('eyb_modules.user_type',3)
                            ->orderBy('id','DESC')
                            ->get();

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
        $data['module_answers']     = $module_answers;
        $data['student_info']       = $student_info;
        $data['instraction_types']   = $instraction_type;
        return view('front-end.module.score-module',$data);
    }
    public function student_info()
    {
        $user_id = $this->get_user();
        $user_info = DB::table('eyb_users')
            ->where('id',$user_id)
            ->first();
        return $user_info;
    }
    public function exam_progress($progress_id)
    {
        $student_info = $this->student_info();
        $progress_info = DB::table('eyb_student_answers')
            ->leftJoin('eyb_modules', 'eyb_student_answers.module_id', '=', 'eyb_modules.id')
            ->leftJoin('eyb_module_types', 'eyb_student_answers.module_type', '=', 'eyb_module_types.id')
            ->select('eyb_modules.module_name','eyb_module_types.module_type','eyb_student_answers.module_mark','eyb_student_answers.student_mark','eyb_student_answers.student_answer','eyb_student_answers.id')
            ->where('eyb_student_answers.id',$progress_id)
            ->first();

        $ans = json_decode($progress_info->student_answer);
        $mark_array = array();
        $marks_array = array();
        $qus_mark = 0;
        $std_mark = 0;
        foreach ($ans as $key=>$item)
        {

            $mark_array[$key]['question_mark']=$item->student_question_marks;
            $mark_array[$key]['student_mark']=$item->student_marks;
            $mark_array[$key]['ans_is_right']=$item->ans_is_right;
            $mark_array[$key]['ans_is_right']=$item->ans_is_right;
            $marks_array[$key]['data'] = $mark_array;
            $qus_mark = $qus_mark+$item->student_question_marks;
            $marks_array[$key]['total'] = $qus_mark;
            $std_mark  =  $std_mark+$item->student_marks;
            $marks_array[$key]['obtain'] =$std_mark;

        }
        $data = array();
        $array = array();

        foreach ($ans as $key=>$an)
        {
            $question_info = array();
            $question = DB::table('eyb_questions')
                ->leftJoin('eyb_question_types', 'eyb_questions.question_type', '=', 'eyb_question_types.id')
                ->select('eyb_questions.*','eyb_question_types.type')
                ->where('eyb_questions.id',$an->question_id)
                ->first();
            $type = strtolower(str_replace(' ','_',$question->type));
            $question_info['question_type'] = $question->question_type;
            $question_info['question_name'] = $question->question_name;
            $question_info['question_description'] = $question->question_description;
            $question_info['mark'] = $question->mark;
            $question_info['answer'] = $question->answer;
            $question_info['student_ans'] = $an->student_ans;
            $question_info['student_marks'] = $an->student_marks;
            $question_info['ans_is_right'] = $an->ans_is_right;
            $question_info['type'] = $type;
            $question_html = $this->$type($question_info);
            $data[$key]['data'] = $question_info;
            $data[$key]['html'] = $question_html;
        }
        $array['student_info'] = $student_info;
        $array['progress'] = $progress_info;
        $array['data'] = $data;
        $array['marks_array'] = $marks_array;
        return view('front-end.exam.exam-progress',$array);
    }
    public function true_false($question_info)
    {
        $html = '';
        $student_ans = json_decode($question_info['student_ans']);
        $check = '';
        $check2 = '';
        if ($student_ans == 1)
        {
            $check = 'checked';
        }else{
            $check2 = 'checked';
        }
        $html .= '<div class="form-check">';
        $html .= '<input class="form-check-input answer"  '.$check.' type="radio" value="1" >';
        $html .= '<label class="form-check-label width-40"  for="true">True</label>';
        $html .= '</div>';
        $html .= '<div class="form-check">';
        $html .= '<input class="form-check-input answer"  '.$check2.' type="radio" value="0" >';
        $html .= '<label class="form-check-label width-40" for="false">False</label>';
        $html .= '</div>';
        return $html;
    }
    public function multiple_choice($question_info)
    {
        $html = '';
        $answers = json_decode($question_info['answer']);
        $crt_answer = $answers->answer;
        $answer_choice = $answers->answer_choice;
        $count = count($answer_choice);
        $lettry_array = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'k', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T');
        $j = 1;

        for($i = 0;$i<$count;$i++)
        {
            $check = '';
            if ($j == $crt_answer)
            {
                $check = 'checked';
            }
            $html .= '<div class="row " id="list_box_'.$j.';?>" style="align-items: center;margin-bottom: 10px;">';
            $html .= '<div class="col-2">';
            $html .= '<p style="text-align: center;background: #eee;width:25px;font-size: 24px;height: 100px;line-height: 100px;">'.$lettry_array[$i].'</p>';
            $html .= '</div>';
            $html .= '<div class="col-8">';
            $html .= '<div class="box">';
            $html .= '<textarea class="form-control" disabled rows="5" style="text-align: center;margin-top: 0px; margin-bottom: 0px; height: 143px;">'.$answer_choice[$i]->answer_choice.'</textarea>';
            $html .= '</div>';
            $html .= '</div>';
            $html .= '<div class="col-2">';
            $html .= '<p class="ss_lette" style="height: 100px;line-height: 100px;background:#eee;text-align: center; ">';
            $html .= '<input class="answer" '.$check.' type="radio" name="answer"  value="'.$j.'" style="text-align: center;font-size: 24px;">';
            $html .= '</p></div></div>';
           $j++;
        }

        return $html;
    }
    public function get_question_for_module(Request $request)
    {
        $result['error'] = false;
        $result['success'] = true;
        $user_id = admin_id();
        if(session('super_status'))
        {
            $user_id = 1;
        }
        $student_grade = $request->student_grade;
        $subject = $request->subject;
        $question_type = $request->question_type;
        if(($student_grade != '' && $student_grade != 'Select Level') && ($subject != '' && $subject != 'Select Subject'))
        {
            if ($question_type != '' && $question_type != 'Select Type')
            {
                $questions = DB::table('eyb_questions')
                    ->where('student_grade',$student_grade)
                    ->where('subject',$subject)
                    ->where('question_type',$question_type)
                    ->where('user_id',$user_id)
                    ->orderBy('id','ASC')
                    ->get();
            }else{
                $questions = DB::table('eyb_questions')
                    ->where('student_grade',$student_grade)
                    ->where('subject',$subject)
                    ->where('user_id',$user_id)
                    ->orderBy('id','ASC')
                    ->get();
            }
            $count = count($questions);
            if ($count > 0)
            {
                $html = '';

                $col = 4;
                if ($count >3)
                {
                    $col = 3;
                }
                $i =1;
                $question_types = DB::table('eyb_question_types')->where('status',1)->get();
                $q_types = array();
                foreach($question_types as $type)
                {
                    $q_types[$type->id] = $type->type;
                }
                
                foreach($questions as $key=>$question)
                {
                    $html .= '<div class="col-md-'.$col.'" style="margin-bottom: 10px;">';
                    $html .= '<table style=" border: 1px solid #283179;width:100%">';
                    $html .= '<thead><tr >';
                    $html .= '<label for="check_box_'.$question->id.'" style="background-color: #283179;border: none !important;color: #fff;padding: 6px 10px;font-size: 13px;width: 100%;margin: 0px;">'.$question->question_name.'</label>';
                    $html .= '</tr></thead><tbody><tr>';
                    $html .= '<td style="padding: 10px;">';
                    $html .= '<label class="form-check-label second_level" for="defaultCheck21" style="">';
                    $html .= '<input class="form-check-input1 module_question" type="checkbox" value="'.$question->id.'" name="moduleQuestion[]" id="check_box_'.$question->id.'">';
                    $html .= '<span> Q'.$i.'</span>';
                    $html .= '<i class="fa fa-info-circle single_question" data-toggle="modal" question-id="'.$question->id.'" data-target=".question-preview-modal" style="color:orange;margin-right: 5px;"></i>';
                    $html .= '<span>'.$q_types[$question->question_type].'</span>';
//                    $html .= '<a style="display:inline !important" href=""><i class="fa fa-edit"></i></a>';
//                    $html .= '<input type="number" min="1" style="width: 60px;" indexid0="0" autocomplete="off" class="questionOrder" disabled="disabled" value="" id="qOrdr">';
//                    $html .= '<input type="hidden" class="qId_order" id="qId_ordr" name="qId_ordr[]" value="">';
//                    $html .= '<input type="hidden" id="qId" class="qId" value="6144">';
                    $html .= '</label></td></tr></tbody></table></div>';
                    $i++;
                }
                $result['data'] = $html;
            }else{
                $result['error'] = true;
                $result['msg'] = 'No data found!';
            }
        }else{
            $result['error'] = true;
            $result['msg'] = 'Please Provide Valid Data';
        }
        echo json_encode($result);
//        die;
    }
    public function add_modal_data(Request $request)
    {
        
        if (admin_type() == 2)
        {
            $validator = Validator::make($request->all(), [

                'module_name'         => 'required|string|max:250',
                'module_type'         => 'required|numeric',
                'student_grade'       => 'required|numeric',
                'subjects'            => 'required|numeric',
                'section'             => 'required|numeric',
                'semester'            => 'required|numeric',
                'creator_name'        => 'required|string|max:100',
                'moduleQuestion'      => 'required',
                'sponsor'             => 'required',

            ]);
        }elseif(admin_type() == 5)
        {
            $validator = Validator::make($request->all(), [

                'module_name'         => 'required|string|max:250',
                'module_type'         => 'required|numeric',
                'student_grade'       => 'required|numeric',
                'subjects'            => 'required|numeric',
                'creator_name'        => 'required|string|max:100',
                'moduleQuestion'      => 'required',
                'batch'               => 'required|numeric',
                'sponsor'             => 'required',

            ]);
        }elseif(admin_type() == 4)
        {
            $validator = Validator::make($request->all(), [

                'module_name'         => 'required|string|max:250',
                'module_type'         => 'required|numeric',
                'student_grade'       => 'required|numeric',
                'subjects'            => 'required|numeric',
                'section'             => 'required|numeric',
                'creator_name'        => 'required|string|max:100',
                'moduleQuestion'      => 'required',
                'sponsor'             => 'required',

            ]);
        }elseif(admin_type() == 1)
        {
            $validator = Validator::make($request->all(), [

                'module_name'         => 'required|string|max:250',
                'module_type'         => 'required|numeric',
                'student_grade'       => 'required|numeric',
                'subjects'            => 'required|numeric',
                'creator_name'        => 'required|string|max:100',
                'moduleQuestion'      => 'required',
                'sponsor'             => 'required',

            ]);
        }


        if ($validator->passes()) {
            $user_id    = admin_id();
            if(session('super_status'))
            {
                $user_id = 1;
            }
            $user_type  = admin_type();
            $data = array();


           
            $data['module_name']    = $request->module_name;
            $data['module_type']    = $request->module_type;
            $data['student_grade']  = $request->student_grade;
            $data['subject']        = $request->subjects;
            $data['semester']       = isset($request->semester) ? $request->semester : 0;
            $data['section']        = isset($request->section) ? $request->section : 0;
            $data['batch']        = isset($request->batch) ? $request->batch : 0;
            $data['creator_name']   = $request->creator_name;
            $data['question_order'] = json_encode($request->moduleQuestion);
            $data['status']         = 0;
            $data['user_id']        = $user_id;
            $data['user_type']      = $user_type;
            if($request->exam_time != '')
            {
                $data['exam_date']      = date('Y-m-d',strtotime($request->exam_time));
                $data['exam_time']      = strtotime($request->exam_time);
            }else{

                $data['exam_date']      = date('Y-m-d');
                $data['exam_time']      = 0;
            }
            if($request->exam_duration != '' && $request->exam_time != '')
            {
                $exam_start = strtotime($request->exam_time);
                $exam_end   = $exam_start+($request->exam_duration*60);
                $data['exam_end']       = $exam_end;
            }else{
                
                $data['exam_end']       = 0;
            }
            if($request->exam_end_time)
            {
                $exam_end_time = strtotime($request->exam_end_time);
                $data['exam_end_time']       = $exam_end_time;
            }else{
                
                $data['exam_end_time']       = 0;
            }
            $data['negative_mark']      = $request->negative_mark;
            $data['ads_content']        = $request->sponsor;
            $data['created_at']         = date("Y-m-d h:i:s");
            $data['updated_at']         = date("Y-m-d h:i:s");
            
            $module_id =  DB::table('eyb_modules')->insertGetId($data);

            return response()->json(['success'=>$module_id]);
        }else{
            return response()->json(['error'=>$validator->errors()->all()]);
        }
    }
    public function add_modal_data_old(Request $request)
    {
        
        if (admin_type() == 2)
        {
            $validator = Validator::make($request->all(), [

                'module_name'         => 'required|string|max:250',
                'module_type'         => 'required|numeric',
                'student_grade'       => 'required|numeric',
                'subjects'            => 'required|numeric',
                'section'             => 'required|numeric',
                'semester'            => 'required|numeric',
                'creator_name'        => 'required|string|max:100',
                'moduleQuestion'      => 'required',
                'sponsor'             => 'required',

            ]);
        }elseif(admin_type() == 5)
        {
            $validator = Validator::make($request->all(), [

                'module_name'         => 'required|string|max:250',
                'module_type'         => 'required|numeric',
                'student_grade'       => 'required|numeric',
                'subjects'            => 'required|numeric',
                'creator_name'        => 'required|string|max:100',
                'moduleQuestion'      => 'required',
                'sponsor'             => 'required',

            ]);
        }elseif(admin_type() == 4)
        {
            $validator = Validator::make($request->all(), [

                'module_name'         => 'required|string|max:250',
                'module_type'         => 'required|numeric',
                'student_grade'       => 'required|numeric',
                'subjects'            => 'required|numeric',
                'section'             => 'required|numeric',
                'creator_name'        => 'required|string|max:100',
                'moduleQuestion'      => 'required',
                'sponsor'             => 'required',

            ]);
        }elseif(admin_type() == 1)
        {
            $validator = Validator::make($request->all(), [

                'module_name'         => 'required|string|max:250',
                'module_type'         => 'required|numeric',
                'student_grade'       => 'required|numeric',
                'subjects'            => 'required|numeric',
                'creator_name'        => 'required|string|max:100',
                'moduleQuestion'      => 'required',
                'sponsor'             => 'required',

            ]);
        }


        if ($validator->passes()) {
            $user_id    = admin_id();
            if(session('super_status'))
            {
                $user_id = 1;
            }
            $user_type  = admin_type();
            $data = array();


           
            $data['module_name']    = $request->module_name;
            $data['module_type']    = $request->module_type;
            $data['student_grade']  = $request->student_grade;
            $data['subject']        = $request->subjects;
            $data['semester']       = isset($request->semester) ? $request->semester : 0;
            $data['section']        = isset($request->section) ? $request->section : 0;
            $data['creator_name']   = $request->creator_name;
            $data['question_order'] = json_encode($request->moduleQuestion);
            $data['status']         = 0;
            $data['user_id']        = $user_id;
            $data['user_type']      = $user_type;
            if($request->exam_time != '')
            {
                $data['exam_date']      = date('Y-m-d',strtotime($request->exam_time));
                $data['exam_time']      = strtotime($request->exam_time);
            }else{

                $data['exam_date']      = date('Y-m-d');
                $data['exam_time']      = 0;
            }
            if($request->exam_duration != '' && $request->exam_time != '')
            {
                $exam_start = strtotime($request->exam_time);
                $exam_end   = $exam_start+($request->exam_duration*60);
                $data['exam_end']       = $exam_end;
            }else{
                
                $data['exam_end']       = 0;
            }
            $data['negative_mark']      = $request->negative_mark;
            $data['ads_content']        = $request->sponsor;
            $data['created_at']         = date("Y-m-d h:i:s");
            $data['updated_at']         = date("Y-m-d h:i:s");
            
            $module_id =  DB::table('eyb_modules')->insertGetId($data);

            return response()->json(['success'=>$module_id]);
        }else{
            return response()->json(['error'=>$validator->errors()->all()]);
        }
    }
    public function updateModuleData(Request $request)
    {
        if (admin_type() == 2)
        {
            $validator = Validator::make($request->all(), [

                'module_name'         => 'required|string|max:250',
                'module_type'         => 'required|numeric',
                'student_grade'       => 'required|numeric',
                'subjects'            => 'required|numeric',
                'section'             => 'required|numeric',
                'semester'            => 'required|numeric',
                'creator_name'        => 'required|string|max:100',
                'moduleQuestion'      => 'required',
                'sponsor'             => 'required',

            ]);
        }elseif(admin_type() == 5)
        {
            $validator = Validator::make($request->all(), [

                'module_name'         => 'required|string|max:250',
                'module_type'         => 'required|numeric',
                'student_grade'       => 'required|numeric',
                'subjects'            => 'required|numeric',
                'batch'               => 'required|numeric',
                'creator_name'        => 'required|string|max:100',
                'moduleQuestion'      => 'required',
                'sponsor'             => 'required',

            ]);
        }elseif(admin_type() == 4)
        {
            $validator = Validator::make($request->all(), [

                'module_name'         => 'required|string|max:250',
                'module_type'         => 'required|numeric',
                'student_grade'       => 'required|numeric',
                'subjects'            => 'required|numeric',
                'section'             => 'required|numeric',
                'creator_name'        => 'required|string|max:100',
                'moduleQuestion'      => 'required',
                'sponsor'             => 'required',

            ]);
        }elseif(admin_type() == 1)
        {
            $validator = Validator::make($request->all(), [

                'module_name'         => 'required|string|max:250',
                'module_type'         => 'required|numeric',
                'student_grade'       => 'required|numeric',
                'subjects'            => 'required|numeric',
                'creator_name'        => 'required|string|max:100',
                'moduleQuestion'      => 'required',
                'sponsor'             => 'required',

            ]);
        }
        if ($validator->passes()) {
            
            $exam_start = strtotime($request->exam_time);
            $exam_end = $exam_start+($request->exam_duration*60);

            $module = eyb_module::where('id',$request->module_id)->first();
            $module->module_name    = $request->module_name;
            $module->creator_name   = $request->creator_name;
            $module->subject        = $request->subjects;
            $module->semester       = isset($request->semester) ? $request->semester : 0;
            $module->section        = isset($request->section) ? $request->section : 0;
            $module->batch          = isset($request->batch) ? $request->batch : 0;
            $module->student_grade  = $request->student_grade;
            $module->module_type    = $request->module_type;
            $module->exam_date      = date('Y-m-d',strtotime($request->exam_time));
            $module->exam_time      = strtotime($request->exam_time);
            $module->exam_end       = $exam_end;
            $module->exam_end_time  = strtotime($request->exam_end_time);
            $module->question_order = json_encode($request->moduleQuestion);
            $module->negative_mark  = $request->negative_mark;
            $module->ads_content    = $request->sponsor;
            $module->update();
            return response()->json(['success'=>'Added new records.']);
        }else{
            return response()->json(['error'=>$validator->errors()->all()]);
        }
    }

    public function duplicate_module($id)
    {
        $user_id    = admin_id();
        if(session('super_status'))
        {
            $user_id = 1;
        }
        $module = eyb_module::where('id',$id)->where('user_id',$user_id)->first();
        if($module != false)
        {
            $duplicate_module = new eyb_module();
            $duplicate_module->module_name      = $module->module_name;
            $duplicate_module->creator_name     = $module->creator_name;
            $duplicate_module->subject          = $module->subject;
            $duplicate_module->semester         = $module->semester;
            $duplicate_module->section          = $module->section;
            $duplicate_module->country          = $module->country;
            $duplicate_module->student_grade    = $module->student_grade;
            $duplicate_module->module_type      = $module->module_type;
            $duplicate_module->user_id          = $module->user_id;
            $duplicate_module->user_type        = $module->user_type;
            $duplicate_module->exam_date        = $module->exam_date;
            $duplicate_module->exam_time        = $module->exam_time;
            $duplicate_module->exam_end_time    = $module->exam_end_time;
            $duplicate_module->exam_end         = $module->exam_end;
            $duplicate_module->question_order   = $module->question_order;
            $duplicate_module->batch            = $module->batch;
            $duplicate_module->status           = $module->status;
            $duplicate_module->negative_mark    = $module->negative_mark;
            $duplicate_module->ads_content      = $module->ads_content;
            $duplicate_module->save();

            return redirect()->route('edit_module',$duplicate_module->id)->with('success','Successfully duplicated a module');
        }
        return redirect()->route('edit_module',$id)->with('error','Module duplicate failed!');;
        
    }
    public function updateModuleData_old(Request $request)
    {
        if (admin_type() == 2)
        {
            $validator = Validator::make($request->all(), [

                'module_name'         => 'required|string|max:250',
                'module_type'         => 'required|numeric',
                'student_grade'       => 'required|numeric',
                'subjects'            => 'required|numeric',
                'section'             => 'required|numeric',
                'semester'            => 'required|numeric',
                'creator_name'        => 'required|string|max:100',
                'moduleQuestion'      => 'required',
                'sponsor'             => 'required',

            ]);
        }elseif(admin_type() == 5)
        {
            $validator = Validator::make($request->all(), [

                'module_name'         => 'required|string|max:250',
                'module_type'         => 'required|numeric',
                'student_grade'       => 'required|numeric',
                'subjects'            => 'required|numeric',
                'creator_name'        => 'required|string|max:100',
                'moduleQuestion'      => 'required',
                'sponsor'             => 'required',

            ]);
        }elseif(admin_type() == 4)
        {
            $validator = Validator::make($request->all(), [

                'module_name'         => 'required|string|max:250',
                'module_type'         => 'required|numeric',
                'student_grade'       => 'required|numeric',
                'subjects'            => 'required|numeric',
                'section'             => 'required|numeric',
                'creator_name'        => 'required|string|max:100',
                'moduleQuestion'      => 'required',
                'sponsor'             => 'required',

            ]);
        }elseif(admin_type() == 1)
        {
            $validator = Validator::make($request->all(), [

                'module_name'         => 'required|string|max:250',
                'module_type'         => 'required|numeric',
                'student_grade'       => 'required|numeric',
                'subjects'            => 'required|numeric',
                'creator_name'        => 'required|string|max:100',
                'moduleQuestion'      => 'required',
                'sponsor'             => 'required',

            ]);
        }
        if ($validator->passes()) {
            
            $exam_start = strtotime($request->exam_time);
            $exam_end = $exam_start+($request->exam_duration*60);

            $module = eyb_module::where('id',$request->module_id)->first();
            $module->module_name    = $request->module_name;
            $module->creator_name   = $request->creator_name;
            $module->subject        = $request->subjects;
            $module->semester       = isset($request->semester) ? $request->semester : 0;
            $module->section        = isset($request->section) ? $request->section : 0;
            $module->student_grade  = $request->student_grade;
            $module->module_type    = $request->module_type;
            $module->exam_date      = date('Y-m-d',strtotime($request->exam_time));
            $module->exam_time      = strtotime($request->exam_time);
            $module->exam_end       = $exam_end;
            $module->question_order = json_encode($request->moduleQuestion);
            $module->negative_mark  = $request->negative_mark;
            $module->ads_content    = $request->sponsor;
            $module->update();
            return response()->json(['success'=>'Added new records.']);
        }else{
            return response()->json(['error'=>$validator->errors()->all()]);
        }
    }
    public function single_question_info(Request $request)
    {
        $user_id = admin_id();
        $id = $request->question_id;
        $question = DB::table('eyb_questions')
            ->where('id',$id)
            ->where('user_id',$user_id)
            ->get();
        if (!empty($question))
        {
            $data['question'] = $question[0];
            if($question[0]->question_type == 1)
            {
                $view =  view('admin.tutors.module-question-view.true-false',$data);
                $result = array();
                $result['view'] = $view->render();
                echo json_encode($result);
            }
            if($question[0]->question_type == 2)
            {
                $view =  view('admin.tutors.module-question-view.multiple-choice',$data);
                $result = array();
                $result['view'] = $view->render();
                echo json_encode($result);
            }
        }
    }
    public function tutor_module()
    {

        $std_id     = $this->get_user();
        $std_info   = eyb_users::where('id',$std_id)->first();
        $inst_info  = InstituteStudent::where('user_id',$std_id)->first();
        
        $std_module = DB::table('eyb_student_answers')
                            ->select('module_id')
                            ->where('student_id',$std_id)
                            ->get();
        $json  = json_encode($std_module);
        $array = json_decode($json, true);
        $data = array();
        //DB::enableQueryLog();
        $modules_query = DB::table('eyb_modules')
                            ->leftJoin('eyb_module_types', 'eyb_modules.module_type', '=', 'eyb_module_types.id')
                            ->leftJoin('eyb_subjects', 'eyb_modules.subject', '=', 'eyb_subjects.id')
                            ->select('eyb_modules.*','eyb_module_types.module_type','eyb_subjects.subject_name')
                            ->where('eyb_modules.user_id',$inst_info['institute_id'])
                            ->where('eyb_modules.exam_time','<=',time())
                            ->where('eyb_modules.exam_end','>=',time())
                            ->where('eyb_modules.exam_date','like','%'.date('Y-m-d').'%')
                            ->where('eyb_modules.student_grade',$inst_info['level']);
                            if ($inst_info->semester != 0) {
                              $modules_query->where('eyb_modules.semester',$inst_info->semester);
                            }
                            if ($inst_info->section != 0) {
                              $modules_query->where('eyb_modules.section',$inst_info->section);
                            }
            if (!empty($std_module)) {
                $modules_query->whereNotIn('eyb_modules.id', array_column($array, 'module_id'));
            }
        $modules_query->orderBy('eyb_modules.id', 'asc');
        $result = $modules_query->get();
        //$query = DB::getQueryLog();
        
        $data['modules'] = $result;
        return view('front-end.module.tutor-module',$data);
    }

    public function searchUserModule(Request $request)
    {
        
        $validator = Validator::make($request->all(), [

                'level'         => 'required|numeric',
            ]);
        if ($validator->passes()) {
            if($request->level != '' && $request->subject == '')
            {
                $subjects = eyb_subject::where('level_id',$request->level)->where('status',1)->get();
                $html = '<option value="">Select Subject</option>';
                foreach($subjects as $subject)
                {
                    $html .= '<option value="'.$subject->id.'">'.$subject->subject_name.'</option>';
                }
                return response()->json(['success'=>$html]);
            }
        }else{

            return response()->json(['error'=>$validator->errors()->all()]);
        }
        if($request->subject != '')
        {
            $validator = Validator::make($request->all(), [

                'subject'         => 'required|numeric',
                'exam_type'       => 'required|numeric',
            ]);
        }
        if ($validator->passes()) {

            $user_id = $this->student_info();
            $subject_id = $request->subject;
            $subject = eyb_subject::where('id',$subject_id)->first();
            $user_type = eyb_users::where('id',$subject->user_id)->first();
            $modules = array();
            if($user_type->user_type == 2)
            {
                $inst_info  = InstituteStudent::where('user_id',$user_id->id)->first();
                
                $modules = DB::table('eyb_modules')
                            ->leftJoin('eyb_subjects', 'eyb_modules.subject', '=', 'eyb_subjects.id')
                            ->select('eyb_modules.*','eyb_subjects.subject_name')
                            ->where('eyb_modules.subject',$subject_id)
                            ->where('eyb_modules.student_grade',$inst_info->level)
                            ->where('eyb_modules.semester',$inst_info->semester)
                            ->where('eyb_modules.section',$inst_info->section)
                            ->where('eyb_modules.user_id',$inst_info->institute_id)
                            ->where('eyb_modules.module_type',1)
                            ->orderBy('id','DESC')
                            ->get();  
            }elseif($user_type->user_type == 4)
            {
                $inst_info  = InstituteStudent::where('user_id',$user_id->id)->first();
                
                $modules = DB::table('eyb_modules')
                            ->leftJoin('eyb_subjects', 'eyb_modules.subject', '=', 'eyb_subjects.id')
                            ->select('eyb_modules.*','eyb_subjects.subject_name')
                            ->where('eyb_modules.subject',$subject_id)
                            ->where('eyb_modules.student_grade',$inst_info->level)
                            ->where('eyb_modules.section',$inst_info->section)
                            ->where('eyb_modules.user_id',$inst_info->institute_id)
                            ->where('eyb_modules.module_type',1)
                            ->orderBy('id','DESC')
                            ->get();
            }elseif($user_type->user_type == 5)
            {
                $inst_info  = InstituteStudent::where('user_id',$user_id->id)->first();
                
                $modules = DB::table('eyb_modules')
                            ->leftJoin('eyb_subjects', 'eyb_modules.subject', '=', 'eyb_subjects.id')
                            ->select('eyb_modules.*','eyb_subjects.subject_name')
                            ->where('eyb_modules.subject',$subject_id)
                            ->where('eyb_modules.student_grade',$inst_info->level)
                            ->where('eyb_modules.user_id',$inst_info->institute_id)
                            ->where('eyb_modules.module_type',1)
                            ->orderBy('id','DESC')
                            ->get();
            }else{

                if($request->exam_type == 2)
                {
                    $std_id     = $this->get_user();
                    $std_info   = eyb_users::where('id',$std_id)->first();
                    $std_module = DB::table('eyb_student_answers')
                                        ->select('module_id')
                                        ->where('student_id',$std_id)
                                        ->where('module_type',2)
                                        ->get();
                    $json  = json_encode($std_module);
                    $array = json_decode($json, true);
                    $data = array();
                    $modules_query = DB::table('eyb_modules')
                            ->leftJoin('eyb_subjects', 'eyb_modules.subject', '=', 'eyb_subjects.id')
                            ->select('eyb_modules.*','eyb_subjects.subject_name')
                            ->where('eyb_modules.subject',$subject_id)
                            ->where('eyb_modules.user_type',1)
                            ->where('eyb_modules.exam_time','<=',time())
                            ->where('eyb_modules.exam_end','>=',time())
                            ->where('eyb_modules.exam_date','like','%'.date('Y-m-d').'%')
                            ->where('eyb_modules.module_type',$request->exam_type);
                            if (!empty($std_module)) {
                    $modules_query->whereNotIn('eyb_modules.id', array_column($array, 'module_id'));
                }
                $modules_query->orderBy('eyb_modules.id','DESC');
                $modules = $modules_query->get();
                }else{
                    $modules = DB::table('eyb_modules')
                            ->leftJoin('eyb_subjects', 'eyb_modules.subject', '=', 'eyb_subjects.id')
                            ->select('eyb_modules.*','eyb_subjects.subject_name')
                            ->where('eyb_modules.subject',$subject_id)
                            ->where('eyb_modules.user_type',1)
                            ->where('eyb_modules.module_type',$request->exam_type)
                            ->orderBy('id','DESC')
                            ->get();
                }  
            }
            
            $html = '';
            if(count($modules) > 0)
            {
                $i = 1;
                foreach($modules as $module)
                {
                    
                    $order = json_decode($module->question_order);
                    $url   = route('student_examination',[$module->id]);

                    $html .= '<tr>';
                    $html .= '<td>'.$i.'</td>';
                    $html .= '<td>'.$module->module_name.'</td>';
                    $html .= '<td>'.$module->subject_name.'</td>';
                    $html .= '<td><a href="'.$url.'" class="btn btn-primary btn-sm">Start</a></td>';
                    $html .= '</tr>';
                  $i++;
                }
            }else{
                $html .= 'No module found!';
            }
             return response()->json(['success'=>$html]);
        }else{

            return response()->json(['error'=>$validator->errors()->all()]);
        }
       
    }
    public function search_practice_module_list(Request $request)
    {
        $user_id    = user_id();
        $institutes = InstituteStudent::where('user_id',$user_id)->where('status',1)->get();
        // 
        $std_module = DB::table('eyb_student_answers')
                            ->select('module_id')
                            ->where('student_id',$user_id)
                            ->where('module_type',1)
                            ->get();
        
        $json  = json_encode($std_module);
        $array = json_decode($json, true);
        $total_rows = 0;
        $total_modules = array();
        $index = 0;
        $draw   = $request->draw;
        $start  = $request->start;
        $length = $request->length;
        foreach($institutes as $inst_info)
        {
            $condition = array();
            $condition['eyb_modules.module_type']  = 1;
            $condition['eyb_modules.user_id']      = $inst_info->institute_id;
            if($inst_info->institute_type == 2)
            {
                 $condition['eyb_modules.student_grade']    = $inst_info->level;
                 $condition['eyb_modules.semester']         = $inst_info->semester;
                 $condition['eyb_modules.section']          = $inst_info->section;
            }elseif($inst_info->institute_type == 4)
            {
                $condition['eyb_modules.student_grade']    = $inst_info->level;
                $condition['eyb_modules.section']          = $inst_info->section;                    
            }elseif($inst_info->institute_type == 5)
            {
                $condition['eyb_modules.student_grade']    = $inst_info->level;
                $condition['eyb_modules.batch']            = $inst_info->batch; 
                                
            }else{

                $condition['eyb_modules.user_type']            = 1;             
            }
            
            $total_rows += DB::table('eyb_modules')->where($condition)->count();
            if (isset($request->search['value']))
            {
                $modules =  DB::table('eyb_modules')
                                ->leftJoin('eyb_subjects', 'eyb_modules.subject', '=', 'eyb_subjects.id')
                                ->select('eyb_modules.*','eyb_subjects.subject_name')
                                ->where($condition)
                                ->Where('module_name','like', '%'.$request->search['value'].'%')
                                ->skip($start)
                                ->take($length)
                                ->orderBy('eyb_modules.id', 'DESC')
                                ->get();
                $total_rows = DB::table('eyb_modules')
                                ->where($condition)
                                ->Where('module_name','like', '%'.$request->search['value'].'%')
                                ->count();
            }else
            {
               $modules =  DB::table('eyb_modules')
                                ->leftJoin('eyb_subjects', 'eyb_modules.subject', '=', 'eyb_subjects.id')
                                ->select('eyb_modules.*','eyb_subjects.subject_name')
                                ->where($condition)
                                ->skip($start)
                                ->take($length)
                                ->orderBy('eyb_modules.id', 'DESC')
                                ->get();   
            }
            foreach($modules as $mo)
            {
                $total_modules[$index] = $mo;
                $index++;
            }
        }
        
        $data = array();
        $data['draw'] = $draw;
        $data['recordsTotal'] = $total_rows;
        $data['recordsFiltered'] = $total_rows;
        $data['data'] = array();
        $i = 1;
        $o = 0;
        foreach($total_modules as $key=>$module)
        {
            $institute_user  = eyb_users::where('id',$module->user_id)->first();
            $html = '';
            $url   = route('student_examination',[$module->id]);
            $html .= '<a href="'.$url.'" class="btn btn-primary btn-sm">Start</a>';
            $data['data'][$o][] = $i;
            $data['data'][$o][] = $html;
            $data['data'][$o][] = $module->module_name;
            $data['data'][$o][] = $institute_user->name;
            $i++;
            $o++;
        }
        echo json_encode($data);   
    }
    public function search_exam_module_list(Request $request)
    {
        $user_id    = user_id();
        $institutes = InstituteStudent::where('user_id',$user_id)->where('status',1)->get();
        
        
        // 
        $std_module = DB::table('eyb_student_answers')
                            ->select('module_id')
                            ->where('student_id',$user_id)
                            ->where('module_type',2)
                            ->get();
        $json  = json_encode($std_module);
        $array = json_decode($json, true);
        $draw   = $request->draw;
        $start  = $request->start;
        $length = $request->length;
        $total_rows = 0;
        $total_modules = array();
        $index = 0;
        foreach($institutes as $inst_info)
        {
            $condition = array();
            $condition['eyb_modules.module_type']  = 2;
            $condition['eyb_modules.user_id']      = $inst_info->institute_id;
            if($inst_info->institute_type == 2)
            {
                 $condition['eyb_modules.student_grade']    = $inst_info->level;
                 $condition['eyb_modules.semester']         = $inst_info->semester;
                 $condition['eyb_modules.section']          = $inst_info->section;
            }elseif($inst_info->institute_type == 4)
            {
                $condition['eyb_modules.student_grade']    = $inst_info->level;
                $condition['eyb_modules.section']          = $inst_info->section;                    
            }elseif($inst_info->institute_type == 5)
            {
                $condition['eyb_modules.student_grade']    = $inst_info->level;
                $condition['eyb_modules.batch']            = $inst_info->batch; 
                                
            }else{

                $condition['eyb_modules.user_type']            = 1;             
            }
            
        
            $total_rows += DB::table('eyb_modules')->where($condition)->where('eyb_modules.exam_time','<=',time())->where('eyb_modules.exam_end_time','>=',time())->where('eyb_modules.exam_date','like','%'.date('Y-m-d').'%')->count();
            if (isset($request->search['value']))
            {
                $modules =  DB::table('eyb_modules')
                                ->leftJoin('eyb_subjects', 'eyb_modules.subject', '=', 'eyb_subjects.id')
                                ->select('eyb_modules.*','eyb_subjects.subject_name')
                                ->where($condition)
                                ->where('eyb_modules.exam_time','<=',time())
                                ->where('eyb_modules.exam_end_time','>=',time())
                                ->where('eyb_modules.exam_date','like','%'.date('Y-m-d').'%')
                                ->Where('module_name','like', '%'.$request->search['value'].'%')
                                ->whereNotIn('eyb_modules.id', array_column($array, 'module_id'))
                                ->skip($start)
                                ->take($length)
                                ->orderBy('eyb_modules.id', 'DESC')
                                ->get();
                $total_rows += DB::table('eyb_modules')
                                ->where($condition)
                                ->where('eyb_modules.exam_time','<=',time())
                                ->where('eyb_modules.exam_end_time','>=',time())
                                ->where('eyb_modules.exam_date','like','%'.date('Y-m-d').'%')
                                ->Where('module_name','like', '%'.$request->search['value'].'%')
                                ->whereNotIn('eyb_modules.id', array_column($array, 'module_id'))
                                ->count();
            }else
            {
               $modules =  DB::table('eyb_modules')
                                ->leftJoin('eyb_subjects', 'eyb_modules.subject', '=', 'eyb_subjects.id')
                                ->select('eyb_modules.*','eyb_subjects.subject_name')
                                ->where($condition)
                                ->where('eyb_modules.exam_time','<=',time())
                                ->where('eyb_modules.exam_end_time','>=',time())
                                ->where('eyb_modules.exam_date','like','%'.date('Y-m-d').'%')
                                ->whereNotIn('eyb_modules.id', array_column($array, 'module_id'))
                                ->skip($start)
                                ->take($length)
                                ->orderBy('eyb_modules.id', 'DESC')
                                ->get();   
            }
            foreach($modules as $mo)
            {
                $total_modules[$index] = $mo;
                $index++;
            }
            
            
        }
        $data = array();
        $data['draw'] = $draw;
        $data['recordsTotal'] = $total_rows;
        $data['recordsFiltered'] = $total_rows;
        $data['data'] = array();
        $i = 1;
        $o = 0;
        foreach($total_modules as $key=>$module)
        {
            $institute_user  = eyb_users::where('id',$module->user_id)->first();
            $exam_time_second = $module->exam_end - $module->exam_time;
            $exam_time = $exam_time_second/60;
            $html = '';
            $url   = route('student_examination',[$module->id]);
            $html .= '<a href="'.$url.'" class="btn btn-primary btn-sm">Start</a>';
            $data['data'][$o][] = $i;
            $data['data'][$o][] = $html;
            $data['data'][$o][] = $module->module_name;
            $data['data'][$o][] = date('Y-m-d h:i:s A',$module->exam_time);
            $data['data'][$o][] = date('Y-m-d h:i:s A',$module->exam_end_time);
            $data['data'][$o][] = $exam_time.' Minutes';
            $data['data'][$o][] = $institute_user->name;
            $i++;
            $o++;
        }
        echo json_encode($data);
    }
    public function search_practice_module_list_old(Request $request)
    {
        $user_id    = user_id();
        $inst_info = InstituteStudent::where('user_id',$user_id)->first();
        $user_type  = eyb_users::where('id',$inst_info->institute_id)->first();
        $std_module = DB::table('eyb_student_answers')
                            ->select('module_id')
                            ->where('student_id',$user_id)
                            ->where('module_type',1)
                            ->get();
        $json  = json_encode($std_module);
        $array = json_decode($json, true);
        $condition = array();
        $condition['eyb_modules.module_type']  = 1;
        $condition['eyb_modules.user_id']      = $inst_info->institute_id;
        if($user_type->user_type == 2)
        {
             $condition['eyb_modules.student_grade']    = $inst_info->level;
             $condition['eyb_modules.semester']         = $inst_info->semester;
             $condition['eyb_modules.section']          = $inst_info->section;
        }elseif($user_type->user_type == 4)
        {
            $condition['eyb_modules.student_grade']    = $inst_info->level;
            $condition['eyb_modules.section']          = $inst_info->section;                    
        }elseif($user_type->user_type == 5)
        {
            $condition['eyb_modules.student_grade']    = $inst_info->level;
            $condition['eyb_modules.batch']            = $inst_info->batch; 
                            
        }else{

            $condition['eyb_modules.user_type']            = 1;             
        }
        $draw   = $request->draw;
        $start  = $request->start;
        $length = $request->length;
        $total_rows = DB::table('eyb_modules')->where($condition)->count();
        if (isset($request->search['value']))
        {
            $modules =  DB::table('eyb_modules')
                            ->leftJoin('eyb_subjects', 'eyb_modules.subject', '=', 'eyb_subjects.id')
                            ->select('eyb_modules.*','eyb_subjects.subject_name')
                            ->where($condition)
                            ->Where('module_name','like', '%'.$request->search['value'].'%')
                            ->skip($start)
                            ->take($length)
                            ->orderBy('eyb_modules.id', 'DESC')
                            ->get();
            $total_rows = DB::table('eyb_modules')
                            ->where($condition)
                            ->Where('module_name','like', '%'.$request->search['value'].'%')
                            ->count();
        }else
        {
           $modules =  DB::table('eyb_modules')
                            ->leftJoin('eyb_subjects', 'eyb_modules.subject', '=', 'eyb_subjects.id')
                            ->select('eyb_modules.*','eyb_subjects.subject_name')
                            ->where($condition)
                            ->skip($start)
                            ->take($length)
                            ->orderBy('eyb_modules.id', 'DESC')
                            ->get();   
        }
        
        $data = array();
        $data['draw'] = $draw;
        $data['recordsTotal'] = $total_rows;
        $data['recordsFiltered'] = $total_rows;
        $data['data'] = array();
        $i = 1;
        $o = 0;
        foreach($modules as $key=>$module)
        {
            $html = '';
            $url   = route('student_examination',[$module->id]);
            $html .= '<a href="'.$url.'" class="btn btn-primary btn-sm">Start</a>';
            $data['data'][$o][] = $i;
            $data['data'][$o][] = $html;
            $data['data'][$o][] = $module->module_name;
            
            $i++;
            $o++;
        }
        echo json_encode($data);   
    }
    public function search_exam_module_list_old(Request $request)
    {
        $user_id    = user_id();
        $inst_info = InstituteStudent::where('user_id',$user_id)->first();
        $user_type  = eyb_users::where('id',$inst_info->institute_id)->first();
        $std_module = DB::table('eyb_student_answers')
                            ->select('module_id')
                            ->where('student_id',$user_id)
                            ->where('module_type',2)
                            ->get();
        $json  = json_encode($std_module);
        $array = json_decode($json, true);
        $condition = array();
        $condition['eyb_modules.module_type']  = 2;
        $condition['eyb_modules.user_id']      = $inst_info->institute_id;
        if($user_type->user_type == 2)
        {
             $condition['eyb_modules.student_grade']    = $inst_info->level;
             $condition['eyb_modules.semester']         = $inst_info->semester;
             $condition['eyb_modules.section']          = $inst_info->section;
        }elseif($user_type->user_type == 4)
        {
            $condition['eyb_modules.student_grade']    = $inst_info->level;
            $condition['eyb_modules.section']          = $inst_info->section;                    
        }elseif($user_type->user_type == 5)
        {
            $condition['eyb_modules.student_grade']    = $inst_info->level;
            $condition['eyb_modules.batch']            = $inst_info->batch; 
                            
        }else{

            $condition['eyb_modules.user_type']            = 1;             
        }

                            
                            
        $draw   = $request->draw;
        $start  = $request->start;
        $length = $request->length;
        $total_rows = DB::table('eyb_modules')->where($condition)->where('eyb_modules.exam_time','<=',time())->where('eyb_modules.exam_end_time','>=',time())->where('eyb_modules.exam_date','like','%'.date('Y-m-d').'%')->count();
        
        if (isset($request->search['value']))
        {
            $modules =  DB::table('eyb_modules')
                            ->leftJoin('eyb_subjects', 'eyb_modules.subject', '=', 'eyb_subjects.id')
                            ->select('eyb_modules.*','eyb_subjects.subject_name')
                            ->where($condition)
                            ->where('eyb_modules.exam_time','<=',time())
                            ->where('eyb_modules.exam_end_time','>=',time())
                            ->where('eyb_modules.exam_date','like','%'.date('Y-m-d').'%')
                            ->Where('module_name','like', '%'.$request->search['value'].'%')
                            ->whereNotIn('eyb_modules.id', array_column($array, 'module_id'))
                            ->skip($start)
                            ->take($length)
                            ->orderBy('eyb_modules.id', 'DESC')
                            ->get();
            $total_rows = DB::table('eyb_modules')
                            ->where($condition)
                            ->where('eyb_modules.exam_time','<=',time())
                            ->where('eyb_modules.exam_end_time','>=',time())
                            ->where('eyb_modules.exam_date','like','%'.date('Y-m-d').'%')
                            ->Where('module_name','like', '%'.$request->search['value'].'%')
                            ->whereNotIn('eyb_modules.id', array_column($array, 'module_id'))
                            ->count();
        }else
        {
           $modules =  DB::table('eyb_modules')
                            ->leftJoin('eyb_subjects', 'eyb_modules.subject', '=', 'eyb_subjects.id')
                            ->select('eyb_modules.*','eyb_subjects.subject_name')
                            ->where($condition)
                            ->where('eyb_modules.exam_time','<=',time())
                            ->where('eyb_modules.exam_end_time','>=',time())
                            ->where('eyb_modules.exam_date','like','%'.date('Y-m-d').'%')
                            ->whereNotIn('eyb_modules.id', array_column($array, 'module_id'))
                            ->skip($start)
                            ->take($length)
                            ->orderBy('eyb_modules.id', 'DESC')
                            ->get();   
        }
        
        $data = array();
        $data['draw'] = $draw;
        $data['recordsTotal'] = $total_rows;
        $data['recordsFiltered'] = $total_rows;
        $data['data'] = array();
        $i = 1;
        $o = 0;
        foreach($modules as $key=>$module)
        {
            $exam_time_second = $module->exam_end - $module->exam_time;
            $exam_time = $exam_time_second/60;
            $html = '';
            $url   = route('student_examination',[$module->id]);
            $html .= '<a href="'.$url.'" class="btn btn-primary btn-sm">Start</a>';
            $data['data'][$o][] = $i;
            $data['data'][$o][] = $html;
            $data['data'][$o][] = $module->module_name;
            $data['data'][$o][] = date('Y-m-d h:i:s A',$module->exam_time);
            $data['data'][$o][] = date('Y-m-d h:i:s A',$module->exam_end_time);
            $data['data'][$o][] = $exam_time.' Minutes';
            $i++;
            $o++;
        }
        echo json_encode($data);
    }
    public function practice_module()
    {
        $user_id        = $this->student_info();
        $inst_info     = InstituteStudent::where('user_id',$user_id->id)->first();
        $data['batch']  = StudentBatch::where('id',$inst_info->batch)->where('level_id',$inst_info->level)->where('user_id',$inst_info->institute_id)->where('start_date','<=',date('Y-m-d'))->where('end_date','>=',date('Y-m-d'))->first();
        $data['subjects']       = eyb_subject::where('level_id',$inst_info->level)->where('user_id',$inst_info->institute_id)->where('status',1)->get();
        $data['institute'] = eyb_users::where('id',$inst_info->institute_id)->first();

        return view('front-end.module.tutor-practice-module',$data);
    }
    public function search_level_by_inst(Request $request)
    {
        $validator = Validator::make($request->all(), [

                'institute_type'         => 'required|numeric',
            ]);

        if ($validator->passes()) {

            $user_id = $this->student_info();
            $inst_info  = InstituteStudent::where('user_id',$user_id->id)->first();
            
            $html = '<option value="">Select Level</option>';
            if($request->institute_type == 1)
            {
                $levels = DB::table('eyb_level')->where('user_id',1)->get();
            }else{

                $levels = DB::table('eyb_level')->where('user_id',$inst_info->institute_id)->get();
            }
            if(!empty($levels))
            {
                foreach($levels  as $level)
                {
                    $html .= '<option value="'.$level->id.'">'.$level->level_name.'</option>';
                    
                }
            }
            
            return response()->json(['success'=>$html]);
        }else{

            return response()->json(['error'=>$validator->errors()->all()]);
        }
    }
    public function search_subject_by_level(Request $request)
    {
        $validator = Validator::make($request->all(), [

                'level'         => 'required|numeric',
            ]);

        if ($validator->passes()) {
            
            $html = '<option value="">Select Subject</option>';
            $subjects = eyb_subject::where('level_id',$request->level)->where('status',1)->get();
            if(!empty($subjects))
            {
                foreach($subjects  as $subject)
                {
                    $html .= '<option value="'.$subject->id.'">'.$subject->subject_name.'</option>';
                    
                }
            }
            
            return response()->json(['success'=>$html]);
        }else{

            return response()->json(['error'=>$validator->errors()->all()]);
        }
    }
    public function search_subject_by_inst(Request $request)
    {
        $validator = Validator::make($request->all(), [

                'institute_type'         => 'required|numeric',
            ]);

        if ($validator->passes()) {

            $user_id = $this->student_info();
            $inst_info  = InstituteStudent::where('user_id',$user_id->id)->first();
            $html = '<option value="">Select Subject</option>';
            if($request->institute_type == 1)
            {
                $subjects = eyb_subject::where('level_id',$user_id->student_grade)->where('user_id',1)->where('status',1)->get();
            }else{

                $subjects = eyb_subject::where('level_id',$inst_info->level)->where('user_id',$inst_info->institute_id)->where('status',1)->get();
            }
            if(!empty($subjects))
            {
                foreach($subjects  as $subject)
                {
                    $html .= '<option value="'.$subject->id.'">'.$subject->subject_name.'</option>';
                    
                }
            }
            
            return response()->json(['success'=>$html]);
        }else{

            return response()->json(['error'=>$validator->errors()->all()]);
        }
        
    }
    public function search_student_answer(Request $request)
    {
        $validator = Validator::make($request->all(), [

                'subject'         => 'required|numeric',
            ]);

        if ($validator->passes()) {

            $user_id = $this->student_info();
            $inst_info  = InstituteStudent::where('user_id',$user_id->id)->first();
            $html = '';
            $html .= '<thead>';
            $html .= '<tr>';
            $html .= '<th scope="col">SL</th>';
            $html .= '<th scope="col">Module Name</th>';
            $html .= '<th scope="col">Teacher Name</th>';
            $html .= '<th scope="col">Exam Type</th>';
            $html .= '<th scope="col">Total Question</th>';
            $html .= '<th scope="col">Total Mark</th>';
            $html .= '<th scope="col">Total Obtain Mark</th>';
            $html .= '<th scope="col">Action</th>';
            $html .= '</tr>';
            $html .= '</thead>';
            $html .= '<tbody>';

            $modules = DB::table('eyb_student_answers')
                            ->leftJoin('eyb_subjects', 'eyb_student_answers.subject_id', '=', 'eyb_subjects.id')
                            ->leftJoin('eyb_modules', 'eyb_student_answers.module_id', '=', 'eyb_modules.id')
                            ->leftJoin('eyb_module_types', 'eyb_student_answers.module_type', '=', 'eyb_module_types.id')
                            ->select('eyb_student_answers.*','eyb_subjects.subject_name','eyb_modules.module_name','eyb_modules.creator_name','eyb_module_types.module_type')
                            ->where('eyb_student_answers.subject_id',$request->subject)
                            ->where('eyb_student_answers.student_id',$user_id->id)
                            ->orderBy('id','DESC')
                            ->get();
           
            if(count($modules) > 0)
            {
                $i = 1;
                foreach($modules  as $module)
                {
                   $html .= '<tr>';
                   $html .= '<td>'.$i.'</td>';
                   $html .= '<td>'.$module->module_name.'</td>';
                   $html .= '<td>'.$module->creator_name.'</td>';
                   $html .= '<td>'.$module->module_type.'</td>';
                   $html .= '<td>'.count(json_decode($module->student_answer)).'</td>';
                   $html .= '<td>'.$module->module_mark.'</td>';
                   $html .= '<td>'.$module->student_mark.'</td>';
                   $html .= '<td><a class="btn btn-primary btn-sm" target="_blank" href="'.route('show_examination_answer',$module->id).'">Answer</a></td>';
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
    public function institute_exam_module()
    {
        $user_id        = $this->student_info();
        $inst_info     = InstituteStudent::where('user_id',$user_id->id)->first();
        $data['batch']  = StudentBatch::where('id',$inst_info->batch)->where('level_id',$inst_info->level)->where('user_id',$inst_info->institute_id)->where('start_date','<=',date('Y-m-d'))->where('end_date','>=',date('Y-m-d'))->first();
        $data['subjects']       = eyb_subject::where('level_id',$inst_info->level)->where('user_id',$inst_info->institute_id)->where('status',1)->get();
        $data['institute'] = eyb_users::where('id',$inst_info->institute_id)->first();

        $user_id = $this->student_info();
        $inst_info  = InstituteStudent::where('user_id',$user_id->id)->first();
        $data['batch']  = StudentBatch::where('id',$inst_info->batch)->where('level_id',$inst_info->level)->where('user_id',$inst_info->institute_id)->where('start_date','<=',date('Y-m-d'))->where('end_date','>=',date('Y-m-d'))->first();
        $data['subjects']       = eyb_subject::where('level_id',$inst_info->level)->where('user_id',$inst_info->institute_id)->where('status',1)->get();
        $data['institute'] = eyb_users::where('id',$inst_info->institute_id)->first();

        return view('front-end.module.tutor-exam-module',$data);
    }
    public function search_practice_module(Request $request)
    {
        $validator = Validator::make($request->all(), [

                'subject'         => 'required|numeric',
            ]);

        if ($validator->passes()) {

            $user_id = $this->student_info();
            $subject_id = $request->subject;
            $subject = eyb_subject::where('id',$subject_id)->first();
            $user_type = eyb_users::where('id',$subject->user_id)->first();
            $std_module = DB::table('eyb_student_answers')
                            ->select('module_id')
                            ->where('student_id',$user_id->id)
                            ->where('module_type',1)
                            ->get();
            $json  = json_encode($std_module);
            $array = json_decode($json, true);
            
            if($user_type->user_type == 2)
            {
                $inst_info  = InstituteStudent::where('user_id',$user_id->id)->first();
                
                $modules = DB::table('eyb_modules')
                            ->leftJoin('eyb_subjects', 'eyb_modules.subject', '=', 'eyb_subjects.id')
                            ->select('eyb_modules.*','eyb_subjects.subject_name')
                            ->where('eyb_modules.subject',$subject_id)
                            ->where('eyb_modules.student_grade',$inst_info->level)
                            ->where('eyb_modules.semester',$inst_info->semester)
                            ->where('eyb_modules.section',$inst_info->section)
                            ->where('eyb_modules.user_id',$inst_info->institute_id)
                            ->where('eyb_modules.module_type',1);
            }elseif($user_type->user_type == 4)
            {
                $inst_info  = InstituteStudent::where('user_id',$user_id->id)->first();
                
                $modules = DB::table('eyb_modules')
                            ->leftJoin('eyb_subjects', 'eyb_modules.subject', '=', 'eyb_subjects.id')
                            ->select('eyb_modules.*','eyb_subjects.subject_name')
                            ->where('eyb_modules.subject',$subject_id)
                            ->where('eyb_modules.student_grade',$inst_info->level)
                            ->where('eyb_modules.section',$inst_info->section)
                            ->where('eyb_modules.user_id',$inst_info->institute_id)
                            ->where('eyb_modules.module_type',1);
                            
            }elseif($user_type->user_type == 5)
            {
                $inst_info  = InstituteStudent::where('user_id',$user_id->id)->first();
                
                $modules = DB::table('eyb_modules')
                            ->leftJoin('eyb_subjects', 'eyb_modules.subject', '=', 'eyb_subjects.id')
                            ->select('eyb_modules.*','eyb_subjects.subject_name')
                            ->where('eyb_modules.subject',$subject_id)
                            ->where('eyb_modules.student_grade',$inst_info->level)
                            ->where('eyb_modules.user_id',$inst_info->institute_id)
                            ->where('eyb_modules.module_type',1);
                            
            }else{
                
                $modules = DB::table('eyb_modules')
                            ->leftJoin('eyb_subjects', 'eyb_modules.subject', '=', 'eyb_subjects.id')
                            ->select('eyb_modules.*','eyb_subjects.subject_name')
                            ->where('eyb_modules.subject',$subject_id)
                            ->where('eyb_modules.student_grade',$user_id->student_grade)
                            ->where('eyb_modules.user_type',1)
                            ->where('eyb_modules.module_type',1);               
            }
            if (!empty($std_module)) {
                // $modules->whereNotIn('eyb_modules.id', array_column($array, 'module_id'));
            }
            $modules->orderBy('eyb_modules.id', 'asc');
            $result = $modules->get();
            $html = '';
            
            if(count($result) > 0)
            {
                $i = 1;
                foreach($result as $module)
                {
                    
                    $order = json_decode($module->question_order);
                    $url   = route('student_examination',[$module->id]);

                    $html .= '<tr>';
                    $html .= '<td>'.$i.'</td>';
                    $html .= '<td>'.$module->module_name.'</td>';
                    $html .= '<td>'.$module->subject_name.'</td>';
                    $html .= '<td><a href="'.$url.'" class="btn btn-primary btn-sm">Start</a></td>';
                    $html .= '</tr>';
                  $i++;
                }
            }else{
                $html .= 'No data found!';
            }
             return response()->json(['success'=>$html]);
        }else{

            return response()->json(['error'=>$validator->errors()->all()]);
        }
    }
    public function Search_exam_module(Request $request)
    {
        $validator = Validator::make($request->all(), [

                'subject'         => 'required|numeric',
            ]);

        if ($validator->passes()) {

            $user_id = $this->student_info();
            $subject_id = $request->subject;
            $subject = eyb_subject::where('id',$subject_id)->first();
            $user_type = eyb_users::where('id',$subject->user_id)->first();
            $std_module = DB::table('eyb_student_answers')
                            ->select('module_id')
                            ->where('student_id',$user_id->id)
                            ->where('module_type',2)
                            ->get();
            $json  = json_encode($std_module);
            $array = json_decode($json, true);

            if($user_type->user_type == 2)
            {
                $inst_info  = InstituteStudent::where('user_id',$user_id->id)->first();
                
                $modules = DB::table('eyb_modules')
                            ->leftJoin('eyb_subjects', 'eyb_modules.subject', '=', 'eyb_subjects.id')
                            ->select('eyb_modules.*','eyb_subjects.subject_name')
                            ->where('eyb_modules.subject',$subject_id)
                            ->where('eyb_modules.exam_time','<=',time())
                            ->where('eyb_modules.exam_end','>=',time())
                            ->where('eyb_modules.exam_date','like','%'.date('Y-m-d').'%')
                            ->where('eyb_modules.student_grade',$inst_info->level)
                            ->where('eyb_modules.semester',$inst_info->semester)
                            ->where('eyb_modules.section',$inst_info->section)
                            ->where('eyb_modules.user_id',$inst_info->institute_id)
                            ->where('eyb_modules.module_type',2);
            }elseif($user_type->user_type == 4)
            {
                $inst_info  = InstituteStudent::where('user_id',$user_id->id)->first();
                
                $modules = DB::table('eyb_modules')
                            ->leftJoin('eyb_subjects', 'eyb_modules.subject', '=', 'eyb_subjects.id')
                            ->select('eyb_modules.*','eyb_subjects.subject_name')
                            ->where('eyb_modules.subject',$subject_id)
                            ->where('eyb_modules.exam_time','<=',time())
                            ->where('eyb_modules.exam_end','>=',time())
                            ->where('eyb_modules.exam_date','like','%'.date('Y-m-d').'%')
                            ->where('eyb_modules.student_grade',$inst_info->level)
                            ->where('eyb_modules.section',$inst_info->section)
                            ->where('eyb_modules.user_id',$inst_info->institute_id)
                            ->where('eyb_modules.module_type',2);
                            
            }elseif($user_type->user_type == 5)
            {
                $inst_info  = InstituteStudent::where('user_id',$user_id->id)->first();
                
                $modules = DB::table('eyb_modules')
                            ->leftJoin('eyb_subjects', 'eyb_modules.subject', '=', 'eyb_subjects.id')
                            ->select('eyb_modules.*','eyb_subjects.subject_name')
                            ->where('eyb_modules.subject',$subject_id)
                            ->where('eyb_modules.exam_time','<=',time())
                            ->where('eyb_modules.exam_end','>=',time())
                            ->where('eyb_modules.exam_date','like','%'.date('Y-m-d').'%')
                            ->where('eyb_modules.student_grade',$inst_info->level)
                            ->where('eyb_modules.user_id',$inst_info->institute_id)
                            ->where('eyb_modules.module_type',2);
                            
            }else{
                
                $modules = DB::table('eyb_modules')
                            ->leftJoin('eyb_subjects', 'eyb_modules.subject', '=', 'eyb_subjects.id')
                            ->select('eyb_modules.*','eyb_subjects.subject_name')
                            ->where('eyb_modules.subject',$subject_id)
                            ->where('eyb_modules.student_grade',$user_id->student_grade)
                            ->where('eyb_modules.exam_time','<=',time())
                            ->where('eyb_modules.exam_end','>=',time())
                            ->where('eyb_modules.exam_date','like','%'.date('Y-m-d').'%')
                            ->where('eyb_modules.user_type',1)
                            ->where('eyb_modules.module_type',2);
                            
                            
            }
            if (!empty($std_module)) {
                $modules->whereNotIn('eyb_modules.id', array_column($array, 'module_id'));
            }
            $modules->orderBy('eyb_modules.id', 'asc');
            $result = $modules->get();
            $html = '';
            
            if(count($result) > 0)
            {
                $i = 1;
                foreach($result as $module)
                {
                    
                    $order = json_decode($module->question_order);
                    $url   = route('student_examination',[$module->id]);

                    $html .= '<tr>';
                    $html .= '<td>'.$i.'</td>';
                    $html .= '<td>'.$module->module_name.'</td>';
                    $html .= '<td>'.$module->subject_name.'</td>';
                    $html .= '<td><a href="'.$url.'" class="btn btn-primary btn-sm">Start</a></td>';
                    $html .= '</tr>';
                  $i++;
                }
            }else{
                $html .= 'No data found!';
            }
             return response()->json(['success'=>$html]);
        }else{

            return response()->json(['error'=>$validator->errors()->all()]);
        }
    }

}
