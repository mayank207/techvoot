<?php

namespace App\Http\Controllers;

use App\Models\User;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $page_title="Users";

        return view('users.index',compact('page_title'));
    }
    public function lists()
    {
        try {
            if (request()->ajax()) {
                $users = User::where('is_admin',0)->select('users.*');
                $all_users = DataTables::of($users)
                    ->editcolumn('name', function (User $users) {
                        return $users->name??"";
                    })->editcolumn('email', function (User $users) {
                        return $users->email??"";
                    })
                    ->editColumn('action', function (User $users) {
                        $action = "";

                        $action .= "<a  class=\"btn btn-info btn-sm\"
                                    href='".route('users.edit',$users->id)."' id=\"editproduct\" data-id='".$users->id."'
                                    data-toggle=\"tooltip\" title=\"Edit\"
                                    data-placement=\"top\">
                                    edit
                                </a>";
                        $action .= "<a href='".route('users.delete',$users->id)."' class=\"btn btn-danger btn-sm\"
                                href=\"#\" id=\"deleteproduct\" data-id='".$users->id."'
                                data-toggle=\"tooltip\" title=\"Edit\"
                                data-placement=\"top\">
                                Delete
                            </a>";

                        return $action;
                    })
                    ->escapeColumns([])
                    ->make(true);
                return $all_users;
            }
        } catch (\Exception $exception) {
            return redirect()->route('login')->withError('Something went wrong, please try again');
        }
    }

    public function create()
    {
        $page_title="Add Users";
        return view('users.create',compact('page_title'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'confirm_password'=> 'required',
        ],
        [
            'name.required' => 'Please enter name',
            'email.required' => 'Please enter email',
            'password.required' => 'Please enter password',
            'confirm_password.required' => 'Please enter confirm password',
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator);
        }
        $user=new User;
        $user->name=$request->name;
        $user->email=$request->email;
        $user->is_admin=0;
        $user->password=bcrypt($request->password);
        $user->save();
        return redirect()->route('users.index')->with('toast-success','User added successfully');
    }

    public function edit($id=null)
    {
        $page_title="Edit Users";
        $users=[];
        if(!is_null($id)){
            $users=User::where('is_admin',0)->where('id',$id)->first();
        }
        return view('users.edit',compact('page_title','users'));
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'emai' => 'required',
        ],
        [
            'name.required' => 'Please enter name',
            'emai.required' => 'Please enter email',
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator);
        }
        $user=User::where('is_admin',0)->where('id',$request->user_id)->first();
        $user->name=$request->name;
        $user->email=$request->email;
        if($user->save()){
            return redirect()->route('users.index')->with('toast-success','User updated successfully');
        }
        return redirect()->route('users.index')->with('toast-error','Something went wrong');
    }

    public function isEmailExists(Request $request){
        $isValid = true;
        $message = '';

        $email = $request->email;
        if($request->has('email')){
            $email =$request->email;
        }
        if(!empty($request->id) && $request->id != 0)
        {
            $isExist = User::select('id')->where('id','!=',$request->id)->where('email',$email)->count();
        }
        else{
            $isExist = User::select('id')->where('email',$email)->count();
        }
        if($isExist != 0){
                $isValid = false;
                $message = 'Email is already exists';
            }
        return response()->json(['valid' => $isValid,'message' => $message]);
    }

    public function destroy($id=null)
    {
        if(!is_null($id)){
            $users=User::where('is_admin',0)->where('id',$id)->delete();
        }
        return redirect()->route('users.index')->with('toast-success','User deleted successfully.');
    }
}
