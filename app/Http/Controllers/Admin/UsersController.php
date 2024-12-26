<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUsersRequest;
use App\Http\Requests\Admin\UpdateUsersRequest;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{

    /**
     * Display a listing of Users.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        if(!Gate::allows('users_manage')) {
            return view('admin.errors.forbidden');
        }

        $users = User::limit(100)->get();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Display a listing of Users in Json.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function users(Request $request)
    {

        $columns = array(
            0 => 'id',
            1 => 'id',
            2 => 'name',
            3 => 'email',
            4 => 'created_at',
            5 => 'id',
            6 => 'DT_RowId',
        );

        $totalData = User::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value')))
        {
           $rows = User::select('*');
           if($limit > 0) {
                $rows->offset($start);
                $rows->limit($limit);
            }
            $rows->orderBy($order,$dir);
            $users = $rows->get();

       } else {
            $search = $request->input('search.value');

            $rows = User::select('*');
            $rows->where('name','LIKE',"{$search}%");
            if($limit > 0) {
                $rows->offset($start);
                $rows->limit($limit);
            }
            $rows->orderBy($order,$dir);
            $users = $rows->get();

            $totalFiltered = User::select('*')
                        ->where('name','LIKE',"{$search}%")
                        ->count();
       }

        $data = array();
        if(!empty($users))
        {
            foreach ($users as $user)
            {
                $show = route('admin.users.show',$user->id);
                $edit = route('admin.users.edit',$user->id);
                $delete = route('admin.users.destroy',$user->id);

                $nestedData['id'] = $user->id;
                $nestedData['name'] = $user->name;
                $nestedData['email'] = $user->email;
                $nestedData['created_at'] = $user->created_at->toDateTimeString();

                $nestedData['actions'] = "<a href='{$show}' class='btn btn-xs btn-info'>View</a>
                <a href='{$edit}' class='btn btn-xs btn-info'>Edit</a>
                <input class='btn btn-xs btn-danger' type='button' onclick='delete_item({$user->id})' value='Delete'>";

                $nestedData['DT_RowId'] = $user->id;
                $data[] = $nestedData;
            }
        }

        return response()->json([
            'data' => $data,
            'draw' => intval($request->input('draw')),
            'recordsTotal' => intval($totalData),
            'recordsFiltered' => intval($totalFiltered),
        ], 201);
    }

    /**
     * Show the form for creating new User.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        $roles = Role::get()->pluck('name', 'name');
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created User in storage.
     *
     * @param  \App\Http\Requests\Admin\StoreUsersRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreUsersRequest $request)
    {
        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->save();

        $roles = $request->input('roles') ? $request->input('roles') : [];
        $user->assignRole($roles);

        return redirect()->route('admin.users.index');
    }

    /**
     * Show the form for editing User.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $roles = Role::get()->pluck('name', 'name');
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update User in storage.
     *
     * @param  \App\Http\Requests\Admin\UpdateUsersRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateUsersRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $user->name = $request->input('name');
        $user->save();
        $roles = $request->input('roles') ? $request->input('roles') : [];
        $user->assignRole($roles);

        return redirect()->route('admin.users.index');
    }

    /**
     * Shows User details.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $user = User::where('id', $id)->first();

        return view('admin.users.show', compact('user'));
    }

    /**
     * Remove User from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        ### Delete user ###
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.index');
    }

    /**
     * Delete all selected Users at once.
     *
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function massDestroy(Request $request)
    {
        if ($request->input('ids')) {
            $entries = User::whereIn('id', $request->input('ids'))->get();
            foreach ($entries as $entry) {
                ### Delete user ###
                $entry->delete();
            }
        }
    }

}
