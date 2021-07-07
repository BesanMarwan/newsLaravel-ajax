<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use App\Http\Requests\UserRequest;
use DB;

class UserController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:المستخدمين'        , ['only' => ['index'         ]]);
        $this->middleware('permission:اضافة مستخدم'      , ['only' => ['create','store']]);
        $this->middleware('permission:تعديل صلاحية مستخدم', ['only' => ['update','edit' ]]);
        $this->middleware('permission:حذف مستخدم'        , ['only' => ['destroy'       ]]);
    }

    public function index(Request $request)
    {
        $users = User::orderby('id', 'desc')->select('id', 'user_image', 'name', 'username', 'email', 'status','bio', 'created_at')->paginate(PAGINATION_COUNT);
        if($request->ajax()) {
            return view('admin.pages.users.subs.table',compact('users'));
        }
        $roles = Role::pluck('name','name')->all();
        return view('admin.pages.users.index',compact('roles','users'));
    }

    public function store(UserRequest $request)
    {
        $user_image='';
        try {
            $user              = new User();
            $user->name        = $request->name;
            $user->username    = $request->username;
            $user->email       = $request->email;
            $user->password    = bcrypt($request->password);
            $user->bio         = $request->bio;
            $user->status      = $request->status;
            $user->roles_name  =$request->input('roles_name')[0];
            if ($request->has('user_image')) {
                $user_image    = uploadImage('users', $request->user_image);
            }
            $user->user_image  = $user_image;
            $user->save();
            $user->assignRole($request->input('roles_name')[0]);
            if(! $user ) {

                return response()->json([
                    'status' => false,
                    'error' => 'فشل عمليه اضافة المستخدم',
                ]);
            }

                return response()->json([
                    'status' => true,
                    'success' => 'تم اضافة المستخدم بنجاح',
                ]);

        }

        catch (\Exception $e){
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function get(Request $request,$id){
        if($request->ajax()) {
            $user = User::find($id);
            return response()->json($user);
        }

    }
    public function show(Request $request,$id)
    {
        try {
            $user = User::find($request->id);
            return view('admin.pages.users.show', compact('user'));
            if(! $user) {
                toastr()->error('هذا المستخدم غير موجود :(');
                return redirect()->route('users.index');
            }
        }catch(\Exception $ex) {
            return redirect()->back()->withErrors(['error' => $ex->getMessage()]);
        }
    }



    public function updateProfile(Request  $request)
    {
        try {
            $user = User::findOrFail(auth()->user()->id);
            $user->update([
                'name'        =>  $request->name,
                'username'    => $request->username,
                'email'       => $request->email,
                'password'    => bcrypt($request->password),
                'bio'         => $request->bio,
                ]);
            if ($request->has('user_image')) {
                $user_image    = uploadImage('users', $request->user_image);
                $image = public_path($user_image);
                unlink($user_image);
                $user->update([
                   'user_image' =>$user_image
                ]);
            }
            toastr()->success('تم التعديل ع بياناتك  بنجاح');
            return redirect()->route('users.show',auth()->user()->id);
        }
        catch
        (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }


    public function update(Request $request)
    {
        try {
            $user = User::findOrFail($request->id);
            $user->update([
                'roles_name'    =>$request->input('roles_name')[0],
                'status'        => $request->status,
            ]);
            DB::table('model_has_roles')->where('model_id',$request->id)->delete();
            $user->assignRole($request->input('roles_name')[0]);
            return response()->json([
                'status' => true,
                'success' => 'تم التعديل ع صلاحيات المستخدم  بنجاح',
            ]);
        }
        catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function destroy(Request $request)
    {

        try {
            $user = User::findOrFail($request->id)->delete();
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'error' => 'فشل عمليه الحدف! ..',
                ]);
            }
            return response()->json([
                'status' => true,
                'success' => 'تم حدف المستخدم  بنجاح',
            ]);
        }catch(\Exception $exception){
            return redirect()->back()->withErrors(['error' => $exception->getMessage()]);

        }

    }

}
