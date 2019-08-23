<?php

namespace Ipsum\Admin\app\Http\Controllers;

use Ipsum\Admin\app\Http\Requests\StoreAdmin;
use Ipsum\Admin\app\Models\Admin;
use Prologue\Alerts\Facades\Alert;

class UserController extends AdminController
{

    public function index()
    {
        $this->authorize('viewAny', Admin::class);

        $admins = Admin::latest()->paginate(10);

        return view('IpsumAdmin::admin.index', compact('admins'));
    }

    public function create()
    {
        $this->authorize('create', Admin::class);

        $roles = config('ipsum.admin.roles');
        if (\Gate::denies('createSuperAdmin', Admin::class)) {
            unset($roles[Admin::SUPERADMIN]);
        }

        $admin = new Admin;
        return view('IpsumAdmin::admin.form', compact('admin', 'roles'));
    }

    public function store(StoreAdmin $request)
    {
        $this->authorize('create', Admin::class);

        $admin = Admin::create($request->all());
        Alert::success("L'enregistrement a bien été ajouté")->flash();
        return redirect()->route('adminUser.edit', $admin->id);
    }

    public function show(Admin $admin)
    {
        //
    }

    public function edit(Admin $admin)
    {
        $this->authorize('update', $admin);

        $roles = config('ipsum.admin.roles');
        if (\Gate::denies('createSuperAdmin', Admin::class)) {
            unset($roles[Admin::SUPERADMIN]);
        }

        return view('IpsumAdmin::admin.form', compact('admin', 'roles'));
    }

    public function update(StoreAdmin $request, Admin $admin)
    {
        $this->authorize('update', $admin);

        $requests = $request->all();

        if (!$request->has('password')) {
            unset($requests['password']);
        } else {
            $requests['password'] = bcrypt($requests['password']);
        }

        $admin->fill($requests);
        $admin->save();

        Alert::success("L'enregistrement a bien été modifié")->flash();
        return back();
    }

    public function destroy(Admin $admin)
    {
        $this->authorize('delete', $admin);

        $admin->delete();

        Alert::warning("L'enregistrement a bien été supprimé")->flash();
        return back();

    }
}
