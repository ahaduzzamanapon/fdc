<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ItemDepartment;
use Flash;
use Response;

class InvPermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /** @var User $users */
        $users = User::select('users.*', 'item_departments.name as inv_permission', 'designations.desi_name as designation')
            ->leftjoin('item_departments', 'users.inv_permission', '=', 'item_departments.id')
            ->leftjoin('designations', 'users.designation', '=', 'designations.id');
        $users = $users->where('users.inv_permission', '!=', null)->get();

        return view('invPermissions.index')->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('invPermissions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user_id = $request->id;
        $inv_permission = $request->inv_permission;
        User::where('id', $user_id)->update(['inv_permission' => $inv_permission]);

        Flash::success('Inventory Permission updated successfully.');
        return redirect(route('invPermissions.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $users = User::find($id);
        if (empty($users)) {
            Flash::error('User not found');
            return redirect(route('invPermissions.index'));
        }
        return view('invPermissions.show')->with('users', $users);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $users = User::find($id);
        if (empty($users)) {
            Flash::error('User not found');
            return redirect(route('invPermissions.index'));
        }
        return view('invPermissions.edit')->with('users', $users);
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
        $inv_permission = $request->inv_permission;
        User::where('id', $id)->update(['inv_permission' => $inv_permission]);
        Flash::success('Inventory Permission updated successfully.');
        return redirect(route('invPermissions.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::where('id', $id)->update(['inv_permission' => null]);
        Flash::success('Inventory Permission delete successfully.');
        return redirect(route('invPermissions.index'));
    }
}
