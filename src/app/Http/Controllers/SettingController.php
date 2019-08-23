<?php

namespace Ipsum\Admin\app\Http\Controllers;

use Ipsum\Core\app\Models\Setting;
use Prologue\Alerts\Facades\Alert;
use Illuminate\Http\Request;

class SettingController extends AdminController
{

    public function edit()
    {
        if (\Gate::denies('show-settings')) {
            abort('403');
        }

        $setting = Setting::where('rules', '!=', null)->get();
        $rules = [];
        foreach ($setting->pluck('rules', 'id')->toArray() as $key => $value) {
            $rules['form_'.$key] = $value;
        }

        $groups = Setting::all()->groupBy('group');

        return view('IpsumAdmin::setting.form', compact('groups', 'rules'));
    }

    public function update(Request $request)
    {
        if (\Gate::denies('show-settings')) {
            abort('403');
        }

        /*foreach ($request->all() as $key => $value) {
            $key[strpos($key, '_')] = '->';
            $requests[$key] = $value;
        }*/

        $setting = Setting::where('rules', '!=', null)->get();
        foreach ($setting->pluck('rules', 'id')->toArray() as $key => $value) {
            $rules['form_'.$key] = $value;
        }

        $validator = \Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            Alert::warning(__("Erreur lors de l'enregistrement des données"))->flash();
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        foreach ($request->all() as $key => $value) {

            $key = str_replace('form_', '', $key);

            $setting = Setting::where('id', $key)->first();
            if ($setting) {
                $setting->value = $value;
                $setting->save();
            }
        }

        Alert::success("Les paramètres ont bien été modifiés")->flash();
        return back();
    }

}
