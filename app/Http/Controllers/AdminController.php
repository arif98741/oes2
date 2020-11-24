<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\eyb_users;
use App\eyb_question;
use App\contact;
use App\eyb_student_answer;
use DB;
use Session,Validator;
class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function Login(Request $request)
    {
        if ($request->isMethod('post')) {

            $validatedData = $request->validate([
                'email' => 'required|email',
                'password' => 'required|string|max:20',
            ]);

            $email = $request->email;
            $pass  = $request->password;
            $user  = eyb_users::where('email',$email)->first();
            if (!empty($user) && ($user->user_type == 1 || $user->user_type == 2 || $user->user_type == 5))
            {
                 if (Hash::check($request->password, $user->password)) {
                    if ($user->status == 1)
                    {
                        $rand = md5(rand()).md5($email);
                        if ($user->user_type == 1 && $user->admin_status == 1)
                        {
                            Session::put('admin_status',1);
                        }
                        if ($user->user_type == 1 && $user->admin_status == 0)
                        {
                            Session::put('super_status',1);
                        }
                        Session::put('log_status',$rand);
                        Session::put('admin_id',$user->id);
                        // DB::table('eyb_users')
                        //     ->where('id', $user->id)
                        //     ->update(['log'=>$rand]);
                        return redirect('/dashboard');
                    }else{
                        return redirect()->back()->with(['error' =>'Your account not activated.Please contact to admin.']);
                    }
                 }else{
                    return redirect()->back()->with(['error'=>'Invalid password!']);
                 }
                
            }else{

                return redirect()->back()->with(['error'=>'Invalid email!']);
            }

        }
        return view('admin.login');
    }
    public function admin_logout()
    {
        // $admin_log = session('log_status');

        // if ($admin_log != '')
        // {
        //     $admin      = eyb_users::where('log',$admin_log)->first();
        //     $admin->log = '';
        //     $admin->update();
        // }
        session()->forget('admin_status');
        session()->forget('super_status');
        session()->forget('log_status');
        session()->forget('admin_id');
        return redirect('backend');
    }

    public function index()
    {
        $data['users'] = eyb_users::count();
        $data['questions'] = eyb_question::count();
        $data['exams'] = eyb_student_answer::count();
        return view('admin.home',$data);
    }
    public function contact()
    {
        $contacts = contact::paginate(10);

        return view('admin.contacts',['contacts'=>$contacts]);
    }

    public function deleteContact(Request $request)
    {
        $id = $request->id;
       
        if(contact::where('id',$id)->delete())
        {
            echo 1;
        }else
        {
            echo 0;
        }
    }

    public function users()
    {
        return view('admin.users.index');
    }
    public function user_list(Request $request)
    {
        $limit = 25;
        $users = eyb_users::where('user_type',3)->paginate($limit);
        $start = 1;
        $data['total'] = eyb_users::where('user_type',3)->count('id');
        if($users->currentPage() > 1)
        {
                $start = (($users->currentPage() - 1) * $limit) + 1;
        }
        $data['users']  = $users;
        $data['start']  = $start;
        if($request->ajax()){

            $view =  view('admin.users.list-content',$data);
            $result['view']         = $view->render();
            return response()->json(['success'=>$result]);  
        }
    }
    public function search_user(Request $request)
    {
        $search         = $request->search;
        $by_date        = $request->by_date;
        $by_verified    = $request->by_verified;
        $by_status      = $request->by_status;
        $limit = 25;
        $total_query = eyb_users::where('user_type',3);
        $user_query = eyb_users::where('user_type',3);
        if($by_status != '')
        {
            if($by_status == 'asc')
            {
                $user_query->where('status',1);
                $total_query->where('status',1);
            }elseif($by_status = 'desc')
            {
                $user_query->where('status',0);
                $total_query->where('status',0);
            }
        }
        if($by_verified != '')
        {
            if($by_verified == 'asc')
            {
                $user_query->where('email_verified_at','!=','');
                $total_query->where('email_verified_at','!=','');
            }elseif($by_verified = 'desc')
            {
                $user_query->whereNull('email_verified_at');
                $total_query->whereNull('email_verified_at');
            }
        }
        if($search != '')
        {
            
            $user_query->where('name','like','%'.$search.'%');
            $user_query->orWhere('email','like','%'.$search.'%');
            $total_query->where('name','like','%'.$search.'%');
            $total_query->orWhere('email','like','%'.$search.'%');
        }
        $data['total'] = $total_query->count('id');
        if($by_date != '')
        {
            if($by_date == 'asc')
            {
                $user_query->orderBy('created_at','asc');
            }elseif($by_date = 'desc')
            {
                $user_query->orderBy('created_at','desc');
            }
        }
        $users = $user_query->paginate($limit);
        $start = 1;
        if($users->currentPage() > 1)
        {
                $start = (($users->currentPage() - 1) * $limit) + 1;
        }
        $data['users']  = $users;
        $data['start']  = $start;
        if($request->ajax()){

            $view =  view('admin.users.list-content',$data);
            $result['view']         = $view->render();
            return response()->json(['success'=>$result]);  
        }
    }
    public function get_users_list(Request $request)
    {
        $draw   = $request->draw;
        $start  = $request->start;
        $length = $request->length;
        $total_rows = eyb_users::where('user_type',3)->count('id');
        if (isset($request->search['value']))
        {
            $users = DB::table('eyb_users')
                            ->where('eyb_users.name','like', '%'.$request->search['value'].'%')
                            ->where('user_type',3)
                            ->orWhere('eyb_users.user_mobile','like','%'.$request->search['value'].'%')
                            ->orWhere('eyb_users.email','like','%'.$request->search['value'].'%')
                            ->select('eyb_users.*')
                            ->skip($start)
                            ->take($length)
                            ->orderBy('id', 'DESC')
                            ->get();
            $count_users = DB::table('eyb_users')
                            ->where('eyb_users.name','like', '%'.$request->search['value'].'%')
                            ->where('user_type',3)
                            ->orWhere('eyb_users.user_mobile','like','%'.$request->search['value'].'%')
                            ->orWhere('eyb_users.email','like','%'.$request->search['value'].'%')
                            ->count();
            $total_rows = $count_users;
        }else
        {
            $users = DB::table('eyb_users')
                            ->where('user_type',3)
                            ->select('eyb_users.*')
                            ->skip($start)
                            ->take($length)
                            ->orderBy('id', 'DESC')
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
            $html = '';
            $html = '<a href="#" onclick="EditUser('.$user->id.')" class="btn btn-primary">Edit</a>';
            $status = '';
            $type = '';
            if($user->status == 1)
            {
                $status = '<button class="btn btn-success btn-sm">Active</button>';
            }else{
                $status = '<button class="btn btn-warning btn-sm">Inactive</button>';
            }
            $institute = '<span class="alert alert-warning">No Institute</span>';
            $StudentInstitute = StudentInstitute($user->id);
            if($StudentInstitute != false)
            {
                $institute = '<span class="alert alert-success">'.ucwords(strtolower($StudentInstitute->name)).'</span>';
            }
            
            $data['data'][$o][] = $user->name;
            $data['data'][$o][] = $user->email;
            $data['data'][$o][] = $institute;
            $data['data'][$o][] = $status;
            $data['data'][$o][] = $html;
            $i++;
            $o++;
        }
        
        echo json_encode($data);
    }

    public function edit_user(Request $request)
    {
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'user_id' => 'required|numeric',
                'status'  => 'required|numeric',
                'verified'  => 'required|numeric',
            ]);
            if ($validator->passes()) {

                $user = eyb_users::where('id',$request->user_id)->first();
                $user->status     = $request->status;
                if($request->verified == 1)
                {
                    $user->email_verified_at     = date('Y-m-d');
                }else{
                    $user->email_verified_at     = NULL;
                }
                
                if($request->password != '')
                {
                    $user->password       = Hash::make($request->password);
                }
                if($user->update())
                {
                    $error['error']  = false;
                    $error['message'] = 'Successfully Update';
                    return response()->json($error);
                }else{
                    $error['error'] = true;
                    $error['message'][0] = 'Update failed!';
                    return response()->json($error);
                }
            }

            $error['error'] = true;
            $error['message'] = $validator->errors()->all();
            return response()->json($error);
        }
        $result['error']    = true;
        $result['html']     = '';
        $result['message']  = 'User not found!';
        $user = eyb_users::where('id',$request->id)->first();

        if(!empty($user))
        {
            $status_array[0] = 'Inactive';
            $status_array[1] = 'Active';
            $verified_array[0] = 'Not Verified';
            $verified_array[1] = 'Verified';
            $html = '';
            $verified_html = '';
            foreach($status_array as $key=>$st)
            {

                $status = '';
                if($user->status == $key)
                {
                    $status = 'selected';
                }
                $html .= '<option value="'.$key.'" '.$status.'>'.$st.'</option>';
            }
            foreach($verified_array as $key=>$verified_a)
            {

                $verified = '';
                if($user->email_verified_at != '')
                {
                    $verified = 'selected';
                }
                $verified_html .= '<option value="'.$key.'" '.$verified.'>'.$verified_a.'</option>';
            }
            
            $result['error']    = false;
            $result['status']   = $html;
            $result['verified']   = $verified_html;
            $result['message']  = 'success';
        }
        
        return response()->json($result);
    }

    public function members()
    {
        return view('admin.members.members');
    }
    public function add_member(Request $request)
    {
        if ($request->isMethod('post')) {
            
            $validatedData = $request->validate([
                'name'      => 'required',
                'phone'     => 'required',
                'email'     => 'required|email|unique:eyb_users,email',
                'address'   => 'required',
                'password'  => 'required|string|max:20',
                'status'    => 'required',
            ]);

            $member = new eyb_users();

            $member->user_type      = 1;
            $member->name           = $request->name;
            $member->user_mobile    = $request->phone;
            $member->email          = $request->email;
            $member->password       = Hash::make($request->password);
            $member->status         = $request->status;
            $member->address        = $request->address;
            if($member->save())
            {
                return redirect()->back()->with(['success'=>'Member successfully added']);
            }else{
                return redirect()->back()->with(['error'=>'member add failed']);
            }
        }
        return view('admin.members.add');
    }

    public function get_members_list(Request $request)
    {
        $draw   = $request->draw;
        $start  = $request->start;
        $length = $request->length;
        $total_rows = eyb_users::where('user_type',1)->where('admin_status',0)->count('id');
        if (isset($request->search['value']))
        {
            $users = DB::table('eyb_users')
                            ->where('eyb_users.name','like', '%'.$request->search['value'].'%')
                            ->where('user_type',1)
                            ->where('admin_status',0)
                            ->orWhere('eyb_users.user_mobile','like','%'.$request->search['value'].'%')
                            ->orWhere('eyb_users.email','like','%'.$request->search['value'].'%')
                            ->select('eyb_users.*')
                            ->skip($start)
                            ->take($length)
                            ->orderBy('id', 'DESC')
                            ->get();
            $count_users = DB::table('eyb_users')
                            ->where('eyb_users.name','like', '%'.$request->search['value'].'%')
                            ->where('user_type',1)
                            ->where('admin_status',0)
                            ->orWhere('eyb_users.user_mobile','like','%'.$request->search['value'].'%')
                            ->orWhere('eyb_users.email','like','%'.$request->search['value'].'%')
                            ->count();
            $total_rows = $count_users;
        }else
        {
            $users = DB::table('eyb_users')
                            ->where('user_type',1)
                            ->where('admin_status',0)
                            ->select('eyb_users.*')
                            ->skip($start)
                            ->take($length)
                            ->orderBy('id', 'DESC')
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
            $html = '';
            $html = '<a href="#" onclick="EditUser('.$user->id.')" class="btn btn-primary">Edit</a>';
            $status = '';
            $type = '';
            if($user->status == 1)
            {
                $status = '<button class="btn btn-success btn-sm">Active</button>';
            }else{
                $status = '<button class="btn btn-warning btn-sm">Inactive</button>';
            }
            
            $data['data'][$o][] = $user->name;
            $data['data'][$o][] = $user->email;
            $data['data'][$o][] = $status;
            $data['data'][$o][] = $html;
            $i++;
            $o++;
        }
        
        echo json_encode($data);
    }

}
