<?php

namespace App\Http\Controllers;

use App\Course;
use App\User;
use Illuminate\Http\Request;
use Validator;
use Yajra\Datatables\Datatables;
use Alert;
use Auth;
use Helper;
use Chat;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function conversations()
    {

        return view('chat.conversations', compact('users'));
    }

    function getConversations()
    {
        $users = User::where('role', 2)->select(['id', 'name', 'email', 'isdelete', 'created_at'])->get();

        return Datatables::of($users)
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
            ->escapeColumns([])
            ->make(true);
    }

}
