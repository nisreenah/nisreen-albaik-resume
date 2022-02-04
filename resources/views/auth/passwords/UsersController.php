<?php

namespace App\Http\Controllers;

use App\EmailTemplete;
use App\Chapters_Lesson;
use App\Course;
use App\LogUser;
use App\TeacherProfile;
use App\User;
use App\RvSubscriber;
use App\Userprofile;
use App\UserAgent;
use Illuminate\Http\Request;
use Validator;
//use Datatables;
use Yajra\Datatables\Datatables;
use Alert;
use App\BlockLog;
use App\Payment;
use Auth;
use App\AccountantNote;
use App\Recordsdate;
use Helper;
use App\University;
use App\Specialty_University;
use App\ResetPassword;
use Illuminate\Support\Facades\Password;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function teachers()
    {
        $users = User::where('role', 2)->get();
        return view('users.teachers', compact('users'));
    }

    function getTeachers()
    {
        $users = User::where('role', 2)
            ->select(['id', 'name', 'email', 'isdelete', 'created_at'])
            ->with('teacherProfile')
            ->get();
//        $users = User::where('role', 2)->get();


//        $users = User::where('role', 2)->select('users.id', 'users.name', 'users.email', 'users.isdelete', 'users.created_at')->with('teacherProfile')->get();;

//        $users = User::where('role', 2)
//            ->leftJoin('core_teachers_profiles', 'users.id', '=', 'core_teachers_profiles.Teacher_id')
//            ->select('users.id', 'users.name', 'users.email', 'users.isdelete', 'users.created_at','core_teachers_profiles.Profile_img as image')
//            ->get();

        //  dd($users);

        return Datatables::of($users)
//            ->addColumn('name', function ($user) {
//                return $user->name;
//            })
//            ->filterColumn('name', function($query, $keyword) {
//                $query->whereRaw("name like ?", ["%{$keyword}%"]);
//            })
//            ->orderColumn('name', '-name $1')
            ->with('teacherProfile')
            ->editColumn('action', function ($user) {
                return '<a href="' . route('users.edit', $user->id) . '" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> تعديل</a>';
            })
            ->editColumn('image', function ($user) {
                if ($user->teacherProfile != null)
                    //  return '<img class="fancybox" src="' . $user->teacherProfile->Profile_img . '" data-big="' . $user->teacherProfile->Profile_img . '">';
                    return ' <a href="#" data-toggle="modal" data-target="#showImg' . $user->id . '"><img src="' . (($user->teacherProfile == null) ? 'http://placehold.it/100/000' : $user->teacherProfile->Profile_img) . '"/></a>
                              <span> ' . $user->name . ' </span>
                              
                             <div class="modal" tabindex="-1" role="dialog" id="showImg' . $user->id . '">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">اسم المعلم  : ' . $user->name . '</h5>
                                        </div>
                                            <div class="modal-body">
                                               <img style="border-radius:0; width: 100%; height: 100%" src="' . $user->teacherProfile->Profile_img . '"/>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                                            </div>
                                    </div>
                                </div>
                            </div>
                            ';
                else
                    return '<img src="http://placehold.it/100/000"><span> ' . $user->name . ' </span>';
            })
            ->addColumn('isdelete', function ($user) {
                if ($user->isdelete == 0)
                    return '<label class="badge badge-success">مفعلة</label>';
                else
                    return '<label class="badge badge-danger">غير مفعلة</label>';
            })
            ->addColumn('activate', function ($user) {
                return '
                   <form method="post" action="' . route('users.updateStatus', $user->id) . '">

                         <input type="hidden" name="_token" value=" ' . csrf_token() . ' ">
                         <div class="form-group">
                         <label>السبب</label>
                            <textarea rows="2" class="form-control" name="reason" placeholder="اكتب سبب الحظر"></textarea>
                         </div>
                         <select class="form-control" name="isdelete" onchange="this.form.submit();">
                            <option style="font-weight: bold;" selected >
                                 الإجراء
                            </option>
                            <option style="font-weight: bold;" value="0">
                                 تفعيل
                            </option>
                            <option value="1" style="font-weight: bold;" >
                                 تعطيل
                            </option>
                        </select>
                   </form>
                ';
            })
            ->editColumn('Approved_by', function ($user) {
                $isApproved = '';
                //dd($user->teacherProfile);
                if ($user->teacherProfile != null) {
                    if ($user->teacherProfile->Approved_by == 0)
                        $isApproved = '<p class="p-2">بانتظار الموافقة</p>';
                    else
                        $isApproved = '<p class="badge badge-success p-2">' . (($user->teacherProfile->ApprovedBy != null) ? 'وافق عليه : ' . $user->teacherProfile->ApprovedBy->name : 'غير معروف') . '</p>';

                    return '
                   
                     ' . $isApproved . '
                  
                     
                     
                      <form method="post" action="' . route('users.approveTeacherProfile', $user->id) . '">
                         <input type="hidden" name="_token" value=" ' . csrf_token() . ' ">
                         <div class="form-group">
                                         
                           <select class="form-control" name="Approved_by" onchange="this.form.submit();">
                                    <option style="font-weight: bold;" selected >
                                         الإجراء
                                    </option>
                                    <option style="font-weight: bold;" value="1">
                                        موافقة
                                    </option>
                                    <option value="0" style="font-weight: bold;" >
                                         رفض
                                    </option>
                                </select>
                      </form>
                      ';
                } else {
                    return 'لا يوجد بروفايل لهذا المعلم';
                }


            })
            ->escapeColumns([])
            ->make(true);
    }

    public function approveTeacherProfile(Request $request, $user_id)
    {

        $Approved_by = 0;
        if ($request->get('Approved_by') != 0)
            $Approved_by = Auth::user()->id;

        //dd($Approved_by);
        $profile = TeacherProfile::where('Teacher_id', $user_id)->first();
        if (!empty($profile)) {
            //dd($profile);
            $profile->update(['Approved_by' => $Approved_by]);
            Alert::success('رسالة نجاح', 'تمت العملية بنجاح');
        } else {
            Alert::error('رسالة خطأ', 'لا يوجد بروفايل ');
        }

        return redirect()->back();
    }

    public function members()
    {
        $users = User::all();
        return view('users.members', compact('users'));
    }

    function getMembers()
    {
        $users = User::select('id', 'name', 'email', 'isdelete', 'created_at', 'role', 'email_verified_at')->get();

        return Datatables::of($users)
            ->editColumn('action', function ($user) {
                return '<a href="' . route('users.edit', $user->id) . '" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> تعديل</a>                   
                ';
            })
            ->editColumn('img', function ($user) {
                if ($user->role == 3)
                    if ($user->profile != null)

                        return ' <a href="#" data-toggle="modal" data-target="#showMemberImg' . $user->id . '"><img src="' . $user->profile->image . '"/></a>
                                
                        <a href="' . route('users.student_details', $user->id) . '" class="btn btn-inverse-dark btn-rounded btn-fw">تفاصيل الطالب <span>' . $user->name . '</span></a>


                             <div class="modal" tabindex="-1" role="dialog" id="showMemberImg' . $user->id . '">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">اسم العضو  : ' . $user->name . '</h5>
                                        </div>
                                            <div class="modal-body">
                                               <img style="border-radius:0; width: 100%; height: 100%" src="' . $user->profile->image . '"/>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                                            </div>
                                    </div>
                                </div>
                            </div>

                        

                            ';
                    else
                        return '<img src="http://placehold.it/100/000">             
                              <a href="' . route('users.student_details', $user->id) . '" class="btn btn-inverse-dark btn-rounded btn-fw">تفاصيل الطالب: <span>' . $user->name . '</span></a>
                            
                        ';

                elseif ($user->role == 2)
                    if ($user->teacherProfile != null)
                        return ' <a href="#" data-toggle="modal" data-target="#showTeacherImg' . $user->id . '"><img src="' . $user->teacherProfile->Profile_img . '"/></a>
                                    <span>' . $user->name . '</span>
                                 <div class="modal" tabindex="-1" role="dialog" id="showTeacherImg' . $user->id . '">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">اسم العضو  : ' . $user->name . '</h5>
                                            </div>
                                                <div class="modal-body">
                                                   <img style="border-radius:0; width: 100%; height: 100%" src="' . $user->teacherProfile->Profile_img . '"/>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                            ';
                    else
                        return '<img src="http://placehold.it/100/000">
                                <span>' . $user->name . '</span>';
                else
                    return '<img src="http://placehold.it/100/000">
                             <span>' . $user->name . '</span>
                            ';
            })
            ->addColumn('isdelete', function ($user) {
                if ($user->isdelete == 0)
                    return '<label class="badge badge-success">مفعلة</label>';
                else
                    return '<label class="badge badge-danger">محظورة</label>';
            })
            ->addColumn('activate_ald', function ($user) {
                return '
                   <form method="post" action="' . route('users.updateStatus', $user->id) . '">

                         <input type="hidden" name="_token" value=" ' . csrf_token() . ' ">
                         <div class="form-group">
                         <label>السبب</label>
                            <textarea rows="2" class="form-control" name="reason" placeholder="اكتب سبب الحظر"></textarea>
                         </div>
                         <select class="form-control" name="isdelete" onchange="this.form.submit();">
                           
                            <option style="font-weight: bold;" value="0" ' . ($user->isdelete == 0 ? 'selected' : '') . '>
                                 حظر
                            </option>
                            <option value="1" style="font-weight: bold;" ' . ($user->isdelete == 1 ? 'selected' : '') . '>
                                 فك الحظر
                            </option>
                        </select>
                   </form>
                ';
            })
            ->addColumn('activate', function ($user) {
                $btn = '';
                if ($user->isdelete == 0) {
                    $btn = ' 
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#actionModal' . $user->id . '">
                     حظر
                    </button>';
                } else {
                    $btn = ' 
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#actionModal' . $user->id . '">
                     فك الحظر
                    </button>';
                }
                return '
                   <!-- Button to Open the Modal -->
                   ' . $btn . '
                    
                    <!-- The Modal -->
                    <div class="modal" id="actionModal' . $user->id . '">
                      <div class="modal-dialog">
                        <div class="modal-content">
                    
                          <!-- Modal Header -->
                          <div class="modal-header">
                            <h4 class="modal-title">اسم المستخدم : ' . $user->name . '</h4>
                          </div>
                    
                          <form method="post" action="' . route('users.updateStatus', $user->id) . '">
                              <input type="hidden" name="_token" value=" ' . csrf_token() . ' ">
                              
                              <!-- Modal body -->
                              <div class="modal-body">
                                   <div class="form-group">
                                      <label>إرسال رسالة</label>
                                      
                                        <div class="col-sm-10">
                                            <div class="form-radio form-radio-flat">
                                                <label class="form-check-label" style="margin-bottom: 10px;">
                                                    <input required type="radio" class="form-control" name="send"
                                                            value="1">
                                                    ارسال رسالة </label>
                                            </div>
                                            <div class="form-radio form-radio-flat">
                                                <label class="form-check-label">
                                                    <input required checked type="radio" class="form-control" name="send"
                                                          value="0"> بدون ارسالة رسالة
                                                </label>
                                            </div>
                                        </div>
                                  </div>
                                  
                                   <div class="form-group">
                                      <label>العملية</label>
                                         <div class="col-sm-10">
                                            ' . $this->blockUnblock($user->isdelete) . '
                                        </div>
                                  </div>                               
                                 
                                  <div class="form-group">
                                      <label>السبب</label>
                                      <textarea rows="5" class="form-control" name="reason" placeholder="اكتب سبب الحظر"></textarea>
                                  </div>
                               
                              </div>
                        
                              <!-- Modal footer -->
                              <div class="modal-footer">
                                   <button type="submit" class="btn btn-success">حفظ</button>
                                   <div class="clearfix"></div>
                                   <button type="button" class="btn btn-danger" data-dismiss="modal">إغلاق</button>
                              </div>
                          </form>
                    
                        </div>
                      </div>
                    </div>
                    <script src="' . asset("assets/js/shared/misc.js") . '"></script>
                ';
            })
            ->addColumn('email_verified_at', function ($user) {
                return ' 
                <div class="d-block mb-1">
                ' . $this->verify($user->email_verified_at) . '
                </div>
                 <form method="post" action="' . route('users.verifyEmail', $user->id) . '">

                         <input type="hidden" name="_token" value=" ' . csrf_token() . ' ">

                         <select class="form-control" name="email_verified_at" onchange="this.form.submit();">
                            <option style="font-weight: bold;" selected >
                                 الإجراء
                            </option>
                            
                         ' . $this->is_email_verified($user->email_verified_at) . '   
                      
                        </select>

                   </form>

                ';

            })
            ->escapeColumns([])
            ->make(true);
    }

    public function verify($email_verified_at)
    {
        if ($email_verified_at != null)
            return '<label class="badge badge-info">مفعلة</label>';
        else
            return '<label class="badge badge-dark">غير مفعلة</label>';
    }

    public function is_email_verified($email_verified_at)
    {
        if ($email_verified_at != null)
            return ' <option style="font-weight: bold;" value="0">  تعطيل </option>';
        else
            return ' <option style="font-weight: bold;" value="1">  تفعيل </option>';
    }

    public function verifyEmail(Request $request, $user_id)
    {
        $email_verified_at = $request->get('email_verified_at');
        if ($email_verified_at == 0) {
            $email_verified_at = null;
        } elseif ($email_verified_at == 1) {
            $email_verified_at = now();
        }
        User::findOrFail($user_id)->update(['email_verified_at' => $email_verified_at]);
        Alert::success('رسالة نجاح', 'تمت العملية بنجاح');
        return redirect()->route('users.members');
    }

    protected function blockUnblock($isdelete)
    {
        if ($isdelete == 0) {
            return '
             <div class="form-radio form-radio-flat">
                <label class="form-check-label" style="margin-bottom: 10px; color: red">
                    <input checked type="radio" class="form-control label-danger block" name="isdelete"
                            value="1" style="color: red">
                            حظر
                      
                </label>
            </div>
            ';
        } else {
            return '
             <div class="form-radio form-radio-flat">
                <label class="form-check-label" style="margin-bottom: 10px;">
                    <input checked type="radio" class="form-control" name="isdelete"
                            value="0" style="color: green">
                    فك الحظر </label>
            </div>
            ';
        }
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|unique:users|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->route('users.create')
                ->withErrors($validator)
                ->withInput();
        }

        $input = $request->all();

        if ($request->Input('password'))
            $bcrypt_pass = bcrypt($request->Input('password'));

        $input['password'] = $bcrypt_pass;
        $input['visits'] = 0;
        $input['session_id'] = '';
        $input['userip'] = 0;
        $input['isdelete'] = 0;
        // $input['role'] = $request->get('role');
        $user = User::create($input);

        $user_id = $user->id;

        if ($request->get('role') == 3) {
            $user->update(['role' => $request->get('role')]);
            Userprofile::create([
                'user_id' => $user_id,
                'university_id' => 1,
                'specialty_id' => 1,
                'image' => 'profile.jpg',
                'whatsup' => '',
            ]);

            $user->assignRole('student');

        } elseif ($request->get('role') == 2) {
            $user->update(['role' => $request->get('role')]);
            TeacherProfile::create([
                'Teacher_id' => $user_id,
                'teacher_type' => 'offline',
                'Active_status' => 0,
                'Qualifications' => '',
                'Years_of_experience' => 0,
                'previous_courses' => '',
                'Bio' => '',
                'Profile_img' => '',
                'Service_Agreement' => 0,
                'marketing_Agreement' => 'ALL',
                'Bank_Account_card' => '',
                'phone' => '',
                'country_code' => '',
                'ID_url' => '',
                'Experience_certificate_url' => 'url',
                'Last_Qualification_url' => 'url',
                'Approved_by' => 0,
            ]);

            $user->assignRole('teacher');

        } elseif ($request->get('role') == 1) {
            $user->update(['role' => $request->get('role')]);
            $user->assignRole('admin');
        } elseif ($request->get('role') == 4) {
            $user->update(['role' => $request->get('role')]);
            $user->assignRole('support');
        } elseif ($request->get('role') == 5) {
            $user->assignRole('accountant');
        } elseif ($request->get('role') == 6) {
            $user->assignRole('financialOfficer');
        } elseif ($request->get('role') == 7) {
            $user->assignRole('operationalOfficer');
        } elseif ($request->get('role') == 8) {
            $user->assignRole('technicalOfficer');
        } elseif ($request->get('role') == 9) {
            $user->assignRole('salesOfficer');
        } elseif ($request->get('role') == 10) {
            $user->assignRole('marketer');
        }

        Alert::success('رسالة نجاح', 'تمت العملية بنجاح');
        return redirect()->route('users.members');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);

        //dd($user->getRoleNames());
        $universities = University::all();
        $specialties = [];
        //if($user->role == 3){
        if ($user->profile != null) {
            if ($user->profile->university_id != null) {
                $specialties = Specialty_University::join('specialty', 'specialty_university.specialty_id', '=', 'specialty.id')
                    ->select('specialty.id', 'specialty.title')
                    ->where('specialty_university.university_id', $user->profile->university_id)
                    ->where('specialty_university.is_delete', 0)
                    ->get();
            }
        }
        //}
        // elseif($user->role == 2){
        // if($user->teacherProfile != null ){
        // if($user->teacherProfile->university_id != null ){
        // $specialties = Specialty_University::join('specialty', 'specialty_university.specialty_id', '=', 'specialty.id')
        // ->select('specialty.id', 'specialty.title')
        // ->where('specialty_university.university_id', $user->teacherProfile->university_id)
        // ->where('specialty_university.is_delete', 0)
        // ->get();
        // }
        // }
        // }
        return view('users.edit', compact('user', 'universities', 'specialties'));
    }

    public function sendResetPasswordRequest($user_id)
    {
        $user = User::findOrFail($user_id);
        $token = Password::getRepository()->create($user);
        $user->sendPasswordResetNotification($token);

        Alert::success('رسالة نجاح', 'تمت العملية بنجاح');
        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email,' . $id . ''
        ]);

        if ($validator->fails()) {
            return redirect()->route('users.edit', $id)
                ->withErrors($validator)
                ->withInput();
        }

        $input = [];
        if ($request->Input('password')) {
            $bcrypt_pass = bcrypt($request->Input('password'));
            $input['password'] = $bcrypt_pass;
            // register this process in password_resets table
            ResetPassword::create([
                'email' => Auth::user()->email,
                'token' => $request->get('_token'),
            ]);

        } else
            unset($input['password']);

        $input['name'] = $request->get('name');
        $input['Lname'] = $request->get('Lname');
        $input['email'] = $request->get('email');
        $input['phone'] = $request->get('phone');

        User::findOrFail($id)->update($input);
        $user = User::findOrFail($id);
        //$role = $user->role != null ? 'null' : $user->role;

        $user_role = '';
        if (sizeof($user->getRoleNames()) > 0)
            $user_role = $user->getRoleNames()[0];


        if ($user->role == 3 || $user_role == 'student') {

            $student_profile_input['university_id'] = $request->get('university_id');
            $student_profile_input['specialty_id'] = $request->get('specialty_id');

            if ($user->profile != null) {

                Userprofile::where('user_id', $user->id)->update($student_profile_input);
            } else {
                Userprofile::create([
                    'user_id' => $user->id,
                    'university_id' => $request->get('university_id'),
                    'specialty_id' => $request->get('specialty_id')
                ]);
            }
        } elseif ($user->role == 2 || $user_role == 'teacher') {
            $teacher_profile_input = [];
            if (!empty($teacher_profile_input['s3url']))
                $teacher_profile_input['Bank_Account_card'] = $request->get('s3url');
            else
                unset($teacher_profile_input['Bank_Account_card']);

            $teacher_profile_input['Bio'] = $request->get('Bio');
            $teacher_profile_input['previous_courses'] = $request->get('previous_courses');
            $teacher_profile_input['Years_of_experience'] = $request->get('Years_of_experience');
            $teacher_profile_input['Qualifications'] = $request->get('Qualifications');
            //dd($teacher_profile_input);
            //dd($user);
            if ($user->teacherProfile != null) {
                TeacherProfile::where('Teacher_id', $user->id)->update($teacher_profile_input);
            } else {
                TeacherProfile::create([
                    'Teacher_id' => $user->id,
                    'Bank_Account_card' => $request->get('s3url'),
                    'Bio' => $request->get('Bio'),
                    'previous_courses' => $request->get('previous_courses'),
                    'Years_of_experience' => $request->get('Years_of_experience'),
                    'Qualifications' => $request->get('Qualifications'),
                ]);
            }

        }

        Alert::success('رسالة نجاح', 'تمت العملية بنجاح');
        return redirect()->route('users.members');
    }

    public function storePhone(Request $request)
    {
        //dd($request->all());
        $user = User::findOrfail($request->get('userId'));
        $user->update([
            'phone_country_name' => $request->get('phone_country_name'),
            'phone_country_code' => $request->get('phone_country_code'),
            'phone_country_flag' => $request->get('phone_country_flag'),
        ]);

    }

    public function updateStatus(Request $request, $id)
    {
//         dd($request->all());
//        $user = User::findOrFail($id)->update(['isdelete' => $request->get('isdelete')]);

        $user = User::findOrFail($id);
//

        $user->isdelete = $request->input('isdelete');
        $user->save();

        $status = '';
        if ($request->input('isdelete') == 0) {
            $status = 'un_block';
        } else {
            $status = 'block';
        }

        $reason = $request->get('reason');
        BlockLog::create([
            'user_id' => $id,
            'operator_id' => Auth::user()->id,
            'reason' => $request->get('reason'),
            'status' => $status
        ]);

        $send = $request->get('send');
        if ($send == 1)
            Helper::sendMail('block_user', 'email.blockUser', $user, $reason, $status);

        Alert::success('رسالة نجاح', 'تمت العملية بنجاح');
        return redirect()->back();
    }

    public function testEmail()
    {
        $emailTemp = EmailTemplete::where('email_title', 'black_user')->first();
        $status = 'block';
        $user = User::findOrFail(1);
        $reason = 'لانك قمت بأمر مخالف';

        return view('email.blockUser', compact('reason', 'emailTemp', 'status', 'user'));
    }

    public function students()
    {
        $users = User::where('role', 3)->get();
        return view('users.students', compact('users'));
    }

    function getStudents(Request $request)
    {
        $users = User::where('role', 3)->select(['id', 'name', 'email', 'visits', 'created_at']);

        if ($request->get('email')) {
            $email = $request->get('email');
            $users = User::where('role', 3)->where('email', 'LIKE', '%' . $email . '%')->get();
        };

        $datatables = Datatables::of($users);
        return $datatables
            ->addColumn('log_old', function ($user) {

                $userLogs = LogUser::where('user_id', $user->id)->get();
                $userLogs_html = '';

                foreach ($userLogs as $userLog) {
                    $created_date = $userLog->created_at != null ? $userLog->created_at->format('d-m-Y') : 'غير معروف';
                    $created_time = $userLog->created_at != null ? $userLog->created_at->format('H:m:s') : 'غير معروف';

                    $userLogs_html = $userLogs_html .
                        '<tr>
                            <td>' . $userLog->id . '</td>
                            <td>' . $userLog->userip . '</td>
                            <td>' . $created_date . '</td>
                            <td>' . $created_time . '</td>
                         </tr>
                    ';
                }

                return '
               <a href="" data-toggle="modal" data-target="#userLogModal' . $user->id . '"><i class="mdi mdi-account-card-details" style="font-size:20px;"></i> تفاصيل سجل الدخول </a>
                   <!-- Modal -->
                    <div class="modal fade" id="userLogModal' . $user->id . '" role="dialog" aria-labelledby="userLogModal" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">سجلات الدخول</h5>

                          </div>
                          <div class="modal-body">
                          <div class="table-wrapper-scroll-y">
                            <table class="table table-bordered table-hover">
                                  <thead>
                                    <tr>
                                      <th scope="col">#</th>
                                      <th scope="col">IP address</th>
                                      <th scope="col">تاريخ الدخول</th>
                                      <th scope="col">وقت الدخول</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    ' . $userLogs_html . '
                                  </tbody>
                            </table>
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                          </div>
                        </div>
                      </div>
                    </div>
                ';
            })
            ->addColumn('created_at', function ($user) {
                if ($user->created_at != null)
                    return $user->created_at->format('d-m-Y');
                else
                    return 'غير معروف';
            })
            ->addColumn('details', function ($user) {
                return ' 
                <a href="' . route('users.student_details', $user->id) . '" class="btn btn-inverse-dark btn-rounded btn-fw"  >
                 تفاصيل المستخدم
                </a>';
            })
            ->addColumn('details_old', function ($user) {

            })
            ->addColumn('log', function ($user) {
                return ' 
                <a href="#" class="js-tingle-modal" data-user-id="' . $user->id . '">
                <i class="mdi mdi-account-card-details" style="font-size:20px;"></i> تفاصيل سجل الدخول </a>
               
                ';
            })
            ->escapeColumns([])
            ->make(true);


    }

    protected function getEmailActivition($EmailActivition)
    {
        if ($EmailActivition == 0) {
            return 'غير مؤكد بالإيميل';
        } else {
            return 'مؤكد بالإيميل';
        }
    }

    protected function getBlocked($isdelete)
    {
        if ($isdelete == 0) {
            return 'محجوب';
        } else {
            return 'فعال';
        }
    }

    protected function getTotalPaid($user_id)
    {
        $user = User::findOrFail($user_id);
        if ($user != null) {
            if ($user->payment != null)
                return $sum = $user->payment->where('Record_status', 1)->sum('this_course_paid_amount');
            else
                return 0;
        } else {
            return Payment::where('user_id', $user_id)->where('Record_status', 1)->sum('this_course_paid_amount');

        }
    }

    protected function getUniversity($user_id)
    {
        $user = User::findOrFail($user_id);
        if ($user->profile != null) {
            if ($user->profile->university != null)
                return $user->profile->university->name;
            else    return 'غير معروف';
        } else {
            return 'غير معروف';
        }

    }

    public function blockLogs()
    {
        return view('users.block_logs');
    }

    function getBlockLogs()
    {
        $logs = BlockLog::select('id', 'user_id', 'operator_id', 'reason', 'status', 'created_at')->get();

        return Datatables::of($logs)
            ->editColumn('user_id', function ($log) {
                if ($log->user != null)
                    return $log->user->name;
                else
                    return 'غير معروف';
            })
            ->editColumn('operator_id', function ($log) {
                if ($log->operator != null)
                    return $log->operator->name;
                else
                    return 'غير معروف';
            })
            ->addColumn('status', function ($log) {
                if ($log->status == 'block')
                    return '<label class="badge badge-danger">حظر</label>';
                else
                    return '<label class="badge badge-success">فك الحظر</label>';
            })
            ->editColumn('created_at', function ($log) {
                $date = $log->created_at->format('d-m-Y');
                $time = $log->created_at->format('H:m:s');
                return $date . '<br/>' . 'في تمام الساعة ' . $time;
            })
            ->escapeColumns([])
            ->make(true);
    }

    public function usersAgent()
    {
        return view('users.users_agent');
    }

    function getUsersAgent()
    {
        $agents = UserAgent::all();
        return Datatables::of($agents)
            ->addColumn('user', function ($agent) {
                if (empty($agent->user_id)) {
                    return 'زائر';

                } else {
//                    return $agent->user;
                    if ($agent->user)
                        return $agent->user->name;
                    else
                        return 'غير معروف';
                }
            })
            ->addColumn('course', function ($agent) {
                if ($agent->course_id != null || $agent->course_id != '') {
                    if ($agent->course != null)
                        return $agent->course->name;
                    else
                        return '<p>(' . $agent->course_id . ') غير معروف</p>';
                } else
                    return '---';
            })
            ->addColumn('lesson', function ($agent) {
                if ($agent->lesson_id != null || $agent->lesson_id != '') {
                    $lesson = $agent->lesson;
                    if ($lesson != null)
                        return $lesson->title;
                    else
                        return 'غير معروف';
                } else
                    return '---';
            })
            ->addColumn('logs_type', function ($agent) {
                if ($agent->logs_type == 'visit_dashboard')
                    return '<label class="badge badge-warning">زيارة لوحة التحكم</label>';
                elseif ($agent->logs_type == 'visit_course')
                    return '<label class="badge badge-primary">زيارة الكورس</label>';
                elseif ($agent->logs_type == 'watch_video_lesson')
                    return '<label class="badge badge-info">مشاهدة فيديو درس</label>';
                elseif ($agent->logs_type == 'visit_course_details')
                    return '<label class="badge badge-secondary">زيارة تفاصيل الكورس</label>';
            })
            ->addColumn('created_at', function ($agent) {
                if ($agent->created_at != null) {
                    $date = $agent->created_at->format('d-m-Y');
                    $time = $agent->created_at->format('H:m:s');
                    return $date . '<br/>' . 'في تمام الساعة ' . $time;
                } else {
                    return '---';
                }

            })
            ->escapeColumns([])
            ->make(true);

        //        $agents = UserAgent::select('id', 'user_id', 'course_id', 'lesson_id', 'user_ip', 'logs_type', 'device', 'browser', 'platform', 'created_at')
//            ->leftJoin('users','users_agent.user_id','users.id');

//        $agents = UserAgent::leftJoin('users','users_agent.user_id','users.id')
//            ->select('users_agent.id', 'users.name as username', 'users_agent.course_id', 'users_agent.lesson_id', 'users_agent.user_ip',
//                'users_agent.logs_type', 'users_agent.device', 'users_agent.browser', 'users_agent.platform', 'users_agent.created_at');
    }

    public function student_details($id)
    {
        $current_semester = Recordsdate::orderBy('start_date', 'desc')->first();
        $previous_semester = Recordsdate::where('id', '<', $current_semester->id)->orderBy('start_date', 'desc')->first();

        $user = User::findOrFail($id);
        $subscriptions = RvSubscriber::where('user_id', $id)->where('created_at', '>', $current_semester->start_date)->where('created_at', '<', $current_semester->end_date)->get();
        $previous_subscriptions = RvSubscriber::where('user_id', $id)->where('created_at', '>', $previous_semester->start_date)->where('created_at', '<', $previous_semester->end_date)->get();
        $all_subscriptions = RvSubscriber::where('user_id', $id)->get();
        $notes = [];
        if ($all_subscriptions != null) {
            foreach ($all_subscriptions as $sub) {
                $notes = AccountantNote::where('related_case', $sub->paymentrecord_id)->get();
            }
        }
        $sum = Payment::where('user_id', $id)->sum('this_course_paid_amount');
//         dd($notes);
        return view('users.student_details', compact('user', 'subscriptions', 'previous_subscriptions', 'notes', 'sum'));
    }

    public function getUserLoginLogs(Request $request)
    {

        if ($request->ajax()) {
            $user_id = $request->user_id;

            $userLogs = LogUser::where('user_id', $user_id)->get();
            $userLogs_html = '';

            foreach ($userLogs as $userLog) {
                $userLogs_html = $userLogs_html .
                    '<tr>
                            <td>' . $userLog->id . '</td>
                            <td>' . $userLog->userip . '</td>
                            <td>' . $userLog->created_at->format('d-m-Y') . '</td>
                            <td>' . $userLog->created_at->format('H:m:s') . '</td>
                         </tr>
                    ';
            }

            $info = '
             <div class="table-wrapper-scroll-y">
            <table class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">IP address</th>
                      <th scope="col">تاريخ الدخول</th>
                      <th scope="col">وقت الدخول</th>
                    </tr>
                  </thead>
                  <tbody>
                    ' . $userLogs_html . '
                  </tbody>
            </table>
            </div>
            ';

            return response()->json($info);

        }

    }

    public function reports()
    {
        return view('users.reports');

    }
}
