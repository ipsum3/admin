<?php

namespace Ipsum\Admin\app\Http\Controllers;

use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use Illuminate\Http\Request;
use Ipsum\Admin\app\Http\Requests\StoreAdmin;
use Ipsum\Admin\app\Models\Admin;
use Prologue\Alerts\Facades\Alert;
use OTPHP\TOTP;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

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

        $acces = config('ipsum.admin.acces');

        $admin = new Admin;
        return view('IpsumAdmin::admin.form', compact('admin', 'roles', 'acces'));
    }

    public function store(StoreAdmin $request)
    {
        $this->authorize('create', Admin::class);

        $requests = $request->validated();
        $requests['password'] = bcrypt($requests['password']);

        $admin = Admin::create($requests);
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

        $acces = config('ipsum.admin.acces');

        return view('IpsumAdmin::admin.form', compact('admin', 'roles', 'acces'));
    }

    public function update(StoreAdmin $request, Admin $admin)
    {
        $this->authorize('update', $admin);

        $requests = $request->validated();

        if (!$request->filled('password')) {
            unset($requests['password']);
        } else {
            $requests['password'] = bcrypt($requests['password']);
        }

        if (\Gate::denies('create', Admin::class)) {
            unset($requests['acces']);
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

    public function twoFactorAuthentification(Admin $admin)
    {
        $this->authorize('update', $admin);

        $otp = TOTP::generate();
        $otp->setLabel(config('app.name'));
        $otp->setIssuer($admin->name);
        $grCodeUri = $otp->getProvisioningUri();

        session()->flash('otp_secret', $otp->getSecret());

        // Génération du code QR
        $renderer = new ImageRenderer(
            new RendererStyle(400),
            new SvgImageBackEnd()
        );
        $writer = new Writer($renderer);
        $qr_code = $writer->writeString($grCodeUri);

        return view('IpsumAdmin::admin.2fa', compact('admin', 'qr_code'));
    }

    public function twoFactorAuthentificationValidate(Request $request, Admin $admin)
    {
        $this->authorize('update', $admin);

        $otp_secret = session()->get('otp_secret');
        //session()->forget('otp_secret');

        $otp = TOTP::createFromSecret($otp_secret);
        if ($otp->verify($request->secret)) {

            $admin->secret_totp = $otp_secret;
            $admin->save();
            Alert::success("L'authentification a été mis en place")->flash();
            return redirect()->route('adminUser.edit', $admin);
        }

        Alert::warning("L'authentification a échoué")->flash();
        return back();
    }

    public function twoFactorAuthentificationDelete(Request $request, Admin $admin)
    {
        $this->authorize('update', $admin);

        $admin->secret_totp = null;
        $admin->save();

        Alert::success("La double authentification a été désactivée avec succès.")->flash();
        return redirect()->route('adminUser.edit', $admin);
    }
}
