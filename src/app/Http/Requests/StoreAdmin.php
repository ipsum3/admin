<?php

namespace Ipsum\Admin\app\Http\Requests;


use Ipsum\Admin\app\Models\Admin;

class StoreAdmin extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $current_params = \Route::current()->parameters();

        $roles =  array_keys(config('ipsum.admin.roles'));
        if (\Gate::denies('createSuperAdmin', Admin::class)) {
            if (($key = array_search(Admin::SUPERADMIN, $roles)) !== false) {
                unset($roles[$key]);
            }
        }

        return [
            'name' => ['required', 'string', 'max:255'],
            'firstname' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:admins,email,'.(isset($current_params['admin']) ? $current_params['admin']->id : '').',id'],
            'password' => [(isset($current_params['admin']) ? 'nullable' : 'required'), 'string', 'min:8'],
            'role' => ['required', 'in:'.implode(',', $roles)],
        ];
    }

}
