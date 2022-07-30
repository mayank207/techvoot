<?php

namespace App\Http\Controllers;

use App\Models\User;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;

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
        $user=new User;
        $user->name=$request->name;
        $user->email=$request->email;
        $user->is_admin=0;
        $user->password=bcrypt($request->password);
        $user->save();
        return redirect()->route('users.index')->withSuccess("User added successfully");
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
        $user=User::where('is_admin',0)->where('id',$request->user_id)->first();
        $user->name=$request->name;
        $user->email=$request->email;
        if($user->save()){
            return redirect()->route('users.index')->withSuccess("User updated successfully");
        }
    }
    
    public function destroy($id=null)
    {
        if(!is_null($id)){
            $users=User::where('is_admin',0)->where('id',$id)->delete();
        }
        return redirect()->route('users.index')->withSuccess("User deleted successfully");
    }
}
