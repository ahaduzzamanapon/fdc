<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Flash;
use Response;
class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('profile.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // if ($id != Auth::id()) {
        //     abort(403); // Optional security
        // }

        // $user = Auth::user();
        // return view('profile.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $profile = User::find($id);
        if ($id != Auth::id()) {
            abort(403); // Optional security
        }

        $user = Auth::user();
        return view('profile.show', compact('user'))->with('users', $profile);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $profile = User::find($id);

        if (empty($profile)) {
            Flash::error('User not found');
            return redirect(route('profile.index'));
        }

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


        if ($request->has('password')) {
            $input['password'] = bcrypt($request->password);
        }else{
            unset($input['password']);
        }

        if ($request->has('mobile_no')) {
            $input['username'] = $request->mobile_no;

            $user = User::where('username', $request->mobile_no)->first();
            if($user && $user->id != $id){
                Flash::error('Mobile No Already Exist.');
                return redirect()->back();
            }
        }
        // $input['group_id'] = $request->user_role;

        $profile->fill($input);
        $profile->save();
        Flash::success('User updated successfully.');
        return redirect(route('profile.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
