<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use DB;
use Image;
use Session;
use Validator;
use App\eyb_users;
use App\contact;
use App\eyb_question;
use App\eyb_student_answer;
use App\eyb_subject;
use App\eyb_module;
use App\Institute;
use App\Mail\Mailer;
class UserController extends Controller
{
    public function get_user()
    {
        return session('user_id');
    }
    public function dashboard()
    {
        $user = $this->user_info();
        $data['modules']        = eyb_module::count();
        $data['answers']        = eyb_student_answer::where('student_id',$user->id)->count();
        $data['module_marks']   = eyb_student_answer::where('student_id',$user->id)->sum('module_mark');
        $data['student_marks']  = eyb_student_answer::where('student_id',$user->id)->sum('student_mark');
        return view('front-end.dashboard',$data);
    }
    public function user_info($id='')
    {
        if($id == '')
        {
            $id = session('user_id');
        }
        $user = DB::table('eyb_users')
                    ->where('id',$id)
                    ->first();
        return $user;
    }
    public function sendVerifyEmail($email)
    {
            $verify_code        = bin2hex(random_bytes(20));
            $user = eyb_users::where('email',$email)->first();
            $user->verify_code = $verify_code;
            $user->update();
            $details = [
                    'to'        => $email,
                    'from'      => 'support@rangdhonupathshala.com',
                    'name'      => 'rongdhonupathshala',
                    'subject'   => 'Verify your email',
                    "code"      => url('verify-email').'/'.$verify_code
                ];
            
            \Mail::to($email)->send(new \App\Mail\Mailer($details));
            
            if (\Mail::failures()) {

                    return false;
                        
                }else{

                    return true;
                }
    }
    public function verify_email($code)
    {
        if(strlen($code) == 40)
        {
            $user = eyb_users::where('verify_code',$code)->first();
            
            if($user != false)
            {
                $user->email_verified_at    = date('Y-m-d h:i:s');
                $user->verify_code          = '';
                $user->update();
                return Redirect()->route('login')->with(['success' => 'Successfully verified your email address.Now you can log in']);
            }else{
                return Redirect()->route('login')->with(['error' => 'Invalid code!']);
            }
        }else{
            return Redirect()->route('login')->with(['error' => 'Invalid code!']); 
        }
    }
    public function UserLogin(Request $request)
    {
            // $error['error']         = true;
            // $error['message'][0]    = "The site is in a development mood. ";
            // return response()->json($error);
        if(session('user_id'))
        {
            return redirect('/');
        }
        if ($request->isMethod('post')) {

            
            $validator = Validator::make($request->all(), [
                'email'     => 'required|email',
                'password'  => 'required|string|max:20',
            ]);
            if($validator->passes()) {
                $email  = $request->email;
                $pass   = $request->password;
                $user   = DB::table('eyb_users')
                                ->where('email',$email)
                                ->first();
                if(!empty($user))
                {
                    if (Hash::check($request->password, $user->password)) {
                        // if($user->user_type != 3)
                        // {
                        //     $error['error']         = true;
                        //     $error['message'][0]    = "You can't access user interface.";
                        //     return response()->json($error);
                        // }
                        
                        if ($user->status == 1)
                        {
                            // if($user->email_verified_at == '')
                            //     {
                            //         $check = $this->sendVerifyEmail($user->email);
                            //       if($check == true)
                            //       {
                            //             $error['error'] = true;
                            //             $error['message'][0] = "Your email address not verified.We've sent a verification link to your email.";
                            //             $error['route'] = route('user.dashboard');
                            //             return response()->json($error);
                            //       }else{
                            //             $error['error'] = true;
                            //             $error['message'][0] = "Can't send varify link on your email address please try again with valid email address!";
                            //             return response()->json($error);
                            //       }
                            //     }
                            
                            // $user->active = 1;
                            // $user->update();
                            Session::put('user_id',$user->id);
                            $error['error']         = false;
                            $error['message'][0]    = 'Successfully logged in';
                            $error['route']         = route('user.dashboard');
                            return response()->json($error);
                        }else{
                            $error['error']         = true;
                            $error['message'][0]    = 'Your account is deactivated!';
                            return response()->json($error);
                        }
                    }else{
                        $error['error']         = true;
                        $error['message'][0]    = 'Invalid password!';
                        return response()->json($error);
                    }
                }else{
                    $error['error']         = true;
                    $error['message'][0]    = 'Invalid Email!';
                    return response()->json($error);
                }
            }else{

                $error['error']     = true;
                $error['message']   = $validator->errors()->all();
                return response()->json($error);
            }
            
            
        }
        return view('front-end.login');
    }
    public function Logout()
    {
        // $user   = DB::table('eyb_users')
        //                         ->where('id',session('user_id'))
        //                         ->first();
        // if($user != false)
        // {
        //     $user->active = 0;
        //     $user->update();
        // }
        session()->forget('user_id');
        
        return redirect('login');
    }
    public function UserRegister(Request $request)
    {
        if(session('user_id'))
        {
            return redirect('/');
        }
        if ($request->isMethod('post')) {
            
            $validator = Validator::make($request->all(), [
                'name'                  => 'required|string|max:100|regex:/^[\pL\s\-]+$/u',
                'email'                 => 'required|email|unique:eyb_users,email',
                'password'              => 'required|string|max:20',
                'district'              => 'required|numeric',
                // 'g-recaptcha-response'  => 'required',
            ]);
            if($validator->passes()) {
                $user = new eyb_users();
                $user->user_type        = 3;
                $user->name             = $request->name;
                $user->email            = $request->email;
                $user->password         = Hash::make($request->password);
                $user->district_id      = $request->district;
                $user->status           = 1;
                $verify_code            = bin2hex(random_bytes(20));
                $user->email_verified_at      = date('Y-m-d');
                // $user->verify_code      = $verify_code;
                $details = [
                    'to'        => $request->email,
                    'from'      => 'support@rangdhonupathshala.com',
                    'name'      => 'rongdhonupathshala',
                    'subject'   => 'Verify your email',
                    "code"      => url('verify-email').'/'.$verify_code
                ];
                \Mail::to($request->email)->send(new \App\Mail\Mailer($details));
                if (\Mail::failures()) {
                    $error['error']      = true;
                    $error['message'][0] = "Can't send varify link on your email address please try again with valid email address!";
                    return response()->json($error);
                }else{
                    if($user->save())
                    {
                        // Session::put('user_id',$user->id);
                        $error['error']         = false;
                        // $error['message'][0]    = 'Successfully created account!Please verify your email.send verification mail on your email address';
                        $error['message'][0]    = 'Successfully created account!you can login.';
                        $error['route']         = route('login');
                        return response()->json($error);
                    }else{
                        $error['error'] = true;
                        $error['message'][0] = 'Register failed!Please try again!';
                        return response()->json($error);
                    }
                }
            }else{
                $error['error'] = true;
                $error['message'] = $validator->errors()->all();
                return response()->json($error);
            }
        }

        $districts  = DB::table('districts')->get();
        $levels     = DB::table('eyb_level')->where('type',1)->get();
        $data       = array();
        $data['districts']  = $districts;
        $data['levels']     = $levels;
        return view('front-end.register',$data);
    }
    public function profile()
    {
        $data = array();
        $user_id = $this->get_user();
        $data['user_info'] = $this->user_info($user_id);
        $data['districts'] = DB::table('districts')->get();
        $data['levels'] = DB::table('eyb_level')->where('type',1)->get();
        return view('front-end.users.profile',$data);
    }
    public function update_picture(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'picture'      => 'required|mimes:jpeg,jpg,png',
        ]);

        // echo '<pre>';
        // print_r($request->all());
        // die;
        if ($validator->passes()) {

            $user = eyb_users::where('id',user_id())->first();
            if($request->file('picture')) {
                $image = $request->file('picture');

                $image_name = time() . rand(10000,9999999).'.'.$image->getclientoriginalextension();
                $image->move("public/assets/users-photo/",$image_name);
                $image_path = "assets/users-photo/".$image_name;
                $destinationPath = 'public/assets/users-photo/';
                Image::make('public/assets/users-photo/'.$image_name)->widen(960)->heighten(960)->orientate()->crop(960,960)->save($destinationPath.'/'.$image_name);
                if($user->image != '')
                {
                    if (file_exists(base_path().'/public/'.$user->image)) {
                        unlink(base_path().'/public/'.$user->image);
                    } 
                }
                $user->image      = $image_path;
                if($user->update())
                {
                    $error['error'] = false;
                    $error['message'] = 'Profile picture update successfully!';
                    return response()->json($error);
                }else{
                    $error['error'] = true;
                    $error['message'][0] = 'Profile picture update failed!';
                    return response()->json($error);
                }
            }
        }else{
            $error['error'] = true;
            $error['message'] = $validator->errors()->all();
            return response()->json($error);
        }
    }
    public function update_user_info(Request $request)
    {
        $data = array();
        $data['name'] = $request->name;
        $data['user_mobile'] = $request->phone;
        $data['student_grade'] = $request->level;
        $data['district_id'] = $request->district;
        if (isset($request->two_step_verification)) {
            $data['two_step_verification'] = 1;
        }else
        {
            $data['two_step_verification'] = 0;
        }
        foreach($data as $key=>$item)
        {
            if ($item == '')
            {
                unset($data[$key]);
            }
        }
        $user_id = $this->get_user();
        DB::table('eyb_users')
            ->where('id', $user_id)
            ->update($data);
        $user = DB::table('eyb_users')
            ->select('name','user_mobile','student_grade','district_id')
            ->where('id',$user_id)
            ->first();
        echo json_encode($user);
    }

    public function change_user_password(Request $request)
    {
        $msg['msg'] = '';
        $msg['status'] = 0;
        $old_password  = $request->old_password;
        $password  = Hash::make($request->password);
        if ($old_password != '' && $request->password != '') {
           $user_id = $this->get_user();
           $user    = DB::table('eyb_users')
                        ->select('password')
                        ->where('id',$user_id)
                        ->first();
            if(!empty($user))
            {
                if (Hash::check($request->old_password, $user->password)) {
                    DB::table('eyb_users')
                    ->where('id', $user_id)
                    ->update(['password'=>$password]);
                    $msg['msg'] = "Password changed successfully.";
                    $msg['status'] = 1;

                }else{

                    $msg['msg'] = "Old password don't matched!";
                }
            }else
            {
                $msg['msg'] = "Old password don't matched!";
            }
         
        }else
        {
            $msg['msg'] = "Please provide valid information!";
        }
        echo json_encode($msg);
        
    }

    public function contact(Request $request)
    {

        if ($request->isMethod('post')) {
            $validatedData = $request->validate([
                'name'                  => 'required',
                'email'                 => 'required|email',
                'message'               => 'required',
                'g-recaptcha-response'  => 'required',
            ]);

            $contact = new contact();
            $contact->name      = $request->name;
            $contact->email     = $request->email;
            $contact->message   = $request->message;
            if ($contact->save())
            {
                return redirect()->back()->with(['success'=>'Successfully send your message']);
            }else{

                return redirect()->back()->with(['error'=>'message not send try again!']);
            }
        }
        return view('front-end.contact');
    }

    public function forgot_password(Request $request)
    {
        if ($request->isMethod('post')) {

            $validatedData = $request->validate([
                    'email'  => 'required|email',
            ]);

            $user = eyb_users::where('email',$request->email)->first();
            if($user != false)
            {
                $verify_code        = bin2hex(random_bytes(6));

                $user->password  = Hash::make($verify_code);
                $user->update();
                $details = [
                    'to'        => $request->email,
                    'from'      => 'support@rangdhonupathshala.com',
                    'name'      => 'rongdhonupathshala',
                    'subject'   => 'New Password',
                    "code"      => $verify_code,
                ];
            
                \Mail::to($request->email)->send(new \App\Mail\MailerReset($details));
                if (\Mail::failures()) {

                    return redirect()->back()->with(['error'=>"Can't send varify link on your email address please try again with valid email address!"]);
                        
                }else{

                    return redirect()->back()->with(['success'=>"New password send on your email address"]);
                }
            }else{
                return redirect()->back()->with(['error'=>'Invalid email!']);
            }
        }
        return view('front-end.forgot-password');
    }
}
