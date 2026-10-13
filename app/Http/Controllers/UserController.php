<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Flash;
use Response;
use DB;

class UserController extends Controller
{
    public function index(Request $request)
    {
        /** @var User $users */
        $users = User::select('users.*', 'roles.name as role', 'designations.desi_name as designation','districts.name_en as district')
            ->leftjoin('roles', 'users.group_id', '=', 'roles.id')
            ->leftjoin('districts', 'users.dis_id', '=', 'districts.id')
            ->leftjoin('designations', 'users.designation', '=', 'designations.id');
        // if(!can('chairman') && can('district_admin')) {
        //     $users = $users->where('users.district_id', auth()->user()->district_id);
        // }
        $users = $users->get();
        return view('users.index')
            ->with('users', $users);
    }

    /**
     * Show the form for creating a new User.
     *
     * @return Response
     */
    public function create()
    {
        return view('users.create');
    }


    public function store(Request $request)
    {
        $input = $request->all();

        try {
            if ($request->hasFile('picture')) {
                $file = $request->file('picture');
                $folder = 'picture/user';
                $customName = 'user-'.time();
                $input['picture'] = uploadFile($file, $folder, $customName);
            } else {
                $input['picture'] = 'no-image.png';
            }

            if ($request->hasFile('signature')) {
                $file = $request->file('signature');
                $folder = 'images/signature';
                $customName = 'signature-'.time();
                $input['signature'] = uploadFile($file, $folder, $customName);
            } else {
                $input['signature'] = 'no-image.png';
            }

            $password = $request->filled('password') ? $request->password : '12345678';
            $input['password'] = bcrypt($password);

            if (!$request->filled('username')) {
                Flash::error('Username is required.');
                return redirect()->back()->withInput();
            }

            $user = User::where('username', $request->username)->first();
            if ($user) {
                Flash::error('Username Already Exist.');
                return redirect()->back()->withInput();
            }
            $input['username'] = $request->username;

            $input['group_id'] = $request->user_role;
            $input['current_status'] = 'Active';

            /** @var User $users */
            $users = User::create($input);

            Flash::success('User saved successfully.');
            return redirect(route('users.index'));
        } catch (\Exception $e) {
            Flash::error($e->getMessage());
            return redirect()->back()->withInput();
        }
    }


    public function show($id)
    {
        /** @var User $users */
        $users = User::find($id);

        if (empty($users)) {
            Flash::error('User not found');

            return redirect(route('users.index'));
        }

        return view('users.show')->with('users', $users);
    }


    public function edit($id)
    {
        /** @var User $users */
        $users = User::find($id);
        //

        if (empty($users)) {
            Flash::error('User not found');

            return redirect(route('users.index'));
        }

        return view('users.edit')->with('users', $users);
    }


    public function update($id, Request $request)
    {
        /** @var User $users */
        $users = User::find($id);

        if (empty($users)) {
            Flash::error('User not found');

            return redirect(route('users.index'));
        }

        try {
            $input = $request->all();
            if ($request->hasFile('picture')) {
                $file = $request->file('picture');
                $folder = 'picture/user';
                $customName = 'user-'.time();
                $input['picture'] = uploadFile($file, $folder, $customName);
            }else{
                unset($input['picture']);
            }

            if ($request->hasFile('signature')) {
                $file = $request->file('signature');
                $folder = 'images/signature';
                $customName = 'signature-'.time();
                $input['signature'] = uploadFile($file, $folder, $customName);
            }else{
                unset($input['signature']);
            }


            if ($request->filled('password')) {
                $input['password'] = bcrypt($request->password);
            }else{
                unset($input['password']);
            }

            if (!$request->filled('username')) {
                Flash::error('Username is required.');
                return redirect()->back()->withInput();
            }

            $user = User::where('username', $request->username)->first();
            if ($user && $user->id != $id) {
                Flash::error('Username Already Exist.');
                return redirect()->back()->withInput();
            }
            $input['username'] = $request->username;


            $input['group_id'] = $request->user_role;

            $users->fill($input);
            $users->save();
            Flash::success('User updated successfully.');
            return redirect(route('users.index'));
        } catch (\Exception $e) {
            Flash::error($e->getMessage());
            return redirect()->back()->withInput();
        }
    }


    public function destroy($id)
    {
        /** @var User $users */
        $users = User::find($id);
        if (empty($users)) {
            Flash::error('User not found');
            return redirect(route('users.index'));
        }
        $users->delete();
        Flash::success('User deleted successfully.');
        return redirect(route('users.index'));
    }
}
